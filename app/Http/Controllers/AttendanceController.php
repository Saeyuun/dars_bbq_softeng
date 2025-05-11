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
        $employee = $user->employee;

        if (!$employee) {
            return back()->with('error', 'Employee record not found.');
        }

        // Ensure no open attendance
        $existing = Employee_Attendance::where('employee_id', $employee->employee_id)
            ->whereNull('time_out')
            ->latest('time_in')
            ->first();

        if ($existing) {
            return back()->with('error', 'You already checked in.');
        }

        Employee_Attendance::create([
            'employee_id' => $employee->employee_id,
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
        $employee = $user->employee;

        if (!$employee) {
            return back()->with('error', 'Employee record not found.');
        }

        $attendance = Employee_Attendance::where('employee_id', $employee->employee_id)
            ->whereNull('time_out')
            ->latest('time_in')
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
