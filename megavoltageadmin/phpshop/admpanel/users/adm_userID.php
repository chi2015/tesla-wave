<?php

$_classPath = "../../";
include($_classPath . "class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("security");

$PHPShopBase = new PHPShopBase($_classPath . "inc/config.ini");
$PHPShopBase->chekAdmin();

PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

// �������� GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title = "�������������� ��������������";


// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name19']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath . "modules/");

// ���������� �������������
$AdmUsers = array(
    "0" => "�������������",
    "1" => "�������� ����",
    "3" => "���������");

// ��������� �����
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

    // �������
    $data = $PHPShopOrm->select(array('*'), array('id' => '=' . $_GET['id']));
    extract($data);

    if ($data['enabled'] == 1)
        $fl = "checked";
    else
        $fl2 = "checked";


    $PHPShopGUI->dir = "../";
    $PHPShopGUI->size = "500, 410";


    // ����������� ��������� ����
    $PHPShopGUI->setHeader("�������������� ��������������", "������� ������ ��� ������ � ����.", $PHPShopGUI->dir . "img/i_account_properties_med[1].gif");

    $Select1 = setSelectChek($status);

    // ���������� �������� 1
    $Tab1 = $PHPShopGUI->setField("E-mail:", $PHPShopGUI->setInput("text", "mail_new", $mail, "none", 250) . $PHPShopGUI->setRadio("enabled_new", 1, "����������", @$fl, "left") . $PHPShopGUI->setRadio("enabled_new", 0, "������", @$fl2), "left") .
            $PHPShopGUI->setField("������:", $PHPShopGUI->setSelect("status_new", $Select1, 150, 1) . "<br>", "left", 5) .
            $PHPShopGUI->setLine() .
            $PHPShopGUI->setField("�����������:", $PHPShopGUI->setText("Login: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;") . $PHPShopGUI->setInput("text", "login_new", $login, "none", 150) .
                    $PHPShopGUI->setText("Password: ") . $PHPShopGUI->setInput("password", "password_new", 'XXXXXXXX', "none", 150, "this.value=''") . $PHPShopGUI->setCheckbox("flag", 1, "������� ����� � ������? ���������� ������� ����� ����� �  ������. �� ��������� ���� ����, ���� ����� ������ � ������ �� ���������.", false), "none", 5);


    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������", $Tab1, 200));

    // ������ ������ �� ��������
    $PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"], __FUNCTION__, $data);

    // ����� ������ ��������� � ����� � �����
    $ContentFooter =
            $PHPShopGUI->setInput("hidden", "newsID", $id, "right", 70, "", "but") .
            $PHPShopGUI->setInput("button", "", "������", "right", 70, "return onCancel();", "but") .
            $PHPShopGUI->setInput("button", "delID", "�������", "right", 70, "return onDelete('" . __('�� ������������� ������ �������?') . "')", "but", "actionDelete") .
            $PHPShopGUI->setInput("submit", "editID", "��", "right", 70, "", "but", "actionUpdate");

    // �����
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// ������� ����������
function actionUpdate() {
    global $PHPShopOrm;

    if (empty($_POST['enabled_new']))
        $_POST['enabled_new'] = 0;

    if (empty($_POST['status_new']))
        $_POST['status_new'] = 0;

    if (!empty($_POST['flag']) and PHPShopSecurity::true_login($_POST['login_new']) and $_POST['password_new'] != 'XXXXXXXX'
            and PHPShopSecurity::true_passw($_POST['password_new'])) {
        $_POST['password_new'] = base64_encode($_POST['password_new']);

        // ���������� ������ ��� �������������� �������� ������������
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

// ������� ��������
function actionDelete() {
    global $PHPShopOrm;
    $action = $PHPShopOrm->delete(array('id' => '=' . intval($_POST['newsID'])));
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



