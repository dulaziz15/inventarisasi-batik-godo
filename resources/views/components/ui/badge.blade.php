@props([
    'variant' => 'default',
    'size' => 'md',
    'icon' => null,
])

@php
  $baseClasses = 'badge d-inline-flex align-items-center gap-1 border-radius-md text-xxs font-weight-bolder';

    $sizeClasses = [
    'sm' => 'badge-sm',
    'md' => '',
    'lg' => 'px-3 py-2',
  ][$size] ?? '';

    $variantClasses = [
    'default' => 'bg-gradient-secondary',
    'success' => 'bg-gradient-success',
    'warning' => 'bg-gradient-warning text-dark',
    'danger' => 'bg-gradient-danger',
    'sacred' => 'bg-gradient-danger shadow-sm',
  ][$variant] ?? 'bg-gradient-secondary';
@endphp

<span {{ $attributes->merge(['class' => $baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses]) }}>
  @if ($icon)
    <i class="{{ $icon }}" aria-hidden="true"></i>
  @endif
  <span>{{ $slot }}</span>
</span>