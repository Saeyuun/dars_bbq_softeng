<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use function Propaganistas\LaravelPhone\phone;
use Inertia\Inertia;


class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::all();
        return Inertia::render('Employees', [
        'employees' => $employees
]);
    }

public function store(Request $request)
{
    $validate = Validator::make($request->all(), [
        'employee_name'    => 'required',
        'email'            => 'required|email|unique:users,email',
        'phone'            => 'required|phone:PH',
        'address'          => 'required',
        'position'         => 'required',
        'profile_picture'  => 'nullable|image',
    ]);

    if ($validate->fails()) {
        return response()->json([
            'message' => 'Validation failed',
            'errors'  => $validate->errors()
        ], 422);
    }

    $validatedData = $validate->validated();

    // Handle profile picture upload if exists
    if ($request->hasFile('profile_picture')) {
        $validatedData['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
    }

    // Create the employee first
    $employee = Employee::create([
        'employee_name'   => $validatedData['employee_name'],
        'email'           => $validatedData['email'],
        'phone'           => $validatedData['phone'],
        'address'         => $validatedData['address'],
        'position'        => $validatedData['position'],
        'profile_picture' => $validatedData['profile_picture'] ?? null,
    ]);

    // Generate random password
    $rawPassword = 'darsbbq123'; // or Str::random(10) if you want random

    // Now create the user using employee_id
    $user = User::create([
        'employee_id' => $employee->employee_id,
        'name'        => $validatedData['employee_name'],
        'email'       => $validatedData['email'],
        'password'    => Hash::make($rawPassword),
        'permission'  => 'employee',
    ]);

    return response()->json([
        'message' => 'Employee and User created successfully',
        'data'    => new EmployeeResource($employee),
        'login_credentials' => [
            'email'    => $user->email,
            'password' => $rawPassword // ← return the raw password
        ]
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
