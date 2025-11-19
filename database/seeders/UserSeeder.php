<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            try {
                $admin = User::create([
                    'name'              => 'Admin',
                    'username'          => 'Admin',
                    'email'             => 'administrator@gmail.com',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('admin'),
                ]);
                $admin->assignRole('Administrator');
            } catch (\Throwable $e) {
                throw $e;
            }
        });
    }
}
