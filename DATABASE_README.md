# Dokumentasi Database Schema - Sistem Pengaduan

## 📊 Entity Relationship Diagram (ERD)

### Struktur Tabel

#### 1. **users** (Tabel Pengguna)
| Column | Type | Constraint | Description |
|--------|------|-----------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY | ID unik pengguna |
| name | VARCHAR(255) | NOT NULL | Nama lengkap |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email pengguna |
| email_verified_at | TIMESTAMP | NULL | Waktu verifikasi email |
| password | VARCHAR(255) | NOT NULL | Password (hashed) |
| nis | VARCHAR(20) | NULL | Nomor Induk Siswa |
| kelas | VARCHAR(50) | NULL | Kelas siswa |
| is_admin | BOOLEAN | DEFAULT FALSE | Status admin |
| remember_token | VARCHAR(100) | NULL | Token remember me |
| created_at | TIMESTAMP | NULL | Tanggal dibuat |
| updated_at | TIMESTAMP | NULL | Tanggal diupdate |

#### 2. **kategoris** (Tabel Kategori Pengaduan)
| Column | Type | Constraint | Description |
|--------|------|-----------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY | ID unik kategori |
| nama | VARCHAR(45) | UNIQUE, NOT NULL | Nama kategori |
| created_at | TIMESTAMP | NULL | Tanggal dibuat |
| updated_at | TIMESTAMP | NULL | Tanggal diupdate |

#### 3. **pengaduans** (Tabel Pengaduan)
| Column | Type | Constraint | Description |
|--------|------|-----------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY | ID unik pengaduan |
| user_id | BIGINT UNSIGNED | FK → users(id), NOT NULL | ID pembuat pengaduan |
| kategori_id | BIGINT UNSIGNED | FK → kategoris(id), NOT NULL | ID kategori |
| tanggal | DATETIME | NOT NULL | Tanggal pengaduan |
| lokasi | VARCHAR(45) | NOT NULL | Lokasi kejadian |
| keterangan | TEXT | NOT NULL | Deskripsi pengaduan |
| foto | VARCHAR(255) | NULL | Path foto bukti |
| status | ENUM | DEFAULT 'Menunggu' | Status: Menunggu/Proses/Selesai |
| created_at | TIMESTAMP | NULL | Tanggal dibuat |
| updated_at | TIMESTAMP | NULL | Tanggal diupdate |

#### 4. **feedback** (Tabel Feedback)
| Column | Type | Constraint | Description |
|--------|------|-----------|-------------|
| id | BIGINT UNSIGNED | PRIMARY KEY | ID unik feedback |
| pengaduan_id | BIGINT UNSIGNED | FK → pengaduans(id), NOT NULL | ID pengaduan |
| user_id | BIGINT UNSIGNED | FK → users(id), NOT NULL | ID pemberi feedback (Admin) |
| tanggal | DATETIME | NOT NULL | Tanggal feedback |
| isi | TEXT | NOT NULL | Isi feedback |
| created_at | TIMESTAMP | NULL | Tanggal dibuat |
| updated_at | TIMESTAMP | NULL | Tanggal diupdate |

---

## 🔗 Relasi Antar Tabel

```
┌─────────────┐
│   users     │
│  (Pengguna) │
└──────┬──────┘
       │
       │ 1
       │
       ├─────────────┐
       │             │
       │ N           │ N
       │             │
┌──────▼──────┐ ┌───▼────────┐
│ pengaduans  │ │  feedback  │
│ (Pengaduan) │ │ (Feedback) │
└──────┬──────┘ └───▲────────┘
       │            │
       │ N          │ 1
       │            │
       │     ┌──────┴────────┐
       │     │               │
       │ 1   │ N             │
       │     │               │
┌──────▼─────┴──┐            │
│   kategoris   │            │
│  (Kategori)   │            │
└───────────────┘            │
                             │
    (pengaduans) ────────────┘
         1 : N
```

### Penjelasan Relasi:

1. **users → pengaduans** (One to Many)
   - Satu user dapat membuat banyak pengaduan
   - FK: `pengaduans.user_id` → `users.id`
   - ON DELETE CASCADE

2. **kategoris → pengaduans** (One to Many)
   - Satu kategori dapat memiliki banyak pengaduan
   - FK: `pengaduans.kategori_id` → `kategoris.id`
   - ON DELETE CASCADE

3. **pengaduans → feedback** (One to Many)
   - Satu pengaduan dapat memiliki banyak feedback
   - FK: `feedback.pengaduan_id` → `pengaduans.id`
   - ON DELETE CASCADE

4. **users → feedback** (One to Many)
   - Satu user (admin) dapat memberikan banyak feedback
   - FK: `feedback.user_id` → `users.id`
   - ON DELETE CASCADE

---

## 📝 Catatan Penting

### Constraint CASCADE DELETE:
- Jika user dihapus → semua pengaduan dan feedback miliknya ikut terhapus
- Jika kategori dihapus → semua pengaduan dengan kategori tersebut ikut terhapus
- Jika pengaduan dihapus → semua feedback untuk pengaduan tersebut ikut terhapus

### Status Pengaduan:
- **Menunggu**: Pengaduan baru, belum ditangani
- **Proses**: Sedang dalam penanganan admin
- **Selesai**: Pengaduan telah diselesaikan

### Role User:
- **is_admin = false**: User biasa (Siswa)
  - Dapat membuat pengaduan
  - Dapat melihat dan mengelola pengaduan sendiri

- **is_admin = true**: Admin
  - Dapat melihat semua pengaduan
  - Dapat mengubah status pengaduan
  - Dapat memberikan feedback
  - Dapat mengelola kategori

---

## 🛠️ Cara Menggunakan SQL Schema

1. **Untuk membuat ERD di tools seperti:**
   - draw.io / diagrams.net
   - dbdiagram.io
   - MySQL Workbench
   - DBeaver
   - Lucidchart

2. **Import file:** `database_schema.sql`

3. **Atau copy-paste SQL ke ERD generator online:**
   - https://dbdiagram.io (Recommended)
   - https://app.quickdatabasediagrams.com/

---

## 📦 Indexes

Untuk performa yang lebih baik, indexes sudah ditambahkan pada:
- `pengaduans.user_id`
- `pengaduans.kategori_id`
- `pengaduans.status`
- `feedback.pengaduan_id`
- `feedback.user_id`
