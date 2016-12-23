<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

if (false === giris_yapilmis_mi()) {
    header('Location: giris.php', true, 303);

    exit();
}

$urun = urun(intval($_GET['id']));

if (empty($urun)) {
    $_SESSION['mesajlar'][] = mesaj_hata(
        'Ulaşmak istediğiniz ürüne ait kayıt bulunamadı.',
        true
    );

    header('Location: urunler.php', true, 303);

    exit();
}

sayfa:

$stil = <<<STIL
body { padding-bottom: 15px; padding-top: 15px; }
.panel { margin-bottom: 15px; }
STIL;

define('baslik', 'Ürün : '.$urun['ad']);
define('stil', $stil);

require str_replace('\\', '/', __DIR__).'/ust.php';

?><div class="container-fluid"><?php

require str_replace('\\', '/', __DIR__).'/nav.php';

?>
<div class="panel panel-primary">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-cube fa-fw"></i>
<span>Ürün</span>
<span>:</span>
<span><?php print $urun['ad']; ?></span>
</h1>
</div>
<div class="panel-body">
</div>
</div>
<?php

$kod = <<<KOD
KOD;

define('kod', $kod);

?></div>
<?php

require str_replace('\\', '/', __DIR__).'/alt.php';
