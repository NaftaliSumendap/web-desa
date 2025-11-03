{{-- Memberitahu Blade untuk menggunakan layout app.blade.php --}}
@extends('layouts.app')

{{-- Mengatur judul halaman --}}
@section('title', 'Berita - ' . ($desa->name ?? 'Desa'))

{{-- Mengisi bagian @yield('content') --}}
@section('content')

{{-- CSS Khusus untuk Halaman Ini (Header & Pagination) --}}
<style>
    /* ... (CSS Anda untuk .page-header dan .pagination-links sudah benar) ... */
    .page-header {
        background-color: var(--dark-olive-green-1, #002400);
        color: white;
        padding: 140px 0 50px 0; /* Pastikan padding atas cukup */
        text-align: center;
    }
    .page-header h1 {
        font-family: 'Merriweather', serif;
        font-size: 3rem;
        margin: 0;
    }
    .page-header p {
        font-size: 1.2rem;
        color: var(--light-olive-green, #BBCF8D);
        margin: 5px 0 0 0;
    }
    .page-content {
        background-color: var(--neutral-cream, #f9f9f9);
        padding: 60px 0;
    }
    .pagination-links {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .page-item { margin: 0; }
    .page-link,
    .page-item.disabled .page-link,
    .page-item.active .page-link {
        padding: 10px 16px;
        display: block;
        text-decoration: none;
        background-color: #fff;
        color: var(--dark-olive-green-3, #58641D);
        border: 1px solid #ddd;
        border-left: none;
        font-weight: 700;
        transition: background-color 0.3s ease;
    }
    .page-item:first-child .page-link {
        border-left: 1px solid #ddd;
    }
    .page-item.disabled .page-link {
        color: #aaa;
        background-color: #f9f9f9;
    }
    .page-item.active .page-link {
        background-color: var(--dark-olive-green-3, #58641D);
        color: white;
        border-color: var(--dark-olive-green-3, #58641D);
    }
    .page-link:hover {
        background-color: var(--neutral-cream, #f9f9f9);
    }
    .page-item.active .page-link:hover {
        background-color: var(--dark-olive-green-2, #273B09);
    }
</style>

<!-- Header Halaman Sederhana -->
<div class="page-header">
    <div class="container">
        <h1>Berita Desa</h1>
        <p>Kumpulan informasi dan kegiatan terbaru {{ $desa->name ?? 'Desa' }}</p>
    </div>
</div>

<!-- Konten Utama Halaman -->
<div class="page-content">
    <div class="container">
        
        {{-- Kita menggunakan class .berita-grid yang sama dari style.css --}}
        <div class="berita-grid">

            {{-- Loop data '$posts' dari Controller (dengan paginate) --}}
            @forelse($posts as $post)
                {{-- PERBAIKAN: Mengarahkan ke rute detail berita --}}
                <a href="{{ route('berita.show', $post->id) }}" class="berita-card">
                    
                    <div class="card-image">
                        {{-- PERBAIKAN: Menggunakan 'gambar' dan 'storage' --}}
                        <img src="{{ $post->gambar ? asset('storage/' . $post->gambar) : 'https://placehold.co/400x300/F5F5DC/333?text=Foto+Berita' }}" alt="{{ $post->judul }}">
                    </div>
                    
                    <div class="card-content">
                        {{-- PERBAIKAN: Menggunakan 'judul' --}}
                        <h3 class="card-title">{{ $post->judul }}</h3>
                        {{-- PERBAIKAN: Menggunakan 'isi_berita' --}}
                        <p class="card-excerpt">{{ Str::limit(strip_tags($post->isi_berita), 100) }}</p>
                        
                        <div class="card-footer">
                            <div class="card-meta">
                                <span>
                                    <i class="fas fa-user"></i>
                                    Administrator
                                </span>
                            </div>
                            <div class="card-date">
                                <span class="day">{{ $post->created_at->format('d') }}</span>
                                <span class="month">{{ $post->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                {{-- Tampilkan jika tidak ada post sama sekali --}}
                <div style="grid-column: 1 / -1; text-align: center; color: #555;">
                    <p>Belum ada berita untuk ditampilkan.</p>
                </div>
            @endforelse

        </div>

        <!-- ====================================== -->
        <!-- BAGIAN PAGINATION (PENOMORAN HALAMAN)  -->
        <!-- ====================================== -->
        <div class="pagination-links">
            {{-- Ini akan otomatis menampilkan link: 1, 2, 3, ... --}}
            {{ $posts->links() }}
        </div>

    </div>
</div>

@endsection

