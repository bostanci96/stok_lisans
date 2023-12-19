<?php 
if($_GET["p"]=="mesaj_cevap"){
	$mesajcevap 		= p("cevap");
	$mid 			= p("mid");
	
	$elcevap 			= p("elcevap");
	$kisiad 			= p("kisiad");
	if(!$mid || !$mesajcevap ){
		echo 'bos-deger';
	}else{
		$onay 			= 1;
		$update =$db->query("UPDATE iletisim SET
			iletisim_cevap 		= '$mesajcevap' ,  
			iletisim_durum 		= '$onay'		
			WHERE iletisim_id='$mid'");
		if($update->rowCount() ){

			$to = $elcevap;
			$isim=$kisiad;

			$ileti=$mesajcevap;

			require 'mailer/class.phpmailer.php';
			$mail = new PHPMailer();
			$mail->IsSMTP();        
			require 'mailer/cevap_functions.php';

			if($mail->Send()){   
				echo 'basarili';exit();
			}else{
				echo "basarisiz";exit();
			}
		}else{
			echo 'bos-deger';
		}



	}

}


if($_GET["p"]=="mesajsil"){
	$id = p("id");
	$kontrol = $db->query("SELECT * FROM iletisim WHERE iletisim_id='$id'");
	if($kontrol->rowCount()){
		$kontrolRow = $kontrol->fetch(PDO::FETCH_ASSOC);
		$delete = $db->query("DELETE FROM iletisim WHERE iletisim_id='$id'");
		if($delete->rowCount()){
			echo 'basarili';exit();
		}else{
			echo 'basarisiz';exit();
		}
	}
}


if($_GET["p"]=="mesajsil2"){
	$id = p("id");
	$kontrol = $db->query("SELECT * FROM iletisim WHERE iletisim_id='$id'");
	if($kontrol->rowCount()){
		$kontrolRow = $kontrol->fetch(PDO::FETCH_ASSOC);
		$delete = $db->query("DELETE FROM iletisim WHERE iletisim_id='$id'");
		if($delete->rowCount()){
			echo 'basarili';exit();
		}else{
			echo 'basarisiz';exit();
		}
	}
}




if($_GET["p"]=="mesajonay"){
	$id = p("id");
	$kontrol = $db->query("SELECT * FROM iletisim WHERE iletisim_id='$id'");
	if($kontrol->rowCount()){
		$uyeRow = $kontrol->fetch(PDO::FETCH_ASSOC);
		$uyeDurum = $uyeRow["iletisim_durum"];
		if($uyeDurum==1){
			$update = $db->query("UPDATE iletisim SET iletisim_durum=0 WHERE iletisim_id='$id'");
			if($update->rowCount()){
				echo 'yasaklama-basarili';exit();
			}
		}else{
			$update = $db->query("UPDATE iletisim SET iletisim_durum=1 WHERE iletisim_id='$id'");
			if($update->rowCount()){
				echo 'yasak-kaldirildi';exit();
			}
		}
	}
}

if ($_GET["p"] == "paket_ekle") {
    $paket_ekle = p("paket_ekle");
    $paket_cins = p("paket_cins");
    $paket_adi = p("paket_adi");
    $paket_tutar = p("paket_tutar");
    $kgh = p("kgh");
    $gil = p("gil");

    if(!$paket_cins || !$paket_adi || !$paket_tutar || !$kgh || !$gil){
    	echo"bos-deger";
    } else {
                $insert = $db->query("INSERT INTO paketler SET
            paket_cins = '$paket_cins',
            paket_adi = '$paket_adi',
            paket_tutar = '$paket_tutar',
            kgh = '$kgh',
            gil = '$gil'");
                if ($insert->rowCount()) {
                        echo "basarili";                    
                } else {
                    echo "basarisiz";
                }
    }
}

if ($_GET["p"] == "alt_paket_ekle") {
    $paket_ekle = p("paket_ekle");
    $paket_cins = p("paket_cins");
    $paket_adi = p("paket_adi");
    $paket_tutar = p("paket_tutar");
    $gil = p("gil");

    if(!$paket_cins || !$paket_adi || !$paket_tutar || !$gil){
    	echo"bos-deger";
    } else {
                $insert = $db->query("INSERT INTO alt_paketler SET
            paket_cins = '$paket_cins',
            paket_adi = '$paket_adi',
            paket_tutar = '$paket_tutar',
            gil = '$gil'");
                if ($insert->rowCount()) {
                        echo "basarili";                    
                } else {
                    echo "basarisiz";
                }
    }
}

if($_GET["p"]=="paket_sil"){
	$id = p("id");
	$kontrol = $db->query("SELECT * FROM paketler WHERE id='$id'");
	if($kontrol->rowCount()){
		$kontrolRow = $kontrol->fetch(PDO::FETCH_ASSOC);
		$delete = $db->query("DELETE FROM paketler WHERE id='$id'");
		if($delete->rowCount()){
			echo 'basarili';exit();
		}else{
			echo 'basarisiz';exit();
		}
	}
}

if($_GET["p"]=="paket_durum"){
	$id = p("id");
	$kontrol = $db->query("SELECT * FROM paketler WHERE id='$id'");
	if($kontrol->rowCount()){
		$uyeRow = $kontrol->fetch(PDO::FETCH_ASSOC);
		$uyeDurum = $uyeRow["paket_durum"];
		if($uyeDurum==1){
			$update = $db->query("UPDATE paketler SET paket_durum=0 WHERE id='$id'");
			if($update->rowCount()){
				echo 'yasaklama-basarili';
			}
		}else{
			$update = $db->query("UPDATE paketler SET paket_durum=1 WHERE id='$id'");
			if($update->rowCount()){
				echo 'yasak-kaldirildi';
			}
		}
	}
}

if($_GET["p"]=="alt_paket_sil"){
	$id = p("id");
	$kontrol = $db->query("SELECT * FROM alt_paketler WHERE id='$id'");
	if($kontrol->rowCount()){
		$kontrolRow = $kontrol->fetch(PDO::FETCH_ASSOC);
		$delete = $db->query("DELETE FROM alt_paketler WHERE id='$id'");
		if($delete->rowCount()){
			echo 'basarili';exit();
		}else{
			echo 'basarisiz';exit();
		}
	}
}

if($_GET["p"]=="alt_paket_durum"){
	$id = p("id");
	$kontrol = $db->query("SELECT * FROM alt_paketler WHERE id='$id'");
	if($kontrol->rowCount()){
		$uyeRow = $kontrol->fetch(PDO::FETCH_ASSOC);
		$uyeDurum = $uyeRow["paket_durum"];
		if($uyeDurum==1){
			$update = $db->query("UPDATE alt_paketler SET paket_durum=0 WHERE id='$id'");
			if($update->rowCount()){
				echo 'yasaklama-basarili';
			}
		}else{
			$update = $db->query("UPDATE alt_paketler SET paket_durum=1 WHERE id='$id'");
			if($update->rowCount()){
				echo 'yasak-kaldirildi';
			}
		}
	}
}

if($_GET["p"]=="paket_duzenle"){
	$id 			= p("id");
	$paket_cins		= p("paket_cins");
	$paket_adi		= p("paket_adi");
	$paket_tutar		= p("paket_tutar");
	$kgh		= p("kgh");
	$gil		= p("gil");
	if(!$id || !$paket_cins || !$paket_adi || !$paket_tutar || !$kgh || !$gil){
		echo 'bos-deger';
	}else{
		$update =$db->query("UPDATE paketler SET
			paket_cins 	= '$paket_cins',
			paket_adi 		= '$paket_adi',
			paket_tutar 		= '$paket_tutar',
			kgh		= '$kgh',
			gil 	= '$gil'
			WHERE id='$id'");
		if($update->rowCount()){
			echo 'basarili';
		}else{
			echo 'basarisiz';
		}
	}
}
if($_GET["p"]=="alt_paket_duzenle"){
	$id 			= p("id");
	$paket_cins		= p("paket_cins");
	$paket_adi		= p("paket_adi");
	$paket_tutar		= p("paket_tutar");
	$gil		= p("gil");
	if(!$id || !$paket_cins || !$paket_adi || !$paket_tutar || !$gil){
		echo 'bos-deger';
	}else{
		$update =$db->query("UPDATE alt_paketler SET
			paket_cins 	= '$paket_cins',
			paket_adi 		= '$paket_adi',
			paket_tutar 		= '$paket_tutar',
			gil 	= '$gil'
			WHERE id='$id'");
		if($update->rowCount()){
			echo 'basarili';
		}else{
			echo 'basarisiz';
		}
	}
}
if ($_GET["p"] == "duyuru_ekle") {
    $hizmet = p("hizmet");
    $duyuru_cins = p("duyuru_cins");
    $duyuru_baslik = p("duyuru_baslik");
    $duyuru_icerik = p("duyuru_icerik");

    if(!$hizmet || !$duyuru_cins || !$duyuru_baslik || !$duyuru_icerik){
    	echo"bos-deger";
    } else {
                $insert = $db->query("INSERT INTO duyurular SET
            hizmet = '$hizmet',
            duyuru_cins = '$duyuru_cins',
            duyuru_baslik = '$duyuru_baslik',
            duyuru_icerik = '$duyuru_icerik'");
                if ($insert->rowCount()) {
                        echo "basarili";                    
                } else {
                    echo "basarisiz";
                }
    }
}

if($_GET["p"]=="duyuru_sil"){
	$id = p("id");
	$kontrol = $db->query("SELECT * FROM duyurular WHERE id='$id'");
	if($kontrol->rowCount()){
		$kontrolRow = $kontrol->fetch(PDO::FETCH_ASSOC);
		$delete = $db->query("DELETE FROM duyurular WHERE id='$id'");
		if($delete->rowCount()){
			echo 'basarili';exit();
		}else{
			echo 'basarisiz';exit();
		}
	}
}

if($_GET["p"]=="duyuru_durum"){
	$id = p("id");
	$kontrol = $db->query("SELECT * FROM duyurular WHERE id='$id'");
	if($kontrol->rowCount()){
		$uyeRow = $kontrol->fetch(PDO::FETCH_ASSOC);
		$uyeDurum = $uyeRow["durum"];
		if($uyeDurum==1){
			$update = $db->query("UPDATE duyurular SET durum=0 WHERE id='$id'");
			if($update->rowCount()){
				echo 'yasaklama-basarili';
			}
		}else{
			$update = $db->query("UPDATE duyurular SET durum=1 WHERE id='$id'");
			if($update->rowCount()){
				echo 'yasak-kaldirildi';
			}
		}
	}
}

if($_GET["p"]=="duyuru_duzenle"){
	$id 			= p("id");
    $hizmet = p("hizmet");
    $duyuru_cins = p("duyuru_cins");
    $duyuru_baslik = p("duyuru_baslik");
    $duyuru_icerik = p("duyuru_icerik");
	if(!$hizmet || !$duyuru_cins || !$duyuru_baslik || !$duyuru_icerik){
		echo 'bos-deger';
	}else{
		$update =$db->query("UPDATE duyurular SET
			hizmet = '$hizmet',
            duyuru_cins = '$duyuru_cins',
            duyuru_baslik = '$duyuru_baslik',
            duyuru_icerik = '$duyuru_icerik'
			WHERE id='$id'");
		if($update->rowCount()){
			echo 'basarili';
		}else{
			echo 'basarisiz';
		}
	}
}
if ($_GET["p"] == "kupon_ekle") {
    $paket_id = p("paket_id");
    $kupon_baslik = p("kupon_baslik");
    $kupon_adet = p("kupon_adet");
    $kupon_kod = strtoupper(generateRandomString());


    if(!$paket_id || !$kupon_baslik || !$kupon_adet){
    	echo"bos-deger";
    } else {
                $insert = $db->query("INSERT INTO kuponlar SET
            paket_id = '$paket_id',
            kupon_baslik = '$kupon_baslik',
            kupon_kod = '$kupon_kod',
            kupon_adet = '$kupon_adet'");
                if ($insert->rowCount()) {
                        echo "basarili";                    
                } else {
                    echo "basarisiz";
                }
    }
}
if($_GET["p"]=="kupon_sil"){
	$id = p("id");
	$kontrol = $db->query("SELECT * FROM kuponlar WHERE id='$id'");
	if($kontrol->rowCount()){
		$kontrolRow = $kontrol->fetch(PDO::FETCH_ASSOC);
		$delete = $db->query("DELETE FROM kuponlar WHERE id='$id'");
		if($delete->rowCount()){
			echo 'basarili';exit();
		}else{
			echo 'basarisiz';exit();
		}
	}
}
if($_GET["p"]=="kupon_duzenle"){
	$id 			= p("id");
    $kupon_baslik = p("kupon_baslik");
    $kupon_adet = p("kupon_adet");
	if(!$kupon_baslik || !$kupon_adet){
		echo 'bos-deger';
	}else{
		$update =$db->query("UPDATE kuponlar SET
            kupon_baslik = '$kupon_baslik',
            kupon_adet = '$kupon_adet'
			WHERE id='$id'");
		if($update->rowCount()){
			echo 'basarili';
		}else{
			echo 'basarisiz';
		}
	}
}
if($_GET["p"]=="hesap_ekle"){
	$fotograf_shortDesc 	= p("fotograf_shortDesc");
	if(isset($_POST["fotograf_shortDesc2"])){$fotograf_shortDesc2=p("fotograf_shortDesc2");}else{$fotograf_shortDesc2="";}
	$fotograf_longDesc		= p("fotograf_longDesc");
	$fotograf_href 			= p("fotograf_href");
	$fotograf_bolum 		= p("fotograf_bolum");
	$fotograf_bolum2 		= p("fotograf_bolum2");
	$dosya 				= $_FILES["dosya"]["tmp_name"][0];
	@$dosya2 				= $_FILES["dosya2"]["tmp_name"][0];
	@$refgaleri 				= $_FILES["refgaleri"]["tmp_name"][0];
	if(!$fotograf_shortDesc || !$fotograf_bolum){
		echo 'bos-deger';
	}else{
		$insert =$db->query("INSERT INTO fotograflar SET
			fotograf_longDesc 	= '$fotograf_longDesc',
			fotograf_shortDesc 	= '$fotograf_shortDesc',
			fotograf_shortDesc2 	= '$fotograf_shortDesc2',

			fotograf_href 		= '$fotograf_href',
			fotograf_bolum 		= '$fotograf_bolum',
			fotograf_bolum2 		= '$fotograf_bolum2',
			fotograf_durum 		= 1
			");
		if($insert->rowCount()){
			$last_insert_id = $db->lastInsertId();
			if($last_insert_id){
				require_once("app-upload/app.upload.php");
				require_once("app-upload/fotograf_resim_add.php");
				if(strlen($dosya2)>3){
					require_once("app-upload/katalog_pdf_add.php");
				}
				if(strlen($refgaleri)>3){
					require_once("app-upload/referans_galeri_add.php");
				}
			}
			echo 'basarili';
		}else{
			echo 'basarisiz';
		}
	}
}
