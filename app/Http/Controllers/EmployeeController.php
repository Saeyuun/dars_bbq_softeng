<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use function Propaganistas\LaravelPhone\phone;

class EmployeeController extends Controller
{

    public function index()
    {
        $employee = Employee::get();
        if($employee->count() > 0) {
            return EmployeeResource::collection($employee);
        }
    }


    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'employee_name' => 'required',
            'email'         => 'required|email',
            'phone'         => 'required|phone:PH',
            'address'       => 'required',
            'position'      => 'required',
            'hire_date'     => 'required|date',
        ]);
    
        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validate->errors()
            ], 422);
        }
    
        // Normalize phone number to E.164 format (e.g., +63917...)
        $validatedData = $validate->validated();
        $validatedData['phone'] = phone($validatedData['phone'], 'PH')->formatE164();
    
        $employee = Employee::create($validatedData);
    
        return response()->json([
            'message' => 'Employee created successfully',
            'data'    => new EmployeeResource($employee)
        ], 201);
    }

    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    public function update(Request $request, Employee $employee)
    {
        $validate = Validator::make($request->all(), [
            'employee_name' => 'required',
            'email'         => 'required|email',
            'phone'         => 'required|phone:PH',
            'address'       => 'required',
            'position'      => 'required',
            'hire_date'     => 'required|date',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validate->errors()
            ], 422); // Use 422 Unprocessable Entity for validation errors
        }

                // Normalize phone number to E.164 format (e.g., +63917...)
            $validatedData = $validate->validated();
            $validatedData['phone'] = phone($validatedData['phone'], 'PH')->formatE164();

        $employee = Employee::update($validate->validated());

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => new EmployeeResource($employee)
        ]);
    }


    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json([
            'message' => 'Employee data successfully deleted'
        ]);
    }
}
