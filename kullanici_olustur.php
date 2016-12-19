<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

if (false === giris_yapilmis_mi()) {
    header('Location: giris.php', true, 303);

    exit();
}

if (isset($_POST['kullanici'])) {
    $olusturuldu_mu = kullanici_olustur($_POST['kullanici']);

    if (false === $olusturuldu_mu) {
        goto sayfa;
    } else {
        header('Location: kullanicilar.php', true, 303);

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

define('baslik', 'Kullanıcı Oluştur');
define('stil', $stil);

$kullanici = isset($_POST['kullanici']) ? $_POST['kullanici'] : [
    'ad' => '',
    'soyad' => '',
    'e_p_a' => '',
];

require str_replace('\\', '/', __DIR__).'/ust.php';

?><div class="container-fluid"><?php

require str_replace('\\', '/', __DIR__).'/nav.php';

?>
<form class="panel panel-primary form-horizontal" method="post">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-fw fa-user-plus"></i>
<span>Kullanıcı Oluştur</span>
</h1>
</div>
<div class="panel-body">
<div class="form-group">
<?php print '<label for="ad" class="control-label sr-only"' .
            '>Ad</label>' . PHP_EOL; ?>
<div class="input-group">
<span class="input-group-addon" data-focus-to="ad">
<i class="fa fa-fw fa-user"></i>
</span>
<?php print '<input class="form-control" id="ad" name="kullanici[ad]" '.
            'placeholder="Ad" required type="text" '.
            'value="'.dolu_mu($kullanici['ad']).'"/>'.PHP_EOL; ?>
</div>
</div>
<div class="form-group">
<?php print '<label for="soyad" class="control-label sr-only"' .
            '>Soyad</label>' . PHP_EOL; ?>
<div class="input-group">
<span class="input-group-addon" data-focus-to="soyad">
<i class="fa fa-fw fa-user-o"></i>
</span>
<?php print '<input class="form-control" id="soyad" name="kullanici[soyad]" '.
            'placeholder="Soyad" required type="text" '.
            'value="'.dolu_mu($kullanici['soyad']).
            '"/>'.PHP_EOL; ?>
</div>
</div>
<div class="form-group">
<?php print '<label for="e-p-a" class="control-label sr-only"' .
            '>Elektronik posta adresi</label>' . PHP_EOL; ?>
<div class="input-group">
<span class="input-group-addon" data-focus-to="e-p-a">
<i class="fa fa-envelope-o fa-fw"></i>
</span>
<?php print '<input class="form-control" id="e-p-a" name="kullanici[e_p_a]" '.
            'placeholder="Elektronik posta adresi" required type="email"'.
            'value="'.dolu_mu($kullanici['e_p_a']).
            '"/>'.PHP_EOL; ?>
</div>
</div>
<div class="form-group">
<?php print '<label for="s-f-r" class="control-label sr-only"'.
            '>Şifre</label>' . PHP_EOL; ?>
<div class="input-group">
<span class="input-group-addon" data-focus-to="s-f-r">
<i class="fa fa-fw fa-key"></i>
</span>
<?php print '<input class="form-control" id="s-f-r" name="kullanici[s_f_r]" '.
            'placeholder="Şifre" required type="password"/>' .
            PHP_EOL; ?>
</div>
</div>
</div>
<div class="panel-footer">
<button class="btn btn-block btn-success">
<i class="fa fa-fw fa-save"></i>
<span>Kaydet</span>
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
