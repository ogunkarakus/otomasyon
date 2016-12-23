<div class="container-fluid">
<p class="small text-center" style="margin: 0"><?php hak_sahipligi(); ?></p>
<p class="small text-center"><?php
    print 'Bu yazılımın tüm kaynak kodları <a href="//unlicense.org" '.
          'target="_blank" title="Unlicense">lisanssız</a> bir şekilde '.
          '<a href="//github.com/ogunkarakus/otomasyon" target="_blank" '.
          'title="GitHub">GitHub</a> üzerinde yayınlanmıştır.';
?></p>
</div>
<script src="<?php
    icerik_saglayici('jquery/1.12.4/jquery.min.js');
?>"></script>
<script src="<?php
    icerik_saglayici('flat-ui/2.3.0/js/flat-ui.min.js');
?>"></script>
<script src="js/app.js"></script>
<script><?php print defined('kod') ? kod : ''; ?></script>
</body>
</html>
<?php

global $vt;

unset($vt);
