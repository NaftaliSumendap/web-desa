<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Aparatur;
use App\Models\VillageProfile;
use App\Models\Gallery;

class PageController extends Controller
{
    /**
     * Menampilkan halaman Home (Beranda).
     */
    public function home()
    {
        $latestPosts = Post::select('id', 'judul', 'isi_berita', 'gambar', 'created_at')
                            ->latest()
                            ->take(3)
                            ->get();

        $kepalaDesa = Aparatur::where('jabatan', 'Kepala Desa')
                            ->firstOrNew(
                                [
                                    'nama_lengkap' => '[Nama Kades Belum Diisi]',
                                    'foto' => null
                                ]
                            );

        $aparaturList = Aparatur::where('jabatan', '!=', 'Kepala Desa')
                                ->orderBy('urutan', 'asc')
                                ->take(4)
                                ->get();
        
        return view('home', [
            'latestPosts' => $latestPosts,
            'kepalaDesa' => $kepalaDesa,
            'aparaturList' => $aparaturList
        ]);
    }

    /**
     * Menampilkan halaman Profil Desa.
     */
    public function profil()
    {
        // Data $desa (dari VillageProfile) sudah dibagikan secara global
        
        // --- Ambil data aparatur untuk bagan organisasi ---
        $semuaAparatur = Aparatur::orderBy('urutan', 'asc')->get();

        $data = [
            'kepalaDesa' => $semuaAparatur->where('jabatan', 'Kepala Desa')->first(),
            'sekretaris' => $semuaAparatur->where('jabatan', 'Sekretaris Desa')->first(),
            'kasiKesejahteraan' => $semuaAparatur->where('jabatan', 'Kepala Seksi Kesejahteraan dan Pelayanan')->first(),
            'kasiPemerintahan' => $semuaAparatur->where('jabatan', 'Kepala Seksi Pemerintahan')->first(),
            'kaurUmum' => $semuaAparatur->where('jabatan', 'Kaur Umum dan Perencanaan')->first(),
            'kaurKeuangan' => $semuaAparatur->where('jabatan', 'Kaur Keuangan')->first(),
            'kadusElo' => $semuaAparatur->where('jabatan', 'Kepala Dusun Pada Elo')->first(),
            'kadusEmpang' => $semuaAparatur->where('jabatan', 'Kepala Dusun Empang')->first(),
            
            'stafKasiKesejahteraan' => $semuaAparatur->where('parent_id', $semuaAparatur->where('jabatan', 'Kepala Seksi Kesejahteraan dan Pelayanan')->first()->id ?? null),
            'stafKasiPemerintahan' => $semuaAparatur->where('parent_id', $semuaAparatur->where('jabatan', 'Kepala Seksi Pemerintahan')->first()->id ?? null),
            'stafKaurUmum' => $semuaAparatur->where('parent_id', $semuaAparatur->where('jabatan', 'Kaur Umum dan Perencanaan')->first()->id ?? null),
            'stafKaurKeuangan' => $semuaAparatur->where('parent_id', $semuaAparatur->where('jabatan', 'Kaur Keuangan')->first()->id ?? null),

            'galeriAparatur' => $semuaAparatur->whereIn('jabatan', [
                'Kaur Keuangan', 'Kepala Seksi Kesejahteraan dan Pelayanan', 'Kaur Umum dan Perencanaan', 'Kepala Seksi Pemerintahan'
            ])
        ];
        // --- Akhir pengambilan data aparatur ---

        // Kirim $data ke view 'profil'
        return view('profil', $data); 
    }

    /**
     * Menampilkan halaman Galeri.
     */
    public function galeri()
    {
        $photos = Gallery::latest()->paginate(12);
        return view('galeri', compact('photos'));
    }

    /**
     * Menampilkan halaman Berita (Publik).
     */
    public function berita()
    {
        $posts = Post::latest()->paginate(9); 
        return view('berita', compact('posts'));
    }

    /**
     * Menampilkan halaman Struktur Organisasi.
     */
    public function struktur()
    {
        $semuaAparatur = Aparatur::orderBy('urutan', 'asc')->get();

        $data = [
            'kepalaDesa' => $semuaAparatur->where('jabatan', 'Kepala Desa')->first(),
            'sekretaris' => $semuaAparatur->where('jabatan', 'Sekretaris Desa')->first(),
            'kasiKesejahteraan' => $semuaAparatur->where('jabatan', 'Kepala Seksi Kesejahteraan dan Pelayanan')->first(),
            // --- PERBAIKAN DI SINI ---
            // Mengubah 'kasiPintahan' menjadi 'kasiPemerintahan'
            'kasiPemerintahan' => $semuaAparatur->where('jabatan', 'Kepala Seksi Pemerintahan')->first(),
            'kaurUmum' => $semuaAparatur->where('jabatan', 'Kaur Umum dan Perencanaan')->first(),
            'kaurKeuangan' => $semuaAparatur->where('jabatan', 'Kaur Keuangan')->first(),
            'kadusElo' => $semuaAparatur->where('jabatan', 'Kepala Dusun Pada Elo')->first(),
            'kadusEmpang' => $semuaAparatur->where('jabatan', 'Kepala Dusun Empang')->first(),
            
            'stafKasiKesejahteraan' => $semuaAparatur->where('parent_id', $semuaAparatur->where('jabatan', 'Kepala Seksi Kesejahteraan dan Pelayanan')->first()->id ?? null),
            'stafKasiPemerintahan' => $semuaAparatur->where('parent_id', $semuaAparatur->where('jabatan', 'Kepala Seksi Pemerintahan')->first()->id ?? null),
            'stafKaurUmum' => $semuaAparatur->where('parent_id', $semuaAparatur->where('jabatan', 'Kaur Umum dan Perencanaan')->first()->id ?? null),
            'stafKaurKeuangan' => $semuaAparatur->where('parent_id', $semuaAparatur->where('jabatan', 'Kaur Keuangan')->first()->id ?? null),

            'galeriAparatur' => $semuaAparatur->whereIn('jabatan', [
                'Kaur Keuangan', 'Kepala Seksi Kesejahteraan dan Pelayanan', 'Kaur Umum dan Perencanaan', 'Kepala Seksi Pemerintahan'
            ])
        ];

        return view('struktur', $data);
    }

    /**
     * METHOD BARU: Menampilkan halaman detail berita.
     */
    public function showBerita(Post $post)
    {
        // $post akan otomatis diambil oleh Laravel berdasarkan ID/slug di URL
        
        // Ambil 3 berita lain sebagai "Berita Terkait"
        $beritaTerkait = Post::where('id', '!=', $post->id)
                                ->latest()
                                ->take(3)
                                ->get();

        // Kita akan membuat view 'berita-show.blade.php' nanti
        return view('berita-show', [
            'post' => $post,
            'beritaTerkait' => $beritaTerkait
        ]);
    }
}