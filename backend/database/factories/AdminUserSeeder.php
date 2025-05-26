<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'username' => 'admin',
            'nama' => 'Super Admin',
            'password' => Hash::make('12345678'),
        ]);
    }
}
