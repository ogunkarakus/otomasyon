<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

if (false === giris_yapilmis_mi()) {
    header('Location: giris.php', true, 303);

    exit();
}

if (false === isset($_GET['id']) || false === is_numeric($_GET['id'])) {
    $_SESSION['mesajlar'][] = mesaj_uyari(
        'Ürün özellik ekle işlemini yapabilmek için geçerli bir '.
        'ürün kayıt numarası gerekmektedir.',
        true
    );

    header('Location: urunler.php', true, 303);

    exit();
}

$urun = urun(intval($_GET['id']));

if (empty($urun)) {
    $_SESSION['mesajlar'][] = mesaj_hata(
        'Ürün kayıt numarasına ait ürün verisi bulunamadı.',
        true
    );

    header('Location: urunler.php', true, 303);

    exit();
}

if (isset($_POST['ozellik'])) {
    $olusturuldu_mu = urune_ozellikleri_ekle(
        intval($urun['id']),
        $_POST['ozellik']
    );

    if (false === $olusturuldu_mu) {
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
.panel-body > .property {
    background-color: #34495e;
    border-radius: 4px;
    margin-bottom: 15px;
    padding: 15px;
}
.panel-body > .property:last-child { margin-bottom: 0; }
.panel-body > .property > *:last-child { margin-bottom: 0; }
STIL;

define('baslik', 'Ürün Özellik Ekle : '.$urun['ad']);
define('stil', $stil);

require str_replace('\\', '/', __DIR__).'/ust.php';

?><div class="container-fluid"><?php

require str_replace('\\', '/', __DIR__).'/nav.php';

?>
<form class="form-horizontal panel panel-primary" method="post">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-fw fa-plus"></i>
<span>Ürün Özellik Ekle : <?php print $urun['ad']; ?></span>
</h1>
</div>
<div class="panel-body">
<?php for ($i = 0; $i < 1; $i++): ?>
<div class="property" data-property-index="<?php print $i; ?>">
<div class="form-group">
<div class="input-group">
<span class="input-group-addon" data-focus-to="ozellik_<?php print $i; ?>_ad">
<i class="fa fa-align-justify fa-fw"></i>
</span>
<?php print '<input class="form-control" id="ozellik_'.$i.'_ad" '.
            'name="ozellik['.$i.'][ad]" placeholder="Ad" '.
            'required type="text"/>'.PHP_EOL; ?>
</div>
</div>
<div class="form-group">
<div class="input-group">
<span class="input-group-addon" data-focus-to="ozellik_<?php
    print $i;
?>_deger">
<i class="fa fa-align-justify fa-fw"></i>
</span>
<?php print '<input class="form-control" id="ozellik_'.$i.'_deger" '.
            'name="ozellik['.$i.'][deger]" placeholder="Değer" '.
            'type="text"/>'.PHP_EOL; ?>
</div>
</div>
</div>
<?php endfor; ?>
<?php print '<button class="btn btn-block btn-inverse" '.
            'data-action="add-property-field" type="button">'.PHP_EOL; ?>
<i class="fa fa-fw fa-plus"></i>
<span>Yeni Özellik Alanı Ekle</span>
</button>
</div>
<div class="panel-footer">
<button class="btn btn-block btn-primary">
<i class="fa fa-fw fa-save"></i>
<span>Kaydet</span>
</button>
</div>
</form>
<?php

$kod = <<<KOD
$("div.input-group").delegate("[data-focus-to]", "click", function () {
$("#"+$(this).data("focus-to")).focus();
});
$("[data-action=\"add-property-field\"]").on("click", function () {
var last_index = $(".panel-body>.property").last().data("property-index");
var index = last_index + 1;
var html = "<div class=\"property\" data-property-index=\""+index+"\">\
<div class=\"form-group\">\
<div class=\"input-group\">\
<span class=\"input-group-addon\" data-focus-to=\"ozellik_"+index+"_ad\">\
<i class=\"fa fa-align-justify fa-fw\"></i>\
</span>\
<input class=\"form-control\"\
 id=\"ozellik_"+index+"_ad\" name=\"ozellik["+index+"][ad]\"\
 placeholder=\"Ad\" required type=\"text\"/>\
</div>\
</div>\
<div class=\"form-group\">\
<div class=\"input-group\">\
<span class=\"input-group-addon\" data-focus-to=\"ozellik_"+index+"_deger\">\
<i class=\"fa fa-align-justify fa-fw\"></i>\
</span>\
<input class=\"form-control\" id=\"ozellik_"+index+"_deger\"\
 name=\"ozellik["+index+"][deger]\" placeholder=\"Değer\"\
 type=\"text\"/>\
</div>\
</div>\
</div>";
$(".panel-body>.property").last().after(html);
$("div.input-group").delegate("[data-focus-to]", "click", function () {
$("#"+$(this).data("focus-to")).focus();
});
});
KOD;

define('kod', $kod);

?></div>
<?php

require str_replace('\\', '/', __DIR__).'/alt.php';
