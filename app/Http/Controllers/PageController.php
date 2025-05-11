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
        return Inertia::render('Employees');
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
