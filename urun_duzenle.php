<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

if (false === giris_yapilmis_mi()) {
    header('Location: giris.php', true, 303);

    exit();
}

if (false === isset($_GET['id']) || false === is_numeric($_GET['id'])) {
    $_SESSION['mesajlar'][] = mesaj_uyari(
        'Kullanıcı düzenleme işlemine devam etmek için geçe'.
        'rli bir kullanıcı numarası gereklidir.',
        true
    );

    header('Location: urunler.php', true, 303);

    exit();
}

$urun = urun(intval($_GET['id']));

if (empty($urun)) {
    $_SESSION['mesajlar'][] = mesaj_hata(
        'Ürün kayıt numarasıyla kayıtlı ürün verisi bulunamadı.',
        true
    );

    header('Location: urunler.php', true, 303);

    exit();
}

if (isset($_POST['urun'])) {
    $guncellendi_mi = urun_guncelle(intval($_GET['id']), $_POST['urun']);

    if (false === $guncellendi_mi) {
        goto sayfa;
    } else {
        header('Location: urun_duzenle.php?id='.$urun['id'], true, 303);

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

define('baslik', 'Ürün Düzenle : '.$urun['ad']);
define('stil', $stil);

require str_replace('\\', '/', __DIR__).'/ust.php';

?><div class="container-fluid"><?php

require str_replace('\\', '/', __DIR__).'/nav.php';

?>
<form class="form-horizontal panel panel-primary" method="post">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-fw fa-plus"></i>
<span>Ürün Düzenle : <?php print $urun['ad']; ?></span>
</h1>
</div>
<div class="panel-body">
<?php mesaj_bilgi(
    'Ürünü oluşturduktan sonra <q><strong>Ürün Düzenle</strong></q> '.
    'sayfasından ürüne özellik ekleyebilirsiniz.'
); ?>
<div class="form-group">
<div class="input-group">
<span class="input-group-addon" data-focus-to="ad">
<i class="fa fa-align-justify fa-fw"></i>
</span>
<?php print '<input class="form-control" id="ad" name="urun[ad]" '.
            'placeholder="Ad" required type="text" '.
            'value="'.dolu_mu($urun['ad']).'"/>'.PHP_EOL; ?>
</div>
</div>
<div class="form-group">
<div class="input-group">
<span class="input-group-addon" data-focus-to="birim">
<i class="fa fa-align-justify fa-fw"></i>
</span>
<select class="form-control" id="birim" name="urun[birim]">
<option<?php
    secili_olsun_mu('', $urun['birim']);
?>>&mdash; Birim Seçiniz &mdash;</option>
<option value="adet"<?php
    secili_olsun_mu('adet', $urun['birim']);
?>>Adet</option>
<option value="kilogram"<?php
    secili_olsun_mu('kilogram', $urun['birim']);
?>>Kilogram</option>
<option value="litre"<?php
    secili_olsun_mu('litre', $urun['birim']);
?>>Litre</option>
</select>
</div>
</div>
<div class="form-group">
<div class="input-group">
<span class="input-group-addon" data-focus-to="fiyat">
<i class="fa fa-fw fa-try"></i>
</span>
<?php print '<input class="form-control" id="fiyat" name="urun[fiyat]" '.
            'placeholder="Fiyat" required type="text" '.
            'value="'.dolu_mu($urun['fiyat']).'"/>'.PHP_EOL; ?>
</div>
</div>
<div class="form-group">
<div class="input-group">
<span class="input-group-addon" data-focus-to="vergi">
<i class="fa fa-fw fa-scissors"></i>
</span>
<?php print '<input class="form-control" id="vergi" name="urun[vergi]" '.
            'placeholder="Vergi oranı" required type="text" '.
            'value="'.dolu_mu($urun['vergi']).'"/>'.PHP_EOL; ?>
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
