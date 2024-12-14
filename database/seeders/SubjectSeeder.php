<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create(['subject_name' => 'JAVA', 'sector_id' => 1]);
        Subject::create(['subject_name' => 'UML', 'sector_id' => 1]);
        Subject::create(['subject_name' => 'Mecanique', 'sector_id' => 2]);
        Subject::create(['subject_name' => 'Mathematics', 'sector_id' => 2]);
        Subject::create(['subject_name' => 'Chimie', 'sector_id' => 3]);
    }
}
