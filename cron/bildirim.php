 <?php

	require_once '../admin/host/a.php';
			
	

	$post = $_POST;

	$merchant_key 	= $ayar["merchant_key"];
	$merchant_salt	= $ayar["merchant_salt"];

	$hash = base64_encode( hash_hmac('sha256', $post['merchant_oid'].$merchant_salt.$post['status'].$post['total_amount'], $merchant_key, true) );
	if( $hash != $post['hash'] )
		die('PAYTR notification failed: bad hash');

	if( $post['status'] == 'success' ) { 
		$token = $post['merchant_oid'];
		$sorgu = $db->query("SELECT * FROM paytr_bildirim WHERE bildirim_token = '$token' AND durum = 1")->fetch(PDO::FETCH_ASSOC);
		$paket_id = $sorgu["paket_id"];

		if($sorgu["alt_paket"] == 1){
		$paketler = $db->query("SELECT * FROM paketler WHERE id = '$paket_id'")->fetch(PDO::FETCH_ASSOC);
		$nowDate = date("Y-m-d H:i:s");
		$bitis_tarih = date("Y-m-d H:i:s",strtotime('+'.$paketler["kgh"].' days'));

		$insert = $db->prepare("INSERT INTO paketlerim SET kisi_id=?,hizmet=?,paket_id=?,paket_bitis_tarih=?");
		$okinsert = $insert->execute(array($sorgu["kisi_id"],$paketler["paket_cins"],$paket_id,$bitis_tarih));

		if($okinsert){
			$update = $db->prepare("UPDATE paytr_bildirim SET durum = ? WHERE bildirim_token = ?");
			$updateok = $update->execute(array(2,$token));
		}
	}elseif($sorgu["alt_paket"] == 2){
		
		$alt_paketler = $db->prepare("SELECT * FROM alt_paketler WHERE id=?");
        $alt_paketler->execute(array($paket_id));
        $cekalt_paketler = $alt_paketler->fetch(PDO::FETCH_ASSOC);
        $kontrol = $alt_paketler->rowCount();
        $hizmet_id = $cekalt_paketler["paket_cins"];
        $kisisss = $sorgu["kisi_id"];
        $paketlerim = $db->query("SELECT * FROM paketlerim WHERE paket_durum = 1 AND hizmet = '$hizmet_id' AND kisi_id = '$kisisss'")->fetch(PDO::FETCH_ASSOC);
        $idssx = $paketlerim["id"];
            $insert = $db->prepare("UPDATE paketlerim SET alt_paket = ? WHERE id  = ? ");
            $okinsert = $insert->execute(array($paket_id,$idssx));
		if($okinsert){
			$update = $db->prepare("UPDATE paytr_bildirim SET durum = ? WHERE bildirim_token = ?");
			$updateok = $update->execute(array(2,$token));
		}
	}


	} else { 

		$token = $post['merchant_oid'];
		$sorgu = $db->query("SELECT * FROM paytr_bildirim WHERE bildirim_token = '$token' AND durum = 1")->fetch(PDO::FETCH_ASSOC);

		$update = $db->prepare("UPDATE paytr_bildirim SET durum = ? WHERE bildirim_token = ?");
		$updateok = $update->execute(array(0,$token));

	}

	echo "OK";
	exit;
?>