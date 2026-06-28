@extends('layout.admin')

@section('title', 'Edit Motif')
@section('page_title', 'Edit Motif')

@section('page_subtitle', 'Perbarui data motif dengan teliti, terutama untuk motif berkategori sakral.')

@section('page_actions')
  <a href="{{ route('admin.motifs.index') }}" class="btn btn-white btn-sm mb-0 shadow-sm"><i class="fa-solid fa-chevron-left me-1"></i> Kembali</a>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
  <div class="card-body p-4 p-lg-5">
    <div class="mb-4">
      <p class="section-kicker mb-1"><i class="fa-solid fa-pen-to-square me-1"></i> Formulir Edit</p>
      <h2 class="admin-section-title mb-1 brand-serif">Edit Data Motif</h2>
      <p class="admin-section-lead mb-0 text-muted">Periksa kembali perubahan pada makna filosofi, sejarah, dan aturan adat sebelum melakukan penyimpanan.</p>
    </div>
    <form method="POST" action="{{ route('admin.motifs.update', $motif) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      @include('admin.motifs._form', ['motif' => $motif])
    </form>
  </div>
</div>
@endsection