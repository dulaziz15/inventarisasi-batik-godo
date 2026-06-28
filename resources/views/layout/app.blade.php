<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Inventarisasi Batik Banyuwangi')</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Cormorant+Garamond:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link href={{ asset("template/assets/css/nucleo-icons.css")}} rel="stylesheet" />
  <link href={{ asset("template/assets/css/nucleo-svg.css")}} rel="stylesheet" />
  <link id="pagestyle" href={{ asset("template/assets/css/argon-dashboard.css?v=2.1.0")}} rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="{{ asset('css/batik.css') }}">
  @stack('styles')
</head>
<body class="site-body">
  <nav class="navbar navbar-expand-lg navbar-dark navbar-batik sticky-top shadow-sm py-3">
    <div class="container">
      <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
        <span class="admin-sidenav-mark" style="width: 1.8rem; height: 1.8rem; font-size: 0.8rem; border-radius: 0.5rem; display: inline-flex; align-items: center; justify-content: center;">BG</span>
        <span class="brand-serif">Batik Banyuwangi</span>
      </a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar" aria-controls="publicNavbar" aria-expanded="false" aria-label="Navigasi">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="publicNavbar">
        <ul class="navbar-nav ms-auto gap-lg-2">
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('catalog') || request()->routeIs('motifs.show') ? 'active' : '' }}" href="{{ route('catalog') }}">Katalog</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Kontak</a></li>
          @auth
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge me-1"></i> Dashboard</a></li>
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-warning ms-lg-2 mt-2 mt-lg-0 px-3 py-2"><i class="fa-solid fa-sign-out me-1"></i> Keluar</button>
              </form>
            </li>
          @else
            <li class="nav-item"><a class="btn btn-sm btn-outline-primary text-white border-white ms-lg-2 mt-2 mt-lg-0 px-3 py-2" href="{{ route('login') }}"><i class="fa-solid fa-user-lock me-1"></i> Masuk Admin</a></li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  <main>
    @yield('content')
  </main>

  @guest
    @unless(request()->routeIs('login'))
      <a href="{{ route('login') }}" class="quick-admin-login" aria-label="Quick Access Login Admin">
        <i class="fa-solid fa-user-lock" aria-hidden="true"></i>
        <span>Login Admin</span>
      </a>
    @endunless
  @endguest

  @stack('modals')

  <footer class="footer-batik text-white py-5 mt-5">
    <div class="container">
      <div class="row g-4 align-items-start">
        <div class="col-lg-6">
          <h5 class="brand-serif text-white fs-3 mb-3">Batik Banyuwangi</h5>
          <p class="text-white-75 mb-0" style="max-width: 48ch;">Dokumentasi motif, filosofi, teknik pembuatan, dan pelestarian adat budaya Batik Banyuwangi sebagai media edukasi publik dan umkm.</p>
        </div>
        <div class="col-md-6 col-lg-3">
          <p class="mb-3 fw-bold text-uppercase tracking-wider small text-white-50" style="letter-spacing: 0.1em;">Menu Navigasi</p>
          <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
            <li><a class="footer-link" href="{{ route('catalog') }}"><i class="fa-solid fa-chevron-right me-2 font-size-xs opacity-50"></i>Katalog Motif</a></li>
            <li><a class="footer-link" href="{{ route('about') }}"><i class="fa-solid fa-chevron-right me-2 font-size-xs opacity-50"></i>Tentang Kami</a></li>
            <li><a class="footer-link" href="{{ route('contact') }}"><i class="fa-solid fa-chevron-right me-2 font-size-xs opacity-50"></i>Kontak & Alamat</a></li>
          </ul>
        </div>
        <div class="col-md-6 col-lg-3">
          <p class="mb-3 fw-bold text-uppercase tracking-wider small text-white-50" style="letter-spacing: 0.1em;">Akses Pengguna</p>
          <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
            <li><a class="footer-link" href="{{ route('login') }}"><i class="fa-solid fa-lock me-2 opacity-50"></i>Login Admin Portal</a></li>
            <li><a class="footer-link" href="{{ route('home') }}"><i class="fa-solid fa-home me-2 opacity-50"></i>Kembali Beranda</a></li>
          </ul>
        </div>
      </div>
      <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
      <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
        <p class="small text-white-50 mb-0">&copy; {{ date('Y') }} Batik Banyuwangi. Hak cipta dilindungi undang-undang.</p>
        <p class="small text-white-50 mb-0">Melestarikan tacit knowledge maestro batik.</p>
      </div>
    </div>
  </footer>

  <script src={{ asset("template/assets/js/core/popper.min.js")}}></script>
  <script src={{ asset("template/assets/js/core/bootstrap.min.js")}}></script>
  <script src={{ asset("template/assets/js/plugins/perfect-scrollbar.min.js")}}></script>
  <script src={{ asset("template/assets/js/plugins/smooth-scrollbar.min.js")}}></script>
  <script src={{ asset("template/assets/js/argon-dashboard.min.js?v=2.1.0")}}></script>
  <script src="{{ asset('js/batik.js') }}"></script>
  @stack('scripts')
</body>
</html>