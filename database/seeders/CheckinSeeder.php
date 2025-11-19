<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CheckinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key checks sementara
        Schema::disableForeignKeyConstraints();

        // Hapus data lama
        DB::table('checkins')->truncate();

        // Data dummy
        $data = [
            [
                'transaction_no' => 'CI/11/2024/0001',
                'guest_name' => 'John Doe',
                'guest_job' => 'Software Engineer',
                'marital_status' => 'Single',
                'idcard_no' => '1234567890',
                'born_place' => 'New York',
                'duration' => 2,
                'birth_date' => '1990-01-01',
                'transaction_date' => Carbon::today()->toDateString(),
                'checkin_date' => Carbon::today()->toDateString(),
                'room_id' => 1,
                'user_id' => 1,
                'room_price' => 250000.00,
                'amount' => 500000.00,
                'idcard_image' => null,
                'guest_image' => null,
                'remark' => 'First-time checkin',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'transaction_no' => 'CI/11/2024/0002',
                'guest_name' => 'Jane Smith',
                'guest_job' => 'Teacher',
                'marital_status' => 'Married',
                'idcard_no' => '0987654321',
                'born_place' => 'Los Angeles',
                'duration' => 1,
                'birth_date' => '1985-05-15',
                'transaction_date' => Carbon::today()->toDateString(),
                'checkin_date' => Carbon::today()->toDateString(),
                'room_id' => 2,
                'user_id' => 1,
                'room_price' => 750000.00,
                'amount' => 750000.00,
                'idcard_image' => null,
                'guest_image' => null,
                'remark' => 'Returning customer',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert data
        DB::table('checkins')->insert($data);

        // Aktifkan kembali foreign key checks
        Schema::enableForeignKeyConstraints();
    }
}
