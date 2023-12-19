<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Hediye Kupon</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=URL?>"><?php echo $bloklar["site_link_map_home"]; ?></a>
                    </li>
                    <li class="breadcrumb-item active">Hediye Kupon
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
                    <h4 class="card-title">Hediye Kupon</h4>
                </div>
                <div class="card-body">
                    <form role="form" class="form-horizontal" id="forms" method="POST" action="<?php echo TEMA_URL; ?>ajax.php?p=hediye_kupon_kullan"  enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="uyeid" value="<?php echo $uyeRow["uye_id"]; ?>">
                            <div class="col-xl-12 col-md-12 col-12">
                                <div class="mb-1">
                                    <label class="form-label" >Hediye Kupon Kodunuzu Giriniz</label>
                                    <input type="text" class="form-control" name="kod" placeholder="Hediye Kupon Kodunuz" />
                                </div>
                            </div>
                            <div class=" col-md-12">
                            <center>
                            <button type="submit" class="btn btn-success me-1 mt-2">Kodu Kullan</button>
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
                    title: 'Uyarı',
                    text: 'Lütfen boşluk bırakmayınız.',
                    icon: 'info',
                    customClass: {
                      confirmButton: 'btn btn-info'
                    },
                    buttonsStyling: false
                  });
                return false;
            } else if (data == "basarili") {
                  Swal.fire({
                    title: 'Başarılı',
                    text: 'Kupon kodunu başarılı bir şekilde kullandınız.',
                    icon: 'success',
                    customClass: {
                      confirmButton: 'btn btn-success'
                    },
                    buttonsStyling: false
                  }).then(function() { window.location.href = "<?php echo URL; ?>";});
                return true;
            } else if (data == "basarisiz") {
                  Swal.fire({
                    title: 'Başarısız',
                    text: 'Kupon kodu hatalı!',
                    icon: 'error',
                    customClass: {
                      confirmButton: 'btn btn-warning'
                    },
                    buttonsStyling: false
                  });
                return false;
            } else if (data == "var") {
                  Swal.fire({
                    title: 'Başarısız',
                    text: 'Bu hizmete zaten sahipsiniz',
                    icon: 'error',
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
