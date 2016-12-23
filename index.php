<?php

require str_replace('\\', '/', __DIR__).'/baslat.php';

if (false === giris_yapilmis_mi()) {
    header('Location: giris.php', true, 303);

    exit();
}

$stil = <<<STIL
body { padding-bottom: 15px; padding-top: 15px; }
.panel { margin-bottom: 15px; }
.panel-body > *:last-child,
.panel-body .row > *:last-child > .panel { margin-bottom: 0; }
.panel-body > p { margin-bottom: 0; }
STIL;

define('baslik', 'Ana Sayfa');
define('stil', $stil);

$istatistikler = istatistikler();

require str_replace('\\', '/', __DIR__).'/ust.php';

?><div class="container-fluid"><?php

require str_replace('\\', '/', __DIR__).'/nav.php';

?>
<div class="panel panel-primary">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-fw fa-pie-chart"></i>
<span>İstatistikler</span>
</h1>
</div>
<div class="panel-body">
<div class="row">
<div class="col-lg-12 col-md-12">
<div class="panel panel-primary">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-fw fa-line-chart"></i>
<span>Genel</span>
</h1>
</div>
<div class="panel-body">
<p class="small">
<strong>Bu ay kazanılan miktar</strong>
<span>:</span>
<span><?php
    print $istatistikler['genel']['b_a_k_m'];
?><i class="fa fa-fw fa-try"></i></span>
</p>
<p class="small">
<strong>Bu yıl kazanılan miktar</strong>
<span>:</span>
<span><?php
    print $istatistikler['genel']['b_y_k_m'];
?><i class="fa fa-fw fa-try"></i></span>
</p>
<p class="small">
<strong>Tüm zamanlar boyunca kazanılan miktar</strong>
<span>:</span>
<span><?php
    print $istatistikler['genel']['t_z_b_k_m'];
?><i class="fa fa-fw fa-try"></i></span>
</p>
</div>
</div>
</div>
<div class="col-lg-4 col-md-4">
<div class="panel panel-primary">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-fw fa-files-o"></i>
<span>Faturalar</span>
</h1>
</div>
<div class="panel-body">
<p class="small">
<strong>Toplam fatura adedi</strong>
<span>:</span>
<span><?php print $istatistikler['fatura']['adet']; ?></span>
</p>
</div>
</div>
</div>
<div class="col-lg-4 col-md-4">
<div class="panel panel-primary">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-fw fa-users"></i>
<span>Kullanıcılar</span>
</h1>
</div>
<div class="panel-body">
<p class="small">
<strong>Toplam kullanıcı adedi</strong>
<span>:</span>
<span><?php print $istatistikler['kullanici']['adet']; ?></span>
</p>
</div>
</div>
</div>
<div class="col-lg-4 col-md-4">
<div class="panel panel-primary">
<div class="panel-heading">
<h1 class="panel-title">
<i class="fa fa-cubes fa-fw"></i>
<span>Ürünler</span>
</h1>
</div>
<div class="panel-body">
<p class="small">
<strong>Toplam ürün adedi</strong>
<span>:</span>
<span><?php print $istatistikler['urun']['adet']; ?></span>
</p>
</div>
</div>
</div>
</div>
</div>
</div>
<?php

$kod = <<<KOD
KOD;

define('kod', $kod);

?></div>
<?php

require str_replace('\\', '/', __DIR__).'/alt.php';
