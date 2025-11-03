<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Judul dinamis dari data desa --}}
    <title>@yield('title') - {{ $desa->name ?? 'Website Desa' }}</title>
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700;900&family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head> 
<body>

    <header class="navbar">
        <div class="navbar-left">
            {{-- Logo dinamis --}}
            <img src="{{ $desa->logo ? asset('storage/' . $desa->logo) : asset('images/logo-desa.png') }}" alt="Logo Desa" class="logo">
            <div class="logo-text">
                <strong>{{ $desa->name ?? 'Desa' }}</strong>
                <span>{{ $desa->kabupaten ?? 'Kabupaten' }}</span>
            </div>
        </div>

        <button class="nav-toggle" aria-label="Buka menu navigasi">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>

        <nav class="navbar-right" id="main-nav-links">
            <a href="{{ route('home') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ route('profil') }}" class="{{ Request::is('profil-desa') ? 'active' : '' }}">Profil Desa</a>
            <a href="{{ route('struktur') }}" class="{{ Request::is('struktur') ? 'active' : '' }}">Struktur</a>
            <a href="{{ route('berita') }}" class="{{ Request::is('berita*') ? 'active' : '' }}">Berita</a>
            <a href="{{ route('galeri') }}" class="{{ Request::is('galeri') ? 'active' : '' }}">Galeri</a>
            
            {{-- PERBAIKAN: Mengganti kelas 'btn-baca' dengan 'navbar-login-link' --}}
            @guest {{-- Tampilkan hanya jika user BELUM login --}}
                <a href="{{ route('login') }}" class="navbar-login-link {{ Request::is('login') ? 'active' : '' }}">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            @endguest
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            
            <div class="footer-col footer-col-1">
                <div class="footer-logo">
                    <img src="{{ $desa->logo ? asset('storage/' . $desa->logo) : asset('images/logo-desa.png') }}" alt="Logo Desa" class="logo">
                    <div class="logo-text">
                        <strong>{{ $desa->name ?? 'Desa' }}</strong>
                        <span>{{ $desa->kabupaten ?? 'Kabupaten' }}</span>
                    </div>
                </div>
                <p class="footer-about">
                    Website resmi Pemerintah {{ $desa->name }} sebagai sarana informasi publik,
                    transparansi, dan media komunikasi digital bagi seluruh warga.
                </p>
                <div class="social-links">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-col footer-col-2">
                <h4>Link Cepat</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('profil') }}">Profil Desa</a></li>
                    <li><a href="{{ route('struktur') }}">Struktur</a></li>
                    <li><a href="{{ route('berita') }}">Berita</a></li>
                    <li><a href="{{ route('galeri') }}">Galeri</a></li>
                </ul>
            </div>

            <div class="footer-col footer-col-3">
                <h4>Kontak Kami</h4>
                <ul>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $desa->address ?? 'Alamat Kantor' }}, Kec. {{ $desa->kecamatan ?? 'Kecamatan' }}, Kab. {{ $desa->kabupaten ?? 'Kabupaten' }}, {{ $desa->provinsi ?? 'Provinsi' }} {{ $desa->kode_pos ?? '' }}</span>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <span>{{ $desa->telepon ?? 'Telepon' }}</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>{{ $desa->email ?? 'Email' }}</span>
                    </li>
                    <li>
                        <i class="fas fa-clock"></i>
                        <span>{{ $desa->jam_kerja ?? 'Senin - Jumat: 08.00 - 16.00' }}</span>
                    </li>
                </ul>
            </div>

        </div>
        <div class="footer-bottom">
            <p>&copy; Copyright {{ date('Y') }} <strong>Pemerintah {{ $desa->name ?? 'Nama Desa' }}</strong>. Seluruh Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    {{-- SCRIPT --}}
    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) { 
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const navToggle = document.querySelector('.nav-toggle');
            const navLinks = document.getElementById('main-nav-links');

            navToggle.addEventListener('click', function() {
                navLinks.classList.toggle('nav-open');
                navToggle.classList.toggle('toggled'); // 'toggled' untuk animasi X
            });
        });
    </script>

</body>
</html>