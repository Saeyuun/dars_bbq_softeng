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
use Illuminate\Support\Facades\Storage;


class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employee::all(); // or your query to get employees

        return Inertia::render('Employees', [
            'employees' => $employees  // Changed from 'employeeData' to 'employees'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employee,email',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $data['profile_picture'] = $path;
        }

        // Create the employee first
        $employee = Employee::create([
            'employee_name' => $data['employee_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'position' => $data['position'],
            'profile_picture' => $data['profile_picture'] ?? null,
        ]);

        // Generate default password
        $rawPassword = 'darsbbq123';

        // Create the user using employee_id
        $user = User::create([
            'employee_id' => $employee->employee_id,
            'name' => $data['employee_name'],
            'email' => $data['email'],
            'password' => Hash::make($rawPassword),
            'permission' => 'employee',
        ]);

        return redirect()->back()->with('success', 'Employee and User created successfully');
    }

    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    public function update(Request $request, $id)
    {
        \Log::info('Update request received', [
            'id' => $id,
            'data' => $request->all()
        ]);

        $request->validate([
            'employee_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $employee = Employee::findOrFail($id);
        \Log::info('Employee found', ['employee' => $employee->toArray()]);

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($employee->profile_picture) {
                Storage::disk('public')->delete($employee->profile_picture);
            }

            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $employee->profile_picture = $path;
        }

        // Update other fields
        $employee->employee_name = $request->employee_name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->position = $request->position;
        $employee->address = $request->address;

        $employee->save();
        \Log::info('Employee updated', ['employee' => $employee->toArray()]);

        // Update the associated user's name and email
        $user = User::where('employee_id', $employee->employee_id)->first();
        if ($user) {
            $user->update([
                'name' => $request->employee_name,
                'email' => $request->email
            ]);
            \Log::info('User updated', ['user' => $user->toArray()]);
        }

        return redirect()->back()->with('success', 'Employee updated successfully');
    }


    public function destroy($id)
    {
        $employee = \App\Models\Employee::findOrFail($id);
        
        // Delete the profile picture if it exists
        if ($employee->profile_picture) {
            Storage::delete($employee->profile_picture);
        }
        
        // Delete the employee record
        $employee->delete();
        
        return redirect()->back();
    }
}
