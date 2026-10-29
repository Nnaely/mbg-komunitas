<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            ['name' => 'SD Fiktif MBG 01', 'address' => 'Jalan Simulasi Nomor 1, Kota Contoh'],
            ['name' => 'SMP Fiktif MBG 02', 'address' => 'Jalan Simulasi Nomor 2, Kota Contoh'],
            ['name' => 'SMA Fiktif MBG 03', 'address' => 'Jalan Simulasi Nomor 3, Kota Contoh'],
        ];

        foreach ($schools as $school) {
            School::firstOrCreate($school);
        }
    }
}
