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
.table, .table-responsive { margin-bottom: 0; }
STIL;

define('baslik', 'Kategoriler');
define('stil', $stil);

$kategoriler = kategoriler();

require str_replace('\\', '/', __DIR__).'/ust.php';

?><div class="container-fluid"><?php

require str_replace('\\', '/', __DIR__).'/nav.php';

?>
<div class="panel panel-primary">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-fw fa-sitemap"></i>
<span>Kategoriler</span>
</h1>
</div>
<div class="panel-body">
<div class="table-responsive">
<table class="table table-bordered">
<thead>
<tr>
<th class="small" style="cursor: help;" title="Kayıt Numarası">#</th>
<th class="small">Ad</th>
<th class="small">Açıklama</th>
<th class="small">Kayıt Zamanı</th>
<th class="small">Güncelleme Zamanı</th>
<th class="small">İşlemler</th>
</tr>
</thead>
<tbody>
<?php if (empty($kategoriler)): ?>
<tr>
<td colspan="6">
<?php mesaj_uyari('Gösterilebilir kategori verisi bulunamadı.'); ?>
</td>
</tr>
<?php else: ?>
<?php foreach ($kategoriler as $kategori): ?>
<tr>
<td class="small"><?php print $kategori['id']; ?></td>
<td class="small"><?php print $kategori['ad']; ?></td>
<td class="small"><?php print $kategori['aciklama']; ?></td>
<td class="small"><?php print $kategori['kayit_zamani']; ?></td>
<td class="small"><?php print $kategori['guncelleme_zamani']; ?></td>
<td class="small">
<a class="btn btn-success btn-sm" href="kategori.php?id=<?php
    print $kategori['id'];
?>" title="Görüntüle">
<i class="fa fa-fw fa-eye"></i>
<span>Görüntüle</span>
</a>
<a class="btn btn-warning btn-sm" href="kategori_duzenle.php?id=<?php
    print $kategori['id'];
?>" title="Düzenle">
<i class="fa fa-fw fa-pencil"></i>
<span>Düzenle</span>
</a>
<a class="btn btn-danger btn-sm" href="kategori_sil.php?id=<?php
    print $kategori['id'];
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
<?php print '<a class="btn btn-block btn-success" '.
            'href="kategori_olustur.php" title="K'.
            'ategori Oluştur">'.PHP_EOL; ?>
<i class="fa fa-fw fa-plus"></i>
<span>Kategori Oluştur</span>
</a>
</div>
</div>
<?php

$kod = <<<KOD
$(document).ready(function () {
    $('a[href*="kategori_sil.php?id="').on('click', function (e) {
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
