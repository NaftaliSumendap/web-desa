{{-- Mewarisi layout utama --}}
@extends('layouts.app')

{{-- Mengatur judul halaman --}}
@section('title', 'Galeri - Desa Tombasian Atas')

{{-- Mengisi konten --}}
@section('content')

{{-- Header Halaman --}}
<div class="page-header">
    <div class="container">
        <h1>Galeri Desa</h1>
        <p>Dokumentasi Kegiatan dan Pemandangan Desa Tombasian Atas</p>
    </div>
</div>

{{-- Konten Halaman (Grid Galeri) --}}
<div class="page-content">
    <div class="container">
        
        <div class="gallery-grid">
            <!-- 
                CATATAN: 
                - Ganti 'href' dengan link ke gambar resolusi TINGGI.
                - Ganti 'src' di dalam <img> dengan link ke gambar thumbnail.
                - Isi 'data-caption' dengan keterangan foto.
            -->

            <!-- Baris 1 -->
            <a href="https://placehold.co/800x600/58641D/white?text=Foto+Kegiatan+1" class="gallery-item" data-caption="Keterangan untuk Foto Kegiatan 1">
                <div class="gallery-image-wrap">
                    <img src="https://placehold.co/400x300/58641D/white?text=Foto+Kegiatan+1" alt="Foto Galeri 1">
                </div>
                <div class="gallery-caption">
                    <p>Foto Kegiatan 1</p>
                </div>
            </a>
            <a href="https://placehold.co/800x600/7B904B/white?text=Foto+Kegiatan+2" class="gallery-item" data-caption="Keterangan untuk Foto Kegiatan 2">
                <div class="gallery-image-wrap">
                    <img src="https://placehold.co/400x300/7B904B/white?text=Foto+Kegiatan+2" alt="Foto Galeri 2">
                </div>
                <div class="gallery-caption">
                    <p>Foto Kegiatan 2</p>
                </div>
            </a>
            <a href="https://placehold.co/800x600/273B09/white?text=Foto+Kegiatan+3" class="gallery-item" data-caption="Keterangan untuk Foto Kegiatan 3">
                <div class="gallery-image-wrap">
                    <img src="https://placehold.co/400x300/273B09/white?text=Foto+Kegiatan+3" alt="Foto Galeri 3">
                </div>
                <div class="gallery-caption">
                    <p>Foto Kegiatan 3</p>
                </div>
            </a>

            <!-- Baris 2 -->
            <a href="https://placehold.co/800x600/BBCF8D/black?text=Pemandangan+1" class="gallery-item" data-caption="Keterangan untuk Pemandangan 1">
                <div class="gallery-image-wrap">
                    <img src="https://placehold.co/400x300/BBCF8D/black?text=Pemandangan+1" alt="Foto Galeri 4">
                </div>
                <div class="gallery-caption">
                    <p>Pemandangan 1</p>
                </div>
            </a>
            <a href="https://placehold.co/800x600/58641D/white?text=Pemandangan+2" class="gallery-item" data-caption="Keterangan untuk Pemandangan 2">
                <div class="gallery-image-wrap">
                    <img src="https://placehold.co/400x300/58641D/white?text=Pemandangan+2" alt="Foto Galeri 5">
                </div>
                <div class="gallery-caption">
                    <p>Pemandangan 2</p>
                </div>
            </a>
            <a href="https://placehold.co/800x600/7B904B/white?text=Pemandangan+3" class="gallery-item" data-caption="Keterangan untuk Pemandangan 3">
                <div class="gallery-image-wrap">
                    <img src="https://placehold.co/400x300/7B904B/white?text=Pemandangan+3" alt="Foto Galeri 6">
                </div>
                <div class="gallery-caption">
                    <p>Pemandangan 3</p>
                </div>
            </a>
        </div>

    </div>
</div>

<!-- Struktur Modal Lightbox (Pop-up Gambar) -->
<div id="lightboxModal" class="lightbox">
    <span class="lightbox-close">&times;</span>
    <img class="lightbox-content" id="lightboxImage">
    <div id="lightboxCaption" class="lightbox-caption"></div>
</div>


<!-- JavaScript untuk Lightbox -->
<script>
// Kita taruh script di sini agar hanya berjalan di halaman galeri
document.addEventListener('DOMContentLoaded', function() {
    const galleryItems = document.querySelectorAll('.gallery-item');
    const modal = document.getElementById('lightboxModal');
    const modalImg = document.getElementById('lightboxImage');
    const modalCaption = document.getElementById('lightboxCaption');
    const closeModal = document.querySelector('.lightbox-close');

    galleryItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah link terbuka di halaman baru
            const captionText = this.dataset.caption || ''; // Ambil caption dari data-caption
            
            modal.style.display = 'flex'; // Tampilkan modal
            modalImg.src = this.href; // Set gambar modal dari 'href' link
            modalCaption.textContent = captionText; // Set teks caption
        });
    });

    // Fungsi untuk menutup modal
    function closeLightbox() {
        modal.style.display = 'none';
        modalImg.src = ''; // Kosongkan src
        modalCaption.textContent = ''; // Kosongkan caption
    }

    // Tombol 'X' untuk menutup
    closeModal.addEventListener('click', closeLightbox);
    
    // Tutup juga saat klik di area gelap (di luar gambar)
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeLightbox();
        }
    });

    // Tutup dengan tombol 'Escape'
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            closeLightbox();
        }
    });
});
</script>

@endsection

