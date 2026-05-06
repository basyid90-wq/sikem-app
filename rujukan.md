# Sistem Arahan Induk — SiKEM (Vibe Coding)

## 1. Konteks & Peranan Ejen
- **Projek:** SiKEM — Sistem Integrasi Kebajikan Mualaf
- **Tech Stack:** Laravel 12, TALL Stack (Tailwind, Alpine.js, Livewire), template TailAdmin
- **Mod:** Vibe Coding Full Auto — Code → Test → Fix → Commit → Push → VPS deploy
- **Akses Seeder:**
  - Super Admin: `basyid90@gmail.com` / `901022aspura`

---

## 2. Gaya Komunikasi
- Ringkas, teknikal, zero fluff.
- Arahan dalam campuran Bahasa Inggeris dan loghat Melayu Utara — ikut je.
- **PANTANG:** Dilarang guna terma Indonesia (*bikin, perbarui, unduh, penerapan*). Guna terma Malaysia atau Inggeris terus.

---

## 3. Peraturan Operasi

| ✅ Buat | ❌ Jangan |
|--------|----------|
| Kerja berfasa — jangan output beratus baris sekaligus | Reka struktur DB di luar `sikem_erd.md` |
| Tanya selepas tiap fasa: *"Fasa selesai. Teruskan?"* | Syarah panjang — fokus kod & terminal |
| Guna komponen TailAdmin yang sedia ada | Reka UI custom kalau TailAdmin dah ada |
| Kemaskini `sikem_erd.md` bila ada perubahan DB | Tinggal `dd()`, `dump()`, `console.log()` dalam kod |

---

## 4. Dokumentasi Dinamik
- Rujuk `sikem_erd.md` setiap kali ada perubahan DB atau logik.
- Kemaskini `sikem_erd.md` serta-merta bila tambah/ubah jadual atau fungsi.

---

## 5. Aliran Kerja Full Auto

### Fasa A — Code & Fix
- Tulis logik, controller, model, komponen ikut arahan.
- Bila ada error log, kaji merentas fail dan betulkan terus.

### Fasa B — Test (Pest PHP)
- Tulis test Pest PHP untuk logik kritikal.
- Abaikan browser test (Dusk). Jalankan auto di terminal. Gagal → betul → ulang.

### Fasa C — Commit & Push (Auto — AI buat, bukan user)
```bash
git add <fail-yang-berubah>
git commit -m "type: ringkasan perubahan"
git push origin main
```
> Jika repo belum wujud: `gh repo create sikem --private --source=. --remote=origin --push`

### Fasa D — Deploy (VPS)
Selepas push, **beritahu user jalankan arahan ini di VPS:**

```bash
# Wajib setiap kali
git pull origin main
php artisan migrate --force
php artisan config:cache && php artisan view:clear && php artisan cache:clear

# Jika ada route baru
php artisan route:clear && php artisan route:cache

# Jika ada class Tailwind baru
npm run build
```

---

## 6. Maklumat VPS

| Perkara | Nilai |
|---------|-------|
| IP | `103.175.50.99` |
| SSH | `ssh -p 58882 root@103.175.50.99` |
| Folder projek | `/var/www/sikem.my` |
| Web server | Nginx (`/etc/nginx/sites-available/sikem.my`) |
| PHP | 8.4 (`php8.4-fpm`) |
| Database | `tailadmin_laravel` (MySQL) |
| Domain | `https://sikem.my` |

---

## 7. Nota Penting
- `public/build/` adalah gitignored — Tailwind **tidak** di-build otomatik di VPS. Guna `npm run build` bila ada class baru.
- Fail `.env` VPS **tidak** dalam git — urus secara manual di VPS.
- Nginx dan php8.4-fpm mesti running. Semak: `systemctl status nginx php8.4-fpm`
