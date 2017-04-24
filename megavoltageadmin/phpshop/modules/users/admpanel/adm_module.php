<?
$_classPath="../../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("orm");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
include($_classPath."admpanel/enter_to_admin.php");


// Настройки модуля
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");


// Редактор
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.users.users_system"));


// Функция обновления
function actionUpdate() {
    global $PHPShopOrm;

    if(empty($_POST['enabled_new'])) $_POST['enabled_new']=0;
    if(empty($_POST['captcha_new'])) $_POST['captcha_new']=0;
    if(empty($_POST['stat_flag_new'])) $_POST['stat_flag_new']=0;

    $action = $PHPShopOrm->update($_POST);
    return $action;
}

// Начальная функция загрузки
function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm;


    $PHPShopGUI->dir=$_classPath."admpanel/";
    $PHPShopGUI->title="Настройка модуля";
    $PHPShopGUI->size="500,450";


    // Выборка
    $data = $PHPShopOrm->select();
    @extract($data);


    // Графический заголовок окна
    $PHPShopGUI->setHeader("Настройка модуля 'Users'","Настройки",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");

    if($flag==1) $s2="selected";
    else $s1="selected";
    $Select[]=array("Слева",0,$s1);
    $Select[]=array("Справа",1,$s2);

    // Расположение статитики
    if($stat_flag==1) $sf2="selected";
    elseif($stat_flag==2) $sf1="selected";
    else $sf0="selected";
    $Select2[]=array("Нет",0,$sf0);
    $Select2[]=array("Слева",2,$sf1);
    $Select2[]=array("Справа",1,$sf2);

    // Активация по e-mail
    if($mail_check ==1) $sf3='selected';
    else $sf4='selected';
    $Select3[]=array("Активация пользователя по e-mail",1,$sf3);
    $Select3[]=array("Ручная активация пользователя",2,$sf4);

    $Tab1=$PHPShopGUI->setField("Расположение блока авторизации:",
            $PHPShopGUI->setCheckbox("enabled_new",1,"Вывод блока на сайте",$enabled).$PHPShopGUI->setSelect("flag_new",$Select,100,1),"left",5);

    $Tab1.=$PHPShopGUI->setField("Расположение блока статистики:",$PHPShopGUI->setSelect("stat_flag_new",$Select2,100,1),"left",5);
    $Tab1.=$PHPShopGUI->setLine();
    $Tab1.=$PHPShopGUI->setField("Captcha:",$PHPShopGUI->setCheckbox("captcha_new",1,'Защита от спама',$captcha));
    $Tab1.=$PHPShopGUI->setField("Активация:",$PHPShopGUI->setSelect("mail_check_new",$Select3,200,1));

    $Info='Для интеграции с другими модулями в качестве проверки авторизации используйте проверку существования переменной $_SESSION[UserName]
     или конструкцию:
     <p>
     $PHPShopUsersElement = new PHPShopUsersElement();<br>
     if($PHPShopUsersElement->is_autorization()) авторизация пройдена
     </p>
     Для добавления полей в форму регистрации отредактируйте файл /phpshop/modules/users/templates/users_forma_register.tpl, добавьте в него
     требуемые поля с префиксом dop_, пример:
          <p>
     &lt;input  type="text" name="dop_Возраст" size="25"&gt;
        </p>
     Для доступа к таким полям в других модулях используется конструкция:
          <p>
     $PHPShopUsersElement = new PHPShopUsersElement();<br>
     $PHPShopUsersElement->getParam("Возраст");
     </p>
     Для произвольного размещения формы авторизации отключите опцию вывода блока на сайте и используйте переменную @autorizationForma@ и @onlineForma@
     для вставки в свой шаблон.
';
    $Tab2=$PHPShopGUI->setInfo($Info,250,'97%');


    // Содержание закладки 2
    $Tab3=$PHPShopGUI->setPay($serial,true);

    // Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,270),array("Описание",$Tab2,270),array("О Модуле",$Tab3,270));

    // Вывод кнопок сохранить и выход в футер
    $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("button","","Отмена","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("submit","editID","ОК","right",70,"","but","actionUpdate");

    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

if($UserChek->statusPHPSHOP < 2) {

    // Вывод формы при старте
    $PHPShopGUI->setLoader($_POST['editID'],'actionStart');

    // Обработка событий
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();

?>


