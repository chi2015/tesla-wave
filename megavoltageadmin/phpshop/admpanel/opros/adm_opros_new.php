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
$PHPShopGUI->title="Создание Нового Опроса";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name21']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopModules ;

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";


// Графический заголовок окна
    $PHPShopGUI->setHeader("Создание Нового Опроса","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_website_statistics_med[1].gif");



// Содержание закладки 1
    $Tab1=
            $PHPShopGUI->setField("Заголовок:",$PHPShopGUI->setTextarea("name_new",$name,"left",'97%','30px'),"none").
            $PHPShopGUI->setField("Привязка:",$PHPShopGUI->setInput("text","dir_new",$dir,"none",400).$PHPShopGUI->setText("* Пример: page/,news/. Можно указать несколько адресов через запятую. "),"left",5).
            $PHPShopGUI->setField("Вывод:",$PHPShopGUI->setRadio("flag_new",1,"Показать","checked","none").$PHPShopGUI->setLine().
            $PHPShopGUI->setRadio("flag_new",0,'<font color="#FF0000">Скрыть</font>',@$fl2),"none");


// Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,350));

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
    global $PHPShopOrm,$PHPShopModules;

    // Перехват модуля
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));
    
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