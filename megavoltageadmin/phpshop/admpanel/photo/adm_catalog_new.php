<?

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
$PHPShopGUI->title="Создание Нового Каталога";
$PHPShopGUI->reload = "left";


// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name22']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;


    // Тип окна
    if($_COOKIE['winOpenType'] == 'default')
        $dot=".";
    else $dot=false;

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="650,630";

// Графический заголовок окна
    $PHPShopGUI->setHeader("Создание Нового Каталога","Укажите данные для записи в базу.",$PHPShopGUI->dir."img//i_filemanager_med[1].gif");

// Редактор 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('content_new') ;
    $oFCKeditor->Height = '420';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= $content ;


// Содержание закладки 1
    $Tab1=
            $PHPShopGUI->setField("Название:",$PHPShopGUI->setInput("text","name_new",'Новый каталог фото',"left",450),"none").
            $PHPShopGUI->setField("Каталог:",$PHPShopGUI->setInput("text","parent_name",'Корень',"left",450).
            $PHPShopGUI->setInput("hidden","parent_to_new",0,"left",450).
            $PHPShopGUI->setButton("Выбрать","../icon/folder_edit.gif","100px","Выбрать","none","miniWin('".$dot."./photo/adm_cat.php?category=".$parent_to."',300,400);return false;"),"none").
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField($PHPShopGUI->setCheckbox("enabled_new",1,"Показывать","checked"),$PHPShopGUI->setInputText(false,"num_new",1,30,"позиция при выводе")).
            $PHPShopGUI->setField("Привязка к странице:",$PHPShopGUI->setInputText(false,"page_new",'',550,'<br>Пример: page/,news/. Можно указать несколько адресов через запятую без пробелов.'));

// Содержание закладки 2
    $Tab2=$oFCKeditor->AddGUI();


// Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,450),array("Содержание",$Tab2,450));

    // Запрос модуля на закладку
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data));



// Вывод кнопок сохранить и выход в футер
    $ContentFooter=
            $PHPShopGUI->setInput("button","","Отмена","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("reset","","Сбросить","right",70,"","but").
            $PHPShopGUI->setInput("submit","editID","ОК","right",70,"","but","actionInsert");

// Футер
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}


// Функция записи
function actionInsert() {
    global $PHPShopOrm;
    $action = $PHPShopOrm->insert($_POST);
    return $action;
}


if($UserChek->statusPHPSHOP < 2) {

// Вывод формы при старте
     $PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// Обработка событий
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();

?>
