@extends('layout.app')

@section('title', 'Login Admin | Batik Banyuwangi')

@section('content')
<section class="container page-section" style="max-width: 1050px;">
  <!-- Split Container Card -->
  <div class="row g-0 rounded-5 overflow-hidden shadow-lg border bg-white" style="border-radius: 2rem !important;">
    
    <!-- Left Column: Visual Panel (Desktop only) -->
    <div class="col-lg-5 d-none d-lg-flex flex-column justify-content-between p-5 text-white position-relative" style="background: linear-gradient(135deg, var(--batik-ink) 0%, #1e1b4b 100%); min-height: 520px;">
      <!-- Subtle Decorative Circles -->
      <div class="login-pattern-overlay"></div>
      
      <div class="position-relative z-3">
        <a class="d-inline-flex align-items-center gap-2 text-decoration-none text-white mb-4" href="{{ route('home') }}">
          <span class="admin-sidenav-mark" style="width: 2.2rem; height: 2.2rem; font-size: 1rem; border-radius: 0.75rem; display: inline-flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--batik-clay), var(--batik-amber));">BG</span>
          <span class="brand-serif fs-4 fw-bold">Batik Banyuwangi</span>
        </a>
        <h2 class="brand-serif text-white fs-2 fw-bold leading-tight mt-4">Pusat Data & Inventarisasi Adat</h2>
        <p class="text-white-75 small mt-3" style="line-height: 1.7;">Masuk sebagai administrator untuk melakukan verifikasi motif baru, mengubah aturan penggunaan adat, dan mengelola bank pengetahuan UMKM.</p>
      </div>

      <!-- Quick Info / Statistics Footer -->
      <div class="position-relative z-3 border-top border-white border-opacity-10 pt-4 mt-auto">
        <div class="d-flex align-items-center gap-2 text-warning small fw-bold mb-2">
          <i class="fa-solid fa-circle-check"></i> <span>Akses Pengelolaan Aman</span>
        </div>
        <p class="small text-white-50 mb-0">Hanya untuk staf kebudayaan dan admin terdaftar.</p>
      </div>
    </div>

    <!-- Right Column: Login Form -->
    <div class="col-lg-7 p-4 p-lg-5 d-flex flex-column justify-content-center bg-light">
      <div class="px-lg-3">
        <p class="section-kicker mb-1"><i class="fa-solid fa-user-shield me-1"></i> Gerbang Admin</p>
        <h1 class="h3 fw-bold mb-4" style="color: var(--batik-ink);">Selamat Datang Kembali</h1>
        
        <form method="POST" action="{{ route('login.store') }}" class="row g-3">
          @csrf
          <div class="col-12">
            <label class="form-label fw-bold text-secondary small"><i class="fa-solid fa-envelope me-1"></i> Email Administrator</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg" placeholder="nama@batikgodo.test" required autofocus style="border-radius: 0.75rem;">
          </div>
          <div class="col-12">
            <label class="form-label fw-bold text-secondary small"><i class="fa-solid fa-lock me-1"></i> Password</label>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••" required style="border-radius: 0.75rem;">
          </div>
          
          <div class="col-12 d-flex justify-content-between align-items-center mt-3">
            <label class="form-check-label text-secondary small cursor-pointer">
              <input type="checkbox" name="remember" class="form-check-input me-1 border-secondary"> Ingat Sesi Saya
            </label>
          </div>
          
          <div class="col-12 mt-4">
            <button class="btn btn-dark btn-lg w-100 py-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2" type="submit" style="border-radius: 0.75rem;">
              <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Sistem
            </button>
          </div>
        </form>

        <!-- Informative Demo Credentials Alert -->
        <div class="alert bg-warning bg-opacity-10 border border-warning border-opacity-25 mt-4 mb-0 p-3" style="border-radius: 1rem;">
          <div class="d-flex gap-2">
            <i class="fa-solid fa-circle-info text-warning mt-1"></i>
            <div>
              <div class="fw-bold text-dark small">Kredensial Demo Awal:</div>
              <div class="text-secondary small mt-1">
                <span>Email: <strong>admin@batikgodo.test</strong></span><br>
                <span>Password: <strong>password</strong></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection