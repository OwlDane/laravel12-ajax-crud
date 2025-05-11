<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        // cara menggil session
        $nama_user = session('nama_user');
        $email = session('detail.email');

        $data = [
            'title' => 'Halaman Login',
            'nama_user' => $nama_user,
            'email' => $email,
        ];
        return view('pages.dashboard', $data);
    }

    // Menampilkan halaman siswa
    public function siswaPage()
    {
        $data = [
            'title' => 'Siswa',
            'url_json' => route('siswa.json_data'),
            'breadcrumb' => [
                [
                    'name' => 'Siswa',
                    'url' => route('siswa'),
                    'active' => true,
                ],
            ]
        ];
        return view('pages.siswa', $data);
    }

    // Mendapatkan data siswa untuk DataTable AJAX
    public function getData()
    {
        $siswas = Siswa::with('kelas')->get();
        $data = [];
        $no = 1;
        foreach ($siswas as $item) {
            $data[] = [
                $no++,
                $item->nisn,
                $item->nama,
                $item->jk == 'L' ? 'Laki-laki' : 'Perempuan',
                optional($item->kelas)->nama_kelas,
                '<img src="' . asset('uploads/foto/' . $item->foto) . '" width="40"/>',
                '<a class="btn btn-warning btn-sm" onclick="editSiswa(' . $item->id . ')">Edit</a> <a class="btn btn-danger btn-sm" onclick="deleteSiswa(' . $item->id . ')">Hapus</a>'
            ];
        }
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Data siswa berhasil ditemukan',
        ], 200, ['Content-Type' => 'application/json; charset=utf-8'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    // Store siswa (AJAX)
    public function insertData(Request $request)
    {
        $request->validate([
            'nisn' => 'required|unique:siswa,nisn',
            'nama' => 'required',
            'jk' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $data = $request->only(['nisn', 'nama', 'jk', 'kelas_id']);
        $data['foto'] = 'default.jpg';
        
        $siswa = Siswa::create($data);

        return response()->json([
            'status' => true,
            'data' => $siswa,
            'message' => 'Data siswa berhasil ditambahkan',
        ], 200);
    }

    // Update siswa (AJAX)
    public function updateData(Request $request, $siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);
        
        $request->validate([
            'nisn' => 'required|unique:siswa,nisn,' . $siswa_id,
            'nama' => 'required',
            'jk' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa->update($request->only(['nisn', 'nama', 'jk', 'kelas_id']));

        return response()->json([
            'status' => true,
            'data' => $siswa,
            'message' => 'Data siswa berhasil diperbarui',
        ], 200);
    }

    // Delete siswa (AJAX)
    public function deleteData(Request $request, $siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);
        $siswa->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data siswa berhasil dihapus',
        ], 200);
    }
}
