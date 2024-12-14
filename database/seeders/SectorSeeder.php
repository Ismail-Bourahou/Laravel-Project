<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sector;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sector::create(['sector_name' => 'Genie informatique']);
        Sector::create(['sector_name' => 'Genie civil']);
        Sector::create(['sector_name' => 'genie thermique']);
    }
}
