<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function employeedashboard()
    {
        return Inertia::render('EmployeeDashboard');
    }

    public function employees()
    {
        return Inertia::render('Employees');
    }

    public function homepage()
    {
        return Inertia::render('Homepage');
    }

    public function inventory()
    {
        return Inertia::render('Inventory');
    }
}
