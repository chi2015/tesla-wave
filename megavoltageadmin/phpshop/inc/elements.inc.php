<?php

/**
 * Элемент последние отзывы
 * @author PHPShop Software
 * @version 1.0
 * @package PHPShopElements
 */
class PHPShopGbookElement extends PHPShopElements {
    /**
     * @var bool  показывать только на главной
     */
    var $disp_only_index=false;
    /**
     * @var Int Кол-во отзывов
     */
    var $limit=3;

    /**
     * Конструктор
     */
    function PHPShopGbookElement() {

        // Отладка
        $this->debug=false;

        // Имя Бд
        $this->objBase=$GLOBALS['SysValue']['base']['table_name7'];
        parent::PHPShopElements();
    }

    /**
     * Вывод последних отзывов
     * @return string
     */
    function index() {
        global $PHPShopModules;
        $dis=null;

        // Выполнение только на главной странице
        if($this->disp_only_index) {
            if($this->PHPShopNav->index()) $view=true;
            else $view=false;
        }
        else $view=true;

        if($view) {
            $data = $this->PHPShopOrm->select(array('*'),array('enabled'=>"='1'"),array('order'=>'id DESC'),array("limit"=>$this->limit));
            if(is_array($data))
                foreach($data as $row) {

                    // Ссылка на автора
                    if(!empty($row['mail']))  $d_mail=PHPShopText::a('mailto:'.$row[mail],PHPShopText::b($row['name']),$row['name']);
                    else  $d_mail=PHPShopText::b($row['name']);

                    // Определяем переменые
                    $this->set('gbookData',PHPShopDate::dataV($row['date'],false));
                    $this->set('gbookName',$row['name']);
                    $this->set('gbookTema',$row['title']);
                    $this->set('gbookMail',$d_mail);
                    $this->set('gbookOtsiv',$row['question']);
                    $this->set('gbookOtvet',$row['answer']);
                    $this->set('gbookId',$row['id']);

                    // Перехват модуля
                    $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                    // Подключаем шаблон
                    $dis.=$this->parseTemplate($this->getValue('templates.main_gbook_forma'));
                }

            $dis.=PHPShopText::div(PHPShopText::a('/gbook/',__('Читать все отзывы')),'left','padding:20');
            $this->set('leftMenuName',__('Отзывы'));
            $this->set('leftMenuContent',$dis);

            return $this->parseTemplate($this->getValue('templates.left_menu'));
        }
    }
}


/**
 * Элемент текстовые блоки
 * @author PHPShop Software
 * @version 1.0
 * @package PHPShopElements
 */
class PHPShopTextElement extends PHPShopElements {

    /**
     * Конструктор
     */
    function PHPShopTextElement() {

        // Отладка
        $this->debug=false;

        // Имя БД
        $this->objBase=$GLOBALS['SysValue']['base']['table_name14'];
        parent::PHPShopElements();
    }


    /**
     * Вывод левых текстовых блоков для навигации
     * @return string
     */
    function leftMenu() {
        global  $PHPShopModules;
        $dis=null;
        $PHPShopOrm = &new PHPShopOrm($this->objBase);
        $data = $PHPShopOrm->select(array('*'),array("flag"=>"='1'",'element'=>"='0'"),array('order'=>'num'),array("limit"=>20));
        if(is_array($data))
            foreach($data as $row) {

                if(empty($row['dir'])) {
                    // Определяем переменые
                    $this->set('leftMenuName',$row['name']);
                    $this->set('leftMenuContent',Parser($row['content']));

                    // Перехват модуля
                    $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                    $dis.=$this->parseTemplate($this->getValue('templates.left_menu'));
                }
                else {
                    $dirs= explode(",",$row['dir']);
                    foreach($dirs as $dir)
                        if($dir==$_SERVER['REQUEST_URI']) {
                            $this->set('leftMenuName',$row['name']);
                            $this->set('leftMenuContent',Parser($row['content']));

                            // Перехват модуля
                            $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                            // Подключаем шаблон
                            $dis.=$this->parseTemplate($this->getValue('templates.left_menu'));
                        }
                }
            }
        return $dis;
    }

    /**
     * Вывод правых текстовых блоков для навигации
     * @return string
     */
    function rightMenu() {
        global $PHPShopModules;
        $dis='';
        $PHPShopOrm = &new PHPShopOrm($this->objBase);
        $data = $PHPShopOrm->select(array('*'),array("flag"=>"='1'",'element'=>"='1'"),array('order'=>'num'),array("limit"=>20));
        if(is_array($data))
            foreach($data as $row) {

                if(empty($row['dir'])) {

                    // Определяем переменые
                    $this->set('leftMenuName',$row['name']);
                    $this->set('leftMenuContent',Parser($row['content']));

                    // Перехват модуля
                    $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                    $dis.=$this->parseTemplate($this->getValue('templates.right_menu'));
                }
                else {
                    $dirs= explode(",",$row['dir']);
                    foreach($dirs as $dir)
                        if($dir==$_SERVER['REQUEST_URI']) {
                            $this->set('leftMenuName',$row['name']);
                            $this->set('leftMenuContent',Parser($row['content']));

                            // Перехват модуля
                            $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                            // Подключаем шаблон
                            $dis.=$this->parseTemplate($this->getValue('templates.right_menu'));
                        }
                }
            }
        return $dis;
    }


    /**
     * Вывод горизонтального меню
     * @return string
     */
    function topMenu() {
        global $PHPShopModules;

        $dis='';
        $objBase=$GLOBALS['SysValue']['base']['table_name11'];
        $PHPShopOrm = &new PHPShopOrm($objBase);
        $data = $PHPShopOrm->select(array('*'),array("category"=>"=1000","enabled"=>"!='0'"),array('order'=>'num'),array("limit"=>20));
        if(is_array($data))
            foreach($data as $row) {

                // Определяем переменые
                $this->set('topMenuName',$row['name']);
                $this->set('topMenuLink',$row['link']);

                // Перехват модуля
                $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                $dis.=$this->parseTemplate($this->getValue('templates.top_menu'));

            }
        return $dis;
    }
}

/**
 * Элемент cмена шаблонов
 * @author PHPShop Software
 * @version 1.0
 * @package PHPShopElements
 */
class PHPShopSkinElement extends PHPShopElements {

    /**
     * Конструктор
     */
    function PHPShopSkinElement() {
        parent::PHPShopElements();
    }

    /**
     * Вывод смены шаблонов
     * @return string
     */
    function index() {
        $dis=$name='';
        if($this->PHPShopSystem->getValue('skin_choice')) {
            $dir=$this->getValue('dir.templates').chr(47);
            if (is_dir($dir)) {
                if (@$dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {

                        if($_SESSION['skin'] == $file)
                            $sel="selected";
                        else $sel="";

                        if($file!="." and $file!=".." and $file!="index.html")
                            @$name.= "<option value=\"$file\" $sel>Шаблон $file</option>";
                    }
                    closedir($dh);
                }
            }


            // Определяем переменые
            $forma="<div style=\"padding:10px\"><form name=SkinForm method=post><select name=\"skin\" onchange=\"ChangeSkin()\">".$name."</select></form></div>";
            $this->set('leftMenuContent',$forma);
            $this->set('leftMenuName',"Сменить дизайн");

            // Подключаем шаблон
            $dis=$this->parseTemplate($this->getValue('templates.left_menu'));
        }
        return $dis;
    }
}

/**
 * Элемент последние новости
 * @author PHPShop Software
 * @version 1.0
 * @package PHPShopElements
 */
class PHPShopNewsElement extends PHPShopElements {
    /**
     * @var bool  показывать только на главной
     */
    var $disp_only_index=false;
    /**
     * @var Int Кол-во новостей
     */
    var $limit=3;

    /**
     * Конструктор
     */
    function PHPShopNewsElement() {

        // Отладка
        $this->debug=false;

        // Имя Бд
        $this->objBase=$GLOBALS['SysValue']['base']['table_name8'];
        parent::PHPShopElements();
    }

    /**
     * Вывод последних новостей
     * @return string
     */
    function index() {
        global $PHPShopModules;
        $dis='';

        // Выполнение только на главной странице
        if($this->disp_only_index) {
            if($this->PHPShopNav->index()) $view=true;
            else $view=false;
        }
        else $view=true;

        if($view) {
            $data = $this->PHPShopOrm->select(array('*'),false,array('order'=>'id DESC'),array("limit"=>$this->limit));
            if(is_array($data))
                foreach($data as $row) {

                    // Определяем переменые
                    $this->set('newsId',$row['id']);
                    $this->set('newsZag',$row['title']);
                    $this->set('newsData',$row['date']);
                    $this->set('newsKratko',$row['description']);

                    // Перехват модуля
                    $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

                    // Подключаем шаблон
                    $dis.=$this->parseTemplate($this->getValue('templates.news_main_mini'));
                }
            return $dis;
        }
    }
}

/**
 * Элемент Форма опросов
 * @author PHPShop Software
 * @version 1.1
 * @package PHPShopElements
 */
class PHPShopOprosElement extends PHPShopElements {

    /**
     * Конструктор
     */
    function PHPShopOprosElement() {
        $this->debug=false;
        parent::PHPShopElements();
    }

    /**
     * Вывод формы голосования
     * @return string
     */
    function oprosDisp() {

        // Выборка данных
        $PHPShopOrm = &new PHPShopOrm($this->getValue('base.table_name21'));
        $PHPShopOrm->debug=$this->debug;
        $dataArray=$PHPShopOrm->select(array('*'),array('flag'=>"='1'"),array('order'=>'id DESC'),array('limit'=>10));
        $content='';
        if(is_array($dataArray))
            foreach($dataArray as $row) {

                if(empty($row['dir'])) {
                    // Определяем переменные
                    $this->set('oprosName',$row['name']);
                    $this->set('oprosContent',$this->getOprosValue($row['id'],"FORMA"));

                    // Подключаем шаблон
                    $content.= $this->parseTemplate($this->getValue('templates.opros_list'));
                }
                else {

                    // Если через запятую укзано
                    if(strpos($row['dir'], ",")) $dirs = explode(",",$row['dir']);
                    else $dirs[] = $row['dir'];

                    foreach($dirs as $dir)
                        if($dir==$_SERVER['REQUEST_URI']) {

                            // Определяем переменные
                            $this->set('oprosName',$row['name']);
                            $this->set('oprosContent',$this->getOprosValue($row['id'],"FORMA"));

                            // Подключаем шаблон
                            $content.= $this->parseTemplate($this->getValue('templates.opros_list'));
                        }
                }
            }

        // Подключаем шаблон
        return $content;
    }

    /**
     * Вывод ответов
     * @param int $n ИД опроса
     * @param string $flag [FORMA|RESULT] опция места вывода (форма опроса или результат опросов)
     * @return string
     */
    function getOprosValue($n,$flag) {
        $dis='';
        $PHPShopOrm = &new PHPShopOrm($this->getValue('base.table_name20'));
        $PHPShopOrm->comment='getOprosValue';
        $PHPShopOrm->debug=$this->debug;
        $this->dataArray=$PHPShopOrm->select(array('*'),array('category'=>'='.$n),array('order'=>'num'),array('limit'=>100));
        if(is_array($this->dataArray))
            foreach($this->dataArray as $row) {

                if($row['total'] > 0) $total=$row['total'];
                else $total="--";

                // Определяем переменые
                $this->set('valueName',$row['name']);
                $this->set('valueId',$row['id']);


                // Подключаем шаблон
                if($flag=="FORMA")
                    $dis.=$this->parseTemplate($this->getValue('templates.opros_forma'));
                elseif($flag=="RESULT") {
                    $sum=$this->getSumValue($row['category']);
                    $pr=@number_format(($total*100)/$sum,"1",".","");

                    // Определяем переменые
                    $this->set('valueSum',$total);
                    $this->set('valueProc',$pr);
                    $this->set('valueWidth',$pr*3+1);

                    $dis.=$this->parseTemplate($this->getValue('templates.opros_page_forma'));
                }
            }
        return $dis;
    }

    /**
     * Сумма значений
     * @param int $n ИД опроса
     * @return int
     */
    function getSumValue($n) {
        $objBase=$this->getValue('base.table_name20');
        $PHPShopOrm = &new PHPShopOrm($objBase);
        $result=$PHPShopOrm->query("select SUM(total) as sum from ".$objBase." where category=".$n);
        $row = mysql_fetch_array($result);
        return $row['sum'];
    }
}


/**
 * Элемент баннер
 * @author PHPShop Software
 * @version 1.1
 * @package PHPShopElements
 */
class PHPShopBannerElement extends PHPShopElements {

    /**
     * Конструктор
     */
    function PHPShopBannerElement() {

        // Отладка
        $this->debug=false;

        // Имя Бд
        $this->objBase=$GLOBALS['SysValue']['base']['table_name15'];
        parent::PHPShopElements();
    }

    /**
     * Вывод баннера
     * @return string
     */
    function index() {

        $this->row = $this->PHPShopOrm->select(array('*'),array("enabled"=>"='1'"),array('order'=>'RAND()'),array("limit"=>1));
        if(is_array($this->row)) {

            // Определяем переменые
            $this->set('banerContent',Parser($this->row['content']));
            $this->set('banerTitle',$this->row['name']);

            // Сообщение администратору о конце показов
            if($this->row['count_all']>$this->row['limit_all']) $this->mail();

            // Обновляем данные показа
            $this->update();

            // Подключаем шаблон
            $dis=$this->parseTemplate($this->getValue('templates.banner_list_forma'));
        }
        return $dis;

    }

    /**
     * Вывод баннера по ИД
     * @param int $id ИД баннера
     * @return string
     */
    function banner($id) {

        if(PHPShopSecurity::true_num($id)) {

            $this->row = $this->PHPShopOrm->select(array('*'),array("id"=>"=".$id),false,array("limit"=>1));
            if(is_array($this->row)) {

                // Определяем переменные
                $this->set('banerContent',Parser($this->row['content']));
                $this->set('banerTitle',$this->row['name']);

                // Сообщение администратору о конце показов
                if($this->row['count_all']>$this->row['limit_all']) $this->mail();

                // Обновляем данные показа
                $this->update();

                // Подключаем шаблон
                $dis=$this->parseTemplate($this->getValue('templates.banner_list_forma'));
            }
            return $dis;
        }

    }

    /**
     * Обновление счетчика показа
     */
    function update() {

        if($this->row['date'] != date("d.m.y")) $count_today=0;
        else $count_today=$this->row['count_today']+1;


        $count_all=$this->row['count_all']+1;
        $this->PHPShopOrm->update(array('count_all'=>$count_all,'count_today'=>$count_today,'date'=>date("d.m.y")),
                array('id'=>"=".$this->row['id']),$prefix='');
    }


    /**
     * Уведомление о лимите показа
     */
    function mail() {
        $this->PHPShopOrm->update(array('flag'=>'0'),array('id'=>"=".$this->row['id']),$prefix='');

        // Подключаем библиотеку отправки почты
        PHPShopObj::loadClass("mail");
        $zag="Закончились показы у банера ".$this->row['name']."";

        $message="
Закончились показы у банера ".$this->row['name'].".
Для редактирования состояния баннерной сети перейдите в панель
администрирования  http://".$_SERVER['SERVER_NAME']."/phpshop/admpanel/

Характеристики баннера
---------------------------------------------------------

Название: ".$this->row['name']."
Лимит: ".$this->row['limit_all']."
Дата отключения: ".date("d.m.y")."
---------------------------------------------------------


http://".$_SERVER['SERVER_NAME'];
        $PHPShopMail = &new PHPShopMail($this->PHPShopSystem->getParam('adminmail2'),
                "robot@".str_replace("www", '', $_SERVER['SERVER_NAME']),$zag,$message);
    }
}


/**
 * Элемент Облако тегов
 * @author PHPShop Software
 * @version 1.1
 * @package PHPShopElements
 */
class PHPShopCloudElement extends PHPShopElements {
    /**
     * @var Int Лимит страниц для анализа
     */
    var $page_limit=100;
    /**
     * @var int Лимит слов для вывода
     */
    var $word_limit=30;

    /*
     * Конструктор
    */
    function PHPShopCloudElement() {

        // Отладка
        $this->debug=false;

        // Имя Бд
        $this->objBase=$GLOBALS['SysValue']['base']['table_name11'];

        parent::PHPShopElements();

        // Цвет текста облака
        if($this->PHPShopSystem->getSerilizeParam('admoption.cloud_color')=="")
            $this->color="0x518EAD";
        else $this->color="0x".$this->PHPShopSystem->getSerilizeParam('admoption.cloud_color');
    }

    /**
     * Вывод облака тегов
     * @return string
     */
    function index() {
        $disp='';

        $data = $this->PHPShopOrm->select(array('keywords','link'),array('enabled'=>"='1'",'keywords'=>" !=''",'category'=>'!=2000'),array('order'=>'RAND()'),array("limit"=>$this->page_limit));
        if(is_array($data))
            foreach($data as $row) {

                $explode=explode(", ",$row['keywords']);
                foreach($explode as $ev)
                    if(!empty($ev)) {
                        $ArrayWords[]=$ev;
                        $ArrayLinks[$ev]=$row['link'];
                    }

            }
        if(is_array($ArrayWords))
            foreach($ArrayWords as $k=>$v) {
                $count=array_keys($ArrayWords,$v);
                $CloudCount[$v]['size']=count($count);
            }

        // Урезаем слова для наглядности
        $i=0;
        if(is_array($CloudCount))
            foreach($CloudCount as $k=>$v) {
                if($i<$this->word_limit) $CloudCountLimit[$k]=$v;
                $i++;
            }

        if(is_array($CloudCountLimit))
            foreach($CloudCountLimit as $key=>$val)
                $disp.="<a href='/page/".$ArrayLinks[$key].".html' style='font-size:12pt;'>$key</a>";

        $disp='
<div id="wpcumuluscontent">Загрузка флеш...</div><script type="text/javascript">
var dd=new Date();
 var so = new SWFObject("/tagcloud/tagcloud.swf?rnd="+dd.getTime(), "tagcloudflash", "180", "180", "9", "'.$this->color.'");
so.addParam("wmode", "transparent");
so.addParam("allowScriptAccess", "always");
so.addVariable("tcolor", "'.$this->color.'");
so.addVariable("tspeed", "150");
so.addVariable("distr", "true");
so.addVariable("mode", "tags");
so.addVariable("tagcloud", "<tags>'.$disp.'</tags>");
so.write("wpcumuluscontent");</script>
';

        // Чистим
        $disp = str_replace('\n','',$disp);
        $disp = str_replace(chr(13),'',$disp);
        $disp = str_replace(chr(10),'',$disp);

        // Определяем переменные
        $this->set('leftMenuName',"Облако тегов");
        $this->set('leftMenuContent',$disp);

        // Подключаем шаблон
        $dis=$this->parseTemplate($this->getValue('templates.left_menu'));

        return $dis;
    }
}
?>