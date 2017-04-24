<?php

class skin_viewer {
    var $debug=false;

    function skin_viewer() {
        global $PHPShopNav;
        $this->PHPShopNav=$PHPShopNav;

        if(empty($GLOBALS['SysValue']['base']['seourl']['seourl_system'])) {
            if($this->PHPShopNav->getPath() == 'page') {
                if($this->PHPShopNav->getNav()=='CID') {
                    $link=PHPShopSecurity::TotalClean($this->PHPShopNav->getId(),2);
                    $sql=array('name'=>'skincat','base'=>$GLOBALS['SysValue']['base']['table_name'],'where'=>array('id'=>"=$link"));
                }

                else {
                    $link=PHPShopSecurity::TotalClean($this->PHPShopNav->getName(),2);
                    $sql=array('name'=>'skin','base'=>$GLOBALS['SysValue']['base']['table_name11'],'where'=>array('link'=>"='$link'"));
                }

                $this->select($sql);
            }
            else $this->set();
        }
        // Проверка модуля Seourl
        else {
            if($this->PHPShopNav->getPath() == 'index') {
                $link=PHPShopSecurity::TotalClean($this->PHPShopNav->getName(),2);
                $sql=array('name'=>'skin','base'=>$GLOBALS['SysValue']['base']['table_name11'],'where'=>array('link'=>"='$link'"));
                $this->select($sql);

            }
            elseif($this->PHPShopNav->getPath() == 'cat') {
                $link=PHPShopSecurity::TotalClean($this->PHPShopNav->objNav['name'],2);

                $sql=array('name'=>'skincat','base'=>$GLOBALS['SysValue']['base']['table_name'],'where'=>array('seoname'=>"='$link'"));
                $this->select($sql);

            }
            else $this->set();
        }

    }

    function select($option=array()) {
        $PHPShopOrm = new PHPShopOrm($option['base']);
        $PHPShopOrm->debug=$this->debug;
        $data = $PHPShopOrm->select(array($option['name']),$option['where'],false,array('limit'=>1));
        $this->set($data[$option['name']]);
    }

    function set($skin=false) {
        global $PHPShopSystem;
        if(!empty($skin) and file_exists("phpshop/templates/".$skin."/index.html"))
            $_SESSION['skin']=$skin;
        else $_SESSION['skin']= $PHPShopSystem->getParam('skin');

        $GLOBALS['SysValue']['other']['pageCss']=$GLOBALS['SysValue']['dir']['templates'].chr(47).$_SESSION['skin'].chr(47).$GLOBALS['SysValue']['css']['default'];
    }
}

$skin_viewer = new skin_viewer;
?>