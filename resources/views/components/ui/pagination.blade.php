@props([
    'paginator',
])

@if ($paginator->hasPages())
  @php
    $links = $paginator->linkCollection()->slice(1, -1);
  @endphp
  <nav role="navigation" aria-label="Navigasi halaman" class="d-flex justify-content-center">
    <ul class="pagination pagination-md mb-0">
      <li class="page-item">
        @if ($paginator->onFirstPage())
          <span class="page-link" aria-disabled="true" aria-label="Sebelumnya">
            <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
          </span>
        @else
          <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link" aria-label="Sebelumnya">
            <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
          </a>
        @endif
      </li>

      @foreach ($links as $link)
        @if ($link['url'] === null)
          <li class="page-item disabled" aria-disabled="true">
            <span class="page-link">{{ $link['label'] }}</span>
          </li>
        @elseif ($link['active'])
          <li class="page-item active" aria-current="page">
            <span class="page-link">{{ $link['label'] }}</span>
          </li>
        @else
          <li class="page-item">
            <a href="{{ $link['url'] }}" class="page-link" aria-label="Halaman {{ $link['label'] }}">{{ $link['label'] }}</a>
          </li>
        @endif
      @endforeach

      <li class="page-item">
        @if ($paginator->hasMorePages())
          <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link" aria-label="Berikutnya">
            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
          </a>
        @else
          <span class="page-link" aria-disabled="true" aria-label="Berikutnya">
            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
          </span>
        @endif
      </li>
    </ul>
  </nav>
@endif