<?php 

require_once '../admin/host/a.php';


$indirmeler = $db->query("SELECT * FROM indirmeler WHERE durum = 1");
$indirmelerCek = $indirmeler->fetchAll(PDO::FETCH_ASSOC);
$indirmelerRow = $indirmeler->rowCount();
if($_SESSION["uye_rutbe"]!=88888){go(URL."login/");die();}else{
?>
<script src="<?php echo TEMA_URL; ?>tema-assets/tv2/jquery-1.11.1.min.js"></script>
<script src="<?php echo TEMA_URL; ?>tema-assets/tv2/ajaxFormData.js"></script>

<form id="forms" method="POST"  action="<?php echo TEMA_URL; ?>ajax.php?p=callback">
	<input type="text" name="user_id" placeholder="user_id">
	<input type="text" name="request_id" placeholder="request_id">
	<input type="text" name="file_link" placeholder="file_link">
	<button type="submit">Gönder</button>
</form>

<script>
 $(document).ready(function(event) {
    $('#forms').ajaxForm({
         
        success: function(data) {
            if (data == "bos-deger") {
                 window.location.reload(true);
            } else if (data == "basarili") {
                  window.location.reload(true);
            } else if (data == "basarisiz") {
                   window.location.reload(true);
            } else if (data == "var") {
              
            }
        }
    });

});
</script>
<?php
}
    
 ?>