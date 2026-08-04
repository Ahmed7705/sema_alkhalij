<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Booking;
use App\Models\MedicalReport;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Phase3CustomerPortalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_customer_profile()
    {
        $response = $this->get('/profile');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function customers_can_access_their_profile_dashboard()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->get('/profile');

        $response->assertStatus(200);
        $response->assertSee($customer->name);
        $response->assertSee('نظرة عامة');
    }

    /** @test */
    public function customers_can_update_their_allowed_profile_information()
    {
        $customer = User::factory()->create([
            'name' => 'محمد علي',
            'email' => 'm.ali@example.com',
            'role' => 'customer',
        ]);

        $updateData = [
            'name' => 'محمد علي التميمي',
            'email' => 'm.ali.updated@example.com',
            'phone' => '0501234567',
            'identification_type' => 'saudi_id',
            'identification_number' => '1029384756',
        ];

        $response = $this->actingAs($customer)->post('/profile/update', $updateData);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $customer->id,
            'name' => 'محمد علي التميمي',
            'email' => 'm.ali.updated@example.com',
            'identification_type' => 'saudi_id',
            'identification_number' => '1029384756',
        ]);
    }

    /** @test */
    public function customers_can_add_edit_and_delete_their_own_addresses()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        // 1. Add Address
        $storeResponse = $this->actingAs($customer)->post('/addresses', [
            'label' => 'المنزل الرئيسي',
            'city' => 'الرياض',
            'district' => 'الياسمين',
            'street' => 'شارع التخصصي',
            'building_no' => '12',
            'is_default' => 1,
        ]);
        $storeResponse->assertStatus(302);

        $address = Address::where('user_id', $customer->id)->first();
        $this->assertNotNull($address);
        $this->assertEquals('المنزل الرئيسي', $address->label);

        // 2. Update Address
        $updateResponse = $this->actingAs($customer)->put('/addresses/' . $address->id, [
            'label' => 'المنزل المحدث',
            'city' => 'الرياض',
            'district' => 'النرجس',
        ]);
        $updateResponse->assertStatus(302);
        $this->assertDatabaseHas('addresses', ['id' => $address->id, 'district' => 'النرجس']);

        // 3. Delete Address
        $deleteResponse = $this->actingAs($customer)->delete('/addresses/' . $address->id);
        $deleteResponse->assertStatus(302);
        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }

    /** @test */
    public function customers_cannot_update_or_delete_another_customers_address()
    {
        $customerA = User::factory()->create(['role' => 'customer']);
        $customerB = User::factory()->create(['role' => 'customer']);

        $addressB = Address::create([
            'user_id' => $customerB->id,
            'label' => 'عنوان العميل الثاني',
            'city' => 'جدة',
        ]);

        // Customer A tries to update Customer B's address -> 403 Forbidden
        $updateResponse = $this->actingAs($customerA)->put('/addresses/' . $addressB->id, [
            'label' => 'محاولة اختراق',
            'city' => 'الرياض',
        ]);
        $updateResponse->assertStatus(403);

        // Customer A tries to delete Customer B's address -> 403 Forbidden
        $deleteResponse = $this->actingAs($customerA)->delete('/addresses/' . $addressB->id);
        $deleteResponse->assertStatus(403);
    }

    /** @test */
    public function customers_can_view_their_own_booking_details()
    {
        $customer = User::factory()->create(['role' => 'customer', 'phone' => '0555123456']);
        $service = Service::create([
            'title' => 'كشف طبي منزلي',
            'slug' => 'doctor-home-visit',
            'price' => 250.00,
            'is_active' => true,
        ]);

        $booking = Booking::create([
            'user_id' => $customer->id,
            'service_id' => $service->id,
            'booking_number' => 'BK-100200',
            'booking_date' => '2026-08-10',
            'booking_time' => '10:00 AM',
            'phone' => '0555123456',
            'address' => 'شارع التخصصي',
            'total_price' => 250.00,
            'status' => 'assigned',
        ]);

        $response = $this->actingAs($customer)->get('/profile/bookings/' . $booking->id);

        $response->assertStatus(200);
        $response->assertSee('BK-100200');
        $response->assertSee('كشف طبي منزلي');
    }

    /** @test */
    public function customers_cannot_view_another_customers_booking_details()
    {
        $customerA = User::factory()->create(['role' => 'customer', 'phone' => '0500000001']);
        $customerB = User::factory()->create(['role' => 'customer', 'phone' => '0500000002']);
        $service = Service::create([
            'title' => 'تمريض منزلي',
            'slug' => 'home-nursing',
            'price' => 300.00,
            'is_active' => true,
        ]);

        $bookingB = Booking::create([
            'user_id' => $customerB->id,
            'service_id' => $service->id,
            'booking_number' => 'BK-PRIVATE',
            'booking_date' => '2026-08-10',
            'booking_time' => '10:00 AM',
            'phone' => '0500000002',
            'address' => 'حي العليا',
            'total_price' => 300.00,
            'status' => 'requested',
        ]);

        // Customer A attempts IDOR access to Customer B's booking
        $response = $this->actingAs($customerA)->get('/profile/bookings/' . $bookingB->id);

        $response->assertStatus(403);
    }

    /** @test */
    public function customers_can_view_their_own_order_details()
    {
        $customer = User::factory()->create(['role' => 'customer', 'phone' => '0555123456']);

        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'ORD-554433',
            'phone' => '0555123456',
            'shipping_address' => 'الرياض - حي الياسمين',
            'subtotal' => 500.00,
            'total_price' => 575.00,
            'total_amount' => 575.00,
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => 'card',
        ]);

        $response = $this->actingAs($customer)->get('/profile/orders/' . $order->id);

        $response->assertStatus(200);
        $response->assertSee('ORD-554433');
    }

    /** @test */
    public function customers_cannot_view_another_customers_order_details()
    {
        $customerA = User::factory()->create(['role' => 'customer', 'phone' => '0500000001']);
        $customerB = User::factory()->create(['role' => 'customer', 'phone' => '0500000002']);

        $orderB = Order::create([
            'user_id' => $customerB->id,
            'order_number' => 'ORD-SECRET',
            'phone' => '0500000002',
            'shipping_address' => 'جدة - حي الشاطئ',
            'subtotal' => 868.70,
            'total_price' => 999.00,
            'total_amount' => 999.00,
            'status' => 'completed',
        ]);

        // Customer A attempts IDOR access to Customer B's order
        $response = $this->actingAs($customerA)->get('/profile/orders/' . $orderB->id);

        $response->assertStatus(403);
    }

    /** @test */
    public function customers_can_download_their_own_medical_report_pdf()
    {
        Storage::fake('local');

        $customer = User::factory()->create(['role' => 'customer']);
        $filePath = 'private/medical_reports/test_report.pdf';
        Storage::put($filePath, 'PDF dummy binary content');

        $report = MedicalReport::create([
            'patient_id' => $customer->id,
            'uploaded_by' => $customer->id,
            'file_path' => $filePath,
            'file_name' => 'نتيجة_التحليل.pdf',
            'file_size' => 1024,
            'mime_type' => 'application/pdf',
        ]);

        $response = $this->actingAs($customer)->get('/medical-reports/' . $report->id . '/download');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /** @test */
    public function customers_cannot_download_another_patients_medical_report_pdf()
    {
        Storage::fake('local');

        $customerA = User::factory()->create(['role' => 'customer']);
        $customerB = User::factory()->create(['role' => 'customer']);
        $filePath = 'private/medical_reports/patient_b_report.pdf';
        Storage::put($filePath, 'PDF secret binary content');

        $reportB = MedicalReport::create([
            'patient_id' => $customerB->id,
            'uploaded_by' => $customerB->id,
            'file_path' => $filePath,
            'file_name' => 'تقرير_سري.pdf',
            'file_size' => 2048,
            'mime_type' => 'application/pdf',
        ]);

        // Customer A attempts IDOR download of Customer B's report
        $response = $this->actingAs($customerA)->get('/medical-reports/' . $reportB->id . '/download');

        $response->assertStatus(403);
    }
}
