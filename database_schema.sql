-- ============================================
-- Database Schema for Sistem Pengaduan
-- Generated: February 11, 2026
-- ============================================

-- Table: users
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    nis VARCHAR(20) NULL,
    kelas VARCHAR(50) NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: kategoris
CREATE TABLE kategoris (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(45) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: pengaduans
CREATE TABLE pengaduans (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    kategori_id BIGINT UNSIGNED NOT NULL,
    tanggal DATETIME NOT NULL,
    lokasi VARCHAR(45) NOT NULL,
    keterangan TEXT NOT NULL,
    foto VARCHAR(255) NULL,
    status ENUM('Menunggu', 'Proses', 'Selesai') DEFAULT 'Menunggu',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (kategori_id) REFERENCES kategoris(id) ON DELETE CASCADE
);

-- Table: feedback
CREATE TABLE feedback (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pengaduan_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    tanggal DATETIME NOT NULL,
    isi TEXT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (pengaduan_id) REFERENCES pengaduans(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ============================================
-- Indexes for better performance
-- ============================================

CREATE INDEX idx_pengaduans_user_id ON pengaduans(user_id);
CREATE INDEX idx_pengaduans_kategori_id ON pengaduans(kategori_id);
CREATE INDEX idx_pengaduans_status ON pengaduans(status);
CREATE INDEX idx_feedback_pengaduan_id ON feedback(pengaduan_id);
CREATE INDEX idx_feedback_user_id ON feedback(user_id);

-- ============================================
-- Relationships Summary for ERD:
-- ============================================
-- 1. users (1) ---> (N) pengaduans
-- 2. users (1) ---> (N) feedback
-- 3. kategoris (1) ---> (N) pengaduans
-- 4. pengaduans (1) ---> (N) feedback
