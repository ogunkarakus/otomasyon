<?php

function giris_yapilmis_mi() {
    return isset($_SESSION['oturum']) && $_SESSION['oturum'];
}

function giris_yapmayi_dene($elektronik_posta_adresi, $sifre) {
    return vt(function ($vt) use ($elektronik_posta_adresi, $sifre) {
        $sonuc = false;

        $stmt = $vt->prepare(
            'select * from `kullanicilar` where '.
            '`elektronik_posta_adresi` = :elektronik_posta_adresi and '.
            '`sifre` = sha1(:sifre)'
        );

        $stmt->bindParam(
            'elektronik_posta_adresi',
            $elektronik_posta_adresi,
            PDO::PARAM_STR
        );
        $stmt->bindParam('sifre', $sifre, PDO::PARAM_STR);

        if (false === $stmt->execute()) {
            goto sonuc;
        }

        if ($stmt->rowCount() <= 0) {
            goto sonuc;
        }

        $_SESSION['kullanici'] = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['oturum'] = true;
        $sonuc = true;

        sonuc:

        return $sonuc;
    });
}

function hak_sahipligi() {
    printf(
        '&copy; %s, <a href="%s" target="_blank" title="%s">%s</a>',
        date('Y'),
        '//ogunkarakus.com.tr',
        'Ogün Karakuş',
        'Ogün Karakuş'
    );
}

function hata_izleyici($no, $mesaj, $dosya, $satir) {
    var_dump(compact('no', 'mesaj', 'dosya', 'satir'));
}

function icerik_saglayici($dosya_yolu) {
    printf(
        '//%s/ajax/libs/%s',
        'cdnjs.cloudflare.com',
        $dosya_yolu
    );
}

function karakter_seti_ayarla($karakter_seti, $karakter_kumesi) {
    vt(function ($vt) use ($karakter_seti, $karakter_kumesi) {
        $vt->query('set names '.$karakter_seti.' collate '.$karakter_kumesi);
        $vt->query('SET character_set_client = '.$karakter_seti);
        $vt->query('SET character_set_connection = '.$karakter_seti);
        $vt->query('SET character_set_results = '.$karakter_seti);
        $vt->query('SET collation_connection = '.$karakter_kumesi);
    });
}

function kullanicilar() {
    return vt(function ($vt) {
        $stmt = $vt->prepare(
            'select `id`, `ad`, `soyad`, `elektronik_pos'.
            'ta_adresi` from `kullanicilar`'
        );

        return sonuclar($stmt);
    });
}

function sonuclar($stmt) {
    return vt(function ($vt) use ($stmt) {
        $sonuclar = [];

        if (false === $stmt->execute()) {
            goto sonuc;
        }

        if ($stmt->rowCount() <= 0) {
            goto sonuc;
        }

        while ($sonuc = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sonuclar[] = $sonuc;
        }

        sonuc:

        return $sonuclar;
    });
}

function mesaj($tur, $ikon, $mesaj, $don = false) {
    $kod = sprintf(
        '<div class="alert alert-%s"><p><i class="fa fa-fw fa-%s"></i>'.
        '<span style="margin-left: 5px">%s</span></p></div>'.PHP_EOL,
        $tur,
        $ikon,
        $mesaj
    );

    if (false === $don) {
        print $kod;
    }

    return $kod;
}

function mesajlar() {
    if (isset($_SESSION['mesajlar'])) {
        foreach ($_SESSION['mesajlar'] as $mesaj_id => $mesaj) {
            print $mesaj;

            unset($_SESSION['mesajlar'][$mesaj_id]);
        }
    }
}

function mesaj_basari($mesaj, $don = false) {
    if ($don) {
        return mesaj('success', 'check-circle', $mesaj, $don);
    }

    mesaj('success', 'check-circle', $mesaj);
}

function mesaj_bilgi($mesaj, $don = false) {
    if ($don) {
        return mesaj('info', 'info-circle', $mesaj, $don);
    }

    mesaj('info', 'info-circle', $mesaj);
}

function mesaj_hata($mesaj, $don = false) {
    if ($don) {
        return mesaj('danger', 'exclamation-circle', $mesaj, $don);
    }

    mesaj('danger', 'exclamation-circle', $mesaj);
}

function mesaj_uyari($mesaj, $don = false) {
    if ($don) {
        return mesaj('warning', 'exclamation-triangle', $mesaj, $don);
    }

    mesaj('warning', 'exclamation-triangle', $mesaj);
}

function meta_googlebot() {
    meta_robots();
}

function meta_robots() {
    print 'noarchive,nofollow,noimageindex,noindex,'.
          'noodp,nosnippet,notranslate';
}

function meta_viewport() {
    print 'initial-scale=1,minimum-scale=1,maximum-scale=1,'.
          'user-scalable=no,width=device-width';
}

function vt($gc = null) {
    global $vt;

    return null === $gc ? $vt : $gc($vt);
}

function yazi_tipi($ad, $boyutlar, $diller) {
    printf(
        '//fonts.googleapis.com/css?family=%s:%s&amp;subset=%s',
        $ad,
        $boyutlar,
        $diller
    );
}
