-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql109.infinityfree.com
-- Waktu pembuatan: 02 Sep 2024 pada 00.05
-- Versi server: 10.6.19-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_36241318_11220027`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_dosen`
--

CREATE TABLE `m_dosen` (
  `id` int(11) NOT NULL,
  `id_dosen` varchar(20) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `m_dosen`
--

INSERT INTO `m_dosen` (`id`, `id_dosen`, `nama_dosen`) VALUES
(1, '110', 'Toni Ahsin Bujari'),
(2, '111', 'Anies baswedan'),
(3, '112', 'Ganjar pranowo'),
(4, '113', 'Prabowo '),
(5, '114', 'Jokowi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_mahasiswa`
--

CREATE TABLE `m_mahasiswa` (
  `id` int(10) NOT NULL,
  `nim` varchar(8) NOT NULL,
  `nama_mhs` varchar(100) NOT NULL,
  `jk` varchar(20) NOT NULL,
  `alamat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `m_mahasiswa`
--

INSERT INTO `m_mahasiswa` (`id`, `nim`, `nama_mhs`, `jk`, `alamat`) VALUES
(1, '11220027', 'Faiz sahrul muharam', 'Laki-Laki', 'jalan cieunteung gede'),
(2, '11224411', 'Amin', 'Laki-Laki', 'jalan bebedahan'),
(3, '11225577', 'Sumanto', 'Laki laki', 'Bandung'),
(4, '11557744', 'Ai', 'Perempuan', 'Pengkolan'),
(5, '11220044', 'Sukicman', 'Perempuan', 'Aceh');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_matakuliah`
--

CREATE TABLE `m_matakuliah` (
  `id` int(11) NOT NULL,
  `kode_mk` varchar(10) NOT NULL,
  `nama_mk` varchar(100) NOT NULL,
  `sks` int(3) NOT NULL,
  `smt` int(3) NOT NULL,
  `id_dosen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `m_matakuliah`
--

INSERT INTO `m_matakuliah` (`id`, `kode_mk`, `nama_mk`, `sks`, `smt`, `id_dosen`) VALUES
(1, '210', 'Agama', 3, 4, '114'),
(2, '211', 'Metode Numerik', 3, 4, '113'),
(3, '212', 'Intreaksi Manusia Komputer', 3, 4, '112'),
(4, '213', 'Matematika Distrik 2', 3, 4, '114');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_pengguna`
--

CREATE TABLE `m_pengguna` (
  `id` int(11) NOT NULL,
  `kode_op` varchar(10) NOT NULL,
  `nama_op` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `m_pengguna`
--

INSERT INTO `m_pengguna` (`id`, `kode_op`, `nama_op`, `pass`, `level`) VALUES
(3, 'admin', 'administrator', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `kode_mk` varchar(8) NOT NULL,
  `nilai` varchar(1) NOT NULL,
  `thn_akademik` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`id`, `nim`, `kode_mk`, `nilai`, `thn_akademik`) VALUES
(1, '11220027', '210', 'A', '2024'),
(2, '11557744', '211', 'B', '2024'),
(3, '11224411', '212', 'D', '2024'),
(4, '11225577', '213', 'B', '2024');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `m_dosen`
--
ALTER TABLE `m_dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_dosen` (`id_dosen`);

--
-- Indeks untuk tabel `m_mahasiswa`
--
ALTER TABLE `m_mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_matakuliah`
--
ALTER TABLE `m_matakuliah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_mk` (`kode_mk`);

--
-- Indeks untuk tabel `m_pengguna`
--
ALTER TABLE `m_pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_op` (`kode_op`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `m_dosen`
--
ALTER TABLE `m_dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `m_mahasiswa`
--
ALTER TABLE `m_mahasiswa`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `m_matakuliah`
--
ALTER TABLE `m_matakuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `m_pengguna`
--
ALTER TABLE `m_pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
