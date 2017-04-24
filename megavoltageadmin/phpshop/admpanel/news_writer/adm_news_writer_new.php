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
$PHPShopGUI->title="Создание Адреса Рассылки";



function actionStart(){
global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath;

$PHPShopGUI->dir="../";
$PHPShopGUI->size="400,300";


// Графический заголовок окна
$PHPShopGUI->setHeader("Создание Адреса Рассылки","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_mail_forward_med[1].gif");


// Содержание закладки 1
$Tab1=$PHPShopGUI->setField("E-mail:",$PHPShopGUI->setInput("text","mail_new",$mail,"none",330),"none");


// Вывод формы закладки
$PHPShopGUI->setTab(array("Основное",$Tab1,120));

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
function actionInsert(){
$sql="INSERT INTO ".$GLOBALS['SysValue']['base']['table_name9']." VALUES ('','".date("d.m.y")."','".$_POST['mail_new']."')";
if(mysql_query($sql)) return true;
  else return mysql_error();
}

if($UserChek->statusPHPSHOP < 2){

// Вывод формы при старте
$PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// Обработка событий 
$PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>
