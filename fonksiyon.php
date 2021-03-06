<?php

function dolu_mu($girdi) {
    return false === empty($girdi) ? $girdi : '';
}

function faturalar() {
    return vt(function ($vt) {
        $stmt = $vt->prepare(
            'select * from `faturalar`'
        );

        return sonuclar($stmt);
    });
}

function giris_yapilmis_mi() {
    return isset($_SESSION['oturum']) && $_SESSION['oturum'];
}

function giris_yapmayi_dene($elektronik_posta_adresi, $sifre) {
    return vt(function ($vt) use ($elektronik_posta_adresi, $sifre) {
        $sonuc = false;

        $stmt = $vt->prepare(
            'select * from `kullanicilar` where '.
            '`elektronik_posta_adresi` = :elektronik_posta_adresi and '.
            '`sifre` = sha1(:sifre) limit 1'
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

function ilk_harfi_buyuk_yap($dizge) {
    $ilk_harf = mb_strtoupper(mb_substr($dizge, 0, 1));

    return $ilk_harf.mb_substr($dizge, 1);
}

function istatistik_fatura() {
    return vt(function ($vt) {
        $stmt = $vt->prepare(
            'select count(`id`) as `adet` from `faturalar`'
        );

        return sonuclar($stmt, true);
    });
}

function istatistik_genel() {
    return vt(function ($vt) {
        $sonuclar = [];

        // Bu ay kazanılan miktar
        $sonuclar['b_a_k_m'] = para(0);
        // Bu yıl kazanılan miktar
        $sonuclar['b_y_k_m'] = para(0);
        // Tüm zamanlar boyunca kazanılan miktar
        $sonuclar['t_z_b_k_m'] = para(0);

        return $sonuclar;
    });
}

function istatistik_kullanici() {
    return vt(function ($vt) {
        $stmt = $vt->prepare(
            'select count(`id`) as `adet` from `kullanicilar`'
        );

        return sonuclar($stmt, true);
    });
}

function istatistik_urun() {
    return vt(function ($vt) {
        $stmt = $vt->prepare(
            'select count(`id`) as `adet` from `urunler`'
        );

        return sonuclar($stmt, true);
    });
}

function istatistikler() {
    return [
        'fatura' => istatistik_fatura(),
        'genel' => istatistik_genel(),
        'kullanici' => istatistik_kullanici(),
        'urun' => istatistik_urun(),
    ];
}

function karakter_seti_ayarla($karakter_seti, $karakter_kumesi) {
    vt(function ($vt) use ($karakter_seti, $karakter_kumesi) {
        $vt->query('set names '.$karakter_seti.' collate '.$karakter_kumesi);
        $vt->query('set character_set_client = '.$karakter_seti);
        $vt->query('set character_set_connection = '.$karakter_seti);
        $vt->query('set character_set_results = '.$karakter_seti);
        $vt->query('set collation_connection = '.$karakter_kumesi);
    });
}

function kullanici($id, $zorla = false) {
    if ($id === intval($_SESSION['kullanici']['id']) && false === $zorla) {
        return $_SESSION['kullanici'];
    }

    return vt(function ($vt) use ($id) {
        $stmt = $vt->prepare(
            'select * from `kullanicilar` where `id` = :id limit 1'
        );

        $stmt->bindParam('id', $id, PDO::PARAM_INT);

        return sonuclar($stmt, true);
    });
}

function kullanicilar() {
    return vt(function ($vt) {
        $stmt = $vt->prepare(
            'select * from `kullanicilar`'
        );

        return sonuclar($stmt);
    });
}

function kullanici_guncelle(
    $id,
    $ad,
    $soyad,
    $elektronik_posta_adresi,
    $sifre
) {
    return vt(function ($vt) use (
        $id,
        $ad,
        $soyad,
        $elektronik_posta_adresi,
        $sifre
    ) {
        $sorgu = 'update `kullanicilar` set `ad` = :ad, `soyad` = :soyad, '.
                 '`elektronik_posta_adresi` = :elektronik_posta_adresi, '.
                 '`guncelleme_zamani` = now()';

        if (false === empty($sifre)) {
            $sifre = sha1($sifre);

            $sifre_stmt_parametre_gonder = function ($stmt, $sifre) {
                $stmt->bindParam('sifre', $sifre, PDO::PARAM_STR);
            };

            $sorgu .= ', `sifre` = :sifre';
        }

        $sorgu .= ' where `id` = :id limit 1';

        $stmt = $vt->prepare($sorgu);

        $stmt->bindParam('ad', $ad, PDO::PARAM_STR);
        $stmt->bindParam('soyad', $soyad, PDO::PARAM_STR);
        $stmt->bindParam(
            'elektronik_posta_adresi',
            $elektronik_posta_adresi,
            PDO::PARAM_STR
        );

        if (isset($sifre_stmt_parametre_gonder)) {
            $sifre_stmt_parametre_gonder($stmt, $sifre);
        }

        $stmt->bindParam('id', $id, PDO::PARAM_INT);

        if (false === $stmt->execute()) {
            $_SESSION['mesajlar'][] = mesaj_hata(
                'Sorgu çalıştırılması sırasında bir hata ile karşılaşıldı. '.
                'İşlem iptal edildi.',
                true
            );

            return false;
        }

        $ek = '';

        if (intval($id) === intval($_SESSION['kullanici']['id'])) {
            $kullanici = $_SESSION['kullanici'];
            $kullanici_e_p_a = $kullanici['elektronik_posta_adresi'];
            $e_p_a_d_m = $kullanici_e_p_a !== $elektronik_posta_adresi;
            $s_f_r_d_m = false === empty($sifre);

            if ($e_p_a_d_m || $s_f_r_d_m) {
                $ek = ' Yeni giriş bilgilerinizi kullanarak '.
                      'giriş yapabilirsiniz.';
            }
        }

        $_SESSION['mesajlar'][] = mesaj_basari(
            'Kullanıcı düzenleme işlemi başarıyla tamamlandı.'.$ek,
            true
        );

        return true;
    });
}

function kullanici_olustur($kullanici) {
    return vt(function ($vt) use ($kullanici) {
        $mesajlar = [];

        if (empty($kullanici['ad'])) {
            $mesajlar[] = 'Ad boş geçilemez.';
        }

        if (empty($kullanici['soyad'])) {
            $mesajlar[] = 'Soyad boş geçilemez.';
        }

        if (empty($kullanici['e_p_a'])) {
            $mesajlar[] = 'Elektronik posta adresi boş geçilemez.';
        }

        if (empty($kullanici['s_f_r'])) {
            $mesajlar[] = 'Şifre boş geçilemez.';
        }

        if (count($mesajlar) > 0) {
            foreach ($mesajlar as $mesaj) {
                $_SESSION['mesajlar'][] = mesaj_uyari($mesaj, true);
            }

            return false;
        }

        $sifre_uzunluk = strlen($kullanici['s_f_r']);

        if ($sifre_uzunluk < 6 || $sifre_uzunluk > 20) {
            $_SESSION['mesajlar'][] = mesaj_uyari(
                'Şifre altı karakterden kısa v'.
                'e yirmi karakterden uzun olamaz.',
                true
            );

            return false;
        }

        if (false === filter_var($kullanici['e_p_a'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['mesajlar'][] = mesaj_hata(
                'Elektronik posta adresini doğru bir biçimde girmediniz.',
                true
            );

            return false;
        }

        $stmt = $vt->prepare(
            'select count(`id`) as `adet` from `kullanicilar` where '.
            '`elektronik_posta_adresi` = :elektronik_posta_adresi'
        );

        $stmt->bindParam(
            'elektronik_posta_adresi',
            $kullanici['e_p_a'],
            PDO::PARAM_STR
        );

        $sonuc = sonuclar($stmt, true);

        if (false === $sonuc) {
            $_SESSION['mesajlar'][] = mesaj_hata(
                'Sorgu çalıştırılması sırasında bir hata ile karşılaşıldı. '.
                'İşlem iptal edildi.',
                true
            );

            return false;
        }

        if ($sonuc['adet'] > 0) {
            $_SESSION['mesajlar'][] = mesaj_hata(
                $kullanici['e_p_a'].' elektronik posta adresini bir '.
                'başka kullanıcı kullanıyor. Her bir elektronik posta adresi '.
                'sadece bir kullanıcı ile ilişkilendirilebilir.',
                true
            );

            return false;
        }

        $stmt = $vt->prepare(
            'insert into `kullanicilar` set `ad` = :ad, `soyad` = :soyad, '.
            '`elektronik_posta_adresi` = :elektronik_posta_adresi, '.
            '`sifre` = :sifre, `kayit_zamani` = now(), `guncelleme_'.
            'zamani` = now()'
        );

        $stmt->bindParam('ad', $kullanici['ad'], PDO::PARAM_STR);
        $stmt->bindParam('soyad', $kullanici['soyad'], PDO::PARAM_STR);
        $stmt->bindParam(
            'elektronik_posta_adresi',
            $kullanici['e_p_a'],
            PDO::PARAM_STR
        );
        $stmt->bindParam('sifre', sha1($kullanici['s_f_r']), PDO::PARAM_STR);

        if (false === $stmt->execute()) {
            $_SESSION['mesajlar'][] = mesaj_hata(
                'Sorgu çalıştırılması sırasında bir hata ile karşılaşıldı. '.
                'İşlem iptal edildi.',
                true
            );

            return false;
        }

        $_SESSION['mesajlar'][] = mesaj_basari(
            'Kullanıcı oluşturma işlemi başarıyla tamamlandı.',
            true
        );

        return true;
    });
}

function kullanici_sil($id) {
    return vt(function ($vt) use ($id) {
        if ($id === intval($_SESSION['kullanici']['id'])) {
            goto giris_yaptigi_kullanici;
        }

        $sonuclar = sonuclar($vt->prepare(
            'select count(`id`) as `adet` from `kullanicilar`'
        ), true);

        if ($sonuclar['adet'] <= 1) {
            giris_yaptigi_kullanici:

            return mesaj_hata(
                'Giriş yapmış olduğunuz kullanıcı hesabını silemezsiniz.',
                true
            );
        }

        $stmt = $vt->prepare(
            'delete from `kullanicilar` where `id` = :id limit 1'
        );

        $stmt->bindParam('id', $id, PDO::PARAM_INT);

        if (false === $stmt->execute()) {
            return mesaj_hata(
                'Sorgu çalıştırılması sırasında bir hata ile karşılaşıldı. '.
                'İşlem iptal edildi.',
                true
            );
        }

        return mesaj_basari(
            'Kullanıcı silme işlemi başarıyla tamamlandı.',
            true
        );
    });
}

function mesaj($tur, $ikon, $mesaj, $don = false) {
    $kod = sprintf(
        '<div class="alert alert-%s"><p class="small">'.
        '<i class="fa fa-fw fa-%s"></i><span style="margin-left: 5px">'.
        '%s</span></p></div>'.PHP_EOL,
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
        return mesaj('danger', 'times-circle', $mesaj, $don);
    }

    mesaj('danger', 'times-circle', $mesaj);
}

function mesaj_uyari($mesaj, $don = false) {
    if ($don) {
        return mesaj('warning', 'exclamation-circle', $mesaj, $don);
    }

    mesaj('warning', 'exclamation-circle', $mesaj);
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

function mi($adres) {
    return false !== strpos($_SERVER['PHP_SELF'], $adres);
}

function ozellik($ozellik_id) {
    return vt(function ($vt) use ($ozellik_id) {
        $stmt = $vt->prepare(
            'select * from `ozellikler` where `id` = :id limit 1'
        );

        $stmt->bindParam('id', $ozellik_id, PDO::PARAM_INT);

        return sonuclar($stmt, true);
    });
}

function ozellik_guncelle($ozellik_id, $ozellik) {
    return vt(function ($vt) use ($ozellik_id, $ozellik) {
        $stmt = $vt->prepare(
            'update `ozellikler` set `anahtar` = :anahtar, '.
            '`deger` = :deger, `guncelleme_zamani` = now() where `id` = :id'
        );

        $stmt->bindParam('anahtar', $ozellik['anahtar'], PDO::PARAM_STR);
        $stmt->bindParam('deger', $ozellik['deger'], PDO::PARAM_STR);
        $stmt->bindParam('id', $ozellik_id, PDO::PARAM_INT);

        if (false === $stmt->execute()) {
            $_SESSION['mesajlar'][] = mesaj_hata(
                'Sorgu çalıştırılması sırasında bir hata ile karşılaşıldı. '.
                'İşlem iptal edildi.',
                true
            );

            return false;
        }

        $_SESSION['mesajlar'][] = mesaj_basari(
            'Özellik güncelleme işlemi başarıyla tamamlandı.',
            true
        );

        return true;
    });
}

function urun_ozellik_sil($urun_id, $ozellik_id) {
    return vt(function ($vt) use($urun_id, $ozellik_id) {
        $stmt = $vt->prepare(
            'select count(`id`) as `adet` from `urunler` where `id` = :id'
        );

        $stmt->bindParam('id', $urun_id, PDO::PARAM_INT);

        $sonuclar = sonuclar($stmt, true);

        if ($sonuclar['adet'] <= 0) {
            return '';
        }

        $stmt = $vt->prepare(
            'select count(`id`) as `adet` from `ozellikler` where `id` = :id'
        );

        $stmt->bindParam('id', $ozellik_id, PDO::PARAM_INT);

        $sonuclar = sonuclar($stmt, true);

        if ($sonuclar['adet'] <= 0) {
            return mesaj_hata(
                'Özellik bulunamadı.',
                true
            );
        }

        $stmt = $vt->prepare(
            'delete from `ozellikler` where `id` = :id limit 1'
        );

        $stmt->bindParam('id', $ozellik_id, PDO::PARAM_INT);

        if (false === $stmt->execute()) {
            return mesaj_hata(
                'Sorgu çalıştırılması sırasında bir hata ile karşılaşıldı. '.
                'İşlem iptal edildi.',
                true
            );
        }

        $stmt = $vt->prepare(
            'delete from `urun_ozellik` where `urun_id` = :urun_id and '.
            '`ozellik_id` = :ozellik_id limit 1'
        );

        $stmt->bindParam('urun_id', $urun_id, PDO::PARAM_INT);
        $stmt->bindParam('ozellik_id', $ozellik_id, PDO::PARAM_INT);

        if (false === $stmt->execute()) {
            return mesaj_hata(
                'Sorgu çalıştırılması sırasında bir hata ile karşılaşıldı. '.
                'İşlem iptal edildi.',
                true
            );
        }

        return mesaj_basari(
            'Özellik silme başarıyla tamamlandı.',
            true
        );
    });
}

function para($sayi) {
    return number_format($sayi, 2, ',', '.');
}

function saati_ayarla() {
    return vt(function ($vt) {
        $vt->query('set @@session.time_zone = \'+03:00\'');
    });
}

function secili_olsun_mu($deger, $girdi) {
    print $deger === $girdi ? ' selected' : '';
}

function sonuc($stmt) {
    return sonuclar($stmt, true);
}

function sonuclar($stmt, $tek = false) {
    return vt(function ($vt) use ($stmt, $tek) {
        $sonuclar = [];

        if (false === $stmt->execute()) {
            goto sonuc;
        }

        if ($stmt->rowCount() <= 0) {
            goto sonuc;
        }

        if ($tek) {
            $sonuclar = $stmt->fetch(PDO::FETCH_ASSOC);

            goto sonuc;
        }

        while ($sonuc = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sonuclar[] = $sonuc;
        }

        sonuc:

        return $sonuclar;
    });
}

function urun($id) {
    return vt(function ($vt) use ($id) {
        $stmt = $vt->prepare(
            'select * from `urunler` where `id` = :id limit 1'
        );

        $stmt->bindParam('id', $id, PDO::PARAM_INT);

        return sonuclar($stmt, true);
    });
}

function urun_olustur($urun) {
    return vt(function ($vt) use ($urun) {
        $mesajlar = [];

        if (empty($urun['ad'])) {
            $mesajlar[] = 'Ad boş geçilemez.';
        }

        if (empty($urun['birim'])) {
            $mesajlar[] = 'Birim boş geçilemez.';
        }

        if (empty($urun['fiyat'])) {
            $mesajlar[] = 'Fiyat boş geçilemez.';
        }

        if (empty($urun['vergi'])) {
            $mesajlar[] = 'Vergi oranı boş geçilemez.';
        }

        if (count($mesajlar) > 0) {
            foreach ($mesajlar as $mesaj) {
                $_SESSION['mesajlar'][] = mesaj_uyari($mesaj, true);
            }

            return false;
        }

        $stmt = $vt->prepare(
            'insert into `urunler` set `ad` = :ad, `birim` = :birim, '.
            '`fiyat` = :fiyat, `vergi` = :vergi, '.
            '`ekleyen_kullanici_id` = :ekleyen_kullanici_id, '.
            '`kayit_zamani` = now(), `guncelleme_zamani` = now()'
        );

        $stmt->bindParam('ad', $urun['ad'], PDO::PARAM_STR);
        $stmt->bindParam('birim', $urun['birim'], PDO::PARAM_STR);
        $stmt->bindParam('fiyat', strval($urun['fiyat']), PDO::PARAM_STR);
        $stmt->bindParam('vergi', $urun['vergi'], PDO::PARAM_INT);
        $stmt->bindParam(
            'ekleyen_kullanici_id',
            $urun['ekleyen_kullanici_id'],
            PDO::PARAM_INT
        );

        if (false === $stmt->execute()) {
            $_SESSION['mesajlar'][] = mesaj_hata(
                'Sorgu çalıştırılması sırasında bir hata ile karşılaşıldı. '.
                'İşlem iptal edildi.',
                true
            );

            return false;
        }

        $urun_id = $vt->lastInsertId();

        $_SESSION['mesajlar'][] = mesaj_basari(
            'Ürün oluşturma işlemi başarıyla tamamlandı.',
            true
        );

        return $urun_id;
    });
}

function urun_guncelle($urun_id, $urun) {
    return vt(function ($vt) use ($urun_id, $urun) {
        $mesajlar = [];

        if (empty($urun['ad'])) {
            $mesajlar[] = 'Ad boş geçilemez.';
        }

        if (empty($urun['birim'])) {
            $mesajlar[] = 'Birim boş geçilemez.';
        }

        if (empty($urun['fiyat'])) {
            $mesajlar[] = 'Fiyat boş geçilemez.';
        }

        if (empty($urun['vergi'])) {
            $mesajlar[] = 'Vergi oranı boş geçilemez.';
        }

        if (count($mesajlar) > 0) {
            foreach ($mesajlar as $mesaj) {
                $_SESSION['mesajlar'][] = mesaj_uyari($mesaj, true);
            }

            return false;
        }

        $stmt = $vt->prepare(
            'update `urunler` set `ad` = :ad, `birim` = :birim, '.
            '`fiyat` = :fiyat, `vergi` = :vergi, '.
            '`guncelleme_zamani` = now() where `id` = :id limit 1'
        );

        $stmt->bindParam('ad', $urun['ad'], PDO::PARAM_STR);
        $stmt->bindParam('birim', $urun['birim'], PDO::PARAM_STR);
        $stmt->bindParam('fiyat', strval($urun['fiyat']), PDO::PARAM_STR);
        $stmt->bindParam('vergi', $urun['vergi'], PDO::PARAM_INT);
        $stmt->bindParam('id', $urun_id, PDO::PARAM_INT);

        if (false === $stmt->execute()) {
            $_SESSION['mesajlar'][] = mesaj_hata(
                'Sorgu çalıştırılması sırasında bir hata ile karşılaşıldı. '.
                'İşlem iptal edildi.',
                true
            );

            return false;
        }

        $_SESSION['mesajlar'][] = mesaj_basari(
            'Ürün güncelleme işlemi başarıyla tamamlandı.',
            true
        );

        return true;
    });
}

function urun_ozellikler($id) {
    return vt(function ($vt) use ($id) {
        $stmt = $vt->prepare(
            'select `ozellikler`.`id`, `ozellikler`.`anahtar`, '.
            '`ozellikler`.`deger` from '.
            '`ozellikler`, `urun_ozellik`, `urunler` where '.
            '`ozellikler`.`id` = `urun_ozellik`.`ozellik_id` and '.
            '`urun_ozellik`.`urun_id` = `urunler`.`id` and '.
            '`urunler`.`id` = :id'
        );

        $stmt->bindParam('id', $id, PDO::PARAM_INT);

        return sonuclar($stmt);
    });
}

function urune_ozellikleri_ekle($urun_id, $ozellikler) {
    return vt(function ($vt) use ($urun_id, $ozellikler) {
        $don = true;

        foreach ($ozellikler as $ozellik) {
            if (empty($ozellik['ad'])) {
                continue;
            }

            $stmt = $vt->prepare(
                'insert into `ozellikler` set `anahtar` = :ad, '.
                '`deger` = :deger, `kayit_zamani` = now(), '.
                '`guncelleme_zamani` = now()'
            );

            $stmt->bindParam('ad', $ozellik['ad'], PDO::PARAM_STR);
            $stmt->bindParam('deger', $ozellik['deger'], PDO::PARAM_STR);

            if (false === $stmt->execute()) {
                $_SESSION['mesajlar'][] = mesaj_hata(
                    'Sorgu çalıştırılması sırasında bir hata ile '.
                    ' karşılaşıldı. İşlem iptal edildi.',
                    true
                );

                $don = false;

                break;
            }

            $ozellik_id = $vt->lastInsertId();

            $stmt = $vt->prepare(
                'insert into `urun_ozellik` set `urun_id` = :urun_id, '.
                '`ozellik_id` = :ozellik_id'
            );

            $stmt->bindParam('urun_id', $urun_id, PDO::PARAM_INT);
            $stmt->bindParam('ozellik_id', $ozellik_id, PDO::PARAM_INT);

            if (false === $stmt->execute()) {
                $_SESSION['mesajlar'][] = mesaj_hata(
                    'Sorgu çalıştırılması sırasında bir hata ile '.
                    ' karşılaşıldı. İşlem iptal edildi.',
                    true
                );

                $don = false;

                break;
            }
        }

        if ($don) {
            $_SESSION['mesajlar'][] = mesaj_basari(
                'Ürüne özellik ekleme işlemi başarıyla tamamlandı.',
                true
            );
        }

        return $don;
    });
}

function urunler() {
    return vt(function ($vt) {
        $stmt = $vt->prepare(
            'select * from `urunler`'
        );

        return sonuclar($stmt);
    });
}

function vergi($miktar, $oran) {
    $oran = $oran <= 0 ? 1 : $oran;

    return $miktar + (($miktar / 100) * $oran);
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
