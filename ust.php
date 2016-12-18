<!DOCTYPE html>
<html>
<head>
<link href="//fonts.googleapis.com" rel="dns-prefetch"/>
<link href="//fonts.gstatic.com" rel="dns-prefetch"/>
<link href="//cdnjs.cloudflare.com" rel="dns-prefetch"/>
<link href="<?php
    icerik_saglayici('twitter-bootstrap/3.3.7/css/bootstrap.min.css');
?>" rel="stylesheet"/>
<link href="<?php
    icerik_saglayici('flat-ui/2.3.0/css/flat-ui.min.css');
?>" rel="stylesheet"/>
<link href="<?php
    icerik_saglayici('font-awesome/4.7.0/css/font-awesome.min.css');
?>" rel="stylesheet"/>
<link href="<?php yazi_tipi(
    'Roboto',
    '100,100i,300,300i,400,400i,500,500i,700,700i,900,900i',
    'cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese'
); ?>" rel="stylesheet"/>
<link href="css/app.css" rel="stylesheet"/>
<meta charset="utf-8"/>
<meta content="<?php meta_googlebot(); ?>" name="googlebot"/>
<meta content="<?php meta_robots(); ?>" name="robots"/>
<meta content="<?php meta_viewport(); ?>" name="viewport"/>
<style><?php print defined('stil') ? stil : ''; ?></style>
<title><?php print defined('baslik') ? baslik : ''; ?></title>
</head>
<body>
