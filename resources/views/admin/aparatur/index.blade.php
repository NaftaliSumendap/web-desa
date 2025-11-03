@extends('layouts.admin')

@section('title', 'Manajemen Aparatur Desa')

@section('content')
<div class="admin-content-box">
    <div class="admin-header">
        <h2>Daftar Aparatur Desa</h2>
        <a href="{{ route('admin.aparatur.create') }}" class="btn btn-primary">Tambah Aparatur Baru</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 50px;">Urutan</th>
                <th>Nama Lengkap</th>
                <th>Jabatan</th>
                <th>Atasan Langsung</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Loop data $aparaturs dari AdminAparaturController --}}
            @forelse($aparaturs as $aparat)
                <tr>
                    <td>{{ $aparat->urutan }}</td>
                    <td>
                        <strong>{{ $aparat->nama_lengkap }}</strong>
                    </td>
                    <td>{{ $aparat->jabatan }}</td>
                    {{-- Tampilkan nama atasan jika ada, jika tidak, tampilkan strip --}}
                    <td>{{ $aparat->atasan->nama_lengkap ?? '-' }}</td>
                    <td class="admin-table-actions">
                        <a href="{{ route('admin.aparatur.edit', $aparat->id) }}" class="btn btn-sm btn-edit">Edit</a>
                        <form action="{{ route('admin.aparatur.destroy', $aparat->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-delete">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                {{-- Tampilan jika tabel kosong (seperti di screenshot Anda) --}}
                <tr>
                    <td colspan="5">Belum ada data aparatur.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tampilkan link paginasi --}}
    <div class="admin-pagination">
        {{ $aparaturs->links() }}
    </div>
</div>
@endsection

