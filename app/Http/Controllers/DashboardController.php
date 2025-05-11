<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// panggil model
use App\Models\Kelas;
use App\Models\Siswa;

class DashboardController extends Controller
{
    // Menampilkan dashboard
    public function index()
    {

        // cara menggil session
        $nama_user = session('nama_user');
        $email = session('detail.email');

        // parameter data yg ingin di kirim ke view
        $data = [
            'title' => 'Dashboard',
            'nama_user' => $nama_user,
            'email' => $email,
            'jml_kelas' => Kelas::getJmlKelas(),
            'jml_siswa' => Siswa::getJmlSiswa(),
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'url' => route('dashboard'),
                    'active' => true,
                ],
            ]
        ];
        return view('pages.dashboard', $data);
    }
}
