@extends('layouts.app')

{{-- Mengatur judul halaman --}}
@section('title', $post->judul ?? 'Detail Berita')

{{-- Mengisi konten --}}
@section('content')

{{-- Header Halaman --}}
<div class="page-header" style="padding: 100px 0 30px 0;">
    <div class="container">
        {{-- Judul Besar tidak perlu di sini, agar desain lebih sederhana --}}
    </div>
</div>

<!-- Konten Utama Halaman -->
<div class="page-content" style="padding-top: 20px;">
    <div class="container">
        
        <div class="berita-detail-grid">
            
            <!-- Kolom Kiri: Isi Berita Utama -->
            <div class="berita-utama">
                
                <h1 class="berita-judul">{{ $post->judul }}</h1>
                
                <div class="berita-meta">
                    <span class="meta-item"><i class="fas fa-clock"></i> {{ $post->created_at->translatedFormat('d F Y') }}</span>
                    <span class="meta-item"><i class="fas fa-tag"></i> {{ $post->kategori }}</span>
                    <span class="meta-item"><i class="fas fa-user"></i> Administrator</span>
                </div>
                
                {{-- Gambar Utama --}}
                <div class="berita-gambar-utama">
                    @if($post->gambar)
                        <img src="{{ asset('storage/' . $post->gambar) }}" alt="{{ $post->judul }}">
                    @else
                        <img src="{{ asset('images/default-berita-large.jpg') }}" alt="Gambar Default">
                    @endif
                </div>

                {{-- Isi Berita --}}
                <div class="berita-isi">
                    {{-- Tampilkan isi berita (asli, dengan tag HTML jika ada) --}}
                    {!! $post->isi_berita !!}
                </div>

            </div>
            
            <!-- Kolom Kanan: Berita Terkait -->
            <div class="berita-sidebar">
                
                <div class="sidebar-box">
                    <h3>Berita Terkait</h3>
                    <ul class="terkait-list">
                        @forelse($beritaTerkait as $terkait)
                        <li>
                            <a href="{{ route('berita.show', $terkait) }}">
                                <img src="{{ $terkait->gambar ? asset('storage/' . $terkait->gambar) : asset('images/default-berita.jpg') }}" alt="{{ $terkait->judul }}">
                                <div class="terkait-info">
                                    <h4>{{ Str::limit($terkait->judul, 50) }}</h4>
                                    <small>{{ $terkait->created_at->translatedFormat('d M Y') }}</small>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li>Tidak ada berita terkait.</li>
                        @endforelse
                    </ul>
                </div>
                
                {{-- Anda bisa tambahkan widget lain di sini (misal: arsip, kategori) --}}

            </div>
            
        </div>
    </div>
</div>

<style>
    /* ===================================== */
    /* CSS BARU UNTUK HALAMAN DETAIL BERITA  */
    /* ===================================== */

    .berita-detail-grid {
        display: grid;
        grid-template-columns: 2fr 1fr; /* 2/3 untuk isi, 1/3 untuk sidebar */
        gap: 40px;
    }

    .berita-utama {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .berita-judul {
        font-family: 'Merriweather', serif;
        font-size: 2.5rem;
        color: var(--dark-olive-green-2);
        line-height: 1.3;
        margin-top: 0;
        margin-bottom: 15px;
    }

    .berita-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
        color: #777;
        font-size: 0.9rem;
        border-bottom: 1px solid var(--neutral-cream);
        padding-bottom: 15px;
    }
    .berita-meta i {
        margin-right: 5px;
        color: var(--dark-olive-green-3);
    }
    .meta-item {
        display: flex;
        align-items: center;
    }

    .berita-gambar-utama {
        margin-bottom: 30px;
        border-radius: 8px;
        overflow: hidden;
        max-height: 450px;
        width: 100%;
    }
    .berita-gambar-utama img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .berita-isi {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-dark);
    }
    /* Mengatur style default untuk konten dalam berita */
    .berita-isi p {
        margin-bottom: 1.5em;
    }
    .berita-isi h2 {
        font-size: 1.8rem;
        font-family: 'Merriweather', serif;
        color: var(--dark-olive-green-2);
        margin-top: 30px;
    }
    .berita-isi ul, .berita-isi ol {
        margin: 1em 0;
        padding-left: 25px;
    }
    /* Sidebar Styling */
    .berita-sidebar {
        /* Tetap di kanan */
    }

    .sidebar-box {
        background: #fff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        border-top: 5px solid var(--dark-olive-green-3);
    }
    .sidebar-box h3 {
        font-family: 'Merriweather', serif;
        font-size: 1.3rem;
        color: var(--dark-olive-green-3);
        margin-top: 0;
        border-bottom: 1px solid var(--neutral-cream);
        padding-bottom: 10px;
        margin-bottom: 15px;
    }
    
    .terkait-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .terkait-list li {
        margin-bottom: 15px;
    }
    .terkait-list li a {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: var(--text-dark);
        transition: color 0.3s ease;
    }
    .terkait-list li a:hover {
        color: var(--dark-olive-green-3);
    }
    .terkait-list li img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 15px;
    }
    .terkait-info h4 {
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.3;
        font-weight: 700;
    }
    .terkait-info small {
        font-size: 0.8rem;
        color: #999;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .berita-detail-grid {
            grid-template-columns: 1fr; /* Stack di tablet/mobile */
        }
    }
</style>
@endsection
