<?php
$paket = $db->query("select * from paketler where paket_durum = 1")->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Mağaza</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=URL?>"><?php echo $bloklar["site_link_map_home"]; ?></a>
                    </li>
                    <li class="breadcrumb-item active">Mağaza
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
</div>
<style type="text/css">
.badge.badge-light-danger {
background-color: rgb(42 133 61 / 23%);
color: #164921 !important;
}
.card-body ul {
padding: 0;
}
.card-body ul li{
list-style: none;
}
</style>
<div class="content-detached">
<div class="content-body">
    <!-- Blog List -->
    <div class="blog-list-wrapper" id="pricing-plan">
        <!-- Blog List Items -->
        <div class="row pricing-card">
            <?php foreach($paket as $m):
               $hizmet_id =  $m["paket_cins"];
               $uyeidddd =  $uyeRow["uye_id"];
                  $paketlerim = $db->query("SELECT * FROM paketlerim WHERE paket_durum = 1 AND hizmet = '$hizmet_id' AND kisi_id = '$uyeidddd'")->rowCount();
             ?>
                        <div class="col-12 col-md-3">
                                    <div class="card standard-pricing  text-center">
                                        <div class="card-body">
                                            <div class="pricing-badge text-end">
                                                <span class="badge rounded-pill badge-light-primary"><?php if($m["paket_cins"]==1){echo"Freepik";}elseif($m["paket_cins"]==2){echo"Envato";} ?></span>
                                            </div>
                                            <h3><?php if($m["paket_cins"]==1){echo"Freepik";}elseif($m["paket_cins"]==2){echo"Envato";} ?> </h3>
                                            <p class="card-text"><?php echo $m["kgh"]; ?> GÜNLÜK</p>
                                            <div class="annual-plan">
                                                <div class="plan-price mt-2">
                                                    <span class="pricing-standard-value fw-bolder text-primary"><?php echo $m["paket_tutar"]; ?></span>
                                                    <sub class="pricing-duration text-body font-medium-1 fw-bold">₺</sub>
                                                </div>
                                                <small class="annual-pricing d-none text-muted"></small>
                                            </div>
                                            <ul class="list-group list-group-circle text-start">
                                                <li class="list-group-item"><?php if($m["paket_cins"]==1){echo"Freepik";}elseif($m["paket_cins"]==2){echo"Envato Elements";} ?></li>
                                                <li class="list-group-item"> <?php echo $m["kgh"]; ?> GÜNLÜK</li>
                                                <li class="list-group-item"> GÜNLÜK <?php echo $m["gil"]; ?> İNDİRME</li>
                                            </ul>
                                        <a href="<?php if($paketlerim > 0){echo"javascript:void(0);";}else{ ?><?php echo URL; ?>satinal/<?php echo $m["id"]; ?><?php } ?>"  class="btn <?php if($paketlerim > 0){echo"btn-outline-danger";}else{ ?>btn-outline-success <?php } ?>"><?php if($paketlerim > 0){echo"Servis Aktif";}else{ ?>Hemen Al<?php } ?></a>
                                        </div>
                                    </div>
                                </div>
        
            <?php endforeach; ?>
            
        </div>
        <!--/ Blog List -->
    </div>
</div>
</div>





<?php

$alt_paket = $db->query("select * from alt_paketler where paket_durum = 1")->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Ek Paketler</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=URL?>"><?php echo $bloklar["site_link_map_home"]; ?></a>
                    </li>
                    <li class="breadcrumb-item active">Ek Paketler
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
</div>
<style type="text/css">
.badge.badge-light-danger {
background-color: rgb(42 133 61 / 23%);
color: #164921 !important;
}
.card-body ul {
padding: 0;
}
.card-body ul li{
list-style: none;
}
</style>
<div class="content-detached">
<div class="content-body">
    <!-- Blog List -->
    <div class="blog-list-wrapper" id="pricing-plan">
        <!-- Blog List Items -->
        <div class="row pricing-card">
            <?php foreach($alt_paket as $m):
               $hizmet_id =  $m["paket_cins"];
               $uyeidddd =  $uyeRow["uye_id"];
                  $paketlerims = $db->query("SELECT * FROM paketlerim WHERE paket_durum = 1 AND hizmet = '$hizmet_id' AND kisi_id = '$uyeidddd'");
                  $paketlerim = $paketlerims->rowCount();
                  $paketlerimss = $paketlerims->fetch(PDO::FETCH_ASSOC);
                  if(($paketlerimss["alt_paket"] == NULL) || ($paketlerim == 0)){
                    $rrtr = false;
                  }else{
                    $rrtr = true;
                  }
             ?>
                        <div class="col-12 col-md-3">
                                    <div class="card standard-pricing  text-center">
                                        <div class="card-body">
                                            <div class="pricing-badge text-end">
                                                <span class="badge rounded-pill badge-light-primary"><?php if($m["paket_cins"]==1){echo"Freepik";}elseif($m["paket_cins"]==2){echo"Envato";} ?></span>
                                            </div>
                                            <h3><?php if($m["paket_cins"]==1){echo"Freepik";}elseif($m["paket_cins"]==2){echo"Envato";} ?> </h3>
                                            <div class="annual-plan">
                                                <div class="plan-price mt-2">
                                                    <span class="pricing-standard-value fw-bolder text-primary"><?php echo $m["paket_tutar"]; ?></span>
                                                    <sub class="pricing-duration text-body font-medium-1 fw-bold">₺</sub>
                                                </div>
                                                <small class="annual-pricing d-none text-muted"></small>
                                            </div>
                                            <ul class="list-group list-group-circle text-start">
                                                <li class="list-group-item"><?php if($m["paket_cins"]==1){echo"Freepik";}elseif($m["paket_cins"]==2){echo"Envato Elements";} ?></li>
                                                <li class="list-group-item"> GÜNLÜK <?php echo $m["gil"]; ?> İNDİRME</li>
                                            </ul>
                                        <a href="<?php if($rrtr){echo"javascript:void(0);";}else{ ?><?php echo URL; ?>altpaket_satinal/<?php echo $m["id"]; ?><?php } ?>"  class="btn <?php if($rrtr){echo"btn-outline-danger";}else{ ?>btn-outline-success <?php } ?>"><?php if($rrtr){echo"Ek Paket Alınamaz";}else{ ?>Hemen Al<?php } ?></a>
                                        </div>
                                    </div>
                                </div>
        
            <?php endforeach; ?>
            
        </div>
        <!--/ Blog List -->
    </div>
</div>
</div>