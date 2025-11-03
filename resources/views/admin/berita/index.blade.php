@extends('layouts.admin')

@section('title', 'Manajemen Berita')

@section('content')
<div class="admin-content-box">
    
    <div class="admin-header">
        <h2>Daftar Berita</h2>
        {{-- Tombol ini mengarah ke rute 'admin.berita.create' --}}
        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Berita Baru
        </a>
    </div>

    {{-- Notifikasi Pop-up (dari layout) akan menangani pesan sukses --}}

    <table class="admin-table">
        <thead>
            <tr>
                <th data-label="Judul">Judul</th>
                <th data-label="Kategori">Kategori</th>
                <th data-label="Tanggal">Tanggal Terbit</th>
                <th data-label="Aksi">Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Loop data $beritas dari controller --}}
            @forelse($beritas as $berita)
            <tr>
                <td data-label="Judul">{{ $berita->judul }}</td>
                <td data-label="Kategori">{{ $berita->kategori }}</td>
                <td data-label="Tanggal">{{ $berita->created_at->format('d M Y') }}</td>
                <td data-label="Aksi" class="admin-table-actions">
                    
                    {{-- Tombol EDIT: Mengarah ke route edit --}}
                    <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-sm btn-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    
                    {{-- Tombol HAPUS: Menggunakan form terpisah --}}
                    <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-delete">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Belum ada berita.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginasi --}}
    <div class="admin-pagination">
        {{ $beritas->links() }}
    </div>
</div>
@endsection