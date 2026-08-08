<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Booking;
use App\Models\LabSample;
use App\Models\MedicalReport;
use App\Models\Order;
use App\Models\WishlistItem;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the Patient & Customer Portal Dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $userPhone = $user->phone;
        $userId = $user->id;

        $bookings = Booking::with(['service', 'assignedProvider', 'labSample', 'medicalReports'])
            ->where(function ($q) use ($userId, $userPhone) {
                if ($userId) $q->where('user_id', $userId);
                if ($userPhone) $q->orWhere('phone', $userPhone);
            })
            ->latest()
            ->get();

        $bookingIds = $bookings->pluck('id')->toArray();

        $orders = Order::with('items.product')
            ->where(function ($q) use ($userId, $userPhone) {
                if ($userId) $q->where('user_id', $userId);
                if ($userPhone) $q->orWhere('phone', $userPhone);
            })
            ->latest()
            ->get();

        $addresses = Address::where('user_id', $userId)->get();

        $medicalReports = MedicalReport::where('patient_id', $userId)
            ->orWhereIn('booking_id', $bookingIds)
            ->latest()
            ->get();

        $labSamples = LabSample::whereIn('booking_id', $bookingIds)
            ->orWhere('patient_id', $userId)
            ->latest()
            ->get();

        $wishlistItems = WishlistItem::where('user_id', $userId)->with('product')->get();

        $userInvoices = \App\Models\Invoice::where('user_id', $userId)->latest()->get();
        $userPayments = \App\Models\Payment::where('user_id', $userId)->with(['invoice', 'refundRequests'])->latest()->get();

        $vatRate = SettingsService::getVatRate();

        return view('profile', compact(
            'user',
            'bookings',
            'orders',
            'addresses',
            'medicalReports',
            'labSamples',
            'wishlistItems',
            'userInvoices',
            'userPayments',
            'vatRate'
        ));
    }


    /**
     * Update User Profile Details.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'identification_type' => 'nullable|string|in:saudi_id,iqama,border_number,gcc_id',
            'identification_number' => 'nullable|string|max:50',
        ], [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
            'identification_type.in' => 'نوع الهوية المختار غير صحيح.',
        ]);

        $user->update($validated);

        return back()->with('success', 'تم تحديث بيانات الملف الشخصي بنجاح.');
    }

    /**
     * Update User Password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'كلمة المرور الحالية مطلوبة.',
            'new_password.required' => 'كلمة المرور الجديدة مطلوبة.',
            'new_password.min' => 'كلمة المرور الجديدة يجب أن تكون 8 أحرف على الأقل.',
            'new_password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'تم تغيير كلمة المرور بنجاح.');
    }

    /**
     * Display single Booking details with IDOR Protection.
     */
    public function showBooking(Booking $booking)
    {
        $user = Auth::user();
        
        // IDOR Check
        if ((int)$booking->user_id !== (int)$user->id && $booking->phone !== $user->phone) {
            abort(403, 'غير مصرح لك باستعراض تفاصيل هذا الحجز.');
        }

        $booking->load(['service', 'assignedProvider', 'labSample', 'medicalReports']);

        return view('profile.booking-show', compact('booking'));
    }

    /**
     * Display single Order details with IDOR Protection & Dynamic VAT.
     */
    public function showOrder(Order $order)
    {
        $user = Auth::user();

        // IDOR Check
        if ((int)$order->user_id !== (int)$user->id && $order->phone !== $user->phone) {
            abort(403, 'غير مصرح لك باستعراض تفاصيل هذا الطلب.');
        }

        $order->load(['items.product']);
        $vatRate = SettingsService::getVatRate();

        return view('profile.order-show', compact('order', 'vatRate'));
    }
}
