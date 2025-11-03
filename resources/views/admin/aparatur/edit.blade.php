@extends('layouts.admin')

@section('title', 'Edit Data Aparatur')

@section('content')
<div class="admin-content-box">
    <div class="admin-header">
        <h2>Edit: {{ $aparatur->nama_lengkap }}</h2>
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

    <form action="{{ route('admin.aparatur.update', $aparatur->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Method PUT untuk update --}}
        
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $aparatur->nama_lengkap) }}" required>
        </div>

        <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control" value="{{ old('jabatan', $aparatur->jabatan) }}" required>
        </div>

        <div class="form-group">
            <label for="parent_id">Atasan Langsung (Parent)</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">-- Tidak Ada Atasan --</option>
                @foreach($atasanList as $atasan)
                    {{-- Jangan jadikan diri sendiri sebagai atasan --}}
                    @if($atasan->id != $aparatur->id) 
                        <option value="{{ $atasan->id }}" {{ old('parent_id', $aparatur->parent_id) == $atasan->id ? 'selected' : '' }}>
                            {{ $atasan->nama_lengkap }} ({{ $atasan->jabatan }})
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="urutan">Nomor Urut Tampil</label>
            <input type="number" name="urutan" id="urutan" class="form-control" value="{{ old('urutan', $aparatur->urutan) }}" required>
        </div>

        <div class="form-group">
            <label for="foto">Ganti Foto (Opsional)</label>
            <input type="file" name="foto" id="foto" class="form-control-file">
            <small>Kosongkan jika tidak ingin mengganti foto. Max: 2MB.</small>
            
            @if ($aparatur->foto)
                <div style="margin-top: 15px;">
                    <small>Foto Saat Ini:</small><br>
                    <img src="{{ asset('storage/' . $aparatur->foto) }}" alt="Foto Aparat" style="width: 150px; border-radius: 5px;">
                </div>
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Data</button>
            <a href="{{ route('admin.aparatur.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
