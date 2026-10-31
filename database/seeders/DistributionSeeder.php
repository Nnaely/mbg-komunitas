<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class DistributionSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            ['name' => 'SDN 035 Soka', 'address' => 'Jl. Soka No. 34, Merdeka, Kec. Sumur Bandung, Kota Bandung, Jawa Barat'],
            ['name' => 'SMP Negeri 2 Bandung', 'address' => 'Jl. Sumatera No. 42, Merdeka, Kec. Sumur Bandung, Kota Bandung, Jawa Barat'],
            ['name' => 'SMAN 3 Bandung', 'address' => 'Jl. Belitung No. 8, Merdeka, Kec. Sumur Bandung, Kota Bandung, Jawa Barat'],
        ];

        $menus = [
            '2026-10-28' => [
                'description' => 'Menu simulasi: nasi, tempe, sayur bayam, dan pisang',
                'previous_description' => 'Nasi, tempe, sayur bayam, dan pisang (data fiktif)',
            ],
            '2026-10-29' => [
                'description' => 'Menu simulasi: nasi, telur, sayur wortel, dan jeruk',
                'previous_description' => 'Nasi, telur, sayur wortel, dan jeruk (data fiktif)',
            ],
        ];

        foreach ($schools as $schoolData) {
            $school = School::where($schoolData)->firstOrFail();

            foreach ($menus as $date => $menu) {
                $school->distributions()
                    ->whereDate('distribution_date', $date)
                    ->where('menu_description', $menu['previous_description'])
                    ->update(['menu_description' => $menu['description']]);

                $school->distributions()->firstOrCreate(
                    ['distribution_date' => $date],
                    ['menu_description' => $menu['description']],
                );
            }
        }
    }
}
