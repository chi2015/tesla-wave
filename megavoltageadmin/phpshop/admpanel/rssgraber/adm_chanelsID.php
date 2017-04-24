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
$PHPShopGUI->title="Редактирование Канала RSS";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name24']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// Заполняем выбор
function setSelectChek($n) {
    $i=1;
    while($i<=10) {
        if($n==$i) $s="selected"; else $s="";
        $select[]=array($i,$i,$s);
        $i++;
    }
    return $select;
}



function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

    // Выборка
    $data = $PHPShopOrm->select(array('*'),array('id'=>'='.$_GET['id']));
    extract($data);
   
    if($enabled) $fl="checked"; else $fl2="checked";

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="400,480";
    $PHPShopGUI->includeJava='<SCRIPT language="JavaScript" src="../java/popup_lib.js"></SCRIPT>
    <SCRIPT language="JavaScript" src="../java/dateselector.js"></SCRIPT>';
    $PHPShopGUI->includeCss='<LINK href="../skins/'.$_SESSION['theme'].'/dateselector.css" type=text/css rel=stylesheet>';

    // Графический заголовок окна
    $PHPShopGUI->setHeader("Редактирование Канала RSS","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_subscription_med[1].gif");



    $Select1=setSelectChek($day_num);


    $DateField='<div style="padding:10"><span name=txtLang id=txtLang>с&nbsp;&nbsp;</span>
<input type="text" name="start_date_new" id="start_date_new"  maxlength="10" value="'.date( "d-m-Y",$start_date).'" style="width:80px;">
<IMG onclick="popUpCalendar(this, product_edit.start_date_new, \'dd-mm-yyyy\');" height=16 hspace=3 src="../icon/date.gif" width=16 border=0 align="absmiddle">
<span name=txtLang id=txtLang>по</span>
<input type="text" name="end_date_new"  maxlength="10" value="'.date( "d-m-Y",$end_date).'" style="width:80px;" >
<IMG onclick="popUpCalendar(this, product_edit.end_date_new, \'dd-mm-yyyy\');" height=16 hspace=3 src="../icon/date.gif" width=16 border=0 align="absmiddle"></div>';

    // Содержание закладки 1
    $Tab1=$PHPShopGUI->setField("Адрес ленты:",$PHPShopGUI->setInput("text","link_new",$link,"none",300),"none").
            $PHPShopGUI->setField("Запись в день:",$PHPShopGUI->setSelect("day_num_new",$Select1,50),"left",5).
            $PHPShopGUI->setField("Кол-во записей за раз:",$PHPShopGUI->setInput("text","news_num_new",$news_num,"left",100),"none",5).
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("Срок работы (dd-mm-yyyy):",$DateField,"none").
            $PHPShopGUI->setField("Статус:",$PHPShopGUI->setRadio("enabled_new",1,"Включено",@$fl,"left").$PHPShopGUI->setRadio("enabled_new",0,'Отключено',@$fl2),"none");



    // Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,300));

    // Запрос модуля на закладку
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data));

    // Вывод кнопок сохранить и выход в футер
    $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("button","","Отмена","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("button","delID","Удалить","right",70,"return onDelete('".__('Вы действительно хотите удалить?')."')","but","actionDelete").
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

    $_POST['link_new'] = mysql_escape_string($_POST['link_new'])  ;
    $_POST['news_num_new'] = intval($_POST['news_num_new']);
    if ($_POST['news_num_new'] == "" || $_POST['news_num_new'] == 0) $_POST['news_num_new']=1;
    $tm_date = explode("-",ereg_replace("[^0-9\-]","",$_POST['start_date_new']));
    $_POST['start_date_new'] = strtotime("$tm_date[2]-$tm_date[1]-$tm_date[0]");
    $tm_date = explode("-",ereg_replace("[^0-9\-]","",$_POST['end_date_new']));
    $_POST['end_date_new'] = strtotime("$tm_date[2]-$tm_date[1]-$tm_date[0]");
    $action = $PHPShopOrm->update($_POST,array('id'=>'='.$_POST['newsID']));
    return $action;
}

// Функция удаления
function actionDelete() {
    global $PHPShopOrm,$PHPShopModules;

    // Перехват модуля
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));
    
    $action = $PHPShopOrm->delete(array('id'=>'='.$_POST['newsID']));
    return $action;
}

if($UserChek->statusPHPSHOP < 2) {

    // Вывод формы при старте
    $PHPShopGUI->setAction($_GET['id'],'actionStart','none');

    // Обработка событий
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>