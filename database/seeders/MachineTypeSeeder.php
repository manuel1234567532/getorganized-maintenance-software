<?php

namespace Database\Seeders;

use App\Models\MachineType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MachineType::create([
            'name' => 'Bestücker',
            'status' => 'active',
        ]);
        MachineType::create([
            'name' => 'ICT/FCT1',
            'status' => 'active',
        ]);
        MachineType::create([
            'name' => 'ICT/FCT2',
            'status' => 'active',
        ]);
    }
}
