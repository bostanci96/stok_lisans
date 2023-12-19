<?php
		echo !defined('ADMIN') ? die(	go(ADMIN_URL.'index.php?sayfa=404')) : null;
if(isset($_GET["id"])){
	$id = g("id");
	$uyeControl = $db->prepare("SELECT * FROM paketler WHERE id=:id");
	$uyeControl->execute(array("id"=>$id));
	if($uyeControl->rowCount()){
		$uyeRow = $uyeControl->fetch(PDO::FETCH_ASSOC);
	}else{
				go(ADMIN_URL.'index.php?sayfa=404');
	}
}else{
			go(ADMIN_URL.'index.php?sayfa=404');
}
?>
<div class="content-wrapper">
	<div class="content-header row">
		<div class="content-header-left col-md-9 col-12 mb-2">
			<div class="row breadcrumbs-top">
				<div class="col-12">
					<h2 class="content-header-title float-left mb-0">Paket Düzenle</h2>
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo ADMIN_URL ;?>">Anasayfa</a>
						</li>
						<li class="breadcrumb-item"><a href="index.php?sayfa=paketler">Paketler</a>
					</li>
					<li class="breadcrumb-item active"><a href="javascript:void(0);">Paket Düzenle </a>
				</li>
			</ol>
		</div>
	</div>
</div>
</div>
</div>
<div class="content-body">
<section id="multiple-column-form">
<div class="row match-height">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">   <p><b><?php echo $uyeRow["paket_adi"];?></b> Adlı Paket Kontrol..</p> </h4>
			</div>
			<div class="card-content">
				<div class="card-body">
					<form role="form"  id="forms" method="POST" action="ajax.php?p=paket_duzenle">
						<input type="hidden" name="id" value="<?php echo $uyeRow["id"];?>"/>
						<div class="row">
							<div class="col-12">
								<div class="form-group row">
									<div class="col-md-2">
										<span>Paket Cinsi</span>
									</div>
									<div class="col-md-10">
										<fieldset class="position-relative has-icon-left">
											<select class="form-control" name="paket_cins">
												<option <?php if($uyeRow["paket_cins"]==1){echo"selected";} ?> value="1">Freepik</option>
												<option <?php if($uyeRow["paket_cins"]==2){echo"selected";} ?>  value="2">Envato</option>
											</select>
											<div class="form-control-position">
												<i class="feather icon-type"></i>
											</div>
										</fieldset>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group row">
									<div class="col-md-2">
										<span>Paket Adı</span>
									</div>
									<div class="col-md-10">
										<fieldset class="position-relative has-icon-left">
											<input type="text" class="form-control" name="paket_adi" value="<?php echo $uyeRow["paket_adi"];?>" placeholder="" >
											<div class="form-control-position">
												<i class="feather icon-type"></i>
											</div>
										</fieldset>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group row">
									<div class="col-md-2">
										<span>Paket Tutar</span>
									</div>
									<div class="col-md-10">
										<fieldset class="position-relative has-icon-left">
											<input type="text" class="form-control" name="paket_tutar" value="<?php echo $uyeRow["paket_tutar"];?>" placeholder="" >
											<div class="form-control-position">
												<i class="feather icon-type"></i>
											</div>
										</fieldset>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group row">
									<div class="col-md-2">
										<span>Kullanım Gün Hakkı</span>
									</div>
									<div class="col-md-10">
										<fieldset class="position-relative has-icon-left">
											<input type="text" class="form-control" name="kgh" value="<?php echo $uyeRow["kgh"];?>" placeholder="" >
											<div class="form-control-position">
												<i class="feather icon-type"></i>
											</div>
										</fieldset>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group row">
									<div class="col-md-2">
										<span>Günlük İndirme Limiti</span>
									</div>
									<div class="col-md-10">
										<fieldset class="position-relative has-icon-left">
											<input type="text" class="form-control" name="gil" value="<?php echo $uyeRow["gil"];?>" placeholder="" >
											<div class="form-control-position">
												<i class="feather icon-type"></i>
											</div>
										</fieldset>
									</div>
								</div>
							</div>
						
						</div>
						<div class="row">
					
						<div class="col-md-8">
							<div id="id_box"></div>
							<button type="submit" class="btn btn-danger btn-lg mr-1 mb-1" value="true">Düzenle</button>

						</div>
					</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
</div>
</section>
</div>
</div>
<script>
	$(document).ready(function(event) {
		$('#forms').ajaxForm({
			success: function(data) {
				if(data=="bos-deger"){
					sweetAlert("Hata","Boş Değer Bırakmamalısınız","error");
					return false;
				}else if(data=="basarilixxx"){
					sweetAlert({
								title	: "Başarılı",
								text 	: "Fatura Talep Red Edildi!",
								type	: "success"
					},
					function(){
						window.location.href = "<?php echo ADMIN_URL.'index.php?sayfa=paketler'; ?>"
					});
					return false;
				}else if(data=="basarili"){
					sweetAlert({
								title	: "Başarılı",
								text 	: "Paket Düzenlendi!",
								type	: "success"
					},
					function(){
						window.location.href = "<?php echo ADMIN_URL.'index.php?sayfa=paketler'; ?>"
					});
					return false;
				}else{
					sweetAlert(data,"Bir Hata Oluştu !","error");
					return false;
				}
			}
		});
	});
</script>