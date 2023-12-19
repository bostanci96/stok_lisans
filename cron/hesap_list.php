<?php 

require_once '../admin/host/a.php';

header("Content-Type: application/json;");

$hesaplar = $db->query("SELECT * FROM fotograflar WHERE fotograf_bolum = 4");
$hesapCek = $hesaplar->fetchAll(PDO::FETCH_ASSOC);
$hesaplarRow = $hesaplar->rowCount();



if($_SESSION["uye_rutbe"]!=88888){go(URL."login/");die();}else{
?>
{

	"Accounts" : [
<?php
$i = 0;

 foreach ($hesapCek as $m):
 
 if($m["fotograf_bolum2"]==1){
 	$service = "Freepik";
 }elseif($m["fotograf_bolum2"]==2){
 	$service = "Envato Elements";
 }
 $service_url = URL."images/katalog/".$m["fotograf_href"];
 $i+=1;
 ?>
		{
      		"service": "<?php echo $service; ?>",
      		"service_url": "<?php echo  $service_url; ?>"
		}<?php if($i != $hesaplarRow){echo",";} ?>
        
<?php 

endforeach;

	
 ?>
 	]
 }
 <?php } ?>
