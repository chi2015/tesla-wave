<?php

// Настройка уровня оповещения отладчика
error_reporting('E_ALL & ~E_NOTICE & ~E_DEPRECATED');

$_classPath="../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("mail");
PHPShopObj::loadClass("security");
PHPShopObj::loadClass("orm");
PHPShopObj::loadClass("admgui");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopSystem = new PHPShopSystem();

$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name19']);
$PHPShopOrm->debug=false;

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// Регистрируем язык
$_SESSION['lang']=$PHPShopSystem->getSerilizeParam("admoption.lang");
PHPShopObj::loadClass("lang");

// Secure Fix
foreach($_REQUEST as $val) PHPShopSecurity::RequestSearch($val);

// Форма авторизации
class PHPShopAdminEnter extends PHPShopGUI {

    function Compile() {
        global $PHPShopSystem;
        $this->theme = $PHPShopSystem->getSerilizeParam("admoption.theme");

        // Запись файла локализации
        writeLangFile();

        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "xhtml11.dtd">
     <html>
     <head>
     <title>'.$this->title.'</title>
     <meta http-equiv="Content-Type" content="text/html; charset='.$this->charset.'">
     <link href="'.$this->dir.'skins/'.$this->theme.'/texts.css" type=text/css rel=stylesheet>'.$this->includeCss.'
         '.$this->includeJava.'</head>
<body bottommargin="0"  topmargin="0" leftmargin="0" rightmargin="0">
'.$this->_CODE='<table width="100%" height="100%">
<tr>
<td valign="middle">
<form method="post">
        <table align="center" cellpadding="0" cellspacing="1" border="0"
        style="border: 1px;border-style:outset;background: ButtonFace;" width="350">
        <tr align="center">
        <td align="left">
	 '.$this->_CODE.'
        </td>
        </tr>
        </table>
</form>
</td>
</tr>
</table>
</body>
</html>';
    }
}

// Редактор GUI
$PHPShopGUI = new PHPShopAdminEnter();
$PHPShopGUI->title=$PHPShopBase->getParam('license.product_name')." -> ".__('Авторизация');
$PHPShopGUI->reload = 'none';
$PHPShopGUI->debug_close_window = false;
$PHPShopGUI->winOpenType = 'default';


// Экшен вход
function actionEnter() {
    global $PHPShopOrm,$PHPShopGUI,$PHPShopModules,$SendMailStatus;

    $data = $PHPShopOrm->select(array('*'),array('enabled'=>"='1'"),false,array('limit'=>30));
    if(is_array($data))
        foreach($data as $row) {
            if(($row['login']==$_POST['log'])and($row['password']==base64_encode($_POST['pas']))) {

                $logPHPSHOP=$_POST['log'];
                $pasPHPSHOP=base64_encode($_POST['pas']);
                @session_start();
                $_SESSION['logPHPSHOP']=$logPHPSHOP;
                $_SESSION['pasPHPSHOP']=$pasPHPSHOP;
                $_SESSION['idPHPSHOP']=$row['id'];
                if(!empty($_POST['pas_to_cookies'])) {
                    setcookie("log", $_POST['log'], time()+60*60*24*30, "/phpshop/admpanel/", $_SERVER['SERVER_NAME'], 0);
                    setcookie("pas", $_POST['pas'], time()+60*60*24*30, "/phpshop/admpanel/", $_SERVER['SERVER_NAME'], 0);
                }

                $_id=session_id();

                $includeJava='
<script>
function WO(){
var URL = "admin.php";
var win_e='.$_POST['win_e'].'-0;
if(win_e != 1){
if(!window.open(URL,"admin'.$_id.'","toolbar=0; location=0; menubar=0; status=1; directories=0; resizable=1;")){
if(confirm("Внимание!\nВ вашем браузере "+navigator.appName+" отключены всплывающие окна.\nДля программы << PHPShop - Панель управления >>\nтребуется поддержка всплывающих окон.\n\nПродолжить работу с отключенными всплывающими окнами? "))
window.location.replace(URL);
}}
else{ window.location.replace(URL);}
}
tmr = setTimeout("WO();",100);
</script>
';
                $PHPShopGUI->includeJava = $includeJava;
            }

        }
    if(empty($_POST['pas_to_cookies'])) {
        @setcookie("log", "", (time()-1000), "/phpshop/admpanel/", $_SERVER['SERVER_NAME'], 0);
        @setcookie("pas", "", (time()-1000), "/phpshop/admpanel/", $_SERVER['SERVER_NAME'], 0);
    }

    if(PHPShopSecurity::true_param($_POST['pas_to_mail']) and PHPShopSecurity::true_login($_POST['log'])) {
        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name19']);
        $row = $PHPShopOrm->select(array('password','mail'),array('login'=>'="'.$_POST['log'].'"'),false,array('limit'=>'1'));
        if(is_array($row)) {
            $OLDpassword=$row['password'];
            $OLDmail=$row['mail'];
        }

        if(!empty($OLDmail)) {
            $content="
Доброго времени!
---------------

Уважаемый $log, вы запросили выслать на ваш адрес пароль для доступа
к панели администрирования PHPShop на сайте ".$_SERVER['SERVER_NAME']."

Ваши данные
---------------
Пользователь: $log
Пароль: ".base64_decode($OLDpassword)."
Дата: ".date("d-m-y H:s a")."
IP отправителя:".$_SERVER['REMOTE_ADDR']."
";
            $zag="Доступ к панели администрирования PHPShop CMS Free";
            new PHPShopMail($OLDmail,$OLDmail,$zag,$content);

            $SendMailStatus="
<br><br>
<table style='border: 1px;border-style:inset;'>
<tr>
	<td>
	<font color='green'>
	Ваш пароль был успешно отослан по адресу ".$OLDmail."</font>
	</td>
</tr>
</table>
";
        }
    }

    // Запрос модуля на закладку
    $PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data);

    return actionStart();
}

// Экшен вывод формы
function actionStart($SendMailStatus=false) {
    global $PHPShopGUI,$PHPShopModules;

    // Выход
    if($_GET['do']=="out") {
        $_SESSION['logPHPSHOP']=false;
        $_SESSION['pasPHPSHOP']=false;
        header("Location: /");
    }

    $PHPShopGUI->setHeader("Вход в Административную Панель","Укажите пользователя и пароль.",$PHPShopGUI->dir."img/i_users_med[1].gif");
    $leftPart=$PHPShopGUI->setLine('<p></p>');
    $leftPart.=$PHPShopGUI->setField("Пользователь:",$PHPShopGUI->setInput("text","log",$_COOKIE['log'],"none",200),"none",5);
    $leftPart.=$PHPShopGUI->setLine('<p></p>');
    $leftPart.=$PHPShopGUI->setField("Пароль:",$PHPShopGUI->setInput("password","pas",$_COOKIE['pas'],"none",200),"none",5);
    $leftPart.=$PHPShopGUI->setLine('<p></p>');
    $leftPart.=$PHPShopGUI->setCheckbox("win_e",1,"Открыть в текущем окне",$_COOKIE['win_e']);
    $leftPart.=$PHPShopGUI->setLine();


    if(empty($_COOKIE['log']) and empty($_COOKIE['pas']))
        $leftPart.=$PHPShopGUI->setCheckbox("pas_to_cookies",1,"Запомнить логин и пароль",$_COOKIE['pas_to_cookies']);
    else $leftPart.=$PHPShopGUI->setCheckbox("pas_to_cookies",0,"Не запоминать логин и пароль",$_COOKIE['pas_to_cookies']);

    $leftPart.=$PHPShopGUI->setLine();

    $leftPart.=$PHPShopGUI->setCheckbox("pas_to_mail",1,"Выслать пароль пользователю",'');
    $leftPart.=$SendMailStatus;

    $rightPart=$PHPShopGUI->setLine('<p style="padding-top:3px;"></p>');
    $rightPart.=$PHPShopGUI->setInput("submit","enter","ОК","right",70,"","but","actionEnter");
    $rightPart.=$PHPShopGUI->setInput("button","exit","Выход","right",70,"location.replace('./?do=out')","but");

    $PHPShopGUI->_CODE.=$PHPShopGUI->setTable($leftPart,$rightPart);

    // Запрос модуля
    $PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,array($leftPart,$rightPart));

    $PHPShopGUI->setFooter(false);
    return true;
}

// Вывод формы при старте
$PHPShopGUI->setLoader($_POST['enter'],'actionStart');

// Обработка событий
$PHPShopGUI->getAction();

?>