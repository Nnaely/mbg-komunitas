<?php

namespace Tests\Feature;

use App\Models\Distribution;
use App\Models\School;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DistributionTest extends TestCase
{
    use RefreshDatabase;

    public function test_distribution_can_be_saved_and_read_with_its_school(): void
    {
        $school = School::create([
            'name' => 'SD Fiktif Pengujian Distribusi',
            'address' => 'Jalan Simulasi Nomor 1, Kota Contoh',
        ]);
        $otherSchool = School::create([
            'name' => 'SMP Fiktif Pengujian Distribusi',
            'address' => 'Jalan Simulasi Nomor 2, Kota Contoh',
        ]);

        $distribution = Distribution::create([
            'school_id' => $school->id,
            'distribution_date' => '2026-10-30',
            'menu_description' => 'Nasi, tempe, dan sayur (data fiktif)',
        ]);
        $secondDistribution = $school->distributions()->create([
            'distribution_date' => '2026-10-31',
            'menu_description' => 'Nasi, telur, dan buah (data fiktif)',
        ]);

        $storedDistribution = Distribution::with('school')->findOrFail($distribution->id);

        $this->assertSame('2026-10-30', $storedDistribution->distribution_date->format('Y-m-d'));
        $this->assertSame('Nasi, tempe, dan sayur (data fiktif)', $storedDistribution->menu_description);
        $this->assertTrue($storedDistribution->school->is($school));
        $this->assertSame(
            [$distribution->id, $secondDistribution->id],
            $school->distributions()->orderBy('id')->pluck('id')->all(),
        );
        $this->assertFalse($otherSchool->distributions()->exists());
    }

    public function test_distribution_cannot_reference_a_missing_school(): void
    {
        try {
            Distribution::create([
                'school_id' => 999,
                'distribution_date' => '2026-10-30',
                'menu_description' => 'Menu simulasi',
            ]);

            $this->fail('Distribusi dengan sekolah yang tidak tersedia harus ditolak.');
        } catch (QueryException $exception) {
            $this->assertSame('23000', (string) $exception->getCode());
        }

        $this->assertDatabaseCount('distributions', 0);
    }

    public function test_school_with_distributions_cannot_be_deleted(): void
    {
        $school = School::create([
            'name' => 'SD Fiktif Uji Integritas',
            'address' => 'Jalan Simulasi, Kota Contoh',
        ]);
        $distribution = $school->distributions()->create([
            'distribution_date' => '2026-10-30',
            'menu_description' => 'Menu simulasi',
        ]);

        try {
            $school->delete();

            $this->fail('Sekolah yang memiliki distribusi harus tetap tersimpan.');
        } catch (QueryException $exception) {
            $this->assertSame('23000', (string) $exception->getCode());
        }

        $this->assertDatabaseHas('schools', ['id' => $school->id]);
        $this->assertDatabaseHas('distributions', [
            'id' => $distribution->id,
            'school_id' => $school->id,
        ]);
    }

    public function test_distribution_seeder_can_be_repeated_without_changing_other_data(): void
    {
        $otherSchool = School::create([
            'name' => 'Sekolah Fiktif Lain',
            'address' => 'Jalan Simulasi Lain, Kota Contoh',
        ]);
        $otherDistribution = $otherSchool->distributions()->create([
            'distribution_date' => '2026-10-27',
            'menu_description' => 'Menu simulasi sekolah lain',
        ]);

        $this->seed(DatabaseSeeder::class);
        $originalIds = Distribution::orderBy('id')->pluck('id')->all();

        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('schools', 4);
        $this->assertDatabaseCount('distributions', 7);
        $this->assertSame($originalIds, Distribution::orderBy('id')->pluck('id')->all());

        foreach (School::where('id', '!=', $otherSchool->id)->get() as $school) {
            $this->assertSame(2, $school->distributions()->count());
        }

        $this->assertSame([$otherDistribution->id], $otherSchool->distributions()->pluck('id')->all());
        $this->assertSame('Menu simulasi sekolah lain', $otherDistribution->fresh()->menu_description);
    }
}
