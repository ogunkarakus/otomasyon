<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

$adres = 'giris.php';

if (false === giris_yapilmis_mi()) {
    goto yonlendir;
}

if (false === isset($_GET['id']) || false === is_numeric($_GET['id'])) {
    $adres = 'kullanicilar.php';

    $_SESSION['mesajlar'][] = mesaj_uyari(
        'Kullanıcı silme işlemine devam etmek için geçe'.
        'rli bir kullanıcı numarası gereklidir.',
        true
    );

    goto yonlendir;
}

$adres = 'kullanicilar.php';

$_SESSION['mesajlar'][] = kullanici_sil(intval($_GET['id']));

goto yonlendir;

yonlendir:

header('Location: '.$adres, true, 303);

exit();
