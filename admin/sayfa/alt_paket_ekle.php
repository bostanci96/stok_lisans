<?php
		echo !defined('ADMIN') ? die(	go(ADMIN_URL.'index.php?sayfa=404')) : null;
?>
<div class="content-wrapper">
	<div class="content-header row">
		<div class="content-header-left col-md-9 col-12 mb-2">
			<div class="row breadcrumbs-top">
				<div class="col-12">
					<h2 class="content-header-title float-left mb-0">Alt Paket Ekle</h2>
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo ADMIN_URL ;?>">Anasayfa</a>
						</li>
						<li class="breadcrumb-item"><a href="index.php?sayfa=alt_paketler">Alt Paketler</a>
					</li>
					<li class="breadcrumb-item active"><a href="javascript:void(0);">Alt Paket Ekle </a>
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
				<h4 class="card-title">   <p><b>Alt Paket Ekle</b></p> </h4>
			</div>
			<div class="card-content">
				<div class="card-body">
					<form role="form"  id="forms" method="POST" action="ajax.php?p=alt_paket_ekle">
						<div class="row">
						
							<div class="col-12">
								<div class="form-group row">
									<div class="col-md-2">
										<span>Paket Cinsi</span>
									</div>
									<div class="col-md-10">
										<fieldset class="position-relative has-icon-left">
											<select class="form-control" name="paket_cins">
												<option value="1">Freepik</option>
												<option value="2">Envato</option>
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
											<input type="text" class="form-control" name="paket_adi" placeholder="" >
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
										<span>Paket Tutarı</span>
									</div>
									<div class="col-md-10">
										<fieldset class="position-relative has-icon-left">
											<input type="text" class="form-control" name="paket_tutar" placeholder="" >
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
											<input type="text" class="form-control" name="gil" placeholder="" >
											<div class="form-control-position">
												<i class="feather icon-type"></i>
											</div>
										</fieldset>
									</div>
								</div>
							</div>
					


					
						
							<div class="form-group col-md-8 offset-md-4">
							</div>
						</div>
						<div class="row">
					
						<div class="col-md-8">
							<div id="id_box"></div>
							<button type="submit" class="btn btn-primary btn-lg mr-1 mb-1" value="true">Paket Ekle</button>

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
						window.location.href = "<?php echo ADMIN_URL.'index.php?sayfa=alt_paketler'; ?>"
					});
					return false;
				}else if(data=="basarili"){
					sweetAlert({
								title	: "Başarılı",
								text 	: "Alt Paket Eklendi!",
								type	: "success"
					},
					function(){
						window.location.href = "<?php echo ADMIN_URL.'index.php?sayfa=alt_paketler'; ?>"
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