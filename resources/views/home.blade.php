{{-- Memberitahu Blade untuk menggunakan layout app.blade.php --}}
@extends('layouts.app')

{{-- Mengganti judul halaman --}}
@section('title', 'Selamat Datang - ' . ($desa->name ?? 'Website Desa'))

{{-- Mengisi bagian @yield('content') --}}
@section('content')

<div class="hero-section">
  <div class="hero-content">
        <div class="welcome-text">
            <h2>Selamat Datang di Website Resmi Desa</h2>
            <h1>{{ $desa->name ?? 'Website Resmi Desa' }}</h1>
            <p>{{ $desa->address ?? 'Sumber informasi terbaru tentang pemerintahan desa' }}</p>
    </div>
</div>

{{-- Anda bisa menambahkan section lain di bawah sini --}}
</div> 

{{-- =================================== --}}
{{-- BAGIAN BERITA TERBARU --}}
{{-- =================================== --}}
<section class="berita-terbaru">
    <div class="container">
        <h2>Berita Terbaru</h2>
        <div class="berita-grid">

            {{-- Loop data $latestPosts dari Controller --}}
            @forelse($latestPosts as $post)
                <a href="{{ route('berita.show', $post) }}" class="berita-card">
                    
                    <div class="card-image">
                        {{-- PERBAIKAN FOTO DEFAULT UNTUK BERITA --}}
                        <img src="{{ $post->gambar ? asset('storage/' . $post->gambar) : asset('images/default-berita.jpg') }}" alt="{{ $post->judul }}">
                    </div>
                    
                    <div class="card-content">
                        <h3 class="card-title">{{ $post->judul }}</h3>
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
                <div style="grid-column: 1 / -1; text-align: center; color: #555;">
                    <p>Belum ada berita terbaru.</p>
                </div>
            @endforelse

        </div>
    </div>
</section>

{{-- =================================== --}}
{{-- BAGIAN SAMBUTAN KEPALA DESA --}}
{{-- =================================== --}}
<section class="sambutan">
    <div class="container sambutan-grid">
        <div class="sambutan-foto">
            {{-- 
              PERBAIKAN FOTO DEFAULT KEPALA DESA:
              Tampilkan foto Kades jika ada, jika tidak (null), tampilkan default-avatar.png
            --}}
            <img src="{{ $kepalaDesa->foto ? asset('storage/' . $kepalaDesa->foto) : asset('images/default-avatar.png') }}" alt="Foto Kepala Desa {{ $kepalaDesa->nama_lengkap ?? '' }}">
        </div>
        <div class="sambutan-teks">
            <h4>Sambutan Kepala Desa</h4>
            <h3>{{ $kepalaDesa->nama_lengkap ?? '[Nama Kepala Desa]' }}</h3>
            {{-- Mengambil data visi sebagai kutipan sambutan --}}
            <p>"{{ $desa->visi ?? 'Selamat datang di website resmi desa kami. Website ini kami hadirkan sebagai media informasi pemerintahan, transparansi anggaran, serta sarana komunikasi interaktif antara pemerintah desa dengan masyarakat.' }}"</p>
            
            <a href="{{ route('profil') }}" class="btn-baca">Profil Lengkap</a>
        </div>
    </div>
</section>

{{-- =================================== --}}
{{-- BAGIAN APARATUR DESA (HOMEPAGE) --}}
{{-- =================================== --}}
<section class="aparatur">
    <div class="container">
        <h2>Aparatur Desa</h2>
        <div class="aparatur-grid">
            
            {{-- Loop 4 aparatur dari controller --}}
            @forelse($aparaturList as $aparat)
            <div class="aparatur-card">
                {{-- 
                  PERBAIKAN FOTO DEFAULT APARATUR:
                  Logika yang sama seperti Kepala Desa
                --}}
                <img src="{{ $aparat->foto ? asset('storage/' . $aparat->foto) : asset('images/default-avatar.png') }}" alt="Foto {{ $aparat->nama_lengkap }}">
                <h4>{{ $aparat->nama_lengkap }}</h4>
                <p>{{ $aparat->jabatan }}</p>
            </div>
            @empty
             <p>Data aparatur belum diisi.</p>
            @endforelse
            
        </div>
    </div>
</section>

@endsection

