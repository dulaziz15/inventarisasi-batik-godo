@extends('layout.admin')

@section('title', 'Halaman Informasi')
@section('page_title', 'Halaman Informasi')

@section('page_subtitle', 'Kelola konten tentang dan kontak agar halaman publik tetap relevan dan mudah ditemukan.')

@section('page_actions')
  <a href="{{ route('home') }}" class="btn btn-white btn-sm mb-0 shadow-sm" target="_blank"><i class="fa-solid fa-eye me-1"></i> Lihat Publik</a>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-body p-4 p-lg-5">
    <div class="mb-4">
      <p class="section-kicker mb-1"><i class="fa-solid fa-newspaper me-1"></i> Informasi Publik</p>
      <h2 class="admin-section-title mb-1 brand-serif">Edit Halaman Tentang & Kontak</h2>
      <p class="admin-section-lead mb-0 text-muted">Konten ini tampil langsung di halaman utama publik, harap tulis dengan kalimat deskriptif yang rapi.</p>
    </div>
    
    <form method="POST" action="{{ route('admin.information.update') }}" class="admin-form-grid">
      @csrf
      @method('PUT')
      
      <!-- Tentang Section -->
      <div class="admin-form-section">
        <h5 class="brand-serif fw-bold text-dark mb-3"><i class="fa-solid fa-landmark text-warning me-1"></i> Deskripsi Tentang Batik</h5>
        <div class="mb-2">
          <textarea name="tentang" rows="8" class="form-control" placeholder="Tuliskan gambaran umum sejarah, filosofi utama, dan esensi Batik Banyuwangi..." required style="border-radius: 0.75rem;">{{ old('tentang', $tentang->content) }}</textarea>
        </div>
        <div class="form-text text-muted small">Teks ini akan ditampilkan pada halaman "Tentang" publik.</div>
      </div>
      
      <!-- Kontak Section -->
      <div class="admin-form-section">
        <h5 class="brand-serif fw-bold text-dark mb-3"><i class="fa-solid fa-address-book text-warning me-1"></i> Informasi Kontak & Footer</h5>
        <div class="mb-2">
          <textarea name="kontak" rows="6" class="form-control" placeholder="Tuliskan nama paguyuban UMKM, nomor telepon, alamat lengkap, dan media sosial..." required style="border-radius: 0.75rem;">{{ old('kontak', $kontak->content) }}</textarea>
        </div>
        <div class="form-text text-muted small">Teks ini akan ditampilkan pada halaman "Kontak" publik dan area peta sekretariat.</div>
      </div>
      
      <!-- Actions -->
      <div class="admin-form-actions d-flex justify-content-end gap-2">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-4"><i class="fa-solid fa-xmark me-1"></i> Batal</a>
        <button class="btn btn-dark admin-action-btn px-4 shadow-sm" type="submit"><i class="fa-solid fa-circle-check me-1"></i> Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection