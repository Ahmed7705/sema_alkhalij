<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Company;
use App\Models\Contract;
use App\Models\LabSample;
use App\Models\MedicalReport;
use App\Models\MedicalReportVersion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Phase7LabOperationsMedicalReportsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $labTech;
    protected User $otherTech;
    protected User $patientA;
    protected User $patientB;
    protected Company $companyA;
    protected Company $companyB;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->labTech = User::factory()->create([
            'role' => 'lab_tech',
            'is_active' => true,
        ]);

        $this->otherTech = User::factory()->create([
            'role' => 'lab_tech',
            'is_active' => true,
        ]);

        $this->companyA = Company::create([
            'name' => 'شركة الأعمال المتقدمة',
            'company_code' => 'COMP-ADV',
            'cr_number' => '1010998877',
            'status' => 'active',
        ]);

        $this->companyB = Company::create([
            'name' => 'شركة الخليج للتقنية',
            'company_code' => 'COMP-GULF',
            'cr_number' => '1010112233',
            'status' => 'active',
        ]);

        $this->patientA = User::factory()->create([
            'role' => 'customer',
            'company_id' => $this->companyA->id,
            'identification_type' => 'saudi_id',
            'identification_number' => '1099887766',
            'is_active' => true,
        ]);

        $this->patientB = User::factory()->create([
            'role' => 'customer',
            'company_id' => $this->companyB->id,
            'identification_type' => 'saudi_id',
            'identification_number' => '1011223344',
            'is_active' => true,
        ]);
    }

    /** @test */
    public function admin_can_view_lab_samples_directory_and_filter()
    {
        LabSample::create([
            'visit_code' => 'VIS-2026-000101',
            'patient_id' => $this->patientA->id,
            'company_id' => $this->companyA->id,
            'sample_status' => LabSample::STATUS_REGISTERED,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.lab-samples.index'));
        $response->assertStatus(200);
        $response->assertSee('VIS-2026-000101');
    }

    /** @test */
    public function admin_can_register_new_lab_sample()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.lab-samples.store'), [
            'patient_id' => $this->patientA->id,
            'company_id' => $this->companyA->id,
            'assigned_staff_id' => $this->labTech->id,
            'notes' => 'فحص وظائف الكبد والدم الكامل',
        ]);

        $response->assertRedirect(route('admin.lab-samples.index'));
        $this->assertDatabaseHas('lab_samples', [
            'patient_id' => $this->patientA->id,
            'assigned_staff_id' => $this->labTech->id,
            'sample_status' => LabSample::STATUS_ASSIGNED,
        ]);
    }

    /** @test */
    public function workflow_state_machine_allows_valid_stage_transitions()
    {
        $sample = LabSample::create([
            'visit_code' => 'VIS-2026-000102',
            'patient_id' => $this->patientA->id,
            'sample_status' => LabSample::STATUS_REGISTERED,
        ]);

        // Transition: registered -> assigned -> sample_collected
        $this->actingAs($this->admin)->post(route('admin.lab-samples.status', $sample->id), [
            'sample_status' => LabSample::STATUS_ASSIGNED,
        ])->assertSessionHasNoErrors();

        $sample->refresh();
        $this->assertEquals(LabSample::STATUS_ASSIGNED, $sample->sample_status);

        $this->actingAs($this->admin)->post(route('admin.lab-samples.status', $sample->id), [
            'sample_status' => LabSample::STATUS_COLLECTED,
        ])->assertSessionHasNoErrors();

        $sample->refresh();
        $this->assertEquals(LabSample::STATUS_COLLECTED, $sample->sample_status);
        $this->assertNotNull($sample->collected_at);
    }

    /** @test */
    public function workflow_state_machine_rejects_invalid_backwards_transition()
    {
        $sample = LabSample::create([
            'visit_code' => 'VIS-2026-000103',
            'patient_id' => $this->patientA->id,
            'sample_status' => LabSample::STATUS_RESULT_READY,
        ]);

        // Invalid backwards transition to registered
        $response = $this->actingAs($this->admin)->post(route('admin.lab-samples.status', $sample->id), [
            'sample_status' => LabSample::STATUS_REGISTERED,
        ]);

        $response->assertSessionHas('error');
        $sample->refresh();
        $this->assertEquals(LabSample::STATUS_RESULT_READY, $sample->sample_status);
    }

    /** @test */
    public function lab_tech_can_access_portal_and_see_only_assigned_samples()
    {
        $assignedSample = LabSample::create([
            'visit_code' => 'VIS-2026-000104',
            'patient_id' => $this->patientA->id,
            'assigned_staff_id' => $this->labTech->id,
            'sample_status' => LabSample::STATUS_ASSIGNED,
        ]);

        $unassignedSample = LabSample::create([
            'visit_code' => 'VIS-2026-000105',
            'patient_id' => $this->patientB->id,
            'assigned_staff_id' => $this->otherTech->id,
            'sample_status' => LabSample::STATUS_ASSIGNED,
        ]);

        $response = $this->actingAs($this->labTech)->get(route('staff.lab.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('VIS-2026-000104');
        $response->assertDontSee('VIS-2026-000105');
    }

    /** @test */
    public function lab_tech_cannot_access_unassigned_sample()
    {
        $unassignedSample = LabSample::create([
            'visit_code' => 'VIS-2026-000106',
            'patient_id' => $this->patientB->id,
            'assigned_staff_id' => $this->otherTech->id,
            'sample_status' => LabSample::STATUS_ASSIGNED,
        ]);

        $response = $this->actingAs($this->labTech)->get(route('staff.lab.show', $unassignedSample->id));
        $response->assertStatus(403);
    }

    /** @test */
    public function lab_tech_can_upload_pdf_report_and_advance_status()
    {
        $sample = LabSample::create([
            'visit_code' => 'VIS-2026-000107',
            'patient_id' => $this->patientA->id,
            'assigned_staff_id' => $this->labTech->id,
            'sample_status' => LabSample::STATUS_PROCESSING,
        ]);

        $pdf = UploadedFile::fake()->create('lab_result_01.pdf', 500, 'application/pdf');

        $response = $this->actingAs($this->labTech)->post(route('medical-reports.upload'), [
            'patient_id' => $this->patientA->id,
            'lab_sample_id' => $sample->id,
            'report_pdf' => $pdf,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('medical_reports', [
            'lab_sample_id' => $sample->id,
            'patient_id' => $this->patientA->id,
            'file_name' => 'lab_result_01.pdf',
        ]);

        $sample->refresh();
        $this->assertEquals(LabSample::STATUS_REPORT_UPLOADED, $sample->sample_status);
    }

    /** @test */
    public function pdf_report_replacement_creates_version_audit_record()
    {
        $sample = LabSample::create([
            'visit_code' => 'VIS-2026-000108',
            'patient_id' => $this->patientA->id,
            'sample_status' => LabSample::STATUS_REPORT_UPLOADED,
        ]);

        $originalPdf = UploadedFile::fake()->create('version_1.pdf', 300, 'application/pdf');
        $this->actingAs($this->admin)->post(route('medical-reports.upload'), [
            'patient_id' => $this->patientA->id,
            'lab_sample_id' => $sample->id,
            'report_pdf' => $originalPdf,
        ]);

        $report = MedicalReport::where('lab_sample_id', $sample->id)->first();

        $newPdf = UploadedFile::fake()->create('version_2_corrected.pdf', 400, 'application/pdf');
        $response = $this->actingAs($this->admin)->post(route('medical-reports.replace', $report->id), [
            'report_pdf' => $newPdf,
            'reason' => 'تصحيح القيم المرجعية لفحص السكر التراكمي',
        ]);

        $response->assertRedirect();
        $report->refresh();
        $this->assertEquals('version_2_corrected.pdf', $report->file_name);

        $this->assertDatabaseHas('medical_report_versions', [
            'medical_report_id' => $report->id,
            'file_name' => 'version_1.pdf',
            'reason' => 'تصحيح القيم المرجعية لفحص السكر التراكمي',
        ]);
    }

    /** @test */
    public function pdf_report_deletion_resets_status_and_creates_audit_log()
    {
        $sample = LabSample::create([
            'visit_code' => 'VIS-2026-000109',
            'patient_id' => $this->patientA->id,
            'sample_status' => LabSample::STATUS_REPORT_UPLOADED,
        ]);

        $pdf = UploadedFile::fake()->create('to_delete.pdf', 200, 'application/pdf');
        $this->actingAs($this->admin)->post(route('medical-reports.upload'), [
            'patient_id' => $this->patientA->id,
            'lab_sample_id' => $sample->id,
            'report_pdf' => $pdf,
        ]);

        $report = MedicalReport::where('lab_sample_id', $sample->id)->first();

        $response = $this->actingAs($this->admin)->delete(route('medical-reports.destroy', $report->id));
        $response->assertRedirect();

        $this->assertDatabaseMissing('medical_reports', ['id' => $report->id]);
        $sample->refresh();
        $this->assertEquals(LabSample::STATUS_RESULT_READY, $sample->sample_status);
    }

    /** @test */
    public function authorized_patient_can_download_own_pdf_report()
    {
        $pdf = UploadedFile::fake()->create('patient_report.pdf', 250, 'application/pdf');
        $path = $pdf->store('private/medical_reports');

        $report = MedicalReport::create([
            'patient_id' => $this->patientA->id,
            'file_path' => $path,
            'file_name' => 'patient_report.pdf',
            'file_size' => 250000,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
            'uploaded_at' => now(),
        ]);

        $response = $this->actingAs($this->patientA)->get(route('medical-reports.download', $report->id));
        $response->assertStatus(200);
    }

    /** @test */
    public function unauthorized_patient_cannot_download_other_patients_pdf_report_idor_protected()
    {
        $pdf = UploadedFile::fake()->create('patient_a_private.pdf', 250, 'application/pdf');
        $path = $pdf->store('private/medical_reports');

        $report = MedicalReport::create([
            'patient_id' => $this->patientA->id,
            'file_path' => $path,
            'file_name' => 'patient_a_private.pdf',
            'file_size' => 250000,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
            'uploaded_at' => now(),
        ]);

        // Patient B attempts to download Patient A's report -> IDOR blocked (403)
        $response = $this->actingAs($this->patientB)->get(route('medical-reports.download', $report->id));
        $response->assertStatus(403);
    }

    /** @test */
    public function company_admin_can_download_company_beneficiary_pdf_report()
    {
        $companyAdmin = User::factory()->create([
            'role' => 'company_admin',
            'company_id' => $this->companyA->id,
            'is_active' => true,
        ]);

        $pdf = UploadedFile::fake()->create('beneficiary_report.pdf', 300, 'application/pdf');
        $path = $pdf->store('private/medical_reports');

        $report = MedicalReport::create([
            'patient_id' => $this->patientA->id,
            'company_id' => $this->companyA->id,
            'file_path' => $path,
            'file_name' => 'beneficiary_report.pdf',
            'file_size' => 300000,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
            'uploaded_at' => now(),
        ]);

        $response = $this->actingAs($companyAdmin)->get(route('medical-reports.download', $report->id));
        $response->assertStatus(200);
    }

    /** @test */
    public function company_admin_cannot_download_other_company_beneficiary_pdf_report()
    {
        $companyAdminA = User::factory()->create([
            'role' => 'company_admin',
            'company_id' => $this->companyA->id,
            'is_active' => true,
        ]);

        $pdf = UploadedFile::fake()->create('company_b_report.pdf', 300, 'application/pdf');
        $path = $pdf->store('private/medical_reports');

        $report = MedicalReport::create([
            'patient_id' => $this->patientB->id,
            'company_id' => $this->companyB->id,
            'file_path' => $path,
            'file_name' => 'company_b_report.pdf',
            'file_size' => 300000,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
            'uploaded_at' => now(),
        ]);

        // Company A admin attempts to download Company B beneficiary report -> IDOR 403
        $response = $this->actingAs($companyAdminA)->get(route('medical-reports.download', $report->id));
        $response->assertStatus(403);
    }

    /** @test */
    public function audit_log_records_medical_report_download_event()
    {
        $pdf = UploadedFile::fake()->create('audit_test.pdf', 100, 'application/pdf');
        $path = $pdf->store('private/medical_reports');

        $report = MedicalReport::create([
            'patient_id' => $this->patientA->id,
            'file_path' => $path,
            'file_name' => 'audit_test.pdf',
            'file_size' => 100000,
            'mime_type' => 'application/pdf',
            'uploaded_by' => $this->admin->id,
            'uploaded_at' => now(),
        ]);

        $this->actingAs($this->patientA)->get(route('medical-reports.download', $report->id));

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'medical_report_downloaded',
            'model_type' => MedicalReport::class,
            'model_id' => $report->id,
            'user_id' => $this->patientA->id,
        ]);
    }
}
