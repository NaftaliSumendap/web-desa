<?php

namespace App\Http\Controllers;

use App\Models\Aparatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAparaturController extends Controller
{
    /**
     * Menampilkan daftar semua aparatur.
     */
    public function index()
    {
        $aparaturs = Aparatur::orderBy('urutan', 'asc')->with('atasan')->paginate(15);
        return view('admin.aparatur.index', compact('aparaturs'));
    }

    /**
     * Menampilkan form untuk menambah aparatur baru.
     */
    public function create()
    {
        $atasanList = Aparatur::orderBy('nama_lengkap', 'asc')->get();
        // Variabel yang dikirim adalah 'atasanList'
        return view('admin.aparatur.create', compact('atasanList'));
    }

    /**
     * Menyimpan aparatur baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'parent_id' => 'nullable|exists:aparaturs,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only('nama_lengkap', 'jabatan', 'urutan', 'parent_id');

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('images/aparatur', 'public');
            $data['foto'] = $path;
        }

        Aparatur::create($data);

        return redirect()->route('admin.aparatur.index')
                         ->with('success', 'Data aparatur baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit aparatur.
     */
    public function edit(Aparatur $aparatur) // Route model binding
    {
        $atasanList = Aparatur::orderBy('nama_lengkap', 'asc')->get();
        return view('admin.aparatur.edit', compact('aparatur', 'atasanList'));
    }

    /**
     * Memperbarui data aparatur di database.
     */
    public function update(Request $request, Aparatur $aparatur)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'urutan' => 'required|integer',
            'parent_id' => 'nullable|exists:aparaturs,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only('nama_lengkap', 'jabatan', 'urutan', 'parent_id');

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($aparatur->foto) {
                Storage::disk('public')->delete($aparatur->foto);
            }
            // Simpan foto baru
            $path = $request->file('foto')->store('images/aparatur', 'public');
            $data['foto'] = $path;
        }

        $aparatur->update($data);

        return redirect()->route('admin.aparatur.index')
                         ->with('success', 'Data aparatur berhasil diperbarui.');
    }

    /**
     * Menghapus data aparatur dari database.
     */
    public function destroy(Aparatur $aparatur)
    {
        if ($aparatur->foto) {
            Storage::disk('public')->delete($aparatur->foto);
        }
        $aparatur->delete();

        return redirect()->route('admin.aparatur.index')
                         ->with('success', 'Data aparatur berhasil dihapus.');
    }
}
