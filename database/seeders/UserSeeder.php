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
                $superadmin = User::create([
                    'name'              => 'Superadmin',
                    'username'          => 'superadmin',
                    'email'             => 'administrator@gmail.com',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('superadmin'),
                ]);
                $superadmin->assignRole('Administrator');
                $admin = User::create([
                    'name'              => 'Admin',
                    'username'          => 'admin',
                    'email'             => 'admin@gmail.com',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('admin'),
                ]);
                $admin->assignRole('Admin');
                $kasat = User::create([
                    'name'              => 'Kasat',
                    'username'          => 'kasat',
                    'email'             => 'kasat@gmail.com',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('kasat'),
                ]);
                $kasat->assignRole('Kasat');
                $kabid = User::create([
                    'name'              => 'Kabid',
                    'username'          => 'kabid',
                    'email'             => 'kabid@gmail.com',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('kabid'),
                ]);
                $kabid->assignRole('Kabid');
                $kasi = User::create([
                    'name'              => 'Kasi 1',
                    'username'          => 'kasi1',
                    'email'             => 'kasi1@gmail.com',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('kasi1'),
                ]);
                $kasi->assignRole('Kasi');
                $kasi = User::create([
                    'name'              => 'Kasi 2',
                    'username'          => 'kasi2',
                    'email'             => 'kasi2@gmail.com',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('kasi1'),
                ]);
                $kasi->assignRole('Kasi');
                $staff = User::create([
                    'name'              => 'Staff',
                    'username'          => 'staff',
                    'email'             => 'staff@gmail.com',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('staff'),
                ]);
                $staff->assignRole('Staff');
            } catch (\Throwable $e) {
                throw $e;
            }
        });
    }
}
