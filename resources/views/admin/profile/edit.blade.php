@extends('layouts.admin')

@section('title', 'Edit Detail Desa')

@section('content')
<div class="admin-content-box">
    <div class="admin-header">
        <h2>Edit Detail Desa</h2>
        <small>Data ini akan tampil di halaman publik (Profil, Struktur, Footer, dll).</small>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="admin-header sub-header">
            <h3>Informasi Dasar</h3>
        </div>

        <div class="form-group">
            <label for="name">Nama Desa</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $profile->name) }}" required>
        </div>
        <div class="form-group">
            <label for="slug">Slug (URL)</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $profile->slug) }}" required>
        </div>
        <div class="form-group">
            <label for="kepala_desa">Nama Kepala Desa</label>
            <input type="text" name="kepala_desa" id="kepala_desa" class="form-control" value="{{ old('kepala_desa', $profile->kepala_desa) }}">
        </div>
        <div class="form-group">
            <label for="logo">Logo Desa</label>
            <input type="file" name="logo" id="logo" class="form-control-file">
            <small>Kosongkan jika tidak ingin mengganti logo. Max: 1MB.</small>
            @if ($profile->logo)
                <div style="margin-top: 15px;">
                    <small>Logo Saat Ini:</small><br>
                    <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo Desa" style="max-height: 80px; background: #eee; padding: 5px; border-radius: 5px;">
                </div>
            @endif
        </div>

        <div class="admin-header sub-header">
            <h3>Visi & Misi</h3>
        </div>
        
        <div class="form-group">
            <label for="visi">Visi</label>
            <textarea name="visi" id="visi" class="form-control" rows="5">{{ old('visi', $profile->visi) }}</textarea>
        </div>
        <div class="form-group">
            <label for="misi">Misi</label>
            <textarea name="misi" id="misi" class="form-control" rows="8">{{ old('misi', $profile->misi) }}</textarea>
        </div>

        <div class="admin-header sub-header">
            <h3>Info Kontak & Alamat</h3>
        </div>

        <div class="form-group">
            <label for="address">Alamat Kantor Desa</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $profile->address) }}">
        </div>
        <div class="form-group">
            <label for="kecamatan">Kecamatan</label>
            <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="{{ old('kecamatan', $profile->kecamatan) }}">
        </div>
        <div class="form-group">
            <label for="kabupaten">Kabupaten</label>
            <input type="text" name="kabupaten" id="kabupaten" class="form-control" value="{{ old('kabupaten', $profile->kabupaten) }}">
        </div>
        <div class="form-group">
            <label for="provinsi">Provinsi</label>
            <input type="text" name="provinsi" id="provinsi" class="form-control" value="{{ old('provinsi', $profile->provinsi) }}">
        </div>
        <div class="form-group">
            <label for="kode_pos">Kode Pos</label>
            <input type="text" name="kode_pos" id="kode_pos" class="form-control" value="{{ old('kode_pos', $profile->kode_pos) }}">
        </div>
        <div class="form-group">
            <label for="telepon">Telepon</label>
            <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon', $profile->telepon) }}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $profile->email) }}">
        </div>
        <div class="form-group">
            <label for="website">Website</label>
            <input type="text" name="website" id="website" class="form-control" value="{{ old('website', $profile->website) }}" placeholder="Contoh: https://desaku.id">
        </div>
        <div class="form-group">
            <label for="jam_kerja">Jam Kerja</label>
            <input type="text" name="jam_kerja" id="jam_kerja" class="form-control" value="{{ old('jam_kerja', $profile->jam_kerja) }}" placeholder="Contoh: Senin - Jumat: 08.00 - 16.00">
        </div>
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $profile->latitude) }}" placeholder="Contoh: -0.000000">
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $profile->longitude) }}" placeholder="Contoh: 100.000000">
        </div>

        <div class="admin-header sub-header">
            <h3>Info Wilayah</h3>
        </div>

        <div class="form-group">
            <label for="luas_wilayah">Luas Wilayah</label>
            <input type="text" name="luas_wilayah" id="luas_wilayah" class="form-control" value="{{ old('luas_wilayah', $profile->luas_wilayah) }}" placeholder="Contoh: 115 Hektar">
        </div>
        <div class="form-group">
            <label for="batas_wilayah">Batas Wilayah</label>
            <textarea name="batas_wilayah" id="batas_wilayah" class="form-control" rows="5">{{ old('batas_wilayah', $profile->batas_wilayah) }}</textarea>
            <small>Contoh: Utara: Desa A, Timur: Desa B, ...</small>
        </div>
        <div class="form-group">
            <label for="kondisi_topografi">Kondisi Topografi</label>
            <textarea name="kondisi_topografi" id="kondisi_topografi" class="form-control" rows="3">{{ old('kondisi_topografi', $profile->kondisi_topografi) }}</textarea>
            <small>Contoh: Dataran rendah, berbukit-bukit, dll.</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection