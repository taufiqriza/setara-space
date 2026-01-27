# Setara Space POS System Documentation

> **"Satu Semesta Seribu Rasa"** - Sistem Point of Sale untuk Dimsum Homemade

## 📚 Daftar Dokumentasi

| Dokumen | Deskripsi |
|---------|-----------|
| [01-Project-Overview.md](./01-Project-Overview.md) | Ringkasan project, tech stack, dan arsitektur |
| [02-Modules-Features.md](./02-Modules-Features.md) | Detail modul dan fitur yang dibutuhkan |
| [03-User-Roles.md](./03-User-Roles.md) | Struktur role, permission, dan access control |
| [04-Database-Schema.md](./04-Database-Schema.md) | ERD dan struktur tabel/entitas |
| [05-Cashier-Workflow.md](./05-Cashier-Workflow.md) | Alur kerja kasir end-to-end |
| [06-UI-Components.md](./06-UI-Components.md) | Komponen UI dan design system |
| [07-MVP-Roadmap.md](./07-MVP-Roadmap.md) | Prioritas MVP vs fitur lanjutan |
| [08-Implementation-Plan.md](./08-Implementation-Plan.md) | Rencana implementasi teknis |

## 🛠 Tech Stack

- **Backend:** Laravel 11 + Livewire 3 (SPA-like experience)
- **Frontend:** Blade + TailwindCSS + Alpine.js
- **Navigation:** Wire:navigate (smooth page transitions)
- **Database:** MySQL 8.0
- **Print:** Thermal printer via ESC/POS
- **Payment:** QRIS, Cash, E-Wallet

> 💡 **SPA-like Experience:** Menggunakan Livewire 3 dengan `wire:navigate` untuk navigasi tanpa reload halaman, memberikan pengalaman smooth seperti aplikasi native.

## 🚀 Quick Start

```bash
# Clone & setup
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## 📱 Target Device

- **Primary:** Tablet (iPad/Android 10")
- **Secondary:** Mobile (responsive)
- **Tertiary:** Desktop browser

---

*Dokumentasi ini dibuat untuk project Setara Space POS System*
