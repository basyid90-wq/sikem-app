# SiKEM Database Schema & Development Phases (ERD)
> MAIN REFERENCE FILE FOR AI AGENT. ALWAYS AUTO-UPDATE THIS FILE IF DATABASE CHANGES ARE MADE IN CHAT.

## Project Overview
- **Name:** SiKEM (Sistem Integrasi Kebajikan Mualaf)
- **Stack:** Laravel 13, TALL Stack (Livewire 3, Alpine, Tailwind), TailAdmin UI.
- **Roles (RBAC):** `super_admin`, `kudd`, `mubaligh`, `guru_apim`, `mualaf`.

---

## Development Phases (Strict Order)
- **Phase 1:** Core Setup (Laravel install, DB connection, TailAdmin UI integration, Spatie Roles/Permissions setup, Super Admin Seeder).
- **Phase 2:** Directory & Master Data (`Kariah` mapping, `Mualaf` profile CRUD, Excel Import for Mualaf Data from JAKIM).
- **Phase 3:** APIM Education Module (`Kelas` creation, physical/online link generation, `Kehadiran` tracking).
- **Phase 4:** Emergency & Death Management (`Kematian` reporting, File uploads for PDF/Proofs, Document Auto-Generation).
- **Phase 5:** Financials & Welfare (`Tuntutan` for Khairat Kematian and APIM RM10 allowances, Dashboard Reporting).

---

## Entity Relationship Diagram (Tables)

### 1. `users`
| Column | Type | Modifiers | Notes |
| :--- | :--- | :--- | :--- |
| id | bigint | PK | |
| name | string | | |
| email | string | unique | |
| password | string | | |
| kariah_id | bigint | FK, nullable | Links to `kariahs.id` (For AJK/Imam) |
| mualaf_id | bigint | FK, nullable | Links to `mualafs.id` (If user is a Mualaf) |
| timestamps | | | |
*Note: Roles and permissions handled via Spatie/Laravel-Permission.*

### 2. `kariahs` (Direktori Masjid/Surau)
| Column | Type | Modifiers | Notes |
| :--- | :--- | :--- | :--- |
| id | bigint | PK | |
| nama_kariah | string | | e.g., Masjid Jamek Beruas |
| zon_daerah | string | | e.g., Manjung |
| alamat | text | nullable | |
| nama_ajk | string | nullable | Contact person |
| no_telefon | string | nullable | For WhatsApp Notification API later |
| timestamps | | | |

### 3. `mualafs` (Profil Master)
| Column | Type | Modifiers | Notes |
| :--- | :--- | :--- | :--- |
| id | bigint | PK | |
| nama_penuh | string | | |
| no_ic | string | unique | |
| no_kad_mualaf | string | unique, nullable | |
| tarikh_syahadah | date | nullable | |
| kariah_id | bigint | FK, nullable | Links to `kariahs.id` |
| status_khairat | boolean | default(false) | true=Ahli Khairat, false=Bukan Ahli |
| alamat_terkini | text | nullable | |
| waris_islam_nama | string | nullable | |
| waris_islam_tel | string | nullable | |
| waris_non_nama | string | nullable | |
| waris_non_tel | string | nullable | |
| sijil_islam_path | string | nullable | Encrypted local storage / S3 path |
| kad_mualaf_path | string | nullable | Encrypted local storage / S3 path |
| timestamps | | | |

### 4. `kelas_apim` (Modul Pendidikan)
| Column | Type | Modifiers | Notes |
| :--- | :--- | :--- | :--- |
| id | bigint | PK | |
| guru_id | bigint | FK | Links to `users.id` (Role: guru_apim) |
| tajuk_kelas | string | | |
| mod_kelas | enum | | ['fizikal', 'online'] |
| pautan_online | string | nullable | Google Meet link / Self-check-in link |
| masa_mula | datetime | | |
| masa_tamat | datetime | | |
| status | enum | default('aktif') | ['aktif', 'selesai', 'batal'] |
| timestamps | | | |

### 5. `kehadiran_apim`
| Column | Type | Modifiers | Notes |
| :--- | :--- | :--- | :--- |
| id | bigint | PK | |
| kelas_id | bigint | FK | Links to `kelas_apim.id` |
| mualaf_id | bigint | FK | Links to `mualafs.id` |
| status_hadir | boolean | default(false) | |
| waktu_rekod | datetime | nullable | |
| timestamps | | | |

### 6. `kematians` (Modul Pengurusan Jenazah)
| Column | Type | Modifiers | Notes |
| :--- | :--- | :--- | :--- |
| id | bigint | PK | |
| mualaf_id | bigint | FK | Links to `mualafs.id` |
| pelapor_id | bigint | FK, nullable | Links to `users.id` |
| tarikh_mati | date | | |
| lokasi_mati | string | | e.g., Hospital Seri Manjung |
| status_tuntutan_non| boolean | default(false) | true if non-Muslim family intervenes |
| status_kes | enum | default('baru') | ['baru', 'dalam_proses', 'selesai'] |
| nota_log | text | nullable | Actions taken, negotiations |
| polis_report_path | string | nullable | Proof of police report |
| surat_wakil_path | string | nullable | Auto-generated authorization letter |
| kariah_dimaklumkan | boolean | default(false) | Status if Kariah has been notified |
| timestamps | | | |

### 7. `tuntutans` (Modul Kewangan/Bantuan)
| Column | Type | Modifiers | Notes |
| :--- | :--- | :--- | :--- |
| id | bigint | PK | |
| jenis_tuntutan | enum | | ['khairat_kematian', 'elaun_kelas'] |
| reference_id | bigint | nullable | Links to `kematians.id` OR `kelas_apim.id` |
| pemohon_id | bigint | FK | Links to `users.id` (Kariah / Guru APIM) |
| jumlah_tuntutan | decimal | 8,2 | e.g., 80.00 for 8 classes attended |
| status_tuntutan | enum | default('pending')| ['pending', 'lulus_kudd', 'selesai_maipk'] |
| resit_path | string | nullable | Invoice from Kariah for death management |
| timestamps | | | |

---
## Relationships Summary
- `User` hasMany `Kematian` (as pelapor)
- `User` hasMany `KelasApim` (as guru)
- `Kariah` hasMany `Mualaf`
- `Kariah` hasMany `User` (AJK accounts)
- `Mualaf` hasOne `User` (Optional login account)
- `Mualaf` hasMany `Kematian`
- `Mualaf` hasMany `KehadiranApim`
- `KelasApim` hasMany `KehadiranApim`
- `Kematian` hasMany `Tuntutan`