<?php

namespace App\Livewire\Control\Pos;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Support\Facades\DB;

class PosPage extends Component
{
    // Product Grid
    public string $search = '';
    public ?int $selectedCategory = null;
    
    // Order Panel
    public string $customerName = '';
    public ?int $tableId = null;
    public string $orderType = 'dine_in';
    public array $cartItems = [];
    public string $promoCode = '';
    public ?string $paymentMethod = null;
    
    // Calculated values
    public float $subtotal = 0;
    public float $taxRate = 10;
    public float $taxAmount = 0;
    public float $discountAmount = 0;
    public float $total = 0;
    
    // UI State
    public bool $showProductModal = false;
    public ?array $selectedProduct = null;
    public int $modalQuantity = 1;
    public string $modalNotes = '';
    
    // Order tracking
    public string $orderStatus = 'open'; // open/closed

    protected $listeners = ['refreshPos' => '$refresh'];

    public function mount()
    {
        $this->taxRate = 10; // Default 10%
    }

    public function render()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => fn($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();
            
        $products = Product::query()
            ->where('is_active', true)
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
            ->with('category')
            ->orderBy('name')
            ->get();
            
        $tables = Table::where('is_active', true)->get();
        
        $recentOrders = Order::with(['user', 'table'])
            ->whereIn('status', ['pending', 'on_kitchen', 'all_done', 'to_be_served'])
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.control.pos.pos-page', [
            'categories' => $categories,
            'products' => $products,
            'tables' => $tables,
            'recentOrders' => $recentOrders,
        ])->layout('layouts.control', ['title' => 'Point of Sales']);
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId === 'all' ? null : (int) $categoryId;
    }

    public function openProductModal($productId)
    {
        $product = Product::with('category')->find($productId);
        if ($product) {
            $this->selectedProduct = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'image' => $product->image,
                'category' => $product->category->name ?? '',
            ];
            $this->modalQuantity = 1;
            $this->modalNotes = '';
            $this->showProductModal = true;
        }
    }

    public function closeProductModal()
    {
        $this->showProductModal = false;
        $this->selectedProduct = null;
    }

    public function incrementModalQty()
    {
        $this->modalQuantity++;
    }

    public function decrementModalQty()
    {
        if ($this->modalQuantity > 1) {
            $this->modalQuantity--;
        }
    }

    public function addToCart()
    {
        if (!$this->selectedProduct) return;
        
        $productId = $this->selectedProduct['id'];
        $existingIndex = null;
        
        // Check if product already in cart
        foreach ($this->cartItems as $index => $item) {
            if ($item['product_id'] === $productId && $item['notes'] === $this->modalNotes) {
                $existingIndex = $index;
                break;
            }
        }
        
        if ($existingIndex !== null) {
            // Update quantity
            $this->cartItems[$existingIndex]['quantity'] += $this->modalQuantity;
            $this->cartItems[$existingIndex]['subtotal'] = 
                $this->cartItems[$existingIndex]['quantity'] * $this->cartItems[$existingIndex]['price'];
        } else {
            // Add new item
            $this->cartItems[] = [
                'product_id' => $productId,
                'name' => $this->selectedProduct['name'],
                'price' => $this->selectedProduct['price'],
                'quantity' => $this->modalQuantity,
                'subtotal' => $this->selectedProduct['price'] * $this->modalQuantity,
                'notes' => $this->modalNotes,
                'image' => $this->selectedProduct['image'],
            ];
        }
        
        $this->calculateTotals();
        $this->closeProductModal();
    }

    public function quickAddToCart($productId)
    {
        $product = Product::find($productId);
        if (!$product) return;
        
        $existingIndex = null;
        foreach ($this->cartItems as $index => $item) {
            if ($item['product_id'] === $productId && empty($item['notes'])) {
                $existingIndex = $index;
                break;
            }
        }
        
        if ($existingIndex !== null) {
            $this->cartItems[$existingIndex]['quantity']++;
            $this->cartItems[$existingIndex]['subtotal'] = 
                $this->cartItems[$existingIndex]['quantity'] * $this->cartItems[$existingIndex]['price'];
        } else {
            $this->cartItems[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price,
                'notes' => '',
                'image' => $product->image,
            ];
        }
        
        $this->calculateTotals();
    }

    public function incrementCartItem($index)
    {
        if (isset($this->cartItems[$index])) {
            $this->cartItems[$index]['quantity']++;
            $this->cartItems[$index]['subtotal'] = 
                $this->cartItems[$index]['quantity'] * $this->cartItems[$index]['price'];
            $this->calculateTotals();
        }
    }

    public function decrementCartItem($index)
    {
        if (isset($this->cartItems[$index])) {
            if ($this->cartItems[$index]['quantity'] > 1) {
                $this->cartItems[$index]['quantity']--;
                $this->cartItems[$index]['subtotal'] = 
                    $this->cartItems[$index]['quantity'] * $this->cartItems[$index]['price'];
            } else {
                $this->removeCartItem($index);
            }
            $this->calculateTotals();
        }
    }

    public function removeCartItem($index)
    {
        if (isset($this->cartItems[$index])) {
            unset($this->cartItems[$index]);
            $this->cartItems = array_values($this->cartItems);
            $this->calculateTotals();
        }
    }

    public function calculateTotals()
    {
        $this->subtotal = collect($this->cartItems)->sum('subtotal');
        $this->taxAmount = $this->subtotal * ($this->taxRate / 100);
        $this->total = $this->subtotal + $this->taxAmount - $this->discountAmount;
    }

    public function selectPaymentMethod($method)
    {
        $this->paymentMethod = $method;
    }

    public function placeOrder()
    {
        if (empty($this->cartItems)) {
            session()->flash('error', 'Keranjang kosong!');
            return;
        }
        
        if (!$this->paymentMethod) {
            session()->flash('error', 'Pilih metode pembayaran!');
            return;
        }

        try {
            DB::transaction(function () {
                // Generate order number
                $lastOrder = Order::whereDate('created_at', today())->count();
                $orderNumber = '#' . str_pad($lastOrder + 1, 3, '0', STR_PAD_LEFT);
                
                // Create order
                $order = Order::create([
                    'order_number' => $orderNumber,
                    'customer_name' => $this->customerName ?: null,
                    'table_id' => $this->tableId,
                    'user_id' => auth()->id(),
                    'order_type' => $this->orderType,
                    'status' => 'pending',
                    'subtotal' => $this->subtotal,
                    'tax_rate' => $this->taxRate,
                    'tax_amount' => $this->taxAmount,
                    'discount_amount' => $this->discountAmount,
                    'promo_code' => $this->promoCode ?: null,
                    'total' => $this->total,
                    'payment_method' => $this->paymentMethod,
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                ]);
                
                // Create order items
                foreach ($this->cartItems as $item) {
                    $order->items()->create([
                        'product_id' => $item['product_id'],
                        'product_name' => $item['name'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                        'notes' => $item['notes'] ?? null,
                    ]);
                }
                
                // Update table status if dine in
                if ($this->tableId) {
                    Table::find($this->tableId)->update(['status' => 'occupied']);
                }
            });
            
            // Reset form
            $this->reset(['cartItems', 'customerName', 'tableId', 'promoCode', 'paymentMethod']);
            $this->orderType = 'dine_in';
            $this->calculateTotals();
            
            session()->flash('success', 'Order berhasil dibuat!');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal membuat order: ' . $e->getMessage());
        }
    }

    public function clearCart()
    {
        $this->reset(['cartItems', 'customerName', 'promoCode', 'paymentMethod']);
        $this->calculateTotals();
    }
}
