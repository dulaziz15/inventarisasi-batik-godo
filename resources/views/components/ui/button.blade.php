@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'disabled' => false,
    'loading' => false,
    'icon' => null,
    'iconPosition' => 'left',
    'href' => null,
])

@php
    $isDisabled = $disabled || $loading;

  $baseClasses = 'btn d-inline-flex align-items-center justify-content-center gap-2 mb-0';

    $sizeClasses = [
    'sm' => 'btn-sm',
    'md' => '',
    'lg' => 'btn-lg',
  ][$size] ?? '';

    $variantClasses = [
    'primary' => 'btn-primary',
    'secondary' => 'btn-dark',
    'outline' => 'btn-outline-secondary',
    'ghost' => 'btn-link text-secondary text-decoration-none',
    'danger' => 'btn-danger',
  ][$variant] ?? 'btn-primary';

  $stateClasses = $isDisabled ? ' disabled opacity-6' : '';

  $classes = trim($baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses . ' ' . $stateClasses);
@endphp

@if ($href)
  <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes . ($isDisabled ? ' pointer-events-none opacity-60' : '')]) }} @if ($isDisabled) aria-disabled="true" tabindex="-1" @endif>
    @if ($loading)
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
         <span class="visually-hidden">Memuat</span>
    @endif
    @if ($icon && $iconPosition === 'left' && !$loading)
      <i class="{{ $icon }}" aria-hidden="true"></i>
    @endif
    <span>{{ $slot }}</span>
    @if ($icon && $iconPosition === 'right' && !$loading)
      <i class="{{ $icon }}" aria-hidden="true"></i>
    @endif
  </a>
@else
  <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }} @disabled($isDisabled) @if ($loading) aria-busy="true" @endif>
    @if ($loading)
      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
         <span class="visually-hidden">Memuat</span>
    @endif
    @if ($icon && $iconPosition === 'left' && !$loading)
      <i class="{{ $icon }}" aria-hidden="true"></i>
    @endif
    <span>{{ $slot }}</span>
    @if ($icon && $iconPosition === 'right' && !$loading)
      <i class="{{ $icon }}" aria-hidden="true"></i>
    @endif
  </button>
@endif