<?

$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("security");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

$PHPShopSystem = new PHPShopSystem();


// Редактор GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="Создание Новой Страницы";
$PHPShopGUI->reload = "right";


// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name11']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");



function Disp_cat_pod($category)// вывод каталогов в выборе подкаталогов
{
    global $SysValue;
    $sql="select name from ".$SysValue['base']['table_name']." where id='$category'";
    $result=mysql_query($sql);
    $row = mysql_fetch_array($result);
    @$name=$row['name'];
    return @$name." -> ";
}

function Disp_cat($category)// вывод каталогов в выборе
{
    global $SysValue;
    $sql="select name,parent_to from ".$SysValue['base']['table_name']." where id=$category";
    $result=mysql_query($sql);
    @$row = mysql_fetch_array($result);
    @$num = mysql_num_rows($result);
    if($num>0) {
        $name=$row['name'];
        $parent_to=$row['parent_to'];
        $dis=Disp_cat_pod($parent_to).$name;
    }
    elseif($category == 1000) $dis="Главное меню сайта";
    elseif($category == 2000) $dis="Начальная страница";
    return @$dis;
}


function GetLastId()// вывод номера
{
    $sql="select id from ".$GLOBALS['SysValue']['base']['table_name11']." order by id desc limit 0, 1";
    $result=mysql_query($sql);
    $row = mysql_fetch_array($result);
    return $row['id'];
}


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopModules;

         // Тип окна
    if($_COOKIE['winOpenType'] == 'default')
        $dot=".";
    else $dot=false;

    if(!PHPShopSecurity::true_num($_GET['catalogID'])) $_GET['catalogID']=null;

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="650,630";

    // Графический заголовок окна
    $PHPShopGUI->setHeader("Создание Новой Страницы","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_website_tab[1].gif");

    // Редактор 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('content_new') ;
    $oFCKeditor->Height = '420';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= '' ;


    // Содержание закладки 1
    $Tab1=$PHPShopGUI->setField("Каталог:",$PHPShopGUI->setInput("text","parent_name",Disp_cat($_GET['catalogID']),"left",450).
            $PHPShopGUI->setInput("hidden","category_new",$_GET['catalogID'],"left",450).
            $PHPShopGUI->setButton("Выбрать","../icon/folder_edit.gif","100px","Выбрать","none","miniWin('".$dot."./catalog/adm_cat.php?category=".$category."',300,400);return false;"),"none").
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("Заголовок:",$PHPShopGUI->setInput("text","name_new",$name,"left",400),"left").
            $PHPShopGUI->setField("Позиция вывода:",$PHPShopGUI->setInput("text","num_new",$num,"left",50),"none",5).
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("Ссылка:",$PHPShopGUI->setInput("text","link_new","page".GetLastId(),"left",400),"left");
           

    $SelectValue[]=array('Вывод в каталоге',1,1);
    $SelectValue[]=array('Заблокировать',0,'');
    $SelectValue[]=array('Внутренняя страница',2,'');

    $Tab1.= $PHPShopGUI->setField("Вывод:",$PHPShopGUI->setSelect("enabled_new",$SelectValue,150),"none",5);

    // Содержание закладки 2
    $Tab2=$oFCKeditor->AddGUI();

    // Содержание закладки 3
    $Tab3=$PHPShopGUI->setField("Title: ",$PHPShopGUI->setInputText(false,"title_new",$title,'98%',false,"none",false,'100px'),"none");
    $Tab3.=$PHPShopGUI->setField("Description: ",$PHPShopGUI->setInputText(false,"description_new",$description,'98%',false,"none",false,'100px'),"none");
    $Tab3.=$PHPShopGUI->setField("Keywords: ",$PHPShopGUI->setInputText(false,"keywords_new",$keywords,'98%',false,"none",false,'100px'),"none");


    // Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,450),array("Содержание",$Tab2,450),array("Заголовки",$Tab3,450));

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
    
    $_POST['date_new']=date('U');
    $action = $PHPShopOrm->insert($_POST);
    return $action;
}

if($UserChek->statusPHPSHOP < 2) {

    // Вывод формы при старте
    $PHPShopGUI->setLoader($_POST['editID'],'actionStart');

    // Обработка событий
    $PHPShopGUI->getAction();
}
else $UserChek->BadUserFormaWindow();
?>



