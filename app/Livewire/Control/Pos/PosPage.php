<?php

namespace App\Livewire\Control\Pos;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Table;
use App\Models\WorkShift;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
    public string $activeOrderFilter = 'all'; // all, dine_in, online

    // Receipt Modal
    public bool $showReceiptModal = false;
    public ?array $lastOrder = null;
    
    // Order Detail Modal (Tracking)
    public bool $showOrderDetailModal = false;
    public ?Order $selectedOrder = null;
    
    // Store Status
    public string $storeStatus = 'open'; // open, closed
    public bool $showStoreStatusModal = false;

    // Shift & Attendance System
    public bool $showAttendanceModal = false;
    public string $attendanceType = 'start'; // start, end
    public $tempPhoto = null; // Base64 photo from webcam
    public $shiftAmount = ''; // Start cash or actual closing cash
    public string $shiftNotes = '';
    public array $shiftData = []; // To store active shift info
    public float $expectedCash = 0;

    protected $listeners = ['refreshPos' => '$refresh'];

    public function openStoreStatusModal()
    {
        $this->showStoreStatusModal = true;
    }

    public function closeStoreStatusModal()
    {
        $this->showStoreStatusModal = false;
    }

    public function toggleStoreStatus()
    {
        $this->storeStatus = $this->storeStatus === 'open' ? 'closed' : 'open';
        $this->closeStoreStatusModal();
        session()->flash('success', 'Store is now ' . ucfirst($this->storeStatus));
    }

    public function mount()
    {
        $this->taxRate = 10; // Default 10%
        $this->checkActiveShift();
    }

    public function checkActiveShift()
    {
        $activeShift = auth()->user()->activeShift();
        
        if (!$activeShift) {
            // No active shift, force open modal
            $this->attendanceType = 'start';
            $this->shiftAmount = ''; // Reset
            $this->attendanceType = 'start';
            $this->shiftAmount = ''; // Reset
            $this->tempPhoto = null;
            $this->shiftData = [];
            $this->dispatch('open-attendance-modal'); // Dispatch event instead of property sync
        } else {
            $this->showAttendanceModal = false; // Internal state update only
            $this->shiftData = $activeShift->toArray();
        }
    }

    public function startRegisterShift()
    {
        $this->validate([
            'shiftAmount' => 'required|numeric|min:0',
            'tempPhoto' => 'required|string',
        ]);

        // Process Photo
        $photoPath = $this->storeBase64Photo($this->tempPhoto, 'shifts/start');

        // Create Shift Record
        $shift = WorkShift::create([
            'user_id' => auth()->id(),
            'start_time' => now(),
            'start_cash' => $this->shiftAmount,
            'start_photo' => $photoPath,
            'status' => 'open',
        ]);

        $this->activeOrderFilter = 'all'; // Reset filter
        $this->checkActiveShift(); // Reload state
        
        $this->dispatch('close-attendance-modal'); // Force close on frontend

        $this->dispatch('swal:compact', [
            'type' => 'success',
            'text' => 'Shift Started! Good luck.'
        ]);
    }

    public function initiateCloseRegister()
    {
        $activeShift = auth()->user()->activeShift();
        if (!$activeShift) return;

        // Calculate Expected Cash: Start Cash + Total Cash Sales during this shift
        // Logic: Get orders where payment_method='cash' AND created_at >= shift start
        $cashSales = Order::where('user_id', auth()->id())
            ->where('created_at', '>=', $activeShift->start_time)
            ->where('payment_status', 'paid')
            ->where('payment_method', 'cash')
            ->sum('total');
            
        $this->expectedCash = $activeShift->start_cash + $cashSales;
        
        $this->attendanceType = 'end';
        $this->shiftAmount = ''; // User must input actual cash
        $this->shiftNotes = '';
        $this->tempPhoto = null;
        $this->dispatch('open-attendance-modal');
    }

    public function closeRegisterShift()
    {
        $this->validate([
            'shiftAmount' => 'required|numeric|min:0',
            'tempPhoto' => 'required|string',
        ]);

        $activeShift = auth()->user()->activeShift();
        if (!$activeShift) return;

        // Process Photo
        $photoPath = $this->storeBase64Photo($this->tempPhoto, 'shifts/end');

        // Update Shift Record
        $activeShift->update([
            'end_time' => now(),
            'end_cash_expected' => $this->expectedCash,
            'end_cash_actual' => $this->shiftAmount,
            'end_photo' => $photoPath,
            'end_photo' => $photoPath,
            'status' => 'closed',
            'note' => $this->shiftNotes,
        ]);

        $this->showAttendanceModal = false;
        $this->dispatch('close-attendance-modal'); // Force close on frontend
        
        // Redirect or generic message
        session()->flash('success', 'Shift Closed. See you tomorrow!');
        return redirect()->route('control.dashboard'); 
    }

    private function storeBase64Photo($base64String, $folder)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            $data = substr($base64String, strpos($base64String, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, etc
            
            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new \Exception('Invalid image type');
            }
            
            $data = base64_decode($data);
            if ($data === false) {
                throw new \Exception('Base64 decode failed');
            }
            
            $filename = $folder . '/' . Str::random(40) . '.' . $type;
            Storage::disk('public')->put($filename, $data);
            
            return $filename;
        }
        
        throw new \Exception('Did not match data URI with image data');
    }
    
    public function getNextOrderNumber()
    {
        // New Format: YYYYMMDD-XXX (e.g. 20260128-001)
        // This guarantees global uniqueness while keeping short sequence per day.
        $prefix = date('Ymd') . '-';
        
        // Find the highest number for TODAY only (matching prefix)
        // Order::where starts with prefix...
        $lastOrder = Order::where('order_number', 'like', $prefix . '%')
            ->withTrashed()
            ->orderBy('id', 'desc') // Assuming ID is roughly sequential, or use length/substring sort if needed
            ->first();

        // Default start
        $nextSequence = 1;

        if ($lastOrder) {
            // Parse existing: "20260128-005" -> extract "005" -> int(5)
            // Robust parsing: split by dash
            $parts = explode('-', $lastOrder->order_number);
            if (count($parts) === 2 && is_numeric($parts[1])) { // Safety check
                $nextSequence = (int)$parts[1] + 1;
            }
        }

        // Final safety loop (just in case)
        while (true) {
            $candidate = $prefix . str_pad($nextSequence, 3, '0', STR_PAD_LEFT);
            
            $exists = Order::where('order_number', $candidate)->withTrashed()->exists();
            if (!$exists) {
                return $candidate;
            }
            
            $nextSequence++;
             // Panic break
            if ($nextSequence > 9999) break;
        }
    }
    
    public function getCurrentOrderNumberProperty()
    {
        return $this->getNextOrderNumber();
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
        
        
        // Active Order Filter Logic
        $recentOrders = Order::with(['user', 'table', 'merchantOrder.integration', 'merchantOrder.credential'])
            ->whereIn('status', ['pending', 'on_kitchen', 'to_be_served', 'processing', 'completed'])
            ->whereDate('created_at', today())
            // Apply Filter
            ->when($this->activeOrderFilter === 'dine_in', function($q) {
                // Assuming online orders have specific payment methods. 
                // Alternatively, check if merchantOrder exists.
                $q->whereNotIn('payment_method', ['gofood', 'grabfood', 'shopeefood']);
            })
            ->when($this->activeOrderFilter === 'online', function($q) {
                $q->whereIn('payment_method', ['gofood', 'grabfood', 'shopeefood']);
            })
            ->latest()
            ->take(20)
            ->get();
            
        // Count Active Online Orders for Badge
        $onlineOrdersCount = Order::whereIn('payment_method', ['gofood', 'grabfood', 'shopeefood'])
            ->whereIn('status', ['pending', 'on_kitchen', 'processing', 'to_be_served', 'ready'])
            ->whereDate('created_at', today())
            ->count();

        return view('livewire.control.pos.pos-page', [
            'categories' => $categories,
            'products' => $products,
            'tables' => $tables,
            'recentOrders' => $recentOrders,
            'currentOrderNumber' => $this->currentOrderNumber,
            'onlineOrdersCount' => $onlineOrdersCount,
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
        
        $this->dispatch('swal:compact', [
            'type' => 'success',
            'text' => 'Item added to cart'
        ]);
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
        
        $this->dispatch('swal:compact', [
            'type' => 'success',
            'text' => 'Item added +1'
        ]);
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
                return; // Remove handles notification
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
            
            $this->dispatch('swal:compact', [
                'type' => 'info',
                'text' => 'Item removed'
            ]);
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
            $this->dispatch('swal:compact', [
                'type' => 'error',
                'text' => 'Cart is empty!'
            ]);
            return;
        }
        
        if (!$this->paymentMethod) {
            $this->dispatch('swal:compact', [
                'type' => 'error',
                'text' => 'Select a payment method!'
            ]);
            return;
        }

        try {
            $orderData = DB::transaction(function () {
                // Generate order number
                // Generate order number inside transaction to be safe
                $orderNumber = $this->getNextOrderNumber();
                
                // Get table name if exists
                $tableName = null;
                if ($this->tableId) {
                    $table = Table::find($this->tableId);
                    $tableName = $table ? $table->name : null;
                }
                
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
                
                $orderItems = [];
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
                    
                    $orderItems[] = [
                        'name' => $item['name'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                    ];
                }
                
                // Update table status if dine in
                if ($this->tableId) {
                    Table::find($this->tableId)->update(['status' => 'occupied']);
                }
                
                
                // Log Activity
                \App\Models\Activity::create([
                    'user_id' => auth()->id(),
                    'action' => 'order_placed',
                    'subject_type' => Order::class,
                    'subject_id' => $order->id,
                    'description' => "Order #{$orderNumber} placed by " . ($this->customerName ?: 'Customer'),
                    'properties' => [
                        'amount' => $this->total,
                        'items_count' => count($orderItems),
                        'items' => array_map(function($item) {
                            return [
                                'name' => $item['name'],
                                'qty' => $item['quantity'],
                                'price' => $item['subtotal'] / $item['quantity'] // Recalculate unit price safely
                            ];
                        }, $orderItems)
                    ],
                    'ip_address' => request()->ip(),
                ]);

                return [
                    'order_number' => $orderNumber,
                    'customer_name' => $this->customerName,
                    'table_name' => $tableName,
                    'order_type' => $this->orderType,
                    'subtotal' => $this->subtotal,
                    'tax_amount' => $this->taxAmount,
                    'total' => $this->total,
                    'payment_method' => $this->paymentMethod,
                    'items' => $orderItems,
                ];
            });
            
            // Set last order for receipt
            $this->lastOrder = $orderData;
            $this->showReceiptModal = true;
            
            // Reset form
            $this->reset(['cartItems', 'customerName', 'tableId', 'promoCode', 'paymentMethod']);
            $this->orderType = 'dine_in';
            $this->calculateTotals();
            
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'title' => 'Order Success!',
                'text' => 'Order has been placed successfully.'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'title' => 'Order Failed',
                'text' => 'Failed: ' . $e->getMessage()
            ]);
        }
    }
    
    public function closeReceiptModal()
    {
        $this->showReceiptModal = false;
        $this->lastOrder = null;
    }
    
    // Order Viewing (Bottom Bar)
    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::with(['items', 'table', 'user', 'merchantOrder.integration'])->find($orderId);
        if ($this->selectedOrder) {
            $this->showOrderDetailModal = true;
        }
    }
    
    public function closeOrderDetailModal()
    {
        $this->showOrderDetailModal = false;
        $this->selectedOrder = null;
    }
    
    public function updateOrderStatus($status)
    {
        if ($this->selectedOrder) {
            $this->selectedOrder->update(['status' => $status]);
            
            // If status is all_done or completed, maybe close the modal?
            // Let's keep it open or close depending on UX. Close is better for quick workflow.
            $this->closeOrderDetailModal();
            
            $this->dispatch('swal:compact', [
                'type' => 'success',
                'text' => 'Status updated to ' . ucfirst(str_replace('_', ' ', $status))
            ]);
        }
    }

    public function clearCart()
    {
        $this->reset(['cartItems', 'customerName', 'promoCode', 'paymentMethod']);
        $this->calculateTotals();
        
        $this->dispatch('swal:compact', [
            'type' => 'info',
            'text' => 'Cart cleared'
        ]);
    }

    public function setActiveOrderFilter($filter)
    {
        $this->activeOrderFilter = $filter;
    }
}
