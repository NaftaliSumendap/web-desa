<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="admin-body">

    <div class="admin-wrapper">
        
        {{-- =================================
           SIDEBAR (Menu Kiri)
           ================================= --}}
        <aside class="sidebar">
            
            <div class="sidebar-header">
                <h2>
                    <a href="{{ route('admin.dashboard') }}">
                        Admin Panel Desa
                    </a>
                </h2>
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ Request::is('admin/dashboard*') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.profile.edit') }}" class="{{ Request::is('admin/profile*') ? 'active' : '' }}">
                            <i class="fas fa-landmark"></i> Detail Desa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.berita.index') }}" class="{{ Request::is('admin/berita*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper"></i> Berita
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.aparatur.index') }}" class="{{ Request::is('admin/aparatur*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Aparatur Desa
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.galeri.index') }}" class="{{ Request::is('admin/galeri*') ? 'active' : '' }}">
                            <i class="fas fa-images"></i> Galeri
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <ul>
                    <li>
                        <a href="{{ route('home') }}" target="_blank">
                            <i class="fas fa-globe"></i> Lihat Website
                        </a>
                    </li>
                    {{-- FORM LOGOUT BARU --}}
                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </aside>

        {{-- =================================
           KONTEN UTAMA (Kanan)
           ================================= --}}
        <div class="main-content">
            
            <header class="topbar">
                <button class="sidebar-toggle" aria-label="Toggle sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1>@yield('title')</h1>
                <div class="user-info">
                    {{-- Menampilkan nama user yang login --}}
                    Selamat datang, {{ auth()->user()->name ?? 'Admin' }}!
                </div>
            </header>

            <div class="admin-content-container">
                @yield('content')
            </div>
        </div>
    </div>

    <div id="toast-notification" class="toast">
        <div class="toast-icon">
            <i class="fas"></i>
        </div>
        <div class="toast-content">
            <span class="toast-title"></span>
            <span class="toast-message"></span>
        </div>
        <button class="toast-close">&times;</button>
    </div>


    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script Menu Mobile
            const toggleButton = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            if(toggleButton && sidebar) {
                toggleButton.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }

            // Script Pop-up
            const toast = document.getElementById('toast-notification');
            if (toast) {
                const toastTitle = toast.querySelector('.toast-title');
                const toastMessage = toast.querySelector('.toast-message');
                const toastIcon = toast.querySelector('.toast-icon i');
                const toastClose = toast.querySelector('.toast-close');
                let toastTimer;

                function showToast(title, message, type) {
                    clearTimeout(toastTimer);
                    toastTitle.textContent = title;
                    toastMessage.textContent = message;
                    toast.classList.remove('toast-success', 'toast-error', 'show');
                    toastIcon.classList.remove('fa-check-circle', 'fa-exclamation-triangle');

                    if (type === 'success') {
                        toast.classList.add('toast-success');
                        toastIcon.classList.add('fa-check-circle');
                    } else if (type === 'error') {
                        toast.classList.add('toast-error');
                        toastIcon.classList.add('fa-exclamation-triangle');
                    }
                    toast.classList.add('show');
                    toastTimer = setTimeout(() => {
                        toast.classList.remove('show');
                    }, 5000);
                }

                if (toastClose) {
                    toastClose.addEventListener('click', () => {
                        clearTimeout(toastTimer);
                        toast.classList.remove('show');
                    });
                }

                @if(session('success'))
                    showToast('Berhasil!', "{{ session('success') }}", 'success');
                @endif
                @if(session('error'))
                    showToast('Gagal!', "{{ session('error') }}", 'error');
                @endif
                @if ($errors->any())
                    // Tampilkan error validasi form hanya jika BUKAN di halaman login
                    @if (!Request::is('login'))
                        showToast('Gagal Validasi!', 'Periksa kembali data yang Anda masukkan.', 'error');
                    @endif
                @endif
            }
        });
    </script>
</body>
</html>