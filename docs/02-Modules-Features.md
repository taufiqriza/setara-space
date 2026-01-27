# 02. Modules & Features

## 📦 Daftar Modul

---

## 1. 🏠 Dashboard

| Fitur | Deskripsi | Priority |
|-------|-----------|----------|
| Summary Cards | Total penjualan hari ini, pesanan, produk terlaris | MVP |
| Quick Stats | Grafik penjualan 7 hari terakhir | MVP |
| Recent Orders | 5 pesanan terakhir | MVP |
| Low Stock Alert | Produk dengan stok rendah | Next |

---

## 2. 💳 Point of Sales (Kasir)

### 2.1 Header Bar
| Komponen | Deskripsi |
|----------|-----------|
| Menu Toggle | Buka/tutup sidebar |
| Date Display | Tanggal hari ini |
| Time Display | Jam real-time |
| Order Status | "Open Order" / "Close Order" indicator |
| Refresh | Reload halaman |

### 2.2 Product Grid (Left Panel)
| Fitur | Deskripsi | Priority |
|-------|-----------|----------|
| Category Tabs | Tab kategori dengan icon (All Menu, Dimsum Original, Dimsum Keju, dll) | MVP |
| Search Bar | Pencarian produk by nama | MVP |
| Product Cards | Grid produk dengan gambar, nama, kategori badge, harga | MVP |
| Product Modal | Detail produk, deskripsi, notes, quantity picker, add to cart | MVP |

### 2.3 Order Panel (Right Panel)
| Fitur | Deskripsi | Priority |
|-------|-----------|----------|
| Customer Name | Input nama pelanggan (editable) | MVP |
| Order Number | Auto-generated (#001, #002, dst) | MVP |
| Table Select | Dropdown pilih meja (untuk Dine In) | MVP |
| Order Type | Dropdown: Dine In / Take Away | MVP |
| Order Items | List item dengan gambar, nama, harga, qty +/-, notes icon | MVP |
| Subtotal | Kalkulasi subtotal | MVP |
| Tax | Pajak (configurable %) | MVP |
| Discount | Diskon (manual atau dari promo) | Next |
| Promo/Voucher | Input kode promo | Next |
| Total | Grand total | MVP |
| Payment Method | Button pilih metode (Cash, QRIS, E-Wallet) | MVP |
| Place Order | Button submit order | MVP |

### 2.4 Track Order Bar (Bottom)
| Fitur | Deskripsi | Priority |
|-------|-----------|----------|
| Order Cards | Horizontal scroll cards dengan nama, table, type, waktu | MVP |
| Status Badge | On Kitchen Hand, All Done, To be Served | MVP |

---

## 3. 📋 Activity (Pesanan)

### 3.1 Billing Queue
| Fitur | Deskripsi | Priority |
|-------|-----------|----------|
| Search | Cari pesanan by nama/nomor | MVP |
| Filter Tabs | All, Active, Closed | MVP |
| Order List | Nama, nomor order, table, datetime, amount, status badge | MVP |
| Active Queue Counter | "4 Active Queue" badge | MVP |

### 3.2 Tables
| Fitur | Deskripsi | Priority |
|-------|-----------|----------|
| Table Grid | Visual layout meja | Next |
| Table Status | Available, Occupied, Reserved | Next |
| Quick Assign | Assign order ke meja | Next |

### 3.3 Order History
| Fitur | Deskripsi | Priority |
|-------|-----------|----------|
| Date Filter | Filter by range tanggal | MVP |
| Export | Export to PDF/Excel | Next |
| Detail View | Lihat detail transaksi lengkap | MVP |

### 3.4 Track Order Panel
| Fitur | Deskripsi | Priority |
|-------|-----------|----------|
| Order Cards | Horizontal scroll dengan detail item | MVP |
| Status Update | Update status pesanan | MVP |
| See More | Expand detail item | MVP |

---

## 4. 📊 Report (Laporan)

| Report Type | Deskripsi | Priority |
|-------------|-----------|----------|
| Daily Sales | Penjualan per hari | MVP |
| Product Sales | Penjualan per produk | MVP |
| Staff Sales | Penjualan per kasir | Next |
| Payment Method | Breakdown per metode bayar | MVP |
| Hourly Sales | Penjualan per jam (peak hours) | Next |
| Monthly Summary | Rangkuman bulanan | MVP |

---

## 5. 📦 Inventory (Produk)

### 5.1 Categories
| Fitur | Deskripsi | Priority |
|-------|-----------|----------|
| CRUD Category | Tambah, edit, hapus kategori | MVP |
| Icon Picker | Pilih icon untuk kategori | Next |
| Sort Order | Urutan tampil di POS | MVP |

### 5.2 Products
| Fitur | Deskripsi | Priority |
|-------|-----------|----------|
| CRUD Product | Tambah, edit, hapus produk | MVP |
| Image Upload | Upload gambar produk | MVP |
| Price | Harga jual | MVP |
| Description | Deskripsi produk | MVP |
| Status | Active/Inactive | MVP |
| Stock Tracking | Kelola stok (opsional) | Next |

---

## 6. 👥 Teams (Staf)

| Fitur | Deskripsi | Priority |
|-------|-----------|----------|
| CRUD Staff | Tambah, edit, hapus staf | MVP |
| Role Assignment | Assign role ke staf | MVP |
| Status | Active/Inactive | MVP |
| Employment Type | Full Time / Part Time | MVP |
| Login Credentials | Email & password | MVP |
| Shift Schedule | Jadwal shift | Next |

---

## 7. ⚙️ Settings

| Fitur | Deskripsi | Priority |
|-------|-----------|----------|
| Store Profile | Nama toko, alamat, logo | MVP |
| Tax Settings | Pajak % | MVP |
| Service Charge | Biaya layanan (opsional) | Next |
| Printer Config | IP/USB printer, paper size | MVP |
| Table Management | CRUD meja | MVP |
| Receipt Template | Kustomisasi struk | Next |
| Promo/Voucher | Kelola promo | Next |

---

## 8. 🔐 Authentication

| Fitur | Deskripsi | Priority |
|-------|-----------|----------|
| Login | Login dengan email/password | MVP |
| Logout | Logout + clear session | MVP |
| Session Lock | Auto-lock setelah idle | Next |
| PIN Login | Quick PIN untuk switch kasir | Next |
