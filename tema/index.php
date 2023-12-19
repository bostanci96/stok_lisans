<?php if($_SESSION["uye_rutbe"]==0){go(URL."admin/index.php");die();} ?>
<?php if($_SESSION["uye_rutbe"]==88888){go(URL."cron/istek_list.php");die();} ?>
<?php 
if(empty($_SESSION["login"])){
require_once('../admin/host/a.php');
go(URL."login/");die();
}
        if(isset($_SESSION["uye_id"])){
            $id = $_SESSION["uye_id"];
            $uyeControl = $db->prepare("SELECT * FROM uyeler WHERE uye_id=:id");
            $uyeControl->execute(array("id"=>$id));
            if($uyeControl->rowCount()){
                $uyeRow = $uyeControl->fetch(PDO::FETCH_ASSOC);
            }else{
               go(URL.'login/');   
            }
        }else{
          go(URL.'login/');
        }
?>
<!DOCTYPE html>
<html class="loading <?php if($uyeRow["tema_mod"]==2){ ?>dark-layout<?php } ?>" lang="tr" data-textdirection="ltr">
    <head>
        <title><?php echo $ayar['site_title']; ?></title>
        <?php include_once("inc/head.php"); ?>
     
    </head>
    <body class="horizontal-layout horizontal-menu  navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col=""  >
        <!-- BEGIN: Header-->
        <nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center" data-nav="brand-center">
            <?php include_once("inc/nav.php"); ?>
        </nav>
        <!-- END: Header-->
        <!-- BEGIN: Main Menu-->
        <?php include_once("inc/menuler.php"); ?>
        <!-- END: Main Menu-->
        <!-- BEGIN: Content-->
        <div class="app-content content " style="/*background-attachment: fixed;background-image: url(<?php echo URL; ?>images/arkaplan.jpg); background-repeat: no-repeat; background-size: cover;*/">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper container-xxl p-0">
              <?php
                    if (isset($par[0])){
                        $sayfa = @$par[0];
                            $file = "sayfa/".$sayfa.".php";
                            if ($file){
                                require_once ($file);
                            }else{
                                require_once ("sayfa/default.php");
                            }
                    }else{
                        
                            require_once ("sayfa/default.php");
                    }
            ?>

            </div>
        </div>
        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>
        <!-- BEGIN: Footer-->
        <?php include_once("inc/footer.php");?>
        <!-- END: Footer-->
        <?php include_once("inc/sc.php");?>
    </body>
</html>