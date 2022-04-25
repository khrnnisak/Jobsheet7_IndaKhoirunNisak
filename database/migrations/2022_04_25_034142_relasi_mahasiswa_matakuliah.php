<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelasiMahasiswaMatakuliah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->unsignedBigInteger('mahasiswa_id')->nullable();
            $table->foreign('mahasiswa_id')->references('id_mahasiswa')->on('mahasiswa');
            $table->unsignedBigInteger('matakuliah_id')->nullable();
            $table->foreign('matakuliah_id')->references('id')->on('matakuliah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mahasiswa', function (Blueprint $table){
            $table->dropForeign(['mahasiswa_id']);
            $table->dropForeign(['matakuliah_id']);
        });
    }
}
