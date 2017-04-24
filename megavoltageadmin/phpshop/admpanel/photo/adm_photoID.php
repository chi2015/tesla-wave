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
$PHPShopGUI->title="Редактирование Изображения";
$PHPShopGUI->reload = "right";


// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name23']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

function Disp_cat($id)// вывод каталогов в выборе
{
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name22']);
    $data = $PHPShopOrm->select(array('name'),array('id'=>'='.$id));
    if(is_array($data)) extract($data);
    return $name;
}


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;


    // Тип окна
    if($_COOKIE['winOpenType'] == 'default')
        $dot=".";
    else $dot=false;

    // Выборка
    $data = $PHPShopOrm->select(array('*'),array('id'=>'='.$_GET['id']));
    extract($data);
    $s_name=str_replace(".","s.",$name);

    if ($data['enabled']==1) $enabled="checked"; else $enabled="";


    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="650,630";

    // Графический заголовок окна
    $PHPShopGUI->setHeader("Редактирование Изображения","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_change_hosting_plan_med[1].gif");


    // Содержание закладки 1
    $Tab1.= $PHPShopGUI->setField("Каталог:",$PHPShopGUI->setInput("text","parent_name",Disp_cat($category),"left",450).
    $PHPShopGUI->setInput("hidden","category_new",$category,"left",450).
    $PHPShopGUI->setButton("Выбрать","../icon/folder_edit.gif",100,false,"none","miniWin('".$dot."./photo/adm_cat.php?category=".$category."',300,400);return false;"),"none");

    $Tab1.=$PHPShopGUI->setField("Оригинал:",$PHPShopGUI->setFrame('frame1',$name,'350',300),'left');
    $Tab1.=$PHPShopGUI->setField("Превью:",$PHPShopGUI->setFrame('frame2',$s_name,'220',150));
    $Tab1.=$PHPShopGUI->setField("Сортировка:",$PHPShopGUI->setSelect('num_new',$PHPShopGUI->setSelectValue($num,20),50).$PHPShopGUI->setCheckbox('enabled_new',1,'Вывод на сайте',$enabled));
    $Tab1.=$PHPShopGUI->setField("Описание:",$PHPShopGUI->setTextarea('info_new',$info,$float="none",$width=220,$height=50));

    // Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,450));

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


// Функция удаления
function actionDelete() {
    global $PHPShopOrm,$PHPShopModules;

    // Перехват модуля
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));

    $action = $PHPShopOrm->delete(array('id'=>'='.$_POST['newsID']));
    return $action;
}

// Функция обновления
function actionUpdate() {
    global $PHPShopOrm,$PHPShopModules;

    // Перехват модуля
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));
    
    if(empty($_POST['enabled_new'])) $_POST['enabled_new']=0;
    $action = $PHPShopOrm->update($_POST,array('id'=>'='.$_POST['newsID']));
    return $action;
}


if($UserChek->statusPHPSHOP < 2) {

    // Вывод формы при старте
    $PHPShopGUI->setAction($_GET['id'],'actionStart','none');

    // Обработка событий
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();

?>