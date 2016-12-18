<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

$adres = 'index.php';

if (false === giris_yapilmis_mi()) {
    goto yonlendir;
}

$adres = 'giris.php';

$_SESSION['oturum'] = false;

unset($_SESSION['kullanici']);

if (isset($_GET['yap']) && $_GET['yap'] === 'mesaj_gosterme') {
    goto yonlendir;
} else {
    $_SESSION['mesajlar'][] = mesaj_basari(
        'Çıkıp yapma işlemi başarıyla tamamlandı.',
        true
    );
}

goto yonlendir;

yonlendir:

header('Location: '.$adres, true, 303);

exit();
