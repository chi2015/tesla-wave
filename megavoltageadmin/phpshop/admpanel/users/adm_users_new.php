<?
$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

// Определяем пользователей
$AdmUsers=array(
        "0"=>"Администратор",
        "1"=>"Оператор базы",
        "3"=>"Промоутер");

PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

// Редактор GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="Создание Нового Администратора";


// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name19']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// Заполняем выбор
function setSelectChek($n) {
    global $AdmUsers;
    foreach($AdmUsers as $key=>$val) {
        if($n==$key) $s="selected"; else $s="";
        $select[]=array($val,$key,$s);
        $i++;
    }
    return $select;
}


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;


    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="500, 410";


// Графический заголовок окна
    $PHPShopGUI->setHeader("Создание Нового Администратора","Укажите данные для записи в базу.",$PHPShopGUI->dir."img/i_account_properties_med[1].gif");

    $Select1=setSelectChek($status);

// Содержание закладки 1
    $Tab1=$PHPShopGUI->setField("E-mail:",$PHPShopGUI->setInput("text","mail_new",$mail,"none",250).$PHPShopGUI->setRadio("enabled_new",1,"Показывать","checked","left").$PHPShopGUI->setRadio("enabled_new",0,"Скрыть",false),"left").
            $PHPShopGUI->setField("Статус:",$PHPShopGUI->setSelect("status_new",$Select1,150,1)."<br>","left",5).
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("Авторизация:",
            $PHPShopGUI->setText("Login: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;").$PHPShopGUI->setInput("text","login_new",$login,"none",150).
            $PHPShopGUI->setText("Password: ").$PHPShopGUI->setInput("password","password_new","","none",150),"none",5);


// Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,200));

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
    global $PHPShopOrm;

    $_POST['password_new']=base64_encode($_POST['password_new']);

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



