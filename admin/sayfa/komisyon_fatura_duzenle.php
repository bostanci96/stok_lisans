<?php
		echo !defined('ADMIN') ? die(	go(ADMIN_URL.'index.php?sayfa=404')) : null;
if(isset($_GET["id"])){
	$id = g("id");
	$uyeControl = $db->prepare("SELECT * FROM uyeler INNER JOIN sertifikalar ON uye_id=sertifi_uye_id WHERE sertifi_id=:id");
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
					<h2 class="content-header-title float-left mb-0">Fatura Düzenle</h2>
					<div class="breadcrumb-wrapper col-12">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo ADMIN_URL ;?>">Anasayfa</a>
						</li>
						<li class="breadcrumb-item"><a href="index.php?sayfa=komisyon_fatura_list">Komisyon Faturaları</a>
					</li>
					<li class="breadcrumb-item active"><a href="javascript:void(0);">Fatura Düzenle </a>
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
				<h4 class="card-title">   <p><b><?php echo $uyeRow["uye_ad"]." ".$uyeRow["uye_soyad"];?></b> adlı Kullanıcı Etkinlik Fatura Kontrol..</p> </h4>
			</div>
			<div class="card-content">
				<div class="card-body">
					<form role="form"  id="forms" method="POST" action="ajax.php?p=uye_fatura_talep_yukle">
						<input type="hidden" name="uye_id" value="<?php echo $uyeRow["uye_id"];?>"/>
						<input type="hidden" name="sertifi_id" value="<?php echo $uyeRow["sertifi_id"];?>"/>
						<input type="hidden" name="uye_eposta" value="<?php echo $uyeRow["uye_eposta"];?>"/>
						<input type="hidden" name="uye_ad" value="<?php echo $uyeRow["uye_ad"];?>"/>
						<input type="hidden" name="uye_soyad" value="<?php echo $uyeRow["uye_soyad"];?>"/>
						<input type="hidden" name="uye_sitedil" value="<?php echo $uyeRow["uye_sitedil"];?>"/>
						<div class="row">
						
							<div class="col-12">
								<div class="form-group row">
									<div class="col-md-2">
										<span>Etkinlik Başlık</span>
									</div>
									<div class="col-md-10">
										<fieldset class="position-relative has-icon-left">
											<input type="text" class="form-control" name="sertifi_baslik" value="<?php echo $uyeRow["sertifi_baslik"];?>" placeholder="" >
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
										<span>Etlinlik Tarih</span>
									</div>
									<div class="col-md-10">
										<fieldset class="position-relative has-icon-left">
											<input type="text" class="form-control" name="sertifi_tarih" value="<?php echo $uyeRow["sertifi_tarih"];?>" placeholder="" >
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
										<span>Etkinlik TL Tutar</span>
									</div>
									<div class="col-md-10">
										<fieldset class="position-relative has-icon-left">
											<input type="text" class="form-control" name="fatura_tl_tutar" value="<?php echo $uyeRow["fatura_tl_tutar"];?>" placeholder="" >
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
										<span>Etkinlik BNB Tutar</span>
									</div>
									<div class="col-md-10">
										<fieldset class="position-relative has-icon-left">
											<input type="text" class="form-control" name="fatura_bnb_tutar" value="<?php echo $uyeRow["fatura_bnb_tutar"];?>" placeholder="" >
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
										<span>Etkinlik Faturası</span>
									</div>
									<div class="col-md-10">
										<fieldset class="form-group">                                                    
															<div class="custom-file">
																<input type="file" class="custom-file-input" name="fatura_dosya[]" id="fatura_dosya[]">
																<label class="custom-file-label" for="inputGroupFile01">Resim Seçiniz</label>
															</div>
														</fieldset>
									</div>
								</div>
							</div>

							<div class="col-md-8">		<a href="<?php echo URL; ?>images/fatura_dosya/big/<?php echo $uyeRow["fatura_dosya"]; ?>" target="_blank"><img  src="<?php echo URL; ?>images/fatura_dosya/big/<?php echo $uyeRow["fatura_dosya"]; ?>" class="img-fluid"></a></div>
						
					


					
						
							<div class="form-group col-md-8 offset-md-4">
							</div>
						</div>
						<div class="row">
					
						<div class="col-md-8">
							<div id="id_box"></div>
							<button type="submit" class="btn btn-danger btn-lg mr-1 mb-1"  name="faturared" value="true"  <?php if($uyeRow["fatura_durum"]==2){ echo "disabled"; }?>><?php if($uyeRow["fatura_durum"]==2){ echo "Fatura Onaylandı"; }else{ echo "Fatura Red Et";} ?></button>
							<button type="submit" class="btn btn-primary btn-lg mr-1 mb-1"  name="faturaonay" value="true"   <?php if($uyeRow["fatura_durum"]==2){ echo "disabled"; }?>><?php if($uyeRow["fatura_durum"]==2){ echo "Fatura Onaylandı"; }else{ echo "Fatura Onayla";} ?></button>

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
						window.location.href = "<?php echo ADMIN_URL.'index.php?sayfa=komisyon_fatura_list'; ?>"
					});
					return false;
				}else if(data=="basarili"){
					sweetAlert({
								title	: "Başarılı",
								text 	: "Fatura Yüklendi!",
								type	: "success"
					},
					function(){
						window.location.href = "<?php echo ADMIN_URL.'index.php?sayfa=komisyon_fatura_list'; ?>"
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