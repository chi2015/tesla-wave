<?

$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

// Редактор GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="Редактирование Банера";
$PHPShopSystem = new PHPShopSystem();

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name15']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// Стартовый вид
function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

// Выборка
    $data = $PHPShopOrm->select(array('*'),array('id'=>'='.$_GET['id']));
    extract($data);


    if($enabled==1) $fl="checked";
    else $fl2="checked";


    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";


// Графический заголовок окна
    $PHPShopGUI->setHeader("Редактирование Банера","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_select_another_account_med[1].gif");


    $Field1=$PHPShopGUI->setInput("text","name_new",$name,"none",300).
            $PHPShopGUI->setRadio("enabled_new",1,"Показывать банер",@$fl).
            $PHPShopGUI->setRadio("enabled_new",0,"Скрыть банер",@$f2);

    $Field2=$PHPShopGUI->setInput("text","limit_all_new",$limit_all,"none",100).
            $PHPShopGUI->setCheckbox("clean_st",1,"Обнулить счетчики ".@$count_today." / ".$count_all,false);

// Содержание закладки 1
    $Tab1=$PHPShopGUI->setField("Наименование:",$Field1,"none").
            $PHPShopGUI->setField("Лимит показов:",$Field2,"none");

// Редактор 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('content_new') ;
    $oFCKeditor->Height = '300';
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= $content ;
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];

// Содержание закладки 2
    $Tab2=$oFCKeditor->AddGUI();

// Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,350),array("Содержание",$Tab2,350));

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

    if($_POST['clean_st']==1) {
        $_POST['count_all_new']='0';
        $_POST['count_today_new']='0';
    }

    $action = $PHPShopOrm->update($_POST,array('id'=>'='.$_POST['newsID']));
    return $action;
}



if(($UserChek->statusPHPSHOP < 2) or ($UserChek->statusPHPSHOP == 3)) {

// Вывод формы при старте
    $PHPShopGUI->setAction($_GET['id'],'actionStart','none');

// Обработка событий 
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>
