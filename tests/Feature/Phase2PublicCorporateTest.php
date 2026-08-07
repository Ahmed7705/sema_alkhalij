<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\ContractRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase2PublicCorporateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_view_public_corporate_services_page()
    {
        $response = $this->get('/corporate-services');
        $response->assertStatus(200);
        $response->assertSee('حلول الرعاية الطبية المتكاملة للشركات');
        $response->assertSee('آلية التعاقد ومراحل التنفيذ التشغيلي');
    }

    /** @test */
    public function guests_can_submit_contract_request_successfully()
    {
        $data = [
            'company_name' => 'شركة التقنية للحلول الطبية',
            'cr_number' => '1010998877',
            'contact_person' => 'عبدالله المنصور',
            'phone' => '0555123456',
            'email' => 'contact@tech-corp.sa',
            'city' => 'الرياض',
            'expected_beneficiaries' => 150,
            'requested_services' => 'تمريض منزلي وسحب عينات',
            'notes' => 'يرجى تقديم عرض أسعار تعاقدي خاص',
        ];

        $response = $this->post('/corporate-services', $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contract_requests', [
            'company_name' => 'شركة التقنية للحلول الطبية',
            'cr_number' => '1010998877',
            'email' => 'contact@tech-corp.sa',
            'status' => 'new',
        ]);
    }

    /** @test */
    public function contract_request_fails_validation_with_missing_fields()
    {
        $response = $this->post('/corporate-services', [
            'company_name' => '', // Required missing
            'email' => 'invalid-email',
        ]);

        $response->assertSessionHasErrors(['company_name', 'contact_person', 'phone', 'email', 'city']);
    }

    /** @test */
    public function guests_are_redirected_when_accessing_admin_dashboard()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function regular_customers_are_redirected_when_accessing_admin_dashboard()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->get('/admin');
        $response->assertRedirect('/');
    }

    /** @test */
    public function customers_receive_forbidden_status_when_accessing_staff_dashboard()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->get('/staff/dashboard');
        $response->assertStatus(403);
    }

    /** @test */
    public function customers_receive_forbidden_status_when_accessing_company_portal()
    {
        $customer = User::factory()->create(['role' => 'customer', 'company_id' => null]);

        $response = $this->actingAs($customer)->get('/company/portal');
        $response->assertStatus(403);
    }

    /** @test */
    public function authorized_medical_doctor_can_access_staff_portal()
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $response = $this->actingAs($doctor)->get('/staff/dashboard');
        $response->assertStatus(200);
    }

    /** @test */
    public function authorized_medical_nurse_can_access_staff_portal()
    {
        $nurse = User::factory()->create(['role' => 'nurse']);

        $response = $this->actingAs($nurse)->get('/staff/dashboard');
        $response->assertStatus(200);
    }

    /** @test */
    public function authorized_physiotherapist_can_access_staff_portal()
    {
        $physio = User::factory()->create(['role' => 'physio']);

        $response = $this->actingAs($physio)->get('/staff/dashboard');
        $response->assertStatus(200);
    }

    /** @test */
    public function authorized_lab_technician_can_access_staff_portal()
    {
        $labTech = User::factory()->create(['role' => 'lab_tech']);

        $response = $this->actingAs($labTech)->get('/staff/dashboard');
        $response->assertStatus(200);
    }

    /** @test */
    public function authorized_company_admin_can_access_company_portal()
    {
        $company = Company::create([
            'name' => 'شركة الأعمال المتقدمة',
            'status' => 'active',
        ]);

        $companyAdmin = User::factory()->create([
            'role' => 'company_admin',
            'company_id' => $company->id,
            'is_active' => true,
        ]);

        $response = $this->actingAs($companyAdmin)->get('/company/portal');
        $response->assertStatus(200);
        $response->assertSee('شركة الأعمال المتقدمة');
    }

    /** @test */
    public function authorized_admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('لوحة التحليلات والإحصائيات');
    }

    /** @test */
    public function header_for_guest_renders_login_and_corporate_dropdown_without_admin_link()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('تسجيل الدخول');
        $response->assertSee('خدمات الشركات');
        $response->assertDontSee('لوحة الإدارة');
        $response->assertDontSee('بوابة الكادر');
        $response->assertDontSee('بوابة الشركة');
    }

    /** @test */
    public function header_for_customer_renders_profile_link_without_admin_or_portals()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->get('/');

        $response->assertStatus(200);
        $response->assertSee('حسابي');
        $response->assertDontSee('لوحة الإدارة');
        $response->assertDontSee('بوابة الكادر');
        $response->assertDontSee('بوابة الشركة');
    }

    /** @test */
    public function header_for_staff_renders_staff_portal_button_without_admin_link()
    {
        $doctor = User::factory()->create(['role' => 'doctor']);

        $response = $this->actingAs($doctor)->get('/');

        $response->assertStatus(200);
        $response->assertSee('بوابة الكادر');
        $response->assertDontSee('لوحة الإدارة');
    }

    /** @test */
    public function header_for_company_user_renders_company_portal_button_without_admin_link()
    {
        $companyUser = User::factory()->create(['role' => 'company_admin']);

        $response = $this->actingAs($companyUser)->get('/');

        $response->assertStatus(200);
        $response->assertSee('بوابة الشركة');
        $response->assertDontSee('لوحة الإدارة');
    }

    /** @test */
    public function header_for_admin_renders_admin_dashboard_button()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/');

        $response->assertStatus(200);
        $response->assertSee('لوحة الإدارة');
    }

    /** @test */
    public function corporate_services_dropdown_contains_valid_active_links()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(route('corporate-services'));
        $response->assertSee(url('/corporate-services#contract-request-form'));
        $response->assertSee(route('login'));
    }
}
