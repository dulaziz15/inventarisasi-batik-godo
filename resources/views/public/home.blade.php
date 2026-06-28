@extends('layout.app')

@section('title', 'Beranda | Inventarisasi Batik Banyuwangi')

@section('content')
<section class="container page-section">
  <!-- Hero Section -->
  <div class="hero-panel p-4 p-lg-5 shadow-lg mb-5 animate-fade-in">
    <div class="hero-grid position-relative z-1">
      <div class="hero-copy py-lg-4">
        <div class="hero-badges">
          <span class="hero-badge"><i class="fa-solid fa-book-bookmark text-warning"></i> Inventarisasi Motif</span>
          <span class="hero-badge"><i class="fa-solid fa-users text-warning"></i> Untuk UMKM & Publik</span>
          <span class="hero-badge"><i class="fa-solid fa-circle-check text-warning"></i> Terverifikasi Adat</span>
        </div>
        <p class="section-kicker text-warning mb-2"><i class="fa-solid fa-palette me-1"></i> Warisan Leluhur Banyuwangi</p>
        <h1 class="section-title text-white mb-4" style="font-family: 'Cormorant Garamond', serif; font-weight: 800; line-height: 1.15;">
          Satu tempat untuk menjelajah, memahami, dan menjaga Batik Banyuwangi.
        </h1>
        <p class="lead mb-4 text-white-75 text-light opacity-90" style="max-width: 60ch; font-size: 1.05rem; line-height: 1.7;">
          Sistem ini mendokumentasikan motif, filosofi mendalam, teknik pembuatan, aturan adat penggunaan, dan sumber pengetahuan terpercaya agar warisan takbenda maestro batik tetap lestari.
        </p>
        <div class="d-flex flex-wrap gap-3">
          <a href="{{ route('catalog') }}" class="btn btn-warning btn-lg fw-bold px-4 py-3"><i class="fa-solid fa-magnifying-glass me-2"></i> Jelajahi Katalog</a>
          <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4 py-3"><i class="fa-solid fa-circle-info me-2"></i> Pelajari Karakteristik</a>
        </div>
      </div>
      <div class="hero-art animate-float">
        <img src="{{ asset('images/motif-placeholder.svg') }}" alt="Ilustrasi Batik Banyuwangi" class="hero-art-pattern">
        <div class="hero-art-card">
          <div class="row g-2 text-center">
            <div class="col-4">
              <div class="hero-stat">
                <div class="hero-stat-value">{{ $motifCount }}</div>
                <div class="hero-stat-label">Motif</div>
              </div>
            </div>
            <div class="col-4">
              <div class="hero-stat">
                <div class="hero-stat-value text-danger">{{ $sacredCount }}</div>
                <div class="hero-stat-label">Sakral</div>
              </div>
            </div>
            <div class="col-4">
              <div class="hero-stat">
                <div class="hero-stat-value text-success">{{ $verifiedCount }}</div>
                <div class="hero-stat-label">Valid</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- About System & Quick Access Section -->
  <div class="page-section pt-0">
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm p-4 p-lg-5 h-100">
          <p class="section-kicker mb-2"><i class="fa-solid fa-circle-info me-1"></i> Tentang Sistem</p>
          <h2 class="section-title mb-4" style="font-size: clamp(1.8rem, 2.8vw, 2.5rem); font-family: 'Cormorant Garamond', serif;">
            Menyatukan data motif, makna filosofis, dan aturan penggunaan adat dalam satu ruang akses digital yang praktis.
          </h2>
          <p class="section-lead mb-0 text-muted" style="font-size: 1rem; line-height: 1.8;">
            {{ $aboutContent ?: 'Sistem Inventarisasi Batik ini dirancang untuk mendata motif-motif batik Banyuwangi beserta maknanya secara lengkap. Admin dapat mengelola konten sejarah umum di halaman admin.' }}
          </p>
        </div>
      </div>
      
      <div class="col-lg-5">
        <div class="card border-0 shadow-sm p-4 p-lg-5 h-100 d-flex flex-column justify-content-between">
          <div>
            <p class="section-kicker mb-3"><i class="fa-solid fa-compass me-1"></i> Akses Cepat Navigasi</p>
          </div>
          <div class="d-flex flex-column gap-3">
            <a class="feature-card d-flex align-items-center gap-3 text-start text-decoration-none text-dark p-3" href="{{ route('catalog') }}">
              <div class="feature-icon mb-0 flex-shrink-0"><i class="fa-solid fa-border-all"></i></div>
              <div>
                <h3 class="h6 mb-1 fw-bold">Katalog Motif</h3>
                <p class="small text-muted mb-0">Cari motif berdasarkan makna filosofi dan kategori adat.</p>
              </div>
            </a>
            
            <a class="feature-card d-flex align-items-center gap-3 text-start text-decoration-none text-dark p-3" href="{{ route('about') }}">
              <div class="feature-icon mb-0 flex-shrink-0"><i class="fa-solid fa-landmark"></i></div>
              <div>
                <h3 class="h6 mb-1 fw-bold">Tentang Batik Banyuwangi</h3>
                <p class="small text-muted mb-0">Pelajari ciri warna khas, festival tahunan, dan sejarah kain.</p>
              </div>
            </a>
            
            <a class="feature-card d-flex align-items-center gap-3 text-start text-decoration-none text-dark p-3" href="{{ route('contact') }}">
              <div class="feature-icon mb-0 flex-shrink-0"><i class="fa-solid fa-phone"></i></div>
              <div>
                <h3 class="h6 mb-1 fw-bold">Kontak Kami</h3>
                <p class="small text-muted mb-0">Informasi alamat UMKM pembatik dan saluran bantuan.</p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Featured / Latest Motifs Grid -->
  <div class="page-section pt-0">
    <div class="d-flex flex-wrap align-items-end justify-content-between mb-4 gap-2">
      <div>
        <p class="section-kicker mb-1"><i class="fa-solid fa-star me-1"></i> Motif Terbaru</p>
        <h2 class="section-title mb-0" style="font-size: clamp(1.8rem, 2.8vw, 2.5rem); font-family: 'Cormorant Garamond', serif;">Koleksi awal hasil inventarisasi batik</h2>
      </div>
      <a href="{{ route('catalog') }}" class="btn btn-outline-dark px-4 py-2"><i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Lihat Semua Katalog</a>
    </div>

    <div class="row g-4">
      @foreach ($featuredMotifs as $motif)
        <div class="col-md-6 col-xl-3">
          <a href="{{ route('motifs.show', $motif) }}" class="catalog-link h-100 d-block">
            <div class="card motif-card h-100 border-0 {{ $motif->isSakral() ? 'border-danger-subtle' : '' }}">
              <div class="position-relative overflow-hidden">
                <img src="{{ $motif->thumbnailUrl() }}" alt="{{ $motif->name }}" class="motif-thumb card-img-top">
                <div class="position-absolute top-0 start-0 p-3 w-100 d-flex justify-content-between align-items-start" style="z-index: 10;">
                  <span class="badge {{ $motif->isSakral() ? 'badge-sakral' : 'bg-success text-white' }}">{{ $motif->categoryLabel() }}</span>
                  <span class="badge badge-soft">{{ $motif->verificationLabel() }}</span>
                </div>
              </div>
              <div class="card-body bg-white p-4">
                <h3 class="h5 mb-2 fw-bold text-dark" style="font-family: 'Cormorant Garamond', serif; font-size: 1.3rem;">{{ $motif->name }}</h3>
                <p class="small text-muted mb-0" style="line-height: 1.6;">{{ \Illuminate\Support\Str::limit($motif->philosophical_meaning, 90) }}</p>
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection