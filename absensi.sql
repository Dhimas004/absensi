-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Agu 2024 pada 15.58
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_absen`
--

CREATE TABLE `data_absen` (
  `id` int(100) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `waktu` time NOT NULL DEFAULT current_timestamp(),
  `uid` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_absen`
--

INSERT INTO `data_absen` (`id`, `id_karyawan`, `tanggal`, `waktu`, `uid`, `status`) VALUES
(27, 0, '2024-07-27', '15:41:33', '3695334', 'IN'),
(37, 0, '2024-07-28', '15:56:15', '3695334', 'IN'),
(38, 0, '2024-07-28', '16:02:27', '3695334', 'OUT'),
(39, 0, '2024-07-28', '16:05:29', 'E38E014', 'IN'),
(40, 0, '2024-07-28', '16:08:54', 'E38E014', 'OUT'),
(41, 0, '2024-07-28', '16:09:40', 'E38E014', 'OUT'),
(42, 0, '2024-07-28', '16:13:15', '9379B530', 'IN'),
(43, 0, '2024-07-28', '16:13:47', '9379B530', 'OUT'),
(46, 0, '2024-07-28', '16:19:09', 'E38E014', 'OUT'),
(48, 0, '2024-07-30', '18:57:54', 'E38E014', 'IN'),
(49, 0, '2024-07-30', '18:58:58', 'E38E014', 'OUT'),
(50, 0, '2024-07-30', '19:02:06', '3695334', 'IN'),
(51, 0, '2024-07-30', '19:03:38', '3695334', 'OUT'),
(52, 0, '2024-07-30', '19:14:58', '9379B530', 'IN'),
(53, 0, '2024-07-30', '19:15:31', '9379B530', 'OUT'),
(56, 0, '2024-07-30', '19:17:45', 'E38E014', 'OUT'),
(57, 0, '2024-07-30', '19:18:12', 'E38E014', 'OUT'),
(60, 0, '2024-07-30', '08:00:00', '13404135', 'IN'),
(61, 0, '2024-07-30', '19:00:00', '13404135', 'OUT'),
(63, 0, '2024-08-04', '11:54:35', '3695334', 'IN'),
(64, 0, '2024-08-04', '20:00:00', '3695334', 'OUT'),
(65, 1, '2024-08-21', '18:42:27', 'E38E014', 'IN'),
(66, 2, '2024-08-21', '18:43:24', '3695334', 'IN'),
(67, 1, '2024-08-21', '18:44:13', 'E38E014', 'OUT'),
(68, 2, '2024-08-21', '18:44:23', '3695334', 'OUT'),
(69, 0, '2024-08-20', '08:00:00', '3695334', 'IN'),
(70, 0, '2024-08-20', '19:00:00', '3695334', 'OUT');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_admin`
--

CREATE TABLE `data_admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_admin`
--

INSERT INTO `data_admin` (`id`, `nama`, `username`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$dHU3H7/xSzxtWQ1hVDlDQeuWWKlVUNykwmdvgC3VXgOaGHp7LopPC');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_invalid`
--

CREATE TABLE `data_invalid` (
  `id` int(100) NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp(),
  `waktu` time NOT NULL DEFAULT current_timestamp(),
  `uid` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_jabatan`
--

CREATE TABLE `data_jabatan` (
  `id` int(11) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_jabatan`
--

INSERT INTO `data_jabatan` (`id`, `jabatan`, `id_admin`, `timestamp`) VALUES
(1, 'PIC', 1, '2024-08-04 10:34:47'),
(2, 'Admin', 1, '2024-08-04 10:34:55'),
(3, 'Kapten', 1, '2024-08-04 10:34:56'),
(5, 'pic 2', 1, '2024-08-04 11:08:09'),
(6, 'pic3', 1, '2024-08-04 11:08:56'),
(7, 'pic4', 1, '2024-08-04 11:09:15'),
(8, 'AutoMan', 1, '2024-08-04 17:27:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_karyawan`
--

CREATE TABLE `data_karyawan` (
  `id` int(50) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp(),
  `uid` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `picture` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_karyawan`
--

INSERT INTO `data_karyawan` (`id`, `id_admin`, `created`, `uid`, `nama`, `no_hp`, `id_jabatan`, `jenis_kelamin`, `alamat`, `picture`) VALUES
(1, 0, '2024-07-21', 'E38E014', 'aSd asd', '082311563036', 1, 'Laki-Laki', 'test', ''),
(2, 0, '2024-07-21', '3695334', 'TEST', '2', 1, 'Laki-Laki', '1', ''),
(4, 0, '2024-07-28', '9379B530', 'TEST 2', '1234567890', 2, 'Laki-Laki', 'DIMANA', ''),
(8, 1, '2024-08-04', '123456', '123', '123', 5, 'Laki-Laki', '123', ''),
(9, 1, '2024-08-04', '123', '235', '235', 1, 'Laki-Laki', '235', ''),
(10, 1, '2024-08-04', '523', '234', '523', 7, 'Laki-Laki', '523', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_absen`
--
ALTER TABLE `data_absen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_admin`
--
ALTER TABLE `data_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_invalid`
--
ALTER TABLE `data_invalid`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_jabatan`
--
ALTER TABLE `data_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_karyawan`
--
ALTER TABLE `data_karyawan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_absen`
--
ALTER TABLE `data_absen`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `data_admin`
--
ALTER TABLE `data_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `data_invalid`
--
ALTER TABLE `data_invalid`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_jabatan`
--
ALTER TABLE `data_jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `data_karyawan`
--
ALTER TABLE `data_karyawan`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
