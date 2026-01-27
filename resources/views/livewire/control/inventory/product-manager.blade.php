<div class="h-screen flex flex-col overflow-hidden">
    
    {{-- Header --}}
    <header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-4 flex-shrink-0">
        <div class="flex items-center gap-4">
            <button onclick="window.toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-600">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Products</h1>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button wire:click="openCategoryModal" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl flex items-center gap-2">
                <i class="fas fa-folder-plus"></i>
                <span class="hidden sm:inline">Add Category</span>
            </button>
            <button wire:click="openProductModal" class="px-4 py-2 bg-space-600 hover:bg-space-700 text-white font-medium rounded-xl flex items-center gap-2">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Add Product</span>
            </button>
        </div>
    </header>
    
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mx-4 mt-3 px-4 py-3 bg-green-100 border border-green-300 text-green-700 rounded-xl flex items-center gap-2">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mx-4 mt-3 px-4 py-3 bg-red-100 border border-red-300 text-red-700 rounded-xl flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Filters --}}
    <div class="p-4 bg-white border-b border-gray-200 flex flex-wrap items-center gap-3">
        <div class="flex-1 min-w-[200px] relative">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk..." 
                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        
        <select wire:model.live="filterCategory" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none min-w-[180px]">
            <option value="">All Categories</option>
            @foreach($allCategories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        
        <select wire:model.live="filterStatus" class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

    {{-- Content --}}
    <div class="flex-1 overflow-y-auto p-4 space-y-4">
        
        {{-- Categories Overview --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fas fa-folder text-space-600"></i>
                Categories ({{ $categories->count() }})
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach($categories as $category)
                    <div class="group flex items-center gap-2 px-3 py-2 bg-gray-50 hover:bg-space-50 rounded-xl border border-gray-200 hover:border-space-300">
                        <i class="{{ $category->icon ?? 'fas fa-folder' }} text-space-600"></i>
                        <span class="font-medium text-gray-700">{{ $category->name }}</span>
                        <span class="text-xs text-gray-400">({{ $category->products_count }})</span>
                        <div class="flex items-center gap-1 ml-2 opacity-0 group-hover:opacity-100">
                            <button wire:click="editCategory({{ $category->id }})" class="w-6 h-6 flex items-center justify-center rounded hover:bg-white text-gray-400 hover:text-space-600">
                                <i class="fas fa-pen text-xs"></i>
                            </button>
                            <button wire:click="confirmDelete('category', {{ $category->id }})" class="w-6 h-6 flex items-center justify-center rounded hover:bg-white text-gray-400 hover:text-red-500">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
                @if($categories->count() == 0)
                    <p class="text-gray-400 text-sm">Belum ada kategori. Klik "Add Category" untuk menambah.</p>
                @endif
            </div>
        </div>

        {{-- Products Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-box text-space-600"></i>
                    Products ({{ $products->total() }})
                </h3>
            </div>
            
            @if($products->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 text-left text-sm text-gray-600">
                            <tr>
                                <th class="px-4 py-3 font-medium">Product</th>
                                <th class="px-4 py-3 font-medium">Category</th>
                                <th class="px-4 py-3 font-medium">Price</th>
                                <th class="px-4 py-3 font-medium">Status</th>
                                <th class="px-4 py-3 font-medium text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                        <i class="fas fa-bowl-food"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                                @if($product->description)
                                                    <p class="text-xs text-gray-500 truncate max-w-[200px]">{{ $product->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 bg-space-50 text-space-700 text-xs font-medium rounded-lg">
                                            {{ $product->category->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="font-semibold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <button wire:click="toggleProductStatus({{ $product->id }})" 
                                                class="px-2 py-1 text-xs font-medium rounded-full {{ $product->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-1">
                                            <button wire:click="editProduct({{ $product->id }})" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 hover:text-space-600">
                                                <i class="fas fa-pen text-sm"></i>
                                            </button>
                                            <button wire:click="confirmDelete('product', {{ $product->id }})" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 hover:text-red-500">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="p-4 border-t border-gray-100">
                    {{ $products->links() }}
                </div>
            @else
                <div class="p-12 text-center text-gray-400">
                    <i class="fas fa-box-open text-4xl mb-3"></i>
                    <p class="font-medium">No products found</p>
                    <p class="text-sm">Add your first product to get started</p>
                </div>
            @endif
        </div>
    </div>

    {{-- ========== CATEGORY MODAL ========== --}}
    @if($showCategoryModal)
        <div class="fixed inset-0 z-[9999] overflow-y-auto" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" wire:click.stop>
                    <div class="flex justify-between items-center p-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-900 text-lg">
                            {{ $editingCategory ? 'Edit Category' : 'Add Category' }}
                        </h3>
                        <button wire:click="closeCategoryModal" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form wire:submit.prevent="saveCategory">
                        <div class="p-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category Name *</label>
                                <input type="text" wire:model="categoryName" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none" placeholder="e.g. Dimsum Original" autofocus>
                                @error('categoryName') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Icon (Font Awesome)</label>
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-space-50 rounded-xl flex items-center justify-center text-space-600">
                                        <i class="{{ $categoryIcon }} text-xl"></i>
                                    </div>
                                    <input type="text" wire:model.live="categoryIcon" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none" placeholder="fas fa-bowl-food">
                                </div>
                                <p class="mt-1 text-xs text-gray-400">Examples: fas fa-bowl-food, fas fa-cheese, fas fa-pepper-hot</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                                <input type="number" wire:model="categorySortOrder" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none" min="0">
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 flex justify-end gap-2">
                            <button type="button" wire:click="closeCategoryModal" class="px-4 py-2 text-gray-600 hover:bg-gray-200 font-medium rounded-xl">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-space-600 hover:bg-space-700 text-white font-medium rounded-xl">
                                {{ $editingCategory ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- ========== PRODUCT MODAL ========== --}}
    @if($showProductModal)
        <div class="fixed inset-0 z-[9999] overflow-y-auto" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden max-h-[90vh] flex flex-col" wire:click.stop>
                    <div class="flex justify-between items-center p-4 border-b border-gray-100 flex-shrink-0">
                        <h3 class="font-semibold text-gray-900 text-lg">
                            {{ $editingProduct ? 'Edit Product' : 'Add Product' }}
                        </h3>
                        <button wire:click="closeProductModal" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form wire:submit.prevent="saveProduct" class="flex flex-col flex-1 overflow-hidden">
                        <div class="p-4 space-y-4 overflow-y-auto flex-1">
                            {{-- Image Upload --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                                <div class="flex items-center gap-4">
                                    <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                        @if($productImage)
                                            <img src="{{ $productImage->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover">
                                        @elseif($existingImage)
                                            <img src="{{ asset('storage/' . $existingImage) }}" alt="Current" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <i class="fas fa-image text-2xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" wire:model="productImage" accept="image/*" class="hidden" id="productImageInput-{{ $editingProduct ? $productId : 'new' }}">
                                        <label for="productImageInput-{{ $editingProduct ? $productId : 'new' }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl cursor-pointer">
                                            <i class="fas fa-upload"></i>
                                            Choose Image
                                        </label>
                                        <p class="mt-1 text-xs text-gray-400">Max. 2MB (JPG, PNG)</p>
                                        <div wire:loading wire:target="productImage" class="mt-1 text-xs text-space-600">
                                            <i class="fas fa-spinner fa-spin"></i> Uploading...
                                        </div>
                                        @error('productImage') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Category --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                                <select wire:model="productCategoryId" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none">
                                    <option value="">Select Category</option>
                                    @foreach($allCategories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('productCategoryId') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                            
                            {{-- Name --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Product Name *</label>
                                <input type="text" wire:model="productName" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none" placeholder="e.g. Dimsum Ayam Original">
                                @error('productName') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                            
                            {{-- Description --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea wire:model="productDescription" rows="3" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none resize-none" placeholder="Short description..."></textarea>
                            </div>
                            
                            {{-- Price --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rp) *</label>
                                <input type="number" wire:model="productPrice" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-space-500/20 focus:border-space-500 outline-none" min="0" step="500" placeholder="15000">
                                @error('productPrice') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                            
                            {{-- Status --}}
                            <div>
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" wire:model="productIsActive" class="w-5 h-5 rounded border-gray-300 text-space-600 focus:ring-space-500">
                                    <span class="font-medium text-gray-700">Active (visible in POS)</span>
                                </label>
                            </div>
                        </div>
                        <div class="p-4 bg-gray-50 flex justify-end gap-2 flex-shrink-0">
                            <button type="button" wire:click="closeProductModal" class="px-4 py-2 text-gray-600 hover:bg-gray-200 font-medium rounded-xl">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-space-600 hover:bg-space-700 text-white font-medium rounded-xl"
                                    wire:loading.attr="disabled" wire:loading.class="opacity-50" wire:target="saveProduct">
                                <span wire:loading.remove wire:target="saveProduct">{{ $editingProduct ? 'Update' : 'Save' }}</span>
                                <span wire:loading wire:target="saveProduct"><i class="fas fa-spinner fa-spin mr-1"></i> Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- ========== DELETE CONFIRMATION MODAL ========== --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-[9999] overflow-y-auto" style="background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden" wire:click.stop>
                    <div class="p-6 text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-trash text-2xl text-red-500"></i>
                        </div>
                        <h3 class="font-semibold text-lg text-gray-900 mb-2">Delete {{ ucfirst($deleteType) }}?</h3>
                        <p class="text-gray-500">Are you sure you want to delete <strong>{{ $deleteName }}</strong>? This action cannot be undone.</p>
                    </div>
                    <div class="p-4 bg-gray-50 flex gap-2">
                        <button wire:click="closeDeleteModal" class="flex-1 px-4 py-2.5 text-gray-600 hover:bg-gray-200 font-medium rounded-xl">
                            Cancel
                        </button>
                        <button wire:click="delete" class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
