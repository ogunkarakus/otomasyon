-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net
--
-- Ana Makine: 192.168.99.100:3306
-- Üretim Zamanı: 26 Ara 2016, 02:05:58
-- Sunucu Sürümü: 5.7.16
-- PHP Sürümü: 7.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+03:00";

--
-- Veritabanı: `otomasyon`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `faturalar`
--

DROP TABLE IF EXISTS `faturalar`;
CREATE TABLE IF NOT EXISTS `faturalar` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kayit_zamani` datetime NOT NULL,
  `guncelleme_zamani` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fatura_ozellik`
--

DROP TABLE IF EXISTS `fatura_ozellik`;
CREATE TABLE IF NOT EXISTS `fatura_ozellik` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fatura_id` int(10) UNSIGNED NOT NULL,
  `ozellik_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fatura_urun`
--

DROP TABLE IF EXISTS `fatura_urun`;
CREATE TABLE IF NOT EXISTS `fatura_urun` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fatura_id` int(10) UNSIGNED NOT NULL,
  `urun_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

DROP TABLE IF EXISTS `kullanicilar`;
CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ad` varchar(64) NOT NULL,
  `soyad` varchar(64) NOT NULL,
  `elektronik_posta_adresi` varchar(128) NOT NULL,
  `sifre` varchar(128) NOT NULL,
  `kayit_zamani` datetime NOT NULL,
  `guncelleme_zamani` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ozellikler`
--

DROP TABLE IF EXISTS `ozellikler`;
CREATE TABLE IF NOT EXISTS `ozellikler` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `anahtar` varchar(128) NOT NULL,
  `deger` text,
  `kayit_zamani` datetime NOT NULL,
  `guncelleme_zamani` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

DROP TABLE IF EXISTS `urunler`;
CREATE TABLE IF NOT EXISTS `urunler` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ad` varchar(192) NOT NULL,
  `birim` enum('adet','kilogram','litre') NOT NULL,
  `fiyat` decimal(19,4) NOT NULL,
  `vergi` int(11) NOT NULL DEFAULT '8',
  `ekleyen_kullanici_id` int(10) UNSIGNED NOT NULL,
  `kayit_zamani` datetime NOT NULL,
  `guncelleme_zamani` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_ozellik`
--

DROP TABLE IF EXISTS `urun_ozellik`;
CREATE TABLE IF NOT EXISTS `urun_ozellik` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `urun_id` int(10) UNSIGNED NOT NULL,
  `ozellik_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
