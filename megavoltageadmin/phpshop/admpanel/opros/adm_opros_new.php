<?
$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();


PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

// �������� GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="�������� ������ ������";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name21']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopModules ;

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";


// ����������� ��������� ����
    $PHPShopGUI->setHeader("�������� ������ ������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_website_statistics_med[1].gif");



// ���������� �������� 1
    $Tab1=
            $PHPShopGUI->setField("���������:",$PHPShopGUI->setTextarea("name_new",$name,"left",'97%','30px'),"none").
            $PHPShopGUI->setField("��������:",$PHPShopGUI->setInput("text","dir_new",$dir,"none",400).$PHPShopGUI->setText("* ������: page/,news/. ����� ������� ��������� ������� ����� �������. "),"left",5).
            $PHPShopGUI->setField("�����:",$PHPShopGUI->setRadio("flag_new",1,"��������","checked","none").$PHPShopGUI->setLine().
            $PHPShopGUI->setRadio("flag_new",0,'<font color="#FF0000">������</font>',@$fl2),"none");


// ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,350));

// ������ ������ �� ��������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data));

// ����� ������ ��������� � ����� � �����
    $ContentFooter=
            $PHPShopGUI->setInput("button","","������","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("reset","","��������","right",70,"","but").
            $PHPShopGUI->setInput("submit","editID","��","right",70,"","but","actionInsert");

// �����
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}


// ������� ������
function actionInsert() {
    global $PHPShopOrm,$PHPShopModules;

    // �������� ������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));
    
    $action = $PHPShopOrm->insert($_POST);
    return $action;
}


if($UserChek->statusPHPSHOP < 2) {

// ����� ����� ��� ������
    $PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// ��������� ������� 
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();

?>