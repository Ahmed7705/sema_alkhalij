<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Contract;
use App\Models\ContractPrice;
use App\Models\ContractBeneficiary;
use App\Models\Service;
use App\Models\Booking;
use App\Models\AuditLog;

class Phase6ContractsPricingBeneficiariesTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $companyA;
    protected $companyB;
    protected $companyUserA;
    protected $companyUserB;
    protected $service1;
    protected $service2;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Setup Admin User
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        // 2. Setup Corporate Companies
        $this->companyA = Company::create([
            'name' => 'Saudi Aramco Health Entity',
            'company_code' => 'COMP-ARAMCO-TEST',
            'cr_number' => '1010111222',
            'contact_person' => 'Aramco Admin',
            'phone' => '0501111111',
            'email' => 'aramco@test.com',
            'city' => 'Dhahran',
            'status' => 'active',
        ]);

        $this->companyB = Company::create([
            'name' => 'SABIC Industrial Health',
            'company_code' => 'COMP-SABIC-TEST',
            'cr_number' => '1010333444',
            'contact_person' => 'SABIC Admin',
            'phone' => '0502222222',
            'email' => 'sabic@test.com',
            'city' => 'Riyadh',
            'status' => 'active',
        ]);

        // 3. Setup Corporate Users
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

        // 4. Setup Services
        $this->service1 = Service::create([
            'title' => 'Home Doctor Visit',
            'name' => 'Home Doctor Visit',
            'slug' => 'home-doctor-visit',
            'price' => 350.00,
            'is_active' => true,
        ]);

        $this->service2 = Service::create([
            'title' => 'Nursing Home Care',
            'name' => 'Nursing Home Care',
            'slug' => 'nursing-home-care',
            'price' => 200.00,
            'is_active' => true,
        ]);
    }

    /** @test */
    public function admin_can_view_contracts()
    {
        Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-2026-TEST1',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30 Days',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/contracts');
        $response->assertStatus(200);
        $response->assertSee('CNT-2026-TEST1');
        $response->assertSee('Saudi Aramco Health Entity');
    }

    /** @test */
    public function admin_can_create_contract()
    {
        $response = $this->actingAs($this->admin)->post('/admin/contracts', [
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-2026-NEW01',
            'start_date' => '2026-02-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 60 Days',
            'status' => 'active',
            'discount_percentage' => 10.00,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contracts', [
            'contract_number' => 'CNT-2026-NEW01',
            'company_id' => $this->companyA->id,
        ]);
    }

    /** @test */
    public function admin_can_edit_contract()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-2026-EDIT',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Immediate',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/contracts/{$contract->id}", [
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-2026-EDITED',
            'start_date' => '2026-01-01',
            'end_date' => '2027-12-31',
            'payment_terms' => 'Monthly Invoice',
            'status' => 'active',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contracts', ['contract_number' => 'CNT-2026-EDITED']);
    }

    /** @test */
    public function duplicate_contract_number_rejected()
    {
        Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-DUP-001',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->post('/admin/contracts', [
            'company_id' => $this->companyB->id,
            'contract_number' => 'CNT-DUP-001',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors('contract_number');
    }

    /** @test */
    public function invalid_date_range_rejected()
    {
        $response = $this->actingAs($this->admin)->post('/admin/contracts', [
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-BAD-DATES',
            'start_date' => '2026-12-31',
            'end_date' => '2026-01-01',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors('end_date');
    }

    /** @test */
    public function unauthorized_user_blocked_from_contract_admin()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->get('/admin/contracts');
        $response->assertRedirect();
    }

    /** @test */
    public function add_covered_service_to_contract()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-PRICE-01',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/contracts/{$contract->id}/services", [
            'service_id' => $this->service1->id,
            'custom_price' => 250.00,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contract_prices', [
            'contract_id' => $contract->id,
            'service_id' => $this->service1->id,
            'custom_price' => 250.00,
        ]);
    }

    /** @test */
    public function remove_covered_service_from_contract()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-PRICE-RM',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        ContractPrice::create([
            'contract_id' => $contract->id,
            'service_id' => $this->service1->id,
            'custom_price' => 280.00,
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/contracts/{$contract->id}/services/{$this->service1->id}/remove");

        $response->assertRedirect();
        $this->assertDatabaseMissing('contract_prices', [
            'contract_id' => $contract->id,
            'service_id' => $this->service1->id,
        ]);
    }

    /** @test */
    public function duplicate_contract_service_rejected()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-PRICE-DUP',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        ContractPrice::create([
            'contract_id' => $contract->id,
            'service_id' => $this->service1->id,
            'custom_price' => 280.00,
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/contracts/{$contract->id}/services", [
            'service_id' => $this->service1->id,
            'custom_price' => 260.00,
        ]);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function set_and_update_contract_price()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-PRICE-UPD',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $priceRecord = ContractPrice::create([
            'contract_id' => $contract->id,
            'service_id' => $this->service1->id,
            'custom_price' => 280.00,
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/contracts/{$contract->id}/prices/{$priceRecord->id}", [
            'custom_price' => 220.00,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contract_prices', [
            'id' => $priceRecord->id,
            'custom_price' => 220.00,
        ]);
    }

    /** @test */
    public function invalid_negative_price_rejected()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-PRICE-NEG',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/contracts/{$contract->id}/services", [
            'service_id' => $this->service1->id,
            'custom_price' => -50.00,
        ]);

        $response->assertSessionHasErrors('custom_price');
    }

    /** @test */
    public function server_ignores_manipulated_client_price()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-PRICE-SERVER',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        ContractPrice::create([
            'contract_id' => $contract->id,
            'service_id' => $this->service1->id,
            'custom_price' => 210.00, // Valid custom contract price
        ]);

        // Attempting to send custom manipulated price = 1.00 SAR in request payload
        $response = $this->actingAs($this->companyUserA)->post('/company/requests', [
            'company_id' => $this->companyA->id,
            'contract_id' => $contract->id,
            'patient_name' => 'Fahad Beneficiary',
            'identification_type' => 'saudi_id',
            'identification_number' => '1099887766',
            'phone' => '0555444333',
            'service_id' => $this->service1->id,
            'booking_date' => '2026-08-15',
            'booking_time' => '10:00 AM',
            'city' => 'Dhahran',
            'address' => 'Aramco Camp',
            'total_price' => 1.00, // Client side hack attempt
        ]);

        $response->assertRedirect();
        // Server MUST calculate 210.00 SAR, ignoring 1.00 SAR
        $this->assertDatabaseHas('bookings', [
            'company_id' => $this->companyA->id,
            'total_price' => 210.00,
        ]);
    }

    /** @test */
    public function correct_contract_price_is_used_in_company_request()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-RATE-CHECK',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        ContractPrice::create([
            'contract_id' => $contract->id,
            'service_id' => $this->service2->id,
            'custom_price' => 135.00, // Service 2 public price is 200
        ]);

        $response = $this->actingAs($this->companyUserA)->post('/company/requests', [
            'company_id' => $this->companyA->id,
            'contract_id' => $contract->id,
            'patient_name' => 'Ali Aramco Employee',
            'identification_type' => 'saudi_id',
            'identification_number' => '1088776655',
            'phone' => '0509998887',
            'service_id' => $this->service2->id,
            'booking_date' => '2026-08-20',
            'booking_time' => '11:00 AM',
            'city' => 'Dhahran',
            'address' => 'Dhahran District',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'patient_name' => 'Ali Aramco Employee',
            'total_price' => 135.00,
        ]);
    }

    /** @test */
    public function admin_can_create_beneficiary()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-BEN-01',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->post('/admin/beneficiaries', [
            'company_id' => $this->companyA->id,
            'contract_id' => $contract->id,
            'name' => 'Khaled Saudi Beneficiary',
            'identification_type' => 'saudi_id',
            'identification_number' => '1012345678',
            'phone' => '0551122334',
            'employee_id_number' => 'EMP-1002',
            'status' => 'active',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contract_beneficiaries', [
            'identification_number' => '1012345678',
            'company_id' => $this->companyA->id,
            'contract_id' => $contract->id,
        ]);
    }

    /** @test */
    public function admin_can_edit_beneficiary()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-BEN-EDIT',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $beneficiary = ContractBeneficiary::create([
            'company_id' => $this->companyA->id,
            'contract_id' => $contract->id,
            'name' => 'Old Beneficiary Name',
            'identification_type' => 'iqama',
            'identification_number' => '2099887766',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->put("/admin/beneficiaries/{$beneficiary->id}", [
            'company_id' => $this->companyA->id,
            'contract_id' => $contract->id,
            'name' => 'Updated Beneficiary Name',
            'identification_type' => 'iqama',
            'identification_number' => '2099887766',
            'phone' => '0599887766',
            'status' => 'active',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contract_beneficiaries', ['name' => 'Updated Beneficiary Name']);
    }

    /** @test */
    public function admin_can_toggle_beneficiary_status()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-BEN-TOGGLE',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $beneficiary = ContractBeneficiary::create([
            'company_id' => $this->companyA->id,
            'contract_id' => $contract->id,
            'name' => 'Toggle Test User',
            'identification_type' => 'saudi_id',
            'identification_number' => '1044556677',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->post("/admin/beneficiaries/{$beneficiary->id}/toggle");
        $response->assertRedirect();
        $this->assertDatabaseHas('contract_beneficiaries', ['id' => $beneficiary->id, 'status' => 'inactive']);
    }

    /** @test */
    public function search_beneficiary_by_identification()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-SEARCH',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        ContractBeneficiary::create([
            'company_id' => $this->companyA->id,
            'contract_id' => $contract->id,
            'name' => 'Unique Searchable Beneficiary',
            'identification_type' => 'saudi_id',
            'identification_number' => '1099009900',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/beneficiaries?q=1099009900');
        $response->assertStatus(200);
        $response->assertSee('Unique Searchable Beneficiary');
    }

    /** @test */
    public function link_existing_patient_without_duplicate()
    {
        // Pre-existing Patient user in system
        $existingPatient = User::factory()->create([
            'name' => 'Existing System Patient',
            'identification_number' => '1077665544',
            'identification_type' => 'saudi_id',
            'role' => 'customer',
        ]);

        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-LINK',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->admin)->post('/admin/beneficiaries', [
            'company_id' => $this->companyA->id,
            'contract_id' => $contract->id,
            'name' => 'Existing System Patient',
            'identification_type' => 'saudi_id',
            'identification_number' => '1077665544',
            'status' => 'active',
        ]);

        $response->assertRedirect();
        // Check patient_id is automatically linked to $existingPatient->id
        $this->assertDatabaseHas('contract_beneficiaries', [
            'identification_number' => '1077665544',
            'patient_id' => $existingPatient->id,
        ]);
        // Verify User count has not increased (no duplicate user created)
        $this->assertEquals(4, User::count()); // admin + 2 company users + 1 existing patient
    }

    /** @test */
    public function invalid_cross_company_beneficiary_rejected()
    {
        $contractB = Contract::create([
            'company_id' => $this->companyB->id,
            'contract_number' => 'CNT-SABIC-01',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        // Submitting contract belonging to Company B for Company A
        $response = $this->actingAs($this->admin)->post('/admin/beneficiaries', [
            'company_id' => $this->companyA->id,
            'contract_id' => $contractB->id,
            'name' => 'Cross Company Hack',
            'identification_type' => 'saudi_id',
            'identification_number' => '1000000001',
            'status' => 'active',
        ]);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function company_sees_only_its_contracts()
    {
        Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-ARAMCO-ONLY',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        Contract::create([
            'company_id' => $this->companyB->id,
            'contract_number' => 'CNT-SABIC-ONLY',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->companyUserA)->get('/company/portal');
        $response->assertStatus(200);
        $response->assertSee('CNT-ARAMCO-ONLY');
        $response->assertDontSee('CNT-SABIC-ONLY');
    }

    /** @test */
    public function company_sees_only_its_beneficiaries()
    {
        $contractA = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-A',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $contractB = Contract::create([
            'company_id' => $this->companyB->id,
            'contract_number' => 'CNT-B',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        ContractBeneficiary::create([
            'company_id' => $this->companyA->id,
            'contract_id' => $contractA->id,
            'name' => 'Aramco Employee 1',
            'identification_type' => 'saudi_id',
            'identification_number' => '1011111111',
            'status' => 'active',
        ]);

        ContractBeneficiary::create([
            'company_id' => $this->companyB->id,
            'contract_id' => $contractB->id,
            'name' => 'SABIC Employee 1',
            'identification_type' => 'saudi_id',
            'identification_number' => '1022222222',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->companyUserA)->get('/company/portal?tab=beneficiaries');
        $response->assertStatus(200);
        $response->assertSee('Aramco Employee 1');
        $response->assertDontSee('SABIC Employee 1');
    }

    /** @test */
    public function company_a_cannot_access_company_b_contract()
    {
        // Attempting to query company_id = companyB while logged in as companyUserA
        $response = $this->actingAs($this->companyUserA)->get('/company/portal?company_id=' . $this->companyB->id);
        $response->assertStatus(403);
    }

    /** @test */
    public function printable_service_request_view_works()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-PRINT-01',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $booking = Booking::create([
            'user_id' => $this->companyUserA->id,
            'company_id' => $this->companyA->id,
            'contract_id' => $contract->id,
            'booking_number' => 'CP-PRINT123',
            'patient_name' => 'Printable Beneficiary',
            'identification_type' => 'saudi_id',
            'identification_number' => '1055667788',
            'service_id' => $this->service1->id,
            'booking_date' => '2026-08-25',
            'booking_time' => '10:00 AM',
            'city' => 'Dhahran',
            'address' => 'Aramco HQ',
            'phone' => '0501234567',
            'total_price' => 350.00,
            'status' => 'requested',
        ]);

        $response = $this->actingAs($this->companyUserA)->get("/company/requests/{$booking->id}/print");
        $response->assertStatus(200);
        $response->assertSee('CP-PRINT123');
        $response->assertSee('Printable Beneficiary');
    }

    /** @test */
    public function sensitive_operations_create_real_audit_records()
    {
        $this->actingAs($this->admin)->post('/admin/contracts', [
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-AUDIT-LOG',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'CREATE_CONTRACT',
        ]);
    }

    /** @test */
    public function company_cannot_request_non_covered_service()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-RESTRICTED-SERVICES',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        // Contract covers ONLY Service 1
        ContractPrice::create([
            'contract_id' => $contract->id,
            'service_id' => $this->service1->id,
            'custom_price' => 300.00,
        ]);

        // Attempt to request Service 2 (not covered)
        $response = $this->actingAs($this->companyUserA)->post('/company/requests', [
            'company_id' => $this->companyA->id,
            'contract_id' => $contract->id,
            'patient_name' => 'Non Covered Service Attempt',
            'identification_type' => 'saudi_id',
            'identification_number' => '1000000099',
            'phone' => '0500000099',
            'service_id' => $this->service2->id,
            'booking_date' => '2026-08-20',
            'booking_time' => '10:00 AM',
            'city' => 'Dhahran',
            'address' => 'Aramco Camp',
        ]);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function inactive_beneficiary_cannot_request_service()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-INACTIVE-BEN',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $beneficiary = ContractBeneficiary::create([
            'company_id' => $this->companyA->id,
            'contract_id' => $contract->id,
            'name' => 'Disabled Beneficiary',
            'identification_type' => 'saudi_id',
            'identification_number' => '1099112233',
            'status' => 'inactive',
        ]);

        $response = $this->actingAs($this->companyUserA)->post('/company/requests', [
            'company_id' => $this->companyA->id,
            'contract_id' => $contract->id,
            'beneficiary_id' => $beneficiary->id,
            'patient_name' => 'Disabled Beneficiary',
            'identification_type' => 'saudi_id',
            'identification_number' => '1099112233',
            'phone' => '0501122334',
            'service_id' => $this->service1->id,
            'booking_date' => '2026-08-20',
            'booking_time' => '10:00 AM',
            'city' => 'Dhahran',
            'address' => 'Aramco Camp',
        ]);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function expired_or_inactive_contract_cannot_be_used()
    {
        $expiredContract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-EXPIRED-99',
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31', // Expired
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->companyUserA)->post('/company/requests', [
            'company_id' => $this->companyA->id,
            'contract_id' => $expiredContract->id,
            'patient_name' => 'Expired Contract Attempt',
            'identification_type' => 'saudi_id',
            'identification_number' => '1099887711',
            'phone' => '0509988771',
            'service_id' => $this->service1->id,
            'booking_date' => '2026-08-20',
            'booking_time' => '10:00 AM',
            'city' => 'Dhahran',
            'address' => 'Aramco Camp',
        ]);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function unauthorized_user_cannot_modify_contract_pricing()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-SEC-PRICE',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        $priceRecord = ContractPrice::create([
            'contract_id' => $contract->id,
            'service_id' => $this->service1->id,
            'custom_price' => 300.00,
        ]);

        // Corporate user attempting to change admin contract pricing
        $response = $this->actingAs($this->companyUserA)->post("/admin/contracts/{$contract->id}/prices/{$priceRecord->id}", [
            'custom_price' => 1.00,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contract_prices', [
            'id' => $priceRecord->id,
            'custom_price' => 300.00, // Price remains unchanged
        ]);
    }

    /** @test */
    public function unauthorized_user_cannot_attach_or_detach_contract_services()
    {
        $contract = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_number' => 'CNT-SEC-ATTACH',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'payment_terms' => 'Net 30',
            'status' => 'active',
        ]);

        // Regular customer trying to attach service
        $customer = User::factory()->create(['role' => 'customer']);
        $response = $this->actingAs($customer)->post("/admin/contracts/{$contract->id}/services", [
            'service_id' => $this->service1->id,
            'custom_price' => 50.00,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseMissing('contract_prices', [
            'contract_id' => $contract->id,
            'service_id' => $this->service1->id,
        ]);
    }
}
