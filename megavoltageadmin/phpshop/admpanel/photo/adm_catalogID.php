<?php

$_classPath = "../../";
include($_classPath . "class/obj.class.php");
PHPShopObj::loadClass("base");

$PHPShopBase = new PHPShopBase($_classPath . "inc/config.ini");
$PHPShopBase->chekAdmin();

PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

// Редактор GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title = "Редактирование Каталога";
$PHPShopGUI->reload = "left";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name22']);

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath . "modules/");

// вывод каталогов в выборе
function Disp_cat($parent_to, $n) {
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name22']);
    $data = $PHPShopOrm->select(array('name'), array('id' => '=' . $parent_to));
    if (is_array($data))
        extract($data);
    return "$name => $n";
}

function actionStart() {
    global $PHPShopGUI, $PHPShopSystem, $SysValue, $_classPath, $PHPShopOrm, $PHPShopModules;

    // Тип окна
    if ($_COOKIE['winOpenType'] == 'default')
        $dot = ".";
    else
        $dot = false;

    // Выборка
    $data = $PHPShopOrm->select(array('*'), array('id' => '=' . $_GET['id']));
    extract($data);

    if ($data['enabled'] == 1)
        $enabled = "checked"; else
        $enabled = "";

    $PHPShopGUI->dir = "../";
    $PHPShopGUI->size = "650,630";

    // Графический заголовок окна
    $PHPShopGUI->setHeader("Редактирование Каталога", "Укажите данные для записи в базу.", $PHPShopGUI->dir . "img/i_filemanager_med[1].gif");

    // Редактор 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('content_new');
    $oFCKeditor->Height = '420';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath . "../templates" . chr(47) . $PHPShopSystem->getParam("skin") . chr(47) . $SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value = $content;

    // Содержание закладки 1
    $Tab1 = $PHPShopGUI->setField("Название:", $PHPShopGUI->setInput("text", "name_new", $name, "left", 450), "none") .
            $PHPShopGUI->setField("Каталог:", $PHPShopGUI->setInput("text", "parent_name", Disp_cat($parent_to, $name), "left", 450) .
                    $PHPShopGUI->setInput("hidden", "parent_to_new", $parent_to, "left", 450) .
                    $PHPShopGUI->setButton("Выбрать", "../icon/folder_edit.gif", "100px", "Выбрать", "none", "miniWin('" . $dot . "./photo/adm_cat.php?category=" . $parent_to . "',300,400);return false;"), "none") .
            $PHPShopGUI->setLine() .
            $PHPShopGUI->setField($PHPShopGUI->setCheckbox("enabled_new", 1, "Показывать", $enabled), $PHPShopGUI->setInputText(false, "num_new", $num, 30, "позиция при выводе")) .
            $PHPShopGUI->setField("Привязка к странице:", $PHPShopGUI->setInputText(false, "page_new", $page, 550, '<br>Пример: page/,news/. Можно указать несколько адресов через запятую без пробелов.'));

    // Содержание закладки 2
    $Tab2 = $oFCKeditor->AddGUI();

    // Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное", $Tab1, 450), array("Содержание", $Tab2, 450));

    // Запрос модуля на закладку
    $PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"], __FUNCTION__, $data);

    // Вывод кнопок сохранить и выход в футер
    $ContentFooter = $PHPShopGUI->setInput("hidden", "newsID", $id, "right", 70, "", "but") .
            $PHPShopGUI->setInput("button", "", __("Отмена"), "right", 70, "return onCancel();", "but") .
            $PHPShopGUI->setInput("button", "delID", __("Удалить"), "right", 70, "return onDelete('" . __('Вы действительно хотите удалить?') . "')", "but", "actionDelete") .
            $PHPShopGUI->setInput("submit", "editID", __("ОК"), "right", 70, "", "but", "actionUpdate");

    // Футер
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// Функция удаления
function actionDelete() {
    global $PHPShopOrm, $PHPShopModules;

    // Перехват модуля
    $PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"], __FUNCTION__, $_POST);

    $action = $PHPShopOrm->delete(array('id' => '=' . $_POST['newsID']));
    return $action;
}

// Функция обновления
function actionUpdate() {
    global $PHPShopOrm, $PHPShopModules;

    if (empty($_POST['enabled_new']))
        $_POST['enabled_new'] = 0;

    // Перехват модуля
    $PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"], __FUNCTION__, $_POST);

    $action = $PHPShopOrm->update($_POST, array('id' => '=' . $_POST['newsID']));
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