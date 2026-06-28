@extends('layout.app')

@section('title', 'Tentang Batik Banyuwangi')

@section('content')
<section class="container page-section">
  <div class="card border-0 shadow-sm p-4 p-lg-5">
    <p class="section-kicker mb-1"><i class="fa-solid fa-circle-info me-1"></i> Tentang</p>
    <h1 class="section-title mb-3" style="font-family: 'Cormorant Garamond', serif; font-weight: 800;">Sejarah dan Karakter Batik Banyuwangi</h1>
    <p class="section-lead mb-5 text-muted" style="line-height: 1.8;">
      {{ $aboutContent ?: 'Konten mengenai sejarah dan perkembangan industri Batik Banyuwangi belum diisi oleh administrator.' }}
    </p>

    <!-- Characteristics cards -->
    <div class="row g-4 mt-2">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <div class="feature-icon"><i class="fa-solid fa-palette"></i></div>
          <h2 class="h5 fw-bold mb-2">Ciri Khas Warna</h2>
          <p class="small text-muted mb-0" style="line-height: 1.6;">Warna-warna kontras tinggi yang berani seperti terakota alam, kuning keemasan, dan hijau rimba mempertegas keberanian karakter lokal.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <div class="feature-icon"><i class="fa-solid fa-people-group"></i></div>
          <h2 class="h5 fw-bold mb-2">Filosofi Tradisional</h2>
          <p class="small text-muted mb-0" style="line-height: 1.6;">Kebersamaan, keseimbangan spiritual, dan penghormatan leluhur dituangkan secara simbolis dalam guratan garis motif geometris maupun non-geometris.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <div class="feature-icon"><i class="fa-solid fa-calendar-check"></i></div>
          <h2 class="h5 fw-bold mb-2">Apresiasi & Regenerasi</h2>
          <p class="small text-muted mb-0" style="line-height: 1.6;">Melalui pelestarian terstruktur dan festival batik tahunan, generasi muda dirangkul agar mencintai dan menjaga keaslian motif leluhur.</p>
        </div>
      </div>
    </div>

    <!-- Pending Motifs Warning Section -->
    <div class="cta-band mt-5">
      <div class="position-relative z-index-2">
        <p class="section-kicker text-warning mb-2"><i class="fa-solid fa-magnifying-glass-chart me-1"></i> Agenda Penelitian & Pendataan</p>
        <h2 class="brand-serif text-white fs-3 mb-3">Motif yang Membutuhkan Pendalaman Data</h2>
        <p class="text-white-75 small mb-4" style="max-width: 75ch;">Daftar motif di bawah ini telah tercatat oleh sistem namun masih memerlukan validasi cerita tutur, verifikasi makna kepada sesepuh pembatik, atau kelengkapan dokumentasi visual.</p>
        
        @if ($pendingMotifs->isEmpty())
          <p class="mb-0 text-white-50 small italic">Seluruh motif terdata saat ini telah terverifikasi secara penuh.</p>
        @else
          <div class="row g-3">
            @foreach ($pendingMotifs as $motif)
              <div class="col-md-6 col-xl-4">
                <a href="{{ route('motifs.show', $motif) }}" class="text-decoration-none">
                  <div class="feature-card bg-white text-start p-3 h-100 border-0" style="border-radius: 1rem !important; transition: transform 0.2s;">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                      <div>
                        <div class="fw-bold text-dark mb-1">{{ $motif->name }}</div>
                        <div class="small text-muted" style="font-size: 0.8rem; line-height: 1.5;">{{ \Illuminate\Support\Str::limit($motif->philosophical_meaning, 70) }}</div>
                      </div>
                      <span class="badge bg-warning text-white flex-shrink-0" style="font-size: 0.65rem;">Riset</span>
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection