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
$PHPShopGUI->title="Редактирование Вопроса для Опроса";
$PHPShopGUI->reload="parent";

// SQL
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name20']);


function actionStart(){
global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm;

// Выборка
$data = $PHPShopOrm->select(array('*'),array('id'=>'='.$_GET['id']));
extract($data);

$PHPShopGUI->dir="../";
$PHPShopGUI->size="500,400";


// Графический заголовок окна
$PHPShopGUI->setHeader("Редактирование Ответа '".$name."'","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_website_statistics_med[1].gif");


$Select1=setSelectChek($category);

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
$PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
$PHPShopGUI->setInput("button","","Отмена","right",70,"return onCancel();","but").
$PHPShopGUI->setInput("submit","delID","Удалить","right",70,"","but","actionDelete").
$PHPShopGUI->setInput("submit","editID","ОК","right",70,"","but","actionUpdate");

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


// Функция удаления
function actionDelete(){
global $PHPShopOrm;
$action = $PHPShopOrm->delete(array('id'=>'='.$_POST['newsID']));
return $action;
}

// Функция обновления
function actionUpdate(){
global $PHPShopOrm;
$action = $PHPShopOrm->update($_POST,array('id'=>'='.$_POST['newsID']));
return $action;
}


if($UserChek->statusPHPSHOP < 2){

// Вывод формы при старте
$PHPShopGUI->setAction($_GET['id'],'actionStart','none');

// Обработка событий 
$PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>
