<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Machine::create([
            'name' => 'Sonstiges',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Beladestation',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Ionisator',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Lasermarkierer',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Pastendrucker',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'SPI',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Puffer',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Conveyor',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Reflow Ofen',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Puffer',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'AOI',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Kontrollstation',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Entladestation',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Beladestation',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Fuji Modul 1',
            'machine_type_id' => '1',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Fuji Modul 2',
            'machine_type_id' => '1',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Fuji Modul 3',
            'machine_type_id' => '1',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Fuji Modul 4',
            'machine_type_id' => '1',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Fuji Modul 5',
            'machine_type_id' => '1',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Beladestation',
            'machine_type_id' => '2',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'ICT1',
            'machine_type_id' => '2',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Entladestation ICT1',
            'machine_type_id' => '2',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Beladestation ICT2',
            'machine_type_id' => '3',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'ICT2',
            'machine_type_id' => '3',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
        Machine::create([
            'name' => 'Entladestation ICT2',
            'machine_type_id' => '3',
            'status' => 'active',
            'location_name' => 'SMT',
        ]);
    }
}
