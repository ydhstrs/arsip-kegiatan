<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Letter;

class LetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Letter::create([
            'uuid'          => '9e6-04af-4b4a-8c48-52e8556385a5',
            'no'            => 'AB/123/Des-2025',
            'desc'          => 'Laporan perbaikan fasilitas umum sektor 1212',
            'file'          => 'letters/69233cf121cc.png',
            'source'        => '21212',
            'remark'        => null,
            'status'        => 'Proses Staff',
            'remark_kasi'   => 'qwqwqw',
            'remark_kabid'  => '12121212',
            'kabid_user_id' => 0,
            'kasi_user_id'  => 5,
            'staff_user_id' => 6,
            'created_at'    => '2025-11-23 16:57:23',
            'updated_at'    => '2025-11-23 17:58:26',
        ]);
    }
}
