<div class="navbar navbar-inverse">
<div class="container-fluid">
<div class="navbar-header">
<?php print '<button aria-controls="navbar" aria-expanded="false"'.
            ' class="collapsed navbar-toggle" data-target="#navba'.
            'r" data-toggle="collapse" type="button">'.PHP_EOL; ?>
<span class="sr-only">Menüyü aç ya da kapat</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="index.php" title="Ana Sayfa">
<i class="fa fa-dashboard fa-fw"></i>
<span>Ana Sayfa</span>
</a>
</div>
<div class="collapse navbar-collapse" id="navbar">
<ul class="nav navbar-nav">
<?php $kullanicilar_mi = mi('kullanici'); ?>
<li<?php print $kullanicilar_mi ? ' class="active"' : ''; ?>>
<a href="kullanicilar.php" title="Kullanıcılar">
<i class="fa fa-fw fa-users"></i>
<span>Kullanıcılar</span>
</a>
</li>
<!--
<?php $siparisler_mi = mi('siparis'); ?>
<li<?php print $siparisler_mi ? ' class="active"' : ''; ?>>
<a href="siparisler.php" title="Siparişler">
<i class="fa fa-fw fa-shopping-cart"></i>
<span>Siparişler</span>
</a>
</li>
-->
<?php $urunler_mi = mi('urun'); ?>
<li<?php print $urunler_mi ? ' class="active"' : ''; ?>>
<a href="urunler.php" title="Ürünler">
<i class="fa fa-cubes fa-fw"></i>
<span>Ürünler</span>
</a>
</li>
</ul>
<ul class="nav navbar-nav navbar-right">
<li>
<a href="cikis.php" title="Çıkış Yap">
<i class="fa fa-fw fa-sign-out"></i>
<span>Çıkış Yap</span>
</a>
</li>
</ul>
</div>
</div>
</div>
<?php

mesajlar();
