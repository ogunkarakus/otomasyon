<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

$adres = 'giris.php';

if (false === giris_yapilmis_mi()) {
    goto yonlendir;
}

if (false === isset($_GET['urun_id']) ||
    false === is_numeric($_GET['urun_id'])
) {
    $adres = 'urunler.php';

    $_SESSION['mesajlar'][] = mesaj_uyari(
        'Özellik silme işlemine devam etmek için geçe'.
        'rli bir ürün numarası gereklidir.',
        true
    );

    goto yonlendir;
}

if (false === isset($_GET['id']) || false === is_numeric($_GET['id'])) {
    $adres = 'urun.php?id='.$_GET['urun_id'];

    $_SESSION['mesajlar'][] = mesaj_uyari(
        'Özellik silme işlemine devam etmek için geçe'.
        'rli bir özellik numarası gereklidir.',
        true
    );

    goto yonlendir;
}

$adres = 'urun.php?id='.$_GET['urun_id'];

$_SESSION['mesajlar'][] = urun_ozellik_sil(
    intval($_GET['urun_id']),
    intval($_GET['id'])
);

goto yonlendir;

yonlendir:

header('Location: '.$adres, true, 303);

exit();
