<?

$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("admgui");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

// Редактор GUI
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="Редактирование Новости";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name8']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

// Выборка
    $data = $PHPShopOrm->select(array('*'),array('id'=>'='.$_GET['id']));
    extract($data);

    $MyStyle=$_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";
    $PHPShopGUI->addJSFiles('../java/popup_lib.js','../java/dateselector.js');
    $PHPShopGUI->addCSSFiles('../skins/'.$_SESSION['theme'].'/dateselector.css');


// Графический заголовок окна
    $PHPShopGUI->setHeader("Редактирование Новости","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_balance_med[1].gif");

// Редактор 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('description_new') ;
    $oFCKeditor->Height = '230';
    $oFCKeditor->Config['EditorAreaCSS'] = $MyStyle;
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= $description;
    $oFCKeditor->Mod='textareas';

// Содержание закладки 1
    $Tab1=$PHPShopGUI->setField("Дата:",
            $PHPShopGUI->setInput("text","date_new",$date,"left",70).
            $PHPShopGUI->setCalendar('date_new'),"left").
            $PHPShopGUI->setField("Заголовок:",$PHPShopGUI->setInput("text","title_new",$title,"left",450),"none",5);

    $Tab1.=$PHPShopGUI->setField("Анонс:",$oFCKeditor->AddGUI());


// Редактор 2
    $oFCKeditor = new Editor('content_new') ;
    $oFCKeditor->Height = '320';
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Config['EditorAreaCSS'] = $MyStyle;
    $oFCKeditor->Value		= $content;
    $oFCKeditor->Mod='textareas';

// Содержание закладки 2
    $Tab2=$oFCKeditor->AddGUI();

// Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,350),array("Подробно",$Tab2,350));

    // Запрос модуля на закладку
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data));


// Вывод кнопок сохранить и выход в футер
    $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("button","","Отмена","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("button","delID","Удалить","right",70,"return onDelete('".__('Вы действительно хотите удалить?')."')","but","actionDelete").
            $PHPShopGUI->setInput("submit","editID","Сохранить","right",70,"","but","actionUpdate").
            $PHPShopGUI->setInput("submit","saveID","Применить","right",80,"","but","actionSave");

   // Футер
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// Функция сохранения
function actionSave() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopModules;

    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name8']);
    $action = $PHPShopOrm->update($_POST,array('id'=>'='.$_POST['newsID']));
    $PHPShopOrm->clean();

    $_GET['id']=$_POST['newsID'];
    $PHPShopGUI->setAction($_GET['id'],'actionStart','none');
}

// Функция обновления
function actionUpdate() {
    global $PHPShopOrm,$PHPShopModules;

    // Перехват модуля
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));

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



