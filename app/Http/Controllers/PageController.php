<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function maindashboard()
    {
        return Inertia::render('MainDashboard');
    }

    public function employees()
    {
        $employees = \App\Models\Employee::with(['attendance' => function($query) {
            $query->orderBy('time_in', 'desc');
        }])->get();
        
        return Inertia::render('Employees', [
            'employees' => $employees->map(function($employee) {
                return [
                    'employee_id' => $employee->employee_id,
                    'employee_name' => $employee->employee_name,
                    'email' => $employee->email,
                    'phone' => $employee->phone,
                    'position' => $employee->position,
                    'address' => $employee->address,
                    'profile_picture' => $employee->profile_picture,
                    'avatar_url' => $employee->avatar_url,
                    'created_at' => $employee->created_at,
                    'attendance' => $employee->attendance->map(function($record) {
                        return [
                            'login_id' => $record->login_id,
                            'employee_id' => $record->employee_id,
                            'time_in' => $record->time_in,
                            'time_out' => $record->time_out,
                            'status' => $record->status,
                            'remark' => $record->remark
                        ];
                    })
                ];
            })
        ]);
    }

    public function inventory()
    {
        return Inertia::render('Inventory');
    }

    public function attendance()
    {
        $user = auth()->user();
        
        if ($user->permission === 'admin') {
            $employees = \App\Models\Employee::with(['attendance' => function($query) {
                $query->orderBy('time_in', 'desc');
            }])->get();
            return Inertia::render('Attendance', [
                'employees' => $employees
            ]);
        }

        // For regular employees, show their own attendance
        $employee = $user->employee;
        if (!$employee) {
            return redirect()->route('dashboard')->with('error', 'Employee record not found.');
        }
        
        // Load attendance records for the employee with proper ordering
        $employee->load(['attendance' => function($query) {
            $query->orderBy('time_in', 'desc');
        }]);
        
        // Format the attendance records
        $formattedAttendance = $employee->attendance->map(function($record) {
            return [
                'login_id' => $record->login_id,
                'employee_id' => $record->employee_id,
                'time_in' => $record->time_in,
                'time_out' => $record->time_out,
                'status' => $record->status,
                'remark' => $record->remark
            ];
        });
        
        return Inertia::render('Attendance', [
            'employee' => [
                'employee_id' => $employee->employee_id,
                'employee_name' => $employee->employee_name,
                'attendance' => $formattedAttendance
            ],
            'showEmployeeAttendance' => true
        ]);
    }

    public function employeeAttendance($employee_id)
    {
        $employee = \App\Models\Employee::with('attendance')->findOrFail($employee_id);
        return Inertia::render('Attendance', [
            'employee' => $employee,
            'showEmployeeAttendance' => true
        ]);
    }

    public function history()
    {
        return Inertia::render('History');
    }
}
