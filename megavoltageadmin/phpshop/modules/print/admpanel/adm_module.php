<?
$_classPath="../../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
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
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.print.print_system"));


// ������� ����������
function actionUpdate() {
    global $PHPShopOrm;
    $action = $PHPShopOrm->update($_POST);
    return $action;
}

// ��������� ������� ��������
function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm;


    $PHPShopGUI->dir=$_classPath."admpanel/";
    $PHPShopGUI->title="��������� ������";
    $PHPShopGUI->size="500,450";


    // �������
    $data = $PHPShopOrm->select();
    @extract($data);


    // ����������� ��������� ����
    $PHPShopGUI->setHeader("��������� ������ 'PrintForm'","���������",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");

    // ���������� �������� 1
    $Info='
������ ������� �������� ����� �������� �� ������ /print/������.html
� ������ �������� ����� �������� ������ �� �������� ����� <a href="/print/������.html">�������� �����</a>

��� ��������������� ������������ ������ �������� php ��� � ������ page/page_page_list.tpl

@php
if(class_exists("PHPShopPrintForma")){
$PHPShopPrintForma=new PHPShopPrintForma();
$PHPShopPrintForma->forma();
}
php@
';
    $Tab1=$PHPShopGUI->setTextarea('example_new',$Info,false,'97%',250);

    // ���������� �������� 2
    $Tab2=$PHPShopGUI->setPay($serial);

    // ����� ����� ��������
    $PHPShopGUI->setTab(array("���������",$Tab1,270),array("� ������",$Tab2,270));

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


