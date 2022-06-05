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
                'mahasiswa_id' => 1,
                'matakuliah_id' => 1,
                'nilai' => 90,
            ],
            [
                'mahasiswa_id' => 1,
                'matakuliah_id' => 2,
                'nilai' => 87,
            ],
            [
                'mahasiswa_id' => 1,
                'matakuliah_id' => 3,
                'nilai' => 88,
            ],
            [
                
                'mahasiswa_id' => 1,
                'matakuliah_id' => 4,
                'nilai' => 90,
            ],
            [
                
                'mahasiswa_id' => 2,
                'matakuliah_id' => 1,
                'nilai' => 80,
            ],
            [
                
                'mahasiswa_id' => 2,
                'matakuliah_id' => 2,
                'nilai' => 75,
            ],
            [

                'mahasiswa_id' => 2,
                'matakuliah_id' => 3,
                'nilai' => 89,
            ],
            [
                
                'mahasiswa_id' => 2,
                'matakuliah_id' => 4,
                'nilai' => 88,
            ],
        ];
        DB::table('mahasiswa_matakuliah')->insert($nilai);
    
    }
}
