-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 192.168.99.100:3306
-- Üretim Zamanı: 17 Ara 2016, 01:35:49
-- Sunucu sürümü: 5.7.16
-- PHP Sürümü: 5.6.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `otomasyon`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ad` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `soyad` varchar(64) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `elektronik_posta_adresi` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `sifre` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `elektronik_posta_adresi` (`elektronik_posta_adresi`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ozellikler`
--

CREATE TABLE IF NOT EXISTS `ozellikler` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ad` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `deger` text COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparisler`
--

CREATE TABLE IF NOT EXISTS `siparisler` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis_ozellik`
--

CREATE TABLE IF NOT EXISTS `siparis_ozellik` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `siparis_id` int(10) UNSIGNED NOT NULL,
  `ozellik_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis_urun`
--

CREATE TABLE IF NOT EXISTS `siparis_urun` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `siparis_id` int(10) UNSIGNED NOT NULL,
  `urun_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stoklar`
--

CREATE TABLE IF NOT EXISTS `stoklar` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `adet` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE IF NOT EXISTS `urunler` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fiyat` decimal(10,2) NOT NULL,
  `indirim` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_ozellik`
--

CREATE TABLE IF NOT EXISTS `urun_ozellik` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `urun_id` int(10) UNSIGNED NOT NULL,
  `ozellik_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_stok`
--

CREATE TABLE IF NOT EXISTS `urun_stok` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `urun_id` int(10) UNSIGNED NOT NULL,
  `stok_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
