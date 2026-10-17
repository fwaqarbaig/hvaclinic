<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with users and HVAC Clinic content.
     */
    public function run(): void
    {
        // Guard seeder to prevent running outside local/testing environments
        if (! app()->environment('local', 'testing')) {
            return;
        }

        // 1. Create Default Admin User
        User::firstOrCreate(
            ['email' => 'info@hvaclinic.com'],
            [
                'name' => 'HVAC Clinic Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'slug' => 'hvaclinic',
                'bio' => 'Lead administrator for HVAC Clinic UAE commercial cooling and power solutions.',
                'is_active' => true,
            ]
        );

        // 2. Create Default Editor User
        User::firstOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'HVAC Technical Editor',
                'password' => Hash::make('password'),
                'role' => 'editor',
                'slug' => 'hvac-editor',
                'bio' => 'Senior HVAC Engineering Editor specializing in commercial chillers and temporary power.',
                'is_active' => true,
            ]
        );

        // 3. Seed real HVAC Clinic content if export file exists
        if (file_exists(database_path('data/hvaclinic-content.json'))) {
            Artisan::call('hvac:import-content', ['--skip-media' => true]);
        }
    }
}
