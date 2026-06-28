@extends('layout.admin')

@section('title', 'Ganti Password')
@section('page_title', 'Ganti Password')

@section('page_subtitle', 'Ubah password akun admin dengan aman.')

@section('page_actions')
  <a href="{{ route('admin.dashboard') }}" class="btn btn-white btn-sm mb-0 shadow-sm"><i class="fa-solid fa-gauge-high me-1"></i> Dashboard</a>
@endsection

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-lg-8 col-xl-7">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4 p-lg-5">
        <div class="mb-4">
          <p class="section-kicker mb-1"><i class="fa-solid fa-shield-halved me-1"></i> Keamanan Akun</p>
          <h2 class="admin-section-title mb-1 brand-serif">Ubah Password</h2>
          <p class="admin-section-lead mb-0 text-readable-muted">Masukkan password lama, lalu buat password baru yang mudah diingat tetapi tetap kuat.</p>
        </div>
        
        <form method="POST" action="{{ route('admin.account.password.update') }}" class="admin-form-grid">
          @csrf
          @method('PUT')
          
          <div class="admin-form-section">
            <div class="mb-3">
              <label class="form-label fw-bold text-secondary small"><i class="fa-solid fa-lock me-1"></i> Password lama</label>
              <input type="password" name="current_password" class="form-control" required style="border-radius: 0.75rem;">
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold text-secondary small"><i class="fa-solid fa-key me-1"></i> Password baru</label>
              <input type="password" name="password" class="form-control" required style="border-radius: 0.75rem;">
            </div>
            <div class="mb-0">
              <label class="form-label fw-bold text-secondary small"><i class="fa-solid fa-circle-check me-1"></i> Konfirmasi password</label>
              <input type="password" name="password_confirmation" class="form-control" required style="border-radius: 0.75rem;">
            </div>
          </div>
          
          <!-- Actions -->
          <div class="admin-form-actions d-flex justify-content-end gap-2 mt-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary px-4"><i class="fa-solid fa-xmark me-1"></i> Batal</a>
            <button class="btn btn-dark admin-action-btn px-4 shadow-sm" type="submit"><i class="fa-solid fa-key me-1"></i> Simpan Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection