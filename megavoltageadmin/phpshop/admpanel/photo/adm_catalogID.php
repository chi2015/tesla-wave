<?php

$_classPath = "../../";
include($_classPath . "class/obj.class.php");
PHPShopObj::loadClass("base");

$PHPShopBase = new PHPShopBase($_classPath . "inc/config.ini");
$PHPShopBase->chekAdmin();

PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

// �������� GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title = "�������������� ��������";
$PHPShopGUI->reload = "left";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name22']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath . "modules/");

// ����� ��������� � ������
function Disp_cat($parent_to, $n) {
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name22']);
    $data = $PHPShopOrm->select(array('name'), array('id' => '=' . $parent_to));
    if (is_array($data))
        extract($data);
    return "$name => $n";
}

function actionStart() {
    global $PHPShopGUI, $PHPShopSystem, $SysValue, $_classPath, $PHPShopOrm, $PHPShopModules;

    // ��� ����
    if ($_COOKIE['winOpenType'] == 'default')
        $dot = ".";
    else
        $dot = false;

    // �������
    $data = $PHPShopOrm->select(array('*'), array('id' => '=' . $_GET['id']));
    extract($data);

    if ($data['enabled'] == 1)
        $enabled = "checked"; else
        $enabled = "";

    $PHPShopGUI->dir = "../";
    $PHPShopGUI->size = "650,630";

    // ����������� ��������� ����
    $PHPShopGUI->setHeader("�������������� ��������", "������� ������ ��� ������ � ����.", $PHPShopGUI->dir . "img/i_filemanager_med[1].gif");

    // �������� 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('content_new');
    $oFCKeditor->Height = '420';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath . "../templates" . chr(47) . $PHPShopSystem->getParam("skin") . chr(47) . $SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value = $content;

    // ���������� �������� 1
    $Tab1 = $PHPShopGUI->setField("��������:", $PHPShopGUI->setInput("text", "name_new", $name, "left", 450), "none") .
            $PHPShopGUI->setField("�������:", $PHPShopGUI->setInput("text", "parent_name", Disp_cat($parent_to, $name), "left", 450) .
                    $PHPShopGUI->setInput("hidden", "parent_to_new", $parent_to, "left", 450) .
                    $PHPShopGUI->setButton("�������", "../icon/folder_edit.gif", "100px", "�������", "none", "miniWin('" . $dot . "./photo/adm_cat.php?category=" . $parent_to . "',300,400);return false;"), "none") .
            $PHPShopGUI->setLine() .
            $PHPShopGUI->setField($PHPShopGUI->setCheckbox("enabled_new", 1, "����������", $enabled), $PHPShopGUI->setInputText(false, "num_new", $num, 30, "������� ��� ������")) .
            $PHPShopGUI->setField("�������� � ��������:", $PHPShopGUI->setInputText(false, "page_new", $page, 550, '<br>������: page/,news/. ����� ������� ��������� ������� ����� ������� ��� ��������.'));

    // ���������� �������� 2
    $Tab2 = $oFCKeditor->AddGUI();

    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������", $Tab1, 450), array("����������", $Tab2, 450));

    // ������ ������ �� ��������
    $PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"], __FUNCTION__, $data);

    // ����� ������ ��������� � ����� � �����
    $ContentFooter = $PHPShopGUI->setInput("hidden", "newsID", $id, "right", 70, "", "but") .
            $PHPShopGUI->setInput("button", "", __("������"), "right", 70, "return onCancel();", "but") .
            $PHPShopGUI->setInput("button", "delID", __("�������"), "right", 70, "return onDelete('" . __('�� ������������� ������ �������?') . "')", "but", "actionDelete") .
            $PHPShopGUI->setInput("submit", "editID", __("��"), "right", 70, "", "but", "actionUpdate");

    // �����
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// ������� ��������
function actionDelete() {
    global $PHPShopOrm, $PHPShopModules;

    // �������� ������
    $PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"], __FUNCTION__, $_POST);

    $action = $PHPShopOrm->delete(array('id' => '=' . $_POST['newsID']));
    return $action;
}

// ������� ����������
function actionUpdate() {
    global $PHPShopOrm, $PHPShopModules;

    if (empty($_POST['enabled_new']))
        $_POST['enabled_new'] = 0;

    // �������� ������
    $PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"], __FUNCTION__, $_POST);

    $action = $PHPShopOrm->update($_POST, array('id' => '=' . $_POST['newsID']));
    return $action;
}

if ($UserChek->statusPHPSHOP < 2) {

// ����� ����� ��� ������
    $PHPShopGUI->setAction($_GET['id'], 'actionStart', 'none');

// ��������� �������
    $PHPShopGUI->getAction();
}else
    $UserChek->BadUserFormaWindow();
?>