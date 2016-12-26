<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

$adres = 'giris.php';

if (false === giris_yapilmis_mi()) {
    goto yonlendir;
}

if (false === isset($_GET['id']) || false === is_numeric($_GET['id'])) {
    $adres = 'faturalar.php';

    $_SESSION['mesajlar'][] = mesaj_uyari(
        'Fatura silme işlemine devam etmek için geçe'.
        'rli bir fatura numarası gereklidir.',
        true
    );

    goto yonlendir;
}

$adres = 'faturalar.php';

// faturayı sil

$_SESSION['mesajlar'][] = mesaj_basari(
    'Fatura silme başarıyla tamamlandı.',
    true
);

goto yonlendir;

yonlendir:

header('Location: '.$adres, true, 303);

exit();
