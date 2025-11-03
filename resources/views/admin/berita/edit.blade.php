@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="admin-content-box">
    
    <div class="admin-header">
        <h2>Edit Berita: {{ $berita_edit->judul }}</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.berita.update', $berita_edit->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Method spoofing untuk update --}}

        {{-- Input Judul --}}
        <div class="form-group">
            <label for="judul">Judul Berita</label>
            <input type="text" id="judul" name="judul" class="form-control" 
                   value="{{ old('judul', $berita_edit->judul) }}" 
                   required>
        </div>

        {{-- Input Kategori (Contoh) --}}
        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" class="form-control">
                @php
                    // Ambil nilai lama atau nilai dari $berita_edit
                    $selectedKategori = old('kategori', $berita_edit->kategori);
                @endphp
                <option value="pemerintahan" {{ $selectedKategori == 'pemerintahan' ? 'selected' : '' }}>Pemerintahan</option>
                <option value="kemasyarakatan" {{ $selectedKategori == 'kemasyarakatan' ? 'selected' : '' }}>Kemasyarakatan</option>
                <option value="pembangunan" {{ $selectedKategori == 'pembangunan' ? 'selected' : '' }}>Pembangunan</option>
                <option value="bencana" {{ $selectedKategori == 'bencana' ? 'selected' : '' }}>Bencana</option>
            </select>
        </div>

        {{-- Input Isi Berita (Textarea) --}}
        <div class="form-group">
            <label for="isi_berita">Isi Berita</label>
            <textarea id="isi_berita" name="isi_berita" class="form-control" rows="10">{{ old('isi_berita', $berita_edit->isi_berita) }}</textarea>
        </div>

        {{-- Input Gambar --}}
        <div class="form-group">
            <label for="gambar">Upload Gambar Utama</label>
            <input type="file" id="gambar" name="gambar" class="form-control-file" accept="image/*">
            <small>Kosongkan jika tidak ingin mengganti gambar.</small>
            @if($berita_edit->gambar)
                <div style="margin-top: 15px;">
                    <small>Gambar saat ini:</small><br>
                    <img src="{{ asset('storage/' . $berita_edit->gambar) }}" alt="Gambar Berita" style="width: 200px; border-radius: 5px;">
                </div>
            @endif
        </div>

        {{-- Tombol Aksi --}}
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Berita
            </button>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>

    </form>
</div>
@endsection