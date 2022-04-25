<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Matakuliah;

class Matakuliah extends Model
{
    protected $primaryKey = 'id'; // Memanggil isi DB Dengan primarykey
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'NamaMatkul',
            'SKS',
            'Semester',
        ];
    
        public function mahasiswa(){
            return $this->belongsToMany(Mahasiswa::class);
        }
        public function mahasiswa_matakuliah(){
            return $this->belongsToMany(Mahasiswa_Matakuliah::class);
        }
}
