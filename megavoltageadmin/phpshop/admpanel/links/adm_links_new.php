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
$PHPShopGUI->title="�������� ����� ������";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name17']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// ��������� �����
function setSelectChek($n) {
    $i=1;
    while($i<=10) {
        if($n==$i) $s="selected"; else $s="";
        $select[]=array($i,$i,$s);
        $i++;
    }
    return $select;
}


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";

// ����������� ��������� ����
    $PHPShopGUI->setHeader("�������� ����� ������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_register_domain_med[1].gif");

    $Select1=setSelectChek($num);

// ���������� �������� 1
    $Tab1=
            $PHPShopGUI->setField("������:",$PHPShopGUI->setTextarea("name_new",$name,"left",'97%','30px'),"none").
            $PHPShopGUI->setField("�������:",$PHPShopGUI->setSelect("num_new",$Select1,50,1).$PHPShopGUI->setRadio("enabled_new",1,"����������","checked","left").$PHPShopGUI->setRadio("enabled_new",0,"������",false),"left",5).
            $PHPShopGUI->setField("������:",$PHPShopGUI->setInput("text","link_new",'',"none",330),"none").
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("��������:",$PHPShopGUI->setTextarea("content_new",'',"left",'97%','100px'),"none");


    $Tab2=$PHPShopGUI->setField("��� ������:",$PHPShopGUI->setTextarea("image_new",'',"left",'97%','100px'),"none");

// ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,350),array("��������",$Tab2,350));

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

    if(!empty($_POST['otsiv_new'])) $flag_new = 1;
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
