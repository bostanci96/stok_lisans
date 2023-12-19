<?php
if ($par[1]) {
$sertifika_id = $par[1];
$ayarControl = $db->query("SELECT * FROM faturalar WHERE id='$sertifika_id'");
if($ayarControl->rowCount()){
$ayarRow = $ayarControl->fetch(PDO::FETCH_ASSOC);

$etkinlik = $db->query("SELECT * FROM sertifikalar WHERE sertifi_id = '".$ayarRow["etkinlik_id"]."'")->fetch(PDO::FETCH_ASSOC);

$uyecek = $db->query("SELECT * FROM uyeler WHERE uye_id = '".$ayarRow["uyeid"]."'")->fetch(PDO::FETCH_ASSOC);
$adrescek = $db->query("SELECT * FROM adresler WHERE varsayilan = 1 AND uye_id = '".$ayarRow["uyeid"]."'")->fetch(PDO::FETCH_ASSOC);

}else{
go(URL);
}
}else{
go(URL);
}
?>
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0"><?php echo $bloklar["site_link_map_etkinlik_duzenle"]; ?></h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=URL?>"><?php echo $bloklar["site_link_map_home"]; ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $bloklar["site_link_map_etkinlik_duzenle"]; ?>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
</div>
<div class="content-body">
<!-- Horizontal Wizard -->
<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo $bloklar["etkinlik_duzenle"]; ?></h4>
                </div>
                <div class="card-body">
                    <form role="form" class="form-horizontal" id="forms" method="POST" action="<?php echo TEMA_URL; ?>ajax.php?p=etkinlik-fatura-duzenle"  enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="uyeid" value="<?php echo $ayarRow["uyeid"]; ?>">
                            <input type="hidden" name="id" value="<?php echo $ayarRow["id"]; ?>">
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" ><?php echo $bloklar["etkinlik_duzenle_one_label"]; ?></label>
                                    <input disabled type="text" class="form-control" value="<?php echo $etkinlik["sertifi_baslik"]; ?>"/>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" ><?php echo $bloklar["etkinlik_duzenle_two_label"]; ?></label>
                                    <input disabled type="text" class="form-control" value="<?php echo $uyecek["uye_ad"]." ".$uyecek["uye_soyad"]; ?>"/>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="basicInput"><?php echo $bloklar["etkinlik_duzenle_there_label"]; ?></label>
                                    <textarea disabled rows="3" name="adres" class="form-control"><?php echo $adrescek["adres"]; ?></textarea>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" ><?php echo $bloklar["etkinlik_duzenle_four_label"]; ?></label>
                                    <input type="file" class="form-control" name="fatura_dosya[]" />
                                </div>
                            </div>
                            <div class="col-md-8">      <a href="<?php echo URL; ?>images/fatura_kullanici_dosya/big/<?php echo $ayarRow["fatura_dosya"]; ?>" target="_blank"><img  src="<?php echo URL; ?>images/fatura_kullanici_dosya/big/<?php echo $ayarRow["fatura_dosya"]; ?>" class="img-fluid"></a></div>
                            <div class=" col-md-12">
                            <center>
                            <button type="submit" class="btn btn-primary me-1 mt-2"><?php echo $bloklar["adreslerim_duzenle_button_label"]; ?></button>
                            </center>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Horizontal Wizard -->
</div>
<script>
 $(document).ready(function(event) {
    $('#forms').ajaxForm({
        success: function(data) {
            if (data == "bos-deger") {
                 Swal.fire({
                    title: '<?php echo $bloklar["alert_bosdeger_sertifi_title"]; ?>',
                    text: '<?php echo $bloklar["alert_bosdeger_sertifi_desc"]; ?>',
                    icon: 'info',
                    customClass: {
                      confirmButton: 'btn btn-info'
                    },
                    buttonsStyling: false
                  });
                return false;
            } else if (data == "basarili") {
                  Swal.fire({
                    title: '<?php echo $bloklar["alert_success_etkinlik_fatura_duzenle_title"]; ?>',
                    text: '<?php echo $bloklar["alert_success_etkinlik_fatura_duzenle_desc"]; ?>',
                    icon: 'success',
                    customClass: {
                      confirmButton: 'btn btn-success'
                    },
                    buttonsStyling: false
                  }).then(function() { window.location.href = "<?php echo URL."adreslerim/"; ?>";});
                return true;
            } else if (data == "basarisiz") {
                  Swal.fire({
                    title: '<?php echo $bloklar["alert_eror_etkinlik_fatura_duzenle_title"]; ?>',
                    text: '<?php echo $bloklar["alert_eror_etkinlik_fatura_duzenle_desc"]; ?>',
                    icon: 'eror',
                    customClass: {
                      confirmButton: 'btn btn-warning'
                    },
                    buttonsStyling: false
                  });
                return false;
            }
        }
    });

});
</script>
