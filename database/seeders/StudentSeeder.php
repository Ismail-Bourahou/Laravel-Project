<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'student_code' => 'M123456789',
            'firstname' => 'Ismail',
            'lastname' => 'Bou',
            'email' => 'ismail@gmail.com',
            'password' => 'Ana12345',
            'sector_id' => 1
        ]);
    }
}

