-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 08 Nis 2026, 15:00:02
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ucak_bileti_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `degerlendirmeler`
--

CREATE TABLE `degerlendirmeler` (
  `id` int(11) NOT NULL,
  `koltuk_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `yorum` text NOT NULL,
  `fiyat_etkisi` decimal(10,2) DEFAULT 0.00,
  `olusturulma_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `koltuklar`
--

CREATE TABLE `koltuklar` (
  `id` int(11) NOT NULL,
  `ucus_id` int(11) NOT NULL,
  `koltuk_no` varchar(10) NOT NULL,
  `standart_fiyat` decimal(10,2) NOT NULL,
  `ozellik_notu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `ad_soyad` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `rol` enum('kullanici','admin') DEFAULT 'kullanici'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ucuslar`
--

CREATE TABLE `ucuslar` (
  `id` int(11) NOT NULL,
  `kalkis_yeri` varchar(100) NOT NULL,
  `varis_yeri` varchar(100) NOT NULL,
  `kalkis_zamani` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ucuslar`
--

INSERT INTO `ucuslar` (`id`, `kalkis_yeri`, `varis_yeri`, `kalkis_zamani`) VALUES
(1, 'İstanbul', 'Ankara', '2026-04-25 14:42:04'),
(3, 'Antalya', 'İzmir', '2026-04-12 14:52:18'),
(6, 'Trabzon', 'İstanbul', '2026-04-16 14:52:18'),
(7, 'Trabzon', 'Ankara', '2026-04-28 14:55:03'),
(8, 'İzmir', 'Antalya', '2026-04-08 14:55:03'),
(9, 'İstanbul', 'Trabzon', '2026-04-09 14:55:03'),
(11, 'Trabzon', 'İzmir', '2026-04-08 17:30:42'),
(12, 'Antalya', 'İzmir', '2026-04-09 20:15:42');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `degerlendirmeler`
--
ALTER TABLE `degerlendirmeler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `koltuk_id` (`koltuk_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Tablo için indeksler `koltuklar`
--
ALTER TABLE `koltuklar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ucus_id` (`ucus_id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `ucuslar`
--
ALTER TABLE `ucuslar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `degerlendirmeler`
--
ALTER TABLE `degerlendirmeler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `koltuklar`
--
ALTER TABLE `koltuklar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `ucuslar`
--
ALTER TABLE `ucuslar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `degerlendirmeler`
--
ALTER TABLE `degerlendirmeler`
  ADD CONSTRAINT `degerlendirmeler_ibfk_1` FOREIGN KEY (`koltuk_id`) REFERENCES `koltuklar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `degerlendirmeler_ibfk_2` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `koltuklar`
--
ALTER TABLE `koltuklar`
  ADD CONSTRAINT `koltuklar_ibfk_1` FOREIGN KEY (`ucus_id`) REFERENCES `ucuslar` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
