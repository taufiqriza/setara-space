# 07. MVP Roadmap & Prioritization

## 📊 Priority Matrix

```
                    HIGH BUSINESS VALUE
                           ▲
                           │
    ┌──────────────────────┼──────────────────────┐
    │                      │                      │
    │   QUICK WINS         │   MAJOR FEATURES     │
    │   (Do First)         │   (MVP Core)         │
    │                      │                      │
    │   • Login/Auth       │   • POS Interface    │
    │   • Basic Dashboard  │   • Order Panel      │
LOW ├──────────────────────┼──────────────────────┤ HIGH
EFFORT│                      │                      │ EFFORT
    │   FILL-INS           │   BIG BETS           │
    │   (Nice to Have)     │   (Phase 2+)         │
    │                      │                      │
    │   • Status badges    │   • Inventory Mgmt   │
    │   • Export PDF       │   • Analytics        │
    │                      │                      │
    └──────────────────────┼──────────────────────┘
                           │
                           ▼
                    LOW BUSINESS VALUE
```

---

## 🎯 Phase 1: MVP (2-3 Minggu)

> **Goal:** Kasir bisa melakukan transaksi lengkap dari awal sampai cetak struk

### Week 1: Foundation
| Task | Complexity | Priority |
|------|------------|----------|
| Setup Laravel + Livewire 3 | Medium | 🔴 Critical |
| Database migrations | Medium | 🔴 Critical |
| Auth system (Login/Logout) | Low | 🔴 Critical |
| Role & Permission setup | Medium | 🔴 Critical |
| Admin layout + SPA navigation | Medium | 🔴 Critical |

### Week 2: Core POS
| Task | Complexity | Priority |
|------|------------|----------|
| Product Categories CRUD | Low | 🔴 Critical |
| Products CRUD | Medium | 🔴 Critical |
| POS Interface - Product Grid | High | 🔴 Critical |
| POS Interface - Order Panel | High | 🔴 Critical |
| Add to Cart + Quantity | Medium | 🔴 Critical |

### Week 3: Transaction Flow
| Task | Complexity | Priority |
|------|------------|----------|
| Order calculation (subtotal, tax, total) | Medium | 🔴 Critical |
| Payment method selection | Low | 🔴 Critical |
| Place Order (save to DB) | Medium | 🔴 Critical |
| Order list (Activity) | Medium | 🔴 Critical |
| Print receipt (basic) | Medium | 🟡 Important |

### MVP Deliverables Checklist
- [ ] Login/Logout functional
- [ ] Dashboard dengan basic stats
- [ ] CRUD Categories
- [ ] CRUD Products dengan image
- [ ] POS: Browse & search products
- [ ] POS: Add items to cart
- [ ] POS: Adjust quantity
- [ ] POS: Calculate totals dengan tax
- [ ] POS: Select payment method
- [ ] POS: Place order
- [ ] Activity: List orders dengan status
- [ ] Basic receipt print

---

## 🚀 Phase 2: Enhancement (2 Minggu)

> **Goal:** Improve UX dan tambah fitur pendukung

### Week 4-5
| Task | Complexity | Priority |
|------|------------|----------|
| Track Order bar (bottom) | Medium | 🟡 Important |
| Order status update flow | Medium | 🟡 Important |
| Table management | Low | 🟡 Important |
| Customer name di order | Low | 🟡 Important |
| Product detail modal + notes | Medium | 🟡 Important |
| Staff management (basic) | Medium | 🟡 Important |
| Daily sales report | Medium | 🟡 Important |
| Settings: Store profile | Low | 🟡 Important |
| Settings: Tax configuration | Low | 🟡 Important |

### Phase 2 Deliverables
- [ ] Track Order carousel
- [ ] Status progression (On Kitchen → Done → Served)
- [ ] Table CRUD + assignment
- [ ] Add notes per item
- [ ] Staff CRUD dengan role
- [ ] Report: Daily sales summary
- [ ] Store settings functional

---

## 📈 Phase 3: Advanced Features (2-3 Minggu)

> **Goal:** Fitur tambahan untuk operasional lebih lengkap

| Task | Complexity | Priority |
|------|------------|----------|
| Promo/Voucher system | High | 🟢 Nice to Have |
| Discount manual | Medium | 🟢 Nice to Have |
| Order history dengan filter | Medium | 🟢 Nice to Have |
| Report: Per product | Medium | 🟢 Nice to Have |
| Report: Per staff | Medium | 🟢 Nice to Have |
| Report: Payment method breakdown | Low | 🟢 Nice to Have |
| Export to PDF/Excel | Medium | 🟢 Nice to Have |
| Receipt template customization | Medium | 🟢 Nice to Have |
| Void order dengan approval | Medium | 🟢 Nice to Have |

---

## 🔮 Future Enhancements (Backlog)

| Feature | Description | Complexity |
|---------|-------------|------------|
| Kitchen Display System | Layar khusus untuk dapur | High |
| Customer Queue System | Nomor antrian digital | Medium |
| Inventory/Stock Management | Tracking stok bahan | High |
| Shift Management | Jadwal shift staf | Medium |
| Multi-outlet Support | Support multiple toko | Very High |
| Loyalty Program | Poin pelanggan | High |
| Online Order Integration | Terima order GoFood | Very High |
| Split Bill | Bagi tagihan | Medium |
| Hold Order | Simpan order sementara | Low |
| PIN Quick Login | Login cepat dengan PIN | Low |
| Offline Mode | Transaksi tanpa internet | Very High |

---

## 💡 Recommended MVP Improvements untuk Dimsum

### Fitur Spesifik Dimsum:
1. **Paket/Bundle** - Jual paket isi 10, 20 pcs
2. **Level Pedas** - Pilihan level saat order
3. **Frozen/Fresh** - Bedakan produk fresh vs frozen
4. **Pre-order** - Untuk pesanan besar/catering
5. **WhatsApp Integration** - Kirim struk via WA

### Quick Wins:
1. **Fast Add** - Double tap untuk quick add ke cart
2. **Favorite Products** - Pin produk populer di atas
3. **Last Order** - Repeat order terakhir
4. **Calculator** - Built-in kalkulator kembalian

---

## 📅 Timeline Summary

```
┌─────────────────────────────────────────────────────────────────┐
│ WEEK 1    │ WEEK 2    │ WEEK 3    │ WEEK 4-5  │ WEEK 6-8  │
├───────────┼───────────┼───────────┼───────────┼───────────┤
│ Foundation│ Core POS  │ Payment   │ Enhancement│ Advanced  │
│ + Auth    │ Interface │ + Orders  │ Features  │ Features  │
├───────────┴───────────┴───────────┼───────────┴───────────┤
│         PHASE 1: MVP              │      PHASE 2 & 3      │
│         (Go Live Ready)           │    (Improvements)     │
└───────────────────────────────────┴───────────────────────┘
```

---

## ✅ Success Metrics

### MVP Success Criteria:
- [ ] Kasir bisa complete 1 transaksi dalam < 2 menit
- [ ] Sistem berjalan stabil 8 jam/hari
- [ ] Struk tercetak dengan benar
- [ ] Laporan harian akurat

### Post-MVP Goals:
- Rata-rata transaksi < 1.5 menit
- Zero downtime during operating hours
- Staff adoption rate > 95%
- Error rate < 1%
