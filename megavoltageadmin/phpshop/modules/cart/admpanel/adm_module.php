<?php

$_classPath = "../../../";
include($_classPath . "class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("security");
PHPShopObj::loadClass("orm");

$PHPShopBase = new PHPShopBase($_classPath . "inc/config.ini");
include($_classPath . "admpanel/enter_to_admin.php");


// ��������� ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath . "modules/");


// ��������
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.cart.cart_system"));

// ������� ����������
function actionUpdate() {
    global $PHPShopOrm;

// �������� ���� �������
    $_FILES['file']['ext'] = PHPShopSecurity::getExt($_FILES['file']['name']);
    if ($_FILES['file']['ext'] == "csv") {
        if (move_uploaded_file($_FILES['file']['tmp_name'], "../../../../UserFiles/Price/" . $_FILES['file']['name']))
            $_POST['filedir_new'] = $_FILES['file']['name'];
    }

// �������� ���� ��������
    $_FILES['catalog']['ext'] = PHPShopSecurity::getExt($_FILES['catalog']['name']);
    if ($_FILES['catalog']['ext'] == "csv") {
        if (move_uploaded_file($_FILES['catalog']['tmp_name'], "../../../../UserFiles/Price/" . $_FILES['catalog']['name']))
            $_POST['catdir_new'] = $_FILES['catalog']['name'];
    }

    if (empty($_POST['enabled_new']))
        $_POST['enabled_new'] = 0;
    if (empty($_POST['enabled_market_new']))
        $_POST['enabled_market_new'] = 0;
    if (empty($_POST['enabled_search_new']))
        $_POST['enabled_search_new'] = 0;
    if (empty($_POST['enabled_speed_new']))
        $_POST['enabled_speed_new'] = 0;

    $PHPShopOrm->debug = false;
    $action = $PHPShopOrm->update($_POST);
    return $action;
}

function actionStart() {
    global $PHPShopGUI, $PHPShopSystem, $_classPath, $PHPShopOrm, $PHPShopModules;


    $PHPShopGUI->dir = $_classPath . "admpanel/";
    $PHPShopGUI->title = "��������� ������ Cart";
    $PHPShopGUI->size = "500,500";


// �������
    $data = $PHPShopOrm->select();
    @extract($data);

    if ($enabled == 1)
        $enabled = "checked"; else
        $enabled = "";
    if ($enabled_market == 1)
        $enabled_market = "checked"; else
        $enabled_market = "";

    // ����������� ��������� ����
    $PHPShopGUI->setHeader("��������� ������ 'Cart'", "��������� �������� ����", $PHPShopGUI->dir . "img/i_display_settings_med[1].gif");

    // ������� ������� ��� �����
    $ContentField1 =
            $PHPShopGUI->setInput("file", "file", "", "left", 350) .
            $PHPShopGUI->setInput("button", "button1", "�������", "left", 70, "window.open('../../../../UserFiles/Price/" . $filedir . "')") .
            $PHPShopGUI->setLine() .
            $PHPShopGUI->setLink($href = "../install/price.csv", '������� ������ ����� ����', $target = '_blank', $style = false);

    $ContentField3 =
            $PHPShopGUI->setInput("file", "catalog", "", "left", 350) .
            $PHPShopGUI->setInput("button", "button1", "�������", "left", 70, "window.open('../../../../UserFiles/Price/" . $catdir . "')") .
            $PHPShopGUI->setLine() .
            $PHPShopGUI->setLink($href = "../install/catalog.csv", '������� ������ ����� ��������', $target = '_blank', $style = false);


    $ContentField2 = $PHPShopGUI->setInputText("E-mail: ", "email_new", $email, 200, ' *��� �������');
    $ContentField2.=$PHPShopGUI->setInputText("������: ", "valuta_new", $valuta, 50);

    $ContentField2.=$PHPShopGUI->setTextarea("message_new", $message, "none", "97%", 70);

    // ���������� �������� 1
    $Tab1 = $PHPShopGUI->setField("���� ������: /UserFiles/Price/" . $filedir . "", $ContentField1);
    $Tab1.=$PHPShopGUI->setField("���� ��������: /UserFiles/Price/" . $catdir . "", $ContentField3);
    $Tab1.=$PHPShopGUI->setField("�����", $ContentField2);


    $Tab2 = $PHPShopGUI->setCheckbox("enabled_speed_new", 1, "��������� ���� ������� ������ � ������ (���������� �������� ������
        ��������� �������) ", $enabled_speed);
    $Tab2.=$PHPShopGUI->setLine();
    $Tab2.=$PHPShopGUI->setCheckbox("enabled_market_new", 1, "����� ������� � ������� � ������� ������", $enabled_market);
    $Tab2.=$PHPShopGUI->setLine();
    $Tab2.=$PHPShopGUI->setCheckbox("enabled_new", 1, "����� ������� �� �����", $enabled);
    $Tab2.=$PHPShopGUI->setLine();
    $Tab2.=$PHPShopGUI->setCheckbox("enabled_search_new", 1, "����� ������� ������ ��� ������", $enabled_search);
    $Tab2.=$PHPShopGUI->setInputText("���������: ", "num_new", $num, 50, ' *������� �� �������� � ������');

    // ���������� �������� 2
    $Info = '��� ������ ������ ��������� ������� ��������� ���� � �������� ����������, ���������� ������ �� ������.

������ ���������� ����� ���� �������:

ID;�������;������������;����;���������
page1;prod1;����;100;1
page2;prod2;��� �����;1000;1
page3;prod3;����������;1500;2

���:
ID  - �� ������ ��� ������ �� ��������
��������� - ID ��������� �� ����� �������� �������

������ ���������� ����� �������� �������:

ID;������������
1;�������
2;�������


�������:
��� ������ ����� ������� �� ����� ���������� ���������� @miniCart@ � �������� index.tpl � shop.tpl � ������ ��� �����.
���������� @miniCart@ ������������� ������������ � ������ ������ ���������� �����. ���� ��� ����� ���������� �� � ������ �����, �� ������� �������
"����� ������� �� �����" � ������� ���������� @miniCart@ � ������ ������.

�����-���� ��������: http://' . $_SERVER['SERVER_NAME'] . '/price/
����� ������:  http://' . $_SERVER['SERVER_NAME'] . '/order/

��� ���������� ������ �� �����-���� � ������� ���� �������� ����� �������� � ������� ���� � ������� ../price/price

������ ����� ������ ��������� � ����� phpshop/modules/cart/templates/order_forma.tpl
��� ���������� ����� ����� � ����� ������ ������ �������� ����� ���� � ���� ����.

��� ���������� ����� "����� ������� � �������" ���� ��������� ������ ��������� ����� ��������� ��� ������ ������ market �
�������� � �������� ����� ������������ � �������. ��� ������� ����� � ���� ������ � ���� �������, �������� ������� ����� ������, �����
�������� � �������������� ����������� �� ���� � ������� ���������� � �������.

��� ������������� ��������� ����� ���������� � ������� ����� ����� ������� "����� ������� � �������" � ��� ������ ������� � ���� ��������
�������� ������ @php $Product = new ProductDisp(3); php@, ��� 3 - ��� ID ������ � ����� ����.
';
    $Tab3 = $PHPShopGUI->setTextarea("", $Info, "left", '98%', 300);

    $rent = $PHPShopGUI->setImage('../install/shopbuilder.jpg', 262, 95, 'left') . '<b>������� ������� �� 
        ��������� PHPShop Enterprise</b><br>
������ �������� ��������-�������� ����� 10 ����� ����� �����������. 
������� � ������ ��������-�������� � ����� ������ �� ������ ����������� �������� � ����������� ���� ������ ��������. 

<h2>������������� ������ ��������-�������� � ������� 45 ���� ���������!</h2>
�� ������ ��������� �������������� ��� ����������� PHPShop Enterprise, ������ ������� �� ��������� �����.
' .$PHPShopGUI->setButton('������� ������� ������', '../install/icon.gif', 250, 30, "none", "javascript:window.open('https://user.shopbuilder.ru/users/register')");

    $Tab4 = $PHPShopGUI->setInfo($rent, false, '97%');

    $Tab5 = $PHPShopGUI->setPay($serial);

    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������", $Tab1, 310), array("�����", $Tab2, 310), array("��������", $Tab3, 310), array("������", $Tab4, 310), array("� ������", $Tab5, 310));




    // ����� ������ ��������� � ����� � �����
    $ContentFooter =
            $PHPShopGUI->setInput("hidden", "newsID", $id, "right", 70, "", "but") .
            $PHPShopGUI->setInput("button", "", "������", "right", 70, "return onCancel();", "but") .
            $PHPShopGUI->setInput("submit", "editID", "��", "right", 70, "", "but", "actionUpdate");

    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

if ($UserChek->statusPHPSHOP < 2) {

// ����� ����� ��� ������
    $PHPShopGUI->setLoader($_POST['editID'], 'actionStart');

// ��������� ������� 
    $PHPShopGUI->getAction();
}else
    $UserChek->BadUserFormaWindow();
?>