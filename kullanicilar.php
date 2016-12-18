<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

if (false === giris_yapilmis_mi()) {
    header('Location: giris.php', true, 303);
}

$stil = <<<STIL
body { padding-bottom: 15px; padding-top: 15px; }
td, th { text-align: center; vertical-align: middle!important; }
td[colspan] .alert { margin-bottom: 0; }
.panel { margin-bottom: 15px; }
.table { margin-bottom: 0; }
STIL;

define('baslik', 'Kullanıcılar');
define('stil', $stil);

$kullanicilar = kullanicilar();

require str_replace('\\', '/', __DIR__).'/ust.php';

?><div class="container-fluid"><?php

require str_replace('\\', '/', __DIR__).'/nav.php';

?>
<div class="panel panel-primary">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-fw fa-users"></i>
<span>Kullanıcılar</span>
</h1>
</div>
<div class="panel-body">
<div class="table-responsive">
<table class="table table-bordered">
<thead>
<tr>
<th class="small" style="cursor: help;" title="Kayıt Numarası">#</th>
<th class="small">Ad</th>
<th class="small">Soyad</th>
<th class="small">Elektronik Posta Adresi</th>
<th class="small">Kayıt Zamanı</th>
<th class="small">Güncelleme Zamanı</th>
<th class="small">İşlemler</th>
</tr>
</thead>
<tbody>
<?php if (empty($kullanicilar)): ?>
<tr>
<td class="small" colspan="5">
<?php mesaj_uyari('Gösterilebilir kullanıcı verisi bulunamadı.'); ?>
</td>
</tr>
<?php else: ?>
<?php foreach ($kullanicilar as $kullanici): ?>
<tr>
<td class="small"><?php print $kullanici['id']; ?></td>
<td class="small"><?php print $kullanici['ad']; ?></td>
<td class="small"><?php print $kullanici['soyad']; ?></td>
<td class="small">
<a href="mailto:<?php
    print $kullanici['elektronik_posta_adresi'];
?>" target="_blank" title="<?php
    print $kullanici['elektronik_posta_adresi'];
?>">
<?php print $kullanici['elektronik_posta_adresi']; ?>
</a>
</td>
<td class="small"><?php print $kullanici['kayit_zamani']; ?></td>
<td class="small"><?php print $kullanici['guncelleme_zamani']; ?></td>
<td class="small">
<a class="btn btn-warning btn-sm" href="kullanici_duzenle.php?id=<?php
    print $kullanici['id'];
?>" title="Düzenle">
<i class="fa fa-fw fa-pencil"></i>
<span>Düzenle</span>
</a>
<a class="btn btn-danger btn-sm" href="kullanici_sil.php?id=<?php
    print $kullanici['id'];
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
<div class="panel-footer">
<?php print '<a class="btn btn-block btn-inverse" '.
            'href="kullanici_olustur.php" title="K'.
            'ullanıcı Oluştur">'.PHP_EOL; ?>
<i class="fa fa-fw fa-user-plus"></i>
<span>Kullanıcı Oluştur</span>
</a>
</div>
</div>
<?php

$kod = <<<KOD
$(document).ready(function () {
    $('a[href*="kullanici_sil.php?id="').on('click', function (e) {
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
