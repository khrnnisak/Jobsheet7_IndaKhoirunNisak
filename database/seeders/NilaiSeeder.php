<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nilai = [
            [
                'matakuliah_id' => 1,
                'mahasiswa_id' => 1,
                'nilai' => 90,
            ],
            [
                'matakuliah_id' => 2,
                'mahasiswa_id' => 1,
                'nilai' => 87,
            ],
            [
                'matakuliah_id' => 3,
                'mahasiswa_id' => 1,
                'nilai' => 88,
            ],
            [
                'matakuliah_id' => 4,
                'mahasiswa_id' => 1,
                'nilai' => 90,
            ],
            [
                'matakuliah_id' => 1,
                'mahasiswa_id' => 2,
                'nilai' => 80,
            ],
            [
                'matakuliah_id' => 2,
                'mahasiswa_id' => 2,
                'nilai' => 75,
            ],
            [
                'matakuliah_id' => 3,
                'mahasiswa_id' => 2,
                'nilai' => 89,
            ],
            [
                'matakuliah_id' => 4,
                'mahasiswa_id' => 2,
                'nilai' => 88,
            ],
        ];
        DB::table('mahasiswa_matakuliah')->insert($nilai);
    
    }
}
