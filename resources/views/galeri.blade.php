{{-- Mewarisi layout utama --}}
@extends('layouts.app')

{{-- Mengatur judul halaman --}}
@section('title', 'Galeri Foto - Desa Tombasian Atas')

{{-- Mengisi konten --}}
@section('content')

{{-- Header Halaman --}}
<div class="page-header">
    <div class="container">
        <h1>Galeri Foto</h1>
        <p>Lihat berbagai kegiatan dan keindahan Desa Tombasian Atas</p>
    </div>
</div>

{{-- Konten Halaman --}}
<div class="page-content">
    <div class="container">
        
        <!-- Grid Galeri -->
        <div class="photo-gallery-grid">
            
            {{-- Loop data $photos dari controller --}}
            @forelse($photos as $photo)
            <div class="photo-card" onclick="openModal('{{ asset('storage/' . $photo->path) }}', '{{ $photo->caption }}')">
                {{-- PASTIKAN MENGGUNAKAN $photo->path --}}
                <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->caption }}" loading="lazy">
                <div class="photo-caption">
                    <p>{{ $photo->caption }}</p>
                </div>
            </div>
            @empty
            <p class="text-center w-full">Saat ini belum ada foto di galeri. Silakan tambahkan foto melalui halaman Admin.</p>
            @endforelse

        </div>

        <!-- Pagination -->
        <div class="pagination-links mt-5">
            {{ $photos->links() }}
        </div>
    </div>
</div>

<!-- Modal untuk View Foto Lebih Besar (Lightbox) -->
<div id="photoModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
</div>

<style>
    /* Styling Dasar untuk Galeri */
    .photo-gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        padding-bottom: 40px;
    }

    .photo-card {
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .photo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .photo-card img {
        width: 100%;
        height: 250px; /* Tinggi tetap untuk konsistensi */
        object-fit: cover;
        display: block;
    }

    .photo-caption {
        padding: 15px;
        text-align: center;
        font-size: 0.9em;
        color: #555;
        min-height: 60px; /* Agar card tidak bergeser jika caption pendek */
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* --- MODAL (Lightbox) Styling --- */
    .modal {
        display: none; /* Tersembunyi secara default */
        position: fixed; 
        z-index: 9999; /* Z-index tinggi agar tampil di atas semua */
        padding-top: 60px; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgba(0,0,0,0.9); /* Hitam dengan opasitas */
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 800px;
        max-height: 90vh;
        object-fit: contain;
    }

    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 800px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* Responsif untuk layar kecil */
    @media only screen and (max-width: 700px){
        .modal-content {
            width: 100%;
        }
        .photo-gallery-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    // Logika Modal (Lightbox)
    var modal = document.getElementById("photoModal");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");

    function openModal(src, caption) {
        modal.style.display = "block";
        modalImg.src = src;
        captionText.innerHTML = caption;
    }

    function closeModal() {
        modal.style.display = "none";
    }

    // Tutup modal jika user klik di luar gambar
    window.onclick = function(event) {
      if (event.target == modal) {
        closeModal();
      }
    }
</script>

@endsection
