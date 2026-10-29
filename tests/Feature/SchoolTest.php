<?php

namespace Tests\Feature;

use App\Models\School;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\SchoolSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolTest extends TestCase
{
    use RefreshDatabase;

    public function test_school_can_be_saved_and_read_from_the_database(): void
    {
        $school = School::create([
            'name' => 'SD Fiktif Pengujian',
            'address' => 'Jalan Uji Nomor 1, Kota Contoh',
        ]);

        $storedSchool = School::findOrFail($school->id);

        $this->assertSame('SD Fiktif Pengujian', $storedSchool->name);
        $this->assertSame('Jalan Uji Nomor 1, Kota Contoh', $storedSchool->address);
        $this->assertNotNull($storedSchool->created_at);
        $this->assertNotNull($storedSchool->updated_at);
    }

    public function test_school_seeder_can_be_repeated_without_duplicate_data(): void
    {
        $this->seed(SchoolSeeder::class);
        $originalIds = School::orderBy('id')->pluck('id')->all();

        $this->seed(SchoolSeeder::class);

        $this->assertDatabaseCount('schools', 3);
        $this->assertSame($originalIds, School::orderBy('id')->pluck('id')->all());
        $this->assertDatabaseHas('schools', [
            'name' => 'SD Fiktif MBG 01',
            'address' => 'Jalan Simulasi Nomor 1, Kota Contoh',
        ]);
    }

    public function test_default_seeder_loads_schools_without_creating_accounts(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('schools', 3);
        $this->assertDatabaseCount('users', 0);
    }
}
