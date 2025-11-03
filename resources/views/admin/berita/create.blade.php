@extends('layouts.admin')

@section('title', 'Tambah Berita Baru')

@section('content')
<div class="admin-content-box">
    
    <div class="admin-header">
        <h2>Tambah Berita Baru</h2>
    </div>

    {{-- Menampilkan error validasi (jika ada) --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf {{-- Wajib untuk keamanan Laravel --}}

        {{-- Input Judul --}}
        <div class="form-group">
            <label for="judul">Judul Berita</label>
            <input type="text" id="judul" name="judul" class="form-control" 
                   value="{{ old('judul') }}" 
                   placeholder="Masukkan judul berita..." required>
        </div>

        {{-- Input Kategori (Contoh) --}}
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" class="form-control">
                <option value="pemerintahan" {{ old('kategori') == 'pemerintahan' ? 'selected' : '' }}>Pemerintahan</option>
                <option value="kemasyarakatan" {{ old('kategori') == 'kemasyarakatan' ? 'selected' : '' }}>Kemasyarakatan</option>
                <option value="pembangunan" {{ old('kategori') == 'pembangunan' ? 'selected' : '' }}>Pembangunan</option>
                <option value="bencana" {{ old('kategori') == 'bencana' ? 'selected' : '' }}>Bencana</option>
            </select>
        </div>

        {{-- Input Isi Berita (Textarea) --}}
        <div class="form-group">
            <label for="isi_berita">Isi Berita</label>
            <textarea id="isi_berita" name="isi_berita" class="form-control" rows="10" 
                      placeholder="Tulis isi berita di sini...">{{ old('isi_berita') }}</textarea>
        </div>

        {{-- Input Gambar --}}
        <div class="form-group">
            <label for="gambar">Upload Gambar Utama</label>
            <input type="file" id="gambar" name="gambar" class="form-control-file" accept="image/*">
            <small>Max: 2MB. Format: jpg, png, webp, gif.</small>
        </div>

        {{-- Tombol Aksi --}}
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Berita
            </button>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>

    </form>
</div>
@endsection