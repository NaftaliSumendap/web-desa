@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- 1. KARTU STATISTIK --}}
<div class="stat-cards-grid">
    
    {{-- Kartu Jumlah Berita --}}
    <div class="stat-card">
        <div class="stat-icon" style="background-color: var(--dark-olive-green-4);">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="stat-info">
            <span class="stat-title">Jumlah Berita</span>
            {{-- Variabel ini datang dari AdminController --}}
            <span class="stat-value">{{ $jumlahBerita }}</span>
        </div>
    </div>

    {{-- Kartu Foto Galeri --}}
    <div class="stat-card">
        <div class="stat-icon" style="background-color: var(--dark-olive-green-3);">
            <i class="fas fa-images"></i>
        </div>
        <div class="stat-info">
            <span class="stat-title">Foto Galeri</span>
            <span class="stat-value">{{ $jumlahFoto }}</span>
        </div>
    </div>

    {{-- Kartu Aparatur Desa --}}
    <div class="stat-card">
        <div class="stat-icon" style="background-color: var(--dark-olive-green-2);">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <span class="stat-title">Aparatur Desa</span>
            <span class="stat-value">{{ $jumlahAparatur }}</span>
        </div>
    </div>

</div>

{{-- 2. KOTAK KONTEN BARU (PINTASAN & APARATUR) --}}
<div class="admin-grid-col-2">
    
    {{-- Kolom 1: Pintasan Cepat --}}
    <div class="admin-content-box">
        <div class="admin-header">
            <h2>Pintasan Cepat</h2>
        </div>
        <div class="quick-links">
            <a href="{{ route('admin.berita.create') }}" class="quick-link-item">
                <i class="fas fa-plus"></i>
                <span>Tambah Berita Baru</span>
            </a>
            <a href="{{ route('admin.aparatur.create') }}" class="quick-link-item">
                <i class="fas fa-user-plus"></i>
                <span>Tambah Aparatur</span>
            </a>
            <a href="{{ route('admin.profile.edit') }}" class="quick-link-item">
                <i class="fas fa-landmark"></i>
                <span>Edit Detail Desa</span>
            </a>
        </div>
    </div>

    {{-- Kolom 2: Aparatur Terbaru --}}
    <div class="admin-content-box">
        <div class="admin-header">
            <h2>Aparatur Terbaru</h2>
            <a href="{{ route('admin.aparatur.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <table class="admin-table simple">
            <tbody>
                {{-- Menggunakan variabel $aparaturTerbaru (bukan $beritaTerbaru) --}}
                @forelse($aparaturTerbaru as $aparat)
                    <tr>
                        <td>
                            <strong>{{ $aparat->nama_lengkap }}</strong><br>
                            <small>{{ $aparat->jabatan }}</small>
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('admin.aparatur.edit', $aparat->id) }}" class="btn btn-sm btn-edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="text-align: center;">Belum ada data aparatur.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection