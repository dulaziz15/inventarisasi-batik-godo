@extends('layout.admin')

@section('title', 'Kelola Motif')
@section('page_title', 'Kelola Motif')

@section('page_subtitle', 'Kelola data motif dengan pencarian cepat, filter status, dan tindakan yang aman.')

@section('page_actions')
  <x-ui.button variant="outline" size="sm" :href="route('admin.motifs.export', request()->query())" icon="fa-solid fa-file-export">Export CSV</x-ui.button>
  <x-ui.button variant="secondary" size="sm" :href="route('admin.motifs.create')" icon="fa-solid fa-plus">Tambah Motif</x-ui.button>
@endsection

@section('content')
<div class="card mb-4">
  <div class="card-header pb-0">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
      <div>
        <p class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 mb-1"><i class="fa-solid fa-folder-open me-1"></i> Daftar Motif</p>
        <h6 class="mb-1">Kelola Semua Data Motif</h6>
        <p class="text-sm text-secondary mb-0">Cari, filter, tambahkan, edit, dan hapus data motif secara langsung dan aman.</p>
      </div>
    </div>
  </div>

  <div class="card-body pt-3">
    <div class="mb-4">
      <form method="GET" action="{{ route('admin.motifs.index') }}" class="row g-3 align-items-end">
        <div class="col-12 col-lg-5">
          <label class="form-label text-xs font-weight-bold text-secondary text-uppercase"><i class="fa-solid fa-search me-1"></i> Pencarian</label>
          <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama atau makna filosofis">
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <label class="form-label text-xs font-weight-bold text-secondary text-uppercase"><i class="fa-solid fa-tags me-1"></i> Kategori</label>
          <select name="kategori" class="form-select">
            <option value="">Semua kategori</option>
            @foreach ($categories as $value => $label)
              <option value="{{ $value }}" @selected(request('kategori') === $value)>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <label class="form-label text-xs font-weight-bold text-secondary text-uppercase"><i class="fa-solid fa-clipboard-check me-1"></i> Status</label>
          <select name="status" class="form-select">
            <option value="">Semua status</option>
            @foreach ($statuses as $value => $label)
              <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-lg-1 d-flex flex-lg-column gap-2">
          <x-ui.button class="w-100" type="submit" icon="fa-solid fa-magnifying-glass" aria-label="Cari"></x-ui.button>
          <x-ui.button class="w-100" variant="outline" :href="route('admin.motifs.index')" icon="fa-solid fa-rotate-left" aria-label="Reset"></x-ui.button>
        </div>
      </form>
    </div>

    <div class="table-responsive p-0">
      <table class="table align-items-center mb-0">
        <thead>
          <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 100px;">Visual</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Motif</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Adat</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sumber Pengetahuan</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($motifs as $motif)
            <tr>
              <td>
                <div class="px-3 py-2">
                  <img src="{{ $motif->thumbnailUrl() }}" alt="{{ $motif->name }}" class="avatar avatar-xl border-radius-lg shadow-sm" style="width: 80px; height: 60px; object-fit: cover;">
                </div>
              </td>
              <td>
                <div class="d-flex flex-column py-2">
                  <h6 class="mb-0 text-sm">{{ $motif->name }}</h6>
                  <p class="text-xs text-secondary mb-0">{{ \Illuminate\Support\Str::limit($motif->philosophical_meaning, 80) }}</p>
                </div>
              </td>
              <td class="align-middle text-sm">
                <x-ui.badge :variant="$motif->isSakral() ? 'sacred' : 'success'" size="sm">{{ $motif->categoryLabel() }}</x-ui.badge>
              </td>
              <td class="align-middle text-sm">
                <x-ui.badge variant="default" size="sm">{{ $motif->verificationLabel() }}</x-ui.badge>
              </td>
              <td class="align-middle text-sm text-secondary">{{ $motif->knowledge_source }}</td>
              <td class="align-middle text-end">
                <div class="d-inline-flex gap-2 justify-content-end">
                  <x-ui.button variant="outline" size="sm" :href="route('admin.motifs.edit', $motif)" icon="fa-solid fa-pen-to-square">Edit</x-ui.button>
                  <form action="{{ route('admin.motifs.destroy', $motif) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus motif ini?');">
                    @csrf
                    @method('DELETE')
                    <x-ui.button variant="danger" size="sm" type="submit" icon="fa-solid fa-trash">Hapus</x-ui.button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-5">
                <i class="fa-solid fa-folder-open mb-2 d-block text-secondary" style="font-size: 2rem;"></i>
                <div class="font-weight-bold text-dark mb-1">Belum ada data motif</div>
                <div class="text-sm text-secondary">Tambahkan data motif pertama Anda untuk memulai inventarisasi.</div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if ($motifs->hasPages())
      <div class="mt-4 pt-2 border-top">
        <x-ui.pagination :paginator="$motifs" />
      </div>
    @endif
  </div>
</div>
@endsection