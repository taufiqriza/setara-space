# 06. UI Components & Design System

## 🎨 Design Overview

Berdasarkan referensi UI yang diberikan, sistem POS Setara Space menggunakan desain modern dengan:
- **Clean & Minimal** - Fokus pada fungsionalitas
- **Soft Colors** - Warna lembut dengan aksen biru
- **Card-based Layout** - Komponen terorganisir dalam cards
- **Touch-friendly** - Optimized untuk tablet/mobile

---

## 🎨 Color Palette

### Primary Colors
```css
/* Space Blue - Brand Primary */
--space-50: #eef1ff;
--space-100: #e0e5ff;
--space-200: #c7ceff;
--space-500: #6b5cfa;
--space-600: #5b3def;
--space-700: #4d30db;
--space-800: #3B4CCA;  /* Primary */
--space-900: #2d2a8c;
--space-950: #1A1A2E;
```

### Accent Colors
```css
/* Golden - Highlight */
--golden-400: #FBBF24;
--golden-500: #F9A825;

/* Status Colors */
--success: #22C55E;  /* Green */
--warning: #F59E0B;  /* Amber */
--error: #EF4444;    /* Red */
--info: #3B82F6;     /* Blue */
```

### Neutral Colors
```css
/* Background & Cards */
--bg-primary: #F8FAFC;    /* Page background */
--bg-card: #FFFFFF;        /* Card background */
--bg-hover: #F1F5F9;       /* Hover state */

/* Text */
--text-primary: #1E293B;
--text-secondary: #64748B;
--text-muted: #94A3B8;
```

---

## 📐 Layout Structure

### Main POS Layout
```
┌─────────────────────────────────────────────────────────────────┐
│  HEADER BAR (fixed)                                              │
│  [≡] [📅 Date] [-] [⏰ Time] [● Status] [↻]                      │
├────────────────────────────────────────┬────────────────────────┤
│                                        │                        │
│          PRODUCT GRID                  │      ORDER PANEL       │
│          (scrollable)                  │      (fixed right)     │
│                                        │                        │
│    [Category Tabs]                     │   Customer Name        │
│    [Search Bar]                        │   Order Details        │
│    [Product Cards Grid]                │   Item List            │
│                                        │   Totals               │
│                                        │   Payment              │
│                                        │   [Place Order]        │
├────────────────────────────────────────┴────────────────────────┤
│  TRACK ORDER BAR (fixed bottom)                                  │
│  [Order Card] [Order Card] [Order Card] →                       │
└─────────────────────────────────────────────────────────────────┘
```

### Responsive Breakpoints
```css
/* Mobile First */
@media (min-width: 640px)  { /* sm - Small tablets */ }
@media (min-width: 768px)  { /* md - Tablets */ }
@media (min-width: 1024px) { /* lg - Landscape tablets/Desktop */ }
@media (min-width: 1280px) { /* xl - Large screens */ }
```

---

## 🧩 Component Library

### 1. Header Bar
```html
<header class="fixed top-0 left-0 right-0 h-14 bg-white border-b border-gray-200 z-50">
    <div class="flex items-center justify-between h-full px-4">
        <!-- Menu Toggle -->
        <button class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-gray-100">
            <i class="fas fa-bars text-gray-600"></i>
        </button>
        
        <!-- Date & Time -->
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <i class="far fa-calendar"></i>
                <span>Wed, 29 May 2024</span>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <i class="far fa-clock"></i>
                <span>07:59 AM</span>
            </div>
        </div>
        
        <!-- Order Status -->
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-green-500"></span>
            <span class="text-sm font-medium text-green-600">Open Order</span>
        </div>
    </div>
</header>
```

### 2. Category Tabs
```html
<div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
    <!-- Active Tab -->
    <button class="flex flex-col items-center gap-1 min-w-[80px] p-3 bg-space-800 text-white rounded-xl">
        <i class="fas fa-th-large text-lg"></i>
        <span class="text-xs font-medium">All Menu</span>
        <span class="text-[10px] opacity-70">110 Items</span>
    </button>
    
    <!-- Inactive Tab -->
    <button class="flex flex-col items-center gap-1 min-w-[80px] p-3 bg-gray-50 text-gray-600 rounded-xl hover:bg-gray-100">
        <i class="fas fa-bowl-food text-lg"></i>
        <span class="text-xs font-medium">Dimsum</span>
        <span class="text-[10px] opacity-70">20 Items</span>
    </button>
</div>
```

### 3. Product Card
```html
<div class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer group">
    <!-- Image -->
    <div class="aspect-square bg-gray-50 rounded-xl mb-3 overflow-hidden">
        <img src="/storage/products/dimsum.jpg" alt="Dimsum" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
    </div>
    
    <!-- Info -->
    <h3 class="font-medium text-gray-900 text-sm mb-1 truncate">Dimsum Ayam Original</h3>
    <div class="flex items-center justify-between">
        <span class="text-xs text-space-600 bg-space-50 px-2 py-0.5 rounded-full">Dimsum</span>
        <span class="font-semibold text-gray-900">Rp15K</span>
    </div>
</div>
```

### 4. Order Item Row
```html
<div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
    <!-- Thumbnail -->
    <div class="w-16 h-16 bg-white rounded-lg overflow-hidden flex-shrink-0">
        <img src="/storage/products/dimsum.jpg" alt="" class="w-full h-full object-cover">
    </div>
    
    <!-- Info -->
    <div class="flex-1 min-w-0">
        <h4 class="font-medium text-gray-900 text-sm truncate">Dimsum Ayam Original</h4>
        <p class="text-sm text-gray-500">Rp 15.000</p>
        <button class="text-xs text-space-600 hover:text-space-800">
            <i class="fas fa-pen text-[10px] mr-1"></i> Add note
        </button>
    </div>
    
    <!-- Quantity -->
    <div class="flex items-center gap-2">
        <button class="w-7 h-7 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-minus text-xs"></i>
        </button>
        <span class="w-6 text-center font-medium">2</span>
        <button class="w-7 h-7 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-100">
            <i class="fas fa-plus text-xs"></i>
        </button>
    </div>
</div>
```

### 5. Primary Button
```html
<!-- Large Primary Button -->
<button class="w-full py-4 bg-space-800 text-white font-semibold rounded-xl hover:bg-space-700 active:bg-space-900 transition-colors">
    Place Order
</button>

<!-- Payment Method Button (Selected) -->
<button class="px-4 py-2 bg-teal-500 text-white font-medium rounded-lg">
    QRIS
</button>

<!-- Payment Method Button (Unselected) -->
<button class="px-4 py-2 bg-gray-100 text-gray-600 font-medium rounded-lg hover:bg-gray-200">
    Cash
</button>
```

### 6. Status Badge
```html
<!-- Active -->
<span class="px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 rounded-full">Active</span>

<!-- Closed -->
<span class="px-2 py-0.5 text-xs font-medium bg-red-100 text-red-700 rounded-full">Closed</span>

<!-- Processing -->
<span class="px-2 py-0.5 text-xs font-medium bg-amber-100 text-amber-700 rounded-full">On Kitchen</span>
```

### 7. Track Order Card
```html
<div class="min-w-[200px] bg-white rounded-xl p-4 shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-2">
        <span class="font-semibold text-gray-900">Mike</span>
        <span class="text-xs text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">On Kitchen</span>
    </div>
    <div class="text-xs text-gray-500 mb-2">
        Table: 04 • Dine In
    </div>
    <div class="text-xs text-gray-400">10:00 AM</div>
</div>
```

---

## ⚡ SPA-like Navigation dengan Livewire 3

### Wire:Navigate untuk Smooth Transitions
```html
<!-- Link dengan transisi smooth -->
<a href="/admin/pos" wire:navigate class="nav-link">
    Point of Sales
</a>

<!-- Prefetch on hover untuk loading lebih cepat -->
<a href="/admin/activity" wire:navigate.hover class="nav-link">
    Activity
</a>
```

### Layout dengan Persist
```html
<!-- Elemen yang tetap persist saat navigasi -->
<div wire:persist="sidebar">
    @livewire('sidebar-navigation')
</div>

<main>
    {{ $slot }}
</main>
```

### Loading State
```html
<!-- Global loading indicator -->
<div wire:loading.delay class="fixed top-0 left-0 right-0 h-1 bg-space-500 animate-pulse z-50"></div>

<!-- Skeleton loading untuk cards -->
<div wire:loading class="animate-pulse">
    <div class="bg-gray-200 rounded-xl aspect-square mb-3"></div>
    <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
</div>
```

---

## 📱 Touch Optimization

### Touch Target Sizes
```css
/* Minimum touch target: 44x44px */
.touch-target {
    min-width: 44px;
    min-height: 44px;
}
```

### Gesture Support
```html
<!-- Swipe to delete on mobile -->
<div x-data="{ swipe: 0 }" 
     x-on:touchstart="..."
     x-on:touchmove="..."
     class="relative overflow-hidden">
    <!-- Content -->
</div>
```

### Pull to Refresh (Alpine.js)
```html
<div x-data="{ pulling: false, threshold: 80 }"
     @touchstart="..."
     @touchmove="...">
    <div x-show="pulling" class="text-center py-4">
        <i class="fas fa-spinner fa-spin"></i>
    </div>
</div>
```
