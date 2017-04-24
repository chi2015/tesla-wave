<?

$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("date");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();


PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

// Редактор GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="Создание Отзыва";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name7']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopModules;


    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";
    $PHPShopGUI->addJSFiles('../java/popup_lib.js','../java/dateselector.js');
    $PHPShopGUI->addCSSFiles('../skins/'.$_SESSION['theme'].'/dateselector.css');

// Графический заголовок окна
    $PHPShopGUI->setHeader("Создание Отзыва","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_account_properties_med[1].gif");

// Редактор 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('answer_new') ;
    $oFCKeditor->Height = '320';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= '' ;


// Содержание закладки 1
    $Tab1=$PHPShopGUI->setField("Дата:",
            $PHPShopGUI->setInput("text","date_new",PHPShopDate::dataV(false,false),"left",70).
            $PHPShopGUI->setCalendar('date_new'),"left").
            $PHPShopGUI->setField("Автор:",$PHPShopGUI->setText("Имя:&nbsp;&nbsp;","left").
            $PHPShopGUI->setInput("text","name_new",'',"none",300).$PHPShopGUI->setText("E-mail:","left").$PHPShopGUI->setInput("text","mail_new",$mail,"none",300),"none",5).
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("Тема:",$PHPShopGUI->setTextarea("title_new",'',"left",'97%','50px'),"none").
            $PHPShopGUI->setField("Отзыв:",$PHPShopGUI->setTextarea("question_new",'',"left",'97%','80px'),"none");

// Содержание закладки 2
    $Tab2=$oFCKeditor->AddGUI();

// Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,350),array("Ответ",$Tab2,350));

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
    
    $_POST['date_new'] = PHPShopDate::GetUnixTime($_POST['date_new']);
    if(!empty($_POST['question_new'])) $_POST['enabled_new'] = 1;
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



