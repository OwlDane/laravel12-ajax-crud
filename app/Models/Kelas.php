<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // jika perlu query builder tanpa eloquent

class Kelas extends Model
{
    protected $table = 'kelas'; // nama tabel

    protected $primaryKey = 'id'; // primary key tabel

    protected $keyType = 'int'; // tipe primary key

    protected $fillable = [ // kolom yang boleh dimanipulasi
        'nama_kelas',
        'status',
    ];

    public $timestamps = true; // menjalankan timestamps untuk pengaturan waktu tabel setiap create dan update

    public static function getJmlKelas()
    {
        return DB::table('kelas')->count(); // dengan query builder
    }

    public static function getKelas()
    {
        // query menampilkan data kelas hanya kolom id, nama_kelas, dan status. Lalu di urutkan nama_kelas berdasarkan asc
        // DB::table => query builder (mungkin sewaktu kita butuh query builder ketimbang eloquent)
        $query = DB::table('kelas AS a')
                        ->selectRaw("a.id, a.nama_kelas, a.status")
                        ->orderBy('a.nama_kelas', 'asc')
                        ->get();

        return $query;
    }

    public static function getKelasById($id)
    {
        $query = DB::table('kelas AS a')
                        ->select("a.id, a.nama_kelas, a.status")
                        ->where('a.id', $id)
                        ->first();

        return $query;
    }

    public static function insertKelas($data)
    {
        DB::table('kelas')->insert($data);
    }

    public static function updateKelas($data, $id)
    {
        DB::table('kelas')->where('id', $id)->update($data);
    }

    public static function deleteKelas($id)
    {
        DB::table('kelas')->where('id', $id)->delete();
    }
}
