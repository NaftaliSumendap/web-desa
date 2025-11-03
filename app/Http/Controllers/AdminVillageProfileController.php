<?php

namespace App\Http\Controllers;

use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminVillageProfileController extends Controller
{
    /**
     * Menampilkan form edit untuk detail desa.
     * Kita akan selalu mencari data dengan ID=1.
     */
    public function edit()
    {
        // Cari profil dengan ID 1, atau buat baru jika tidak ada
        $profile = VillageProfile::firstOrCreate(
            ['id' => 1]
        );

        return view('admin.profile.edit', compact('profile'));
    }

    /**
     * Memperbarui detail desa di database.
     */
    public function update(Request $request)
    {
        // Validasi untuk semua data baru
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:1024', // Max 1MB
            'kepala_desa' => 'nullable|string|max:255',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|string|max:100',
            'jam_kerja' => 'nullable|string|max:255',
            'luas_wilayah' => 'nullable|string|max:100',
            'batas_wilayah' => 'nullable|string',
            'kondisi_topografi' => 'nullable|string',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
        ]);

        // Cari profil ID 1, atau buat baru
        $profile = VillageProfile::firstOrCreate(['id' => 1]);

        // Ambil semua data kecuali logo
        $data = $request->except('logo');

        // Logika untuk upload Logo
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }
            // Simpan logo baru
            $path = $request->file('logo')->store('images/logo-desa', 'public');
            $data['logo'] = $path;
        }

        // Update data
        $profile->update($data);

        return redirect()->route('admin.profile.edit')
                         ->with('success', 'Detail desa berhasil diperbarui.');
    }
}