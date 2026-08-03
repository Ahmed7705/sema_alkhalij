<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingManagerController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('service')->latest()->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $request->validate(['status' => 'required|string']);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة الزيارة الطبية بنجاح.');
    }
}
