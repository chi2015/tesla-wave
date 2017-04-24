<?php

$_classPath = "../../";
include($_classPath . "class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("security");

$PHPShopBase = new PHPShopBase($_classPath . "inc/config.ini");
$PHPShopBase->chekAdmin();

PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

// Редактор GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title = "Редактирование Администратора";


// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name19']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath . "modules/");

// Определяем пользователей
$AdmUsers = array(
    "0" => "Администратор",
    "1" => "Оператор базы",
    "3" => "Промоутер");

// Заполняем выбор
function setSelectChek($n) {
    global $AdmUsers;
    foreach ($AdmUsers as $key => $val) {
        if ($n == $key)
            $s = "selected"; else
            $s = "";
        $select[] = array($val, $key, $s);
        $i++;
    }
    return $select;
}

function actionStart() {
    global $PHPShopGUI, $PHPShopOrm, $PHPShopModules;

    // Выборка
    $data = $PHPShopOrm->select(array('*'), array('id' => '=' . $_GET['id']));
    extract($data);

    if ($data['enabled'] == 1)
        $fl = "checked";
    else
        $fl2 = "checked";


    $PHPShopGUI->dir = "../";
    $PHPShopGUI->size = "500, 410";


    // Графический заголовок окна
    $PHPShopGUI->setHeader("Редактирование Администратора", "Укажите данные для записи в базу.", $PHPShopGUI->dir . "img/i_account_properties_med[1].gif");

    $Select1 = setSelectChek($status);

    // Содержание закладки 1
    $Tab1 = $PHPShopGUI->setField("E-mail:", $PHPShopGUI->setInput("text", "mail_new", $mail, "none", 250) . $PHPShopGUI->setRadio("enabled_new", 1, "Показывать", @$fl, "left") . $PHPShopGUI->setRadio("enabled_new", 0, "Скрыть", @$fl2), "left") .
            $PHPShopGUI->setField("Статус:", $PHPShopGUI->setSelect("status_new", $Select1, 150, 1) . "<br>", "left", 5) .
            $PHPShopGUI->setLine() .
            $PHPShopGUI->setField("Авторизация:", $PHPShopGUI->setText("Login: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;") . $PHPShopGUI->setInput("text", "login_new", $login, "none", 150) .
                    $PHPShopGUI->setText("Password: ") . $PHPShopGUI->setInput("password", "password_new", 'XXXXXXXX', "none", 150, "this.value=''") . $PHPShopGUI->setCheckbox("flag", 1, "Сменить логин и пароль? Необходимо указать новый логин и  пароль. Не отмечайте этот флаг, если смена логина и пароля не требуется.", false), "none", 5);


    // Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное", $Tab1, 200));

    // Запрос модуля на закладку
    $PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"], __FUNCTION__, $data);

    // Вывод кнопок сохранить и выход в футер
    $ContentFooter =
            $PHPShopGUI->setInput("hidden", "newsID", $id, "right", 70, "", "but") .
            $PHPShopGUI->setInput("button", "", "Отмена", "right", 70, "return onCancel();", "but") .
            $PHPShopGUI->setInput("button", "delID", "Удалить", "right", 70, "return onDelete('" . __('Вы действительно хотите удалить?') . "')", "but", "actionDelete") .
            $PHPShopGUI->setInput("submit", "editID", "ОК", "right", 70, "", "but", "actionUpdate");

    // Футер
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// Функция обновления
function actionUpdate() {
    global $PHPShopOrm;

    if (empty($_POST['enabled_new']))
        $_POST['enabled_new'] = 0;

    if (empty($_POST['status_new']))
        $_POST['status_new'] = 0;

    if (!empty($_POST['flag']) and PHPShopSecurity::true_login($_POST['login_new']) and $_POST['password_new'] != 'XXXXXXXX'
            and PHPShopSecurity::true_passw($_POST['password_new'])) {
        $_POST['password_new'] = base64_encode($_POST['password_new']);

        // Обновление данных при редактирование текущего пользователя
        if ($_SESSION['idPHPSHOP'] == $_POST['newsID']) {
            $_SESSION['logPHPSHOP'] = $_POST['login_new'];
            $_SESSION['pasPHPSHOP'] = $_POST['password_new'];
        }
    } else {
        $_POST['login_new'] = null;
        $_POST['password_new'] = null;
    }

    return $PHPShopOrm->update($_POST, array('id' => '=' . intval($_POST['newsID'])));
}

// Функция удаления
function actionDelete() {
    global $PHPShopOrm;
    $action = $PHPShopOrm->delete(array('id' => '=' . intval($_POST['newsID'])));
    return $action;
}

if ($UserChek->statusPHPSHOP < 2) {

    // Вывод формы при старте
    $PHPShopGUI->setAction($_GET['id'], 'actionStart', 'none');

    // Обработка событий 
    $PHPShopGUI->getAction();
}else
    $UserChek->BadUserFormaWindow();
?>



