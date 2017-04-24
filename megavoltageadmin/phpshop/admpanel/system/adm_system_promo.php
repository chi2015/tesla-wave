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
$PHPShopGUI->title="Настройка заголовков";
$PHPShopGUI->reload="none";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name3']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

// Выборка
    $data = $PHPShopOrm->select();
    extract($data);

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="500,600";


// Графический заголовок окна
    $PHPShopGUI->setHeader("Настройка заголовков","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_website_statistics_med[1].gif");


// Содержание закладки 1
    $Tab1=
            $PHPShopGUI->setField("Title:",$PHPShopGUI->setTextarea("title_new",$title,"left",'97%','100'),"none").
            $PHPShopGUI->setField("Keywords:",$PHPShopGUI->setTextarea("keywords_new",$keywords,"left",'97%','70'),"none").
            $PHPShopGUI->setField("Description:",$PHPShopGUI->setTextarea("meta_new",$meta,"left",'97%','100'),"none");


// Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,430));

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


