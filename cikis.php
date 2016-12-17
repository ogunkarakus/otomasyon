<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

if (false === giris_yapilmis_mi()) {
    header('Location: index.php', true, 303);
}

$_SESSION['oturum'] = false;

$_SESSION['mesajlar'][] = mesaj_basari(
    'Çıkıp yapma işlemi başarıyla tamamlandı.',
    true
);

header('Location: giris.php', true, 303);

exit;
