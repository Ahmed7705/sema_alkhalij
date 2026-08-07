<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Company;
use App\Models\Contract;
use App\Models\ContractRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase5CorporateCRMTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $customer;
    protected $companyA;
    protected $companyB;
    protected $companyUserA;
    protected $companyUserB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->customer = User::factory()->create([
            'role' => 'customer',
            'is_active' => true,
        ]);

        $this->companyA = Company::create([
            'name' => 'Aramco Health',
            'company_code' => 'COMP-ARAMCO',
            'cr_number' => '1010999888',
            'contact_person' => 'Aramco Admin',
            'phone' => '0500000001',
            'email' => 'contact@aramco.com',
            'city' => 'Dhahran',
            'status' => 'active',
        ]);

        $this->companyB = Company::create([
            'name' => 'Sabic Medical',
            'company_code' => 'COMP-SABIC',
            'cr_number' => '2020888777',
            'contact_person' => 'Sabic Admin',
            'phone' => '0500000002',
            'email' => 'contact@sabic.com',
            'city' => 'Riyadh',
            'status' => 'active',
        ]);

        $this->companyUserA = User::factory()->create([
            'role' => 'company_admin',
            'company_id' => $this->companyA->id,
            'is_active' => true,
        ]);

        $this->companyUserB = User::factory()->create([
            'role' => 'company_admin',
            'company_id' => $this->companyB->id,
            'is_active' => true,
        ]);
    }

    /** @test */
    public function admin_can_view_companies()
    {
        $response = $this->actingAs($this->admin)->get('/admin/companies');

        $response->assertStatus(200);
        $response->assertSee('Aramco Health');
        $response->assertSee('Sabic Medical');
    }

    /** @test */
    public function admin_can_create_company()
    {
        $response = $this->actingAs($this->admin)->post('/admin/companies', [
            'name' => 'STC Health Solutions',
            'cr_number' => '3030777666',
            'contact_person' => 'Khalid STC',
            'phone' => '0555555555',
            'email' => 'corporate@stc.com',
            'city' => 'Riyadh',
            'status' => 'active',
        ]);

        $company = Company::where('cr_number', '3030777666')->first();
        $this->assertNotNull($company);
        $response->assertRedirect("/admin/companies/{$company->id}");
        $this->assertDatabaseHas('companies', ['name' => 'STC Health Solutions']);
    }

    /** @test */
    public function admin_can_update_company()
    {
        $response = $this->actingAs($this->admin)->put("/admin/companies/{$this->companyA->id}", [
            'name' => 'Aramco Medical Services Updated',
            'cr_number' => '1010999888',
            'contact_person' => 'Aramco Admin Updated',
            'phone' => '0500000099',
            'email' => 'contact@aramco.com',
            'city' => 'Dhahran',
            'status' => 'active',
        ]);

        $response->assertRedirect("/admin/companies/{$this->companyA->id}");
        $this->assertDatabaseHas('companies', ['id' => $this->companyA->id, 'name' => 'Aramco Medical Services Updated']);
    }

    /** @test */
    public function duplicate_cr_number_is_rejected()
    {
        $response = $this->actingAs($this->admin)->post('/admin/companies', [
            'name' => 'Duplicate CR Company',
            'cr_number' => '1010999888', // Same CR as companyA
            'contact_person' => 'Test',
            'phone' => '0500000000',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors(['cr_number']);
    }

    /** @test */
    public function admin_can_activate_deactivate_company()
    {
        $response = $this->actingAs($this->admin)->post("/admin/companies/{$this->companyA->id}/toggle");

        $response->assertRedirect();
        $this->assertDatabaseHas('companies', ['id' => $this->companyA->id, 'status' => 'inactive']);
    }

    /** @test */
    public function company_details_show_real_relationships()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-2026-999',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/companies/{$this->companyA->id}");

        $response->assertStatus(200);
        $response->assertSee('CNT-2026-999');
    }

    /** @test */
    public function admin_can_manage_company_users()
    {
        // 1. Add user
        $addResponse = $this->actingAs($this->admin)->post("/admin/companies/{$this->companyA->id}/users", [
            'name' => 'Aramco Staff User',
            'email' => 'staff@aramco.com',
            'phone' => '0511111111',
            'password' => 'secret123',
            'role' => 'company_operator',
            'is_active' => 1,
        ]);

        $addResponse->assertRedirect();
        $newUser = User::where('email', 'staff@aramco.com')->first();
        $this->assertNotNull($newUser);
        $this->assertEquals($this->companyA->id, $newUser->company_id);

        // 2. Toggle Status
        $toggleResponse = $this->actingAs($this->admin)->post("/admin/companies/{$this->companyA->id}/users/{$newUser->id}/toggle");
        $toggleResponse->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $newUser->id, 'is_active' => false]);

        // 3. Detach User
        $detachResponse = $this->actingAs($this->admin)->post("/admin/companies/{$this->companyA->id}/users/{$newUser->id}/detach");
        $detachResponse->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $newUser->id, 'company_id' => null]);
    }

    /** @test */
    public function unauthorized_roles_cannot_access_corporate_admin()
    {
        $response = $this->actingAs($this->customer)->get('/admin/companies');

        $response->assertRedirect('/');
    }

    /** @test */
    public function contract_request_submitted_from_public_site_appears_in_admin()
    {
        // Public Submission
        $publicResponse = $this->post('/corporate-services', [
            'company_name' => 'Saudi Electricity Company',
            'cr_number' => '4040555444',
            'contact_person' => 'Fahad SEC',
            'phone' => '0544444444',
            'email' => 'sec@se.com.sa',
            'city' => 'Riyadh',
            'requested_services' => 'Home Care & Nursing',
            'expected_beneficiaries' => 150,
        ]);

        $publicResponse->assertRedirect();
        $this->assertDatabaseHas('contract_requests', ['company_name' => 'Saudi Electricity Company']);

        // Admin View
        $adminResponse = $this->actingAs($this->admin)->get('/admin/contract-requests');
        $adminResponse->assertStatus(200);
        $adminResponse->assertSee('Saudi Electricity Company');
    }

    /** @test */
    public function admin_can_view_request_details()
    {
        $request = ContractRequest::create([
            'company_name' => 'Almarai Medical',
            'contact_person' => 'Saleh Almarai',
            'phone' => '0533333333',
            'email' => 'hr@almarai.com',
            'expected_beneficiaries' => 50,
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)->get("/admin/contract-requests/{$request->id}");

        $response->assertStatus(200);
        $response->assertSee('Almarai Medical');
        $response->assertSee('Saleh Almarai');
    }

    /** @test */
    public function new_to_under_review_works()
    {
        $request = ContractRequest::create([
            'company_name' => 'Bupa Arabia',
            'contact_person' => 'Noura Bupa',
            'phone' => '0522222222',
            'email' => 'contact@bupa.com.sa',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/contract-requests/{$request->id}/status", [
            'status' => 'under_review',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contract_requests', [
            'id' => $request->id,
            'status' => 'under_review',
            'reviewed_by' => $this->admin->id,
        ]);
    }

    /** @test */
    public function under_review_to_approved_works()
    {
        $request = ContractRequest::create([
            'company_name' => 'Tawuniya Health',
            'contact_person' => 'Majed Tawuniya',
            'phone' => '0511112222',
            'email' => 'contact@tawuniya.com.sa',
            'status' => 'under_review',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/contract-requests/{$request->id}/status", [
            'status' => 'approved',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contract_requests', [
            'id' => $request->id,
            'status' => 'approved',
            'approved_by' => $this->admin->id,
        ]);
    }

    /** @test */
    public function under_review_to_rejected_works()
    {
        $request = ContractRequest::create([
            'company_name' => 'Unqualified Corp',
            'contact_person' => 'Bad Contact',
            'phone' => '0500009999',
            'email' => 'bad@unqualified.com',
            'status' => 'under_review',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/contract-requests/{$request->id}/status", [
            'status' => 'rejected',
            'rejection_reason' => 'Company CR does not match Ministry database',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contract_requests', [
            'id' => $request->id,
            'status' => 'rejected',
            'rejection_reason' => 'Company CR does not match Ministry database',
        ]);
    }

    /** @test */
    public function invalid_workflow_transition_is_rejected()
    {
        // Rejected -> Approved directly without returning to under_review
        $request = ContractRequest::create([
            'company_name' => 'Rejected Corp',
            'contact_person' => 'Contact',
            'phone' => '0500008888',
            'email' => 'rej@corp.com',
            'status' => 'rejected',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/contract-requests/{$request->id}/status", [
            'status' => 'approved',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('contract_requests', [
            'id' => $request->id,
            'status' => 'rejected',
        ]);
    }

    /** @test */
    public function approved_request_can_be_converted_to_company()
    {
        $request = ContractRequest::create([
            'company_name' => 'Mobily Telecom Health',
            'cr_number' => '7070111222',
            'contact_person' => 'Sultan Mobily',
            'phone' => '0566666666',
            'email' => 'health@mobily.com.sa',
            'city' => 'Riyadh',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/contract-requests/{$request->id}/convert");

        $company = Company::where('cr_number', '7070111222')->first();
        $this->assertNotNull($company);

        $response->assertRedirect("/admin/companies/{$company->id}");
        $this->assertDatabaseHas('companies', ['name' => 'Mobily Telecom Health', 'contract_request_id' => $request->id]);
        $this->assertDatabaseHas('contract_requests', ['id' => $request->id, 'converted_company_id' => $company->id]);
    }

    /** @test */
    public function same_request_cannot_be_converted_twice()
    {
        $request = ContractRequest::create([
            'company_name' => 'Converted Twice Corp',
            'cr_number' => '8080222333',
            'contact_person' => 'Contact',
            'phone' => '0577777777',
            'email' => 'twice@corp.com',
            'status' => 'approved',
            'converted_company_id' => $this->companyA->id,
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/contract-requests/{$request->id}/convert");

        $response->assertRedirect("/admin/companies/{$this->companyA->id}");
    }

    /** @test */
    public function duplicate_company_is_prevented()
    {
        // Try converting request with CR number that already exists as companyA
        $request = ContractRequest::create([
            'company_name' => 'Aramco Health Alias',
            'cr_number' => $this->companyA->cr_number, // 1010999888
            'contact_person' => 'Contact',
            'phone' => '0588888888',
            'email' => 'alias@aramco.com',
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/contract-requests/{$request->id}/convert");

        // Links to existing company instead of creating a duplicate
        $response->assertRedirect("/admin/companies/{$this->companyA->id}");
        $this->assertDatabaseHas('contract_requests', ['id' => $request->id, 'converted_company_id' => $this->companyA->id]);
    }

    /** @test */
    public function failed_conversion_rolls_back_transaction()
    {
        // Unapproved request conversion attempt
        $request = ContractRequest::create([
            'company_name' => 'Unapproved Corp',
            'contact_person' => 'Contact',
            'phone' => '0599999999',
            'email' => 'unapp@corp.com',
            'status' => 'new',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/contract-requests/{$request->id}/convert");

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('companies', ['name' => 'Unapproved Corp']);
    }

    /** @test */
    public function company_a_cannot_access_company_b_data()
    {
        // Company User A attempts to view Company B portal data via query param IDOR
        $response = $this->actingAs($this->companyUserA)->get("/company/portal?company_id={$this->companyB->id}");

        $response->assertStatus(403);
    }

    /** @test */
    public function audit_logs_are_created_for_sensitive_actions()
    {
        // Create company
        $this->actingAs($this->admin)->post('/admin/companies', [
            'name' => 'Audit Test Company',
            'cr_number' => '9999111222',
            'contact_person' => 'Audit Person',
            'phone' => '0500001111',
            'status' => 'active',
        ]);

        $company = Company::where('cr_number', '9999111222')->first();

        // Verify audit log created
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'CREATE_COMPANY',
            'model_id' => $company->id,
        ]);
    }

    /** @test */
    public function inactive_company_user_cannot_use_restricted_company_functionality()
    {
        $this->companyUserA->update(['is_active' => false]);

        $response = $this->actingAs($this->companyUserA)->get('/company/portal');

        $response->assertStatus(403);
    }

    /** @test */
    public function arabic_phase5_ui_works_correctly_in_rtl()
    {
        app()->setLocale('ar');

        $response = $this->actingAs($this->admin)->get('/admin/companies');

        $response->assertStatus(200);
        $response->assertSee('dir-rtl', false);
    }

    /** @test */
    public function english_phase5_ui_works_correctly_in_ltr()
    {
        app()->setLocale('en');

        $response = $this->actingAs($this->admin)->get('/admin/companies');

        $response->assertStatus(200);
        $response->assertSee('dir-ltr', false);
    }

    /** @test */
    public function authorization_is_enforced_server_side()
    {
        // Non-admin customer trying to access /admin/companies
        $response = $this->actingAs($this->customer)->get('/admin/companies');

        $response->assertRedirect('/');
    }
}
