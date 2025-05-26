<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition()
    {
        $roles = ['admin', 'siswa', 'guru'];
        
        return [
            'id_user' => $this->faker->unique()->randomNumber(8),
            'nik' => $this->faker->unique()->numerify('#############'),
            'nama' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'password' => Hash::make('12345678'), // Default password
            'role' => $this->faker->randomElement($roles),
            'face_encoding' => $this->faker->text(200),
            'no_hp_siswa' => $this->faker->phoneNumber,
            'kelas_id' => Kelas::factory(),
            'foto' => 'users/' . $this->faker->image('public/storage/users', 200, 200, null, false),
            'nama_ortu' => $this->faker->name,
            'no_hp_ortu' => $this->faker->phoneNumber,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null
        ];
    }

    public function admin()
    {
        return $this->state([
            'role' => 'admin',
        ]);
    }

    public function siswa()
    {
        return $this->state([
            'role' => 'siswa',
            'kelas_id' => $this->faker->numberBetween(1, 12),
        ]);
    }

    public function guru()
    {
        return $this->state([
            'role' => 'guru',
            'kelas_id' => null,
        ]);
    }
}
