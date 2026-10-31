<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            [
                'name' => 'Pelapor Demo',
                'email' => 'pelapor@mbg.test',
                'role' => User::ROLE_PELAPOR,
            ],
            [
                'name' => 'Pemantau Demo',
                'email' => 'pemantau@mbg.test',
                'role' => User::ROLE_PEMANTAU,
            ],
            [
                'name' => 'Koordinator Demo',
                'email' => 'koordinator@mbg.test',
                'role' => User::ROLE_KOORDINATOR,
            ],
        ];

        foreach ($accounts as $account) {
            $user = User::firstOrNew(['email' => $account['email']]);
            $user->name = $account['name'];
            $user->role = $account['role'];
            $user->password = 'password';
            $user->save();
        }
    }
}
