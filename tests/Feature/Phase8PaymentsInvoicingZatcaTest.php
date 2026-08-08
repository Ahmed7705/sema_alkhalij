<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\RefundRequest;
use App\Models\Service;
use App\Models\User;
use App\Services\InvoiceGeneratorService;
use App\Services\PaymentGatewayService;
use App\Services\ZatcaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase8PaymentsInvoicingZatcaTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $customerA;
    protected User $customerB;
    protected Company $companyA;
    protected Company $companyB;
    protected Contract $contractA;
    protected Service $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->companyA = Company::create([
            'name' => 'شركة أرامكو السعودية للخدمات الطبية',
            'company_code' => 'COMP-ARAMCO-2026',
            'cr_number' => '1010998877',
            'status' => 'active',
        ]);

        $this->companyB = Company::create([
            'name' => 'شركة سابك للصناعات المتطورة',
            'company_code' => 'COMP-SABIC-2026',
            'cr_number' => '1010112233',
            'status' => 'active',
        ]);

        $this->contractA = Contract::create([
            'company_id' => $this->companyA->id,
            'contract_code' => 'CNT-ARAMCO-001',
            'status' => 'active',
            'start_date' => now()->subMonth(),
            'end_date' => now()->addYear(),
        ]);

        $this->customerA = User::factory()->create([
            'role' => 'customer',
            'company_id' => $this->companyA->id,
            'is_active' => true,
        ]);

        $this->customerB = User::factory()->create([
            'role' => 'customer',
            'company_id' => $this->companyB->id,
            'is_active' => true,
        ]);

        $this->service = Service::create([
            'title' => 'خدمة زيارة طبيب عام منزلية',
            'title_ar' => 'خدمة زيارة طبيب عام منزلية',
            'title_en' => 'General Physician Home Visit',
            'slug' => 'general-physician-visit',
            'price' => 300.00,
            'is_active' => true,
        ]);
    }


    /** @test */
    public function invoice_generator_creates_sequential_invoice_number_and_calculates_15_percent_vat()
    {
        $booking = Booking::create([
            'booking_number' => 'BKG-2026-000101',
            'user_id' => $this->customerA->id,
            'service_id' => $this->service->id,
            'patient_name' => 'أحمد علي',
            'phone' => '0590000001',
            'total_price' => 230.00, // Total = 200 Subtotal + 30 VAT (15%)
            'booking_date' => now()->format('Y-m-d'),
            'booking_time' => '10:00 AM',
            'city' => 'الرياض',
            'address' => 'حي العليا',
            'status' => 'confirmed',
            'payment_status' => 'unpaid',
        ]);


        $service = new InvoiceGeneratorService();
        $invoice = $service->generateForBooking($booking);

        $this->assertDatabaseHas('invoices', [
            'booking_id' => $booking->id,
            'user_id' => $this->customerA->id,
            'total_amount' => 230.00,
            'vat_amount' => 30.00,
            'subtotal' => 200.00,
        ]);

        $this->assertNotNull($invoice->qr_code_tlv);
        $this->assertNotNull($invoice->invoice_hash);
        $this->assertNotNull($invoice->uuid);
    }

    /** @test */
    public function invoice_generator_creates_corporate_contract_invoice()
    {
        $service = new InvoiceGeneratorService();
        $invoice = $service->generateForCorporateContract($this->companyA, $this->contractA, 10000.00, 'مطالبة شهرية لعقد الخدمات الطبية');

        $this->assertEquals(10000.00, $invoice->subtotal);
        $this->assertEquals(1500.00, $invoice->vat_amount);
        $this->assertEquals(11500.00, $invoice->total_amount);
        $this->assertEquals($this->companyA->id, $invoice->company_id);
    }

    /** @test */
    public function zatca_service_generates_valid_base64_tlv_qr_code_and_sha256_hash()
    {
        $qrCode = ZatcaService::generateTlvQrCode(
            'شركة سما الخليج للخدمات الطبية',
            '300000000000003',
            now()->toIso8601String(),
            115.00,
            15.00
        );

        $this->assertNotEmpty($qrCode);
        $this->assertIsString($qrCode);

        $hash = ZatcaService::calculateInvoiceHash('INV-2026-000101', now()->toIso8601String(), 115.00);
        $this->assertEquals(64, strlen($hash)); // SHA-256 string length
    }

    /** @test */
    public function payment_gateway_service_processes_payment_across_supported_methods()
    {
        $booking = Booking::create([
            'booking_number' => 'BKG-2026-000102',
            'user_id' => $this->customerA->id,
            'service_id' => $this->service->id,
            'patient_name' => 'أحمد علي',
            'phone' => '0590000001',
            'total_price' => 115.00,
            'booking_date' => now()->format('Y-m-d'),
            'booking_time' => '10:00 AM',
            'city' => 'الرياض',
            'address' => 'حي العليا',
            'status' => 'confirmed',
        ]);

        $invoiceService = new InvoiceGeneratorService();
        $invoice = $invoiceService->generateForBooking($booking);

        $gatewayService = new PaymentGatewayService();
        $payment = $gatewayService->processPayment($invoice, PaymentGatewayService::METHOD_MADA, 115.00);

        $this->assertEquals('completed', $payment->status);
        $this->assertEquals(115.00, $payment->amount);

        $invoice->refresh();
        $this->assertEquals('paid', $invoice->payment_status);
    }

    /** @test */
    public function admin_can_access_financial_dashboard_and_view_metrics()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.finance.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('العمليات المالية والفواتير الإلكترونية ZATCA');
    }

    /** @test */
    public function admin_can_view_invoices_directory_and_filter()
    {
        $booking = Booking::create([
            'booking_number' => 'BKG-2026-000103',
            'user_id' => $this->customerA->id,
            'service_id' => $this->service->id,
            'patient_name' => 'أحمد علي',
            'phone' => '0590000001',
            'total_price' => 500.00,
            'booking_date' => now()->format('Y-m-d'),
            'booking_time' => '10:00 AM',
            'city' => 'الرياض',
            'address' => 'حي العليا',
            'status' => 'confirmed',
        ]);

        $invoiceService = new InvoiceGeneratorService();
        $invoice = $invoiceService->generateForBooking($booking);

        $response = $this->actingAs($this->admin)->get(route('admin.finance.invoices.index'));
        $response->assertStatus(200);
        $response->assertSee($invoice->invoice_number);
    }

    /** @test */
    public function admin_can_issue_corporate_invoice()
    {
        $response = $this->actingAs($this->admin)->post(route('admin.finance.invoices.corporate.store'), [
            'company_id' => $this->companyA->id,
            'contract_id' => $this->contractA->id,
            'amount' => 5000.00,
            'description' => 'مطالبة مالية شهرية لشركة أرامكو',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('invoices', [
            'company_id' => $this->companyA->id,
            'contract_id' => $this->contractA->id,
            'subtotal' => 5000.00,
            'vat_amount' => 750.00,
            'total_amount' => 5750.00,
        ]);
    }

    /** @test */
    public function customer_can_submit_refund_request()
    {
        $booking = Booking::create([
            'booking_number' => 'BKG-2026-000104',
            'user_id' => $this->customerA->id,
            'service_id' => $this->service->id,
            'patient_name' => 'أحمد علي',
            'phone' => '0590000001',
            'total_price' => 115.00,
            'booking_date' => now()->format('Y-m-d'),
            'booking_time' => '10:00 AM',
            'city' => 'الرياض',
            'address' => 'حي العليا',
            'status' => 'confirmed',
        ]);

        $invoice = (new InvoiceGeneratorService())->generateForBooking($booking);
        $payment = (new PaymentGatewayService())->processPayment($invoice, PaymentGatewayService::METHOD_MADA, 115.00);

        $response = $this->actingAs($this->customerA)->post(route('refunds.store'), [
            'payment_id' => $payment->id,
            'reason' => 'تم إلغاء الموعد بداعي السفر الطارئ',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('refund_requests', [
            'payment_id' => $payment->id,
            'user_id' => $this->customerA->id,
            'amount' => 115.00,
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function idor_prevents_customer_from_requesting_refund_for_another_users_payment()
    {
        $booking = Booking::create([
            'booking_number' => 'BKG-2026-000105',
            'user_id' => $this->customerA->id,
            'service_id' => $this->service->id,
            'patient_name' => 'أحمد علي',
            'phone' => '0590000001',
            'total_price' => 115.00,
            'booking_date' => now()->format('Y-m-d'),
            'booking_time' => '10:00 AM',
            'city' => 'الرياض',
            'address' => 'حي العليا',
            'status' => 'confirmed',
        ]);

        $invoice = (new InvoiceGeneratorService())->generateForBooking($booking);
        $payment = (new PaymentGatewayService())->processPayment($invoice, PaymentGatewayService::METHOD_MADA, 115.00);

        // Customer B attempts to request refund for Customer A's payment -> IDOR blocked
        $response = $this->actingAs($this->customerB)->post(route('refunds.store'), [
            'payment_id' => $payment->id,
            'reason' => 'محاولة احتيال واسترجاع مالي لمبلغ مريض آخر',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('refund_requests', [
            'payment_id' => $payment->id,
            'user_id' => $this->customerB->id,
        ]);
    }

    /** @test */
    public function admin_can_approve_refund_and_update_payment_and_invoice_statuses()
    {
        $booking = Booking::create([
            'booking_number' => 'BKG-2026-000106',
            'user_id' => $this->customerA->id,
            'service_id' => $this->service->id,
            'patient_name' => 'أحمد علي',
            'phone' => '0590000001',
            'total_price' => 115.00,
            'booking_date' => now()->format('Y-m-d'),
            'booking_time' => '10:00 AM',
            'city' => 'الرياض',
            'address' => 'حي العليا',
            'status' => 'confirmed',
        ]);

        $invoice = (new InvoiceGeneratorService())->generateForBooking($booking);
        $payment = (new PaymentGatewayService())->processPayment($invoice, PaymentGatewayService::METHOD_MADA, 115.00);

        $refund = RefundRequest::create([
            'refund_number' => 'REF-2026-000101',
            'payment_id' => $payment->id,
            'invoice_id' => $invoice->id,
            'user_id' => $this->customerA->id,
            'amount' => 115.00,
            'reason' => 'إلغاء الموعد بناء على طلب العميل',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.finance.refunds.approve', $refund->id), [
            'notes' => 'تم استرجاع المبلغ على بطاقة مدى',
        ]);

        $response->assertRedirect();

        $refund->refresh();
        $this->assertEquals('approved', $refund->status);

        $payment->refresh();
        $this->assertEquals('refunded', $payment->status);

        $invoice->refresh();
        $this->assertEquals('refunded', $invoice->payment_status);
    }

    /** @test */
    public function authorized_user_can_download_invoice_pdf()
    {
        $booking = Booking::create([
            'booking_number' => 'BKG-2026-000107',
            'user_id' => $this->customerA->id,
            'service_id' => $this->service->id,
            'patient_name' => 'أحمد علي',
            'phone' => '0590000001',
            'total_price' => 115.00,
            'booking_date' => now()->format('Y-m-d'),
            'booking_time' => '10:00 AM',
            'city' => 'الرياض',
            'address' => 'حي العليا',
            'status' => 'confirmed',
        ]);

        $invoice = (new InvoiceGeneratorService())->generateForBooking($booking);

        $response = $this->actingAs($this->customerA)->get(route('invoices.download', $invoice->id));
        $response->assertStatus(200);
        $response->assertSee($invoice->invoice_number);
    }

    /** @test */
    public function unauthorized_user_cannot_download_other_users_invoice_pdf_idor_protected()
    {
        $booking = Booking::create([
            'booking_number' => 'BKG-2026-000108',
            'user_id' => $this->customerA->id,
            'service_id' => $this->service->id,
            'patient_name' => 'أحمد علي',
            'phone' => '0590000001',
            'total_price' => 115.00,
            'booking_date' => now()->format('Y-m-d'),
            'booking_time' => '10:00 AM',
            'city' => 'الرياض',
            'address' => 'حي العليا',
            'status' => 'confirmed',
        ]);


        $invoice = (new InvoiceGeneratorService())->generateForBooking($booking);

        // Customer B attempts to download Customer A's invoice -> IDOR 403
        $response = $this->actingAs($this->customerB)->get(route('invoices.download', $invoice->id));
        $response->assertStatus(403);
    }
}
