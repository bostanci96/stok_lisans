<div class="horizontal-menu-wrapper">
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-light navbar-shadow menu-border container-xl" role="navigation" data-menu="menu-wrapper" data-menu-type="floating-nav">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row ">
                <li class="nav-item me-auto">
                    <a class="navbar-brand" href="<?php echo URL; ?>">
                        <span class="brand-logo">
                            <img src="<?php echo URL;?>images/<?php echo $ayar["logo"];?>" class="img-fluid" alt="<?php echo $ayar[$lehce."site_title"];?>">
                        </span>
                    </a>
                </li>
                <li class="nav-item nav-toggle">
                    <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i></a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <!-- Horizontal menu content-->
        <div class="navbar-container main-menu-content" data-menu="menu-container">
            
            <ul class="nav navbar-nav justify-content-center" id="main-menu-navigation" data-menu="menu-navigation">
                
                <li class="<?php classActive('',@$par[0]);?>" data-menu="">
                    <a class="dropdown-item d-flex align-items-center" href="<?php echo URL;?>">
                        <i data-feather="home"></i>
                        <span data-i18n="<?php echo $bloklar["homebutton"]?>"><?php echo $bloklar["homebutton"]?></span>
                    </a>
                </li>
                <li class="dropdown nav-item <?php classActive('envato_elements',@$par[0]);?>" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <i data-feather='server'></i>
                        <span data-i18n="Servisler">Servisler</span>
                    </a>
                    <ul class="dropdown-menu" data-bs-popper="none">
                        <li class="<?php classActive('envato_elements',@$par[0]);?>" data-menu="">
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo URL;?>envato_elements/">
                                <i data-feather='layers'></i>
                                <span data-i18n="Envato Elements">Envato Elements</span>
                            </a>
                        </li>
                        <li class="<?php classActive('freepik',@$par[0]);?>" data-menu="">
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo URL;?>freepik/">
                                <i data-feather='layers'></i>
                                <span data-i18n="Freepik">Freepik</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="<?php classActive('magaza',@$par[0]);?>" data-menu="">
                    <a class="dropdown-item d-flex align-items-center" href="<?php echo URL;?>magaza/">
                        <i data-feather='shopping-cart'></i>
                        <span data-i18n="Mağaza">Mağaza</span>
                    </a>
                </li>
                <li class="<?php classActive('hediye_kupon',@$par[0]);?>" data-menu="">
                    <a class="dropdown-item d-flex align-items-center" href="<?php echo URL;?>hediye_kupon/">
                        <i data-feather='gift'></i>
                        <span data-i18n="Hediye Kupon Kullan">Hediye Kupon Kullan</span>
                    </a>
                </li>
                
                <?php
                $url="https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
                $menuQuery = $db->query("SELECT * FROM menuler WHERE menu_durum=1 and menu_ust=0 and menu_type=0  ORDER BY menu_sira ASC LIMIT 6");
                if($menuQuery->rowCount()){
                $numb  = 0;
                foreach($menuQuery as $menuRow){
                if ($url==$menuRow[$lehce."menu_href"]) {$linkactive="active";}else{$linkactive=null;}
                $menuId = $menuRow["menu_id"];
                $altMenuQuery = $db->query("SELECT * FROM menuler WHERE menu_ust='$menuId' and menu_durum=1 and menu_type=0 ORDER BY menu_sira ASC LIMIT 6");
                $sayac=0;
                if($altMenuQuery->rowCount()){
                $sayac++;
                echo '<li id="'.$sayac.'" class="dropdown nav-item '.$linkactive.'"  data-menu="dropdown">';
                    echo '<a href="javascript:void(0);" class="dropdown-toggle nav-link d-flex align-items-center"  data-bs-toggle="dropdown"><i data-feather="menu"></i><span data-i18n="'.$menuRow[$lehce."menu_baslik"].'">'.$menuRow[$lehce."menu_baslik"].'</span></a>';
                    echo '<ul  class="dropdown-menu" data-bs-popper="none">';
                        $saya=0;
                        foreach($altMenuQuery as $altMenuRow){
                        $saya++;
                        $menuIdone = $altMenuRow["menu_id"];
                        echo '<li id="'.$saya.'" class="'.$linkactive.'">';
                            echo '<a class="dropdown-item d-flex align-items-center"  href="'.$altMenuRow[$lehce."menu_href"].'"><i data-feather="menu"></i><span data-i18n="'.$altMenuRow[$lehce."menu_baslik"].'">'.$altMenuRow[$lehce."menu_baslik"].'</span></a>';
                        echo '</li>';
                        }
                    echo '</ul>';
                echo '</li>';
                }else{
                echo '<li id="'.$numb.'" class="'.$linkactive.'"><a class="dropdown-item d-flex align-items-center"   href="'.$menuRow[$lehce."menu_href"].'"><i data-feather="menu"></i><span data-i18n="'.$menuRow[$lehce."menu_baslik"].'">'.$menuRow[$lehce."menu_baslik"].'</span></a></li>';
                }
                $numb++;
                }
                }
                ?>
                
                <li class="dropdown nav-item <?php classActive('blog',@$par[0]);?>" data-menu="dropdown">
                    <a class="dropdown-toggle nav-link d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <i data-feather='book'></i>
                        <span data-i18n="<?php echo $bloklar["sitemap_blog"]?>"><?php echo $bloklar["sitemap_blog"]?></span>
                    </a>
                    <ul class="dropdown-menu" data-bs-popper="none">
                        <?php
                        $haberQuery = $db->query("SELECT * FROM haberkategori WHERE kategori_durum=1 ORDER BY kategori_id");
                        if( $haberQuery->rowCount() ){
                        foreach($haberQuery as $haberRow){
                        $haberUrl = URL."blog/".$haberRow["kategori_id"]."_".$haberRow["kategori_url"];
                        $haberUrlxyz =$haberRow["kategori_id"]."_".$haberRow["kategori_url"];
                        ?>
                        
                        
                        
                        <li data-menu="" class="<?php classActive($haberUrlxyz,@$par[1]);?>" >
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo $haberUrl; ?>" data-bs-toggle="" data-i18n="<?php echo $haberRow[$lehce."kategori_adi"];?>">
                                <i data-feather='list'></i>
                                <span data-i18n="<?php echo $haberRow[$lehce."kategori_adi"];?>"><?php echo $haberRow[$lehce."kategori_adi"];?></span>
                            </a>
                        </li>
                        <?php
                        }
                        }?>
                    </ul>
                </li>
                <li class="<?php classActive('database',@$par[0]);?>" data-menu="">
                    <a class="dropdown-item d-flex align-items-center" href="<?php echo URL;?>database/">
                        <i data-feather='database'></i>
                        <span data-i18n="<?php echo $bloklar["sitmap_database"]?>"><?php echo $bloklar["sitmap_database"]?></span>
                    </a>
                </li>
                <li class="<?php classActive('contact',@$par[0]);?>" data-menu="">
                    <a class="dropdown-item d-flex align-items-center" href="<?php echo URL;?>contact/">
                        <i data-feather='help-circle'></i>
                        <span data-i18n="<?php echo $bloklar["iletisim_title"]?>"><?php echo $bloklar["iletisim_title"]?></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>