<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserRoleMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_existing_users_receive_the_default_role_without_data_loss(): void
    {
        $migration = require database_path('migrations/2026_10_30_000003_add_role_to_users_table.php');
        $migration->down();

        $user = User::factory()->create();
        $originalAttributes = $user->fresh()->getRawOriginal();

        $migration->up();

        $storedAttributes = $user->fresh()->getRawOriginal();
        $this->assertSame('pelapor', $storedAttributes['role']);

        unset($storedAttributes['role']);

        $this->assertSame($originalAttributes, $storedAttributes);
    }

    public function test_role_migration_can_be_rolled_back_without_deleting_users(): void
    {
        $user = User::factory()->create();
        $originalAttributes = $user->fresh()->getRawOriginal();
        unset($originalAttributes['role']);

        $migration = require database_path('migrations/2026_10_30_000003_add_role_to_users_table.php');
        $migration->down();

        $this->assertFalse(Schema::hasColumn('users', 'role'));
        $this->assertSame($originalAttributes, $user->fresh()->getRawOriginal());
    }
}
