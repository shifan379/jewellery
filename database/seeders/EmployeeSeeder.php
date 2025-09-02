<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Employee::create([
            'first_name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@11'),
            'designation' => 'Admin',
        ]);
    }
}
