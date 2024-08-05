<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrioritiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Priority::create([
            'name' => 'Niedrig',
            'status' => 'niedrig'
        ]);

        Priority::create([
            'name' => 'Mittel',
            'status' => 'mittel'
        ]);

        Priority::create([
            'name' => 'Hoch',
            'status' => 'hoch'
        ]);
    }
}
