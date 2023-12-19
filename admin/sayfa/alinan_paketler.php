<?php echo !defined("ADMIN") ? die(	go(ADMIN_URL.'index.php?sayfa=404')) : null;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<div class="content-wrapper">
	<div class="content-header row">
		<div class="content-header-left col-md-9 col-12 mb-2">
			<div class="row breadcrumbs-top">
				<div class="col-12">
					<h2 class="content-header-title float-left mb-0">Satın Alınan Paketler</h2>
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo ADMIN_URL ;?>">Anasayfa</a>
							</li>
							<li class="breadcrumb-item active"><a href="index.php?sayfa=alinan_paketler">Satın Alınan Paketler </a>
							</li>
						</ol>
					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="content-body">
		<!-- Data list view starts -->
		<section id="data-list-view" class="data-list-view-header">


			<!-- DataTable starts -->
			<div class="table-responsive">
				<div class="actions action-btns"><div class="dt-buttons btn-group">
					<a href="index.php?sayfa=paket_ekle" class="btn btn-outline-primary" tabindex="0" aria-controls="DataTables_Table_0"><span><i class="feather icon-plus"></i> Yeni Ekle</span></a> </div></div>
					<table class="table data-list-view">
						<thead>
							<tr><th></th>
								<th>ID</th>
								<th>Üye Adı</th>
								<th>Paket Cinsi</th>
								<th>Paket Adı</th>
								<th>Paket Tutar</th>
								<th>Satın Alım Tarihi</th>
								<th>Bitiş Tarihi</th>
							</tr>
						</thead>
						<tbody>


							<?php
							$kquery = $db->query("SELECT * FROM paketlerim order by id desc");
							if($kquery->rowCount()){
								foreach($kquery as $kRow){
									$paket_id = $kRow["paket_id"];
									$uye_id = $kRow["kisi_id"];
									$paketler = $db->query("select * from paketler where id = '$paket_id'")->fetch(PDO::FETCH_ASSOC);
									$uyeler = $db->query("select * from uyeler where uye_id = '$uye_id'")->fetch(PDO::FETCH_ASSOC);
								?>
								<tr>
									<td></td>
									<td><?php echo $kRow["id"];?></td>
									<td><?php echo $uyeler["uye_ad"]." ".$uyeler["uye_soyad"];?></td>
									<td><?php if($paketler["paket_cins"]==1){echo "Freepik";}elseif($paketler["paket_cins"]==2){echo"Envato";}?></td>
									<td><?php echo $paketler["paket_adi"];?></td>
									<td><?php echo $paketler["paket_tutar"];?>₺</td>
									<td><?php echo $kRow["paket_alim_tarih"];?></td>
									<td><?php echo $kRow["paket_bitis_tarih"];?></td>
								</tr>

							<?php  }} ?>



						</tbody>
					</table>
				</div>
				<!-- DataTable ends -->

				<!-- add new sidebar ends -->
			</section>
			<!-- Data list view end -->

		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('.datatable').dataTable({
				"bSort":false
			});
		});
		function paketSil(catId){
			$.post('ajax.php?p=paket_sil', {id: catId}, function (data) {
				if(data=="basarili"){
					sweetAlert({
						title	: "Başarılı",
						text 	: "Paket başarılı bir şekilde silinmiştir.",
						type	: "success"
					},
					function(){
						window.location.reload(true);
					});
					return false;
				}else if(data=="basarisiz"){
					swal("Başarısız","Silinemedi","error");
					return false;
				}
			});
		}
		function paketDurum(catId){
			$.post('ajax.php?p=paket_durum', {id: catId}, function (data) {
				if(data=="yasaklama-basarili"){
					sweetAlert({
						title	: "Başarılı",
						text 	: "Paket başarılı bir şekilde gizlendi.",
						type	: "success"
					},
					function(){
						window.location.reload(true);
					});
					return false;
				}else if(data=="yasak-kaldirildi"){
					sweetAlert({
						title	: "Başarılı",
						text 	: "Paket başarılı bir şekilde aktifleştirildi.",
						type	: "success"
					},
					function(){
						window.location.reload(true);
					});
					return false;
				}else if(data=="basarisiz"){
					swal("Başarısız","Silinemedi","error");
					return false;
				}
			});
		}

	</script>
