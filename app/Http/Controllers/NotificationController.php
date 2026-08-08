<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\NotificationPreference;
use App\Services\Drivers\PushNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $user->notifications();

        if ($request->filled('category')) {
            $query->where('data->event_type', $request->category);
        }

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('data->title_ar', 'like', "%{$term}%")
                  ->orWhere('data->title_en', 'like', "%{$term}%")
                  ->orWhere('data->message_ar', 'like', "%{$term}%")
                  ->orWhere('data->message_en', 'like', "%{$term}%");
            });
        }

        $notifications = $query->paginate(15);
        $unreadCount = $user->unreadNotifications()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead(string $id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->firstOrFail();

        $notification->markAsRead();

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'READ_NOTIFICATION',
            'details' => json_encode(['notification_id' => $id]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', __('تم تحديث الإشعار كمقروء.'));
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'READ_NOTIFICATION',
            'details' => json_encode(['action' => 'mark_all_read']),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', __('تم تعيين جميع الإشعارات كمقروءة.'));
    }

    public function destroy(string $id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->firstOrFail();
        $notification->delete();

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'DELETE_NOTIFICATION',
            'details' => json_encode(['notification_id' => $id]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', __('تم حذف الإشعار بنجاح.'));
    }

    public function preferences()
    {
        $user = Auth::user();
        $events = [
            'booking_created' => 'إنشاء وتأكيد الحجز',
            'visit_status_changed' => 'تحديث حالة الزيارة الطبية',
            'medical_report_uploaded' => 'جاهزية وتوفّر التقرير الطبي',
            'invoice_created' => 'إصدار الفواتير والعمليات المالية',
            'payment_succeeded' => 'تأكيد نجاح عمليات الدفع',
            'low_stock' => 'تنبيهات المخزون والدفعات',
        ];

        $preferences = NotificationPreference::where('user_id', $user->id)
            ->get()
            ->keyBy('event_type');

        return view('notifications.preferences', compact('events', 'preferences'));
    }

    public function updatePreferences(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'preferences' => 'required|array',
        ]);

        foreach ($request->preferences as $eventType => $channels) {
            NotificationPreference::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'event_type' => $eventType,
                ],
                [
                    'in_app' => !empty($channels['in_app']),
                    'email' => !empty($channels['email']),
                    'sms' => !empty($channels['sms']),
                    'whatsapp' => !empty($channels['whatsapp']),
                    'push' => !empty($channels['push']),
                ]
            );
        }


        return back()->with('success', __('تم حفظ تفضيلات الإشعارات والتواصل بنجاح.'));
    }

    public function registerDeviceToken(Request $request, PushNotificationService $pushService)
    {
        $request->validate([
            'device_token' => 'required|string',
            'device_type' => 'nullable|string|in:web,android,ios',
        ]);

        $pushService->registerDevice(
            Auth::user(),
            $request->device_token,
            $request->device_type ?? 'web',
            $request->header('User-Agent')
        );

        return response()->json(['success' => true, 'message' => 'Device token registered successfully.']);
    }
}
