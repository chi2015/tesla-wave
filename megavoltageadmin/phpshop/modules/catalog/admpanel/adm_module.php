<?php

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
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.catalog.catalog_system"));


// ������� ����������
function actionUpdate() {
    global $PHPShopOrm;

    $action = $PHPShopOrm->update($_POST);
    return $action;
}


function actionStart() {
    global $PHPShopGUI,$_classPath,$PHPShopOrm;

    $PHPShopGUI->dir=$_classPath."admpanel/";
    $PHPShopGUI->title="��������� ������ Catalog";
    $PHPShopGUI->size="500,500";

    // �������
    $data = $PHPShopOrm->select();
    @extract($data);


    // ����������� ��������� ����
    $PHPShopGUI->setHeader("��������� ������ 'Catalog'","���������",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");


    // ���������� �������� 1
    $Tab1=$PHPShopGUI->setField("��� ������ ������:",$PHPShopGUI->setInputText("http://: ","domain_new",$domain,250),'left');
    $Tab1.=$PHPShopGUI->setField("���������� ������� �� ��������:",$PHPShopGUI->setInputText(false,"limit_new",$limit,50,' �� ����� 100'),'right',5);
    $Tab1.=$PHPShopGUI->setLine();
    $Tab1.=$PHPShopGUI->setField("Partner ID:",$PHPShopGUI->setInputText(false,"partner_new",$partner,50,' *������������� �������� (�����). ����������� ��� ��������� ��� �������.'));
    $Tab1.=$PHPShopGUI->setField("URL Key:",$PHPShopGUI->setInputText(false,"url_key_new",$url_key,100,' *���� ����������� ��� ����� '.$_SERVER['SERVER_NAME'].'.'));
    $Tab1.=$PHPShopGUI->setField("Catalog ID:",$PHPShopGUI->setInputText(false,"left_new",$left,50,' *������������� �������� ��� ������ ����� (�����, /shop/CID_<b>8</b>.html)'));  
    $Tab1.=$PHPShopGUI->setField("���������� ������� �����:",$PHPShopGUI->setInputText(false,"limit_left_new",$limit_left,50));  
    $Tab1.=$PHPShopGUI->setField("Catalog ID:",$PHPShopGUI->setInputText(false,"right_new",$right,50,' *������������� �������� ��� ������ ������ (�����, /shop/CID_<b>8</b>.html)'));  
    $Tab1.=$PHPShopGUI->setField("���������� ������� ������:",$PHPShopGUI->setInputText(false,"limit_right_new",$limit_right,50)); 

    $Tab3=$PHPShopGUI->setPay($serial,false);
    
    $Info='��� ������ ������� � ��������� �������� � �������� phpshop/modules/catalog/templates/
<ul>
<li>catalog_forma.tpl - ������ ��������
<li>catalog_list.tpl - ������ ������ ���������
<li>product_forma.tpl - ������ ������ � �����
<li>product_forma_full.tpl - ������ �������� �������� ������
<li>product_forma_full.tpl - ������ ���������� �������� ������
</ul>
';
    $Tab2=$PHPShopGUI->setInfo($Info);
    
    // ����� ����� ��������
    $PHPShopGUI->setTab(array("�����",$Tab1,370),array("�������",$Tab2,370),array("� ������",$Tab3,370));


    

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