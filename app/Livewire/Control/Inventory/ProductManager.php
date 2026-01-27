<?php

namespace App\Livewire\Control\Inventory;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductManager extends Component
{
    use WithPagination, WithFileUploads;

    // Search & Filter
    public string $search = '';
    public ?int $filterCategory = null;
    public ?string $filterStatus = null;

    // Category Modal
    public bool $showCategoryModal = false;
    public bool $editingCategory = false;
    public ?int $categoryId = null;
    public string $categoryName = '';
    public string $categoryIcon = 'fas fa-bowl-food';
    public int $categorySortOrder = 0;

    // Product Modal
    public bool $showProductModal = false;
    public bool $editingProduct = false;
    public ?int $productId = null;
    public ?int $productCategoryId = null;
    public string $productName = '';
    public string $productDescription = '';
    public float $productPrice = 0;
    public bool $productIsActive = true;
    public $productImage = null;
    public ?string $existingImage = null;

    // Delete Confirmation
    public bool $showDeleteModal = false;
    public string $deleteType = '';
    public ?int $deleteId = null;
    public string $deleteName = '';

    protected $queryString = ['search', 'filterCategory', 'filterStatus'];

    protected function rules()
    {
        return [
            'categoryName' => 'required|min:2|max:100',
            'categoryIcon' => 'required',
            'categorySortOrder' => 'integer|min:0',
            'productCategoryId' => 'required|exists:categories,id',
            'productName' => 'required|min:2|max:255',
            'productDescription' => 'nullable|max:1000',
            'productPrice' => 'required|numeric|min:0',
            'productImage' => 'nullable|image|max:2048',
        ];
    }

    public function render()
    {
        $categories = Category::withCount(['products' => fn($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        $products = Product::query()
            ->with('category')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->filterCategory, fn($q) => $q->where('category_id', $this->filterCategory))
            ->when($this->filterStatus !== null, fn($q) => $q->where('is_active', $this->filterStatus === 'active'))
            ->orderBy('category_id')
            ->orderBy('name')
            ->paginate(20);

        return view('livewire.control.inventory.product-manager', [
            'categories' => $categories,
            'products' => $products,
            'allCategories' => Category::orderBy('sort_order')->get(),
        ])->layout('layouts.control', ['title' => 'Products']);
    }

    // ========== CATEGORY METHODS ==========
    
    public function openCategoryModal()
    {
        $this->resetCategoryForm();
        $this->showCategoryModal = true;
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->categoryName = $category->name;
        $this->categoryIcon = $category->icon ?? 'fas fa-bowl-food';
        $this->categorySortOrder = $category->sort_order;
        $this->editingCategory = true;
        $this->showCategoryModal = true;
    }

    public function saveCategory()
    {
        $this->validate([
            'categoryName' => 'required|min:2|max:100',
            'categoryIcon' => 'required',
            'categorySortOrder' => 'integer|min:0',
        ]);

        if ($this->editingCategory && $this->categoryId) {
            $category = Category::findOrFail($this->categoryId);
            $category->update([
                'name' => $this->categoryName,
                'slug' => Str::slug($this->categoryName),
                'icon' => $this->categoryIcon,
                'sort_order' => $this->categorySortOrder,
            ]);
            session()->flash('success', 'Kategori berhasil diupdate!');
        } else {
            Category::create([
                'name' => $this->categoryName,
                'slug' => Str::slug($this->categoryName),
                'icon' => $this->categoryIcon,
                'sort_order' => $this->categorySortOrder,
                'is_active' => true,
            ]);
            session()->flash('success', 'Kategori berhasil ditambahkan!');
        }

        $this->closeCategoryModal();
    }

    public function closeCategoryModal()
    {
        $this->showCategoryModal = false;
        $this->resetCategoryForm();
    }

    private function resetCategoryForm()
    {
        $this->categoryId = null;
        $this->categoryName = '';
        $this->categoryIcon = 'fas fa-bowl-food';
        $this->categorySortOrder = 0;
        $this->editingCategory = false;
    }

    // ========== PRODUCT METHODS ==========

    public function openProductModal(?int $categoryId = null)
    {
        $this->resetProductForm();
        $this->productCategoryId = $categoryId;
        $this->showProductModal = true;
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->productCategoryId = $product->category_id;
        $this->productName = $product->name;
        $this->productDescription = $product->description ?? '';
        $this->productPrice = $product->price;
        $this->productIsActive = $product->is_active;
        $this->existingImage = $product->image;
        $this->editingProduct = true;
        $this->showProductModal = true;
    }

    public function saveProduct()
    {
        $this->validate([
            'productCategoryId' => 'required|exists:categories,id',
            'productName' => 'required|min:2|max:255',
            'productDescription' => 'nullable|max:1000',
            'productPrice' => 'required|numeric|min:0',
            'productImage' => 'nullable|image|max:2048',
        ]);

        $imagePath = $this->existingImage;

        // Handle image upload
        if ($this->productImage) {
            $imagePath = $this->productImage->store('products', 'public');
        }

        if ($this->editingProduct && $this->productId) {
            $product = Product::findOrFail($this->productId);
            $product->update([
                'category_id' => $this->productCategoryId,
                'name' => $this->productName,
                'slug' => Str::slug($this->productName),
                'description' => $this->productDescription,
                'price' => $this->productPrice,
                'is_active' => $this->productIsActive,
                'image' => $imagePath,
            ]);
            session()->flash('success', 'Produk berhasil diupdate!');
        } else {
            Product::create([
                'category_id' => $this->productCategoryId,
                'name' => $this->productName,
                'slug' => Str::slug($this->productName),
                'description' => $this->productDescription,
                'price' => $this->productPrice,
                'is_active' => $this->productIsActive,
                'image' => $imagePath,
            ]);
            session()->flash('success', 'Produk berhasil ditambahkan!');
        }

        $this->closeProductModal();
    }

    public function closeProductModal()
    {
        $this->showProductModal = false;
        $this->resetProductForm();
    }

    public function toggleProductStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => !$product->is_active]);
        session()->flash('success', 'Status produk berhasil diubah!');
    }

    private function resetProductForm()
    {
        $this->productId = null;
        $this->productCategoryId = null;
        $this->productName = '';
        $this->productDescription = '';
        $this->productPrice = 0;
        $this->productIsActive = true;
        $this->productImage = null;
        $this->existingImage = null;
        $this->editingProduct = false;
    }

    // ========== DELETE METHODS ==========

    public function confirmDelete($type, $id)
    {
        $this->deleteType = $type;
        $this->deleteId = $id;
        
        if ($type === 'category') {
            $item = Category::findOrFail($id);
            $this->deleteName = $item->name;
        } else {
            $item = Product::findOrFail($id);
            $this->deleteName = $item->name;
        }
        
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->deleteType === 'category') {
            $category = Category::findOrFail($this->deleteId);
            
            // Check if category has products
            if ($category->products()->count() > 0) {
                session()->flash('error', 'Tidak bisa menghapus kategori yang masih memiliki produk!');
                $this->closeDeleteModal();
                return;
            }
            
            $category->delete();
            session()->flash('success', 'Kategori berhasil dihapus!');
        } else {
            Product::findOrFail($this->deleteId)->delete();
            session()->flash('success', 'Produk berhasil dihapus!');
        }
        
        $this->closeDeleteModal();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deleteType = '';
        $this->deleteId = null;
        $this->deleteName = '';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterCategory()
    {
        $this->resetPage();
    }
}
