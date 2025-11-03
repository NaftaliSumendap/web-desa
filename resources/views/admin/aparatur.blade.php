{{-- Simpan sebagai: resources/views/admin/aparatur.blade.php --}}

@extends('layouts.admin')

@section('title', 'Manajemen Aparatur Desa')

@section('content')

{{-- FORMULIR TAMBAH / EDIT APARATUR --}}
<div class="admin-card">
    
    @if(isset($aparatur_edit))
        <h2 class="form-title">Edit Aparatur: {{ $aparatur_edit->nama_lengkap }}</h2>
        <form action="{{ route('admin.aparatur.update', $aparatur_edit->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
    @else
        <h2 class="form-title">Tambah Aparatur Baru</h2>
        <form action="{{ route('admin.aparatur.store') }}" method="POST" enctype="multipart/form-data">
    @endif

        @csrf

        {{-- Baris 1: Nama & Jabatan --}}
        <div class="form-row">
            <div class="form-group-col">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" 
                       value="{{ old('nama_lengkap', $aparatur_edit->nama_lengkap ?? '') }}" 
                       placeholder="Masukkan nama lengkap..." required>
                @error('nama_lengkap') <small class="form-error">{{ $message }}</small> @enderror
            </div>
            <div class="form-group-col">
                <label for="jabatan">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" class="form-control" 
                       value="{{ old('jabatan', $aparatur_edit->jabatan ?? '') }}" 
                       placeholder="Misal: Kepala Desa" required>
                @error('jabatan') <small class="form-error">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Baris 2: Foto & Urutan --}}
        <div class="form-row">
            <div class="form-group-col">
                <label for="foto">Upload Foto (Rasio 1:1/Persegi)</label>
                <input type="file" id="foto" name="foto" class="form-control-file" accept="image/*">
                @if(isset($aparatur_edit) && $aparatur_edit->foto)
                    <small>Foto saat ini: <a href="{{ asset('storage/' . $aparatur_edit->foto) }}" target="_blank">Lihat</a></small>
                @endif
            </div>
            <div class="form-group-col">
                <label for="urutan">Nomor Urut Tampil</label>
                <input type="number" id="urutan" name="urutan" class="form-control" 
                       value="{{ old('urutan', $aparatur_edit->urutan ?? '0') }}" 
                       placeholder="Misal: 1 (untuk Kepala Desa)">
                <small>Semakin kecil angka, semakin di atas posisinya.</small>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="form-buttons mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> {{ isset($aparatur_edit) ? 'Update Aparatur' : 'Simpan Aparatur' }}
            </button>
            @if(isset($aparatur_edit))
                <a href="{{ route('admin.aparatur.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal Edit
                </a>
            @endif
        </div>
    </form>
</div>

<hr class="separator">

{{-- DAFTAR APARATUR DESA (TAMPILAN GRID KARTU) --}}
<div class="admin-card">
    <h2 class="form-title">Daftar Aparatur Desa</h2>
    
    <div class="aparatur-grid">
        @forelse($semua_aparatur as $aparatur)
            <div class="aparatur-card">
                <img src="{{ $aparatur->foto ? asset('storage/' . $aparatur->foto) : asset('images/default-avatar.png') }}" alt="{{ $aparatur->nama_lengkap }}" class="aparatur-foto">
                <h3>{{ $aparatur->nama_lengkap }}</h3>
                <p class="aparatur-jabatan">{{ $aparatur->jabatan }}</p>
                <p class="aparatur-urutan">(Urutan: {{ $aparatur->urutan }})</p>
                
                <div class="aparatur-actions">
                    <a href="{{ route('admin.aparatur.edit', $aparatur->id) }}" class="btn-edit btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.aparatur.destroy', $aparatur->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-hapus btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p>Belum ada data aparatur desa.</p>
        @endforelse
    </div>
</div>
@endsection