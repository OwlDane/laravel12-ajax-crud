<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa'; // nama tabel

    protected $primaryKey = 'id'; // primary key tabel

    protected $keyType = 'int'; // tipe primary key

    protected $fillable = [ // kolom yang boleh dimanipulasi
        'nisn',
        'nama',
        'jk',
        'kelas_id',
        'foto',
    ];

    public $timestamps = true; // menjalankan timestamps untuk pengaturan waktu tabel setiap create dan update

    public static function getJmlSiswa()
    {
        return Siswa::count(); // dengan eloquent
    }

    public function kelas()
    {
        return $this->belongsTo(\App\Models\Kelas::class, 'kelas_id');
    }
}
