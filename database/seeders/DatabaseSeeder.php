<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EditorsTableSeeder::class);
        $this->call(PrioritiesTableSeeder::class);
        $this->call(MachineTypeSeeder::class);
        $this->call(MachineTableSeeder::class);
        $this->call(RolesAndAccessSeeder::class);
        $this->call(WebsiteSettingsSeeder::class);
    }
}
