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
$PHPShopGUI->title="��������� ����������";
$PHPShopGUI->reload="none";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name3']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

// �������
    $data = $PHPShopOrm->select();
    extract($data);

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="500,600";


// ����������� ��������� ����
    $PHPShopGUI->setHeader("��������� ����������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_website_statistics_med[1].gif");


// ���������� �������� 1
    $Tab1=
            $PHPShopGUI->setField("Title:",$PHPShopGUI->setTextarea("title_new",$title,"left",'97%','100'),"none").
            $PHPShopGUI->setField("Keywords:",$PHPShopGUI->setTextarea("keywords_new",$keywords,"left",'97%','70'),"none").
            $PHPShopGUI->setField("Description:",$PHPShopGUI->setTextarea("meta_new",$meta,"left",'97%','100'),"none");


// ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,430));

    // ������ ������ �� ��������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data));

// ����� ������ ��������� � ����� � �����
    $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("button","","������","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("submit","editID","��","right",70,"","but","actionUpdate");

// �����
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}



// ������� ����������
function actionUpdate() {
    global $PHPShopOrm,$PHPShopModules;

    // �������� ������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));
    
    $action = $PHPShopOrm->update($_POST,array('id'=>'='.$_POST['newsID']));
    return $action;
}


if($UserChek->statusPHPSHOP < 2) {

// ����� ����� ��� ������
    $PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// ��������� ������� 
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>


