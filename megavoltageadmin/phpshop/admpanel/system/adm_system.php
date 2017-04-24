<?php

$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

// Редактор GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="Системные Настройки";
$PHPShopGUI->reload="top";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name3']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// Выбор иконки шаблона
function GetSkinsIcon($skin) {
    global $SysValue;
    $dir="../../templates";
    $filename=$dir.'/'.$skin.'/icon/icon.gif';
    if (file_exists($filename))
        $disp='<img src="'.$filename.'" alt="'.$skin.'" width="150" height="120" border="1" id="icon">';
    else $disp='<img src="../img/icon_non.gif" alt="Изображение не доступно" width="150" height="120" border="1" id="icon">';
    return '<div align="center" style="padding:5px">'.$disp.'</div>';
}


// Выбор иконки адм. темы
function GetThemesIcon($skin) {
    global $SysValue;
    $dir="../skins/";
    $filename=$dir.'/'.$skin.'/icon.gif';
    if (file_exists($filename))
        $disp='<img src="'.$filename.'" alt="'.$skin.'" width="150" height="120" border="1" id="theme">';
    else $disp='<img src="../img/icon_non.gif" alt="Изображение не доступно" width="150" height="120" border="1" id="icon">';
    return '<div align="center" style="padding:5px">'.$disp.'</div>';
}

// Выбор шаблона
function GetSkins($skin) {
    global $SysValue,$PHPShopGUI;
    $dir="../../templates";
    if (is_dir($dir)) {
        if (@$dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {

                if($skin == $file)
                    $sel="selected";
                else $sel="";

                if($file!="." and $file!=".." and $file!="index.html")
                    $value[]=array($file,$file,$sel);
            }
            closedir($dh);
        }
    }

    return $PHPShopGUI->setSelect('skin_new',$value,270,'left',false,$onchange="GetSkinIcon(this.value)",200,5);
}

// Выбор языка
function GetLang($skin) {
    global $SysValue,$PHPShopGUI;
    $dir="../locale/";

    if (is_dir($dir)) {
        if (@$dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {


                if($file!="." and $file!=".." and $file!="index.html") {
                    $name = substr($file,0,strlen($file)-4);

                    if($skin == $name)
                        $sel="selected";
                    else $sel="";

                    $value[]=array(ucfirst($name),$name ,$sel);
                }
            }
            closedir($dh);
        }
    }

    return $PHPShopGUI->setSelect('lang_new',$value,100,'left');
}

// Выбор адм. темы
function getThemes($skin) {
    global $SysValue,$PHPShopGUI;
    $dir="../skins/";
    if (is_dir($dir)) {
        if (@$dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {

                if($skin == $file)
                    $sel="selected";
                else $sel="";

                if($file!="." and $file!=".." and $file!="index.html")
                    $value[]=array($file,$file,$sel);
            }
            closedir($dh);
        }
    }

    return $PHPShopGUI->setSelect('theme_new',$value,270,'left',false,$onchange="GetThemeIcon(this.value)",200,5);
}

function Editors($editor) {
    global $SysValue,$PHPShopGUI;
    $dir="../editors/";
    if (is_dir($dir)) {
        if (@$dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {

                if($editor == $file)
                    $sel="selected";
                else $sel="";

                if($file!="." and $file!=".." and $file!="index.html")
                    $value[]=array($file,$file,$sel);
            }
            closedir($dh);
        }
    }

    return $PHPShopGUI->setSelect('editor_new',$value,100);
}

function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

    // Тип окна
    if($_COOKIE['winOpenType'] == 'default')
        $dot=".";
    else $dot=false;

    // Выборка
    $data = $PHPShopOrm->select();
    extract($data);

    $option=unserialize($admoption);
    if($option['image_save_source']==1) $image_save_source="checked";
    if($option['rss_graber_enabled']==1) $rss_graber_enabled="checked";
    if($option['cart_enabled']==1) $cart_enabled="checked";
    if($option['editor_enabled']==1) $editor_enabled="checked";


    if(!empty($spec_num)) $fl="checked";
    if(!empty($option['image_save_source'])) $image_save_source="checked";

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="510,450";


    // Графический заголовок окна
    $PHPShopGUI->setHeader("Системные Настройки","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");


    // Содержание закладки 1
    $Tab1=GetSkins($skin);
    $Tab1.=$PHPShopGUI->setField('Скриншот',GetSkinsIcon($skin),$float="none",$margin_left=5);
    $Tab1.=$PHPShopGUI->setCheckbox('skin_choice_new',1,'Выбор шаблона на сайте',$skin_choice);
    $Tab1.=$PHPShopGUI->setLine();
    $Tab1.=$PHPShopGUI->setImage('../img/icon-filetype-jpg.gif',16,16).$PHPShopGUI->setLink('http://phpshopcms.ru/doc/skins.html','База бесплатных шаблонов');

    // Содержание закладки 2
    $Tab2=$PHPShopGUI->setInputText('Название: ','name_new',$name);
    $Tab2.=$PHPShopGUI->setInputText('Компания: ','company_new',$company);
    $Tab2.=$PHPShopGUI->setInputText('Телефоны: ','tel_new',$tel);
    $Tab2.=$PHPShopGUI->setInputText('E-mail: ','admin_mail_new',$admin_mail);
    $Tab2.=$PHPShopGUI->setCheckbox('rss_graber_enabled_new',1,' Копирование RSS каналов в новости',$rss_graber_enabled);
    $Tab2.=$PHPShopGUI->setInputText('Пагинация: ','num_row_new',$num_row,20,' (позиций на странице)' ,'left').
            $PHPShopGUI->setInputText('&nbsp;&nbsp;&nbsp;Цвет текста облака тегов: ','cloud_color_new',$option['cloud_color'],50,'RGB');


    // Содержание закладки 3
    $Tab3=getThemes($option['theme']);
    $Tab3.=$PHPShopGUI->setField('Скриншот',GetThemesIcon($option['theme']),$float="none",$margin_left=5);
    $Tab3.=$PHPShopGUI->setField('Язык',GetLang($option['lang']),$float="none",$margin_left=5);

    // Содержание закладки 4
    $Tab4=$PHPShopGUI->setInputText('Макс. ширина оригинала: ','img_w',$option['img_w'],30,'px','left');
    $Tab4.=$PHPShopGUI->setInputText('Макс. ширина тумбнейла: ','img_tw',$option['img_tw'],30,'px');
    $Tab4.=$PHPShopGUI->setInputText('Макс. высота оригинала: ','img_h',$option['img_h'],30,'px','left');
    $Tab4.=$PHPShopGUI->setInputText('Макс. высота тумбнейла: ','img_th',$option['img_th'],30,'px');
    $Tab4.=$PHPShopGUI->setInputText('Качество оригинала: ','width_podrobno',$option['width_podrobno'],30,'%','left');
    $Tab4.=$PHPShopGUI->setInputText('Качество тумбнейла: ','width_kratko',$option['width_kratko'],30,'%');
    $Tab4.=$PHPShopGUI->setCheckbox('image_save_source_new',1,'Сохранять исходное изображение при ресайзинге',$option['image_save_source']);
    $Tab4.=$PHPShopGUI->setField('Настройка параметров защиты изображений от копирования',$PHPShopGUI->setButton('Настроить Watermark','../icon/photo_album.gif','50%',false,"none","miniWin('".$dot."./system/adm_system_watermark.php',500,640);return false;"));


    // Кодировка XML
    switch($option['xmlencode']) {
        case('ISO-8859-1'): $xmlencode_chek_2='selected';
            break;
        case('UTF-8'): $xmlencode_chek_3='selected';
            break;
        default: $xmlencode_chek_1='selected';

    }

    $xmlencode[]=array('Авто','',$xmlencode_chek_1);
    $xmlencode[]=array('ISO-8859-1','ISO-8859-1',$xmlencode_chek_2);
    $xmlencode[]=array('UTF-8','UTF-8',$xmlencode_chek_3);

    $Tab5=$PHPShopGUI->setSelect('xmlencode_new',$xmlencode,100,false,'XML кодировка');
    $Tab5.=$PHPShopGUI->setLine();
    $Tab5.=__('Редактор кода: ').Editors($option['editor']);
    $Tab5.=$PHPShopGUI->setLine();

    // Тип окна
    switch($option['wintype']) {
        case('highslide'): $wintype_highslide='selected';
            break;
        default: $wintype_default='selected';

    }

    $wintype[]=array('Highslide','highslide',$wintype_highslide);
    $wintype[]=array('Default','default',$wintype_default);

    $Tab5.=$PHPShopGUI->setSelect('wintype_new',$wintype,100,false,'Оконный менеджер');


    // Вывод формы закладки
    $PHPShopGUI->setTab(array("Дизайн",$Tab1,250),array("Опции",$Tab2,250),array("Галерея",$Tab4,250),array("Темы",$Tab3,250),array("Управление",$Tab5,250));

    // Запрос модуля на закладку
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data));

    // Вывод кнопок сохранить и выход в футер
    $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("button","","Отмена","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("submit","editID","ОК","right",70,"","but","actionUpdate");

    // Футер
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}



// Функция обновления
function actionUpdate() {
    global $PHPShopOrm,$PHPShopModules;

    // Перехват модуля
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));

    extract($_POST);

    // Admoption
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name3']);
    $data = $PHPShopOrm->select(array('admoption'));
    $option = unserialize($data['admoption']);

    $option["image_save_source"]=$image_save_source_new;
    $option["rss_graber_enabled"]=$rss_graber_enabled_new;
    $option["img_w"]=$img_w;
    $option["img_h"]=$img_h;
    $option["img_tw"]=$img_tw;
    $option["img_th"]=$img_th;
    $option["width_podrobno"]=$width_podrobno;
    $option["width_kratko"]=$width_kratko;
    $option["theme"]=$theme_new;
    $option["cloud_color"]=$cloud_color_new;
    $option["editor"]=$editor_new;
    $option["xmlencode"]=$xmlencode_new;
    $option["wintype"]=$wintype_new;
    $option["lang"]=$lang_new;
    $_POST['admoption_new']=serialize($option);

    if(empty($_POST['image_save_source_new'])) $_POST['image_save_source_new']=0;
    if(empty($_POST['skin_choice_new'])) $_POST['skin_choice_new']=0;

    $_SESSION['skin'] = $_POST['skin_new'];
    $action = $PHPShopOrm->update($_POST,array('id'=>'='.$_POST['newsID']));
    return $action;
}


if($UserChek->statusPHPSHOP < 2) {

// Вывод формы при старте
    $PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// Обработка событий
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>


