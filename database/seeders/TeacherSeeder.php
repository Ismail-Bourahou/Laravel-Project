<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::create([
            'teacher_code' => '1122334455',
            'firstname' => 'Ismail',
            'lastname' => 'Bou',
            'email' => 'ismail@gmail.com',
            'password' => 'Ana12345'
        ]);
    }
}
