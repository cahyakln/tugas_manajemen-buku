<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@manajemenbuku.test',
                'password' => 'Admin12345',
                'role' => 'Admin',
            ],
            [
                'name' => 'Dosen Penguji',
                'email' => 'dosen@manajemenbuku.test',
                'password' => 'Dosen12345',
                'role' => 'Dosen',
            ],
            [
                'name' => 'Mahasiswa Penguji',
                'email' => 'mahasiswa@manajemenbuku.test',
                'password' => 'Mhs12345',
                'role' => 'Mahasiswa',
            ],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => $data['password'],
                ]
            );

            $user->syncRoles([$data['role']]);
        }
    }
}

