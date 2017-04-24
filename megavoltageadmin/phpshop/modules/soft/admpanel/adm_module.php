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
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.soft.soft_system"));


// Функция обновления
function actionUpdate(){
global $PHPShopOrm;

// Копируем базу товаров
$_FILES['file']['ext']=PHPShopSecurity::getExt($_FILES['file']['name']);
if($_FILES['file']['ext']=="csv"){
if(move_uploaded_file($_FILES['file']['tmp_name'], "../../../../UserFiles/File/".$_FILES['file']['name']))
$_POST['filedir_new']=$_FILES['file']['name'];
}
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
$PHPShopGUI->setHeader("Настройка модуля 'SoftCatalog'","Настройки файловой базы",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");

// Создаем объекты для формы
$ContentField1=
$PHPShopGUI->setInput("file","file","","left",350).
$PHPShopGUI->setInput("button","button1","Скачать","left",70,"window.open('../../../../UserFiles/File/".$filedir."')").
$PHPShopGUI->setInput("hidden","order_db_old","").
'Скачать пример <a href="../install/base.csv" title="Скачать пример" target="_blank">файла-базы</a>.'
;

// Содержание закладки 1
$Tab1=$PHPShopGUI->setField("База файлов: <strong>/UserFiles/File/".$filedir."</strong>",$ContentField1);

// Содержание закладки 2
$Info='Для работы модуля требуется создать текстовый файл с ячейками инфрмации, содержащие данные по файлам.

Пример содержания файла:

ID;Размер;Путь;
page1;1000;/UserFiles/File/f1.rar;
page2;1500;/UserFiles/File/f2.rar;
page3;2000;/UserFiles/File/f3.rar;

где:
page1 - ссылка страницы, для кторой будет выведена карточка для загрузки
1000 - размер в байтах файла
/UserFiles/File/f1.rar - путь до файла. Файлы нужно предварительно загрузить в папку /UserFiles/File
';
$Tab2=$PHPShopGUI->setTextarea("1",$Info,"left",450,200);
$Tab3=$PHPShopGUI->setPay($serial);
// Вывод формы закладки
$PHPShopGUI->setTab(array("Основное",$Tab1,270),array("Описание",$Tab2,270),array("О Модуле",$Tab3,270));

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


