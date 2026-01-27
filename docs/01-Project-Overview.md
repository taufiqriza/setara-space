# 01. Project Overview

## 🎯 Tujuan Project

Membangun sistem Point of Sale (POS) untuk **Setara Space**, bisnis dimsum homemade di Yogyakarta. Sistem ini akan membantu operasional harian kasir, manajemen produk, pelacakan pesanan, dan pelaporan.

---

## 📋 Fitur Utama

### 1. **Point of Sales (Kasir)**
- Grid produk dengan kategori dan search
- Panel order dengan item, quantity, dan notes
- Pilihan tipe order: Dine In / Take Away
- Pilihan meja untuk Dine In
- Promo/voucher support
- Multiple payment method (Cash, QRIS, E-Wallet)
- Cetak struk thermal

### 2. **Activity (Pesanan)**
- Billing Queue - antrian tagihan aktif
- Tables - manajemen meja
- Order History - riwayat pesanan
- Track Order - status pesanan real-time

### 3. **Report (Laporan)**
- Laporan penjualan harian/mingguan/bulanan
- Laporan per produk
- Laporan per kasir/staf
- Laporan per metode pembayaran

### 4. **Inventory (Produk)**
- Manajemen kategori produk
- CRUD produk dengan gambar
- Harga dan status ketersediaan
- Stok (opsional untuk dimsum)

### 5. **Teams (Staf)**
- Manajemen user staf
- Role assignment (Superadmin, Full Time, Part Time)
- Jadwal shift (next phase)

### 6. **Settings (Pengaturan)**
- Profil toko
- Pajak dan biaya layanan
- Printer setting
- Manajemen meja

---

## 🏗 Arsitektur

```
┌─────────────────────────────────────────────────────────┐
│                    PRESENTATION LAYER                    │
│  ┌─────────────────┐  ┌─────────────────┐               │
│  │   Blade Views   │  │   Livewire      │               │
│  │   + Alpine.js   │  │   Components    │               │
│  └─────────────────┘  └─────────────────┘               │
├─────────────────────────────────────────────────────────┤
│                    APPLICATION LAYER                     │
│  ┌─────────────────┐  ┌─────────────────┐               │
│  │   Controllers   │  │   Services      │               │
│  │                 │  │   (Business)    │               │
│  └─────────────────┘  └─────────────────┘               │
├─────────────────────────────────────────────────────────┤
│                     DOMAIN LAYER                         │
│  ┌─────────────────┐  ┌─────────────────┐               │
│  │   Models        │  │   Policies      │               │
│  │   (Eloquent)    │  │   (Permission)  │               │
│  └─────────────────┘  └─────────────────┘               │
├─────────────────────────────────────────────────────────┤
│                  INFRASTRUCTURE LAYER                    │
│  ┌─────────────────┐  ┌─────────────────┐               │
│  │   MySQL DB      │  │   File Storage  │               │
│  └─────────────────┘  └─────────────────┘               │
└─────────────────────────────────────────────────────────┘
```

---

## 🔧 Tech Stack Detail

| Layer | Technology | Version |
|-------|------------|---------|
| Backend | Laravel | 11.x |
| Realtime | Livewire | 3.x |
| Styling | TailwindCSS | 3.x |
| Interactivity | Alpine.js | 3.x |
| Icons | Font Awesome | 6.x |
| Database | MySQL | 8.0 |
| Auth | Laravel Breeze/Fortify | - |
| Permission | Spatie Permission | 6.x |

---

## 📱 Responsive Breakpoints

| Device | Breakpoint | Priority |
|--------|------------|----------|
| Mobile | < 640px | Secondary |
| Tablet | 640px - 1024px | **Primary** |
| Desktop | > 1024px | Tertiary |

---

## 📁 Folder Structure (Planned)

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Admin/           # Admin controllers
│   └── Middleware/
├── Livewire/
│   ├── Pos/                 # POS components
│   ├── Activity/            # Order tracking
│   ├── Report/              # Reports
│   ├── Inventory/           # Products
│   ├── Teams/               # Staff management
│   └── Settings/            # App settings
├── Models/
├── Services/
└── Policies/

resources/
├── views/
│   ├── admin/
│   │   └── layouts/
│   ├── livewire/
│   │   ├── pos/
│   │   ├── activity/
│   │   ├── report/
│   │   ├── inventory/
│   │   ├── teams/
│   │   └── settings/
│   └── components/
└── css/
```
