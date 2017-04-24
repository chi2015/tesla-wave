<?

class PHPShopSoft extends PHPShopCore {

    function PHPShopSoft() {
        global $PHPShopModules;
        $this->objBase=$GLOBALS['SysValue']['base']['table_name11'];
        $this->debug=false;
        $this->action=array("nav"=>"CID");

        // База файлов
        include($PHPShopModules->getParam("class.soft.soft_load"));
        $DB = "./UserFiles/File/".$this->getOption();
        $FileCsv = new FileCsv($DB);
        $this->FILEDB = $FileCsv->CreatBase();

        //Ко-во загрузок массив
        $this->LoadNum=$this->getLoadNum();

        parent::PHPShopCore();
    }



    function index() {

        // Данные по загрузке
        $LoadNum=&$this->LoadNum;

        $link=PHPShopSecurity::TotalClean($this->PHPShopNav->getName(),2);
        $link=str_replace("soft","",$link);

        // Выборка данных
        $row=parent::getFullInfoItem(array('*'),array('link'=>"='$link'"));

        // Прикрываем страницу от дубля
        if($row['category'] == 2000)  return $this->setError404();
        elseif(empty($row['id'])) return $this->setError404();

        // Определяем переменые
        $this->set('pageContent',Parser($row['content']));
        $this->set('pageTitle',$row['name']);
        $this->set('pageLink',$row['link']);

        if(!empty($LoadNum[$row['link']]['load_today']) and $LoadNum[$row['link']]['data']==date("d.m.y")) {
            $SysValue['other']['numLoadToday']=$LoadNum[$row['link']]['load_today'];
            $this->set('numLoadToday',$LoadNum[$row['link']]['load_today']);
        }
        else $this->set('numLoadToday',0);

        if(!empty($LoadNum[$row['link']]['load_total']))
            $this->set('numLoadTotal',$LoadNum[$row['link']]['load_total']);
        else $this->set('numLoadTotal',0);

        $this->set('fileSize',$this->FILEDB[$row['link']]['size']);


        // Мета
        if(empty($row['title'])) $title=$row['name'];
        else $title=$row['title'];
        $this->title=$title." - ".$this->PHPShopSystem->getValue("name");
        $this->description=$row['description'];
        $this->keywords=$row['keywords'];
        $this->lastmodified=$row['datas'];


        // Навигация хлебные крошки
        $this->navigation($row['category'],$row['name']);

        // Подключаем шаблон
        $this->set('pageContent',ParseTemplateReturn($this->PHPShopModules->getParam("templates.soft.soft_page_forma"),true));
        $this->parseTemplate($this->getValue('templates.page_page_list'));
    }

    function CID() {

        // ID категории
        $this->category=PHPShopSecurity::TotalClean($this->PHPShopNav->getId(),1);
        $this->PHPShopCategory = &new PHPShopCategory($this->category);
        $this->category_name=$this->PHPShopCategory->getName();

        $PHPShopOrm = &new PHPShopOrm($this->getValue('base.table_name'));
        $PHPShopOrm->debug=$this->debug;
        $row=$PHPShopOrm->select(array('id,name'),array('parent_to'=>"=".$this->category),false,array('limit'=>1));

        // Если страницы
        if(empty($row['id'])) {

            $this->ListPage();
        }
        // Если каталоги
        else {

            $this->ListCategory();
        }
    }

    // Подсчет загрузок
    function getLoadNum() {
        global $PHPShopModules;
        $PHPShopOrm = &new PHPShopOrm($PHPShopModules->getParam("base.soft.soft_load"));
        $dataArray=$PHPShopOrm->select(array('*'),false,false,array('limit'=>1000));
        if(is_array($dataArray))
            foreach($dataArray as $row) $return[$row['id']]=$row;
        return $return;
    }


    // Настройи модуля
    function getOption() {
        global $PHPShopModules;
        $PHPShopOrm = &new PHPShopOrm($PHPShopModules->getParam("base.soft.soft_system"));
        $row=$PHPShopOrm->select(array('filedir'),false,false,array('limit'=>1));
        return $row['filedir'];
    }

    function ListPage() {
        global $PHPShopModules;
        $dis='';

        // Данные по загрузке
        $LoadNum=&$this->LoadNum;

        // 404
        if(!isset($this->category_name)) return $this->setError404();

        // Выборка данных
        $this->dataArray=$this->PHPShopOrm->select(array('*'),array('category'=>'='.$this->category,'enabled'=>"='1'"),
                array('order'=>'num'),array('limit'=>100));
        if(is_array($this->dataArray))
            foreach($this->dataArray as $row) {


                // Определяем переменые
                $this->set('pageTitle',$row['name']);
                $this->set('pageContent',$row['content']);
                $this->set('pageLink',$row['link']);


                if(!empty($LoadNum[$row['link']]['load_today']) and $LoadNum[$row['link']]['data']==date("d.m.y")) {
                    $SysValue['other']['numLoadToday']=$LoadNum[$row['link']]['load_today'];
                    $this->set('numLoadToday',$LoadNum[$row['link']]['load_today']);
                }
                else $this->set('numLoadToday',0);

                if(!empty($LoadNum[$row['link']]['load_total']))
                    $this->set('numLoadTotal',$LoadNum[$row['link']]['load_total']);
                else $this->set('numLoadTotal',0);

                $this->set('fileSize',$this->FILEDB[$row['link']]['size']);

                // Подключаем шаблон
                $dis.=ParseTemplateReturn($PHPShopModules->getParam("templates.soft.soft_page_forma"),true);

            }




        $this->set('pageContent',$dis);
        $this->set('pageTitle',$this->category_name);

        // Мета
        $this->title=$this->category_name." - ".$this->PHPShopSystem->getValue("name");


        // Навигация хлебные крошки
        $this->navigation($row['category'],$this->category_name);

        // Подключаем шаблон
        $this->parseTemplate($this->getValue('templates.page_page_list'));

    }

    function ListCategory() {

        // Выборка данных
        $PHPShopOrm = &new PHPShopOrm($this->getValue('base.table_name'));
        $PHPShopOrm->debug=$this->debug;
        $dataArray=$PHPShopOrm->select(array('name','id'),array('parent_to'=>'='.$this->category),array('order'=>'num'),array('limit'=>100));
        if(is_array($dataArray))
            foreach($dataArray as $row) {
                $dis.="<li><a href=\"/soft/CID_".$row['id'].".html\" title=\"".$row['name']."\">".$row['name']."</a></li>";
            }

        $disp="<h1>".$this->category_name."</h1>";

        // Если есть описание каталога
        if(!empty($this->LoadItems['CatalogPage'][$this->category]['content_enabled']))
            $disp.=$this->PHPShopCategory->getContent();

        $disp.="<ul>$dis</ul>";


        $this->set('pageContent',$disp);
        $this->set('pageTitle',$this->category_name);

        // Мета
        $this->title=$this->category_name." - ".$this->PHPShopSystem->getValue("name");


        // Навигация хлебные крошки
        $this->navigation($this->category,$this->category_name);

        // Подключаем шаблон
        $this->parseTemplate($this->getValue('templates.page_page_list'));

    }

}

?>