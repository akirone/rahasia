<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Fasilitas Kelas'],
            ['nama' => 'Kebersihan'],
            ['nama' => 'Laboratorium'],
            ['nama' => 'Perpustakaan'],
            ['nama' => 'Toilet'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
