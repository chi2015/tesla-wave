<?
$_classPath="../../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("security");
PHPShopObj::loadClass("orm");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
include($_classPath."admpanel/enter_to_admin.php");


// ��������� ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");


// ��������
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.edit.edit_system"));


// ������� ����������
function actionUpdate() {
    global $PHPShopOrm;

    $action = $PHPShopOrm->update($_POST);
    return $action;
}


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm;
    
    
    $PHPShopGUI->dir=$_classPath."admpanel/";
    $PHPShopGUI->title="��������� ������";
    $PHPShopGUI->size="500,450";
    
    
    // �������
    $data = $PHPShopOrm->select();
    @extract($data);
    
    
    // ����������� ��������� ����
    $PHPShopGUI->setHeader("��������� ������ 'Edit'","���������",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");
     $Info='
     ��� ����������� �������������� ������ �������� ���������� ���������� ����� CHMOD 775 �� ��������� ����� � ����� /phpshop/templates/
     ��� ������������� ������������ ��������� PHPShop EasyControl "��� ����" ��� ������ ������� ������������ ������� ��� �� Windows
     ����� CHMOD �� ����� ����������� �� �����.
     <p>
     ���������� � ������������ �� ����� ���� �� �����: <a href="http://www.phpshop.ru/gbook/ID_476.htm" target="_blank">
     http://www.phpshop.ru/gbook/ID_476.html</a>
     </p>';
     
    $Tab1=$PHPShopGUI->setInfo($Info,250,'97%');
    $Tab2=$PHPShopGUI->setPay($serial,false);

    $Lib='� ������ ������������ �������� ���������� <a href="http://codemirror.net/" target="_blank">�odemirror</a><br>
        Copyright (C) 2011 by Marijn Haverbeke.';
    $Tab2.=$PHPShopGUI->setInfo($Lib,30,'95%');
    
    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,270),array("� ������",$Tab2,270));
    
    // ����� ������ ��������� � ����� � �����
    $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("button","","������","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("submit","editID","��","right",70,"","but","actionUpdate");
    
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

if($UserChek->statusPHPSHOP < 2) {
    
    // ����� ����� ��� ������
    $PHPShopGUI->setLoader($_POST['editID'],'actionStart');
    
    // ��������� ������� 
    $PHPShopGUI->getAction();
    
}else $UserChek->BadUserFormaWindow();

?>


