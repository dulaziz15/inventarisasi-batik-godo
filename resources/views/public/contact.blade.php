@extends('layout.app')

@section('title', 'Kontak | Batik Banyuwangi')

@section('content')
<section class="container page-section">
  <div class="card border-0 shadow-sm p-4 p-lg-5">
    <p class="section-kicker mb-1"><i class="fa-solid fa-address-book me-1"></i> Kontak</p>
    <h1 class="section-title mb-3" style="font-family: 'Cormorant Garamond', serif; font-weight: 800;">Hubungi Kami & Informasi UMKM</h1>
    <p class="section-lead mb-5 text-muted">Kami menyambut masukan, kontribusi cerita motif dari masyarakat, serta kerja sama penelitian mengenai kain tenun dan batik khas Banyuwangi.</p>
    
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm p-4 p-lg-5 h-100 d-flex flex-column justify-content-between">
          <div>
            <div class="feature-icon mb-4"><i class="fa-solid fa-map-location-dot"></i></div>
            <h2 class="h5 fw-bold mb-3">Sekretariat & Paguyuban Pembatik</h2>
            <div class="text-secondary mb-4" style="line-height: 1.8; font-size: 0.95rem;">
              {!! nl2br(e($contactContent ?: 'Informasi alamat dan kontak UMKM pembatik belum dikonfigurasi.')) !!}
            </div>
          </div>
          <div class="border-top pt-4 mt-auto">
            <span class="small text-muted"><i class="fa-solid fa-clock me-1 text-warning"></i> Jam Operasional Layanan Publik: Senin - Jumat (08.00 - 16.00 WIB)</span>
          </div>
        </div>
      </div>
      
      <div class="col-lg-5">
        <div class="cta-band h-100 d-flex flex-column justify-content-between p-4 p-lg-5" style="border-radius: 1.5rem !important;">
          <div>
            <h2 class="brand-serif text-white fs-3 mb-3">Tujuan Inventarisasi</h2>
            <ul class="text-white-75 mb-4 ps-3 small d-flex flex-column gap-2" style="line-height: 1.6;">
              <li>Mendokumentasikan tacit knowledge dari maestro batik agar tidak hilang ditelan zaman.</li>
              <li>Menjadi rujukan resmi bagi desainer, akademisi, pembatik lokal, dan masyarakat umum.</li>
              <li>Mengekspor data inventarisasi untuk keperluan riset kebudayaan dan laporan UMKM terkait.</li>
            </ul>
          </div>
          <div class="d-grid gap-2 d-sm-flex">
            <a href="{{ route('catalog') }}" class="btn btn-warning text-white fw-bold px-4 py-3"><i class="fa-solid fa-rectangle-list me-1"></i> Buka Katalog</a>
            <a href="{{ route('home') }}" class="btn btn-outline-light px-4 py-3"><i class="fa-solid fa-home me-1"></i> Ke Beranda</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection