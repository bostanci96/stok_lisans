<?php

if ($par[1]) {
$paket_id = $par[1];
$ayarControl = $db->query("SELECT * FROM alt_paketler WHERE id='$paket_id'");
if($ayarControl->rowCount()){
$ayarRow = $ayarControl->fetch(PDO::FETCH_ASSOC);
}else{
go(URL);
}
}else{
go(URL);
}
?>
<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0"><?php echo $ayarRow["paket_adi"] ?> Satın Al</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=URL?>"><?php echo $bloklar["site_link_map_home"]; ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $ayarRow["paket_adi"] ?> Satın Al
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
                    <h4 class="card-title"><?php echo $ayarRow["paket_adi"] ?> Satın Al</h4>
                </div>
                <div class="card-body">
                   <div style="width: 100%;margin: 0 auto;display: table;margin-top: 50px;">
    <?php
        


        
    $merchant_id    = $ayar["merchant_id"];
    $merchant_key   = $ayar["merchant_key"];
    $merchant_salt  = $ayar["merchant_salt"];
    $email = $uyeRow["uye_eposta"];
    $payment_amount =  $ayarRow["paket_tutar"] * 100;
    $rand = uniqid();
    $merchant_oid = md5($rand.time().date("Y-m-d H:i:s"));
    $user_name = $uyeRow["uye_ad"]." ".$uyeRow["uye_soyad"];
    $user_address = "Türkiye";
    $user_phone = $uyeRow["uye_telefon"];

    $insert = $db->prepare("INSERT INTO paytr_bildirim SET bildirim_token=?,kisi_id=?,paket_id=?,tutar=?,alt_paket=?");
    $okinsert = $insert->execute(array($merchant_oid,$uyeRow["uye_id"],$ayarRow["id"],$ayarRow["paket_tutar"],2));

    $merchant_ok_url = URL."/index.php?durum=ok";
    $merchant_fail_url = URL."/index.php?durum=no";
    $user_basket = base64_encode(json_encode(array(
        array($ayarRow["paket_adi"]." Satın Alım", $ayarRow["paket_tutar"], 1),
    )));

    if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        $ip = $_SERVER["REMOTE_ADDR"];
    }
    $user_ip=$ip;
    $timeout_limit = "30";

    $debug_on = 1;

    $test_mode = 0;

    $no_installment = 1;
    $max_installment = 12;

    $currency = "TL";
    
    $hash_str = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
    $paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
    $post_vals=array(
            'merchant_id'=>$merchant_id,
            'user_ip'=>$user_ip,
            'merchant_oid'=>$merchant_oid,
            'email'=>$email,
            'payment_amount'=>$payment_amount,
            'paytr_token'=>$paytr_token,
            'user_basket'=>$user_basket,
            'debug_on'=>$debug_on,
            'no_installment'=>$no_installment,
            'max_installment'=>$max_installment,
            'user_name'=>$user_name,
            'user_address'=>$user_address,
            'user_phone'=>$user_phone,
            'merchant_ok_url'=>$merchant_ok_url,
            'merchant_fail_url'=>$merchant_fail_url,
            'timeout_limit'=>$timeout_limit,
            'currency'=>$currency,
            'test_mode'=>$test_mode
        );
    
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1) ;
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
     
    $result = @curl_exec($ch);

    if(curl_errno($ch))
        die("PAYTR IFRAME connection error. err:".curl_error($ch));

    curl_close($ch);
    
    $result=json_decode($result,1);
    $kontrolet = "";
    if($result['status']=='success'){
        $token=$result['token'];
   
    $kontrolet = true;
     }else{
        echo "PAYTR IFRAME failed. reason:".$result['reason'];
    $kontrolet = false;
    }
    ?>

    <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
        <?php if($kontrolet == true){ ?>
    <iframe src="https://www.paytr.com/odeme/guvenli/<?php echo $token;?>" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
        <?php } ?>

    <script>iFrameResize({},'#paytriframe');</script>

</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Horizontal Wizard -->
</div>
