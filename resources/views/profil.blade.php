{{-- Mewarisi layout utama --}}
@extends('layouts.app')

{{-- Mengatur judul halaman --}}
@section('title', 'Profil Desa - ' . ($desa->name ?? 'Desa'))

{{-- Mengisi konten --}}
@section('content')

{{-- CSS Khusus untuk Grafik Kependudukan (jika Anda masih ingin menggunakannya) --}}
<style>
    .demografi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }
    .chart-container {
        margin-top: 20px;
        padding: 20px;
        background-color: var(--neutral-cream, #f9f9f9); 
        border-radius: 8px;
        border: 1px solid #eee;
    }
    .chart-label {
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        color: var(--text-dark, #333);
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    .chart-bar-bg {
        width: 100%;
        background-color: #e9e9e9;
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 15px;
    }
    .chart-bar-fill {
        height: 25px;
        border-radius: 0 5px 5px 0;
        transition: width 1s ease-in-out;
        padding-left: 10px;
        box-sizing: border-box;
        color: white;
        font-size: 0.8rem;
        font-weight: 700;
        line-height: 25px;
    }
    .pie-chart-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    .pie-chart {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: conic-gradient(
            var(--dark-olive-green-4) 0% {{ $desa->dem_laki_persen ?? 50 }}%, 
            var(--dark-olive-green-3) {{ $desa->dem_laki_persen ?? 50 }}% 100%
        );
    }
    .chart-legend {
        margin-left: 20px;
    }
    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .legend-color {
        width: 15px;
        height: 15px;
        border-radius: 3px;
        margin-right: 10px;
    }
</style>

<div class="page-header">
    <div class="container">
        <h1>Profil Desa {{ $desa->name ?? '' }}</h1>
        <p>Sejarah, Visi Misi, dan Struktur Pemerintahan</p>
    </div>
</div>

<div class="page-content">
    <div class="container">
        
        <div class="content-section">
            <h2>Sejarah Desa</h2>
            {{-- Data $desa ini diambil dari AppServiceProvider --}}
            {{-- nl2br(e(...)) digunakan agar enter (baris baru) di textarea tetap tampil --}}
            <p>{!! nl2br(e($desa->sejarah ?? 'Sejarah desa belum diisi. Silakan edit di dasbor admin.')) !!}</p>
        </div>

        <div class="content-section">
            <h2>Visi & Misi</h2>
            
            <h3>Visi</h3>
            <blockquote>
                <p>"{{ $desa->visi ?? 'Visi desa belum diisi.' }}"</p>
            </blockquote>

            <h3>Misi</h3>
            {{-- Kita gunakan <ol> (ordered list) jika misinya adalah daftar --}}
            {{-- Periksa apakah misi mengandung "1." atau "<li>" --}}
            @if(Str::contains($desa->misi, '1.') || Str::contains($desa->misi, '<li>'))
                {!! $desa->misi !!} {{-- Jika sudah HTML, tampilkan langsung --}}
            @else
                <p>{!! nl2br(e($desa->misi ?? 'Misi desa belum diisi.')) !!}</p>
            @endif
        </div>

        <div class="content-section">
            <h2>Kondisi Wilayah</h2>
            
            <h3>Luas Wilayah</h3>
            <p>{{ $desa->luas_wilayah ?? 'Data luas wilayah belum diisi.' }}</p>

            <h3>Batas Wilayah</h3>
            <p>{!! nl2br(e($desa->batas_wilayah ?? 'Data batas wilayah belum diisi.')) !!}</p>

            <h3>Kondisi Topografi</h3>
            <p>{!! nl2br(e($desa->kondisi_topografi ?? 'Data kondisi topografi belum diisi.')) !!}</p>
        </div>

        <div class="content-section">
            <h2>Data Kependudukan</h2>
            <p>Total Penduduk: <strong>{{ $desa->dem_total_penduduk ?? 0 }} Jiwa</strong></p>

            <div class="demografi-grid">
                
                {{-- Grafik Distribusi Kelamin --}}
                <div class="chart-container">
                    <h4>Distribusi Kelamin</h4>
                    <div class="pie-chart-container">
                        <div class="pie-chart"></div>
                        <div class="chart-legend">
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: var(--dark-olive-green-4);"></div>
                                <span>Laki-laki: {{ $desa->dem_laki ?? 0 }} ({{ $desa->dem_laki_persen ?? 0 }}%)</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color" style="background-color: var(--dark-olive-green-3);"></div>
                                <span>Perempuan: {{ $desa->dem_perempuan ?? 0 }} ({{ $desa->dem_perempuan_persen ?? 0 }}%)</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Grafik Agama --}}
                <div class="chart-container">
                    <h4>Distribusi Agama</h4>
                    @if($desa->dem_agama && json_decode($desa->dem_agama))
                        @foreach(json_decode($desa->dem_agama) as $item)
                            <div class="chart-label">
                                <span>{{ $item->label }}</span>
                                <span>{{ $item->value }} Jiwa</span>
                            </div>
                            <div class="chart-bar-bg">
                                @php
                                    $persen = ($desa->dem_total_penduduk > 0) ? ($item->value / $desa->dem_total_penduduk) * 100 : 0;
                                @endphp
                                <div class="chart-bar-fill" style="width: {{ $persen }}%; background-color: var(--dark-olive-green-3);">
                                    {{ number_format($persen, 1) }}%
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Data agama belum diisi.</p>
                    @endif
                </div>

                {{-- Grafik Pendidikan --}}
                <div class="chart-container">
                    <h4>Tingkat Pendidikan</h4>
                    @if($desa->dem_pendidikan && json_decode($desa->dem_pendidikan))
                        @foreach(json_decode($desa->dem_pendidikan) as $item)
                            <div class="chart-label">
                                <span>{{ $item->label }}</span>
                                <span>{{ $item->value }} Jiwa</span>
                            </div>
                            <div class="chart-bar-bg">
                                @php
                                    $persen = ($desa->dem_total_penduduk > 0) ? ($item->value / $desa->dem_total_penduduk) * 100 : 0;
                                @endphp
                                <div class="chart-bar-fill" style="width: {{ $persen }}%; background-color: var(--dark-olive-green-4);">
                                    {{ number_format($persen, 1) }}%
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Data pendidikan belum diisi.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="content-section">
            <h2>Tata Kerja Pemerintah Desa</h2>
            
            <div class="org-chart">
                <ul>
                    <li>
                        @if($kepalaDesa)
                        <div class="org-node">
                            <span>Kepala Desa</span>
                            <strong>{{ $kepalaDesa->nama_lengkap }}</strong>
                        </div>
                        @else
                        <div class="org-node">
                            <span>Kepala Desa</span>
                            <strong>(Data Belum Diisi)</strong>
                        </div>
                        @endif

                        <ul>
                            <li>
                                @if($kasiKesejahteraan)
                                <div class="org-node">
                                    <span>{{ $kasiKesejahteraan->jabatan }}</span>
                                    <strong>{{ $kasiKesejahteraan->nama_lengkap }}</strong>
                                </div>
                                @endif
                                <ul>
                                    @forelse($stafKasiKesejahteraan as $staf)
                                    <li><div class="org-node staff"><span>Staf</span><strong>{{ $staf->nama_lengkap }}</strong></div></li>
                                    @empty
                                    <li><div class="org-node staff"><span>Staf</span><strong>(Kosong)</strong></div></li>
                                    @endforelse
                                </ul>
                            </li>
                            <li>
                                @if($kasiPemerintahan)
                                <div class="org-node">
                                    <span>{{ $kasiPemerintahan->jabatan }}</span>
                                    <strong>{{ $kasiPemerintahan->nama_lengkap }}</strong>
                                </div>
                                @endif
                                <ul>
                                    @forelse($stafKasiPemerintahan as $staf)
                                    <li><div class="org-node staff"><span>Staf</span><strong>{{ $staf->nama_lengkap }}</strong></div></li>
                                    @empty
                                    <li><div class="org-node staff"><span>Staf</span><strong>(Kosong)</strong></div></li>
                                    @endforelse
                                </ul>
                            </li>
                            <li>
                                @if($sekretaris)
                                <div class="org-node">
                                    <span>Sekretaris Desa</span>
                                    <strong>{{ $sekretaris->nama_lengkap }}</strong>
                                </div>
                                @endif
                                <ul>
                                    <li>
                                        @if($kaurUmum)
                                        <div class="org-node kaur">
                                            <span>{{ $kaurUmum->jabatan }}</span>
                                            <strong>{{ $kaurUmum->nama_lengkap }}</strong>
                                        </div>
                                        @endif
                                        <ul>
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

        <div class="content-section">
            <h2>Aparat Pemerintah Desa</h2>
            
            <div class="aparatur-grid aparatur-struktur-grid">
                
                {{-- Loop data $galeriAparatur dari controller --}}
                @forelse($galeriAparatur as $aparat)
                <div class="aparat-card-struktur">
                    {{-- PERBAIKAN FOTO DEFAULT --}}
                    <img src="{{ $aparat->foto ? asset('storage/' . $aparat->foto) : asset('images/default-avatar.png') }}" alt="Foto {{ $aparat->nama_lengkap }}">
                    <div class="aparat-info">
                        <h4>{{ $aparat->nama_lengkap }}</h4>
                        <p>{{ $aparat->jabatan }}</p>
                    </div>
                </div>
                @empty
                <p>Data aparat belum tersedia. Silakan isi di dasbor admin.</p>
                @endforelse

            </div>
        </div>

    </div>
</div>

@endsection