<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

$adres = 'giris.php';

if (false === giris_yapilmis_mi()) {
    goto yonlendir;
}

if (false === isset($_GET['id']) || false === is_numeric($_GET['id'])) {
    $adres = 'urunler.php';

    $_SESSION['mesajlar'][] = mesaj_uyari(
        'Ürün silme işlemine devam etmek için geçe'.
        'rli bir fatura numarası gereklidir.',
        true
    );

    goto yonlendir;
}

$adres = 'urunler.php';

// ürünü sil
// ürüne ait özellikleri sil
// ürünün olduğu faturaları sil

$_SESSION['mesajlar'][] = mesaj_basari(
    'Ürün silme başarıyla tamamlandı.',
    true
);

goto yonlendir;

yonlendir:

header('Location: '.$adres, true, 303);

exit();
