<?

// Список каталогов софта
class PHPShopSoftElement extends PHPShopElements {

    function PHPShopSoftElement() {
        $this->debug=false;
        $this->objBase=$GLOBALS['SysValue']['base']['table_name'];
        parent::PHPShopElements();
    }

    
    function mainMenuPage() {
        $dis='';
        $i=0;

        $data = $this->PHPShopOrm->select(array('*'),array('parent_to'=>'=0'),array('order'=>'num'),array("limit"=>100));
        if(is_array($data))
            foreach($data as $row) {

                // Определяем переменные
                $this->set('catalogId',$row['id']);
                $this->set('catalogI',$i);
                $this->set('catalogTemplates',$this->getValue('dir.templates').chr(47).$this->PHPShopSystem->getValue('skin').chr(47));

                // Глобальный массив для навигации хлебных крошек
                $this->LoadItems['CatalogPage'][$row['id']]['name']=$row['name'];
                $this->LoadItems['CatalogPage'][$row['id']]['parent_to']=$row['parent_to'];
                if(!empty($row['content'])) $this->LoadItems['CatalogPage'][$row['id']]['content_enabled']=true;
                else $this->LoadItems['CatalogPage'][$row['id']]['content_enabled']=false;

                // Если есть страницы
                if($this->chek($row['id'])) {

                    $this->set('catalogPodcatalog',$this->page($row['id']));
                    $this->set('catalogName',$row['name']);

                    $dis.=$this->parseTemplate($this->getValue('templates.catalog_forma'));

                }  else {
                    $this->set('catalogPodcatalog',$this->podcatalog($row['id']));
                    $this->set('catalogName',$row['name']);
                    $dis.=ParseTemplateReturn($this->PHPShopModules->getParam("templates.soft.soft_menu_forma"),true);
                }

                $i++;
            }

        return $dis;
    }


    // Есть ли подкаталоги
    function chek($id) {
        $PHPShopOrm = &new PHPShopOrm($this->getValue('base.table_name'));
        $PHPShopOrm->debug=$this->debug;
        $num=$PHPShopOrm->select(array('id'),array('parent_to'=>"=$id"),false,array('limit'=>1));
        if(empty($num['id'])) return true;
    }

    // Вывод подкаталогов
    function page($n) {
        $dis='';
        $n=PHPShopSecurity::TotalClean($n,1);
        $PHPShopOrm = &new PHPShopOrm($this->getValue('base.table_name11'));
        $PHPShopOrm->debug=$this->debug;
        $data = $PHPShopOrm->select(array('*'),array('category'=>'='.$n,'enabled'=>"='1'"),array('order'=>'num'),array("limit"=>100));
        if(is_array($data))
            foreach($data as $row) {

                $id=$row['id'];
                $name=$row['name'];
                $link=$row['link'];
                $category=$row['category'];

                // Определяем переменные
                $this->set('catalogId',$n);
                $this->set('catalogUid',$row['id']);
                $this->set('catalogLink',$row['link']);
                $this->set('catalogName',$row['name']);

                // Подключаем шаблон
                $dis.=ParseTemplateReturn($this->PHPShopModules->getParam("templates.soft.soft_podcatalog_forma"),true);
            }
        return $dis;
    }


    // Вывод подкаталогов
    function podcatalog($n) {
        $dis='';
        $i=0;
        $n=PHPShopSecurity::TotalClean($n,1);
        $PHPShopOrm = &new PHPShopOrm($this->getValue('base.table_name'));
        $data = $PHPShopOrm->select(array('*'),array('parent_to'=>'='.$n),array('order'=>'num'),array("limit"=>100));
        if(is_array($data))
            foreach($data as $row) {


                // Определяем переменные
                $this->set('catalogId',$n);
                $this->set('catalogI',$i);
                $this->set('catalogLink','CID_'.$row['id']);
                $this->set('catalogName',$row['name']);
                $this->set('catalogTemplates',$this->getValue('dir.templates').chr(47).$this->PHPShopSystem->getValue('skin').chr(47));
                $this->set('catalogName',$row['name']);
                $i++;


                // Глобальный массив для навигации хлебных крошек
                $this->LoadItems['CatalogPage'][$row['id']]['name']=$row['name'];
                $this->LoadItems['CatalogPage'][$row['id']]['parent_to']=$row['parent_to'];
                if(!empty($row['content'])) $this->LoadItems['CatalogPage'][$row['id']]['content_enabled']=true;
                else $this->LoadItems['CatalogPage'][$row['id']]['content_enabled']=false;

                // Подключаем шаблон
                $dis.=ParseTemplateReturn($this->PHPShopModules->getParam("templates.soft.soft_podcatalog_forma"),true);

            }
        return $dis;
    }
}

// Меняем вывод навигации каталога
$PHPShopSoftElement = &new PHPShopSoftElement();
$PHPShopSoftElement->init('mainMenuPage');

?>