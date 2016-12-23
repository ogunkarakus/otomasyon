<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

if (false === giris_yapilmis_mi()) {
    header('Location: giris.php', true, 303);

    exit();
}

if (false === is_numeric($_GET['id'])) {
    $adres = 'kullanicilar.php';

    $_SESSION['mesajlar'][] = mesaj_uyari(
        'Kullanıcı düzenleme işlemine devam etmek için geçe'.
        'rli bir kullanıcı numarası gereklidir.',
        true
    );

    header('Location: kullanicilar.php', true, 303);

    exit();
}

$kullanici = kullanici(intval($_GET['id']), true);

if (empty($kullanici)) {
    $adres = 'kullanicilar.php';

    $_SESSION['mesajlar'][] = mesaj_uyari(
        'Kullanıcı düzenleme işlemine devam etmek için geçe'.
        'rli bir kullanıcı numarası gereklidir.',
        true
    );

    header('Location: kullanicilar.php', true, 303);

    exit();
}

if (isset($_POST['ad']) &&
    isset($_POST['soyad']) &&
    isset($_POST['e_p_a'])) {
    if (false === filter_var($_POST['e_p_a'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mesajlar'][] = mesaj_uyari(
            'Elektronik posta adresini doğru bir biçimde girmediniz.',
            true
        );

        goto sayfa;
    }

    $guncellendi_mi = kullanici_guncelle(
        intval($_GET['id']),
        $_POST['ad'],
        $_POST['soyad'],
        $_POST['e_p_a'],
        $_POST['s_f_r']
    );

    if (false === $guncellendi_mi) {
        goto sayfa;
    } else {
        if ($kullanici['id'] == $_SESSION['kullanici']['id']) {
            $e_p_a = $kullanici['elektronik_posta_adresi'];
            $e_p_a_d_i = $e_p_a !== $_POST['e_p_a'];
            $s_f_r_d_i = false === empty($_POST['s_f_r']);

            if ($e_p_a_d_i || $s_f_r_d_i) {
                header('Location: cikis.php?yap=mesaj_gosterme', true, 303);

                exit();
            }

            $_SESSION['kullanici'] = kullanici(intval($_GET['id']), true);
        }

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

define('baslik', 'Kullanıcı Düzenle');
define('stil', $stil);

require str_replace('\\', '/', __DIR__).'/ust.php';

?><div class="container-fluid"><?php

require str_replace('\\', '/', __DIR__).'/nav.php';

?>
<form class="form-horizontal panel panel-primary" method="post">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-edit fa-fw"></i>
<span>Kullanıcı Düzenle</span>
</h1>
</div>
<div class="panel-body">
<?php mesaj_bilgi(
    'Şifre alanı boş geçildiği takdirde var olan şifre kullanıl'.
    'maya devam edilecektir.'
); ?>
<div class="form-group">
<?php print '<label for="ad" class="control-label sr-only"' .
            '>Ad</label>' . PHP_EOL; ?>
<div class="input-group">
<span class="input-group-addon" data-focus-to="ad">
<i class="fa fa-fw fa-user-o"></i>
</span>
<?php print '<input class="form-control" id="ad" name="ad" '.
            'placeholder="Ad" required type="text" '.
            'value="'.$kullanici['ad'].'"/>'.PHP_EOL; ?>
</div>
</div>
<div class="form-group">
<?php print '<label for="soyad" class="control-label sr-only"' .
            '>Soyad</label>' . PHP_EOL; ?>
<div class="input-group">
<span class="input-group-addon" data-focus-to="soyad">
<i class="fa fa-fw fa-user-o"></i>
</span>
<?php print '<input class="form-control" id="soyad" name="soyad" '.
            'placeholder="Soyad" required type="text" '.
            'value="'.$kullanici['soyad'].'"/>'.PHP_EOL; ?>
</div>
</div>
<div class="form-group">
<?php print '<label for="e-p-a" class="control-label sr-only"' .
            '>Elektronik posta adresi</label>' . PHP_EOL; ?>
<div class="input-group">
<span class="input-group-addon" data-focus-to="e-p-a">
<i class="fa fa-envelope-o fa-fw"></i>
</span>
<?php print '<input class="form-control" id="e-p-a" name="e_p_a" '.
            'placeholder="Elektronik posta adresi" required type="email" '.
            'value="'.$kullanici['elektronik_posta_adresi'].'"/>'.PHP_EOL; ?>
</div>
</div>
<div class="form-group">
<?php print '<label for="s-f-r" class="control-label sr-only"'.
            '>Şifre</label>' . PHP_EOL; ?>
<div class="input-group">
<span class="input-group-addon" data-focus-to="s-f-r">
<i class="fa fa-fw fa-key"></i>
</span>
<?php print '<input class="form-control" id="s-f-r" name="s_f_r" '.
            'placeholder="Şifre" type="password"/>' .
            PHP_EOL; ?>
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
