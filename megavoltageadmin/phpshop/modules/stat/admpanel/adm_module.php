<?
$_classPath="../../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("security");
PHPShopObj::loadClass("orm");


$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
include($_classPath."admpanel/enter_to_admin.php");


// Настройки модуля
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");


// Редактор
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.stat.stat_system"));


// Функция обновления
function actionUpdate(){
global $PHPShopOrm;
$action = $PHPShopOrm->update($_POST);
return $action;
}


function actionStart(){
global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm;


$PHPShopGUI->dir=$_classPath."admpanel/";
$PHPShopGUI->title="Настройка модуля";
$PHPShopGUI->size="500,450";


// Выборка
$data = $PHPShopOrm->select();
@extract($data);


// Графический заголовок окна
$PHPShopGUI->setHeader("Настройка модуля 'Visitors Counter'","Настройки параметров",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");

// Создаем объекты для формы
$ContentField1=$PHPShopGUI->setInputText(false,"color_new",$color,$size=70,'RGB');

$Tab2=$PHPShopGUI->setPay($serial);
// Вывод формы закладки
$PHPShopGUI->setTab(array("О Модуле",$Tab2,270));

// Вывод кнопок сохранить и выход в футер
$ContentFooter=
$PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
$PHPShopGUI->setInput("button","","Отмена","right",70,"return onCancel();","but").
$PHPShopGUI->setInput("submit","editID","ОК","right",70,"","but","actionUpdate");

$PHPShopGUI->setFooter($ContentFooter);
return true;
}

if($UserChek->statusPHPSHOP < 2){

// Вывод формы при старте
$PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// Обработка событий 
$PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();

?>


