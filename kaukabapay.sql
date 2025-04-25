-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 25 Apr 2025 pada 22.18
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kaukabapay`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` enum('bendahara','kepala sekolah') NOT NULL,
  `user_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`nip`, `nama`, `jabatan`, `user_id`) VALUES
('NIP001', 'Nama Kepala Sekolah', 'kepala sekolah', 'ad19f6b6-1ed4-11f0-a19b-3822e22e3cc1'),
('NIP002', 'Nama Bendahara', 'bendahara', 'aa1a91d5-1ed4-11f0-a19b-3822e22e3cc1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` char(36) NOT NULL DEFAULT (uuid()),
  `tagihan_id` char(36) NOT NULL,
  `tanggal_pembayaran` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jumlah_bayar` int NOT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` char(36) NOT NULL DEFAULT (uuid()),
  `tanggal_pengeluaran` datetime DEFAULT CURRENT_TIMESTAMP,
  `jumlah` int NOT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `nis` varchar(20) NOT NULL,
  `user_id` char(36) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `alamat` text,
  `nama_orang_tua` varchar(100) DEFAULT NULL,
  `kontak_orang_tua` varchar(20) DEFAULT NULL,
  `pekerjaan_orang_tua` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`nis`, `user_id`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `nama_orang_tua`, `kontak_orang_tua`, `pekerjaan_orang_tua`, `foto`) VALUES
('NIS001', '8dd6a43e-1fb1-11f0-ac11-3822e22e3cc1', 'Muhamad Yuda', 'Bandung', '2008-06-12', 'L', 'Jl. Merdeka No. 1', 'Alyuda', '08123456789', 'Pegawai Negeri Sipil', 'uploads/siswa/yuda.jpg'),
('NIS002', 'afd55375-1ed4-11f0-a19b-3822e22e3cc1', 'Ahmad Fauzi', 'Bandung', '2007-05-12', 'L', 'Jl. Merdeka No. 1', 'Budi Fauzi', '08123456789', 'Pegawai Negeri', 'uploads/siswa/ahmad.jpg'),
('NIS003', '8dd6aeba-1fb1-11f0-ac11-3822e22e3cc1', 'Muhamad Aep', 'Bandung', '2008-06-12', 'L', 'Jl. Merdeka No. 1', 'Darso', '08123456789', 'Kepolisian RI', 'uploads/siswa/aep.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` char(36) NOT NULL DEFAULT (uuid()),
  `nis` varchar(20) NOT NULL,
  `jenis_tagihan` varchar(255) NOT NULL,
  `jumlah` int NOT NULL,
  `dibayar` int NOT NULL DEFAULT '0',
  `sisa_tagihan` int GENERATED ALWAYS AS ((`jumlah` - `dibayar`)) STORED,
  `status` varchar(15) GENERATED ALWAYS AS ((case when ((`jumlah` - `dibayar`) <= 0) then _utf8mb4'lunas' else _utf8mb4'belum lunas' end)) STORED,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `nis`, `jenis_tagihan`, `jumlah`, `dibayar`, `created_at`) VALUES
('ba8a6f53-2218-11f0-b717-3822e22e3cc1', 'NIS001', 'SPP Bulan Februari 2025', 250000, 0, '2025-04-26 04:03:25'),
('ba8a76e7-2218-11f0-b717-3822e22e3cc1', 'NIS003', 'SPP Bulan Februari 2025', 250000, 0, '2025-04-26 04:03:25'),
('ba8a79ef-2218-11f0-b717-3822e22e3cc1', 'NIS002', 'SPP Bulan Februari 2025', 250000, 0, '2025-04-26 04:03:25'),
('c11b05f7-2218-11f0-b717-3822e22e3cc1', 'NIS001', 'SPP Bulan Maret 2025', 250000, 0, '2025-04-26 04:03:36'),
('c11b103f-2218-11f0-b717-3822e22e3cc1', 'NIS003', 'SPP Bulan Maret 2025', 250000, 0, '2025-04-26 04:03:36'),
('c11b1423-2218-11f0-b717-3822e22e3cc1', 'NIS002', 'SPP Bulan Maret 2025', 250000, 0, '2025-04-26 04:03:36'),
('c6f18783-2218-11f0-b717-3822e22e3cc1', 'NIS001', 'SPP Bulan April 2025', 250000, 0, '2025-04-26 04:03:46'),
('c6f18e52-2218-11f0-b717-3822e22e3cc1', 'NIS003', 'SPP Bulan April 2025', 250000, 0, '2025-04-26 04:03:46'),
('c6f1915d-2218-11f0-b717-3822e22e3cc1', 'NIS002', 'SPP Bulan April 2025', 250000, 0, '2025-04-26 04:03:46'),
('ccb21394-2218-11f0-b717-3822e22e3cc1', 'NIS001', 'SPP Bulan Mei 2025', 250000, 0, '2025-04-26 04:03:55'),
('ccb21b9e-2218-11f0-b717-3822e22e3cc1', 'NIS003', 'SPP Bulan Mei 2025', 250000, 0, '2025-04-26 04:03:55'),
('ccb21d64-2218-11f0-b717-3822e22e3cc1', 'NIS002', 'SPP Bulan Mei 2025', 250000, 0, '2025-04-26 04:03:55'),
('f516c76f-2214-11f0-b717-3822e22e3cc1', 'NIS001', 'SPP Bulan Januari 2025', 250000, 0, '2025-04-26 03:44:00'),
('f5172e01-2214-11f0-b717-3822e22e3cc1', 'NIS003', 'SPP Bulan Januari 2025', 250000, 0, '2025-04-26 03:44:00'),
('f5173236-2214-11f0-b717-3822e22e3cc1', 'NIS002', 'SPP Bulan Januari 2025', 250000, 0, '2025-04-26 03:44:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` char(36) NOT NULL DEFAULT (uuid()),
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('bendahara','kepala sekolah','siswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `role`) VALUES
('8dd6a43e-1fb1-11f0-ac11-3822e22e3cc1', 'siswa2@example.com', 'kaukabapay', 'siswa'),
('8dd6aeba-1fb1-11f0-ac11-3822e22e3cc1', 'siswa3@example.com', 'kaukabapay', 'siswa'),
('aa1a91d5-1ed4-11f0-a19b-3822e22e3cc1', 'bendahara@example.com', 'kaukabapay', 'bendahara'),
('ad19f6b6-1ed4-11f0-a19b-3822e22e3cc1', 'kepalasekolah@example.com', 'kaukabapay', 'kepala sekolah'),
('afd55375-1ed4-11f0-a19b-3822e22e3cc1', 'siswa@example.com', 'kaukabapay', 'siswa');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`nip`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `tagihan_id` (`tagihan_id`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `nis` (`nis`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihan` (`id_tagihan`);

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
