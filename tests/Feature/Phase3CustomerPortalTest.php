<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Booking;
use App\Models\LabSample;
use App\Models\MedicalReport;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use App\Models\WishlistItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
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

    /** @test */
    public function customers_can_toggle_and_view_their_own_wishlist_items_and_cannot_delete_others_wishlist()
    {
        $customerA = User::factory()->create(['role' => 'customer']);
        $customerB = User::factory()->create(['role' => 'customer']);

        $product = Product::create([
            'title' => 'جهاز قياس ضغط الدم',
            'slug' => 'bp-monitor',
            'price' => 199.00,
            'stock' => 10,
        ]);

        // 1. Customer A toggles product to wishlist
        $toggleResponse = $this->actingAs($customerA)->postJson('/wishlist/toggle', [
            'product_id' => $product->id,
        ]);
        $toggleResponse->assertStatus(200);
        $toggleResponse->assertJson(['status' => 'added']);

        $this->assertDatabaseHas('wishlist_items', [
            'user_id' => $customerA->id,
            'product_id' => $product->id,
        ]);

        // 2. Customer A views wishlist index
        $indexResponse = $this->actingAs($customerA)->getJson('/wishlist');
        $indexResponse->assertStatus(200);
        $indexResponse->assertJsonFragment(['product_id' => (string)$product->id]);

        $itemA = WishlistItem::where('user_id', $customerA->id)->first();

        // 3. Customer B attempts IDOR delete of Customer A's wishlist item -> 403 Forbidden
        $deleteResponse = $this->actingAs($customerB)->delete('/wishlist/' . $itemA->id);
        $deleteResponse->assertStatus(403);

        // 4. Customer A deletes own wishlist item
        $ownDeleteResponse = $this->actingAs($customerA)->delete('/wishlist/' . $itemA->id);
        $ownDeleteResponse->assertStatus(302);
        $this->assertDatabaseMissing('wishlist_items', ['id' => $itemA->id]);
    }

    /** @test */
    public function customers_can_view_their_own_lab_samples_and_all_7_workflow_steps()
    {
        $customerA = User::factory()->create(['role' => 'customer']);
        $customerB = User::factory()->create(['role' => 'customer']);

        $service = Service::create([
            'title' => 'فحص المختبر الشامل',
            'slug' => 'full-lab-test',
            'price' => 450.00,
        ]);

        $bookingA = Booking::create([
            'user_id' => $customerA->id,
            'service_id' => $service->id,
            'booking_number' => 'BK-LAB-01',
            'booking_date' => '2026-08-12',
            'booking_time' => '09:00 AM',
            'phone' => '0555123456',
            'address' => 'الرياض',
            'total_price' => 450.00,
            'status' => 'assigned',
        ]);

        $sampleA = LabSample::create([
            'visit_code' => 'VIS-2026-000100',
            'patient_id' => $customerA->id,
            'booking_id' => $bookingA->id,
            'sample_status' => 'assigned',
        ]);

        // Customer A views profile and sees their lab sample and all 7 approved workflow steps
        $profileResponse = $this->actingAs($customerA)->get('/profile');
        $profileResponse->assertStatus(200);
        $profileResponse->assertSee('VIS-2026-000100');
        $profileResponse->assertSee('تسجيل العينة');
        $profileResponse->assertSee('إسناد الفني');
        $profileResponse->assertSee('تم سحب العينة');
        $profileResponse->assertSee('إرسال للمختبر');
        $profileResponse->assertSee('استلام المختبر');
        $profileResponse->assertSee('جاري الفحص');
        $profileResponse->assertSee('النتيجة جاهزة');

        // Customer B views profile and does NOT see Customer A's lab sample visit code
        $profileResponseB = $this->actingAs($customerB)->get('/profile');
        $profileResponseB->assertStatus(200);
        $profileResponseB->assertDontSee('VIS-2026-000100');
    }

    /** @test */
    public function customers_can_update_their_password_with_valid_current_password()
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'password' => Hash::make('old_password123'),
        ]);

        $response = $this->actingAs($customer)->post('/profile/password', [
            'current_password' => 'old_password123',
            'new_password' => 'new_password123',
            'new_password_confirmation' => 'new_password123',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $customer->refresh();
        $this->assertTrue(Hash::check('new_password123', $customer->password));
    }

    /** @test */
    public function password_update_fails_with_incorrect_current_password_or_mismatched_confirmation()
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'password' => Hash::make('secret123'),
        ]);

        // Incorrect current password
        $response = $this->actingAs($customer)->post('/profile/password', [
            'current_password' => 'wrong_password',
            'new_password' => 'new_password123',
            'new_password_confirmation' => 'new_password123',
        ]);
        $response->assertSessionHasErrors('current_password');

        // Mismatched new password confirmation
        $responseMismatch = $this->actingAs($customer)->post('/profile/password', [
            'current_password' => 'secret123',
            'new_password' => 'new_password123',
            'new_password_confirmation' => 'different_password',
        ]);
        $responseMismatch->assertSessionHasErrors('new_password');
    }

    /** @test */
    public function header_for_customer_displays_profile_link_and_hides_all_admin_staff_and_company_portals()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $view = $this->actingAs($customer)->blade('<x-header />');

        $view->assertSee('حسابي');
        $view->assertDontSee('لوحة تحكم الأدمن');
        $view->assertDontSee('بوابة الكادر الطبي');
    }
}
