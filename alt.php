<div class="container-fluid">
<p class="small text-center" style="margin: 0"><?php hak_sahipligi(); ?></p>
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
