<?php 
    $uyeid = $uyeRow["uye_id"];
    $paketlerims = $db->query("SELECT * FROM paketlerim  where hizmet = 1 and paket_durum = 1 and kisi_id = '$uyeid'");
    $paketlerimcek = $paketlerims->fetch(PDO::FETCH_ASSOC);
    $paketlerim = $paketlerims->rowCount();
    $paketlerid = $paketlerimcek["paket_id"];
    $alt_paket_id = $paketlerimcek["alt_paket"];




    $paketlerceks = $db->query("SELECT * FROM paketler where id = '$paketlerid'")->fetch(PDO::FETCH_ASSOC);
    $altpakets = $db->query("SELECT * FROM alt_paketler where id = '$alt_paket_id'")->fetch(PDO::FETCH_ASSOC);

    if ($paketlerimcek["alt_paket"] != NULL) {
        $paketlerceks["gil"] = $paketlerceks["gil"]+$altpakets["gil"];
    }else{
        $paketlerceks["gil"] = $paketlerceks["gil"];
    }

    $explode1 = explode(" ", date("Y-m-d H:i:s"));

	$explode2 = explode(" ", $paketlerimcek["paket_bitis_tarih"]);

	$baslangicTarihi = strtotime("".$explode1[0].""); 

	$bitisTarihi = strtotime("".$explode2[0].""); 

	$fark = ($bitisTarihi - $baslangicTarihi) / 86400;

        $nowDate = date("Y-m-d");
        $day_limit = 0;
        $paket_idd = $paketlerimcek["id"];
        $indirmeler = $db->query("SELECT * FROM indirmeler where hizmet = 1 and paket_id = '$paket_idd' and kisi_id = '$uyeid'");
        $total_downloads = $db->query("SELECT * FROM indirmeler where hizmet = 1 and kisi_id = '$uyeid'")->rowCount();
        $indirmelerforeach = $indirmeler->fetchAll(PDO::FETCH_ASSOC);
        $indirmelerRow = $indirmeler->rowCount();
        foreach($indirmelerforeach as $m){

                $tarih = explode(" ", $m["tarih"]);
                $tarih[0];
            if($nowDate == $tarih[0]){
                $day_limit += 1;
            }

        }


 ?>
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Freepik</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=URL?>"><?php echo $bloklar["site_link_map_home"]; ?></a>
                    </li>
                    <li class="breadcrumb-item active">Freepik
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
 
  	<?php if($paketlerim != 0){ ?>
  		 <div class="col-lg-4 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        <h2 class="fw-bolder mb-0"><?php echo $paketlerceks["gil"]-$day_limit; ?></h2>
                                        <p class="card-text">Kalan Günlük İndirme Limiti</p>
                                    </div>
                                    <div class="avatar bg-light-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="download" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-4 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        <h2 class="fw-bolder mb-0"><?php echo $fark; ?> Gün</h2>
                                        <p class="card-text">Bitiş Tarihi</p>
                                    </div>
                                    <div class="avatar bg-light-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="calendar" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-4 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        <h2 class="fw-bolder mb-0"><?php echo $total_downloads; ?></h2>
                                        <p class="card-text">Toplam İndirme Sayısı</p>
                                    </div>
                                    <div class="avatar bg-light-primary p-50 m-0">
                                        <div class="avatar-content">
                                            <i data-feather="download" class="font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <?php } ?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Freepik</h4><h4 class="card-title" style="float:right;">Servis Durumu : <?php if($bakim["freepik_mod"]==0){echo '<button type="submit" class="btn btn-danger">Pasif</button>';}elseif($bakim["freepik_mod"]==1){echo '<button type="submit" class="btn btn-success">Aktif</button>';} ?></h4>
                </div>
                <div class="card-body">
                    <?php if($paketlerim == 0){ ?>
                        <div class="d-flex align-content-center justify-content-center align-items-center">
                             <div class="auth-wrapper auth-basic px-2 col-md-5">
                        <div class="auth-inner my-2">
                            <!-- verify email basic -->
                            <div class="card mb-0">
                                <div class="card-body text-center">
                                    <a href="<?php echo URL; ?>" class="brand-logo">
                                        <img class="img-fluid" width="100" src="<?php echo URL;?>images/indir.png" alt="<?php echo $ayar[$lehce."site_title"];?>">
                                    </a>
                                    <center>
                                    <h2 class="card-title fw-bolder mb-1">Hata</h2>
                                    <p class="card-text mb-2">
                                        Freepik Hizmetine Sahip Değilsiniz!
                                        Aşşağıdaki Link İle Mağazaya Giderek Satın Alabilirsiniz
                                    </p>
                                    </center>
                                    <a href="<?php echo URL; ?>magaza/" class="btn btn-primary w-100">Mağaza</a>
                                </div>
                            </div>
                            <!-- / verify email basic -->
                        </div>
                    </div>
                     </div>
                    <?php }else{ ?>
                    <form role="form" class="form-horizontal" id="forms" method="POST" action="<?php echo TEMA_URL; ?>ajax.php?p=freepik"  enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="uyeid" value="<?php echo $uyeRow["uye_id"]; ?>">
                            <input type="hidden" name="paket_id" value="<?php echo $paketlerimcek["id"]; ?>">
                            <input type="hidden" name="asgduyas" value="<?php echo $day_limit; ?>">
                            <input type="hidden" name="gaoihsg" value="<?php echo $paketlerceks["gil"]; ?>">
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" >İçerik Url Giriniz</label>
                                    <input <?php if($day_limit == $paketlerceks["gil"]){echo"disabled";} ?> <?php if($bakim["freepik_mod"]==0){echo "disabled";} ?> type="text" <?php if($bakim["freepik_mod"]==0){echo "disabled";} ?> class="form-control" name="url" placeholder="İçerik Url Giriniz" />
                                </div>
                            </div>
                            <div class=" col-md-12">
                            <center>
                            <button type="submit" <?php if($day_limit == $paketlerceks["gil"]){echo"disabled";} ?> <?php if($bakim["freepik_mod"]==0){echo "disabled";} ?> class="btn btn-success me-1 mt-2"><?php if($day_limit == $paketlerceks["gil"]){echo"Günlük İndirime Limitiniz Doldu!";}else{echo"İndirme Bağlantısı Oluştur";} ?></button>
                            </center>
                        </div>
                        </div>
                    </form>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

    
<?php 
    
$duyuruYesil = $db->query("SELECT * FROM duyurular WHERE hizmet = 1 ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

foreach($duyuruYesil as $mx):
 ?>

 <div class="alert alert-<?php if($mx["duyuru_cins"]==1){echo"danger";}elseif($mx["duyuru_cins"]==2){echo "success";} ?>" role="alert">
                                            <h4 class="alert-heading"><?php echo $mx["duyuru_baslik"]; ?></h4>
                                            <div class="alert-body">
                                               <?php echo $mx["duyuru_icerik"]; ?>
                                            </div>
                                        </div>
<?php endforeach; 


$dkontrolid = $uyeRow["last_request_freepik_id"];
$dkontrol = $db->query("SELECT * FROM indirmeler WHERE id = '$dkontrolid'")->fetch(PDO::FETCH_ASSOC);
$downloadView = "";
if($dkontrolid != 0){
if($dkontrol["hizmet"] == 1){
    $downloadView = true;
}else{

    $downloadView = false;
}
}else{
    $downloadView = false;
}


?>
<!-- /Horizontal Wizard -->
</div>
<script>
 $(document).ready(function(event) {
    $('#forms').ajaxForm({
       /*  uploadProgress: function(event, position, total, percentComplete) {
            let timerInterval
            Swal.fire({
                icon: 'info',
                title: 'Bekleyiniz',
                html: 'İndirme bağlantınız oluşturulana kadar lütfen bekleyin, sayfayı kapatmayın!',
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            });
        },*/
        success: function(data) {
            if (data == "bos-deger") {
                 Swal.fire({
                    title: 'Hata',
                    text: 'Lütfen Boşluk Bırakmayınız',
                    icon: 'info',
                    customClass: {
                      confirmButton: 'btn btn-info'
                    },
                    buttonsStyling: false
                  });
                return false;
            } else if (data == "gecersizurl") {
                 Swal.fire({
                    title: 'Hata',
                    text: 'Lütfen Freepik Linki Olduğundan Emin Olun !',
                    icon: 'info',
                    customClass: {
                      confirmButton: 'btn btn-info'
                    },
                    buttonsStyling: false
                  });
                return false;
            }else if (data == "premiumdegil") {
                 Swal.fire({
                    title: 'Hata',
                    text: 'Lütfen İndirmeye Çalıştığınız Dosyanın Premium Olduğundan Emin Olun !',
                    icon: 'info',
                    customClass: {
                      confirmButton: 'btn btn-info'
                    },
                    buttonsStyling: false
                  });
                return false;
            }else if (data == "basarili") {
                   Swal.fire({
                icon: 'info',
                title: 'Bekleyiniz',
                html: 'İndirme bağlantınız oluşturulana kadar lütfen bekleyin, sayfayı kapatmayın!',
                timer:420000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                    }, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then(function() { 
window.location.href = "<?php echo URL; ?>freepik/";
                  });
                return true;
            } else if (data == "basarisiz") {
                  Swal.fire({
                    title: 'Hata',
                    text: 'Bir Hata Oluştu',
                    icon: 'error',
                    customClass: {
                      confirmButton: 'btn btn-warning'
                    },
                    buttonsStyling: false
                  });
                return false;
            } else if (data == "yok") {
                  Swal.fire({
                    title: 'Hata',
                    text: 'Bir Hata Oluştu',
                    icon: 'error',
                    customClass: {
                      confirmButton: 'btn btn-warning'
                    },
                    buttonsStyling: false
                  });
                return false;
            }else if (data == "indirmebasarili") {
window.location.href = "<?php echo URL; ?>freepik/";
            }
        }



    });
  <?php if ($downloadView) { ?>
        Swal.fire({
                    title: 'Başarılı',
                    text: 'Dosyanız başarılı bir şekilde indirildi.',
                    icon: 'success',
                    customClass: {
                      confirmButton: 'btn btn-success'
                    },
                    footer: '<a download target="_blank" href="<?php echo $dkontrol["indirme_link"]; ?>">Buraya Tıklayarak Dosyanızı İndiriniz..</a>',
                    buttonsStyling: false
                  }).then(function() { 
 window.open('<?php echo $dkontrol["indirme_link"]; ?>', '_blank');
IndirmeSifirla(<?php echo $uyeRow["uye_id"]; ?>);


                  });
              <?php } ?>
});



    function IndirmeSifirla(catId) {
        $.post('<?php echo TEMA_URL; ?>ajax.php?p=IndirmeSifirlaFree', {
            id: catId
        }, function(data) {});
    }
</script>
