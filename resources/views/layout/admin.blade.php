<!DOCTYPE html>
<html lang="en">

@include('components.header')

<body class="g-sidenav-show bg-gray-100 admin-shell-body">
  <div class="min-height-300 bg-gradient-dark position-absolute w-100 admin-hero-bg"></div>
  @include('components.sidebar')
  @if (session('success'))
    <div class="container position-relative z-index-3 pt-3 admin-alert-wrap">
      <div class="alert alert-success alert-dismissible fade show border-0 d-flex align-items-center gap-2 p-3 shadow-sm rounded-3" role="alert" style="background-color: rgba(6, 95, 70, 0.1); border-left: 4px solid var(--batik-emerald) !important;">
        <i class="fa-solid fa-circle-check text-success fs-5"></i>
        <div class="text-success-emphasis fw-semibold small">{{ session('success') }}</div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Tutup" style="filter: invert(0.5);"></button>
      </div>
    </div>
  @endif
  @if ($errors->any())
    <div class="container position-relative z-index-3 pt-3 admin-alert-wrap">
      <div class="alert alert-danger border-0 p-3 shadow-sm rounded-3" style="background-color: rgba(153, 27, 27, 0.1); border-left: 4px solid var(--batik-clay) !important;">
        <div class="d-flex align-items-center gap-2 mb-2">
          <i class="fa-solid fa-triangle-exclamation text-danger fs-5"></i>
          <div class="text-danger-emphasis fw-bold small">Periksa kembali isian berikut:</div>
        </div>
        <ul class="mb-0 ps-4 small text-danger-emphasis">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  <main class="main-content position-relative border-radius-lg admin-main-content">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{ route('home') }}">Publik</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">@yield('page_title', 'Dashboard')</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">@yield('page_title', 'Dashboard')</h6>
          @hasSection('page_subtitle')
            <p class="text-white small mb-0 mt-1 opacity-75">@yield('page_subtitle')</p>
          @endif
        </nav>
        <div class="d-flex align-items-center gap-2 d-xl-none ms-auto">
          <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav" aria-label="Buka sidebar admin">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
            </div>
          </a>
        </div>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center gap-2 flex-wrap justify-content-end">
            @yield('page_actions')
          </div>
        </div>
      </div>
    </nav>

    <div class="container-fluid py-4 admin-page-wrap">
      @yield('content')
    </div>
  </main>
  @include('components.fixed-plugin')
  @include('components.script')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var body = document.body;
      var sidenav = document.getElementById('sidenav-main');
      var openBtn = document.getElementById('iconNavbarSidenav');
      var closeBtn = document.getElementById('iconSidenav');

      if (!body || !sidenav) return;

      // Argon already binds its own toggle handlers when script loads correctly.
      if (typeof window.toggleSidenav === 'function') return;

      var openClass = 'g-sidenav-pinned';

      function toggleSidebar(event) {
        if (event) event.preventDefault();
        body.classList.toggle(openClass);
      }

      if (openBtn) {
        openBtn.addEventListener('click', toggleSidebar);
      }

      if (closeBtn) {
        closeBtn.addEventListener('click', toggleSidebar);
      }
    });
  </script>
  @stack('scripts')
</body>

</html>