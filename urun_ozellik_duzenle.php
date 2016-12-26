<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

if (false === giris_yapilmis_mi()) {
    header('Location: giris.php', true, 303);

    exit();
}

if (false === isset($_GET['urun_id']) ||
    false === is_numeric($_GET['urun_id'])) {
    $_SESSION['mesajlar'][] = mesaj_uyari(
        'Ürün özelliği düzenleyebilmeniz için geçerli bir '.
        'ürün kayıt numarası gerekmektedir.',
        true
    );

    header('Location: urunler.php', true, 303);

    exit();
}

$urun = urun(intval($_GET['urun_id']));

if (empty($urun)) {
    $_SESSION['mesajlar'][] = mesaj_hata(
        'Ürün kayıt numarasına ait ürün verisi bulunamadı.',
        true
    );

    header('Location: urunler.php', true, 303);

    exit();
}

if (false === isset($_GET['id']) ||
    false === is_numeric($_GET['id'])) {
    $_SESSION['mesajlar'][] = mesaj_uyari(
        'Ürün özelliği düzenleyebilmeniz için geçerli bir '.
        'ürün özelliği kayıt numarası gerekmektedir.',
        true
    );

    header('Location: urunler.php', true, 303);

    exit();
}

$ozellik = ozellik(intval($_GET['id']));

if (empty($ozellik)) {
    $_SESSION['mesajlar'][] = mesaj_hata(
        'Ürün özelliği kayıt numarasına ait ürün özellik verisi bulunamadı.',
        true
    );

    header('Location: urun.php?id='.$urun['id'], true, 303);

    exit();
}

if (isset($_POST['ozellik'])) {
    $guncellendi_mi = ozellik_guncelle(
        intval($ozellik['id']),
        $_POST['ozellik']
    );

    if (false === $guncellendi_mi) {
        goto sayfa;
    } else {
        header('Location: urun.php?id='.$urun['id'], true, 303);

        exit();
    }
}

sayfa:

$stil = <<<STIL
body { padding-bottom: 15px; padding-top: 15px; }
label, .input-group-addon { cursor: pointer; }
.alert { margin-bottom: 15px; }
.form-group { padding-left: 15px; padding-right: 15px; }
.panel { margin-bottom: 15px; }
.panel-body > *:last-child { margin-bottom: 0; }
STIL;

define('baslik', 'Ürün Özellik Düzenle : '.$urun['ad']);
define('stil', $stil);

require str_replace('\\', '/', __DIR__).'/ust.php';

?><div class="container-fluid"><?php

require str_replace('\\', '/', __DIR__).'/nav.php';

?>
<form class="form-horizontal panel panel-primary" method="post">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-fw fa-plus"></i>
<span>Ürün Özellik Düzenle : <?php print $urun['ad']; ?></span>
</h1>
</div>
<div class="panel-body">
<div class="form-group">
<div class="input-group">
<span class="input-group-addon" data-focus-to="anahtar">
<i class="fa fa-align-justify fa-fw"></i>
</span>
<?php print '<input class="form-control" id="anahtar" '.
            ' name="ozellik[anahtar]" placeholder="Ad" required '.
            'type="text" value="'.$ozellik['anahtar'].'"/>'.PHP_EOL; ?>
</div>
</div>
<div class="form-group">
<div class="input-group">
<span class="input-group-addon" data-focus-to="deger">
<i class="fa fa-align-justify fa-fw"></i>
</span>
<?php print '<input class="form-control" id="deger" '.
            'name="ozellik[deger]" placeholder="Değer" '.
            'type="text" value="'.$ozellik['deger'].'"/>'.PHP_EOL; ?>
</div>
</div>
</div>
<div class="panel-footer">
<button class="btn btn-block btn-primary">
<i class="fa fa-fw fa-save"></i>
<span>Güncelle</span>
</button>
</div>
</form>
<?php

$kod = <<<KOD
$("[data-focus-to]").on("click", function () {
$("#"+$(this).data("focus-to")).focus();
});
KOD;

define('kod', $kod);

?></div>
<?php

require str_replace('\\', '/', __DIR__).'/alt.php';
