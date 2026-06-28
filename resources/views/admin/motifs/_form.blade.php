@php
  $selectedCategory = old('category', $motif->category);
@endphp

<div class="row g-4">
  <!-- General Info Card Section -->
  <div class="col-12 card border-0 shadow-sm p-4">
    <h5 class="brand-serif fw-bold text-dark mb-3"><i class="fa-solid fa-circle-info text-warning me-1"></i> Informasi Dasar</h5>
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label fw-bold text-secondary small">Nama Motif</label>
        <input type="text" name="name" value="{{ old('name', $motif->name) }}" class="form-control" placeholder="Contoh: Gajah Oling" required style="border-radius: 0.75rem;">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-bold text-secondary small">Kategori Adat</label>
        <select name="category" class="form-select" required style="border-radius: 0.75rem;">
          @foreach ($categories as $value => $label)
            <option value="{{ $value }}" @selected($selectedCategory === $value)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-bold text-secondary small">Status Verifikasi</label>
        <select name="verification_status" class="form-select" required style="border-radius: 0.75rem;">
          @foreach ($statuses as $value => $label)
            <option value="{{ $value }}" @selected(old('verification_status', $motif->verification_status) === $value)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>

  <!-- Meaning Section -->
  <div class="col-12 card border-0 shadow-sm p-4">
    <h5 class="brand-serif fw-bold text-dark mb-3"><i class="fa-solid fa-quote-left text-warning me-1"></i> Makna Filosofis</h5>
    <div>
      <textarea name="philosophical_meaning" rows="4" class="form-control" placeholder="Jelaskan makna filosofis mendalam yang diwariskan sesepuh pembatik atau hasil wawancara di lapangan" required style="border-radius: 0.75rem;">{{ old('philosophical_meaning', $motif->philosophical_meaning) }}</textarea>
    </div>
  </div>

  <!-- History & Description Section -->
  <div class="col-12 card border-0 shadow-sm p-4">
    <h5 class="brand-serif fw-bold text-dark mb-3"><i class="fa-solid fa-book-open text-warning me-1"></i> Deskripsi & Kronik Sejarah</h5>
    <div class="row g-3">
      <div class="col-12">
        <label class="form-label fw-bold text-secondary small">Sejarah / Asal-usul Motif</label>
        <textarea name="history" rows="3" class="form-control" placeholder="Tuliskan latar belakang sejarah, asal mula, atau mitos yang melekat pada motif ini" style="border-radius: 0.75rem;">{{ old('history', $motif->history) }}</textarea>
      </div>
      <div class="col-12">
        <label class="form-label fw-bold text-secondary small">Deskripsi Visual Motif</label>
        <textarea name="visual_description" rows="3" class="form-control" placeholder="Detail ornamen utama, isen-isen khas, komposisi warna rekomendasi, atau tata letak visual" style="border-radius: 0.75rem;">{{ old('visual_description', $motif->visual_description) }}</textarea>
      </div>
    </div>
  </div>

  <!-- Technical Recommendation & Source -->
  <div class="col-12 card border-0 shadow-sm p-4">
    <h5 class="brand-serif fw-bold text-dark mb-3"><i class="fa-solid fa-gears text-warning me-1"></i> Teknis Pembuatan & Sumber Informasi</h5>
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label fw-bold text-secondary small">Teknik Pengerjaan Utama</label>
        <select name="technique" class="form-select" required style="border-radius: 0.75rem;">
          @foreach ($techniques as $value => $label)
            <option value="{{ $value }}" @selected(old('technique', $motif->technique) === $value)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label fw-bold text-secondary small">Aturan Penggunaan Adat</label>
        <select name="usage_rule" class="form-select" required style="border-radius: 0.75rem;">
          @foreach ($usageRules as $value => $label)
            <option value="{{ $value }}" @selected(old('usage_rule', $motif->usage_rule) === $value)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label fw-bold text-secondary small">Sumber Pengetahuan / Narasumber</label>
        <input type="text" name="knowledge_source" value="{{ old('knowledge_source', $motif->knowledge_source) }}" class="form-control" placeholder="Contoh: Sesepuh Adat / Maestro Batik Banyuwangi" required style="border-radius: 0.75rem;">
      </div>
    </div>
  </div>

  <!-- Visual Asset Files Upload -->
  <div class="col-12 card border-0 shadow-sm p-4">
    <h5 class="brand-serif fw-bold text-dark mb-3"><i class="fa-solid fa-images text-warning me-1"></i> Berkas Gambar Visual</h5>
    <div class="row g-3 align-items-start">
      <div class="col-md-6">
        <label class="form-label fw-bold text-secondary small">Unggah Gambar Utama</label>
        <input type="file" name="main_image" class="form-control" accept="image/jpeg,image/png" {{ $motif->exists ? '' : 'required' }} style="border-radius: 0.75rem;">
        <div class="form-text text-muted small">Disarankan aspek rasio 4:3, format JPG/PNG, ukuran maksimal 2MB.</div>
        @if ($motif->main_image)
          <div class="mt-3 position-relative d-inline-block">
            <img src="{{ $motif->thumbnailUrl() }}" alt="{{ $motif->name }}" class="rounded-3 shadow border" style="width: 200px; height: 150px; object-fit: cover;">
            <span class="position-absolute top-0 start-0 badge bg-dark m-2 bg-opacity-75">Aktif</span>
          </div>
        @endif
      </div>
      <div class="col-md-6">
        <label class="form-label fw-bold text-secondary small">Galeri Foto Tambahan</label>
        <input type="file" name="gallery_images[]" class="form-control" accept="image/jpeg,image/png" multiple style="border-radius: 0.75rem;">
        <div class="form-text text-muted small">Pilih beberapa file sekaligus jika ada detail foto ornamen terpisah.</div>
      </div>
    </div>
  </div>

  <!-- Sacred Change Confirmation Alert -->
  @if ($motif->exists && $motif->category === 'sakral')
    <div class="col-12 card border border-danger-subtle bg-danger-subtle bg-opacity-10 p-2">
      <div class="p-2 d-flex gap-2">
        <i class="fa-solid fa-triangle-exclamation text-danger fs-5 mt-1"></i>
        <div>
          <div class="fw-bold text-danger mb-2 small">Konfirmasi Perubahan Data Motif Sakral</div>
          <label class="form-check-label text-secondary small cursor-pointer">
            <input type="checkbox" name="confirm_sakral_change" value="1" class="form-check-input border-danger me-2">
            Saya memahami bahwa mengubah detail motif berkategori sakral memerlukan kehati-hatian adat tambahan.
          </label>
        </div>
      </div>
    </div>
  @endif

  <!-- Sticky Actions Bar -->
  <div class="col-12 d-flex gap-2 justify-content-end">
    <a href="{{ route('admin.motifs.index') }}" class="btn btn-outline-secondary px-4"><i class="fa-solid fa-xmark me-1"></i> Batal</a>
    <button class="btn btn-dark admin-action-btn px-4 shadow-sm" type="submit"><i class="fa-solid fa-circle-check me-1"></i> Simpan Data</button>
  </div>
</div>