-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Okt 2025 pada 13.50
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmb_mkm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'admin',
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nama_admin`, `username`, `email`, `password`, `role`, `tanggal_dibuat`) VALUES
(1, 'Admin Utama', 'admin', 'admin@mkm.ac.id', '$2y$10$MdQ/Fyr5yMOKM.M..SQyaeoDWcvFU9AnHApgnrWjX/xytZ3BwM3lK', 'admin', '2025-10-29 12:08:15'),
(2, 'HakiHoki', 'haki', 'haki12@gmail.com', '$2y$10$01/Bk1LjAWN19xwr132x6ei37IAlGvf0jkKzGWb95w3nNBkjd/ufS', 'admin', '2025-10-30 03:22:36'),
(3, 'Hikmah', 'hikmah', 'hikmah12@gmail.com', '$2y$10$ikbQSpK7mxFDFFNbld4bUeRKQaMGYEtXTgnhCrBvqBK6kmUtcKx.W', 'admin', '2025-10-30 04:30:48'),
(4, 'zaky', 'zaky', 'zaky12@gmail.com', '$2y$10$BsRN4rDzitnZe0LKNo1wSO0Lz60Ua0wCCgPxueMbZN3R0OPYRzthi', 'admin', '2025-10-30 04:31:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `id_pesan` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nomor_wa` varchar(20) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kontak`
--

INSERT INTO `kontak` (`id_pesan`, `nama`, `email`, `nomor_wa`, `pesan`, `tanggal`) VALUES
(2, 'akmal jaya', 'akmah@gmail.com', '6285764678929', 'Apakah disini ada kelas karyawan?', '2025-10-30 03:58:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pendaftaran`
--

CREATE TABLE `tb_pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `asal_slta` varchar(100) DEFAULT NULL,
  `program_studi` varchar(100) DEFAULT NULL,
  `rencana_kelas` varchar(50) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `tanggal_daftar` datetime DEFAULT current_timestamp(),
  `status_pendaftaran` enum('Pending','Diterima','Tidak Diterima') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pendaftaran`
--

INSERT INTO `tb_pendaftaran` (`id_pendaftaran`, `nama_lengkap`, `email`, `jenis_kelamin`, `alamat`, `nik`, `nisn`, `asal_slta`, `program_studi`, `rencana_kelas`, `bukti_pembayaran`, `tanggal_daftar`, `status_pendaftaran`) VALUES
(1, 'Ea ex et velit saepe1', NULL, 'Laki-laki', 'In labore dolor aute1', 'Nulla consectetur es', 'Do accusamus hic vit', 'Reprehenderit id al1', 'farmasi1', 'Kelas Reguler1', '1761795457_3x4.jpg', '2025-10-30 10:37:37', 'Diterima'),
(2, 'Nihil eligendi sed e', NULL, 'Perempuan', 'Aperiam similique in', 'Veniam iusto in rer', 'A et rerum illum mo', 'Repellendus Dolor i', 'Analis Kesehatan', 'Kelas Karyawan', '1761795491_24f5f1268c5609adad93b9b25f30c48f.jpg', '2025-10-30 10:38:11', 'Diterima'),
(3, 'Dolor dolor amet mi', NULL, 'Perempuan', 'Cupiditate rem amet', 'Quod ullam exercitat', 'Pariatur Quae ipsa', 'Veritatis repudianda', 'farmasi', 'Kelas Reguler', '1761796449_foto_login.jpg', '2025-10-30 10:54:09', 'Tidak Diterima'),
(4, 'Deserunt perferendis', NULL, 'Laki-laki', 'Saepe sed dolore eve', 'Minus consequatur N', 'Veritatis aut enim i', 'Pariatur Irure ut q', 'Manajemen Informatika', '', '1761797945_demon.jpg', '2025-10-30 11:19:05', 'Diterima'),
(5, 'Dolorem ad obcaecati', NULL, 'Laki-laki', 'Qui ut aut officiis ', 'Dolor rerum autem na', 'Elit et nobis in vo', 'Labore ut voluptate ', 'Manajemen Informatika', 'Kelas Karyawan', '1761799055_3x4.jpg', '2025-10-30 11:37:35', 'Diterima'),
(6, 'Optio ipsam sint q', 'naruzajuxa@mailinator.com', 'Laki-laki', 'Quia sit modi nihil', 'Est laudantium dol', 'Et ut ad et aspernat', 'Culpa error omnis qu', 'Manajemen Informatika', 'Kelas Karyawan', '1761828369_foto_login.jpg', '2025-10-30 19:46:09', 'Diterima');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('mahasiswa','admin') DEFAULT 'mahasiswa',
  `status_akun` enum('aktif','nonaktif') DEFAULT 'nonaktif',
  `tanggal_daftar` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama_lengkap`, `username`, `password`, `role`, `status_akun`, `tanggal_daftar`) VALUES
(1, 'Ea ex et velit saepe', 'Nulla consectetur es', '$2y$10$VkNLuYJRDvG.u31Wz.rfMOWvboxd1a/.yj4swBQdZs2dP0FD.krv6', 'mahasiswa', 'aktif', '2025-10-30 10:37:37'),
(2, 'Nihil eligendi sed e', 'Veniam iusto in rer', '$2y$10$urCqkCBTkVGvJkMyyPp5ye7hXxcTSb4SNc5sCjFj7bGNBZr6bNZNy', 'mahasiswa', 'aktif', '2025-10-30 10:38:11'),
(3, 'Dolor dolor amet mi', 'Quod ullam exercitat', '$2y$10$SVfjdHQTdTxKWsruHyO/NuhJa9SJiqIDcKRKinzQH4gybn.V/z/dC', 'mahasiswa', 'nonaktif', '2025-10-30 10:54:09'),
(4, 'Deserunt perferendis', 'Minus consequatur N', '$2y$10$8ahkLQwf5tUEYlaFVFjiDe86MA4BXr4V2EMJMBsoPOkVoqxzEar0K', 'mahasiswa', 'aktif', '2025-10-30 11:19:05'),
(5, 'Dolorem ad obcaecati', 'Dolor rerum autem na', '$2y$10$uMnY9BChD8LW6msgqB/9OOFeWCIIkjcmwGeMm.UM/xE0YRe.qUw.G', 'mahasiswa', 'aktif', '2025-10-30 11:37:35'),
(6, 'Optio ipsam sint q', 'Est laudantium dol', '$2y$10$U8zSVNeGZ0Kuzf49zXf1yeQjXwnb7B.tS6gxmbKtEfnLewLxpmuHK', 'mahasiswa', 'aktif', '2025-10-30 19:46:09');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_pesan`);

--
-- Indeks untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_pendaftaran`
--
ALTER TABLE `tb_pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
