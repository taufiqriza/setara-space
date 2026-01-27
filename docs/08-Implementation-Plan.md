# 08. Implementation Plan

## 🚀 Technical Implementation Guide

> Rencana implementasi sistem POS Setara Space menggunakan **Laravel 11 + Livewire 3** dengan pengalaman SPA-like yang smooth.

---

## 📋 Prerequisites

### System Requirements
- PHP 8.2+
- Composer 2.x
- Node.js 18+ & NPM
- MySQL 8.0
- Git

### Packages yang Diperlukan
```json
{
    "require": {
        "laravel/framework": "^11.0",
        "livewire/livewire": "^3.0",
        "spatie/laravel-permission": "^6.0",
        "intervention/image": "^3.0",
        "barryvdh/laravel-dompdf": "^2.0"
    },
    "require-dev": {
        "laravel/pint": "^1.0",
        "pestphp/pest": "^2.0"
    }
}
```

---

## 🏗 Step-by-Step Implementation

### Phase 1: Foundation Setup

#### Step 1.1: Install Dependencies
```bash
# Install PHP packages
composer require livewire/livewire:^3.0
composer require spatie/laravel-permission:^6.0
composer require intervention/image:^3.0

# Install frontend dependencies
npm install -D tailwindcss postcss autoprefixer @tailwindcss/forms
npx tailwindcss init -p
```

#### Step 1.2: Configure Livewire 3 untuk SPA
```php
// config/livewire.php
return [
    'navigate' => [
        'show_progress_bar' => true,
        'progress_bar_color' => '#3B4CCA',
    ],
];
```

#### Step 1.3: Database Migrations
```bash
# Generate migrations
php artisan make:migration create_categories_table
php artisan make:migration create_products_table
php artisan make:migration create_tables_management_table
php artisan make:migration create_orders_table
php artisan make:migration create_order_items_table
php artisan make:migration create_promos_table
php artisan make:migration create_settings_table
php artisan make:migration add_employment_type_to_users_table

# Run migrations
php artisan migrate
```

#### Step 1.4: Setup Spatie Permission
```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
php artisan make:seeder RolePermissionSeeder
```

---

### Phase 2: Models & Relationships

#### Step 2.1: Create Models
```bash
php artisan make:model Category -m
php artisan make:model Product -m
php artisan make:model Table -m
php artisan make:model Order -m
php artisan make:model OrderItem -m
php artisan make:model Promo -m
php artisan make:model Setting -m
```

#### Step 2.2: Model Relationships
```php
// app/Models/Order.php
class Order extends Model
{
    public function user() { return $this->belongsTo(User::class); }
    public function table() { return $this->belongsTo(Table::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
    
    // Auto-generate order number
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->order_number = '#' . str_pad(Order::count() + 1, 3, '0', STR_PAD_LEFT);
        });
    }
}
```

---

### Phase 3: Livewire Components

#### Step 3.1: Create Component Structure
```bash
# POS Components
php artisan make:livewire Pos/ProductGrid
php artisan make:livewire Pos/OrderPanel
php artisan make:livewire Pos/CategoryTabs
php artisan make:livewire Pos/ProductModal
php artisan make:livewire Pos/TrackOrder

# Activity Components
php artisan make:livewire Activity/BillingQueue
php artisan make:livewire Activity/OrderHistory

# Inventory Components
php artisan make:livewire Inventory/CategoryManager
php artisan make:livewire Inventory/ProductManager

# Teams Components
php artisan make:livewire Teams/StaffManager

# Settings Components
php artisan make:livewire Settings/StoreSettings
php artisan make:livewire Settings/TaxSettings
```

#### Step 3.2: POS Main Component
```php
// app/Livewire/Pos/ProductGrid.php
class ProductGrid extends Component
{
    public $search = '';
    public $selectedCategory = null;
    
    public function render()
    {
        return view('livewire.pos.product-grid', [
            'products' => Product::query()
                ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
                ->where('is_active', true)
                ->get(),
            'categories' => Category::withCount('products')->orderBy('sort_order')->get(),
        ]);
    }
    
    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId === 'all' ? null : $categoryId;
    }
    
    // Emit event ke OrderPanel
    public function addToCart($productId)
    {
        $this->dispatch('product-added', productId: $productId);
    }
}
```

#### Step 3.3: Order Panel Component
```php
// app/Livewire/Pos/OrderPanel.php
class OrderPanel extends Component
{
    public $customerName = '';
    public $tableId = null;
    public $orderType = 'dine_in';
    public $items = [];
    public $promoCode = '';
    public $paymentMethod = null;
    
    protected $listeners = ['product-added' => 'addProduct'];
    
    public function addProduct($productId)
    {
        $product = Product::find($productId);
        
        // Check if already in cart
        $key = array_search($productId, array_column($this->items, 'product_id'));
        
        if ($key !== false) {
            $this->items[$key]['quantity']++;
        } else {
            $this->items[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'notes' => '',
                'image' => $product->image,
            ];
        }
        
        $this->calculateTotals();
    }
    
    public function calculateTotals()
    {
        $this->subtotal = collect($this->items)->sum(fn($item) => $item['price'] * $item['quantity']);
        $this->taxRate = Setting::get('tax.rate', 10);
        $this->tax = $this->subtotal * ($this->taxRate / 100);
        $this->total = $this->subtotal + $this->tax - $this->discount;
    }
    
    public function placeOrder()
    {
        // Validation
        $this->validate([
            'items' => 'required|array|min:1',
            'paymentMethod' => 'required',
        ]);
        
        DB::transaction(function () {
            $order = Order::create([
                'customer_name' => $this->customerName,
                'table_id' => $this->tableId,
                'user_id' => auth()->id(),
                'order_type' => $this->orderType,
                'subtotal' => $this->subtotal,
                'tax_rate' => $this->taxRate,
                'tax_amount' => $this->tax,
                'discount_amount' => $this->discount,
                'total' => $this->total,
                'payment_method' => $this->paymentMethod,
                'payment_status' => 'paid',
                'status' => 'pending',
            ]);
            
            foreach ($this->items as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                    'notes' => $item['notes'],
                ]);
            }
            
            // Update table status if dine in
            if ($this->tableId) {
                Table::find($this->tableId)->update(['status' => 'occupied']);
            }
        });
        
        // Reset form
        $this->reset(['items', 'customerName', 'promoCode', 'paymentMethod']);
        
        // Show success
        $this->dispatch('order-placed');
    }
}
```

---

### Phase 4: Views & Layout

#### Step 4.1: Admin Layout dengan SPA Navigation
```blade
{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} - Setara Space POS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50">
    {{-- Loading Progress Bar --}}
    <div wire:loading.delay class="fixed top-0 left-0 right-0 h-1 bg-space-500 animate-pulse z-[100]"></div>
    
    {{-- Sidebar (persisted) --}}
    <div wire:persist="admin-sidebar">
        @livewire('admin.sidebar')
    </div>
    
    {{-- Main Content --}}
    <main class="lg:pl-64">
        {{ $slot }}
    </main>
    
    @livewireScripts
</body>
</html>
```

#### Step 4.2: SPA Links
```blade
{{-- Sidebar navigation dengan wire:navigate --}}
<nav>
    <a href="{{ route('admin.pos') }}" wire:navigate 
       class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 rounded-lg">
        <i class="fas fa-cash-register"></i>
        <span>Point of Sales</span>
    </a>
    
    <a href="{{ route('admin.activity') }}" wire:navigate
       class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 rounded-lg">
        <i class="fas fa-list-alt"></i>
        <span>Activity</span>
    </a>
    
    {{-- ... more links --}}
</nav>
```

---

### Phase 5: Routes

```php
// routes/web.php
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', DashboardController::class)->name('dashboard');
    
    // POS
    Route::get('/pos', function() {
        return view('admin.pos');
    })->name('pos');
    
    // Activity
    Route::get('/activity', function() {
        return view('admin.activity');
    })->name('activity');
    
    // Reports (requires permission)
    Route::middleware(['permission:report.view'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    });
    
    // Inventory (requires permission)
    Route::middleware(['permission:inventory.view'])->group(function () {
        Route::get('/inventory/categories', function() {
            return view('admin.inventory.categories');
        })->name('inventory.categories');
        
        Route::get('/inventory/products', function() {
            return view('admin.inventory.products');
        })->name('inventory.products');
    });
    
    // Teams (superadmin only)
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('/teams', function() {
            return view('admin.teams');
        })->name('teams');
    });
    
    // Settings
    Route::get('/settings', function() {
        return view('admin.settings');
    })->name('settings');
});
```

---

## ✅ Verification Plan

### Automated Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=OrderTest
```

### Test Cases untuk MVP
```php
// tests/Feature/PosTest.php
test('can add product to cart', function () {
    // ...
});

test('can calculate order totals correctly', function () {
    // ...
});

test('can place order successfully', function () {
    // ...
});

test('order number auto-increments', function () {
    // ...
});
```

### Manual Testing Checklist
1. [ ] Login sebagai Superadmin → akses semua menu
2. [ ] Login sebagai Staff Part Time → hanya bisa akses POS
3. [ ] Tambah produk ke cart → hitung subtotal benar
4. [ ] Apply tax 10% → total benar
5. [ ] Place order → order tersimpan di database
6. [ ] Cek Activity → order muncul di list
7. [ ] Update status order → status berubah
8. [ ] Navigasi antar halaman → smooth tanpa reload

---

## 🔧 Development Commands

```bash
# Start development
php artisan serve &
npm run dev

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan livewire:clear

# Generate IDE helpers
php artisan ide-helper:generate
php artisan ide-helper:models

# Run tests
php artisan test
```

---

## 📝 Notes

1. **SPA Navigation**: Semua link internal menggunakan `wire:navigate` untuk pengalaman smooth
2. **Persistence**: Sidebar dan header menggunakan `wire:persist` agar tidak re-render
3. **Loading States**: Semua komponen memiliki loading indicator
4. **Realtime Updates**: Menggunakan Livewire polling atau events untuk update real-time
