# 03. User Roles & Permissions

## 👥 Struktur Role

```
┌────────────────────────────────────────────────────┐
│                   SUPERADMIN                        │
│           (Owner / Manager Utama)                   │
│      Full access ke semua fitur & data             │
└───────────────────────┬────────────────────────────┘
                        │
        ┌───────────────┴───────────────┐
        ▼                               ▼
┌───────────────────┐         ┌───────────────────┐
│   STAFF FULL TIME │         │  STAFF PART TIME  │
│   (Kasir Senior)  │         │   (Kasir Junior)  │
│  Akses lebih luas │         │   Akses terbatas  │
└───────────────────┘         └───────────────────┘
```

---

## 📋 Detail Role

### 1. SUPERADMIN
**Deskripsi:** Pemilik atau manager dengan akses penuh ke semua fitur sistem.

| Module | Permission |
|--------|------------|
| Dashboard | ✅ View semua data |
| POS | ✅ Full access |
| Activity | ✅ Full access + void/delete order |
| Report | ✅ Full access + export |
| Inventory | ✅ Full CRUD |
| Teams | ✅ Full CRUD + role assignment |
| Settings | ✅ Full access |

---

### 2. STAFF FULL TIME
**Deskripsi:** Kasir senior/tetap dengan akses operasional lengkap namun tidak bisa manage staf dan settings kritis.

| Module | Permission |
|--------|------------|
| Dashboard | ✅ View |
| POS | ✅ Full access |
| Activity | ✅ View + update status |
| Report | ✅ View (tidak bisa export) |
| Inventory | ✅ View only |
| Teams | ❌ No access |
| Settings | ⚠️ Limited (printer only) |

---

### 3. STAFF PART TIME
**Deskripsi:** Kasir part-time dengan akses paling terbatas, fokus pada transaksi.

| Module | Permission |
|--------|------------|
| Dashboard | ⚠️ Limited (stats hari ini saja) |
| POS | ✅ Full access |
| Activity | ⚠️ View own orders only |
| Report | ❌ No access |
| Inventory | ❌ No access |
| Teams | ❌ No access |
| Settings | ❌ No access |

---

## 🔐 Permission Matrix

| Permission | Superadmin | Full Time | Part Time |
|------------|------------|-----------|-----------|
| **POS** ||||
| Create order | ✅ | ✅ | ✅ |
| Apply discount | ✅ | ✅ | ❌ |
| Apply promo | ✅ | ✅ | ✅ |
| Void order | ✅ | ⚠️ Pending | ❌ |
| Edit order | ✅ | ✅ | ⚠️ Own only |
| **ACTIVITY** ||||
| View all orders | ✅ | ✅ | ❌ |
| View own orders | ✅ | ✅ | ✅ |
| Update status | ✅ | ✅ | ✅ |
| Delete order | ✅ | ❌ | ❌ |
| **REPORT** ||||
| View reports | ✅ | ✅ | ❌ |
| Export reports | ✅ | ❌ | ❌ |
| **INVENTORY** ||||
| View products | ✅ | ✅ | ❌ |
| Create product | ✅ | ❌ | ❌ |
| Edit product | ✅ | ❌ | ❌ |
| Delete product | ✅ | ❌ | ❌ |
| **TEAMS** ||||
| View staff | ✅ | ❌ | ❌ |
| Manage staff | ✅ | ❌ | ❌ |
| **SETTINGS** ||||
| Store settings | ✅ | ❌ | ❌ |
| Tax settings | ✅ | ❌ | ❌ |
| Printer settings | ✅ | ✅ | ❌ |
| Table settings | ✅ | ❌ | ❌ |

---

## 🛡 Implementation dengan Spatie Permission

### Roles
```php
// database/seeders/RoleSeeder.php
$roles = [
    'superadmin',
    'staff-fulltime',
    'staff-parttime',
];
```

### Permissions
```php
// database/seeders/PermissionSeeder.php
$permissions = [
    // POS
    'pos.access',
    'pos.apply-discount',
    'pos.apply-promo',
    'pos.void-order',
    'pos.edit-all-orders',
    
    // Activity
    'activity.view-all',
    'activity.view-own',
    'activity.update-status',
    'activity.delete',
    
    // Report
    'report.view',
    'report.export',
    
    // Inventory
    'inventory.view',
    'inventory.create',
    'inventory.edit',
    'inventory.delete',
    
    // Teams
    'teams.view',
    'teams.manage',
    
    // Settings
    'settings.store',
    'settings.tax',
    'settings.printer',
    'settings.tables',
];
```

### Role-Permission Assignment
```php
// Superadmin - semua permission
$superadmin->givePermissionTo(Permission::all());

// Staff Full Time
$fulltime->givePermissionTo([
    'pos.access',
    'pos.apply-discount',
    'pos.apply-promo',
    'pos.edit-all-orders',
    'activity.view-all',
    'activity.update-status',
    'report.view',
    'inventory.view',
    'settings.printer',
]);

// Staff Part Time
$parttime->givePermissionTo([
    'pos.access',
    'pos.apply-promo',
    'activity.view-own',
    'activity.update-status',
]);
```

---

## 🔒 Middleware Protection

```php
// routes/web.php atau routes/admin.php

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('teams', TeamController::class);
    Route::get('settings/store', [SettingsController::class, 'store']);
});

Route::middleware(['auth', 'permission:report.view'])->group(function () {
    Route::get('reports', [ReportController::class, 'index']);
});

Route::middleware(['auth', 'permission:pos.access'])->group(function () {
    Route::get('pos', PosController::class);
});
```
