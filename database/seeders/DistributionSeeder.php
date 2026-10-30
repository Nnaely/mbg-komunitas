<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class DistributionSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            ['name' => 'SD Fiktif MBG 01', 'address' => 'Jalan Simulasi Nomor 1, Kota Contoh'],
            ['name' => 'SMP Fiktif MBG 02', 'address' => 'Jalan Simulasi Nomor 2, Kota Contoh'],
            ['name' => 'SMA Fiktif MBG 03', 'address' => 'Jalan Simulasi Nomor 3, Kota Contoh'],
        ];

        $menus = [
            '2026-10-28' => 'Nasi, tempe, sayur bayam, dan pisang (data fiktif)',
            '2026-10-29' => 'Nasi, telur, sayur wortel, dan jeruk (data fiktif)',
        ];

        foreach ($schools as $schoolData) {
            $school = School::where($schoolData)->firstOrFail();

            foreach ($menus as $date => $menu) {
                $school->distributions()
                    ->whereDate('distribution_date', $date)
                    ->firstOrCreate(
                        ['menu_description' => $menu],
                        ['distribution_date' => $date],
                    );
            }
        }
    }
}
