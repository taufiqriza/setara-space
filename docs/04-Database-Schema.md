# 04. Database Schema

## 📊 Entity Relationship Diagram

```
┌─────────────────┐         ┌─────────────────┐
│     users       │         │     roles       │
├─────────────────┤         ├─────────────────┤
│ id              │◄───┐    │ id              │
│ name            │    │    │ name            │
│ email           │    │    │ guard_name      │
│ password        │    │    └─────────────────┘
│ employment_type │    │           ▲
│ is_active       │    │           │
│ created_at      │    │    ┌──────┴──────┐
│ updated_at      │    │    │ model_has   │
└─────────────────┘    │    │ _roles      │
         │             │    └─────────────┘
         │             │
         ▼             │
┌─────────────────┐    │    ┌─────────────────┐
│    orders       │    │    │   categories    │
├─────────────────┤    │    ├─────────────────┤
│ id              │    │    │ id              │
│ order_number    │    │    │ name            │
│ customer_name   │    │    │ icon            │
│ table_id        │────┼───►│ sort_order      │
│ user_id         │────┘    │ is_active       │
│ order_type      │         │ created_at      │
│ status          │         └─────────────────┘
│ subtotal        │                  │
│ tax_amount      │                  │
│ discount_amount │                  ▼
│ total           │         ┌─────────────────┐
│ payment_method  │         │    products     │
│ payment_status  │         ├─────────────────┤
│ notes           │         │ id              │
│ created_at      │         │ category_id     │
│ updated_at      │         │ name            │
└─────────────────┘         │ description     │
         │                  │ price           │
         │                  │ image           │
         ▼                  │ is_active       │
┌─────────────────┐         │ created_at      │
│  order_items    │         └─────────────────┘
├─────────────────┤                  ▲
│ id              │                  │
│ order_id        │──────────────────┤
│ product_id      │──────────────────┘
│ product_name    │
│ quantity        │
│ unit_price      │
│ subtotal        │
│ notes           │
│ created_at      │
└─────────────────┘

┌─────────────────┐         ┌─────────────────┐
│    tables       │         │    settings     │
├─────────────────┤         ├─────────────────┤
│ id              │         │ id              │
│ name            │         │ key             │
│ capacity        │         │ value           │
│ status          │         │ group           │
│ is_active       │         │ created_at      │
│ created_at      │         └─────────────────┘
└─────────────────┘

┌─────────────────┐
│    promos       │
├─────────────────┤
│ id              │
│ code            │
│ name            │
│ type            │
│ value           │
│ min_purchase    │
│ max_discount    │
│ start_date      │
│ end_date        │
│ is_active       │
│ created_at      │
└─────────────────┘
```

---

## 📋 Detail Tabel

### 1. users
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    employment_type ENUM('fulltime', 'parttime') DEFAULT 'fulltime',
    is_active BOOLEAN DEFAULT TRUE,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### 2. categories
```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    icon VARCHAR(100) NULL,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### 3. products
```sql
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    price DECIMAL(12,2) NOT NULL,
    image VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
```

### 4. tables
```sql
CREATE TABLE tables (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    capacity INT DEFAULT 4,
    status ENUM('available', 'occupied', 'reserved') DEFAULT 'available',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### 5. orders
```sql
CREATE TABLE orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(20) UNIQUE NOT NULL,
    customer_name VARCHAR(255) NULL,
    table_id BIGINT UNSIGNED NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    order_type ENUM('dine_in', 'take_away') DEFAULT 'dine_in',
    status ENUM('pending', 'on_kitchen', 'all_done', 'to_be_served', 'completed', 'cancelled') DEFAULT 'pending',
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    tax_rate DECIMAL(5,2) DEFAULT 0,
    tax_amount DECIMAL(12,2) DEFAULT 0,
    discount_amount DECIMAL(12,2) DEFAULT 0,
    promo_code VARCHAR(50) NULL,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    payment_method ENUM('cash', 'qris', 'ewallet', 'transfer') NULL,
    payment_status ENUM('unpaid', 'paid', 'refunded') DEFAULT 'unpaid',
    paid_at TIMESTAMP NULL,
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (table_id) REFERENCES tables(id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Index untuk performa
CREATE INDEX idx_orders_status ON orders(status);
CREATE INDEX idx_orders_created_at ON orders(created_at);
CREATE INDEX idx_orders_user_id ON orders(user_id);
```

### 6. order_items
```sql
CREATE TABLE order_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    unit_price DECIMAL(12,2) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
```

### 7. promos
```sql
CREATE TABLE promos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    type ENUM('percentage', 'fixed') NOT NULL,
    value DECIMAL(12,2) NOT NULL,
    min_purchase DECIMAL(12,2) DEFAULT 0,
    max_discount DECIMAL(12,2) NULL,
    usage_limit INT NULL,
    used_count INT DEFAULT 0,
    start_date DATE NULL,
    end_date DATE NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### 8. settings
```sql
CREATE TABLE settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `group` VARCHAR(50) NOT NULL,
    `key` VARCHAR(100) NOT NULL,
    value TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY unique_group_key (`group`, `key`)
);

-- Default settings
INSERT INTO settings (`group`, `key`, value) VALUES
('store', 'name', 'Setara Space'),
('store', 'tagline', 'Satu Semesta Seribu Rasa'),
('store', 'address', 'Jl. Wahid Hasyim, Condongcatur, Sleman, Yogyakarta'),
('store', 'phone', ''),
('tax', 'rate', '10'),
('tax', 'enabled', 'true'),
('printer', 'enabled', 'true'),
('printer', 'type', 'thermal'),
('printer', 'paper_width', '58');
```

---

## 🔢 Enum Values

### Order Status Flow
```
pending → on_kitchen → all_done → to_be_served → completed
                                              ↘ cancelled
```

### Payment Status
```
unpaid → paid
       ↘ refunded
```

---

## 📈 Sample Data (Seeder)

### Categories for Dimsum
```php
$categories = [
    ['name' => 'All Menu', 'icon' => 'fa-th-large', 'sort_order' => 0],
    ['name' => 'Dimsum Original', 'icon' => 'fa-bowl-food', 'sort_order' => 1],
    ['name' => 'Dimsum Keju', 'icon' => 'fa-cheese', 'sort_order' => 2],
    ['name' => 'Dimsum Pedas', 'icon' => 'fa-pepper-hot', 'sort_order' => 3],
    ['name' => 'Dimsum Mentai', 'icon' => 'fa-fire', 'sort_order' => 4],
    ['name' => 'Wonton', 'icon' => 'fa-bowl-rice', 'sort_order' => 5],
    ['name' => 'Mie & Noodle', 'icon' => 'fa-utensils', 'sort_order' => 6],
    ['name' => 'Minuman', 'icon' => 'fa-mug-hot', 'sort_order' => 7],
];
```

### Sample Products
```php
$products = [
    ['category' => 'Dimsum Original', 'name' => 'Dimsum Ayam Original', 'price' => 15000],
    ['category' => 'Dimsum Original', 'name' => 'Dimsum Udang', 'price' => 18000],
    ['category' => 'Dimsum Keju', 'name' => 'Dimsum Keju Goreng', 'price' => 17000],
    ['category' => 'Dimsum Keju', 'name' => 'Dimsum Keju Mozarella', 'price' => 20000],
    ['category' => 'Dimsum Pedas', 'name' => 'Dimsum Level 1', 'price' => 16000],
    ['category' => 'Dimsum Pedas', 'name' => 'Dimsum Level 3', 'price' => 16000],
    ['category' => 'Dimsum Mentai', 'name' => 'Dimsum Mentai Original', 'price' => 22000],
    ['category' => 'Wonton', 'name' => 'Wonton Frozen (10pcs)', 'price' => 25000],
];
```
