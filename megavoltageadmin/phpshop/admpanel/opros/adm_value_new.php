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
$PHPShopGUI->title="Создание Вопроса для Опроса";
$PHPShopGUI->reload="parent";

// SQL
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name20']);


function actionStart(){
global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath;

$PHPShopGUI->dir="../";
$PHPShopGUI->size="500,400";


// Графический заголовок окна
$PHPShopGUI->setHeader("Создание Варианта Ответа","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_website_statistics_med[1].gif");

$Select1=setSelectChek($_GET['categoryID']);

// Содержание закладки 1
$Tab1=
$PHPShopGUI->setField("Ответ:",$PHPShopGUI->setTextarea("name_new",$name,"left",'97%','30px'),"none").
$PHPShopGUI->setField("Категория:",$PHPShopGUI->setSelect("category_new",$Select1,400,1),"none").
$PHPShopGUI->setField("Голоса:",$PHPShopGUI->setInput("text","total_new",$total,"none",200),"left").
$PHPShopGUI->setField("Сортировка:",$PHPShopGUI->setInput("text","num_new",$num,"none",200),"none");


// Вывод формы закладки
$PHPShopGUI->setTab(array("Основное",$Tab1,220));

// Вывод кнопок сохранить и выход в футер
$ContentFooter=
$PHPShopGUI->setInput("button","","Отмена","right",70,"return onCancel();","but").
$PHPShopGUI->setInput("reset","","Сбросить","right",70,"","but").
$PHPShopGUI->setInput("submit","editID","ОК","right",70,"","but","actionInsert");

// Футер
$PHPShopGUI->setFooter($ContentFooter);
return true;
}


// Заполняем выбор вывод каталогов в выборе
function setSelectChek($n){
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name21']);
$data = $PHPShopOrm->select(array('name','id'),false,false,array("limit"=>"100"));
foreach($data as $row){
extract($row);
if($n==$id) $s="selected"; else $s="";
$select[]=array($name,$id,$s);
}
return $select;
}


// Функция записи
function actionInsert(){
global $PHPShopOrm;
$action = $PHPShopOrm->insert($_POST);
return $action;
}


if($UserChek->statusPHPSHOP < 2){

// Вывод формы при старте
$PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// Обработка событий 
$PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>
