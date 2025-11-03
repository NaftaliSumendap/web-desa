@extends('layouts.admin')

@section('title', 'Manajemen Galeri')

@section('content')

{{-- 1. FORM UPLOAD --}}
<div class="admin-content-box">
    <div class="admin-header">
        <h2>Upload Foto Baru</h2>
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

    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="photos">Pilih Foto (Bisa lebih dari satu)</label>
            <input type="file" name="photos[]" id="photos" class="form-control-file" multiple required>
            <small>Max: 2MB per foto. Format: jpg, png, webp.</small>
        </div>
        
        <div class="form-group">
            <label for="caption">Keterangan (Opsional)</label>
            <input type="text" name="caption" id="caption" class="form-control" placeholder="Keterangan singkat untuk semua foto yang diupload...">
            <small>Jika kosong, akan menggunakan nama asli file.</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-upload"></i> Upload Foto
            </button>
        </div>
    </form>
</div>

<div style="height: 30px;"></div> {{-- Memberi jarak --}}

{{-- 2. GRID FOTO YANG SUDAH DI-UPLOAD --}}
<div class="admin-content-box">
    <div class="admin-header">
        <h2>Daftar Foto di Galeri</h2>
    </div>

    @if($photos->isEmpty())
        <p>Belum ada foto di galeri. Silakan upload foto baru.</p>
    @else
        <div class="admin-gallery-grid">
            @foreach($photos as $photo)
                <div class="admin-gallery-item">
                    <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->caption }}">
                    <div class="admin-gallery-caption">
                        <p>{{ $photo->caption }}</p>
                        {{-- Form Hapus --}}
                        <form action="{{ route('admin.galeri.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus foto ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-delete">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Paginasi --}}
    <div class="admin-pagination">
        {{ $photos->links() }}
    </div>
</div>
@endsection