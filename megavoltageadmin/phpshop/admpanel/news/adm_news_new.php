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
$PHPShopGUI->title="Новая Новость";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name8']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// Стартовый вид
function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopModules;
    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";


// Графический заголовок окна
    $PHPShopGUI->setHeader("Создание Новости","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_balance_med[1].gif");

// Редактор 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('description_new') ;
    $oFCKeditor->Height = '230';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= '' ;
    $oFCKeditor->Mod='textareas';

// Содержание закладки 1
    $Tab1=$PHPShopGUI->setField("Дата:",$PHPShopGUI->setInput("text","date_new",date("d-m-Y"),"left",70),"left").
            $PHPShopGUI->setField("Заголовок:",$PHPShopGUI->setInput("text","title_new",'',"left",450),"none",5);

    $Tab1.=$PHPShopGUI->setField("Анонс:",$oFCKeditor->AddGUI());

// Редактор 2
    $oFCKeditor = new Editor('content_new') ;
    $oFCKeditor->Height = '320';
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->Value		= '' ;
    $oFCKeditor->Mod='textareas';

// Содержание закладки 2
    $Tab2=$oFCKeditor->AddGUI();

// Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,350),array("Подробно",$Tab2,350));

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

    $action = $PHPShopOrm->insert($_POST);
    return $action;
}


if($UserChek->statusPHPSHOP < 2) {

// Вывод формы при старте
    $PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// Обработка событий 
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>



