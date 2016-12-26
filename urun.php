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

$ekleyen = kullanici(intval($urun['ekleyen_kullanici_id']));

$urun_ozellikler = urun_ozellikler(intval($_GET['id']));

sayfa:

$stil = <<<STIL
body { padding-bottom: 15px; padding-top: 15px; }
td, th { text-align: center; vertical-align: middle!important; }
.panel { margin-bottom: 15px; }
.table, .table-responsive { margin-bottom: 0; }
.table tr td:first-child { font-weight: bold; }
.table tbody tr td:first-child { width: 35%; }
.table tbody tr td:last-child { width: 60%; }
.table tbody tr td .alert { margin-bottom: 0; }
.panel-body > *:last-child { margin-bottom: 0; }
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
<div class="panel panel-primary">
<div class="panel-heading">
<h2 class="panel-title">Ürün Detayları</h2>
</div>
<div class="panel-body">
<div class="table-responsive">
<table class="table table-bordered">
<tbody>
<tr>
<td class="small">Ad</td>
<td class="small">:</td>
<td class="small"><?php print $urun['ad']; ?></td>
</tr>
<tr>
<td class="small">Fiyat (Vergisiz)</td>
<td class="small">:</td>
<td class="small"><?php
    print para($urun['fiyat']);
?><i class="fa fa-fw fa-try"></i></td>
</tr>
<tr>
<td class="small">Fiyat (Vergili)</td>
<td class="small">:</td>
<td class="small"><?php
    print para(vergi($urun['fiyat'], $urun['vergi']));
?><i class="fa fa-fw fa-try"></i></td>
</tr>
<tr>
<td class="small">Vergi Oranı</td>
<td class="small">:</td>
<td class="small"><?php print '%'.para($urun['vergi']); ?></td>
</tr>
<tr>
<td class="small">Ürünü Ekleyen</td>
<td class="small">:</td>
<td class="small">
<a href="kullanici_duzenle.php?id=<?php
    print $ekleyen['id'];
?>" target="_blank" title="<?php
    print $ekleyen['ad'].' '.$ekleyen['soyad'];
?>"><?php
    print $ekleyen['ad'].' '.$ekleyen['soyad'];
?></a>
</td>
</tr>
<tr>
<td class="small">Kayıt Zamanı</td>
<td class="small">:</td>
<td class="small"><?php print $urun['kayit_zamani']; ?></td>
</tr>
<tr>
<td class="small">Güncelleme Zamanı</td>
<td class="small">:</td>
<td class="small"><?php print $urun['guncelleme_zamani']; ?></td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
<div class="panel panel-primary">
<div class="panel-heading">
<h2 class="panel-title">Ürün Özellikleri</h2>
</div>
<div class="panel-body">
<div class="table-responsive">
<table class="table table-bordered">
<thead>
<tr>
<th class="small">Ad</th>
<th class="small">&nbsp;</th>
<th class="small">Değer</th>
<th class="small">İşlemler</th>
</tr>
</thead>
<tbody>
<?php if (empty($urun_ozellikler)): ?>
<tr>
<td colspan="4"><?php mesaj_bilgi(
    'Ürüne ait özellik verisi bulunamadı. '.
    '<a href="urun_ozellik_ekle.php?id='.$urun['id'].
    '" title="Ürüne Özellik Ekle">Buraya tıklayarak '.
    'ürüne özellik verisi ekleyebilirsiniz</a>.'
); ?></td>
</tr>
<?php else: ?>
<?php foreach ($urun_ozellikler as $urun_ozellik): ?>
<tr>
<td class="small" style="width: 35%"><?php
    print $urun_ozellik['anahtar'];
?></td>
<td class="small" style="width: 5%">:</td>
<td class="small" style="width: 35%"><?php
    print $urun_ozellik['deger'];
?></td>
<td class="small" style="width: 30%">
<a class="btn btn-warning btn-xs" href="urun_ozellik_duzenle.php?id=<?php
    print $urun_ozellik['id'];
?>&amp;urun_id=<?php
    print $urun['id'];
?>" title="Düzenle">
<i class="fa fa-fw fa-pencil"></i>
<span>Düzenle</span>
</a>
<a class="btn btn-danger btn-xs" href="urun_ozellik_sil.php?id=<?php
    print $urun_ozellik['id'];
?>&amp;urun_id=<?php
    print $urun['id'];
?>" title="Sil">
<i class="fa fa-fw fa-trash-o"></i>
<span>Sil</span>
</a>
</td>
</tr>
<?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
<div class="panel-footer">
<a class="btn btn-block btn-primary" href="urun_ozellik_ekle.php?id=<?php
    print $urun['id'];
?>" title="Ürüne Özellik Ekle">
<i class="fa fa-fw fa-plus"></i>
<span>Ürüne Özellik Ekle</span>
</a>
</div>
</div>
<?php

$kod = <<<KOD
$(document).ready(function () {
    $('a[href*="ozellik_sil.php?id="').on('click', function (e) {
        if (!confirm('İşleme devam etmek istediğinize emin misiniz?')) {
            e.preventDefault();
            return false;
        }
    })
})
KOD;

define('kod', $kod);

?></div>
<?php

require str_replace('\\', '/', __DIR__).'/alt.php';
