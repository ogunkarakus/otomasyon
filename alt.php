<div class="container-fluid">
<p class="small text-center" style="margin: 0"><?php hak_sahipligi(); ?></p>
</div>
<script src="<?php
    icerik_saglayici('jquery/3.1.1/jquery.min.js');
?>"></script>
<script src="<?php
    icerik_saglayici('twitter-bootstrap/3.3.7/js/bootstrap.min.js');
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
