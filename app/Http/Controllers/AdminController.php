<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Aparatur; // <-- Pastikan model ini ada
// use App\Models\Gallery; 

class AdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin.
     */
    public function dashboard()
    {
        // Ambil data untuk statistik
        $jumlahBerita = Post::count();
        $jumlahFoto = 0; // Ganti 0 dengan: Gallery::count();
        $jumlahAparatur = Aparatur::count(); // <-- Hitung aparatur
        
        // Ambil 5 aparatur terbaru
        $aparaturTerbaru = Aparatur::latest()->take(5)->get();

        // Kirim data ke view
        return view('admin.dashboard', [
            'jumlahBerita' => $jumlahBerita,
            'jumlahFoto' => $jumlahFoto,
            'jumlahAparatur' => $jumlahAparatur,
            'aparaturTerbaru' => $aparaturTerbaru, // <-- Kirim data baru
        ]);
    }
}

