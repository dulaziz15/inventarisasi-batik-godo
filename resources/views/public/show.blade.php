@extends('layout.app')

@section('title', $motif->name.' | Detail Motif')

@push('modals')
<div class="modal fade" id="motifImageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content border-0 overflow-hidden" style="border-radius: 1.5rem;">
      <div class="modal-header bg-dark text-white border-0 py-3 px-4">
        <h5 class="modal-title brand-serif text-white fs-4" data-lightbox-title>{{ $motif->name }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body p-0 bg-light">
        <img src="{{ $motif->imageUrl() }}" alt="{{ $motif->name }}" class="img-fluid w-100" style="max-height: 80vh; object-fit: contain;" data-lightbox-image>
      </div>
    </div>
  </div>
</div>
@endpush

@section('content')
<section class="container page-section">
  <!-- Top Navigation & Action Panel -->
  <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between mb-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent p-0 mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted"><i class="fa-solid fa-home me-1"></i> Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('catalog') }}" class="text-decoration-none text-muted">Katalog</a></li>
        <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">{{ $motif->name }}</li>
      </ol>
    </nav>
    <div class="d-flex gap-2">
      <a href="{{ route('catalog') }}" class="btn btn-outline-dark px-3 py-2"><i class="fa-solid fa-chevron-left me-1"></i> Kembali</a>
      <button class="btn btn-warning text-white px-3 py-2" type="button" data-share-url="{{ url()->current() }}" data-share-title="{{ $motif->name }}"><i class="fa-solid fa-share-nodes me-1"></i> Bagikan</button>
    </div>
  </div>

  <!-- Alert for Sacred Motifs -->
  @if ($motif->isSakral())
    <div class="warning-sacred d-flex align-items-start gap-3 mb-4 animate-fade-in">
      <div class="feature-icon mb-0 flex-shrink-0 bg-danger bg-opacity-10 text-danger" style="width: 2.5rem; height: 2.5rem; border-radius: 0.75rem;"><i class="fa-solid fa-triangle-exclamation" style="font-size: 1.1rem;"></i></div>
      <div>
        <strong class="text-danger d-block mb-1">Perhatian Khusus Adat:</strong>
        <p class="small mb-0 text-secondary-emphasis">Motif ini masuk kategori sakral dengan makna luhur yang mendalam. Penggunaannya diimbau agar menyesuaikan dengan norma adat tradisional Banyuwangi.</p>
      </div>
    </div>
  @endif

  <!-- Detail Content Grid -->
  <div class="detail-hero">
    <!-- Left Column: Main Image & Gallery -->
    <div>
      <div class="detail-image-shell">
        <a href="javascript:void(0)" data-lightbox-src="{{ $motif->imageUrl() }}" data-lightbox-title="{{ $motif->name }}">
          <img src="{{ $motif->imageUrl() }}" alt="{{ $motif->name }}" class="detail-image">
        </a>
      </div>

      <!-- Additional Gallery Grid -->
      @if ($motif->galleries->count())
        <div class="card border-0 shadow-sm p-3 mt-3">
          <p class="small text-muted fw-bold mb-2 uppercase text-uppercase tracking-wider" style="font-size: 0.7rem; letter-spacing: 0.05em;"><i class="fa-solid fa-images me-1 text-warning"></i> Foto Galeri Detail</p>
          <div class="row g-2">
            @foreach ($motif->galleries as $gallery)
              <div class="col-6 col-md-4">
                <a href="javascript:void(0)" data-lightbox-src="{{ $gallery->imageUrl() }}" data-lightbox-title="{{ $motif->name }} - Galeri">
                  <div class="overflow-hidden rounded-3 border" style="aspect-ratio: 4 / 3;">
                    <img src="{{ $gallery->imageUrl() }}" alt="Galeri {{ $motif->name }}" class="img-fluid w-100 h-100 hover-zoom" style="object-fit: cover; transition: transform var(--transition-fast);">
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>

    <!-- Right Column: Metadata Panel -->
    <div class="detail-panel shadow-sm">
      <div class="d-flex flex-wrap gap-2 mb-3">
        <span class="badge {{ $motif->isSakral() ? 'badge-sakral' : 'bg-success text-white' }}"><i class="fa-solid fa-circle-exclamation me-1"></i> {{ $motif->categoryLabel() }}</span>
        <span class="badge badge-soft"><i class="fa-solid fa-clipboard-check me-1 text-success"></i> {{ $motif->verificationLabel() }}</span>
        <span class="badge bg-light text-dark border"><i class="fa-solid fa-feather-pointed me-1 text-warning"></i> {{ $motif->techniqueLabel() }}</span>
      </div>
      
      <h1 class="brand-serif mb-3 fs-1 fw-bold">{{ $motif->name }}</h1>
      <p class="text-muted small mb-4" style="line-height: 1.6;">
        Berikut adalah dokumentasi mengenai asal-usul, filosofi, rekomendasi pengerjaan, dan kegunaan motif ini agar dapat dimanfaatkan secara bijaksana.
      </p>

      <!-- Key Metadata Grid -->
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <div class="detail-stat h-100">
            <div class="detail-stat-label"><i class="fa-solid fa-quote-left me-1"></i> Makna Filosofis</div>
            <div class="detail-stat-value text-dark" style="font-style: italic;">"{{ $motif->philosophical_meaning }}"</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-stat h-100">
            <div class="detail-stat-label"><i class="fa-solid fa-circle-nodes me-1"></i> Sumber Narasumber</div>
            <div class="detail-stat-value text-dark">{{ $motif->knowledge_source }}</div>
          </div>
        </div>
      </div>

      <!-- History Section -->
      <div class="mb-4">
        <div class="detail-stat-label"><i class="fa-solid fa-hourglass-start me-1"></i> Sejarah / Asal-usul</div>
        <p class="text-secondary mb-0" style="line-height: 1.7;">{{ $motif->history ?: 'Deskripsi sejarah belum terdokumentasi.' }}</p>
      </div>

      <!-- Visual Description -->
      <div class="mb-4">
        <div class="detail-stat-label"><i class="fa-solid fa-eye me-1"></i> Deskripsi Visual</div>
        <p class="text-secondary mb-0" style="line-height: 1.7;">{{ $motif->visual_description ?: 'Deskripsi visual detail belum terdokumentasi.' }}</p>
      </div>

      <!-- Technique & Usage Recommendation Cards -->
      <div class="row g-3">
        <div class="col-md-6">
          <div class="card border-0 shadow-sm p-3 h-100">
            <div class="detail-stat-label"><i class="fa-solid fa-wrench me-1"></i> Rekomendasi Teknik</div>
            <div class="detail-stat-value text-dark fw-bold">{{ $motif->techniqueLabel() }}</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card border-0 shadow-sm p-3 h-100">
            <div class="detail-stat-label"><i class="fa-solid fa-scale-balanced me-1"></i> Aturan Penggunaan</div>
            <div class="detail-stat-value text-dark fw-bold">{{ $motif->usageRuleLabel() }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Related Motifs Slider/List -->
  <div class="page-section pb-0 mt-3">
    <div class="d-flex align-items-end justify-content-between mb-4">
      <div>
        <p class="section-kicker mb-1"><i class="fa-solid fa-link me-1"></i> Motif Lainnya</p>
        <h2 class="section-title mb-0" style="font-size: clamp(1.6rem, 2.5vw, 2.2rem); font-family: 'Cormorant Garamond', serif;">Referensi Tambahan Motif Batik</h2>
      </div>
    </div>
    <div class="row g-4">
      @foreach ($relatedMotifs as $related)
        <div class="col-md-4">
          <a href="{{ route('motifs.show', $related) }}" class="catalog-link h-100 d-block">
            <div class="card motif-card h-100 border-0">
              <div class="overflow-hidden" style="aspect-ratio: 16/10;">
                <img src="{{ $related->thumbnailUrl() }}" alt="{{ $related->name }}" class="motif-thumb card-img-top">
              </div>
              <div class="card-body bg-white p-4">
                <h3 class="h5 mb-2 fw-bold text-dark" style="font-family: 'Cormorant Garamond', serif; font-size: 1.25rem;">{{ $related->name }}</h3>
                <p class="small text-muted mb-0" style="line-height: 1.6;">{{ \Illuminate\Support\Str::limit($related->philosophical_meaning, 90) }}</p>
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
</section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Custom dynamic Lightbox implementation
    const lightboxModalEl = document.getElementById('motifImageModal');
    const lightboxModal = new bootstrap.Modal(lightboxModalEl);
    const lightboxImg = lightboxModalEl.querySelector('[data-lightbox-image]');
    const lightboxTitle = lightboxModalEl.querySelector('[data-lightbox-title]');

    document.querySelectorAll('[data-lightbox-src]').forEach(trigger => {
      trigger.addEventListener('click', (e) => {
        e.preventDefault();
        const src = trigger.getAttribute('data-lightbox-src');
        const title = trigger.getAttribute('data-lightbox-title');
        
        lightboxImg.setAttribute('src', src);
        lightboxTitle.textContent = title;
        lightboxModal.show();
      });
    });

    // Share action
    const shareBtn = document.querySelector('[data-share-url]');
    if (shareBtn) {
      shareBtn.addEventListener('click', async () => {
        const url = shareBtn.getAttribute('data-share-url');
        const title = shareBtn.getAttribute('data-share-title');
        
        if (navigator.share) {
          try {
            await navigator.share({
              title: title,
              text: `Lihat makna filosofis batik ${title}`,
              url: url
            });
          } catch (err) {
            console.error('Share failed', err);
          }
        } else {
          // Fallback copy to clipboard
          try {
            await navigator.clipboard.writeText(url);
            const originalText = shareBtn.innerHTML;
            shareBtn.innerHTML = '<i class="fa-solid fa-circle-check"></i> URL Tersalin!';
            setTimeout(() => { shareBtn.innerHTML = originalText; }, 2000);
          } catch (err) {
            console.error('Clipboard copy failed', err);
          }
        }
      });
    }
  });
</script>
@endpush
@endsection