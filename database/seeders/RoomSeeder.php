<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            try {
                Room::create([
                    'name' => 'Kamar 101',
                    'type' => 'Normal',
                    'floor' => '1',
                    'price' => '350000',
                ]);
                Room::create([
                    'name' => 'Kamar 202',
                    'type' => 'Normal',
                    'floor' => '2',
                    'price' => '300000',
                ]);
                Room::create([
                    'name' => 'Kamar 102',
                    'type' => 'Normal',
                    'floor' => '1',
                    'price' => '350000',
                ]);
                Room::create([
                    'name' => 'Kamar 301',
                    'type' => 'Normal',
                    'floor' => '3',
                    'price' => '350000',
                ]);
                Room::create([
                    'name' => 'Kamar 103',
                    'type' => 'Normal',
                    'floor' => '1',
                    'price' => '350000',
                ]);
                Room::create([
                    'name' => 'Kamar 104',
                    'type' => 'Normal',
                    'floor' => '1',
                    'price' => '380000',
                ]);
            } catch (\Throwable $e) {
                throw $e;
            }
        });
    }
}
