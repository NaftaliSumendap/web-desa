    {{-- Mewarisi layout utama --}}
    @extends('layouts.app')

    {{-- Mengatur judul halaman --}}
    @section('title', 'Struktur Organisasi - Desa Tombasian Atas')

    {{-- Mengisi konten --}}
    @section('content')

    {{-- Header Halaman --}}
    <div class="page-header">
        <div class="container">
            <h1>Struktur Organisasi</h1>
            <p>Tata Kerja dan Aparat Pemerintah Desa Tombasian Atas</p>
        </div>
    </div>

    {{-- Konten Halaman --}}
    <div class="page-content">
        <div class="container">
            
            <!-- BAGIAN 1: BAGAN ORGANISASI -->
            <div class="content-section">
                <h2>Tata Kerja Pemerintah Desa</h2>
                
                <div class="org-chart">
                    <ul>
                        <li>
                            <!-- Kepala Desa -->
                            {{-- Cek jika data $kepalaDesa ada --}}
                            @if($kepalaDesa)
                            <div class="org-node">
                                <span>Kepala Desa</span>
                                {{-- Tampilkan nama dari database --}}
                                <strong>{{ $kepalaDesa->nama_lengkap }}</strong>
                            </div>
                            @else
                            <div class="org-node">
                                <span>Kepala Desa</span>
                                <strong>(Data Belum Diisi)</strong>
                            </div>
                            @endif

                            <ul>
                                <!-- Level 2: Kasi & Sekretaris -->
                                <li>
                                    <!-- Kasi (Kiri) -->
                                    @if($kasiKesejahteraan)
                                    <div class="org-node">
                                        <span>{{ $kasiKesejahteraan->jabatan }}</span>
                                        <strong>{{ $kasiKesejahteraan->nama_lengkap }}</strong>
                                    </div>
                                    @endif
                                    <ul>
                                        <!-- Staf Kasi -->
                                        {{-- Gunakan @forelse untuk perulangan data staf --}}
                                        @forelse($stafKasiKesejahteraan as $staf)
                                        <li><div class="org-node staff"><span>Staf</span><strong>{{ $staf->nama_lengkap }}</strong></div></li>
                                        @empty
                                        <li><div class="org-node staff"><span>Staf</span><strong>(Kosong)</strong></div></li>
                                        @endforelse
                                    </ul>
                                </li>
                                <li>
                                    <!-- Kasi (Tengah) -->
                                    @if($kasiPemerintahan)
                                    <div class="org-node">
                                        <span>{{ $kasiPemerintahan->jabatan }}</span>
                                        <strong>{{ $kasiPemerintahan->nama_lengkap }}</strong>
                                    </div>
                                    @endif
                                    <ul>
                                        <!-- Staf Kasi -->
                                        @forelse($stafKasiPemerintahan as $staf)
                                        <li><div class="org-node staff"><span>Staf</span><strong>{{ $staf->nama_lengkap }}</strong></div></li>
                                        @empty
                                        <li><div class="org-node staff"><span>Staf</span><strong>(Kosong)</strong></div></li>
                                        @endforelse
                                    </ul>
                                </li>
                                <li>
                                    <!-- Sekretaris (Kanan) -->
                                    @if($sekretaris)
                                    <div class="org-node">
                                        <span>Sekretaris Desa</span>
                                        <strong>{{ $sekretaris->nama_lengkap }}</strong>
                                    </div>
                                    @endif
                                    <ul>
                                        <!-- Kaur -->
                                        <li>
                                            @if($kaurUmum)
                                            <div class="org-node kaur">
                                                <span>{{ $kaurUmum->jabatan }}</span>
                                                <strong>{{ $kaurUmum->nama_lengkap }}</strong>
                                            </div>
                                            @endif
                                            <ul>
                                                <!-- Staf Kaur -->
                                                @forelse($stafKaurUmum as $staf)
                                                <li><div class="org-node staff"><span>Staf</span><strong>{{ $staf->nama_lengkap }}</strong></div></li>
                                                @empty
                                                <li><div class="org-node staff"><span>Staf</span><strong>(Kosong)</strong></div></li>
                                                @endforelse
                                            </ul>
                                        </li>
                                        <li>
                                            @if($kaurKeuangan)
                                            <div class="org-node kaur">
                                                <span>{{ $kaurKeuangan->jabatan }}</span>
                                                <strong>{{ $kaurKeuangan->nama_lengkap }}</strong>
                                            </div>
                                            @endif
                                            <ul>
                                                <!-- Staf Kaur -->
                                                @forelse($stafKaurKeuangan as $staf)
                                                <li><div class="org-node staff"><span>Staf</span><strong>{{ $staf->nama_lengkap }}</strong></div></li>
                                                @empty
                                                <li><div class="org-node staff"><span>Staf</span><strong>(Kosong)</strong></div></li>
                                                @endforelse
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <!-- Level Bawah: Kepala Dusun -->
                            <ul>
                                <li>
                                    @if($kadusElo)
                                    <div class="org-node kadus">
                                        <span>{{ $kadusElo->jabatan }}</span>
                                        <strong>{{ $kadusElo->nama_lengkap }}</strong>
                                    </div>
                                    @endif
                                </li>
                                <li>
                                    @if($kadusEmpang)
                                    <div class="org-node kadus">
                                        <span>{{ $kadusEmpang->jabatan }}</span>
                                        <strong>{{ $kadusEmpang->nama_lengkap }}</strong>
                                    </div>
                                    @endif
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- BAGIAN 2: GALERI APARAT -->
            <div class="content-section">
                <h2>Aparat Pemerintah Desa</h2>
                
                <div class="aparatur-grid aparatur-struktur-grid">
                    
                    {{-- Loop data $galeriAparatur dari controller --}}
                    @forelse($galeriAparatur as $aparat)
                    <div class="aparat-card-struktur">
                        {{-- Tampilkan foto jika ada, jika tidak, tampilkan placeholder --}}
                        <img src="{{ $aparat->foto ? asset('storage/' . $aparat->foto) : 'https://placehold.co/400x500/F5F5DC/333?text=Foto' }}" alt="Foto {{ $aparat->nama_lengkap }}">
                        <div class="aparat-info">
                            <h4>{{ $aparat->nama_lengkap }}</h4>
                            <p>{{ $aparat->jabatan }}</p>
                        </div>
                    </div>
                    @empty
                    <p>Data aparat belum tersedia.</p>
                    @endforelse

                </div>
            </div>

        </div>
    </div>

    @endsection

