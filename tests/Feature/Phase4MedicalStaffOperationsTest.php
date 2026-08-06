<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Service;
use App\Models\StaffProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase4MedicalStaffOperationsTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $doctor;
    protected $nurse;
    protected $customer;
    protected $companyUser;
    protected $service;
    protected $booking;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->doctor = User::factory()->create([
            'role' => 'doctor',
            'is_active' => true,
        ]);
        StaffProfile::create([
            'user_id' => $this->doctor->id,
            'staff_type' => 'doctor',
            'specialty' => 'Cardiology',
            'license_number' => 'DOC-12345',
            'is_active' => true,
        ]);

        $this->nurse = User::factory()->create([
            'role' => 'nurse',
            'is_active' => true,
        ]);
        StaffProfile::create([
            'user_id' => $this->nurse->id,
            'staff_type' => 'nurse',
            'specialty' => 'Critical Care',
            'license_number' => 'NUR-67890',
            'is_active' => true,
        ]);

        $this->customer = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        $this->companyUser = User::factory()->create([
            'role' => 'company_admin',
            'is_active' => true,
        ]);

        $this->service = Service::create([
            'title' => 'Home Nursing Care',
            'slug' => 'home-nursing-care',
            'price' => 250.00,
            'duration_minutes' => 60,
            'is_active' => true,
        ]);

        $this->booking = Booking::create([
            'user_id' => $this->customer->id,
            'patient_name' => 'John Patient',
            'booking_number' => 'BK-2026-10001',
            'service_id' => $this->service->id,
            'booking_date' => '2026-08-10',
            'booking_time' => '10:00 AM',
            'city' => 'Riyadh',
            'address' => 'King Fahd Road',
            'phone' => '0500000000',
            'total_price' => 250.00,
            'status' => 'requested',
        ]);
    }

    /** @test */
    public function admin_can_view_staff_management()
    {
        $response = $this->actingAs($this->admin)->get('/admin/staff');

        $response->assertStatus(200);
        $response->assertSee($this->doctor->name);
        $response->assertSee($this->nurse->name);
    }

    /** @test */
    public function admin_can_create_and_update_staff_profile()
    {
        // 1. Create Staff
        $createResponse = $this->actingAs($this->admin)->post('/admin/staff', [
            'name' => 'Dr. Sara Al-Otaibi',
            'email' => 'sara@sema-alkhalij.com',
            'phone' => '0555555555',
            'password' => 'secret123',
            'role' => 'doctor',
            'staff_type' => 'doctor',
            'specialty' => 'Pediatrics',
            'license_number' => 'DOC-99999',
            'job_title' => 'Senior Consultant',
            'is_active' => 1,
        ]);

        $createResponse->assertRedirect('/admin/staff');
        $this->assertDatabaseHas('users', ['email' => 'sara@sema-alkhalij.com', 'role' => 'doctor']);
        $newStaff = User::where('email', 'sara@sema-alkhalij.com')->first();
        $this->assertDatabaseHas('staff_profiles', ['user_id' => $newStaff->id, 'license_number' => 'DOC-99999']);

        // 2. Update Staff
        $updateResponse = $this->actingAs($this->admin)->put("/admin/staff/{$newStaff->id}", [
            'name' => 'Dr. Sara Al-Otaibi Updated',
            'email' => 'sara@sema-alkhalij.com',
            'phone' => '0555555555',
            'role' => 'doctor',
            'staff_type' => 'doctor',
            'specialty' => 'Pediatric Cardiology',
            'license_number' => 'DOC-99999-UPDATED',
            'job_title' => 'Consultant',
            'is_active' => 1,
        ]);

        $updateResponse->assertRedirect('/admin/staff');
        $this->assertDatabaseHas('users', ['id' => $newStaff->id, 'name' => 'Dr. Sara Al-Otaibi Updated']);
        $this->assertDatabaseHas('staff_profiles', ['user_id' => $newStaff->id, 'specialty' => 'Pediatric Cardiology']);
    }

    /** @test */
    public function admin_can_toggle_staff_active_status_without_deleting_user()
    {
        $response = $this->actingAs($this->admin)->post("/admin/staff/{$this->doctor->id}/toggle");

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $this->doctor->id, 'is_active' => false]);
        $this->assertDatabaseHas('staff_profiles', ['user_id' => $this->doctor->id, 'is_active' => false]);
    }

    /** @test */
    public function inactive_staff_cannot_be_assigned_visit()
    {
        // Deactivate Doctor
        $this->doctor->update(['is_active' => false]);
        $this->doctor->staffProfile->update(['is_active' => false]);

        $response = $this->actingAs($this->admin)->post("/admin/bookings/{$this->booking->id}/assign", [
            'assigned_provider_id' => $this->doctor->id,
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('bookings', [
            'id' => $this->booking->id,
            'assigned_provider_id' => null,
            'status' => 'requested',
        ]);
    }

    /** @test */
    public function admin_can_assign_visit_to_qualified_active_staff()
    {
        $response = $this->actingAs($this->admin)->post("/admin/bookings/{$this->booking->id}/assign", [
            'assigned_provider_id' => $this->doctor->id,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('bookings', [
            'id' => $this->booking->id,
            'assigned_provider_id' => $this->doctor->id,
            'status' => 'assigned',
        ]);
    }

    /** @test */
    public function reassignment_works_and_is_logged_in_audit_logs()
    {
        // 1. Initial Assignment to Doctor
        $this->actingAs($this->admin)->post("/admin/bookings/{$this->booking->id}/assign", [
            'assigned_provider_id' => $this->doctor->id,
        ]);

        // 2. Reassignment to Nurse
        $response = $this->actingAs($this->admin)->post("/admin/bookings/{$this->booking->id}/assign", [
            'assigned_provider_id' => $this->nurse->id,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('bookings', [
            'id' => $this->booking->id,
            'assigned_provider_id' => $this->nurse->id,
        ]);

        // Verify Audit Log entry for reassignment
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'REASSIGN_VISIT',
            'model_id' => $this->booking->id,
        ]);
    }

    /** @test */
    public function doctor_sees_only_own_assigned_visits()
    {
        // Assign booking to Doctor
        $this->booking->update([
            'assigned_provider_id' => $this->doctor->id,
            'status' => 'assigned',
        ]);

        // Create another booking assigned to Nurse
        $nurseBooking = Booking::create([
            'user_id' => $this->customer->id,
            'booking_number' => 'BK-2026-10002',
            'service_id' => $this->service->id,
            'assigned_provider_id' => $this->nurse->id,
            'booking_date' => '2026-08-11',
            'booking_time' => '11:00 AM',
            'city' => 'Riyadh',
            'address' => 'Olaya',
            'phone' => '0500000000',
            'total_price' => 250.00,
            'status' => 'assigned',
        ]);

        $response = $this->actingAs($this->doctor)->get('/staff/dashboard');

        $response->assertStatus(200);
        $response->assertSee($this->booking->booking_number);
        $response->assertDontSee($nurseBooking->booking_number);
    }

    /** @test */
    public function nurse_sees_only_own_assigned_visits()
    {
        $this->booking->update([
            'assigned_provider_id' => $this->nurse->id,
            'status' => 'assigned',
        ]);

        $response = $this->actingAs($this->nurse)->get('/staff/dashboard');

        $response->assertStatus(200);
        $response->assertSee($this->booking->booking_number);
    }

    /** @test */
    public function staff_cannot_access_or_modify_another_staff_members_visit()
    {
        // Assign booking to Doctor
        $this->booking->update([
            'assigned_provider_id' => $this->doctor->id,
            'status' => 'assigned',
        ]);

        // Nurse attempts to accept Doctor's visit
        $response = $this->actingAs($this->nurse)->post("/staff/visits/{$this->booking->id}/status", [
            'status' => 'accepted',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('bookings', [
            'id' => $this->booking->id,
            'status' => 'assigned',
        ]);
    }

    /** @test */
    public function customer_cannot_access_staff_portal()
    {
        $response = $this->actingAs($this->customer)->get('/staff/dashboard');

        $response->assertStatus(403);
    }

    /** @test */
    public function company_user_cannot_access_staff_portal_without_permission()
    {
        $response = $this->actingAs($this->companyUser)->get('/staff/dashboard');

        $response->assertStatus(403);
    }

    /** @test */
    public function staff_can_accept_assigned_visit()
    {
        $this->booking->update([
            'assigned_provider_id' => $this->doctor->id,
            'status' => 'assigned',
        ]);

        $response = $this->actingAs($this->doctor)->post("/staff/visits/{$this->booking->id}/status", [
            'status' => 'accepted',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'id' => $this->booking->id,
            'status' => 'accepted',
        ]);
    }

    /** @test */
    public function staff_can_start_accepted_visit()
    {
        $this->booking->update([
            'assigned_provider_id' => $this->doctor->id,
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($this->doctor)->post("/staff/visits/{$this->booking->id}/status", [
            'status' => 'in_progress',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'id' => $this->booking->id,
            'status' => 'in_progress',
        ]);
    }

    /** @test */
    public function staff_can_complete_in_progress_visit()
    {
        $this->booking->update([
            'assigned_provider_id' => $this->doctor->id,
            'status' => 'in_progress',
        ]);

        $response = $this->actingAs($this->doctor)->post("/staff/visits/{$this->booking->id}/status", [
            'status' => 'completed',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'id' => $this->booking->id,
            'status' => 'completed',
        ]);
    }

    /** @test */
    public function invalid_workflow_transition_is_rejected()
    {
        // Attempt jumping directly from assigned -> completed
        $this->booking->update([
            'assigned_provider_id' => $this->doctor->id,
            'status' => 'assigned',
        ]);

        $response = $this->actingAs($this->doctor)->post("/staff/visits/{$this->booking->id}/status", [
            'status' => 'completed',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('bookings', [
            'id' => $this->booking->id,
            'status' => 'assigned',
        ]);
    }

    /** @test */
    public function authorized_supervisor_or_admin_can_verify_completed_visit()
    {
        $this->booking->update([
            'assigned_provider_id' => $this->doctor->id,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/bookings/{$this->booking->id}/verify");

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('bookings', [
            'id' => $this->booking->id,
            'status' => 'verified',
            'verified_by' => $this->admin->id,
        ]);
    }

    /** @test */
    public function unauthorized_staff_cannot_verify_completed_visit()
    {
        $this->booking->update([
            'assigned_provider_id' => $this->doctor->id,
            'status' => 'completed',
        ]);

        // Doctor (practitioner) attempts to verify visit directly - intercepted by admin middleware
        $response = $this->actingAs($this->doctor)->post("/admin/bookings/{$this->booking->id}/verify");

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'id' => $this->booking->id,
            'status' => 'completed',
        ]);
    }

    /** @test */
    public function all_sensitive_transitions_are_logged_in_audit_logs()
    {
        // 1. Assign
        $this->actingAs($this->admin)->post("/admin/bookings/{$this->booking->id}/assign", [
            'assigned_provider_id' => $this->doctor->id,
        ]);

        // 2. Accept
        $this->actingAs($this->doctor)->post("/staff/visits/{$this->booking->id}/status", [
            'status' => 'accepted',
        ]);

        // 3. Start
        $this->actingAs($this->doctor)->post("/staff/visits/{$this->booking->id}/status", [
            'status' => 'in_progress',
        ]);

        // 4. Complete
        $this->actingAs($this->doctor)->post("/staff/visits/{$this->booking->id}/status", [
            'status' => 'completed',
        ]);

        // 5. Verify
        $this->actingAs($this->admin)->post("/admin/bookings/{$this->booking->id}/verify");

        // Verify Audit Logs count for this booking
        $logsCount = AuditLog::where(function ($q) {
            $q->where('model_id', $this->booking->id)
              ->orWhere('auditable_id', $this->booking->id);
        })->count();

        $this->assertGreaterThanOrEqual(4, $logsCount);
    }
}
