<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

if (giris_yapilmis_mi()) {
    header('Location: index.php', true, 303);
}

if (isset($_POST['e_p_a']) && isset($_POST['s_f_r'])) {
    $e_p_a = $_POST['e_p_a'];
    $s_f_r = $_POST['s_f_r'];

    if (false === filter_var($e_p_a, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mesajlar'][] = mesaj_uyari(
            'Elektronik posta adresini doğru bir biçimde girmediniz.',
            true
        );

        goto sayfa;
    }

    if (false === giris_yapmayi_dene($e_p_a, $s_f_r)) {
        $_SESSION['mesajlar'][] = mesaj_hata(
            'Elektronik posta adresi ya d'.
            'a şifre ile eşleşen kayıt bulunamadı.',
            true
        );

        goto sayfa;
    }

    $_SESSION['mesajlar'][] = mesaj_basari(
        'Giriş yapma işlemi başarıyla gerçekleştirildi.',
        true
    );

    header('Location: index.php', true, 303);

    exit();
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

$kod = <<<KOD
$("[data-focus-to]").on("click", function () {
$("#"+$(this).data("focus-to")).focus();
});
KOD;

define('baslik', 'Giriş Yap');
define('kod', $kod);
define('stil', $stil);

require str_replace('\\', '/', __DIR__).'/ust.php';

?>
<div class="container-fluid">
<div class="row">
<div class="col-lg-12">
<?php mesajlar(); ?>
<form class="panel panel-default form-horizontal" method="post">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-fw fa-sign-in"></i>
<span>Giriş Yap</span>
</h1>
</div>
<div class="panel-body">
<div class="form-group">
<?php print '<label for="e-p-a" class="control-label sr-only"' .
            '>Elektronik posta adresi</label>' . PHP_EOL; ?>
<div class="input-group">
<span class="input-group-addon" data-focus-to="e-p-a">
<i class="fa fa-envelope-o fa-fw"></i>
</span>
<?php print '<input class="form-control" id="e-p-a" name="e_p_a" '.
            'placeholder="Elektronik posta adresi" required type="email"/>'.
            PHP_EOL; ?>
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
            'placeholder="Şifre" required type="password"/>' .
            PHP_EOL; ?>
</div>
</div>
</div>
<div class="panel-footer">
<button class="btn btn-block btn-default" type="submit">
<i class="fa fa-fw fa-sign-in"></i>
</button>
</div>
</form>
</div>
</div>
</div>
<?php

require str_replace('\\', '/', __DIR__).'/alt.php';
