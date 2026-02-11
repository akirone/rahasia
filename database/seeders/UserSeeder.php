<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Giero',
            'email' => 'admin@app.com',
            'password' => Hash::make('admin123'),
            'nis' => null,
            'kelas' => null,
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Garen',
            'email' => 'siswa@app.com',
            'password' => Hash::make('siswa123'),
            'nis' => '0076622257',
            'kelas' => 'XII RPL',
            'is_admin' => false,
        ]);

        User::create([
            'name' => 'Axeno',
            'email' => 'siswa2@app.com',
            'password' => Hash::make('siswa123'),
            'nis' => '0076622258',
            'kelas' => 'XII RPL',
            'is_admin' => false,
        ]);
    }
}
