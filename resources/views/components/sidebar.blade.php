<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 admin-sidenav" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0 admin-sidenav-brand d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
      <span class="admin-sidenav-mark">BG</span>
      <span class="ms-1 font-weight-bold brand-serif fs-5">Batik Godo</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav admin-nav-stack">
      <li class="nav-item admin-nav-section">Menu Utama</li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-gauge-high text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.motifs.*') ? 'active' : '' }}" href="{{ route('admin.motifs.index') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-palette text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Kelola Motif</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.information.*') ? 'active' : '' }}" href="{{ route('admin.information.edit') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-circle-info text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Informasi Publik</span>
        </a>
      </li>

      <li class="nav-item admin-nav-section mt-3">Keamanan</li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.account.*') ? 'active' : '' }}" href="{{ route('admin.account.password') }}">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-key text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Ganti Password</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}" target="_blank">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-globe text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Lihat Halaman Publik</span>
        </a>
      </li>
      <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}" class="m-0">
          @csrf
          <button type="submit" class="nav-link w-100 text-start admin-nav-button">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa-solid fa-right-from-bracket text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Keluar</span>
          </button>
        </form>
      </li>
    </ul>
  </div>
  <div class="sidenav-footer mx-3 admin-sidenav-footer">
    <div class="admin-user-chip mb-3">
      <div class="admin-user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
      <div>
        <div class="fw-bold text-dark text-xs text-truncate" style="max-width: 140px;">{{ auth()->user()->name ?? 'Admin' }}</div>
        <div class="small text-secondary" style="font-size: 0.65rem;">Administrator</div>
      </div>
    </div>
    <a href="{{ route('admin.motifs.create') }}" class="btn btn-dark btn-sm w-100 mb-2"><i class="fa-solid fa-plus me-1"></i> Tambah Motif</a>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm w-100 mb-0">Overview</a>
  </div>
</aside>