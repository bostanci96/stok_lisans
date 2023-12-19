<?php
$toplam		= count($_FILES["dosya2"]["tmp_name"]);
$formatlar	=  array("application/pdf", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/msword", "application/vnd.ms-excel", "text/plain");
		

function sef_linkdddd($string)
{
	$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
	$replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
	$string = str_replace($find, $replace, $string);
	$string = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $string);
	$string = trim(preg_replace('/\s+/', ' ', $string));
	$string = str_replace(' ', '-', $string);
	$string = str_replace('.', '',$string);
	return $string;
}	
for($i=0; $i<$toplam; $i++){
	$dosya_tipi		= $_FILES["dosya2"]["type"][$i];
	if(in_array($dosya_tipi,$formatlar)){
		$resimler = array();
		foreach ($_FILES['dosya2'] as $k => $l) {
			foreach ($l as $i => $v) {
				if (!array_key_exists($i, $resimler))
					$resimler[$i] = array();
				$resimler[$i][$k] = $v;
			}
		}


		$sira_no	= 1;
		foreach($resimler as $resim){
			$handle = new Upload($resim);
			if($handle->uploaded){

				/* resmi yeniden isimlendir */
				$randName 	= substr(base64_encode(uniqid(true)),0,20);
				/*$newName 	= str_replace("=","",$randName);*/
				$newName 	= sef_linkdddd($fotograf_shortDesc);
				$handle->file_new_name_body = $newName;
				$resim_adi = $handle->file_new_name_body;

				/* Resim Uzantısını Alma */
				/*$uzanti = "pdf";*/
				$uzanti = $handle->file_src_name_ext;
				$resimAdi = $resim_adi.".".$uzanti;
				/* Resim yükleme izini */
				$handle->allowed = array('application/*','text/*' );
				/* Büyük resmi yükle */
				$handle->Process("../images/katalog/");
				if($handle->processed){
					$imgInsert = $db->query("UPDATE fotograflar SET 
						fotograf_href = '$resimAdi' WHERE fotograf_id='$last_insert_id'");
				}
			}
			$sira_no++;
		}
	}
}						
/* upload */

?>