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
        $employees = \App\Models\Employee::all();
        return Inertia::render('Employees', [
            'employees' => $employees
        ]);
    }

    public function inventory()
    {
        return Inertia::render('Inventory');
    }
    public function attendance()
    {
        return Inertia::render('Attendance');
    }
    public function history()
    {
        return Inertia::render('History');
    }
}
