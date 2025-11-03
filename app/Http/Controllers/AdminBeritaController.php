<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminBeritaController extends Controller
{
    /**
     * Menampilkan daftar semua berita.
     * (Memuat view index.blade.php)
     */
    public function index()
    {
        // Menggunakan nama variabel $beritas (plural)
        $beritas = Post::latest()->paginate(10); 
        return view('admin.berita.index', compact('beritas'));
    }

    /**
     * Menampilkan form untuk membuat berita baru.
     * (Memuat view create.blade.php)
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Menyimpan berita baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi berdasarkan nama kolom di form Anda
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'isi_berita' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only('judul', 'kategori', 'isi_berita');

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('images/berita', 'public');
            $data['gambar'] = $path;
        }

        Post::create($data);

        return redirect()->route('admin.berita.index')
                         ->with('success', 'Berita baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit berita.
     * (Memuat view edit.blade.php)
     */
    public function edit(Post $berita) // $berita diambil otomatis berdasarkan ID
    {
        // Menggunakan nama variabel $berita_edit (sesuai view Anda)
        $berita_edit = $berita;
        return view('admin.berita.edit', compact('berita_edit'));
    }

    /**
     * Memperbarui berita di database.
     */
    public function update(Request $request, Post $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'isi_berita' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only('judul', 'kategori', 'isi_berita');

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($berita->gambar) {
                Storage::disk('public')->delete($berita->gambar);
            }
            // Simpan gambar baru
            $path = $request->file('gambar')->store('images/berita', 'public');
            $data['gambar'] = $path;
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')
                         ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Menghapus berita dari database.
     */
    public function destroy(Post $berita)
    {
        if ($berita->gambar) {
            Storage::disk('public')->delete($berita->gambar);
        }
        $berita->delete();

        return redirect()->route('admin.berita.index')
                         ->with('success', 'Berita berhasil dihapus.');
    }
}