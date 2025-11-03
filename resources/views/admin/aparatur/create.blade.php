@extends('layouts.admin')

@section('title', 'Tambah Aparatur Baru')

@section('content')
<div class="admin-content-box">
    <div class="admin-header">
        <h2>Tambah Aparatur Baru</h2>
    </div>

    {{-- Menampilkan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.aparatur.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
        </div>

        <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control" value="{{ old('jabatan') }}" required>
            <small>Contoh: "Kepala Desa", "Kaur Keuangan", "Staf"</small>
        </div>
a
        <div class="form-group">
            <label for="parent_id">Atasan Langsung (Parent)</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">-- Tidak Ada Atasan (cth: Kepala Desa) --</option>
                {{-- Pastikan ini menggunakan $atasanList --}}
                @foreach($atasanList as $atasan)
                    <option value="{{ $atasan->id }}" {{ old('parent_id') == $atasan->id ? 'selected' : '' }}>
                        {{ $atasan->nama_lengkap }} ({{ $atasan->jabatan }})
                    </option>
                @endforeach
            </select>
            <small>Pilih atasan langsung untuk bagan organisasi.</small>
        </div>

        <div class="form-group">
            <label for="urutan">Nomor Urut Tampil</label>
            <input type="number" name="urutan" id="urutan" class="form-control" value="{{ old('urutan', 0) }}" required>
            <small>Semakin kecil angka, semakin atas/kiri posisinya.</small>
        </div>

        <div class="form-group">
            <label for="foto">Foto (Opsional)</label>
            <input type="file" name="foto" id="foto" class="form-control-file">
            <small>Max: 2MB. Akan ditampilkan di galeri aparat.</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.aparatur.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>

    {{-- Kode Paginasi yang salah ($atasan->links()) TELAH DIHAPUS dari sini --}}

</div>
@endsection

    