<?php echo !defined("ADMIN") ? die(	go(ADMIN_URL.'index.php?sayfa=404')) : null;

error_reporting(E_ALL);

?>

<div class="content-wrapper">
	<div class="content-header row">
		<div class="content-header-left col-md-9 col-12 mb-2">
			<div class="row breadcrumbs-top">
				<div class="col-12">
					<h2 class="content-header-title float-left mb-0">Kuponlar</h2>
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo ADMIN_URL ;?>">Anasayfa</a>
							</li>
							<li class="breadcrumb-item active"><a href="index.php?sayfa=kuponlar">Kuponlar</a>
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
					<a href="index.php?sayfa=kupon_ekle" class="btn btn-outline-primary" tabindex="0" aria-controls="DataTables_Table_0"><span><i class="feather icon-plus"></i> Yeni Ekle</span></a> </div></div>
					<table class="table data-list-view">
						<thead>
							<tr><th></th>
								<th>ID</th>
								<th>Paket Adı</th>
								<th>Kupon Başlık</th>
								<th>Kupon Kod</th>
								<th>Kalan Adet</th>
								<th>Oluşturma Tarih</th>
								<th>İşlemler</th>
							</tr>
						</thead>
						<tbody>


							<?php
							$kquery = $db->query("SELECT * FROM kuponlar order by id desc");
							if($kquery->rowCount()){
								foreach($kquery as $kRow){
									$paket_id = $kRow["paket_id"];
									$paketler = $db->query("SELECT * FROM paketler WHERE id = '$paket_id'")->fetch(PDO::FETCH_ASSOC);
								?>
								<tr>
									<td></td>
									<td><?php echo $kRow["id"];?></td>
									<td><?php echo $paketler["paket_adi"];?></td>
									<td><?php echo $kRow["kupon_baslik"];?></td>
									<td><?php echo $kRow["kupon_kod"];?></td>
									<td><?php echo $kRow["kupon_adet"];?></td>
									<td><?php echo tarih($kRow["tarih"]);?></td>
										<td> <div class="dropdown dropright">

												<button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													İşlemler
												</button>
												<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													<a class="dropdown-item" href="index.php?sayfa=kupon_duzenle&id=<?php echo $kRow["id"];?>">Görüntüle / Düzenle</a>
													<a class="dropdown-item"  onclick="kuponSil(<?php echo $kRow["id"];?>);" >Kupon Sil</a>
												</div>
											</div>   


										</td>
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
		function kuponSil(catId){
			$.post('ajax.php?p=kupon_sil', {id: catId}, function (data) {
				if(data=="basarili"){
					sweetAlert({
						title	: "Başarılı",
						text 	: "Kupon başarılı bir şekilde silinmiştir.",
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
						text 	: "Kupon başarılı bir şekilde gizlendi.",
						type	: "success"
					},
					function(){
						window.location.reload(true);
					});
					return false;
				}else if(data=="yasak-kaldirildi"){
					sweetAlert({
						title	: "Başarılı",
						text 	: "Kupon başarılı bir şekilde aktifleştirildi.",
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
