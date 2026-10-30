<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_receive_the_pelapor_role_by_default(): void
    {
        $user = User::factory()->create();

        $this->assertSame('pelapor', $user->fresh()->role);
    }

    public function test_all_three_supported_roles_can_be_saved(): void
    {
        foreach (['pelapor', 'pemantau', 'koordinator'] as $role) {
            $user = User::factory()->make();
            $user->role = $role;
            $user->save();

            $this->assertDatabaseHas('users', [
                'id' => $user->id,
                'role' => $role,
            ]);
        }
    }

    public function test_unsupported_roles_are_rejected_by_the_database(): void
    {
        $this->assertTrue(Schema::hasColumn('users', 'role'));

        $user = User::factory()->make();
        $user->role = 'admin';

        $this->expectException(QueryException::class);

        $user->save();
    }
}
