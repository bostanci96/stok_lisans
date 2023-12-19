<?php
if ($par[1]) {
$sertifika_id = $par[1];
$sertifika_uye_id = $_SESSION['uye_id'];
$ayarControl = $db->query("SELECT * FROM adresler WHERE id='$sertifika_id' AND uye_id='$sertifika_uye_id' ");
if($ayarControl->rowCount()){
$ayarRow = $ayarControl->fetch(PDO::FETCH_ASSOC);
$urunid = $ayarRow["sertifi_urun_id"];
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
                <h2 class="content-header-title float-start mb-0"><?php echo $bloklar["site_link_map_adreslerim_duzenle"]; ?></h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=URL?>"><?php echo $bloklar["site_link_map_home"]; ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $bloklar["site_link_map_adreslerim_duzenle"]; ?>
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
                    <h4 class="card-title"><?php echo $bloklar["adreslerim_duzenle"]; ?></h4>
                </div>
                <div class="card-body">
                    <form role="form" class="form-horizontal" id="forms" method="POST" action="<?php echo TEMA_URL; ?>ajax.php?p=adreslerim_duzenle"  enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="uyeid" value="<?php echo $ayarRow["uye_id"]; ?>">
                            <input type="hidden" name="id" value="<?php echo $ayarRow["id"]; ?>">
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" ><?php echo $bloklar["adreslerim_ekle_one_label"]; ?></label>
                                    <input type="text" class="form-control" value="<?php echo $ayarRow["baslik"]; ?>" name="adres_baslik"/>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="basicInput"><?php echo $bloklar["adreslerim_ekle_two_label"]; ?></label>
                                    <textarea rows="3" name="adres" class="form-control"><?php echo $ayarRow["adres"]; ?></textarea>
                                </div>
                            </div>
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
                    title: '<?php echo $bloklar["alert_success_adreslerim_duzenle_title"]; ?>',
                    text: '<?php echo $bloklar["alert_success_adreslerim_duzenle_desc"]; ?>',
                    icon: 'success',
                    customClass: {
                      confirmButton: 'btn btn-success'
                    },
                    buttonsStyling: false
                  }).then(function() { window.location.href = "<?php echo URL."adreslerim/"; ?>";});
                return true;
            } else if (data == "basarisiz") {
                  Swal.fire({
                    title: '<?php echo $bloklar["alert_eror_adreslerim_duzenle_title"]; ?>',
                    text: '<?php echo $bloklar["alert_eror_adreslerim_duzenle_desc"]; ?>',
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
