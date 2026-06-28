@extends('layout.admin')

@section('title', 'Tambah Motif')
@section('page_title', 'Tambah Motif')

@section('page_subtitle', 'Isi data motif dengan lengkap, unggah gambar utama, dan simpan setelah semua data tervalidasi.')

@section('page_actions')
  <a href="{{ route('admin.motifs.index') }}" class="btn btn-white btn-sm mb-0 shadow-sm"><i class="fa-solid fa-chevron-left me-1"></i> Kembali</a>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-body p-4 p-lg-5">
    <div class="mb-4">
      <p class="section-kicker mb-1"><i class="fa-solid fa-folder-plus me-1"></i> Formulir Input</p>
      <h2 class="admin-section-title mb-1 brand-serif">Tambah Data Motif Baru</h2>
      <p class="admin-section-lead mb-0 text-muted">Pastikan informasi makna filosofi dan sumber narasumber ditulis secara jelas dan lengkap demi keaslian data.</p>
    </div>
    <form method="POST" action="{{ route('admin.motifs.store') }}" enctype="multipart/form-data">
      @csrf
      @include('admin.motifs._form', ['motif' => $motif])
    </form>
  </div>
</div>
@endsection