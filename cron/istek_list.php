<?php 

require_once '../admin/host/a.php';

header("Content-Type: application/json;");

$indirmeler = $db->query("SELECT * FROM indirmeler WHERE durum = 1");
$indirmelerCek = $indirmeler->fetchAll(PDO::FETCH_ASSOC);
$indirmelerRow = $indirmeler->rowCount();



if($_SESSION["uye_rutbe"]!=88888){go(URL."login/");die();}else{
?>
{

	"Requests" : [
<?php
$i = 0;

 foreach ($indirmelerCek as $m):
 
 if($m["hizmet"]==1){
 	$service = "Freepik";
 }elseif($m["hizmet"]==2){
 	$service = "Envato Elements";
 }
 $i+=1;
 ?>
		{

      		"user_id": "<?php echo $m["kisi_id"]; ?>",
      		"request_id": "<?php echo $m["id"]; ?>",
      		"file_link": "<?php echo $m["resim_link"]; ?>",
      		"service": "<?php echo $service; ?>"
		}<?php if($i != $indirmelerRow){echo",";} ?>
<?php 

endforeach;

	
 ?>

 	]
 }
<?php } ?>