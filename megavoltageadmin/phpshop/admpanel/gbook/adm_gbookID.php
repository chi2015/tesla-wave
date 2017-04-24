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
$PHPShopGUI->title="Редактирование Отзыва";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name7']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

// Выборка
    $data = $PHPShopOrm->select(array('*'),array('id'=>'='.$_GET['id']));
    extract($data);

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";
    $PHPShopGUI->addJSFiles('../java/popup_lib.js','../java/dateselector.js');
    $PHPShopGUI->addCSSFiles('../skins/'.$_SESSION['theme'].'/dateselector.css');


// Графический заголовок окна
    $PHPShopGUI->setHeader("Редактирование Отзыва","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_account_properties_med[1].gif");

// Редактор 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('answer_new') ;
    $oFCKeditor->Height = '320';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= $answer ;


// Содержание закладки 1
    $Tab1=$PHPShopGUI->setField("Дата:",
            $PHPShopGUI->setInput("text","date_new",PHPShopDate::dataV($date,false),"left",70).
            $PHPShopGUI->setCalendar('date_new').
            $PHPShopGUI->setLine().
            $PHPShopGUI->setCheckbox('enabled_new','1','Вывод',$enabled)
            ,"left");


    $Tab1.=$PHPShopGUI->setField("Автор:",$PHPShopGUI->setText("Имя:&nbsp;&nbsp;","left").
            $PHPShopGUI->setInput("text","name_new",$name,"none",300).$PHPShopGUI->setText("E-mail:","left").$PHPShopGUI->setInput("text","mail_new",$mail,"none",300),"none",5).
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("Тема:",$PHPShopGUI->setTextarea("title_new",$title,"left",'97%','50px'),"none").
            $PHPShopGUI->setField("Отзыв:",$PHPShopGUI->setTextarea("question_new",$question,"left",'97%','80px'),"none");

// Содержание закладки 2
    $Tab2=$oFCKeditor->AddGUI();

// Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,350),array("Ответ",$Tab2,350));

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

// Функция отправки почты
function sendMail($name,$mail) {
    global $PHPShopSystem;

    // Подключаем библиотеку отправки почты
    PHPShopObj::loadClass("mail");

    $zag="Ваш отзыв добавлен на сайт ".$PHPShopSystem->getValue('name');
    $message="Уважаемый ".$name.",

Ваш отзыв добавлен на сайт по адресу: http://".$_SERVER['SERVER_NAME']."/gbook/

Спасибо за проявленный интерес.";
    $PHPShopMail = new PHPShopMail($PHPShopSystem->getValue('admin_mail'),$mail,$zag,$message);
}


// Функция обновления
function actionUpdate() {
    global $PHPShopOrm,$PHPShopModules;

    // Перехват модуля
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));

    $_POST['date_new'] = PHPShopDate::GetUnixTime($_POST['date_new']);
    if(empty($_POST['enabled_new'])) $_POST['enabled_new'] = 0;
    else if(!empty($_POST['mail_new'])) sendMail($_POST['name_new'],$_POST['mail_new']);

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