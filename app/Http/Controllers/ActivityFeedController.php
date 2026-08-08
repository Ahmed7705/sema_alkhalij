<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityFeedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        $activities = ActivityLog::where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('profile.activity', compact('activities'));
    }
}
