{{-- Memberitahu Blade untuk menggunakan layout app.blade.php --}}
@extends('layouts.app')

{{-- Mengatur judul halaman --}}
@section('title', 'Selamat Datang - ' . ($desa->name ?? 'Website Desa'))

{{-- Mengisi bagian @yield('content') --}}
@section('content')

{{-- =================================== --}}
{{-- HERO SECTION (DINAMIS) --}}
{{-- =================================== --}}
<div class="hero-section">
  <div class="hero-content">
        <div class="welcome-text">
            <h2>Selamat Datang di Website Resmi</h2>
            {{-- Data $desa ini diambil dari AppServiceProvider --}}
            <h1>{{ $desa->name ?? 'Website Desa' }}</h1>
            <p>{{ $desa->address ?? 'Sumber informasi terbaru tentang pemerintahan desa' }}</p>
    </div>
</div>

{{-- Tag </div> ekstra dari file Anda sebelumnya, pastikan ini benar --}}
</div> 

{{-- =================================== --}}
{{-- BAGIAN BERITA TERBARU (DINAMIS) --}}
{{-- =================================== --}}
<section class="berita-terbaru">
    <div class="container">
        <h2>Berita Terbaru</h2>
        <div class="berita-grid">

            {{-- Loop data $latestPosts dari Controller --}}
            @forelse($latestPosts as $post)
                {{-- Link mengarah ke halaman detail berita --}}
                <a href="{{ route('berita.show', $post) }}" class="berita-card">
                    
                    <div class="card-image">
                        {{-- Tampilkan gambar berita, atau gambar default jika kosong --}}
                        <img src="{{ $post->gambar ? asset('storage/' . $post->gambar) : asset('images/default-berita.jpg') }}" alt="{{ $post->judul }}">
                    </div>
                    
                    <div class="card-content">
                        {{-- Menggunakan kolom 'judul' dari database --}}
                        <h3 class="card-title">{{ $post->judul }}</h3>
                        {{-- Menggunakan kolom 'isi_berita' dan strip_tags untuk membersihkan HTML --}}
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
                {{-- Tampilan jika tidak ada berita --}}
                <div style="grid-column: 1 / -1; text-align: center; color: #555;">
                    <p>Belum ada berita terbaru untuk ditampilkan.</p>
                </div>
            @endforelse

        </div>
    </div>
</section>

{{-- =================================== --}}
{{-- BAGIAN SAMBUTAN KADES (DINAMIS) --}}
{{-- =================================== --}}
<section class="sambutan">
    <div class="container sambutan-grid">
        <div class="sambutan-foto">
            {{-- Tampilkan foto Kades, atau avatar default jika kosong --}}
            <img src="{{ $kepalaDesa->foto ? asset('storage/' . $kepalaDesa->foto) : asset('images/default-avatar.jpg') }}" alt="Foto Kepala Desa {{ $kepalaDesa->nama_lengkap ?? '' }}">
        </div>
        <div class="sambutan-teks">
            <h4>Sambutan Kepala Desa</h4>
            {{-- Tampilkan nama Kades dari database --}}
            <h3>Treisje D. Rawung S.T</h3>
            {{-- Tampilkan Visi Desa sebagai kutipan sambutan --}}
            <p>"{{ $desa->visi ?? 'Selamat datang di website resmi desa kami. Website ini kami hadirkan sebagai media informasi pemerintahan, transparansi anggaran, serta sarana komunikasi interaktif antara pemerintah desa dengan masyarakat.' }}"</p>
            
            <a href="{{ route('profil') }}" class="btn-baca">Profil Lengkap</a>
        </div>
    </div>
</section>

{{-- =================================== --}}
{{-- BAGIAN APARATUR DESA (DINAMIS) --}}
{{-- =================================== --}}
<section class="aparatur">
    <div class="container">
        <h2>Aparat Pemerintah Desa</h2>
        <div class="aparatur-grid">
            
            {{-- Loop 4 aparatur dari $aparaturList di controller --}}
            @forelse($aparaturList as $aparat)
            <div class="aparatur-card">
                {{-- Tampilkan foto aparat, atau avatar default jika kosong --}}
                <img src="{{ $aparat->foto ? asset('storage/' . $aparat->foto) : asset('images/default-avatar.jpg') }}" alt="Foto {{ $aparat->nama_lengkap }}">
                <h4>{{ $aparat->nama_lengkap }}</h4>
                <p>{{ $aparat->jabatan }}</p>
            </div>
            @empty
             <p style="text-align: center; grid-column: 1 / -1; color: #555;">Data aparatur desa belum diisi.</p>
            @endforelse
            
        </div>
    </div>
</section>

@endsection

