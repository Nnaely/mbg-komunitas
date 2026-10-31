<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            [
                'name' => 'SDN 035 Soka',
                'address' => 'Jl. Soka No. 34, Merdeka, Kec. Sumur Bandung, Kota Bandung, Jawa Barat',
                'previous_name' => 'SD Fiktif MBG 01',
            ],
            [
                'name' => 'SMP Negeri 2 Bandung',
                'address' => 'Jl. Sumatera No. 42, Merdeka, Kec. Sumur Bandung, Kota Bandung, Jawa Barat',
                'previous_name' => 'SMP Fiktif MBG 02',
            ],
            [
                'name' => 'SMAN 3 Bandung',
                'address' => 'Jl. Belitung No. 8, Merdeka, Kec. Sumur Bandung, Kota Bandung, Jawa Barat',
                'previous_name' => 'SMA Fiktif MBG 03',
            ],
        ];

        foreach ($schools as $schoolData) {
            $school = School::where('name', $schoolData['previous_name'])->first()
                ?? School::firstOrNew(['name' => $schoolData['name']]);

            $school->name = $schoolData['name'];
            $school->address = $schoolData['address'];
            $school->save();
        }
    }
}
