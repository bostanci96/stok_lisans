<?php 
    $uyeid = $_SESSION["uye_id"];
    $freepik = $db->query("SELECT * FROM paketlerim  where hizmet = 1 and paket_durum = 1 and kisi_id = '$uyeid'");
    $freepikcek = $freepik->fetch(PDO::FETCH_ASSOC);
    $freepikRow = $freepik->rowCount();


    $freepikexplode1 = explode(" ", date("Y-m-d H:i:s"));

    $freepikexplode2 = explode(" ", $freepikcek["paket_bitis_tarih"]);

    $freepikbaslangictarih = strtotime("".$freepikexplode1[0].""); 

    $freepikbitistarih = strtotime("".$freepikexplode2[0].""); 

    $freepikfark = ($freepikbitistarih - $freepikbaslangictarih) / 86400;

    $envato = $db->query("SELECT * FROM paketlerim  where hizmet = 2 and paket_durum = 1 and kisi_id = '$uyeid'");
    $envatocek = $envato->fetch(PDO::FETCH_ASSOC);
    $envatoRow = $envato->rowCount();


    $envatoexplode1 = explode(" ", date("Y-m-d H:i:s"));

    $envatoexplode2 = explode(" ", $envatocek["paket_bitis_tarih"]);

    $envatobaslangictarih = strtotime("".$envatoexplode1[0].""); 

    $envatobitistarih = strtotime("".$envatoexplode2[0].""); 

    $envatofark = ($envatobitistarih - $envatobaslangictarih) / 86400;

     $indirmeler = $db->query("SELECT * FROM indirmeler where kisi_id = '$uyeid'")->rowCount();

     durum
 ?>

<div class="content-body">
	<link rel="stylesheet" type="text/css" href="<?php echo TEMA_URL; ?>tema-assets/jquery.dataTables.css">
	<section id="basic-input">
    <div class="row">
         <div class="col-lg-4 col-sm-6 col-12">
                

                <div class="card">
                    <div class="card-header">
                        <div>
                            <h2 class="fw-bolder mb-0"><?php echo $indirmeler; ?></h2>
                            <p class="card-text">Toplam İndirmeler</p>
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
                            <h2 class="fw-bolder mb-0"><?php if($freepikRow == 0){echo "Yok";}else{echo $freepikfark." Gün";} ?></h2>
                            <p class="card-text">Freepik Bitiş Tarihi</p>
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
                            <h2 class="fw-bolder mb-0"><?php if($envatoRow == 0){echo "Yok";}else{echo $envatofark." Gün";} ?></h2>
                            <p class="card-text">Envato Elements Bitiş Tarihi</p>
                        </div>
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather="calendar" class="font-medium-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Paket Geçmişim</h4>
                    
                </div>
                <div class="card-body">
                    <table id="example" class="dt-responsive table" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>SERVİS ADI</th>
                                <th>GÜNLÜK İNDİRME</th>
                                <th>HİZMET</th>
                                <th>DURUM</th>
                                <th>BİTİŞ TARİHİ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $catQuery = $db->query("SELECT * FROM  paketlerim WHERE kisi_id={$_SESSION['uye_id']} ");
                            if ($catQuery->rowCount()) {
                            foreach ($catQuery as $catRow) {
                            	$paket_id = $catRow["paket_id"];
                            	$paketler = $db->query("SELECT * FROM paketler where id = '$paket_id' ")->fetch(PDO::FETCH_ASSOC);

                            	$explode1 = explode(" ", date("Y-m-d H:i:s"));
                            	$explode2 = explode(" ", $catRow["paket_bitis_tarih"]);

                            	$baslangicTarihi = strtotime("".$explode1[0].""); 

								$bitisTarihi = strtotime("".$explode2[0].""); 

								$fark = ($bitisTarihi - $baslangicTarihi) / 86400;


                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $catRow["id"];  ;?></td>
                                <td><?php echo $paketler["paket_adi"]; ?></td>
                                <td><?php echo $paketler["gil"]; ?></td>
                                <td><?php if($paketler["paket_cins"]==1){echo "Freepik";}elseif($paketler["paket_cins"]==2){echo"Envato";}?></td>
                                <td>
                                	
                                	<?php
											if ($catRow["paket_durum"] == 0) { ?>
											<div class="chip chip-danger">
												<div class="chip-body">
													<div class="chip-text">Süresi Bitmiş</div>
												</div>
											</div> <?php }else if ($catRow["paket_durum"] == 1) { ?>
											<div class="chip chip-success">
												<div class="chip-body">
													<div class="chip-text">Aktif</div>
												</div>
											</div> <?php } ?>
											

                                </td>
                                <td><?php echo $fark; ?> Gün</td>
                            </tr>
                            <?php }  } ?>
                            
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

    <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">İndirme Geçmişi</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="freepik-tab" data-bs-toggle="tab" href="#freepik" aria-controls="freepik" role="tab" aria-selected="true">Freepik</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="envato-tab" data-bs-toggle="tab" href="#envato" aria-controls="envato" role="tab" aria-selected="false">Envato Elements</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="freepik" aria-labelledby="freepik-tab" role="tabpanel">
                                            <section id="basic-input">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table id="example3" class="dt-responsive table" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Link</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $catQuery = $db->query("SELECT * FROM indirmeler WHERE hizmet = 1 AND kisi_id={$_SESSION['uye_id']} ");
                            if ($catQuery->rowCount()) {
                            foreach ($catQuery as $catRow) {
                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $catRow["id"];  ;?></td>
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
                                        </div>
                                        <div class="tab-pane" id="envato" aria-labelledby="envato-tab" role="tabpanel">
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
                                <th>Link</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $catQuery = $db->query("SELECT * FROM indirmeler WHERE hizmet = 2 AND kisi_id={$_SESSION['uye_id']} ");
                            if ($catQuery->rowCount()) {
                            foreach ($catQuery as $catRow) {
                            ?>
                            <tr>
                                <td></td>
                                <td><?php echo $catRow["id"];  ;?></td>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
