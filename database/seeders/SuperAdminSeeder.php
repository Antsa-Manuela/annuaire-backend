<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuperAdmin;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        SuperAdmin::firstOrCreate(
            ['email' => 'superadmin@annuaire.com'],
            [
                'name' => 'Super Admin',
                'cin' => 'SA001',
                'password' => Hash::make('password123'),
                'is_active' => true,
            ]
        );

        $this->command->info('Super admin created or already exists.');
    }
}