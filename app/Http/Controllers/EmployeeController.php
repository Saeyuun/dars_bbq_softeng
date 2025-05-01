<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee = Employee::get();
        if($employee->count() > 0) {
            return EmployeeResource::collection($employee);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'employee_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^09\d{9}$/',
            'address' => 'required',
            'position' => 'required',
            'hire_date' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validate->errors()
            ], 422); // Use 422 Unprocessable Entity for validation errors
        }

        $employee = Employee::create($validate->validated());

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new EmployeeResource($employee)
        ], 201); // Use 201 Created for successful resource creation
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, Employee $employee)
    {
        $validate = Validator::make($request->all(), [
            'employee_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^09\d{9}$/',
            'address' => 'required',
            'position' => 'required',
            'hire_date' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validate->errors()
            ], 422); // Use 422 Unprocessable Entity for validation errors
        }

        $employee = Employee::update($validate->validated());

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new EmployeeResource($employee)
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json([
            'message' => 'Employee data successfully deleted'
        ]);
    }
}
