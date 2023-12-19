<?php 
require_once('host/a.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(empty($_SESSION["login"])){go(ADMIN_URL."login.php");die();}
if($_SESSION["uye_rutbe"]!=0){
if ($_SESSION["uye_rutbe"]!=2){
	go(URL);die();
}
}
define("ADMIN",true);

$nowDate = date("Y-m-d H:i:s");

$paket_kontrol = $db->query("SELECT * FROM paketlerim WHERE paket_durum = 1")->fetchAll(PDO::FETCH_ASSOC);

foreach ($paket_kontrol as $m) {
	$pakettid = $m["paket_id"];
	$kisi_idss = $m["kisi_id"];
	$paketler = $db->query("SELECT * FROM paketler WHERE id='$pakettid'")->fetch(PDO::FETCH_ASSOC);
	$uyess = $db->query("SELECT * FROM uyeler WHERE uye_id='$kisi_idss'")->fetch(PDO::FETCH_ASSOC);
		
		$mail_tarih = strtotime('-1 day',strtotime($m["paket_bitis_tarih"]));
		$mail_tarih = date('Y-m-d H:i:s' ,$mail_tarih);

	if($m["paket_bitis_tarih"]<=$nowDate){
		$updates = $db->prepare("UPDATE paketlerim set paket_durum = ? WHERE id = ?");
		$okupdates = $updates->execute(array(0,$m["id"]));
	}

	if($m["mail"]==1){
		if($mail_tarih <= $nowDate){
		$updates = $db->prepare("UPDATE paketlerim set mail = ? WHERE id = ?");
		$okupdates = $updates->execute(array(0,$m["id"]));
		if($okupdates){

			require '../admin/host/mail_sablon/paket_mail_sablon.php';
			$mailgonder = MailXM($uyess["uye_eposta"], $paketler["paket_adi"]." Süresi Doluyor", $paket_mail_sablon);

		}
		}
	}


}
?>

<!DOCTYPE html>
<html class="loading" lang="tr" data-textdirection="ltr">
<head>
	<?php require_once('inc/head.php');?>
</head>
<body class="vertical-layout vertical-menu-modern <?php if($ayar["site_tema"]==1){ ?>dark-layout<?php }else{ ?>semi-dark-layout<?php } ?>  2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="<?php if($ayar["site_tema"]==1){ ?>dark-layout<?php }else{ ?>semi-dark-layout<?php } ?>">


	<?php require_once('inc/solMenu.php');?>

	<!-- BEGIN: Content-->
	<div class="app-content content">

		<!-- BEGIN: Header-->
		<div class="content-overlay"></div>
		<div class="header-navbar-shadow"></div>

		<?php require_once('inc/topBar.php');?>

		<?php
		if(isset($_GET["sayfa"])){
			$sayfa = $_GET["sayfa"];
			$file = "sayfa/".$sayfa.".php";
			
			if(file_exists($file)){
				require_once($file);
			}else{
				
				require_once("sayfa/default.php");
			}
		}else{
			
			require_once("sayfa/default.php");
		}

		?>






	</div>
	<div class="sidenav-overlay"></div>
	<div class="drag-target"></div>
	<?php require_once('inc/footer.php');?>

	<!-- End of eoverlay modal -->
	<?php require_once('inc/scripts.php');?>
	<script type="text/javascript">
		$("img").each(function() { // for each img found
    var src = $(this).attr("src"); // get the src
    var fileName = src.substring(src.lastIndexOf('.')); // and filename
    console.log(fileName)
    if(fileName=='.pdf' ){
         $(this).replaceWith( "<iframe style='width: 100%;height: 450px;'  src='"+src+"' />" );
          $(this).remove();
    }
      if(fileName=='.doc' ){
         $(this).replaceWith( "<iframe style='width: 100%;height: 450px;'  src='"+src+"' />" );
          $(this).remove();
    }
      if(fileName=='.docx' ){
         $(this).replaceWith( "<iframe style='width: 100%;height: 450px;'  src='"+src+"' />" );
          $(this).remove();
    }
      if(fileName=='.xls' ){
         $(this).replaceWith( "<iframe style='width: 100%;height: 450px;'  src='"+src+"' />" );
          $(this).remove();
    }
     if(fileName=='.xlsx' ){
         $(this).replaceWith( "<iframe style='width: 100%;height: 450px;'  src='"+src+"' />" );
          $(this).remove();
    }
  });
	</script>
</body>
</html>