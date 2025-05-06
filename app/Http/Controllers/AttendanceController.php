<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee_Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        $user = Auth::user();

        // Ensure no open attendance
        $existing = Employee_Attendance::where('login_id', $user->id)
            ->whereNull('time_out')
            ->latest()
            ->first();

        if ($existing) {
            return back()->with('error', 'You already checked in.');
        }

        Employee_Attendance::create([
            'login_id' => $user->id,
            'time_in' => now(),
        ]);

        return back()->with('success', 'Checked in successfully.');
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        $attendance = Employee_Attendance::where('login_id', $user->id)
            ->whereNull('time_out')
            ->latest()
            ->first();

        if (!$attendance) {
            return back()->with('error', 'No active check-in found.');
        }

        $attendance->update([
            'time_out' => now(),
            'remark' => $request->remarks,
        ]);

        return back()->with('success', 'Checked out successfully.');
    }
}
