@extends('layout.app')

@section('title', 'Katalog Motif | Batik Banyuwangi')

@section('content')
<section class="container page-section">
  <!-- Title / Introduction -->
  <div class="card border-0 shadow-sm p-4 p-lg-5 mb-5">
    <div class="d-flex flex-column flex-lg-row gap-3 align-items-lg-end justify-content-between mb-4">
      <div>
        <p class="section-kicker mb-1"><i class="fa-solid fa-folder-open me-1"></i> Katalog Motif</p>
        <h1 class="section-title mb-0" style="font-size: clamp(2rem, 3.5vw, 2.8rem); font-family: 'Cormorant Garamond', serif; font-weight: 800;">
          {{ $totalMotifs }} motif terinventarisasi
        </h1>
      </div>
      <div class="section-lead mb-0 text-muted" style="max-width: 50ch;">
        Temukan informasi otentik mengenai motif batik, makna filosofisnya yang mendalam, dan status pendataannya di Banyuwangi.
      </div>
    </div>

    <!-- Search & Filter Form -->
    <div class="catalog-toolbar mb-4">
      <form method="GET" action="{{ route('catalog') }}" class="row g-3 align-items-end">
        <div class="col-lg-4 col-md-6">
          <label class="form-label fw-bold text-secondary small"><i class="fa-solid fa-search me-1"></i> Nama Motif</label>
          <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control search-input" placeholder="Cari nama motif (contoh: Gajah Oling)">
        </div>
        <div class="col-lg-3 col-md-6">
          <label class="form-label fw-bold text-secondary small"><i class="fa-solid fa-tags me-1"></i> Kategori Adat</label>
          <select name="kategori" class="form-select filter-select">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $value => $label)
              <option value="{{ $value }}" @selected(($filters['kategori'] ?? '') === $value)>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-lg-3 col-md-6">
          <label class="form-label fw-bold text-secondary small"><i class="fa-solid fa-brain me-1"></i> Kata Kunci Filosofi</label>
          <input type="text" name="makna" value="{{ $filters['makna'] ?? '' }}" class="form-control search-input" placeholder="Contoh: ketuhanan, persatuan">
        </div>
        <div class="col-lg-2 col-md-6">
          <div class="d-flex gap-2">
            <button class="btn btn-dark w-100 py-3 d-flex align-items-center justify-content-center gap-2" type="submit">
              <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>
            <a class="btn btn-outline-secondary px-3 py-3 d-flex align-items-center justify-content-center" href="{{ route('catalog') }}" title="Reset Filter">
              <i class="fa-solid fa-rotate-left"></i>
            </a>
          </div>
        </div>
      </form>
    </div>

    <!-- Feature highlights (UX pointers) -->
    <div class="row g-3">
      <div class="col-md-4">
        <div class="feature-card p-3 d-flex align-items-center gap-3 text-start">
          <div class="feature-icon mb-0 flex-shrink-0" style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem;"><i class="fa-solid fa-database" style="font-size: 1rem;"></i></div>
          <div>
            <h2 class="h6 mb-1 fw-bold">Pencarian Akurat</h2>
            <p class="small text-muted mb-0">Terhubung langsung ke database UMKM.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card p-3 d-flex align-items-center gap-3 text-start">
          <div class="feature-icon mb-0 flex-shrink-0" style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem;"><i class="fa-solid fa-sliders" style="font-size: 1rem;"></i></div>
          <div>
            <h2 class="h6 mb-1 fw-bold">Filter Kategori</h2>
            <p class="small text-muted mb-0">Pisahkan motif sakral dan motif umum.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card p-3 d-flex align-items-center gap-3 text-start">
          <div class="feature-icon mb-0 flex-shrink-0" style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem;"><i class="fa-solid fa-mobile-button" style="font-size: 1rem;"></i></div>
          <div>
            <h2 class="h6 mb-1 fw-bold">Responsivitas Penuh</h2>
            <p class="small text-muted mb-0">Akses nyaman dari HP maupun tablet.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Motif Grid -->
  <div class="row g-4">
    @forelse ($motifs as $motif)
      <div class="col-sm-6 col-lg-4 col-xl-3">
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
              <h2 class="h5 mb-2 fw-bold text-dark" style="font-family: 'Cormorant Garamond', serif; font-size: 1.3rem;">{{ $motif->name }}</h2>
              <p class="small text-muted mb-0" style="line-height: 1.6;">{{ \Illuminate\Support\Str::limit($motif->philosophical_meaning, 110) }}</p>
            </div>
          </div>
        </a>
      </div>
    @empty
      <div class="col-12">
        <div class="card border-0 shadow-sm p-5 text-center">
          <div class="feature-icon mx-auto"><i class="fa-solid fa-face-surprise"></i></div>
          <h2 class="h4 brand-serif fw-bold mb-2">Data motif tidak ditemukan</h2>
          <p class="text-muted mb-0">Coba gunakan kata kunci pencarian lain atau setel ulang filter kategori.</p>
        </div>
      </div>
    @endforelse
  </div>

  <!-- Pagination -->
  @if($motifs->hasPages())
    <div class="d-flex justify-content-center mt-5">
      <x-ui.pagination :paginator="$motifs" />
    </div>
  @endif
</section>
@endsection