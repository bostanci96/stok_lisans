<?php
require_once ('../admin/host/a.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
#Logout
if ($_GET["p"] == "logout") {
    session_destroy();
    go(URL);
}
##Login
if ($_GET["p"] == "login") {
    $eposta = p("username");
    $md5 = md5(p("password"));
    if (!$eposta || $eposta == "username" || !$md5 || $md5 == "password") {
        echo '<div role="alert" class="alert alert-danger"><div class="alert-body">' . $bloklar["login_verification_one"] . '</div></div>';
    } else {
        $query = $db->prepare("SELECT * FROM uyeler WHERE uye_eposta=:eposta && uye_sifre=:sifre");
        $query->execute(array("eposta" => $eposta, "sifre" => $md5));
        $query->rowCount();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if ($query->rowCount()) {
            if ($row["uye_onay"] == 1) {
                uye_lang_check($row["uye_sitedil"]);
                $session = array("login" => true, "uye_id" => $row["uye_id"], "uye_lang" => $row["uye_sitedil"], "uye_eposta" => $row["uye_eposta"], "uye_rutbe" => $row["uye_rutbe"], "uye_adsoyad" => $row["uye_ad"] . " " . $row["uye_soyad"]);
                session_olustur($session);
                echo '<div role="alert" class="alert alert-success"><div class="alert-body">' . $bloklar["login_verification_two"] . '</div></div>';
                echo '<script type="text/javascript">window.location.href = "' . URL . '"</script>';
            } else {
                echo '<div role="alert" class="alert alert-warning"><div class="alert-body">' . $bloklar["login_verification_onay"] . '</div></div>';
            }
        } else {
            $query = $db->prepare("SELECT * FROM uyeler WHERE uye_eposta=:eposta ");
            $query->execute(array("eposta" => $eposta));
            $query->rowCount();
            $row = $query->fetch(PDO::FETCH_ASSOC);
            if ($query->rowCount()) {
                echo '<div role="alert" class="alert alert-warning"><div class="alert-body">' . $bloklar["login_verification_tree"] . '</div></div>';
            } else {
                echo '<div role="alert" class="alert alert-warning"><div class="alert-body">' . $bloklar["login_verification_four"] . '</div></div>';
            }
        }
    }
}
if ($_GET["p"] == "resetpassword") {
    $eposta = $_POST["username"];
    $query = $db->query("SELECT * FROM uyeler WHERE uye_eposta = '$eposta'");
    if (empty($eposta) or !filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="alert alert-warning">' . $bloklar["uye_sifremi_unuttum_bir"] . '</div>';
        exit();
    } else {
        $yeni_sifre = rand(10000, 99999);
        $yeni_sifre_md5 = md5($yeni_sifre);
        $uyedilcheck = $db->query("SELECT * FROM uyeler WHERE uye_eposta = '$eposta'")->fetch(PDO::FETCH_ASSOC);
        $sitelang = $uyedilcheck["uye_sitedil"];
        uye_lang_check($sitelang);
        dilCek();
        $update = $db->query("UPDATE uyeler SET uye_sifre = '$yeni_sifre_md5' WHERE uye_eposta = '$eposta'");
        if ($update) {
            require '../admin/host/mail_sablon/uye_sifre_sifirla.php';
            $mailgonder = MailXM($eposta, $bloklar["uye_sifremi_unuttum_bes"], $uye_sifre_sifirla);
            if ($mailgonder) {
                echo '<div class="alert alert-success">
				<strong>' . $bloklar["uye_sifremi_unuttum_dort"] . '</div>';
                echo '<script type="text/javascript">  setTimeout(function () {
					window.location.href = "' . URL . '"; 
				}, 4000); //will call the function after 2 secs.</script>';
                exit();
            } else {
                echo '<div class="alert alert-warning">' . $bloklar["uye_sifremi_unuttum_uc"] . '</div>';
                exit();
            }
        } else {
            echo '<div class="alert alert-warning">' . $bloklar["uye_sifremi_unuttum_iki"] . '</div>';
            exit();
        }
    }
}
if ($_GET["p"] == "register") {
    $name = p("name");
    $surname = p("surname");
    $phone = p("phone");
    $eposta = p("eposta");
    $sex = p("sex");
    $password = p("password");
    $passwordd = p("passwordd");
    @$sitelang = p("sitelang");
    @$privacypolicy = p("privacypolicy");
    if ($sitelang == 11) {
        $lang = "tr";
    } else {
        $lang = "en";
    }
    $random_code = RandomString();
    uye_lang_check($sitelang);
    dilCek();
    if (!$name || !$surname || !$phone || !$eposta || !$password || !$sitelang || !$privacypolicy) {
        echo '<div role="alert" class="alert alert-danger"><div class="alert-body">' . $bloklar["login_verification_one"] . '</div></div>';
    } elseif (!filter_var($eposta, FILTER_VALIDATE_EMAIL)) {
        echo '<div role="alert" class="alert alert-danger"><div class="alert-body">' . $bloklar["register_eror_one"] . '</div></div>';
    } else {
        $mailCheck = $db->query("SELECT * FROM uyeler WHERE uye_eposta='$eposta'");
        if ($mailCheck->rowCount()) {
            echo '<div role="alert" class="alert alert-danger"><div class="alert-body">' . $bloklar["register_eror_two"] . '</div></div>';
        } else {
            if ($password == $passwordd) {
                $password = md5($password);
                $insert = $db->query("INSERT into uyeler SET
				uye_ad	= '$name',
				uye_soyad	= '$surname',
				uye_telefon	= '$phone',
				uye_eposta	= '$eposta',
				uye_sifre	= '$password',
				uye_cinsiyet	= '$sex',
				uye_sitedil	= '$sitelang',
				uye_key	= '$random_code',
				uye_rutbe	= 1,
				uye_onay 	= 0");
                if ($insert->rowCount()) {
                    $last_insert_id = $db->lastInsertId();
                    require '../admin/host/mail_sablon/uyeonay_ileti.php';
                    if ($last_insert_id) {
                        $mailgonder = MailXM($eposta, $bloklar["register_mail_subject"], $uyeonay_ileti);
                        if ($mailgonder) {
                            echo '<div role="alert" class="alert alert-success"><div class="alert-body">' . $bloklar["register_succsess"] . '</div></div>';
                            echo '<script type="text/javascript">setTimeout(function () {window.location.href = "' . URL . '"; }, 6000);</script>';
                        } else {
                            echo '<div role="alert" class="alert alert-danger"><div class="alert-body">' . $bloklar["register_eror_tree"] . '</div></div>';
                        }
                    }
                } else {
                    echo '<div role="alert" class="alert alert-warning"><div class="alert-body">' . $bloklar["register_eror"] . '</div></div>';
                }
            } else {
                echo '<div role="alert" class="alert alert-warning"><div class="alert-body">Şifreler Uyuşmuyor!</div></div>';
            }
        }
    }
}
if ($_GET["p"] == "profileupdate") {
    $uye_id = p("uyeid");
    $name = p("name");
    $surname = p("surname");
    $phone = p("phone");
    $eposta = p("eposta");
    $sex = p("sex");
    @$profile_img = $_FILES["profile_img"]["tmp_name"][0];
    $resim_onad = $uye_id . "_";
    if (!$uye_id || !$name || !$surname || !$phone || !$eposta || !$sex) {
        echo 'bos-deger';
    }
    if ($profile_img) {
        $profile_imgyuk = imgAdd("profile_img", "profile_img", "uyeler", "uye_profil_img", "uye_id", $uye_id, $resim_onad);
        if ($profile_imgyuk) {
            echo 'basarili';
        }
    } else {
        $insert = $db->query("UPDATE uyeler SET 
			uye_ad 		= '$name',
			uye_soyad 		= '$surname',
			uye_telefon 		= '$phone',
			uye_cinsiyet 		= '$sex'
			WHERE uye_id='$uye_id'");
        if ($insert->rowCount()) {
            echo 'basarili';
        } else {
            echo 'basarisiz';
        }
    }
}
if ($_GET["p"] == "passwordupdate") {
    $uye_id = p("uyeid");
    $uye_sifre = md5(p("password"));
    $uye_sifre_2 = md5(p("password_two"));
    if (!$uye_id || !$uye_sifre || !$uye_sifre_2) {
        echo 'bos-deger';
    } elseif ($uye_sifre != $uye_sifre_2) {
        echo 'sifreler-uyusmuyor';
    } else {
        $insert = $db->query("UPDATE uyeler SET 
		uye_sifre =	'$uye_sifre' 
		 WHERE uye_id='$uye_id'");
        if ($insert->rowCount()) {
            echo 'basarili';
        } else {
            echo 'basarisiz';
        }
    }
}
if ($_GET["p"] == "contactform") {
    $uyeid = p("uyeid");
    $name = p("name");
    $surname = p("surname");
    $date = p("date");
    $phone = p("phone");
    $eposta = p("eposta");
    $uye_firma_adresi = p("uye_firma_adresi");
    $uye_firma_vergino = p("uye_firma_vergino");
    $uye_firmaunvan = p("uye_firmaunvan");
    $uye_firma_telefon = p("uye_firma_telefon");
    $uye_firma_email = p("uye_firma_email");
    $uye_firma_ulke = p("uye_firma_ulke");
    $uye_firma_metemask = p("uye_firma_metemask");
    $iletisim_baslik = p("iletisim_baslik");
    $iletisim_desc = p("iletisim_desc");
    $gelen_ip = GetIP();
    if (!$iletisim_baslik || !$iletisim_desc) {
        echo 'bos-deger';
    } else {
        $ileti = "Merhaba Yönetici; <br>İletişim Formundan Bir Yeni Mesaj Alıdın. Detaylar aşağıdaki gibidir;";
        $ileti.= "<br><p><strong><h4><u>Gönderilen Mesaj Detayları</u></h4></strong></p>";
        $ileti.= "<b>Ad Soyad :</b> " . $name . " " . $surname . "<br>";
        $ileti.= "<b>Doğum Tarihi :</b> " . $date . "<br>";
        $ileti.= "<b>Telefon Numarası :</b> " . $phone . "<br>";
        $ileti.= "<b>E-Posta :</b> " . $eposta . "<br>";
        $ileti.= "<b>İletişim Konusu :</b> " . $iletisim_baslik . "<br>";
        $ileti.= "<b>Mesaj Detayları :</b> " . $iletisim_desc . "<br>";
        $ileti.= "<h5><u>Bu mesaj <b>" . $gelen_ip . "</b> numaralı ip adresinden gönderildi !</u></h5>";
        $mailgonder = MailXM($ayar["gemail"], "Yeni İletişim Formu Talebi Mevcut !", $ileti);
        if ($mailgonder) {
            echo 'basarili';
        } else {
            echo 'basarisiz';
        }
    }
}
if ($_GET["p"] == "adreslerim_varsayilan") {
    $id = p("id");
    $kontrol = $db->query("SELECT * FROM adresler WHERE id='$id'");
    if ($kontrol->rowCount()) {
        $uyeRow = $kontrol->fetch(PDO::FETCH_ASSOC);
        $updates = $db->prepare("UPDATE adresler set varsayilan = ? WHERE uye_id = ? ");
        $okupdates = $updates->execute(array(0, $uyeRow["uye_id"]));
        if ($okupdates) {
            $update = $db->query("UPDATE adresler SET varsayilan=1 WHERE id='$id'");
            if ($update->rowCount()) {
                echo 'basarili';
            } else {
                echo 'basarisiz';
            }
        } else {
            echo 'basarisiz';
        }
    }
}
if ($_GET["p"] == "adreslerim_sil") {
    $id = p("id");
    $kontrol = $db->query("SELECT * FROM adresler WHERE id='$id'");
    if ($kontrol->rowCount()) {
        $uyeRow = $kontrol->fetch(PDO::FETCH_ASSOC);
        if ($uyeRow["varsayilan"] == 1) {
            echo "varsayilan";
        } else {
            $sil = $db->query("DELETE FROM adresler where id = '$id'");
            if ($sil->rowCount()) {
                echo 'basarili';
            } else {
                echo "basarisiz";
            }
        }
    } else {
        echo "basarisiz";
    }
}
if ($_GET["p"] == "adreslerim_ekle") {
    $uyeid = p("uyeid");
    $adres_baslik = p("adres_baslik");
    $adres = p("adres");
    if (!$uyeid || !$adres_baslik || !$adres) {
        echo "bos-deger";
    } else {
        $insert = $db->query("INSERT INTO adresler SET
						baslik	= '$adres_baslik', 
						adres	= '$adres', 
						uye_id	= '$uyeid'
						");
        if ($insert->rowCount()) {
            echo 'basarili';
        } else {
            echo 'basarisiz';
        }
    }
}
if ($_GET["p"] == "adreslerim_duzenle") {
    $id = p("id");
    $uyeid = p("uyeid");
    $adres_baslik = p("adres_baslik");
    $adres = p("adres");
    if (!$id || !$uyeid || !$adres_baslik || !$adres) {
        echo "bos-deger";
    } else {
        $insert = $db->query("UPDATE adresler SET
						baslik	= '$adres_baslik', 
						adres	= '$adres'
						WHERE
						id	= '$id'
						AND
						uye_id = '$uyeid'						
						");
        if ($insert->rowCount()) {
            echo 'basarili';
        } else {
            echo 'basarisiz';
        }
    }
}
if ($_GET["p"] == "hediye_kupon_kullan") {
    $uyeid = p("uyeid");
    $kod = p("kod");
    if (!$uyeid || !$kod) {
        echo "bos-deger";
    } else {
        $kuponlar = $db->prepare("SELECT * FROM kuponlar WHERE kupon_kod=?");
        $kuponlar->execute(array($kod));
        $cekkupon = $kuponlar->fetch(PDO::FETCH_ASSOC);
        $kontrol = $kuponlar->rowCount();
        $paket_id = $cekkupon["paket_id"];
        $paketler = $db->query("select * from paketler where id = '$paket_id' ")->fetch(PDO::FETCH_ASSOC);
        $nowDate = date("Y-m-d H:i:s");
        $bitis_tarih = date("Y-m-d H:i:s", strtotime('+' . $paketler["kgh"] . ' days'));
        $hizmet_id = $paketler["paket_cins"];
        $paketlerim = $db->query("SELECT * FROM paketlerim WHERE paket_durum = 1 AND hizmet = '$hizmet_id' and kisi_id = '$uyeid'")->rowCount();
        if ($kontrol == 0) {
            echo "basarisiz";
        } elseif ($cekkupon["kupon_adet"] == 0) {
            echo "basarisiz";
        } elseif ($paketlerim > 0) {
            echo "var";
        } else {
            $insert = $db->query("INSERT INTO paketlerim SET
						kisi_id	= '$uyeid', 
						paket_id	= '$paket_id', 
						paket_alim_tarih	= '$nowDate',
						paket_bitis_tarih	= '$bitis_tarih'
						hizmet	= '$hizmet_id'
						");
            if ($insert->rowCount()) {
                $newkuponadet = $cekkupon["kupon_adet"] - 1;
                $update = $db->prepare("update kuponlar set kupon_adet=? where id=?");
                $okupdate = $update->execute(array($newkuponadet, $cekkupon["id"]));
                if ($okupdate) {
                    echo 'basarili';
                }
            }
        }
    }
}
if ($_GET["p"] == "satinal") {
    $uyeid = p("uyeid");
    $paket_id = p("paket_id");
    if (!$uyeid || !$paket_id) {
        echo "bos-deger";
    } else {
        $paketler = $db->prepare("SELECT * FROM paketler WHERE id=?");
        $paketler->execute(array($paket_id));
        $cekpaketler = $paketler->fetch(PDO::FETCH_ASSOC);
        $kontrol = $paketler->rowCount();
        $nowDate = date("Y-m-d H:i:s");
        $bitis_tarih = date("Y-m-d H:i:s", strtotime('+' . $cekpaketler["kgh"] . ' days'));
        $hizmet_id = $cekpaketler["paket_cins"];
        $paketlerim = $db->query("SELECT * FROM paketlerim WHERE paket_durum = 1 AND hizmet = '$hizmet_id' AND kisi_id = '$uyeid'")->rowCount();
        if ($kontrol == 0) {
            echo "basarisiz";
        } elseif ($paketlerim > 0) {
            echo "var";
        } else {
            $insert = $db->query("INSERT INTO paketlerim SET
						kisi_id	= '$uyeid', 
						paket_id	= '$paket_id', 
						paket_alim_tarih	= '$nowDate',
						paket_bitis_tarih	= '$bitis_tarih',
						hizmet	= '$hizmet_id'
						");
            if ($insert->rowCount()) {
                echo 'basarili';
            }
        }
    }
}
if ($_GET["p"] == "altpaket_satinal") {
    $uyeid = p("uyeid");
    $paket_id = p("paket_id");
    if (!$uyeid || !$paket_id) {
        echo "bos-deger";
    } else {
        $alt_paketler = $db->prepare("SELECT * FROM alt_paketler WHERE id=?");
        $alt_paketler->execute(array($paket_id));
        $cekalt_paketler = $alt_paketler->fetch(PDO::FETCH_ASSOC);
        $kontrol = $alt_paketler->rowCount();
        $hizmet_id = $cekalt_paketler["paket_cins"];
        $paketlerim = $db->query("SELECT * FROM paketlerim WHERE paket_durum = 1 AND hizmet = '$hizmet_id' AND kisi_id = '$uyeid'")->fetch(PDO::FETCH_ASSOC);
        if ($kontrol == 0) {
            echo "basarisiz";
        } else {

            $idssx = $paketlerim["id"];
            $insert = $db->query("UPDATE paketlerim SET
                        alt_paket    = '$paket_id'
                        WHERE
                        id  = '$idssx'
                        ");
            if ($insert->rowCount()) {
                echo 'basarili';
            }
        }
    }
}
if ($_GET["p"] == "uye_karanlik_mod") {
    $id = p("id");
    $kontrol = $db->query("SELECT * FROM uyeler WHERE uye_id='$id'");
    if ($kontrol->rowCount()) {
        $uyeRow = $kontrol->fetch(PDO::FETCH_ASSOC);
        $uyeDurum = $uyeRow["tema_mod"];
        if ($uyeDurum == 1) {
            $update = $db->query("UPDATE uyeler SET tema_mod=2 WHERE uye_id='$id'");
            if ($update->rowCount()) {
            }
        } else {
            $update = $db->query("UPDATE uyeler SET tema_mod=1 WHERE uye_id='$id'");
            if ($update->rowCount()) {
            }
        }
    }
}
if ($_GET["p"] == "freepik") {
    @$uyeid = p("uyeid");
    @$paket_id = p("paket_id");
    @$url = p("url");
    @$asgduyas = p("asgduyas");
    @$gaoihsg = p("gaoihsg");
    @$kelimeara = $url;
    @$aranan = "freepik.com";
	 @$aranan2 = "premium";
    @$aramasonucu = strstr($kelimeara, $aranan);
	  @$aramasonucu2 = strstr($kelimeara, $aranan2);
    if ($aramasonucu==false){
        echo "gecersizurl";
    }if ($aramasonucu2==false){
        echo "premiumdegil";
    }else{
        if (!$uyeid || !$paket_id || !$url) {
        echo "bos-deger";
    } else {
        $paketler = $db->prepare("SELECT * FROM paketlerim WHERE id=? and kisi_id = ?");
        $paketler->execute(array($paket_id, $uyeid));
        $cekpaketler = $paketler->fetch(PDO::FETCH_ASSOC);
        $kontrol = $paketler->rowCount();
        $nowDate = date("Y-m-d H:i:s");
        $pakets_id = $cekpaketler["paket_id"];
        $paketlerim = $db->query("SELECT * FROM paketlerim WHERE paket_id = '$pakets_id' AND kisi_id = '$uyeid' AND paket_durum = 1")->rowCount();
        if ($kontrol == 0) {
            echo "basarisiz";
        } elseif ($paketlerim == 0) {
            echo "yok";
        } elseif ($asgduyas == $gaoihsg) {
            echo "basarisiz";
        } else {

            $indirmeler = $db->query("SELECT * FROM indirmeler WHERE resim_link = '$url' and durum = 2");
            $indirmeRowcount = $indirmeler->rowCount();
            $cekindirmeler = $indirmeler->fetch(PDO::FETCH_ASSOC);

            if($indirmeRowcount > 0){

                $newdownloadlink = $cekindirmeler["indirme_link"];

                $insert = $db->query("INSERT INTO indirmeler SET
                        kisi_id = '$uyeid', 
                        paket_id    = '$paket_id', 
                        resim_link  = '$url',
                        indirme_link = '$newdownloadlink',
                        hizmet  = 1, 
                        tarih   = '$nowDate',
                        durum = 2
                        ");
            if ($insert->rowCount()) {
                $last_insert_id = $db->lastInsertId();
                $updatess = $db->prepare("UPDATE uyeler SET last_request_freepik_id = ? WHERE uye_id=?");
                $okupdatess = $updatess->execute(array($last_insert_id,$uyeid));
                if($okupdatess){
                    echo"indirmebasarili";
                }

    
            }


            }else{

            $insert = $db->query("INSERT INTO indirmeler SET
						kisi_id	= '$uyeid', 
						paket_id	= '$paket_id', 
						resim_link	= '$url', 
						hizmet	= 1, 
						tarih	= '$nowDate'
						");
            if ($insert->rowCount()) {
                $last_insert_id = $db->lastInsertId();
                echo 'basarili';
            }
        }





        }
    }
    }
  /*  if (isset($_GET["file_link"])) {
        if ($last_insert_id == $_GET["request_id"]) {
            echo $file_link = $_GET["file_link"];
        }
    }*/
}
if ($_GET["p"] == "envato_elements") {
    $uyeid = p("uyeid");
    $paket_id = p("paket_id");
    $url = p("url");
    $asgduyas = p("xjkhas");
    $gaoihsg = p("qwskji");
      @$kelimeara = $url;
    @$aranan = "elements.envato.com";
    @$aramasonucu = strstr($kelimeara, $aranan);
    if ($aramasonucu==false){
        echo "gecersizurl";
    }else{
        if (!$uyeid || !$paket_id || !$url) {
        echo "bos-deger";
    } else {
        $paketler = $db->prepare("SELECT * FROM paketlerim WHERE id=? and kisi_id = ?");
        $paketler->execute(array($paket_id, $uyeid));
        $cekpaketler = $paketler->fetch(PDO::FETCH_ASSOC);
        $kontrol = $paketler->rowCount();
        $nowDate = date("Y-m-d H:i:s");
        $pakets_id = $cekpaketler["paket_id"];
        $paketlerim = $db->query("SELECT * FROM paketlerim WHERE paket_id = '$pakets_id' AND kisi_id = '$uyeid' AND paket_durum = 1")->rowCount();
        if ($kontrol == 0) {
            echo "basarisiz";
        } elseif ($paketlerim == 0) {
            echo "yok";
        } elseif ($asgduyas == $gaoihsg) {
            echo "basarisiz";
        } else {


 $indirmeler = $db->query("SELECT * FROM indirmeler WHERE resim_link = '$url' and durum = 2");
            $indirmeRowcount = $indirmeler->rowCount();
            $cekindirmeler = $indirmeler->fetch(PDO::FETCH_ASSOC);

            if($indirmeRowcount > 0){

                $newdownloadlink = $cekindirmeler["indirme_link"];

                $insert = $db->query("INSERT INTO indirmeler SET
                        kisi_id = '$uyeid', 
                        paket_id    = '$paket_id', 
                        resim_link  = '$url',
                        indirme_link = '$newdownloadlink',
                        hizmet  = 2, 
                        tarih   = '$nowDate',
                        durum = 2
                        ");
            if ($insert->rowCount()) {
                $last_insert_id = $db->lastInsertId();
                $updatess = $db->prepare("UPDATE uyeler SET last_request_id = ? WHERE uye_id=?");
                $okupdatess = $updatess->execute(array($last_insert_id,$uyeid));
                if($okupdatess){
                    echo"indirmebasarili";
                }

    
            }


            }else{



            $insert = $db->query("INSERT INTO indirmeler SET
						kisi_id	= '$uyeid', 
						paket_id	= '$paket_id', 
						resim_link	= '$url', 
						hizmet	= 2, 
						tarih	= '$nowDate'
						");
            if ($insert->rowCount()) {
                $last_insert_id = $db->lastInsertId();
                echo 'basarili';
            }

 }




        }
    }
    }
    /*if (isset($_GET["file_link"])) {
        if ($last_insert_id == $_GET["request_id"]) {
            echo $file_link = $_GET["file_link"];
        }
    }*/
}
if ($_GET["p"] == "callback") {
    $user_id = p("user_id");
    $request_id = p("request_id");
    $file_link = p("file_link");
    if (!$user_id || !$request_id || !$file_link) {
        echo "bos-deger";
    } else {
        $insert = $db->query("UPDATE indirmeler SET
						indirme_link	= '$file_link', 
						durum	= 2
						WHERE
						id	= '$request_id'
						AND
						kisi_id = '$user_id'						
						");
        if ($insert->rowCount()) {
          $paketlerimscek = $db->query("SELECT * FROM indirmeler where id = '$request_id'")->fetch(PDO::FETCH_ASSOC);

if($paketlerimscek["hizmet"] == 2){
                $updatess = $db->prepare("UPDATE uyeler SET last_request_id = ? WHERE uye_id=?");
                $okupdatess = $updatess->execute(array($request_id,$user_id));
                if($okupdatess){
                    echo"indirmebasarili";
                }
}else{
                $updatess = $db->prepare("UPDATE uyeler SET last_request_freepik_id = ? WHERE uye_id=?");
                $okupdatess = $updatess->execute(array($request_id,$user_id));
                if($okupdatess){
                    echo"indirmebasarili";
                }
                }
           
        } else {
            echo 'basarisiz';
        }
    }
}

if ($_GET["p"] == "IndirmeSifirla") {
    $user_id = p("id");
               	$updatess = $db->prepare("UPDATE uyeler SET last_request_id = ? WHERE uye_id=?");
            	$okupdatess = $updatess->execute(array(0,$user_id));
            	if($okupdatess){
            		// echo"basarili";
            	}else{
            		// echo"basarisiz";
            	}
           
    
}
if ($_GET["p"] == "IndirmeSifirlaFree") {
    $user_id = p("id");
                $updatess = $db->prepare("UPDATE uyeler SET last_request_freepik_id = ? WHERE uye_id=?");
                $okupdatess = $updatess->execute(array(0,$user_id));
                if($okupdatess){
                    // echo"basarili";
                }else{
                    // echo"basarisiz";
                }
           
    
}