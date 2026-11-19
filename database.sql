-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql305.infinityfree.com
-- Waktu pembuatan: 19 Nov 2026 pada 02.20
-- Versi server: 11.4.13-MariaDB
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
-- Database: `if0_43478308_pasar_tradisional`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` char(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_produk`, `jumlah`, `harga`) VALUES
(1, 1, 10, 1, 577000),
(2, 2, 9, 1, 375000),
(3, 3, 9, 1, 375000),
(4, 4, 16, 1, 599000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Makanan'),
(3, 'Pakaian'),
(4, 'Sepatu'),
(5, 'Handphone'),
(6, 'Electronic'),
(7, 'Sepatu'),
(8, 'High Heels');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjual`
--

CREATE TABLE `penjual` (
  `id_penjual` int(11) NOT NULL,
  `nama_toko` varchar(60) NOT NULL,
  `kontak` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjual`
--

INSERT INTO `penjual` (`id_penjual`, `nama_toko`, `kontak`) VALUES
(1, 'Elvina Store', '0812000111');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama_pembeli` varchar(60) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `total` int(11) NOT NULL,
  `status` enum('Menunggu Konfirmasi','Dikonfirmasi','Dikemas','Dikirim','Selesai','Dibatalkan') DEFAULT 'Menunggu Konfirmasi',
  `tanggal` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `kode`, `nama_pembeli`, `no_hp`, `alamat`, `total`, `status`, `tanggal`) VALUES
(2, 'MG261118843', 'Elvina Utami', '081245673890', 'Bengkulu', 375000, 'Selesai', '2026-11-19 03:34:19'),
(3, 'MG261118720', 'Princess', '085271567894', 'Kampung Kelawi', 375000, 'Selesai', '2026-11-19 04:26:22'),
(4, 'MG261118403', 'Dendy', '085768899723', 'jl. letnan sudirman', 599000, 'Selesai', '2026-11-19 04:47:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_penjual` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(80) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `emoji` varchar(8) DEFAULT '?',
  `gambar` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `id_penjual`, `id_kategori`, `nama`, `deskripsi`, `harga`, `stok`, `emoji`, `gambar`) VALUES
(9, 1, 3, 'y2k autumn  street women hooded ', 'Hoodie Wanita Kekinian   \r\n\r\nHoodie wanita dengan desain stylish dan casual, nyaman digunakan untuk aktivitas sehari-hari. Cocok untuk kuliah, hangout, jalan-jalan, maupun santai. Mudah dipadukan dengan berbagai outfit agar tetap tampil fashionable dan percaya diri. \r\nYuk, checkout sekarang! ', 375000, 48, '', '6afe6938a6085.jpg'),
(10, 1, 3, 'Cherry Sporty Jacket ', 'Jacket Cewek Trendy   \r\n\r\nTampil simpel dan modis dengan jacket wanita yang nyaman dan stylish. Cocok untuk berbagai aktivitas, mulai dari jalan-jalan, nongkrong, hingga daily outfit. Desain kekinian yang bikin penampilan makin kece! \r\nBuruan checkout sebelum kehabisan!', 577000, 100, '', '6afe6ac730edf.jpg'),
(11, 1, 3, 'Red Spider Graphic Zip-Up Hoodie', '🕷️ Red Spider Graphic Zip-Up Hoodie 🕷️\r\n\r\nHoodie wanita dengan desain grafis Red Spider yang unik dan stylish. Model zipper yang praktis dengan tampilan streetwear kekinian, cocok untuk kamu yang ingin tampil lebih keren, edgy, dan fashionable dalam berbagai aktivitas. ', 785000, 150, '', '6afe73f75e8fd.jpg'),
(12, 1, 4, 'puma speedcat og black mauve mist pink', ' PUMA Women\'s Sneakers\r\n\r\nSepatu wanita PUMA dengan desain sporty dan stylish, cocok untuk melengkapi penampilan sehari-hari. Nyaman digunakan untuk jalan-jalan, kuliah, maupun hangout. Tampil lebih fashionable dan percaya diri dengan gaya casual yang kekinian!', 750000, 100, '', '6afe74bc2c65b.jpg'),
(13, 1, 4, 'Sneakers 2026 Best Trend Shoes for Men', 'Sepatu sneakers pria dengan desain modern dan trendy, cocok untuk menunjang penampilan sehari-hari. Nyaman digunakan untuk jalan-jalan, kuliah, maupun aktivitas santai. Tampil lebih stylish, sporty, dan percaya diri dengan sneakers kekinian!', 1299000, 100, '', '6afe75950705b.jpg'),
(14, 1, 6, 'Canon g7x mark iii', 'Kamera compact dengan desain elegan dan kualitas foto serta video yang memukau. Cocok untuk membuat konten, vlog, traveling, hingga mengabadikan momen spesial. Praktis dibawa ke mana saja dan siap menemani setiap momen terbaikmu! ', 3799000, 50, '', '6afe75e97d99c.jpg'),
(15, 1, 5, 'iphone 18 pro max', 'iphone18pro cherry #iphone18 pro max cherry\r\nRam 1TB', 44000000, 50, '', '6afe76e102691.jpg'),
(16, 1, 1, 'Steak sapi', 'Beef Steak\r\n\r\nSteak sapi dengan daging yang juicy, tekstur lembut, dan cita rasa gurih yang menggugah selera. Disajikan dengan saus lezat serta pelengkap yang bikin setiap gigitan semakin nikmat. Cocok untuk pecinta kuliner daging! ', 599000, 99, '', '6afe7744bdf1d.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `penjual`
--
ALTER TABLE `penjual`
  ADD PRIMARY KEY (`id_penjual`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_penjual` (`id_penjual`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `penjual`
--
ALTER TABLE `penjual`
  MODIFY `id_penjual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_penjual`) REFERENCES `penjual` (`id_penjual`),
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
