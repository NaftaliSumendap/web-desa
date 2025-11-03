<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Aparatur;
use App\Models\VillageProfile;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB; // <-- Digunakan untuk pencarian case-insensitive

class PageController extends Controller
{
    /**
     * Menampilkan halaman Home (Beranda).
     */
    public function home()
    {
        // Kode debugging telah dihapus.
        
        $latestPosts = Post::select('id', 'judul', 'isi_berita', 'gambar', 'created_at')
                            ->latest()
                            ->take(3)
                            ->get();

        // Mencari 'Kepala Desa' ATAU 'Hukum Tua' (case-insensitive)
        $kepalaDesa = Aparatur::whereIn(DB::raw('LOWER(jabatan)'), ['kepala desa', 'hukum tua'])
                            ->orderBy('urutan', 'asc')
                            ->firstOrNew(
                                [
                                    'nama_lengkap' => '[Nama Kades Belum Diisi]',
                                    'foto' => null
                                ]
                            );

        // Mengambil 4 aparatur selain Kades/Hukum Tua (case-insensitive)
        $aparaturList = Aparatur::whereNotIn(DB::raw('LOWER(jabatan)'), ['kepala desa', 'hukum tua'])
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
     * Helper function untuk mengambil staf berdasarkan ID atasan
     */
    private function getStafByParentId($parentId)
    {
        if (is_null($parentId)) {
            return collect();
        }
        return Aparatur::where('parent_id', $parentId)->orderBy('urutan')->get();
    }

    /**
     * Mengambil semua data aparatur dengan cara yang lebih efisien
     */
    private function getAparaturData()
    {
        $jabatanUtama = [
            'kepala desa', 'hukum tua', 'sekretaris desa',
            'kepala seksi kesejahteraan dan pelayanan', 'kepala seksi pemerintahan',
            'kaur umum dan perencanaan', 'kaur keuangan',
            'kepala dusun pada elo', 'kepala dusun empang'
        ];
        
        $aparaturUtama = Aparatur::whereIn(DB::raw('LOWER(jabatan)'), $jabatanUtama)
                                ->get()
                                ->keyBy(function($item) {
                                    return strtolower($item->jabatan);
                                });
        
        $getAparat = function($jabatan) use ($aparaturUtama) {
            return $aparaturUtama->get(strtolower($jabatan));
        };

        $kasiKes = $getAparat('kepala seksi kesejahteraan dan pelayanan');
        $kasiPem = $getAparat('kepala seksi pemerintahan');
        $kaurUmum = $getAparat('kaur umum dan perencanaan');
        $kaurKeu = $getAparat('kaur keuangan');

        return [
            'kepalaDesa' => $getAparat('kepala desa') ?? $getAparat('hukum tua'),
            'sekretaris' => $getAparat('sekretaris desa'),
            'kasiKesejahteraan' => $kasiKes,
            'kasiPemerintahan' => $kasiPem,
            'kaurUmum' => $kaurUmum,
            'kaurKeuangan' => $kaurKeu,
            'kadusElo' => $getAparat('kepala dusun pada elo'),
            'kadusEmpang' => $getAparat('kepala dusun empang'),
            
            'stafKasiKesejahteraan' => $this->getStafByParentId($kasiKes->id ?? null),
            'stafKasiPemerintahan' => $this->getStafByParentId($kasiPem->id ?? null),
            'stafKaurUmum' => $this->getStafByParentId($kaurUmum->id ?? null),
            'stafKaurKeuangan' => $this->getStafByParentId($kaurKeu->id ?? null),

            'galeriAparatur' => Aparatur::whereIn(DB::raw('LOWER(jabatan)'), [
                'kaur keuangan', 'kepala seksi kesejahteraan dan pelayanan', 
                'kaur umum dan perencanaan', 'kepala seksi pemerintahan'
            ])->orderBy('urutan')->get()
        ];
    }

    /**
     * Menampilkan halaman Profil Desa.
     */
    public function profil()
    {
        $data = $this->getAparaturData();
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
        $data = $this->getAparaturData();
        return view('struktur', $data);
    }

    /**
     * METHOD BARU: Menampilkan halaman detail berita.
     */
    public function showBerita(Post $post)
    {
        $beritaTerkait = Post::where('id', '!=', $post->id)
                                ->latest()
                                ->take(3)
                                ->get();

        return view('berita-show', [
            'post' => $post,
            'beritaTerkait' => $beritaTerkait
        ]);
    }
}
