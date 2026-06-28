@extends('layout.admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ikhtisar cepat untuk memantau inventarisasi motif, verifikasi, dan aktivitas terbaru.')

@section('page_actions')
  <a href="{{ route('admin.motifs.export', request()->query()) }}" class="btn btn-white btn-sm mb-0 shadow-sm"><i class="fa-solid fa-file-export me-1 text-secondary"></i> Export CSV</a>
  <a href="{{ route('admin.motifs.create') }}" class="btn btn-warning text-white btn-sm mb-0 shadow-sm"><i class="fa-solid fa-plus me-1"></i> Tambah Motif</a>
@endsection

@section('content')
<!-- Statistics Section -->
<div class="row g-4 mb-4">
  <div class="col-xl-3 col-sm-6">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div>
            <p class="section-kicker mb-1" style="font-size: 0.65rem;"><i class="fa-solid fa-database me-1"></i> Total Motif</p>
            <h3 class="mb-1 fw-bold fs-2 text-dark">{{ $totalMotifs }}</h3>
            <p class="mb-0 text-xs text-secondary"><span class="text-success fw-bold">{{ $verifiedMotifs }}</span> terverifikasi adat</p>
          </div>
          <div class="icon icon-shape bg-gradient-dark shadow-primary text-center rounded-circle d-flex align-items-center justify-content-center" style="width: 3rem; height: 3rem; background: linear-gradient(135deg, var(--batik-ink) 0%, var(--batik-ink-light) 100%);">
            <i class="fa-solid fa-palette text-white opacity-10"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div>
            <p class="section-kicker mb-1" style="font-size: 0.65rem; color: var(--batik-clay);"><i class="fa-solid fa-circle-exclamation me-1"></i> Motif Sakral</p>
            <h3 class="mb-1 fw-bold fs-2 text-dark">{{ $sacredMotifs }}</h3>
            <p class="mb-0 text-xs text-secondary"><span class="text-warning fw-bold">Perlu</span> perhatian khusus</p>
          </div>
          <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle d-flex align-items-center justify-content-center" style="width: 3rem; height: 3rem; background: linear-gradient(135deg, var(--batik-clay) 0%, #ea580c 100%);">
            <i class="fa-solid fa-triangle-exclamation text-white opacity-10"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div>
            <p class="section-kicker mb-1" style="font-size: 0.65rem; color: var(--batik-emerald);"><i class="fa-solid fa-circle-check me-1"></i> Terverifikasi</p>
            <h3 class="mb-1 fw-bold fs-2 text-dark">{{ $verifiedMotifs }}</h3>
            <p class="mb-0 text-xs text-secondary"><span class="text-success fw-bold">Siap</span> tampil ke publik</p>
          </div>
          <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle d-flex align-items-center justify-content-center" style="width: 3rem; height: 3rem; background: linear-gradient(135deg, var(--batik-emerald) 0%, #059669 100%);">
            <i class="fa-solid fa-check text-white opacity-10"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-sm-6">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div>
            <p class="section-kicker mb-1" style="font-size: 0.65rem; color: #b45309;"><i class="fa-solid fa-magnifying-glass-chart me-1"></i> Perlu Riset</p>
            <h3 class="mb-1 fw-bold fs-2 text-dark">{{ $pendingMotifs }}</h3>
            <p class="mb-0 text-xs text-secondary"><span class="text-danger fw-bold">Prioritas</span> pendalaman</p>
          </div>
          <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle d-flex align-items-center justify-content-center" style="width: 3rem; height: 3rem; background: linear-gradient(135deg, var(--batik-amber) 0%, #d97706 100%);">
            <i class="fa-solid fa-magnifying-glass-chart text-white opacity-10"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Details & Activity Grid -->
<div class="row g-4">
  <!-- Motif Terbaru Table -->
  <div class="col-lg-7">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
        <p class="section-kicker mb-1"><i class="fa-solid fa-clock-rotate-left me-1"></i> Ringkasan Data</p>
        <h4 class="mb-1 fw-bold text-dark brand-serif">Motif Terbaru</h4>
        <p class="text-xs mb-0 text-secondary">Daftar motif terdata terakhir yang aktif dalam sistem.</p>
      </div>
      <div class="card-body p-0 mt-3">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th class="ps-4">Nama Motif</th>
                <th>Kategori</th>
                <th class="pe-4">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($recentMotifs as $motif)
                <tr>
                  <td class="ps-4">
                    <div class="fw-bold text-dark" style="font-family: 'Cormorant Garamond', serif; font-size: 1.15rem;">{{ $motif->name }}</div>
                    <div class="text-xs text-secondary text-truncate" style="max-width: 250px;">{{ $motif->philosophical_meaning }}</div>
                  </td>
                  <td>
                    <x-ui.badge :variant="$motif->isSakral() ? 'sacred' : 'success'" size="sm">{{ $motif->categoryLabel() }}</x-ui.badge>
                  </td>
                  <td class="pe-4">
                    <x-ui.badge variant="default" size="sm">{{ $motif->verificationLabel() }}</x-ui.badge>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="text-center text-secondary py-5">
                    <i class="fa-solid fa-box-open d-block fs-3 mb-2 text-muted"></i>
                    Belum ada motif terbaru yang didata.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Activity Logs Timeline -->
  <div class="col-lg-5">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
        <p class="section-kicker mb-1"><i class="fa-solid fa-timeline me-1"></i> Aktivitas</p>
        <h4 class="mb-1 fw-bold text-dark brand-serif">Jejak Aktivitas</h4>
        <p class="text-xs mb-0 text-secondary">Riwayat perubahan data inventarisasi terbaru.</p>
      </div>
      <div class="card-body p-4 mt-2">
        <div class="d-flex flex-column gap-3">
          @forelse ($recentLogs as $log)
            <div class="position-relative ps-4 border-start pb-2" style="border-color: var(--batik-border) !important;">
              <!-- Timeline Dot -->
              <div class="position-absolute" style="left: -6px; top: 4px; width: 11px; height: 11px; border-radius: 50%; background-color: var(--batik-clay); border: 2px solid var(--batik-cream);"></div>
              
              <div class="d-flex justify-content-between gap-2 mb-1">
                <div class="text-xs fw-bold text-dark">{{ $log->action }}</div>
                <span class="badge bg-secondary bg-opacity-10 text-secondary text-xxs" style="font-size: 0.65rem; padding: 0.25em 0.5em;">{{ $log->user?->name ?? 'Sistem' }}</span>
              </div>
              <p class="text-xs text-muted mb-1" style="line-height: 1.5;">{{ $log->description }}</p>
              <p class="text-xxs text-secondary opacity-70 mb-0" style="font-size: 0.65rem;"><i class="fa-regular fa-clock me-1"></i>{{ $log->created_at?->format('d M Y H:i') }} WIB</p>
            </div>
          @empty
            <div class="text-center text-secondary py-5">
              <i class="fa-solid fa-folder-open d-block fs-3 mb-2 text-muted"></i>
              Belum ada log aktivitas dalam sistem.
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Tips Panel -->
<div class="row mt-4">
  <div class="col-12">
    <div class="alert alert-info border-0 d-flex align-items-start gap-3 p-4 shadow-sm" style="background-color: rgba(180, 83, 9, 0.05); border-left: 5px solid var(--batik-amber) !important;">
      <i class="fa-solid fa-lightbulb text-warning fs-4 mt-1"></i>
      <div>
        <div class="fw-bold text-dark mb-1">Tips Penggunaan Panel Admin:</div>
        <p class="small text-secondary-emphasis mb-0" style="line-height: 1.6;">Gunakan fitur <strong>Tambah Motif</strong> untuk mendata motif baru hasil riset di lapangan. Selalu pastikan narasumber diisi dengan jelas sebagai pertanggungjawaban ilmiah. Anda juga dapat mengekspor seluruh database motif ke file CSV untuk kebutuhan pelaporan cepat.</p>
      </div>
    </div>
  </div>
</div>
@endsection
