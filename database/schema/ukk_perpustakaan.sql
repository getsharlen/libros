CREATE DATABASE IF NOT EXISTS libros_ukk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE libros_ukk;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'siswa') NOT NULL DEFAULT 'siswa',
    nis VARCHAR(30) UNIQUE,
    no_telp VARCHAR(20) NULL,
    alamat TEXT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

CREATE TABLE books (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_buku VARCHAR(30) NOT NULL UNIQUE,
    judul VARCHAR(255) NOT NULL,
    penulis VARCHAR(255) NOT NULL,
    penerbit VARCHAR(255) NULL,
    tahun_terbit YEAR NULL,
    isbn VARCHAR(20) UNIQUE,
    stok_total INT UNSIGNED NOT NULL DEFAULT 0,
    stok_tersedia INT UNSIGNED NOT NULL DEFAULT 0,
    lokasi_rak VARCHAR(50) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB;

CREATE TABLE peminjamans (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    book_id BIGINT UNSIGNED NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_jatuh_tempo DATE NOT NULL,
    status ENUM('dipinjam', 'dikembalikan', 'terlambat') NOT NULL DEFAULT 'dipinjam',
    catatan TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_peminjamans_user_status (user_id, status),
    CONSTRAINT fk_peminjamans_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_peminjamans_book FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE pengembalians (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    peminjaman_id BIGINT UNSIGNED NOT NULL UNIQUE,
    processed_by BIGINT UNSIGNED NULL,
    tanggal_kembali DATE NOT NULL,
    denda DECIMAL(12,2) NOT NULL DEFAULT 0,
    catatan_kondisi TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_pengembalians_peminjaman FOREIGN KEY (peminjaman_id) REFERENCES peminjamans(id) ON DELETE CASCADE,
    CONSTRAINT fk_pengembalians_user FOREIGN KEY (processed_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO users (name, email, password, role, nis, no_telp, alamat, created_at, updated_at)
VALUES
('Admin Perpustakaan', 'admin@libros.test', '$2y$12$5d5hjK9o8c8haN6pl8nYxODPZAjM3NqcL2Gm6iVLWIoB7vT9nArZO', 'admin', NULL, '081200000001', 'Ruang Tata Usaha', NOW(), NOW()),
('Siswa Contoh', 'siswa@libros.test', '$2y$12$8Gxq06x2y2LQnA2xA44tD.8hLecIYfYzG7nZsI5LQ4nVwQf0M2jLi', 'siswa', 'NIS-001', '081200000002', 'Kelas XII RPL', NOW(), NOW());
