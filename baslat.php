<?php

session_start();

ob_start();

require_once str_replace('\\', '/', __DIR__).'/fonksiyon.php';

$ayar = require str_replace('\\', '/', __DIR__).'/ayar.php';

try {
    $vt = new PDO(
        sprintf(
            'mysql:dbname=%s;host=%s;port=%s',
            $ayar['vt_adi'],
            $ayar['vt_sunucu'],
            $ayar['vt_kapi_numarasi']
        ),
        $ayar['vt_kullanici'],
        $ayar['vt_sifre'],
        [
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
            PDO::ATTR_TIMEOUT => 2,
        ]
    );
} catch (PDOException $hata) {
    exit('Veritabani baglantisi kurulamadi.');
}

karakter_seti_ayarla($ayar['vt_karakter_seti'], $ayar['vt_karakter_kumesi']);

saati_ayarla();

if (false === isset($_SESSION['mesajlar'])) {
    $_SESSION['mesajlar'] = [];
}
