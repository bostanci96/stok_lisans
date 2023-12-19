<?php echo !defined("ADMIN") ? die(	go(ADMIN_URL.'index.php?sayfa=404')) : null;?>
<link rel="stylesheet" type="text/css" href="<?php echo TEMA_URL; ?>tema-assets/jquery.dataTables.css">
<div class="content-header row">
</div>
<div class="content-body">
	<!-- Dashboard Analytics Start -->
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-9 col-12 mb-2">
				<div class="row breadcrumbs-top">
					<div class="col-12">
						<h2 class="content-header-title float-left mb-0">Yönetim Paneli</h2>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">Anasayfa</a>
								</li>
								<li class="breadcrumb-item active">Yönetim Paneli
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="content-body">
			<!-- Statistics card section start -->
			<section id="statistics-card">



<div class="row">

					<div class="col-lg-3 col-sm-6 col-12">
						<div class="card">
							<div class="card-header d-flex flex-column align-items-start pb-0" style="margin-bottom: 25px;">
								<?php
									$nowDate = date("Y-m-d");
                                    $b_indirilmis = 0;
                                    $indirmeler = $db->query("SELECT * FROM indirmeler");
                                    $indirmelerforeach = $indirmeler->fetchAll(PDO::FETCH_ASSOC);
                                    $indirmelerRow = $indirmeler->rowCount();
                                    foreach($indirmelerforeach as $m){

                                            $tarih = explode(" ", $m["tarih"]);
                                            $tarih[0];
                                        if($nowDate == $tarih[0]){
                                            $b_indirilmis += 1;
                                        }

                                    }

									?>
									<h2 class="text-bold-700 mt-1"><?php echo $b_indirilmis;?></h2>
									<p class="mb-0">Bugün İndirilmiş</p>
								</div>

							</div>
						</div>

                        <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-column align-items-start pb-0" style="margin-bottom: 25px;">
                                <?php
                                    $uyelersss = $db->query("SELECT * FROM uyeler")->rowCount();

                                    ?>
                                    <h2 class="text-bold-700 mt-1"><?php echo $uyelersss;?></h2>
                                    <p class="mb-0">Toplam Üye</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-column align-items-start pb-0" style="margin-bottom: 25px;">
                                <?php
                                    $g_ciro = 0;
                                    $cirolar = $db->query("SELECT * FROM paytr_bildirim WHERE durum = 2");
                                    $cirolarforeach = $cirolar->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($cirolarforeach as $m){

                                            $tarih = explode(" ", $m["tarih"]);
                                            $tarih[0];
                                        if($nowDate == $tarih[0]){
                                            $g_ciro += $m["tutar"];
                                        }

                                    }

                                    ?>
                                    <h2 class="text-bold-700 mt-1"><?php echo $g_ciro;?>₺</h2>
                                    <p class="mb-0">Günlük Ciro</p>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex flex-column align-items-start pb-0" style="margin-bottom: 25px;">
                                <?php
                                    $t_ciro = 0;
                                    foreach($cirolarforeach as $m){
                                            $t_ciro += $m["tutar"];

                                    }

                                    ?>
                                    <h2 class="text-bold-700 mt-1"><?php echo $t_ciro;?>₺</h2>
                                    <p class="mb-0">Toplam Ciro</p>
                                </div>

                            </div>
                        </div>
							
</section>
<section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table id="example2" class="dt-responsive table" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Kullanıcı</th>
                                <th>Hizmet</th>
                                <th>Link</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $catQuery = $db->query("SELECT * FROM indirmeler");
                            if ($catQuery->rowCount()) {
                            foreach ($catQuery as $catRow) {
                            	$uyeidd = $catRow["kisi_id"];
                            	$uyelers = $db->query("SELECT * FROM uyeler WHERE uye_id = '$uyeidd'")->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $catRow["id"];?></td>
                                <td><a href="index.php?sayfa=kullanici_duzenle&id=<?php echo $uyeidd; ?>"><?php echo $uyelers["uye_ad"]." ".$uyelers["uye_soyad"];?></a></td>
                                <td><?php  if($catRow["hizmet"]==1){ echo "Freepik"; }elseif($catRow["hizmet"]==2){ echo "Envato Elements"; } ?></td>
                                <td><a href="<?php echo $catRow["resim_link"]; ?>" target="_blank"><?php echo $catRow["resim_link"]; ?></a></td>
                                <td>
                                    
                                    <?php
                                            if ($catRow["durum"] == 1) { ?>
                                            <div class="chip chip-danger">
                                                <div class="chip-body">
                                                    <div class="chip-text">İndirilmedi</div>
                                                </div>
                                            </div> <?php }else if ($catRow["durum"] == 2) { ?>
                                            <div class="chip chip-success">
                                                <div class="chip-body">
                                                    <div class="chip-text">İndirildi</div>
                                                </div>
                                            </div> <?php } ?>
                                            

                                </td>
                                <td><?php echo $catRow["tarih"]; ?></td>
                            </tr>
                            <?php }  } ?>
                            
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- // Statistics Card section end-->

</div>

   <script type="text/javascript">

    	$(document).ready(function() {
$('#example').DataTable( {
"aLengthMenu": [[40, 100, 150, 200], [40, 100, 150, 200]],
"pageLength": 40,
 order: [[2, 'asc']],
/*dom: 'Bfrtip',
buttons: [
'copy', 'csv', 'excel', 'pdf', 'print'
]*/
} );
$('#example2').DataTable( {
"aLengthMenu": [[40, 100, 150, 200], [40, 100, 150, 200]],
"pageLength": 40,
 order: [[2, 'asc']],
/*dom: 'Bfrtip',
buttons: [
'copy', 'csv', 'excel', 'pdf', 'print'
]*/
} );
$('#example3').DataTable( {
"aLengthMenu": [[40, 100, 150, 200], [40, 100, 150, 200]],
"pageLength": 40,
 order: [[2, 'asc']],
/*dom: 'Bfrtip',
buttons: [
'copy', 'csv', 'excel', 'pdf', 'print'
]*/
} );
} );
</script>


</div>


</div>
<!-- Dashboard Analytics end -->
