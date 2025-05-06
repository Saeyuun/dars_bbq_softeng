<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Employee;

class employeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Employee::create([
                'employee_name' => "Employee $i",
                'email' => "employee$i@example.com",
                'phone' => '09' . rand(100000000, 999999999),
                'address' => "Address $i",
                'position' => ['Manager', 'Developer', 'Designer', 'Analyst'][rand(0, 3)],
                'hire_date' => now()->subDays(rand(30, 1000))->toDateString(),
            ]);
        }
    }
}
