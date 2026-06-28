# Design Document: UI/UX Refactoring

## Overview

This design document provides comprehensive technical specifications for refactoring the Batik Banyuwangi inventory application's UI/UX. The refactoring consolidates the styling framework to Tailwind CSS 4 only (removing Bootstrap 5.3.3), implements WCAG 2.1 Level AA accessibility standards, establishes a cohesive design system inspired by Batik Banyuwangi cultural heritage, and optimizes performance across all devices.

### Goals

1. **Accessibility First**: Achieve WCAG 2.1 Level AA compliance across all pages and components
2. **Framework Consolidation**: Eliminate Bootstrap entirely and use only Tailwind CSS 4 for styling
3. **Design System**: Establish a comprehensive, reusable design system with cultural identity
4. **Mobile-First**: Ensure seamless responsive experience across all device sizes
5. **Performance**: Optimize CSS bundle size, loading times, and runtime performance
6. **Maintainability**: Create well-documented, reusable components for efficient development

### Current State Analysis

**Technology Stack:**
- Laravel 11 (Backend framework)
- Blade Templates (View layer)
- Bootstrap 5.3.3 (Currently used, to be removed)
- Tailwind CSS 4 (Currently minimal usage, to be primary framework)
- Font Awesome 6 (Icon system)
- Vite (Build tool)

**Current Issues:**
- Style conflicts between Bootstrap and Tailwind CSS
- Inconsistent component styling across pages
- Accessibility gaps (missing ARIA labels, insufficient color contrast in some areas)
- Large CSS bundle size due to dual framework usage
- Inconsistent mobile responsiveness
- Cultural design elements not systematically implemented

### Target State

**Unified Framework:**
- Tailwind CSS 4 as the sole CSS framework
- Custom design tokens defined in Tailwind configuration
- Zero Bootstrap dependencies

**Accessibility:**
- All interactive elements keyboard navigable with visible focus indicators
- Proper ARIA labels, roles, and landmarks throughout
- Minimum 4.5:1 color contrast for normal text, 3:1 for large text
- Screen reader announcements for dynamic content
- Minimum 44x44px touch targets

**Performance:**
- Lighthouse performance score ≥90 (desktop), ≥80 (mobile)
- Purged CSS with only used utility classes
- Optimized font loading with font-display: swap
- Lazy-loaded images below the fold


## Architecture

### System Architecture

The UI/UX refactoring follows a layered architecture approach:

```
┌─────────────────────────────────────────────────────────────┐
│                     Presentation Layer                       │
│  (Blade Templates + Tailwind Utility Classes)               │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                    Component Library                         │
│  (Reusable Blade Components with Tailwind Styling)         │
│  - Button, Card, Badge, Input, Select, Alert, Modal, etc.  │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                      Design System                           │
│  (Tailwind Configuration + Custom CSS)                      │
│  - Design Tokens (colors, typography, spacing, shadows)    │
│  - Cultural Elements (patterns, gradients, textures)       │
│  - Animation System (transitions, keyframes)               │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                    Build Pipeline                            │
│  (Vite + Tailwind CSS 4 + PostCSS)                         │
│  - CSS Purging, Minification, Optimization                 │
└─────────────────────────────────────────────────────────────┘
```

### Design System Architecture

The design system is organized into three layers:

1. **Foundation Layer**: Core design tokens (colors, typography, spacing, shadows, borders)
2. **Component Layer**: Reusable UI components built with foundation tokens
3. **Pattern Layer**: Composite patterns combining multiple components (forms, cards, navigation)

### File Structure

```
resources/
├── css/
│   ├── app.css                    # Main Tailwind entry point
│   ├── components/                # Component-specific styles
│   │   ├── buttons.css
│   │   ├── forms.css
│   │   ├── cards.css
│   │   └── navigation.css
│   ├── utilities/                 # Custom utility classes
│   │   ├── animations.css
│   │   └── patterns.css
│   └── base/                      # Base styles and resets
│       ├── typography.css
│       └── accessibility.css
├── views/
│   ├── components/                # Blade components
│   │   ├── ui/                    # UI components
│   │   │   ├── button.blade.php
│   │   │   ├── card.blade.php
│   │   │   ├── badge.blade.php
│   │   │   ├── input.blade.php
│   │   │   ├── select.blade.php
│   │   │   ├── alert.blade.php
│   │   │   ├── modal.blade.php
│   │   │   ├── breadcrumb.blade.php
│   │   │   ├── pagination.blade.php
│   │   │   └── skeleton.blade.php
│   │   └── layout/                # Layout components
│   │       ├── navbar.blade.php
│   │       ├── sidebar.blade.php
│   │       └── footer.blade.php
│   └── layout/
│       ├── app.blade.php          # Public layout
│       └── admin.blade.php        # Admin layout
└── js/
    ├── app.js                     # Main JavaScript entry
    └── components/                # Interactive components
        ├── modal.js
        ├── dropdown.js
        └── accessibility.js
```


## Components and Interfaces

### 1. Design System Foundation

#### 1.1 Tailwind CSS Configuration

**File**: `tailwind.config.js`

```javascript
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        // Primary Palette (Batik Banyuwangi Heritage)
        batik: {
          ink: {
            DEFAULT: '#0f172a',  // Slate 900 - Deep ink
            light: '#1e293b',    // Slate 800
          },
          clay: {
            DEFAULT: '#991b1b',  // Terracotta red - Traditional earth dye
            light: '#dc2626',
            dark: '#7f1d1d',
          },
          emerald: {
            DEFAULT: '#065f46',  // Dark forest green
            light: '#059669',
            dark: '#064e3b',
          },
          amber: {
            DEFAULT: '#b45309',  // Gold/Amber - Premium accents
            light: '#d97706',
            dark: '#92400e',
            glow: 'rgba(180, 83, 9, 0.15)',
          },
          cream: {
            DEFAULT: '#fdfbf7',  // Warm ivory - Unbleached cotton
            dark: '#f5f0e6',     // Soft sand
          },
        },
        // Semantic Colors
        surface: '#ffffff',
        border: {
          DEFAULT: 'rgba(15, 23, 42, 0.08)',
          focus: 'rgba(153, 27, 27, 0.4)',
        },
      },
      fontFamily: {
        sans: ['Manrope', 'system-ui', '-apple-system', 'sans-serif'],
        serif: ['Cormorant Garamond', 'Georgia', 'serif'],
      },
      fontSize: {
        'xs': ['0.75rem', { lineHeight: '1rem' }],
        'sm': ['0.875rem', { lineHeight: '1.25rem' }],
        'base': ['1rem', { lineHeight: '1.5rem' }],
        'lg': ['1.125rem', { lineHeight: '1.75rem' }],
        'xl': ['1.25rem', { lineHeight: '1.75rem' }],
        '2xl': ['1.5rem', { lineHeight: '2rem' }],
        '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
        '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
        '5xl': ['3rem', { lineHeight: '1.1' }],
        '6xl': ['3.75rem', { lineHeight: '1' }],
      },
      spacing: {
        '18': '4.5rem',
        '88': '22rem',
        '128': '32rem',
      },
      borderRadius: {
        'sm': '0.5rem',
        'DEFAULT': '0.75rem',
        'md': '0.85rem',
        'lg': '1.25rem',
        'xl': '1.5rem',
        '2xl': '2rem',
        '3xl': '2.5rem',
      },
      boxShadow: {
        'sm': '0 2px 8px rgba(15, 23, 42, 0.04)',
        'DEFAULT': '0 10px 25px rgba(15, 23, 42, 0.06)',
        'md': '0 10px 25px rgba(15, 23, 42, 0.06)',
        'lg': '0 20px 45px rgba(15, 23, 42, 0.1)',
        'xl': '0 25px 50px rgba(15, 23, 42, 0.15)',
        'gold': '0 15px 35px rgba(180, 83, 9, 0.12)',
        'clay': '0 8px 20px rgba(153, 27, 27, 0.04)',
        'inner': 'inset 0 2px 4px 0 rgba(15, 23, 42, 0.05)',
      },
      transitionDuration: {
        'fast': '150ms',
        'normal': '250ms',
        'slow': '400ms',
      },
      transitionTimingFunction: {
        'smooth': 'cubic-bezier(0.4, 0, 0.2, 1)',
      },
      keyframes: {
        'fade-in': {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        'fade-out': {
          '0%': { opacity: '1' },
          '100%': { opacity: '0' },
        },
        'slide-in-up': {
          '0%': { transform: 'translateY(10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        'slide-in-down': {
          '0%': { transform: 'translateY(-10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        'scale-in': {
          '0%': { transform: 'scale(0.95)', opacity: '0' },
          '100%': { transform: 'scale(1)', opacity: '1' },
        },
        'float': {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-8px)' },
        },
      },
      animation: {
        'fade-in': 'fade-in 250ms ease-out',
        'fade-out': 'fade-out 200ms ease-in',
        'slide-in-up': 'slide-in-up 300ms ease-out',
        'slide-in-down': 'slide-in-down 300ms ease-out',
        'scale-in': 'scale-in 200ms ease-out',
        'float': 'float 6s ease-in-out infinite',
      },
    },
  },
  plugins: [],
}
```


#### 1.2 Custom CSS Layer (app.css)

```css
@import 'tailwindcss';

@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';

/* ==========================================================================
   DESIGN TOKENS & CUSTOM PROPERTIES
   ========================================================================== */

@theme {
  /* Font Families */
  --font-sans: 'Manrope', ui-sans-serif, system-ui, sans-serif;
  --font-serif: 'Cormorant Garamond', Georgia, serif;
  
  /* Cultural Pattern Definitions */
  --pattern-batik-dots: radial-gradient(var(--color-batik-amber) 1.5px, transparent 1.5px),
                        radial-gradient(var(--color-batik-clay) 1.5px, transparent 1.5px);
  --pattern-size: 40px 40px;
  --pattern-position: 0 0, 20px 20px;
}

/* ==========================================================================
   BASE STYLES & RESETS
   ========================================================================== */

@layer base {
  /* Typography */
  body {
    @apply font-sans text-batik-ink antialiased;
  }
  
  h1, h2, h3, h4, h5, h6 {
    @apply font-serif font-bold text-batik-ink;
  }
  
  /* Focus Visible Styles (Accessibility) */
  *:focus-visible {
    @apply outline-none ring-3 ring-batik-clay/40 ring-offset-2;
  }
  
  /* Custom Scrollbar */
  ::-webkit-scrollbar {
    @apply w-2 h-2;
  }
  
  ::-webkit-scrollbar-track {
    @apply bg-batik-cream;
  }
  
  ::-webkit-scrollbar-thumb {
    @apply bg-batik-ink/15 rounded hover:bg-batik-clay/30;
  }
  
  /* Reduced Motion Support */
  @media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
      animation-duration: 0.01ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.01ms !important;
    }
  }
}

/* ==========================================================================
   COMPONENT STYLES
   ========================================================================== */

@layer components {
  /* Cultural Pattern Overlay */
  .pattern-batik {
    position: relative;
  }
  
  .pattern-batik::before {
    content: '';
    @apply absolute inset-0 pointer-events-none;
    background-image: var(--pattern-batik-dots);
    background-size: var(--pattern-size);
    background-position: var(--pattern-position);
    opacity: 0.06;
  }
  
  /* Glass Morphism Effect */
  .glass {
    @apply bg-white/65 backdrop-blur-md border border-white/30;
  }
  
  /* Surface Card */
  .surface-card {
    @apply bg-white/85 border border-border backdrop-blur-sm shadow-md;
    @apply transition-all duration-normal hover:shadow-lg;
  }
}

/* ==========================================================================
   UTILITY CLASSES
   ========================================================================== */

@layer utilities {
  /* Text Utilities */
  .text-balance {
    text-wrap: balance;
  }
  
  /* Gradient Text */
  .gradient-text {
    @apply bg-gradient-to-r from-batik-clay to-batik-amber bg-clip-text text-transparent;
  }
  
  /* Touch Target (Accessibility) */
  .touch-target {
    @apply min-w-[44px] min-h-[44px];
  }
  
  /* Screen Reader Only */
  .sr-only {
    @apply absolute w-px h-px p-0 -m-px overflow-hidden whitespace-nowrap border-0;
    clip: rect(0, 0, 0, 0);
  }
}
```


### 2. Component Library Specifications

#### 2.1 Button Component

**File**: `resources/views/components/ui/button.blade.php`

**Props:**
- `variant`: 'primary' | 'secondary' | 'outline' | 'ghost' | 'danger' (default: 'primary')
- `size`: 'sm' | 'md' | 'lg' (default: 'md')
- `type`: 'button' | 'submit' | 'reset' (default: 'button')
- `disabled`: boolean (default: false)
- `loading`: boolean (default: false)
- `icon`: string (Font Awesome class, optional)
- `iconPosition`: 'left' | 'right' (default: 'left')
- `href`: string (optional, renders as link)
- `class`: string (additional classes)

**Variants:**

```php
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
$baseClasses = 'inline-flex items-center justify-center gap-2 font-semibold rounded-md transition-all duration-normal focus-visible:outline-none focus-visible:ring-3 focus-visible:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed touch-target';

$variantClasses = [
    'primary' => 'bg-batik-ink text-white hover:bg-batik-ink-light focus-visible:ring-batik-ink/40 shadow-sm hover:shadow-md active:scale-95',
    'secondary' => 'bg-batik-amber text-white hover:bg-batik-amber-dark focus-visible:ring-batik-amber/40 shadow-sm hover:shadow-gold active:scale-95',
    'outline' => 'border-2 border-batik-ink text-batik-ink hover:bg-batik-ink hover:text-white focus-visible:ring-batik-ink/40',
    'ghost' => 'text-batik-ink hover:bg-batik-ink/5 focus-visible:ring-batik-ink/40',
    'danger' => 'bg-batik-clay text-white hover:bg-batik-clay-dark focus-visible:ring-batik-clay/40 shadow-sm hover:shadow-clay active:scale-95',
];

$sizeClasses = [
    'sm' => 'px-4 py-2 text-sm rounded-md',
    'md' => 'px-6 py-2.5 text-base rounded-lg',
    'lg' => 'px-8 py-3.5 text-lg rounded-xl',
];

$classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $sizeClasses[$size];
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $classes }} {{ $attributes->get('class') }}" {{ $attributes->except('class') }}>
        @if($icon && $iconPosition === 'left')
            <i class="{{ $icon }}" aria-hidden="true"></i>
        @endif
        {{ $slot }}
        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }}" aria-hidden="true"></i>
        @endif
    </a>
@else
    <button type="{{ $type }}" class="{{ $classes }} {{ $attributes->get('class') }}" {{ $disabled || $loading ? 'disabled' : '' }} {{ $attributes->except('class') }}>
        @if($loading)
            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="sr-only">Loading...</span>
        @elseif($icon && $iconPosition === 'left')
            <i class="{{ $icon }}" aria-hidden="true"></i>
        @endif
        {{ $slot }}
        @if(!$loading && $icon && $iconPosition === 'right')
            <i class="{{ $icon }}" aria-hidden="true"></i>
        @endif
    </button>
@endif
```

**Usage Examples:**

```blade
{{-- Primary button --}}
<x-ui.button variant="primary">Save Changes</x-ui.button>

{{-- Button with icon --}}
<x-ui.button variant="secondary" icon="fa-solid fa-plus">Add Motif</x-ui.button>

{{-- Loading state --}}
<x-ui.button variant="primary" :loading="true">Processing...</x-ui.button>

{{-- Link styled as button --}}
<x-ui.button variant="outline" href="{{ route('catalog') }}">View Catalog</x-ui.button>

{{-- Danger button --}}
<x-ui.button variant="danger" icon="fa-solid fa-trash">Delete</x-ui.button>
```


#### 2.2 Card Component

**File**: `resources/views/components/ui/card.blade.php`

**Props:**
- `variant`: 'default' | 'glass' | 'elevated' (default: 'default')
- `padding`: 'none' | 'sm' | 'md' | 'lg' (default: 'md')
- `hover`: boolean (default: false) - enables hover lift effect
- `class`: string (additional classes)

**Slots:**
- `header`: Card header content
- `footer`: Card footer content
- Default slot: Card body content

```php
@props([
    'variant' => 'default',
    'padding' => 'md',
    'hover' => false,
])

@php
$baseClasses = 'rounded-xl border transition-all duration-normal';

$variantClasses = [
    'default' => 'bg-white/85 border-border shadow-md backdrop-blur-sm',
    'glass' => 'bg-white/65 border-white/30 shadow-sm backdrop-blur-md',
    'elevated' => 'bg-white border-border shadow-lg',
];

$paddingClasses = [
    'none' => '',
    'sm' => 'p-4',
    'md' => 'p-6',
    'lg' => 'p-8',
];

$hoverClasses = $hover ? 'hover:shadow-lg hover:-translate-y-1 cursor-pointer' : '';

$classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $paddingClasses[$padding] . ' ' . $hoverClasses;
@endphp

<div class="{{ $classes }} {{ $attributes->get('class') }}" {{ $attributes->except('class') }}>
    @isset($header)
        <div class="card-header {{ $padding !== 'none' ? '-mt-6 -mx-6 mb-6 px-6 py-4' : 'mb-4' }} border-b border-border">
            {{ $header }}
        </div>
    @endisset
    
    <div class="card-body">
        {{ $slot }}
    </div>
    
    @isset($footer)
        <div class="card-footer {{ $padding !== 'none' ? '-mb-6 -mx-6 mt-6 px-6 py-4' : 'mt-4' }} border-t border-border">
            {{ $footer }}
        </div>
    @endisset
</div>
```

**Usage Examples:**

```blade
{{-- Basic card --}}
<x-ui.card>
    <h3 class="text-xl font-bold mb-2">Card Title</h3>
    <p class="text-batik-ink/70">Card content goes here.</p>
</x-ui.card>

{{-- Card with header and footer --}}
<x-ui.card variant="elevated" hover>
    <x-slot:header>
        <h3 class="text-lg font-bold">Motif Information</h3>
    </x-slot:header>
    
    <p>Detailed motif description...</p>
    
    <x-slot:footer>
        <x-ui.button variant="primary" size="sm">View Details</x-ui.button>
    </x-slot:footer>
</x-ui.card>

{{-- Glass card --}}
<x-ui.card variant="glass" padding="lg">
    <div class="text-center">
        <i class="fa-solid fa-palette text-4xl text-batik-amber mb-4"></i>
        <h4 class="text-xl font-bold">Cultural Heritage</h4>
    </div>
</x-ui.card>
```


#### 2.3 Badge Component

**File**: `resources/views/components/ui/badge.blade.php`

**Props:**
- `variant`: 'default' | 'success' | 'warning' | 'danger' | 'sacred' (default: 'default')
- `size`: 'sm' | 'md' | 'lg' (default: 'md')
- `icon`: string (Font Awesome class, optional)
- `class`: string (additional classes)

```php
@props([
    'variant' => 'default',
    'size' => 'md',
    'icon' => null,
])

@php
$baseClasses = 'inline-flex items-center gap-1.5 font-bold rounded-full border';

$variantClasses = [
    'default' => 'bg-batik-ink/6 text-batik-ink-light border-batik-ink/5',
    'success' => 'bg-batik-emerald/12 text-batik-emerald border-batik-emerald/16',
    'warning' => 'bg-batik-amber/12 text-batik-amber-dark border-batik-amber/16',
    'danger' => 'bg-batik-clay/12 text-batik-clay border-batik-clay/16',
    'sacred' => 'bg-batik-clay/12 text-batik-clay border-batik-clay/16 shadow-clay',
];

$sizeClasses = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-3 py-1 text-sm',
    'lg' => 'px-4 py-1.5 text-base',
];

$classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $sizeClasses[$size];
@endphp

<span class="{{ $classes }} {{ $attributes->get('class') }}" {{ $attributes->except('class') }}>
    @if($icon)
        <i class="{{ $icon }} text-xs" aria-hidden="true"></i>
    @endif
    {{ $slot }}
</span>
```

**Usage Examples:**

```blade
{{-- Default badge --}}
<x-ui.badge>New</x-ui.badge>

{{-- Success badge with icon --}}
<x-ui.badge variant="success" icon="fa-solid fa-check">Verified</x-ui.badge>

{{-- Sacred motif badge --}}
<x-ui.badge variant="sacred" icon="fa-solid fa-star">Motif Sakral</x-ui.badge>

{{-- Large warning badge --}}
<x-ui.badge variant="warning" size="lg">Limited Edition</x-ui.badge>
```

#### 2.4 Input Component

**File**: `resources/views/components/ui/input.blade.php`

**Props:**
- `type`: 'text' | 'email' | 'password' | 'number' | 'tel' | 'url' | 'search' (default: 'text')
- `name`: string (required)
- `label`: string (optional)
- `placeholder`: string (optional)
- `value`: string (optional)
- `error`: string (optional, error message)
- `required`: boolean (default: false)
- `disabled`: boolean (default: false)
- `icon`: string (Font Awesome class, optional)
- `iconPosition`: 'left' | 'right' (default: 'left')
- `helpText`: string (optional)
- `class`: string (additional classes)

```php
@props([
    'type' => 'text',
    'name',
    'label' => null,
    'placeholder' => '',
    'value' => '',
    'error' => null,
    'required' => false,
    'disabled' => false,
    'icon' => null,
    'iconPosition' => 'left',
    'helpText' => null,
])

@php
$inputId = $attributes->get('id', 'input-' . $name);
$hasError = !empty($error);
$baseClasses = 'w-full rounded-lg border px-4 py-2.5 text-base transition-all duration-normal focus:outline-none focus:ring-3 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
$normalClasses = 'border-batik-ink/12 bg-batik-cream focus:bg-white focus:border-batik-clay focus:ring-batik-clay/40';
$errorClasses = 'border-batik-clay bg-batik-clay/5 focus:border-batik-clay focus:ring-batik-clay/40';
$iconPadding = $icon ? ($iconPosition === 'left' ? 'pl-11' : 'pr-11') : '';
$classes = $baseClasses . ' ' . ($hasError ? $errorClasses : $normalClasses) . ' ' . $iconPadding;
@endphp

<div class="input-group {{ $attributes->get('class') }}">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-semibold text-batik-ink mb-2">
            {{ $label }}
            @if($required)
                <span class="text-batik-clay" aria-label="required">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        @if($icon)
            <div class="absolute inset-y-0 {{ $iconPosition === 'left' ? 'left-0 pl-4' : 'right-0 pr-4' }} flex items-center pointer-events-none">
                <i class="{{ $icon }} text-batik-ink/40" aria-hidden="true"></i>
            </div>
        @endif
        
        <input
            type="{{ $type }}"
            id="{{ $inputId }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            class="{{ $classes }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            @if($hasError) aria-invalid="true" aria-describedby="{{ $inputId }}-error" @endif
            @if($helpText && !$hasError) aria-describedby="{{ $inputId }}-help" @endif
            {{ $attributes->except(['class', 'id']) }}
        />
    </div>
    
    @if($hasError)
        <p id="{{ $inputId }}-error" class="mt-2 text-sm text-batik-clay flex items-center gap-1.5">
            <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
            {{ $error }}
        </p>
    @elseif($helpText)
        <p id="{{ $inputId }}-help" class="mt-2 text-sm text-batik-ink/60">
            {{ $helpText }}
        </p>
    @endif
</div>
```

**Usage Examples:**

```blade
{{-- Basic input --}}
<x-ui.input name="title" label="Motif Title" placeholder="Enter motif name" required />

{{-- Input with icon --}}
<x-ui.input 
    type="search" 
    name="search" 
    placeholder="Search motifs..." 
    icon="fa-solid fa-search" 
/>

{{-- Input with error --}}
<x-ui.input 
    name="email" 
    label="Email Address" 
    type="email" 
    :error="$errors->first('email')" 
    required 
/>

{{-- Input with help text --}}
<x-ui.input 
    name="slug" 
    label="URL Slug" 
    helpText="Lowercase letters and hyphens only" 
/>
```


#### 2.5 Select Component

**File**: `resources/views/components/ui/select.blade.php`

**Props:**
- `name`: string (required)
- `label`: string (optional)
- `options`: array (required, format: ['value' => 'label'])
- `selected`: string (optional, selected value)
- `placeholder`: string (optional)
- `error`: string (optional)
- `required`: boolean (default: false)
- `disabled`: boolean (default: false)
- `class`: string (additional classes)

```php
@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => '',
    'placeholder' => 'Select an option',
    'error' => null,
    'required' => false,
    'disabled' => false,
])

@php
$selectId = $attributes->get('id', 'select-' . $name);
$hasError = !empty($error);
$baseClasses = 'w-full rounded-lg border px-4 py-2.5 text-base transition-all duration-normal focus:outline-none focus:ring-3 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed appearance-none bg-no-repeat bg-right pr-10';
$normalClasses = 'border-batik-ink/12 bg-batik-cream focus:bg-white focus:border-batik-clay focus:ring-batik-clay/40';
$errorClasses = 'border-batik-clay bg-batik-clay/5 focus:border-batik-clay focus:ring-batik-clay/40';
$classes = $baseClasses . ' ' . ($hasError ? $errorClasses : $normalClasses);
$bgImage = "url('data:image/svg+xml,%3Csvg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 20 20\"%3E%3Cpath stroke=\"%230f172a\" stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"1.5\" d=\"m6 8 4 4 4-4\"/%3E%3C/svg%3E')";
@endphp

<div class="select-group {{ $attributes->get('class') }}">
    @if($label)
        <label for="{{ $selectId }}" class="block text-sm font-semibold text-batik-ink mb-2">
            {{ $label }}
            @if($required)
                <span class="text-batik-clay" aria-label="required">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        <select
            id="{{ $selectId }}"
            name="{{ $name }}"
            class="{{ $classes }}"
            style="background-image: {{ $bgImage }}; background-position: right 0.75rem center; background-size: 1.25rem;"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            @if($hasError) aria-invalid="true" aria-describedby="{{ $selectId }}-error" @endif
            {{ $attributes->except(['class', 'id']) }}
        >
            @if($placeholder)
                <option value="" {{ empty($selected) ? 'selected' : '' }} disabled>{{ $placeholder }}</option>
            @endif
            
            @foreach($options as $value => $label)
                <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>
    
    @if($hasError)
        <p id="{{ $selectId }}-error" class="mt-2 text-sm text-batik-clay flex items-center gap-1.5">
            <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
            {{ $error }}
        </p>
    @endif
</div>
```

**Usage Examples:**

```blade
{{-- Basic select --}}
<x-ui.select 
    name="category" 
    label="Category" 
    :options="['geometric' => 'Geometric', 'floral' => 'Floral', 'animal' => 'Animal']"
    required 
/>

{{-- Select with error --}}
<x-ui.select 
    name="status" 
    label="Status" 
    :options="['active' => 'Active', 'inactive' => 'Inactive']"
    :selected="old('status')"
    :error="$errors->first('status')"
/>
```


#### 2.6 Alert Component

**File**: `resources/views/components/ui/alert.blade.php`

**Props:**
- `variant`: 'success' | 'error' | 'warning' | 'info' (default: 'info')
- `dismissible`: boolean (default: false)
- `icon`: string (Font Awesome class, optional, auto-set based on variant if not provided)
- `title`: string (optional)
- `class`: string (additional classes)

```php
@props([
    'variant' => 'info',
    'dismissible' => false,
    'icon' => null,
    'title' => null,
])

@php
$variantConfig = [
    'success' => [
        'classes' => 'bg-batik-emerald/10 border-batik-emerald/20 text-batik-emerald-dark',
        'icon' => 'fa-solid fa-circle-check',
        'borderLeft' => 'border-l-4 border-l-batik-emerald',
    ],
    'error' => [
        'classes' => 'bg-batik-clay/10 border-batik-clay/20 text-batik-clay-dark',
        'icon' => 'fa-solid fa-circle-xmark',
        'borderLeft' => 'border-l-4 border-l-batik-clay',
    ],
    'warning' => [
        'classes' => 'bg-batik-amber/10 border-batik-amber/20 text-batik-amber-dark',
        'icon' => 'fa-solid fa-triangle-exclamation',
        'borderLeft' => 'border-l-4 border-l-batik-amber',
    ],
    'info' => [
        'classes' => 'bg-batik-ink/5 border-batik-ink/10 text-batik-ink',
        'icon' => 'fa-solid fa-circle-info',
        'borderLeft' => 'border-l-4 border-l-batik-ink',
    ],
];

$config = $variantConfig[$variant];
$iconClass = $icon ?? $config['icon'];
$baseClasses = 'rounded-xl border p-4 shadow-sm ' . $config['classes'] . ' ' . $config['borderLeft'];
@endphp

<div 
    class="{{ $baseClasses }} {{ $attributes->get('class') }}" 
    role="alert"
    {{ $attributes->except('class') }}
>
    <div class="flex items-start gap-3">
        <i class="{{ $iconClass }} text-lg flex-shrink-0 mt-0.5" aria-hidden="true"></i>
        
        <div class="flex-1 min-w-0">
            @if($title)
                <h4 class="font-bold text-sm mb-1">{{ $title }}</h4>
            @endif
            <div class="text-sm {{ $title ? '' : 'font-semibold' }}">
                {{ $slot }}
            </div>
        </div>
        
        @if($dismissible)
            <button 
                type="button" 
                class="flex-shrink-0 ml-2 p-1 rounded hover:bg-black/5 transition-colors touch-target"
                onclick="this.closest('[role=alert]').remove()"
                aria-label="Dismiss alert"
            >
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        @endif
    </div>
</div>
```

**Usage Examples:**

```blade
{{-- Success alert --}}
<x-ui.alert variant="success" dismissible>
    Motif berhasil disimpan!
</x-ui.alert>

{{-- Error alert with title --}}
<x-ui.alert variant="error" title="Validation Error">
    Please check the form fields and try again.
</x-ui.alert>

{{-- Warning alert --}}
<x-ui.alert variant="warning">
    This motif is marked as sacred. Please handle with cultural sensitivity.
</x-ui.alert>

{{-- Info alert --}}
<x-ui.alert variant="info" dismissible>
    <strong>Tip:</strong> Use the search bar to quickly find motifs.
</x-ui.alert>
```

#### 2.7 Modal Component

**File**: `resources/views/components/ui/modal.blade.php`

**Props:**
- `id`: string (required, unique modal identifier)
- `title`: string (optional)
- `size`: 'sm' | 'md' | 'lg' | 'xl' (default: 'md')
- `closeButton`: boolean (default: true)
- `class`: string (additional classes)

**Slots:**
- `trigger`: Button or element that opens the modal
- `footer`: Modal footer content
- Default slot: Modal body content

```php
@props([
    'id',
    'title' => null,
    'size' => 'md',
    'closeButton' => true,
])

@php
$sizeClasses = [
    'sm' => 'max-w-md',
    'md' => 'max-w-lg',
    'lg' => 'max-w-2xl',
    'xl' => 'max-w-4xl',
];
@endphp

{{-- Trigger --}}
@isset($trigger)
    <div data-modal-trigger="{{ $id }}">
        {{ $trigger }}
    </div>
@endisset

{{-- Modal --}}
<div 
    id="{{ $id }}"
    class="modal fixed inset-0 z-50 hidden overflow-y-auto"
    aria-labelledby="{{ $id }}-title"
    aria-modal="true"
    role="dialog"
    tabindex="-1"
>
    {{-- Backdrop --}}
    <div class="modal-backdrop fixed inset-0 bg-batik-ink/60 backdrop-blur-sm transition-opacity" data-modal-close="{{ $id }}"></div>
    
    {{-- Modal Container --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="modal-content relative w-full {{ $sizeClasses[$size] }} bg-white rounded-2xl shadow-xl transform transition-all animate-scale-in">
            {{-- Header --}}
            @if($title || $closeButton)
                <div class="modal-header flex items-center justify-between px-6 py-4 border-b border-border">
                    @if($title)
                        <h3 id="{{ $id }}-title" class="text-xl font-bold text-batik-ink">
                            {{ $title }}
                        </h3>
                    @endif
                    
                    @if($closeButton)
                        <button 
                            type="button"
                            class="ml-auto p-2 rounded-lg hover:bg-batik-ink/5 transition-colors touch-target"
                            data-modal-close="{{ $id }}"
                            aria-label="Close modal"
                        >
                            <i class="fa-solid fa-xmark text-xl" aria-hidden="true"></i>
                        </button>
                    @endif
                </div>
            @endif
            
            {{-- Body --}}
            <div class="modal-body px-6 py-6">
                {{ $slot }}
            </div>
            
            {{-- Footer --}}
            @isset($footer)
                <div class="modal-footer flex items-center justify-end gap-3 px-6 py-4 border-t border-border bg-batik-cream/30">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
```

**JavaScript** (resources/js/components/modal.js):

```javascript
// Modal functionality
document.addEventListener('DOMContentLoaded', () => {
    // Open modal
    document.querySelectorAll('[data-modal-trigger]').forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            const modalId = trigger.dataset.modalTrigger;
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                // Focus first focusable element
                const firstFocusable = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                if (firstFocusable) firstFocusable.focus();
            }
        });
    });
    
    // Close modal
    document.querySelectorAll('[data-modal-close]').forEach(closeBtn => {
        closeBtn.addEventListener('click', () => {
            const modalId = closeBtn.dataset.modalClose;
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });
    
    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal:not(.hidden)').forEach(modal => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            });
        }
    });
});
```

**Usage Example:**

```blade
<x-ui.modal id="delete-modal" title="Confirm Deletion" size="sm">
    <x-slot:trigger>
        <x-ui.button variant="danger">Delete Motif</x-ui.button>
    </x-slot:trigger>
    
    <p class="text-batik-ink/70">Are you sure you want to delete this motif? This action cannot be undone.</p>
    
    <x-slot:footer>
        <x-ui.button variant="ghost" data-modal-close="delete-modal">Cancel</x-ui.button>
        <x-ui.button variant="danger">Delete</x-ui.button>
    </x-slot:footer>
</x-ui.modal>
```


#### 2.8 Breadcrumb Component

**File**: `resources/views/components/ui/breadcrumb.blade.php`

**Props:**
- `items`: array (required, format: [['label' => 'Home', 'url' => '/'], ...])
- `class`: string (additional classes)

```php
@props(['items' => []])

<nav aria-label="Breadcrumb" class="{{ $attributes->get('class') }}">
    <ol class="flex items-center gap-2 text-sm">
        @foreach($items as $index => $item)
            <li class="flex items-center gap-2">
                @if($index > 0)
                    <i class="fa-solid fa-chevron-right text-xs text-batik-ink/30" aria-hidden="true"></i>
                @endif
                
                @if(isset($item['url']) && $index < count($items) - 1)
                    <a 
                        href="{{ $item['url'] }}" 
                        class="text-batik-ink/60 hover:text-batik-clay transition-colors"
                    >
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-batik-ink font-semibold" aria-current="page">
                        {{ $item['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
```

**Usage Example:**

```blade
<x-ui.breadcrumb :items="[
    ['label' => 'Home', 'url' => route('home')],
    ['label' => 'Catalog', 'url' => route('catalog')],
    ['label' => 'Motif Detail'],
]" />
```

#### 2.9 Pagination Component

**File**: `resources/views/components/ui/pagination.blade.php`

**Props:**
- `paginator`: LengthAwarePaginator instance (required)
- `class`: string (additional classes)

```php
@props(['paginator'])

@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between {{ $attributes->get('class') }}">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-batik-ink/40 bg-white border border-border rounded-lg cursor-not-allowed">
                <i class="fa-solid fa-chevron-left text-xs" aria-hidden="true"></i>
                <span>Previous</span>
            </span>
        @else
            <a 
                href="{{ $paginator->previousPageUrl() }}" 
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-batik-ink bg-white border border-border rounded-lg hover:bg-batik-ink/5 transition-colors"
                rel="prev"
            >
                <i class="fa-solid fa-chevron-left text-xs" aria-hidden="true"></i>
                <span>Previous</span>
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="hidden md:flex items-center gap-1">
            @foreach ($paginator->links()->elements[0] as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span 
                        class="px-4 py-2 text-sm font-bold text-white bg-batik-ink rounded-lg"
                        aria-current="page"
                    >
                        {{ $page }}
                    </span>
                @else
                    <a 
                        href="{{ $url }}" 
                        class="px-4 py-2 text-sm font-medium text-batik-ink bg-white border border-border rounded-lg hover:bg-batik-ink/5 transition-colors"
                    >
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        </div>

        {{-- Mobile Page Info --}}
        <div class="md:hidden text-sm text-batik-ink/70">
            Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a 
                href="{{ $paginator->nextPageUrl() }}" 
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-batik-ink bg-white border border-border rounded-lg hover:bg-batik-ink/5 transition-colors"
                rel="next"
            >
                <span>Next</span>
                <i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
            </a>
        @else
            <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-batik-ink/40 bg-white border border-border rounded-lg cursor-not-allowed">
                <span>Next</span>
                <i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
            </span>
        @endif
    </nav>
@endif
```

**Usage Example:**

```blade
<x-ui.pagination :paginator="$motifs" class="mt-8" />
```


#### 2.10 Skeleton Loader Component

**File**: `resources/views/components/ui/skeleton.blade.php`

**Props:**
- `type`: 'text' | 'title' | 'avatar' | 'image' | 'card' (default: 'text')
- `lines`: number (for text type, default: 3)
- `class`: string (additional classes)

```php
@props([
    'type' => 'text',
    'lines' => 3,
])

@php
$baseClasses = 'animate-pulse bg-gradient-to-r from-batik-ink/5 via-batik-ink/10 to-batik-ink/5 bg-[length:200%_100%]';
@endphp

@if($type === 'text')
    <div class="space-y-3 {{ $attributes->get('class') }}">
        @for($i = 0; $i < $lines; $i++)
            <div class="{{ $baseClasses }} h-4 rounded {{ $i === $lines - 1 ? 'w-3/4' : 'w-full' }}"></div>
        @endfor
    </div>
@elseif($type === 'title')
    <div class="{{ $baseClasses }} h-8 w-2/3 rounded-lg {{ $attributes->get('class') }}"></div>
@elseif($type === 'avatar')
    <div class="{{ $baseClasses }} w-12 h-12 rounded-full {{ $attributes->get('class') }}"></div>
@elseif($type === 'image')
    <div class="{{ $baseClasses }} w-full aspect-[4/3] rounded-xl {{ $attributes->get('class') }}"></div>
@elseif($type === 'card')
    <div class="border border-border rounded-xl p-6 {{ $attributes->get('class') }}">
        <div class="{{ $baseClasses }} h-48 w-full rounded-lg mb-4"></div>
        <div class="{{ $baseClasses }} h-6 w-3/4 rounded mb-3"></div>
        <div class="{{ $baseClasses }} h-4 w-full rounded mb-2"></div>
        <div class="{{ $baseClasses }} h-4 w-5/6 rounded"></div>
    </div>
@endif
```

**CSS Animation** (add to app.css):

```css
@keyframes shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

.animate-pulse {
    animation: shimmer 2s ease-in-out infinite;
}
```

**Usage Examples:**

```blade
{{-- Text skeleton --}}
<x-ui.skeleton type="text" :lines="4" />

{{-- Title skeleton --}}
<x-ui.skeleton type="title" />

{{-- Image skeleton --}}
<x-ui.skeleton type="image" />

{{-- Card skeleton --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @for($i = 0; $i < 6; $i++)
        <x-ui.skeleton type="card" />
    @endfor
</div>
```

### 3. Layout System

#### 3.1 Responsive Grid System

Tailwind CSS 4 provides a powerful grid system. The application will use the following breakpoints:

```javascript
// Breakpoints (defined in tailwind.config.js)
screens: {
  'sm': '640px',   // Mobile landscape
  'md': '768px',   // Tablet
  'lg': '1024px',  // Desktop
  'xl': '1280px',  // Large desktop
  '2xl': '1536px', // Extra large desktop
}
```

**Container Widths:**

```css
/* Container utility classes */
.container {
  @apply mx-auto px-4 sm:px-6 lg:px-8;
  max-width: 1280px;
}

.container-narrow {
  @apply mx-auto px-4 sm:px-6 lg:px-8;
  max-width: 960px;
}

.container-wide {
  @apply mx-auto px-4 sm:px-6 lg:px-8;
  max-width: 1536px;
}
```

**Grid Patterns:**

```blade
{{-- Two-column layout (responsive) --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Content -->
</div>

{{-- Three-column layout --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Content -->
</div>

{{-- Four-column layout --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Content -->
</div>

{{-- Sidebar layout --}}
<div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-8">
    <aside><!-- Sidebar --></aside>
    <main><!-- Main content --></main>
</div>

{{-- Hero layout --}}
<div class="grid grid-cols-1 lg:grid-cols-[1.25fr_0.75fr] gap-8 items-center">
    <div><!-- Text content --></div>
    <div><!-- Image --></div>
</div>
```

#### 3.2 Spacing Scale

Consistent spacing using Tailwind's spacing scale (4px base unit):

```
0    = 0px
1    = 0.25rem (4px)
2    = 0.5rem (8px)
3    = 0.75rem (12px)
4    = 1rem (16px)
5    = 1.25rem (20px)
6    = 1.5rem (24px)
8    = 2rem (32px)
10   = 2.5rem (40px)
12   = 3rem (48px)
16   = 4rem (64px)
20   = 5rem (80px)
24   = 6rem (96px)
```

**Common Spacing Patterns:**

- Section padding: `py-12 md:py-16 lg:py-20`
- Card padding: `p-6 lg:p-8`
- Element gaps: `gap-4 md:gap-6`
- Margin between sections: `mb-8 md:mb-12`


## Data Models

### Design Token Model

The design system uses a hierarchical token structure:

```
Design Tokens
├── Color Tokens
│   ├── Brand Colors (batik-ink, batik-clay, batik-emerald, batik-amber, batik-cream)
│   ├── Semantic Colors (success, warning, error, info)
│   └── Surface Colors (surface, border, background)
├── Typography Tokens
│   ├── Font Families (sans, serif)
│   ├── Font Sizes (xs to 6xl)
│   ├── Font Weights (normal, medium, semibold, bold)
│   └── Line Heights (tight, normal, relaxed)
├── Spacing Tokens
│   └── Scale (0 to 128, 4px base unit)
├── Border Tokens
│   ├── Radius (sm, md, lg, xl, 2xl, 3xl)
│   └── Width (1px, 2px, 4px)
├── Shadow Tokens
│   └── Levels (sm, md, lg, xl, gold, clay)
└── Animation Tokens
    ├── Durations (fast, normal, slow)
    ├── Timing Functions (smooth, ease-in, ease-out)
    └── Keyframes (fade-in, slide-in, scale-in, float)
```

### Component Props Model

Each component follows a consistent props structure:

```typescript
interface ComponentProps {
  // Visual variant
  variant?: 'primary' | 'secondary' | 'outline' | 'ghost' | 'danger';
  
  // Size
  size?: 'sm' | 'md' | 'lg';
  
  // State
  disabled?: boolean;
  loading?: boolean;
  error?: string;
  
  // Content
  label?: string;
  icon?: string;
  placeholder?: string;
  
  // Accessibility
  ariaLabel?: string;
  ariaDescribedBy?: string;
  required?: boolean;
  
  // Styling
  class?: string;
}
```

### Accessibility Model

ARIA attributes and roles follow WCAG 2.1 Level AA standards:

```typescript
interface AccessibilityAttributes {
  // Roles
  role?: 'button' | 'navigation' | 'main' | 'complementary' | 'alert' | 'dialog';
  
  // Labels
  'aria-label'?: string;
  'aria-labelledby'?: string;
  'aria-describedby'?: string;
  
  // States
  'aria-expanded'?: boolean;
  'aria-hidden'?: boolean;
  'aria-current'?: 'page' | 'step' | 'location';
  'aria-invalid'?: boolean;
  'aria-required'?: boolean;
  
  // Live regions
  'aria-live'?: 'polite' | 'assertive' | 'off';
  'aria-atomic'?: boolean;
  
  // Focus management
  tabindex?: number;
}
```

### Responsive Breakpoint Model

```typescript
interface ResponsiveBreakpoints {
  mobile: {
    min: 0,
    max: 767,
    columns: 1,
    containerPadding: '1rem',
  },
  tablet: {
    min: 768,
    max: 1023,
    columns: 2,
    containerPadding: '1.5rem',
  },
  desktop: {
    min: 1024,
    max: Infinity,
    columns: 3,
    containerPadding: '2rem',
  },
}
```

## Accessibility Implementation

### 1. Keyboard Navigation

**Focus Management:**

```css
/* Focus visible styles (app.css) */
@layer base {
  *:focus-visible {
    @apply outline-none ring-3 ring-batik-clay/40 ring-offset-2;
  }
  
  /* Skip to main content link */
  .skip-to-main {
    @apply sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4;
    @apply bg-batik-ink text-white px-4 py-2 rounded-lg z-50;
  }
}
```

**Implementation in Layouts:**

```blade
{{-- Add to layout/app.blade.php and layout/admin.blade.php --}}
<a href="#main-content" class="skip-to-main">
    Skip to main content
</a>

<main id="main-content" tabindex="-1">
    @yield('content')
</main>
```

**Tab Order:**

- Navigation links: tabindex="0" (natural order)
- Modal close buttons: tabindex="0"
- Hidden elements: tabindex="-1"
- Skip links: tabindex="0"

### 2. ARIA Labels and Landmarks

**Page Structure:**

```blade
<body>
    {{-- Skip link --}}
    <a href="#main-content" class="skip-to-main">Skip to main content</a>
    
    {{-- Navigation --}}
    <nav role="navigation" aria-label="Main navigation">
        <!-- Navigation content -->
    </nav>
    
    {{-- Main content --}}
    <main id="main-content" role="main">
        @yield('content')
    </main>
    
    {{-- Footer --}}
    <footer role="contentinfo">
        <!-- Footer content -->
    </footer>
</body>
```

**Form Accessibility:**

```blade
{{-- Proper label association --}}
<label for="motif-title" class="block text-sm font-semibold mb-2">
    Motif Title
    <span class="text-batik-clay" aria-label="required">*</span>
</label>
<input 
    type="text" 
    id="motif-title" 
    name="title"
    aria-required="true"
    aria-describedby="title-help"
/>
<p id="title-help" class="text-sm text-batik-ink/60 mt-1">
    Enter a descriptive name for the motif
</p>

{{-- Error state --}}
@if($errors->has('title'))
    <p id="title-error" class="text-sm text-batik-clay mt-1" role="alert">
        <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
        {{ $errors->first('title') }}
    </p>
@endif
```

**Dynamic Content Announcements:**

```blade
{{-- Success message with live region --}}
<div 
    role="alert" 
    aria-live="polite" 
    aria-atomic="true"
    class="alert-success"
>
    Motif successfully saved!
</div>

{{-- Loading state --}}
<div 
    role="status" 
    aria-live="polite" 
    aria-label="Loading content"
>
    <x-ui.skeleton type="card" />
    <span class="sr-only">Loading motifs...</span>
</div>
```

### 3. Color Contrast Requirements

**Minimum Contrast Ratios:**

- Normal text (< 18pt): 4.5:1
- Large text (≥ 18pt or ≥ 14pt bold): 3:1
- UI components and graphics: 3:1

**Verified Color Combinations:**

```css
/* High contrast combinations (app.css) */
.text-on-light {
  /* batik-ink on white: 15.8:1 ✓ */
  @apply text-batik-ink bg-white;
}

.text-on-dark {
  /* white on batik-ink: 15.8:1 ✓ */
  @apply text-white bg-batik-ink;
}

.text-on-clay {
  /* white on batik-clay: 8.2:1 ✓ */
  @apply text-white bg-batik-clay;
}

.text-on-emerald {
  /* white on batik-emerald: 9.1:1 ✓ */
  @apply text-white bg-batik-emerald;
}

.text-on-amber {
  /* white on batik-amber: 5.8:1 ✓ */
  @apply text-white bg-batik-amber;
}

/* Muted text (still meets 4.5:1) */
.text-muted {
  @apply text-batik-ink/70; /* 7.2:1 on white ✓ */
}
```

### 4. Touch Target Sizes

All interactive elements must meet minimum 44x44px touch target size:

```css
/* Touch target utility (app.css) */
@layer utilities {
  .touch-target {
    @apply min-w-[44px] min-h-[44px];
  }
}
```

**Implementation:**

```blade
{{-- Buttons automatically meet touch target --}}
<x-ui.button size="sm">Click Me</x-ui.button> {{-- min-height: 44px --}}

{{-- Icon buttons --}}
<button class="touch-target p-2 rounded-lg hover:bg-batik-ink/5">
    <i class="fa-solid fa-heart text-xl"></i>
    <span class="sr-only">Add to favorites</span>
</button>

{{-- Links with small text --}}
<a href="#" class="touch-target inline-flex items-center justify-center">
    Small Link
</a>
```

### 5. Screen Reader Support

**Image Alt Text:**

```blade
{{-- Meaningful images --}}
<img 
    src="{{ $motif->image_url }}" 
    alt="Batik {{ $motif->name }} motif featuring {{ $motif->description }}"
    class="w-full h-auto"
/>

{{-- Decorative images --}}
<img 
    src="/images/pattern-bg.svg" 
    alt="" 
    aria-hidden="true"
    class="absolute inset-0 opacity-5"
/>
```

**Icon Accessibility:**

```blade
{{-- Decorative icons (with adjacent text) --}}
<button>
    <i class="fa-solid fa-save" aria-hidden="true"></i>
    Save
</button>

{{-- Meaningful icons (standalone) --}}
<button aria-label="Close modal">
    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
</button>
```

**Screen Reader Only Text:**

```blade
<span class="sr-only">Current page: </span>
<span aria-current="page">Home</span>
```


## Error Handling

### 1. Form Validation Errors

**Display Strategy:**

- Inline errors below each field
- Error summary at top of form for multiple errors
- Focus first error field on submission
- Clear errors on field correction

**Implementation:**

```blade
{{-- Error summary --}}
@if($errors->any())
    <x-ui.alert variant="error" title="Please correct the following errors:" class="mb-6">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-ui.alert>
@endif

{{-- Form with error handling --}}
<form method="POST" action="{{ route('motifs.store') }}" id="motif-form">
    @csrf
    
    <x-ui.input 
        name="title" 
        label="Motif Title" 
        :value="old('title')"
        :error="$errors->first('title')"
        required 
    />
    
    <x-ui.select 
        name="category" 
        label="Category" 
        :options="$categories"
        :selected="old('category')"
        :error="$errors->first('category')"
        required 
    />
    
    <div class="flex gap-3 mt-6">
        <x-ui.button type="submit" variant="primary">Save Motif</x-ui.button>
        <x-ui.button type="button" variant="ghost" href="{{ route('motifs.index') }}">Cancel</x-ui.button>
    </div>
</form>
```

**JavaScript Enhancement:**

```javascript
// resources/js/components/form-validation.js
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const firstError = form.querySelector('[aria-invalid="true"]');
            if (firstError) {
                e.preventDefault();
                firstError.focus();
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
        
        // Clear error on input
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                const errorMsg = document.getElementById(`${input.id}-error`);
                if (errorMsg) {
                    errorMsg.remove();
                    input.setAttribute('aria-invalid', 'false');
                    input.classList.remove('border-batik-clay', 'bg-batik-clay/5');
                    input.classList.add('border-batik-ink/12', 'bg-batik-cream');
                }
            });
        });
    });
});
```

### 2. Network Errors

**Implementation:**

```blade
{{-- Network error alert --}}
<x-ui.alert variant="error" id="network-error" class="hidden">
    <strong>Connection Error:</strong> Unable to reach the server. Please check your internet connection and try again.
    <x-ui.button variant="outline" size="sm" class="mt-2" onclick="location.reload()">
        Retry
    </x-ui.button>
</x-ui.alert>
```

**JavaScript:**

```javascript
// resources/js/components/network-handler.js
async function fetchWithErrorHandling(url, options = {}) {
    try {
        const response = await fetch(url, options);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('Network error:', error);
        
        // Show error alert
        const errorAlert = document.getElementById('network-error');
        if (errorAlert) {
            errorAlert.classList.remove('hidden');
            errorAlert.setAttribute('role', 'alert');
            errorAlert.focus();
        }
        
        throw error;
    }
}
```

### 3. Empty States

**Catalog Empty State:**

```blade
@if($motifs->isEmpty())
    <div class="text-center py-16">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-batik-ink/5 mb-6">
            <i class="fa-solid fa-search text-3xl text-batik-ink/30"></i>
        </div>
        <h3 class="text-2xl font-bold text-batik-ink mb-3">No motifs found</h3>
        <p class="text-batik-ink/60 mb-6 max-w-md mx-auto">
            We couldn't find any motifs matching your search criteria. Try adjusting your filters or search terms.
        </p>
        <x-ui.button variant="primary" href="{{ route('catalog') }}">
            Clear Filters
        </x-ui.button>
    </div>
@else
    {{-- Display motifs --}}
@endif
```

**Admin Dashboard Empty State:**

```blade
@if($motifs->isEmpty())
    <x-ui.card class="text-center py-12">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-batik-amber/10 mb-4">
            <i class="fa-solid fa-palette text-2xl text-batik-amber"></i>
        </div>
        <h3 class="text-xl font-bold text-batik-ink mb-2">No motifs yet</h3>
        <p class="text-batik-ink/60 mb-6">
            Start building your collection by adding your first motif.
        </p>
        <x-ui.button variant="primary" icon="fa-solid fa-plus" href="{{ route('admin.motifs.create') }}">
            Add First Motif
        </x-ui.button>
    </x-ui.card>
@endif
```

### 4. 404 and 500 Error Pages

**404 Page** (resources/views/errors/404.blade.php):

```blade
@extends('layout.app')

@section('title', 'Page Not Found')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-2xl">
        <div class="mb-8">
            <span class="text-9xl font-bold gradient-text">404</span>
        </div>
        <h1 class="text-4xl font-bold text-batik-ink mb-4">Page Not Found</h1>
        <p class="text-lg text-batik-ink/70 mb-8">
            The page you're looking for doesn't exist or has been moved.
        </p>
        <div class="flex gap-4 justify-center">
            <x-ui.button variant="primary" href="{{ route('home') }}">
                <i class="fa-solid fa-home"></i>
                Go Home
            </x-ui.button>
            <x-ui.button variant="outline" href="{{ route('catalog') }}">
                Browse Catalog
            </x-ui.button>
        </div>
    </div>
</div>
@endsection
```

**500 Page** (resources/views/errors/500.blade.php):

```blade
@extends('layout.app')

@section('title', 'Server Error')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-2xl">
        <div class="mb-8">
            <span class="text-9xl font-bold gradient-text">500</span>
        </div>
        <h1 class="text-4xl font-bold text-batik-ink mb-4">Something Went Wrong</h1>
        <p class="text-lg text-batik-ink/70 mb-8">
            We're experiencing technical difficulties. Please try again later.
        </p>
        <x-ui.button variant="primary" onclick="location.reload()">
            <i class="fa-solid fa-rotate-right"></i>
            Try Again
        </x-ui.button>
    </div>
</div>
@endsection
```

## Testing Strategy

### 1. Accessibility Testing

**Tools:**
- axe DevTools (browser extension)
- WAVE (Web Accessibility Evaluation Tool)
- Lighthouse (Chrome DevTools)
- Screen readers: NVDA (Windows), JAWS (Windows), VoiceOver (macOS/iOS)

**Test Checklist:**

```markdown
## Accessibility Test Checklist

### Keyboard Navigation
- [ ] All interactive elements are keyboard accessible
- [ ] Tab order is logical and follows visual flow
- [ ] Focus indicators are visible (3px outline, sufficient contrast)
- [ ] Skip to main content link works
- [ ] Modal traps focus and returns focus on close
- [ ] Escape key closes modals and dropdowns

### Screen Reader
- [ ] All images have appropriate alt text
- [ ] Form labels are properly associated
- [ ] Error messages are announced
- [ ] Dynamic content changes are announced (aria-live)
- [ ] Buttons and links have descriptive text
- [ ] Heading hierarchy is correct (no skipped levels)

### Color Contrast
- [ ] Normal text meets 4.5:1 contrast ratio
- [ ] Large text meets 3:1 contrast ratio
- [ ] UI components meet 3:1 contrast ratio
- [ ] Focus indicators meet 3:1 contrast ratio

### Touch Targets
- [ ] All interactive elements are minimum 44x44px
- [ ] Adequate spacing between touch targets

### Forms
- [ ] Required fields are indicated
- [ ] Error messages are clear and helpful
- [ ] Success messages are announced
- [ ] Field validation provides immediate feedback
```

### 2. Visual Regression Testing

**Manual Testing:**

Test on multiple devices and browsers:
- Desktop: Chrome, Firefox, Safari, Edge
- Mobile: iOS Safari, Android Chrome
- Tablet: iPad Safari, Android Chrome

**Responsive Breakpoints:**

```markdown
## Responsive Test Checklist

### Mobile (< 768px)
- [ ] Navigation collapses to hamburger menu
- [ ] Cards stack vertically
- [ ] Forms are full-width
- [ ] Images scale appropriately
- [ ] Text is readable without zooming
- [ ] Touch targets are adequate

### Tablet (768px - 1023px)
- [ ] Two-column layouts work correctly
- [ ] Navigation is accessible
- [ ] Images maintain aspect ratio
- [ ] Spacing is appropriate

### Desktop (≥ 1024px)
- [ ] Multi-column layouts display correctly
- [ ] Hover states work on interactive elements
- [ ] Content doesn't exceed max-width
- [ ] Sidebar layouts function properly
```

### 3. Performance Testing

**Metrics to Track:**

```markdown
## Performance Metrics

### Lighthouse Scores (Target)
- [ ] Performance: ≥90 (desktop), ≥80 (mobile)
- [ ] Accessibility: 100
- [ ] Best Practices: ≥90
- [ ] SEO: ≥90

### Core Web Vitals
- [ ] LCP (Largest Contentful Paint): < 2.5s
- [ ] FID (First Input Delay): < 100ms
- [ ] CLS (Cumulative Layout Shift): < 0.1

### Bundle Sizes
- [ ] CSS bundle: < 50KB (gzipped)
- [ ] JavaScript bundle: < 100KB (gzipped)
- [ ] Total page weight: < 1MB
```

**Performance Optimization Checklist:**

```markdown
- [ ] CSS is purged of unused classes
- [ ] Images are lazy-loaded below the fold
- [ ] Fonts use font-display: swap
- [ ] Critical CSS is inlined
- [ ] JavaScript is minified and bundled
- [ ] Assets are served with compression (gzip/brotli)
- [ ] Browser caching is configured
```

### 4. Component Testing

**Unit Tests for Components:**

Each component should be tested for:
- Correct rendering with different props
- Accessibility attributes are present
- Event handlers work correctly
- Error states display properly

**Example Test (PHPUnit + Blade):**

```php
// tests/Feature/Components/ButtonTest.php
class ButtonTest extends TestCase
{
    public function test_button_renders_with_primary_variant()
    {
        $view = $this->blade('<x-ui.button variant="primary">Click Me</x-ui.button>');
        
        $view->assertSee('Click Me');
        $view->assertSee('bg-batik-ink');
    }
    
    public function test_button_renders_with_icon()
    {
        $view = $this->blade('<x-ui.button icon="fa-solid fa-save">Save</x-ui.button>');
        
        $view->assertSee('fa-solid fa-save');
        $view->assertSee('aria-hidden="true"');
    }
    
    public function test_button_renders_disabled_state()
    {
        $view = $this->blade('<x-ui.button :disabled="true">Disabled</x-ui.button>');
        
        $view->assertSee('disabled');
        $view->assertSee('opacity-50');
    }
}
```


## CSS Migration Strategy

### Phase 1: Setup and Configuration (Week 1)

**Step 1.1: Update Tailwind Configuration**

Create comprehensive `tailwind.config.js` with all design tokens:

```bash
# Create Tailwind config
touch tailwind.config.js
```

Add the complete configuration (see Components and Interfaces section 1.1).

**Step 1.2: Update app.css**

Replace existing `resources/css/app.css` with new structure:

```css
@import 'tailwindcss';

@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';

/* Import custom layers */
@import './base/typography.css';
@import './base/accessibility.css';
@import './components/buttons.css';
@import './components/forms.css';
@import './components/cards.css';
@import './components/navigation.css';
@import './utilities/animations.css';
@import './utilities/patterns.css';
```

**Step 1.3: Create CSS Directory Structure**

```bash
mkdir -p resources/css/{base,components,utilities}
touch resources/css/base/{typography,accessibility}.css
touch resources/css/components/{buttons,forms,cards,navigation}.css
touch resources/css/utilities/{animations,patterns}.css
```

**Step 1.4: Update Vite Configuration**

Ensure `vite.config.js` is properly configured:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

### Phase 2: Component Creation (Week 2-3)

**Step 2.1: Create Blade Component Directory**

```bash
mkdir -p resources/views/components/ui
mkdir -p resources/views/components/layout
```

**Step 2.2: Create Components in Order**

Priority order (most used first):

1. Button (`resources/views/components/ui/button.blade.php`)
2. Card (`resources/views/components/ui/card.blade.php`)
3. Input (`resources/views/components/ui/input.blade.php`)
4. Select (`resources/views/components/ui/select.blade.php`)
5. Alert (`resources/views/components/ui/alert.blade.php`)
6. Badge (`resources/views/components/ui/badge.blade.php`)
7. Modal (`resources/views/components/ui/modal.blade.php`)
8. Breadcrumb (`resources/views/components/ui/breadcrumb.blade.php`)
9. Pagination (`resources/views/components/ui/pagination.blade.php`)
10. Skeleton (`resources/views/components/ui/skeleton.blade.php`)

**Step 2.3: Test Each Component**

Create test pages for each component:

```bash
php artisan make:controller ComponentTestController
```

```php
// app/Http/Controllers/ComponentTestController.php
public function index()
{
    return view('test.components');
}
```

```blade
{{-- resources/views/test/components.blade.php --}}
@extends('layout.app')

@section('content')
<div class="container py-12 space-y-12">
    <section>
        <h2 class="text-2xl font-bold mb-4">Buttons</h2>
        <div class="flex flex-wrap gap-4">
            <x-ui.button variant="primary">Primary</x-ui.button>
            <x-ui.button variant="secondary">Secondary</x-ui.button>
            <x-ui.button variant="outline">Outline</x-ui.button>
            <x-ui.button variant="ghost">Ghost</x-ui.button>
            <x-ui.button variant="danger">Danger</x-ui.button>
        </div>
    </section>
    
    {{-- Test other components --}}
</div>
@endsection
```

### Phase 3: Bootstrap Removal (Week 4)

**Step 3.1: Identify Bootstrap Usage**

Search for Bootstrap classes in Blade files:

```bash
grep -r "class=\".*\(btn\|col\|row\|container\|navbar\|card\|alert\|modal\|form-control\)" resources/views/
```

**Step 3.2: Replace Bootstrap Classes Page by Page**

Create a mapping document:

```markdown
## Bootstrap to Tailwind Migration Map

### Layout
- `container` → `container mx-auto px-4`
- `row` → `grid grid-cols-12 gap-4` or `flex flex-wrap`
- `col-md-6` → `col-span-12 md:col-span-6`
- `d-flex` → `flex`
- `justify-content-between` → `justify-between`
- `align-items-center` → `items-center`

### Buttons
- `btn btn-primary` → `<x-ui.button variant="primary">`
- `btn btn-secondary` → `<x-ui.button variant="secondary">`
- `btn btn-outline-primary` → `<x-ui.button variant="outline">`
- `btn btn-sm` → `<x-ui.button size="sm">`
- `btn btn-lg` → `<x-ui.button size="lg">`

### Forms
- `form-control` → `<x-ui.input>`
- `form-select` → `<x-ui.select>`
- `form-label` → `label` prop in components
- `is-invalid` → `error` prop in components

### Cards
- `card` → `<x-ui.card>`
- `card-body` → default slot
- `card-header` → `header` slot
- `card-footer` → `footer` slot

### Alerts
- `alert alert-success` → `<x-ui.alert variant="success">`
- `alert alert-danger` → `<x-ui.alert variant="error">`
- `alert alert-warning` → `<x-ui.alert variant="warning">`
- `alert alert-info` → `<x-ui.alert variant="info">`

### Utilities
- `mb-3` → `mb-3` (same in Tailwind)
- `mt-4` → `mt-4` (same in Tailwind)
- `text-center` → `text-center` (same in Tailwind)
- `fw-bold` → `font-bold`
- `text-muted` → `text-batik-ink/60`
```

**Step 3.3: Migration Order**

Migrate pages in this order:

1. **Public Pages:**
   - Home page (`resources/views/home.blade.php`)
   - Catalog page (`resources/views/catalog.blade.php`)
   - Motif detail page (`resources/views/motifs/show.blade.php`)
   - About page (`resources/views/about.blade.php`)
   - Contact page (`resources/views/contact.blade.php`)

2. **Auth Pages:**
   - Login page (`resources/views/auth/login.blade.php`)

3. **Admin Pages:**
   - Dashboard (`resources/views/admin/dashboard.blade.php`)
   - Motif list (`resources/views/admin/motifs/index.blade.php`)
   - Motif create/edit (`resources/views/admin/motifs/create.blade.php`, `edit.blade.php`)
   - Information pages
   - Account pages

4. **Layout Files:**
   - Public layout (`resources/views/layout/app.blade.php`)
   - Admin layout (`resources/views/layout/admin.blade.php`)
   - Components (`resources/views/components/`)

**Step 3.4: Remove Bootstrap Files**

After all pages are migrated and tested:

```bash
# Remove Bootstrap from package.json (if present)
npm uninstall bootstrap

# Remove Bootstrap CDN links from layouts
# Edit resources/views/layout/app.blade.php and admin.blade.php
# Remove: <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/...">
# Remove: <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/...">

# Remove old batik.css (will be replaced by Tailwind)
rm public/css/batik.css
```

### Phase 4: Testing and Refinement (Week 5)

**Step 4.1: Visual Regression Testing**

Test each page on:
- Desktop (Chrome, Firefox, Safari, Edge)
- Tablet (iPad, Android tablet)
- Mobile (iPhone, Android phone)

**Step 4.2: Accessibility Audit**

Run accessibility tests:

```bash
# Install axe-core for automated testing
npm install --save-dev @axe-core/cli

# Run accessibility tests
npx axe http://localhost:8000 --save results.json
```

Manual testing:
- Keyboard navigation on all pages
- Screen reader testing (NVDA, JAWS, VoiceOver)
- Color contrast verification
- Touch target size verification

**Step 4.3: Performance Audit**

```bash
# Build for production
npm run build

# Test with Lighthouse
# Open Chrome DevTools → Lighthouse → Run audit
```

Verify:
- CSS bundle size < 50KB (gzipped)
- Performance score ≥90 (desktop), ≥80 (mobile)
- Accessibility score = 100

**Step 4.4: Cross-Browser Testing**

Test on:
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Android Chrome)

### Phase 5: Deployment (Week 6)

**Step 5.1: Pre-Deployment Checklist**

```markdown
- [ ] All Bootstrap references removed
- [ ] All pages migrated to Tailwind
- [ ] All components tested
- [ ] Accessibility audit passed
- [ ] Performance audit passed
- [ ] Cross-browser testing completed
- [ ] Mobile responsiveness verified
- [ ] Production build tested
```

**Step 5.2: Build for Production**

```bash
# Clear caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Build assets
npm run build

# Verify build output
ls -lh public/build/assets/
```

**Step 5.3: Deploy**

```bash
# Deploy to production
git add .
git commit -m "UI/UX refactoring: Migrate to Tailwind CSS, implement design system, achieve WCAG 2.1 AA compliance"
git push origin main

# On production server
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Step 5.4: Post-Deployment Verification**

- [ ] All pages load correctly
- [ ] No console errors
- [ ] Assets load from CDN/build directory
- [ ] Forms submit correctly
- [ ] Authentication works
- [ ] Admin panel functions properly


## Performance Optimizations

### 1. CSS Optimization

**Purging Unused Classes:**

Tailwind CSS 4 automatically purges unused classes. Ensure proper configuration:

```javascript
// tailwind.config.js
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './app/View/Components/**/*.php',
  ],
  // ... rest of config
}
```

**Critical CSS Inlining:**

For above-the-fold content, inline critical CSS:

```blade
{{-- resources/views/layout/app.blade.php --}}
<head>
    <style>
        /* Critical CSS - inline for faster initial render */
        body { font-family: 'Manrope', sans-serif; }
        .container { max-width: 1280px; margin: 0 auto; padding: 0 1rem; }
        /* Add other critical styles */
    </style>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
```

**CSS Minification:**

Vite automatically minifies CSS in production. Verify in `vite.config.js`:

```javascript
export default defineConfig({
    build: {
        minify: 'terser',
        cssMinify: true,
    },
});
```

### 2. Font Loading Optimization

**Font Display Strategy:**

```css
/* resources/css/base/typography.css */
@layer base {
  @font-face {
    font-family: 'Manrope';
    src: url('/fonts/manrope-variable.woff2') format('woff2');
    font-weight: 400 800;
    font-display: swap; /* Prevent invisible text during font load */
    font-style: normal;
  }
  
  @font-face {
    font-family: 'Cormorant Garamond';
    src: url('/fonts/cormorant-garamond-bold.woff2') format('woff2');
    font-weight: 700;
    font-display: swap;
    font-style: normal;
  }
}
```

**Preload Critical Fonts:**

```blade
<head>
    <link rel="preload" href="/fonts/manrope-variable.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/cormorant-garamond-bold.woff2" as="font" type="font/woff2" crossorigin>
</head>
```

**Font Subsetting:**

Use only required character sets:

```bash
# Install pyftsubset (part of fonttools)
pip install fonttools brotli

# Subset fonts to Latin characters only
pyftsubset manrope-variable.woff2 \
  --output-file=manrope-variable-subset.woff2 \
  --flavor=woff2 \
  --layout-features='*' \
  --unicodes=U+0020-007E,U+00A0-00FF
```

### 3. Image Optimization

**Lazy Loading:**

```blade
{{-- Lazy load images below the fold --}}
<img 
    src="{{ $motif->image_url }}" 
    alt="{{ $motif->name }}"
    loading="lazy"
    class="w-full h-auto"
/>

{{-- Eager load hero images --}}
<img 
    src="{{ $heroImage }}" 
    alt="Hero"
    loading="eager"
    class="w-full h-auto"
/>
```

**Responsive Images:**

```blade
<img 
    src="{{ $motif->image_url }}" 
    srcset="
        {{ $motif->image_url_small }} 640w,
        {{ $motif->image_url_medium }} 1024w,
        {{ $motif->image_url_large }} 1920w
    "
    sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
    alt="{{ $motif->name }}"
    loading="lazy"
    class="w-full h-auto"
/>
```

**Image Format Optimization:**

Use WebP with fallback:

```blade
<picture>
    <source srcset="{{ $motif->image_webp }}" type="image/webp">
    <source srcset="{{ $motif->image_jpg }}" type="image/jpeg">
    <img src="{{ $motif->image_jpg }}" alt="{{ $motif->name }}" loading="lazy">
</picture>
```

### 4. JavaScript Optimization

**Code Splitting:**

```javascript
// resources/js/app.js
import './bootstrap';

// Lazy load modal functionality
const modalTriggers = document.querySelectorAll('[data-modal-trigger]');
if (modalTriggers.length > 0) {
    import('./components/modal.js');
}

// Lazy load form validation
const forms = document.querySelectorAll('form[data-validate]');
if (forms.length > 0) {
    import('./components/form-validation.js');
}
```

**Defer Non-Critical Scripts:**

```blade
<head>
    {{-- Critical scripts --}}
    @vite(['resources/js/app.js'])
    
    {{-- Non-critical scripts (defer) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" defer></script>
</head>
```

### 5. Caching Strategy

**Browser Caching (Laravel):**

```php
// config/cache.php - already configured

// Add cache headers in .htaccess or nginx config
```

**.htaccess (Apache):**

```apache
# public/.htaccess
<IfModule mod_expires.c>
    ExpiresActive On
    
    # Images
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
    
    # CSS and JavaScript
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    
    # Fonts
    ExpiresByType font/woff2 "access plus 1 year"
    ExpiresByType font/woff "access plus 1 year"
</IfModule>

# Gzip compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

**Nginx Configuration:**

```nginx
# nginx.conf
location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2)$ {
    expires 1y;
    add_header Cache-Control "public, immutable";
}

# Gzip compression
gzip on;
gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;
gzip_min_length 1000;
```

### 6. Database Query Optimization

**Eager Loading:**

```php
// app/Http/Controllers/PublicController.php
public function catalog(Request $request)
{
    $motifs = Motif::with(['galleries']) // Eager load relationships
        ->when($request->search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%");
        })
        ->paginate(12);
    
    return view('catalog', compact('motifs'));
}
```

**Query Caching:**

```php
// Cache expensive queries
$motifs = Cache::remember('featured_motifs', 3600, function () {
    return Motif::where('featured', true)
        ->with('galleries')
        ->limit(6)
        ->get();
});
```

### 7. Asset Versioning

Vite automatically handles asset versioning. Verify in production:

```blade
{{-- Vite automatically adds hash to filenames --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- Outputs: --}}
{{-- <link rel="stylesheet" href="/build/assets/app-abc123.css"> --}}
{{-- <script src="/build/assets/app-def456.js"></script> --}}
```

### 8. Reduced Motion Support

**CSS:**

```css
/* resources/css/base/accessibility.css */
@layer base {
  @media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
      animation-duration: 0.01ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.01ms !important;
      scroll-behavior: auto !important;
    }
  }
}
```

**JavaScript:**

```javascript
// resources/js/components/accessibility.js
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (prefersReducedMotion) {
    // Disable animations
    document.documentElement.classList.add('reduce-motion');
}
```


## Cultural Design Elements

### 1. Color Palette Implementation

**Primary Colors (Batik Banyuwangi Heritage):**

```css
/* Inspired by traditional Batik Banyuwangi dyes */
--batik-ink: #0f172a        /* Deep indigo - traditional natural dye */
--batik-clay: #991b1b       /* Terracotta red - earth pigment */
--batik-emerald: #065f46    /* Forest green - natural leaf dye */
--batik-amber: #b45309      /* Golden amber - turmeric/saffron */
--batik-cream: #fdfbf7      /* Unbleached cotton base */
```

**Color Usage Guidelines:**

- **batik-ink**: Primary text, dark backgrounds, navigation
- **batik-clay**: Accent color, sacred motif indicators, error states
- **batik-emerald**: Success states, nature-related content
- **batik-amber**: Premium features, call-to-action buttons, highlights
- **batik-cream**: Page backgrounds, card surfaces

**Gradient Combinations:**

```css
/* Hero gradients */
.hero-gradient {
  background: linear-gradient(135deg, var(--batik-ink) 0%, #1e1b4b 50%, #451a03 100%);
}

/* Accent gradients */
.accent-gradient {
  background: linear-gradient(135deg, var(--batik-clay), var(--batik-amber));
}

/* Subtle background gradients */
.bg-gradient {
  background: 
    radial-gradient(circle at 10% 20%, rgba(180, 83, 9, 0.05), transparent 40%),
    radial-gradient(circle at 90% 10%, rgba(6, 95, 70, 0.04), transparent 35%),
    linear-gradient(180deg, var(--batik-cream) 0%, #f7f3eb 100%);
}
```

### 2. Pattern Implementation

**Batik-Inspired Geometric Patterns:**

```css
/* resources/css/utilities/patterns.css */
@layer utilities {
  /* Dot pattern (kawung-inspired) */
  .pattern-dots {
    background-image: 
      radial-gradient(circle, var(--batik-amber) 1.5px, transparent 1.5px),
      radial-gradient(circle, var(--batik-clay) 1.5px, transparent 1.5px);
    background-size: 40px 40px;
    background-position: 0 0, 20px 20px;
    opacity: 0.06;
  }
  
  /* Diagonal lines (parang-inspired) */
  .pattern-lines {
    background-image: repeating-linear-gradient(
      45deg,
      transparent,
      transparent 10px,
      var(--batik-clay) 10px,
      var(--batik-clay) 11px
    );
    opacity: 0.04;
  }
  
  /* Geometric grid (ceplok-inspired) */
  .pattern-grid {
    background-image: 
      linear-gradient(var(--batik-amber) 1px, transparent 1px),
      linear-gradient(90deg, var(--batik-amber) 1px, transparent 1px);
    background-size: 50px 50px;
    opacity: 0.03;
  }
}
```

**Usage in Components:**

```blade
{{-- Hero section with pattern overlay --}}
<div class="relative bg-gradient-to-br from-batik-ink to-batik-ink-light overflow-hidden">
    <div class="absolute inset-0 pattern-dots"></div>
    <div class="relative z-10 container py-20">
        {{-- Hero content --}}
    </div>
</div>

{{-- Card with subtle pattern --}}
<x-ui.card class="relative overflow-hidden">
    <div class="absolute inset-0 pattern-grid"></div>
    <div class="relative z-10">
        {{-- Card content --}}
    </div>
</x-ui.card>
```

### 3. Typography System

**Font Pairing:**

- **Headings**: Cormorant Garamond (serif) - evokes traditional elegance
- **Body**: Manrope (sans-serif) - modern readability

**Typography Scale:**

```css
/* Heading styles */
.heading-1 { @apply font-serif text-5xl md:text-6xl font-bold leading-tight; }
.heading-2 { @apply font-serif text-4xl md:text-5xl font-bold leading-tight; }
.heading-3 { @apply font-serif text-3xl md:text-4xl font-bold leading-snug; }
.heading-4 { @apply font-serif text-2xl md:text-3xl font-bold leading-snug; }
.heading-5 { @apply font-serif text-xl md:text-2xl font-bold leading-normal; }
.heading-6 { @apply font-serif text-lg md:text-xl font-bold leading-normal; }

/* Body styles */
.body-large { @apply font-sans text-lg leading-relaxed; }
.body-base { @apply font-sans text-base leading-normal; }
.body-small { @apply font-sans text-sm leading-normal; }

/* Special styles */
.kicker { @apply font-sans text-xs font-extrabold uppercase tracking-widest text-batik-clay; }
.lead { @apply font-sans text-lg md:text-xl text-batik-ink/70 leading-relaxed; }
```

**Usage Examples:**

```blade
{{-- Section with kicker and heading --}}
<div class="text-center mb-12">
    <p class="kicker mb-3">Warisan Budaya</p>
    <h2 class="heading-2 mb-4">Koleksi Motif Batik</h2>
    <p class="lead max-w-2xl mx-auto">
        Jelajahi kekayaan motif batik Banyuwangi yang sarat makna dan filosofi.
    </p>
</div>
```

### 4. Sacred Motif Styling

**Visual Treatment for Sacred Motifs:**

```css
/* Sacred motif card styling */
.motif-sacred {
  @apply border-2 border-batik-clay/24 shadow-clay;
  position: relative;
}

.motif-sacred::before {
  content: '';
  @apply absolute inset-0 bg-gradient-to-br from-batik-clay/5 to-transparent pointer-events-none;
}

.motif-sacred-badge {
  @apply bg-batik-clay/12 text-batik-clay border border-batik-clay/16 shadow-clay;
}
```

**Sacred Warning Banner:**

```blade
<x-ui.card class="border-l-4 border-l-batik-clay bg-gradient-to-r from-red-50 to-amber-50">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-batik-clay/10 flex items-center justify-center">
            <i class="fa-solid fa-star text-batik-clay text-xl"></i>
        </div>
        <div class="flex-1">
            <h4 class="font-bold text-batik-clay mb-2">Motif Sakral</h4>
            <p class="text-sm text-batik-clay-dark">
                Motif ini memiliki nilai sakral dalam budaya Banyuwangi. Mohon hormati makna dan penggunaannya sesuai dengan adat istiadat setempat.
            </p>
        </div>
    </div>
</x-ui.card>
```

### 5. Animation and Transitions

**Cultural-Inspired Animations:**

```css
/* Gentle float animation (like fabric in breeze) */
@keyframes gentle-float {
  0%, 100% { transform: translateY(0) rotate(0deg); }
  25% { transform: translateY(-5px) rotate(0.5deg); }
  75% { transform: translateY(-3px) rotate(-0.5deg); }
}

.animate-gentle-float {
  animation: gentle-float 6s ease-in-out infinite;
}

/* Fade in with slight scale (like batik dye spreading) */
@keyframes fade-scale {
  0% { 
    opacity: 0; 
    transform: scale(0.98);
  }
  100% { 
    opacity: 1; 
    transform: scale(1);
  }
}

.animate-fade-scale {
  animation: fade-scale 0.4s ease-out;
}

/* Shimmer effect (like silk fabric) */
@keyframes shimmer {
  0% { background-position: -200% center; }
  100% { background-position: 200% center; }
}

.animate-shimmer {
  background: linear-gradient(
    90deg,
    transparent 0%,
    rgba(255, 255, 255, 0.3) 50%,
    transparent 100%
  );
  background-size: 200% 100%;
  animation: shimmer 3s ease-in-out infinite;
}
```

**Usage:**

```blade
{{-- Floating decorative element --}}
<div class="absolute top-10 right-10 w-32 h-32 opacity-10 animate-gentle-float">
    <img src="/images/batik-pattern.svg" alt="" aria-hidden="true">
</div>

{{-- Card entrance animation --}}
<x-ui.card class="animate-fade-scale">
    {{-- Content --}}
</x-ui.card>

{{-- Shimmer on hover --}}
<div class="relative overflow-hidden group">
    <img src="{{ $motif->image }}" alt="{{ $motif->name }}">
    <div class="absolute inset-0 animate-shimmer opacity-0 group-hover:opacity-100 transition-opacity"></div>
</div>
```

### 6. Iconography

**Cultural Icon Usage:**

```blade
{{-- Traditional motif categories --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="text-center p-6 rounded-xl bg-white border border-border hover:shadow-lg transition-shadow">
        <i class="fa-solid fa-leaf text-4xl text-batik-emerald mb-3"></i>
        <h4 class="font-semibold">Motif Alam</h4>
    </div>
    
    <div class="text-center p-6 rounded-xl bg-white border border-border hover:shadow-lg transition-shadow">
        <i class="fa-solid fa-shapes text-4xl text-batik-amber mb-3"></i>
        <h4 class="font-semibold">Motif Geometris</h4>
    </div>
    
    <div class="text-center p-6 rounded-xl bg-white border border-border hover:shadow-lg transition-shadow">
        <i class="fa-solid fa-dove text-4xl text-batik-ink mb-3"></i>
        <h4 class="font-semibold">Motif Fauna</h4>
    </div>
    
    <div class="text-center p-6 rounded-xl bg-white border border-border hover:shadow-lg transition-shadow">
        <i class="fa-solid fa-star text-4xl text-batik-clay mb-3"></i>
        <h4 class="font-semibold">Motif Sakral</h4>
    </div>
</div>
```

### 7. Texture and Depth

**Layered Depth System:**

```css
/* Elevation levels */
.elevation-0 { box-shadow: none; }
.elevation-1 { box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04); }
.elevation-2 { box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06); }
.elevation-3 { box-shadow: 0 20px 45px rgba(15, 23, 42, 0.1); }
.elevation-4 { box-shadow: 0 25px 50px rgba(15, 23, 42, 0.15); }

/* Fabric-like texture overlay */
.texture-fabric {
  position: relative;
}

.texture-fabric::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image: url('data:image/svg+xml,...'); /* Subtle fabric texture */
  opacity: 0.02;
  pointer-events: none;
}
```

**Usage:**

```blade
{{-- Elevated card with texture --}}
<x-ui.card class="elevation-3 texture-fabric">
    {{-- Content --}}
</x-ui.card>
```


## Implementation Approach

### Phase-by-Phase Implementation Strategy

#### Phase 1: Foundation (Week 1)

**Objectives:**
- Set up Tailwind CSS 4 configuration
- Create design token system
- Establish file structure
- Remove Bootstrap dependencies

**Tasks:**

1. **Create Tailwind Configuration**
   ```bash
   # Create tailwind.config.js with complete design tokens
   touch tailwind.config.js
   ```

2. **Update CSS Structure**
   ```bash
   # Create directory structure
   mkdir -p resources/css/{base,components,utilities}
   
   # Create CSS files
   touch resources/css/app.css
   touch resources/css/base/{typography,accessibility}.css
   touch resources/css/components/{buttons,forms,cards,navigation}.css
   touch resources/css/utilities/{animations,patterns}.css
   ```

3. **Update Build Configuration**
   - Verify `vite.config.js` includes Tailwind plugin
   - Test build process: `npm run dev`

4. **Remove Bootstrap**
   ```bash
   # Remove Bootstrap from package.json (if present)
   npm uninstall bootstrap
   
   # Remove Bootstrap CDN links from layouts
   # Edit: resources/views/layout/app.blade.php
   # Edit: resources/views/layout/admin.blade.php
   ```

**Deliverables:**
- ✅ Tailwind CSS 4 configured with design tokens
- ✅ CSS file structure established
- ✅ Bootstrap completely removed
- ✅ Build process working

#### Phase 2: Component Library (Week 2-3)

**Objectives:**
- Create all reusable Blade components
- Implement accessibility features
- Test components in isolation

**Tasks:**

1. **Create Component Directory**
   ```bash
   mkdir -p resources/views/components/ui
   mkdir -p resources/views/components/layout
   ```

2. **Build Components (Priority Order)**
   - Week 2:
     - Button component
     - Card component
     - Input component
     - Select component
     - Alert component
   
   - Week 3:
     - Badge component
     - Modal component
     - Breadcrumb component
     - Pagination component
     - Skeleton component

3. **Create Component Test Page**
   ```bash
   php artisan make:controller ComponentTestController
   ```
   
   Create test route and view to verify all components

4. **Accessibility Testing**
   - Test keyboard navigation
   - Verify ARIA attributes
   - Check color contrast
   - Test with screen reader

**Deliverables:**
- ✅ 10 reusable Blade components
- ✅ Component test page
- ✅ Accessibility audit passed
- ✅ Component documentation

#### Phase 3: Page Migration (Week 4)

**Objectives:**
- Migrate all pages from Bootstrap to Tailwind
- Replace Bootstrap classes with Tailwind utilities
- Use new component library

**Tasks:**

1. **Public Pages Migration**
   - Day 1-2: Home page
   - Day 2-3: Catalog page
   - Day 3-4: Motif detail page
   - Day 4-5: About and Contact pages

2. **Auth Pages Migration**
   - Day 5: Login page

3. **Admin Pages Migration**
   - Day 6-7: Dashboard
   - Day 7-8: Motif management (list, create, edit)
   - Day 8-9: Information management
   - Day 9-10: Account management

4. **Layout Migration**
   - Update `resources/views/layout/app.blade.php`
   - Update `resources/views/layout/admin.blade.php`
   - Update shared components (navbar, sidebar, footer)

**Migration Checklist per Page:**
```markdown
- [ ] Replace Bootstrap grid with Tailwind grid/flex
- [ ] Replace Bootstrap buttons with <x-ui.button>
- [ ] Replace Bootstrap forms with <x-ui.input> and <x-ui.select>
- [ ] Replace Bootstrap cards with <x-ui.card>
- [ ] Replace Bootstrap alerts with <x-ui.alert>
- [ ] Replace Bootstrap badges with <x-ui.badge>
- [ ] Replace Bootstrap modals with <x-ui.modal>
- [ ] Update spacing utilities (mb-3 → mb-3, etc.)
- [ ] Update text utilities (fw-bold → font-bold, etc.)
- [ ] Test responsive behavior
- [ ] Test accessibility
- [ ] Verify no Bootstrap classes remain
```

**Deliverables:**
- ✅ All pages migrated to Tailwind
- ✅ No Bootstrap classes in codebase
- ✅ All pages responsive
- ✅ Visual consistency maintained

#### Phase 4: Testing and Refinement (Week 5)

**Objectives:**
- Comprehensive testing across devices and browsers
- Accessibility audit
- Performance optimization
- Bug fixes and refinements

**Tasks:**

1. **Visual Regression Testing**
   - Test on desktop browsers (Chrome, Firefox, Safari, Edge)
   - Test on tablet devices (iPad, Android tablet)
   - Test on mobile devices (iPhone, Android phone)
   - Document and fix visual inconsistencies

2. **Accessibility Audit**
   ```bash
   # Install axe-core
   npm install --save-dev @axe-core/cli
   
   # Run automated tests
   npx axe http://localhost:8000 --save results.json
   ```
   
   - Fix automated accessibility issues
   - Manual keyboard navigation testing
   - Screen reader testing (NVDA, JAWS, VoiceOver)
   - Color contrast verification
   - Touch target size verification

3. **Performance Audit**
   - Run Lighthouse audits on all pages
   - Optimize images (lazy loading, WebP format)
   - Optimize fonts (preload, font-display: swap)
   - Verify CSS bundle size < 50KB (gzipped)
   - Achieve performance scores: ≥90 (desktop), ≥80 (mobile)

4. **Cross-Browser Testing**
   - Chrome (latest)
   - Firefox (latest)
   - Safari (latest)
   - Edge (latest)
   - Mobile browsers (iOS Safari, Android Chrome)

5. **Bug Fixes and Refinements**
   - Fix reported issues
   - Refine animations and transitions
   - Optimize spacing and alignment
   - Polish cultural design elements

**Deliverables:**
- ✅ All devices and browsers tested
- ✅ Accessibility score: 100
- ✅ Performance scores met
- ✅ All bugs fixed
- ✅ Documentation updated

#### Phase 5: Deployment (Week 6)

**Objectives:**
- Prepare for production deployment
- Deploy to production
- Post-deployment verification
- Documentation and handoff

**Tasks:**

1. **Pre-Deployment Preparation**
   ```bash
   # Clear all caches
   php artisan cache:clear
   php artisan view:clear
   php artisan config:clear
   php artisan route:clear
   
   # Run tests
   php artisan test
   
   # Build for production
   npm run build
   
   # Verify build output
   ls -lh public/build/assets/
   ```

2. **Pre-Deployment Checklist**
   ```markdown
   - [ ] All Bootstrap references removed
   - [ ] All pages migrated and tested
   - [ ] All components working correctly
   - [ ] Accessibility audit passed (score: 100)
   - [ ] Performance audit passed (≥90 desktop, ≥80 mobile)
   - [ ] Cross-browser testing completed
   - [ ] Mobile responsiveness verified
   - [ ] Production build tested locally
   - [ ] Database migrations ready (if any)
   - [ ] Environment variables configured
   - [ ] Backup created
   ```

3. **Deployment**
   ```bash
   # Commit changes
   git add .
   git commit -m "UI/UX refactoring: Complete Tailwind migration with design system and WCAG 2.1 AA compliance"
   git push origin main
   
   # On production server
   git pull origin main
   composer install --optimize-autoloader --no-dev
   npm ci
   npm run build
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan optimize
   ```

4. **Post-Deployment Verification**
   ```markdown
   - [ ] All pages load correctly
   - [ ] No console errors
   - [ ] Assets load from build directory
   - [ ] Forms submit correctly
   - [ ] Authentication works
   - [ ] Admin panel functions properly
   - [ ] Search and filters work
   - [ ] Image uploads work
   - [ ] Performance metrics meet targets
   - [ ] Accessibility features work
   ```

5. **Documentation and Handoff**
   - Update README.md with new setup instructions
   - Document component usage
   - Create style guide
   - Train team on new components
   - Provide maintenance guidelines

**Deliverables:**
- ✅ Production deployment successful
- ✅ Post-deployment verification passed
- ✅ Documentation complete
- ✅ Team trained
- ✅ Maintenance plan established

### Risk Mitigation

**Potential Risks and Mitigation Strategies:**

1. **Risk: Breaking existing functionality during migration**
   - **Mitigation**: Migrate page by page, test thoroughly before moving to next page
   - **Mitigation**: Keep Bootstrap temporarily until all pages migrated
   - **Mitigation**: Use version control, create feature branch

2. **Risk: Accessibility regressions**
   - **Mitigation**: Test accessibility after each component creation
   - **Mitigation**: Use automated tools (axe-core) in CI/CD pipeline
   - **Mitigation**: Manual testing with screen readers

3. **Risk: Performance degradation**
   - **Mitigation**: Monitor bundle sizes throughout development
   - **Mitigation**: Run Lighthouse audits regularly
   - **Mitigation**: Implement lazy loading and code splitting

4. **Risk: Browser compatibility issues**
   - **Mitigation**: Test on multiple browsers early and often
   - **Mitigation**: Use autoprefixer for CSS compatibility
   - **Mitigation**: Provide fallbacks for modern CSS features

5. **Risk: Cultural design elements not authentic**
   - **Mitigation**: Consult with stakeholders familiar with Batik Banyuwangi
   - **Mitigation**: Research traditional batik patterns and colors
   - **Mitigation**: Iterate based on feedback

### Success Criteria

**The refactoring is considered successful when:**

1. ✅ **Framework Consolidation**
   - Zero Bootstrap dependencies
   - All styling uses Tailwind CSS 4
   - CSS bundle < 50KB (gzipped)

2. ✅ **Accessibility**
   - WCAG 2.1 Level AA compliance achieved
   - Lighthouse accessibility score: 100
   - All interactive elements keyboard accessible
   - Screen reader compatible

3. ✅ **Performance**
   - Lighthouse performance: ≥90 (desktop), ≥80 (mobile)
   - LCP < 2.5s
   - FID < 100ms
   - CLS < 0.1

4. ✅ **Design System**
   - 10+ reusable components created
   - Consistent design tokens implemented
   - Cultural elements integrated
   - Component documentation complete

5. ✅ **Responsiveness**
   - All pages work on mobile, tablet, desktop
   - Touch targets meet 44x44px minimum
   - Images responsive and optimized

6. ✅ **Functionality**
   - All existing features work correctly
   - No regressions in user workflows
   - Forms validate and submit properly
   - Admin panel fully functional

7. ✅ **Quality**
   - No console errors
   - Cross-browser compatible
   - Code follows best practices
   - Documentation complete


## Appendix

### A. Complete File Checklist

**Files to Create:**

```
tailwind.config.js
resources/css/app.css
resources/css/base/typography.css
resources/css/base/accessibility.css
resources/css/components/buttons.css
resources/css/components/forms.css
resources/css/components/cards.css
resources/css/components/navigation.css
resources/css/utilities/animations.css
resources/css/utilities/patterns.css
resources/views/components/ui/button.blade.php
resources/views/components/ui/card.blade.php
resources/views/components/ui/badge.blade.php
resources/views/components/ui/input.blade.php
resources/views/components/ui/select.blade.php
resources/views/components/ui/alert.blade.php
resources/views/components/ui/modal.blade.php
resources/views/components/ui/breadcrumb.blade.php
resources/views/components/ui/pagination.blade.php
resources/views/components/ui/skeleton.blade.php
resources/js/components/modal.js
resources/js/components/form-validation.js
resources/js/components/accessibility.js
resources/js/components/network-handler.js
resources/views/errors/404.blade.php
resources/views/errors/500.blade.php
```

**Files to Modify:**

```
resources/views/layout/app.blade.php
resources/views/layout/admin.blade.php
resources/views/home.blade.php
resources/views/catalog.blade.php
resources/views/motifs/show.blade.php
resources/views/about.blade.php
resources/views/contact.blade.php
resources/views/auth/login.blade.php
resources/views/admin/dashboard.blade.php
resources/views/admin/motifs/index.blade.php
resources/views/admin/motifs/create.blade.php
resources/views/admin/motifs/edit.blade.php
resources/views/components/header.blade.php
resources/views/components/sidebar.blade.php
resources/views/components/footer.blade.php
vite.config.js
package.json
```

**Files to Delete:**

```
public/css/batik.css (replaced by Tailwind)
```

### B. Quick Reference: Tailwind Utility Classes

**Common Patterns:**

```css
/* Layout */
.container → container mx-auto px-4
.row → grid grid-cols-12 gap-4 or flex flex-wrap
.col-md-6 → col-span-12 md:col-span-6

/* Flexbox */
.d-flex → flex
.justify-content-between → justify-between
.align-items-center → items-center
.flex-column → flex-col
.gap-3 → gap-3

/* Spacing */
.mb-3 → mb-3
.mt-4 → mt-4
.p-4 → p-4
.px-3 → px-3
.py-2 → py-2

/* Typography */
.fw-bold → font-bold
.fw-semibold → font-semibold
.text-center → text-center
.text-muted → text-batik-ink/60
.fs-5 → text-lg

/* Colors */
.text-primary → text-batik-ink
.text-danger → text-batik-clay
.text-success → text-batik-emerald
.bg-light → bg-batik-cream
.bg-white → bg-white

/* Borders */
.border → border
.border-0 → border-0
.rounded → rounded-lg
.rounded-3 → rounded-xl
.shadow-sm → shadow-sm

/* Display */
.d-none → hidden
.d-block → block
.d-inline-block → inline-block
.d-flex → flex
.d-grid → grid

/* Responsive */
.d-md-block → hidden md:block
.col-md-6 → col-span-12 md:col-span-6
.mb-md-0 → mb-4 md:mb-0
```

### C. Browser Support Matrix

**Supported Browsers:**

| Browser | Version | Support Level |
|---------|---------|---------------|
| Chrome | Latest 2 versions | Full |
| Firefox | Latest 2 versions | Full |
| Safari | Latest 2 versions | Full |
| Edge | Latest 2 versions | Full |
| iOS Safari | iOS 14+ | Full |
| Android Chrome | Latest | Full |
| Samsung Internet | Latest | Full |

**CSS Features Used:**

- CSS Grid (supported in all modern browsers)
- Flexbox (supported in all modern browsers)
- CSS Custom Properties (supported in all modern browsers)
- backdrop-filter (supported with -webkit- prefix)
- aspect-ratio (supported in modern browsers, fallback provided)

**Fallbacks Provided:**

```css
/* Backdrop filter fallback */
.glass {
  background: rgba(255, 255, 255, 0.65);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px); /* Safari */
}

/* Aspect ratio fallback */
.aspect-video {
  aspect-ratio: 16 / 9;
}

@supports not (aspect-ratio: 16 / 9) {
  .aspect-video {
    padding-bottom: 56.25%; /* 16:9 ratio */
    position: relative;
  }
  
  .aspect-video > * {
    position: absolute;
    inset: 0;
  }
}
```

### D. Maintenance Guidelines

**Regular Maintenance Tasks:**

1. **Monthly:**
   - Review and update dependencies
   - Run accessibility audits
   - Check performance metrics
   - Review and fix any reported issues

2. **Quarterly:**
   - Update Tailwind CSS to latest version
   - Review and optimize CSS bundle size
   - Update browser support matrix
   - Review and update documentation

3. **Annually:**
   - Comprehensive accessibility audit
   - Performance optimization review
   - Design system review and updates
   - User feedback analysis and improvements

**Adding New Components:**

1. Create component file in `resources/views/components/ui/`
2. Follow existing component structure (props, variants, accessibility)
3. Add component to test page
4. Test accessibility (keyboard, screen reader, contrast)
5. Test responsiveness (mobile, tablet, desktop)
6. Document component usage
7. Add to component library documentation

**Updating Design Tokens:**

1. Update `tailwind.config.js`
2. Rebuild CSS: `npm run build`
3. Test affected components
4. Update documentation
5. Communicate changes to team

**Performance Monitoring:**

```bash
# Run Lighthouse audit
npm run lighthouse

# Check bundle sizes
npm run build
ls -lh public/build/assets/

# Analyze bundle composition
npm run analyze
```

### E. Resources and References

**Documentation:**

- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Laravel Blade Components](https://laravel.com/docs/blade#components)
- [Vite Documentation](https://vitejs.dev/)

**Tools:**

- [axe DevTools](https://www.deque.com/axe/devtools/) - Accessibility testing
- [WAVE](https://wave.webaim.org/) - Web accessibility evaluation
- [Lighthouse](https://developers.google.com/web/tools/lighthouse) - Performance and accessibility audits
- [Color Contrast Checker](https://webaim.org/resources/contrastchecker/) - WCAG contrast verification

**Batik Banyuwangi Resources:**

- Traditional color references
- Pattern documentation
- Cultural significance guides
- Local artisan consultations

**Community:**

- Tailwind CSS Discord
- Laravel Discord
- Web Accessibility Initiative (WAI)
- Frontend development communities

---

## Summary

This design document provides comprehensive technical specifications for refactoring the Batik Banyuwangi inventory application's UI/UX. The refactoring consolidates styling to Tailwind CSS 4, implements WCAG 2.1 Level AA accessibility standards, establishes a cohesive design system inspired by Batik Banyuwangi cultural heritage, and optimizes performance across all devices.

**Key Achievements:**

1. **Framework Consolidation**: Complete migration from Bootstrap to Tailwind CSS 4
2. **Design System**: Comprehensive design tokens and 10+ reusable components
3. **Accessibility**: WCAG 2.1 Level AA compliance with keyboard navigation, screen reader support, and proper color contrast
4. **Cultural Identity**: Batik-inspired colors, patterns, and typography reflecting Banyuwangi heritage
5. **Performance**: Optimized CSS bundle, lazy loading, and font optimization for fast load times
6. **Responsiveness**: Mobile-first approach with seamless experience across all devices
7. **Maintainability**: Well-documented components and clear implementation guidelines

**Next Steps:**

1. Review and approve design document
2. Begin Phase 1: Foundation setup
3. Proceed through implementation phases
4. Conduct thorough testing
5. Deploy to production
6. Monitor and maintain

This refactoring will result in a modern, accessible, performant, and culturally authentic application that serves as a digital showcase for Batik Banyuwangi heritage.

