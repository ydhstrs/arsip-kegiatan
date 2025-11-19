<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction; // Pastikan model sudah sesuai dengan nama model Anda
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $transactions = [
            ['CI/11/2024/0001', 'John Doe', 'Checkin', 1, '2024-01-22', 500000],
            ['CI/11/2024/0002', 'Jane Smith', 'Checkin', 2, '2024-02-22', 750000],
            ['B/11/2024/0001', 'John Doe', 'Bill', 1, '2024-03-23', 350000],
            ['B/11/2024/0002', 'Jane Smith', 'Bill', 2, '2024-04-23', 300000],
            ['B/11/2024/0005', 'John Doe', 'Bill', 1, '2024-05-23', 350000],
            ['B/11/2024/0006', 'John Doe', 'Bill', 1, '2024-06-29', 350000],
            ['PAY/11/2024/0007', null, 'Paying', 0, '2024-07-23', 1000],
            ['BUY/11/2024/0008', null, 'Buying', 0, '2024-08-23', 111],
            ['BUY/11/2024/0009', null, 'Buying', 0, '2024-09-23', 111],
            ['BUY/11/2024/0010', 'Anna Doe', 'Buying', 0, '2024-10-23', 200],
            ['PAY/11/2024/0011', 'Jane Smith', 'Paying', 1, '2024-11-23', 1200],
            ['CI/11/2024/0012', 'John Doe', 'Checkin', 1, '2024-12-22', 600000],
            ['B/11/2024/0013', 'John Doe', 'Bill', 1, '2025-01-22', 370000],
            ['CI/11/2024/0014', 'Anna Doe', 'Checkin', 2, '2025-02-20', 800000],
            ['BUY/11/2024/0015', null, 'Buying', 0, '2025-03-22', 150],
            ['PAY/11/2024/0016', null, 'Paying', 0, '2025-04-22', 250],
            ['B/11/2024/0017', 'Jane Smith', 'Bill', 2, '2025-05-23', 320000],
            ['BUY/11/2024/0018', null, 'Buying', 0, '2025-06-23', 175],
            ['PAY/11/2024/0019', 'Anna Doe', 'Paying', 1, '2025-07-23', 450],
            ['CI/11/2024/0020', 'John Doe', 'Checkin', 1, '2025-08-23', 650000],
        ];

        foreach ($transactions as $index => $data) {
            Transaction::create([
                'transaction_no' => $data[0],
                'guest_name' => $data[1],
                'transaction_type' => $data[2],
                'room_id' => $data[3],
                'date' => $data[4],
                'amount' => $data[5],
                'created_by' => 1, // Sesuaikan jika ada relasi dengan user
                'created_at' => Carbon::parse($data[4])->subMinutes($index * 5),
                'updated_at' => Carbon::parse($data[4])->subMinutes($index * 5),
            ]);
        }
    }
}
