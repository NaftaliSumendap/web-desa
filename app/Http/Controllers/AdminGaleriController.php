<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGaleriController extends Controller
{
    /**
     * Menampilkan halaman galeri admin (form upload dan grid foto).
     */
    public function index()
    {
        // Ambil semua foto, urutkan dari yang terbaru
        $photos = Gallery::latest()->paginate(12); // 12 foto per halaman
        return view('admin.galeri.index', compact('photos'));
    }

    /**
     * Menyimpan foto baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
            'photos' => 'required|array', // Pastikan 'photos' adalah array
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Validasi setiap file
        ]);

        foreach ($request->file('photos') as $file) {
            // 1. Simpan file
            $path = $file->store('images/galeri', 'public');

            // 2. Simpan ke database
            Gallery::create([
                'path' => $path,
                'caption' => $request->caption ?? $file->getClientOriginalName(), // Gunakan caption atau nama asli file
            ]);
        }

        return redirect()->route('admin.galeri.index')
                         ->with('success', 'Foto berhasil di-upload.');
    }

    /**
     * Menghapus foto dari database dan storage.
     */
    public function destroy(Gallery $galeri) // Menggunakan Route Model Binding
    {
        // 1. Hapus file dari storage
        if ($galeri->path) {
            Storage::disk('public')->delete($galeri->path);
        }

        // 2. Hapus data dari database
        $galeri->delete();

        return redirect()->route('admin.galeri.index')
                         ->with('success', 'Foto berhasil dihapus.');
    }
}