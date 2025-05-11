<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiswaKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Kelas
        DB::table('kelas')->insert([
            ['nama_kelas' => 'XI PPLG 1', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kelas' => 'XI PPLG 2', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kelas' => 'XI PPLG 3', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed Siswa
        DB::table('siswa')->insert(collect(range(1, 10))->map(function ($i) {
            return [
                'nisn' => 'NISN' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'nama' => 'Siswa ' . $i,
                'jk' => $i % 2 == 0 ? 'L' : 'P',
                'kelas_id' => rand(1, 3),
                'foto' => 'default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray());
    }
}
