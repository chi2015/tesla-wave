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
$PHPShopGUI->title="�������� ������� ��� ������";
$PHPShopGUI->reload="parent";

// SQL
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name20']);


function actionStart(){
global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath;

$PHPShopGUI->dir="../";
$PHPShopGUI->size="500,400";


// ����������� ��������� ����
$PHPShopGUI->setHeader("�������� �������� ������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_website_statistics_med[1].gif");

$Select1=setSelectChek($_GET['categoryID']);

// ���������� �������� 1
$Tab1=
$PHPShopGUI->setField("�����:",$PHPShopGUI->setTextarea("name_new",$name,"left",'97%','30px'),"none").
$PHPShopGUI->setField("���������:",$PHPShopGUI->setSelect("category_new",$Select1,400,1),"none").
$PHPShopGUI->setField("������:",$PHPShopGUI->setInput("text","total_new",$total,"none",200),"left").
$PHPShopGUI->setField("����������:",$PHPShopGUI->setInput("text","num_new",$num,"none",200),"none");


// ����� ����� ��������
$PHPShopGUI->setTab(array("��������",$Tab1,220));

// ����� ������ ��������� � ����� � �����
$ContentFooter=
$PHPShopGUI->setInput("button","","������","right",70,"return onCancel();","but").
$PHPShopGUI->setInput("reset","","��������","right",70,"","but").
$PHPShopGUI->setInput("submit","editID","��","right",70,"","but","actionInsert");

// �����
$PHPShopGUI->setFooter($ContentFooter);
return true;
}


// ��������� ����� ����� ��������� � ������
function setSelectChek($n){
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name21']);
$data = $PHPShopOrm->select(array('name','id'),false,false,array("limit"=>"100"));
foreach($data as $row){
extract($row);
if($n==$id) $s="selected"; else $s="";
$select[]=array($name,$id,$s);
}
return $select;
}


// ������� ������
function actionInsert(){
global $PHPShopOrm;
$action = $PHPShopOrm->insert($_POST);
return $action;
}


if($UserChek->statusPHPSHOP < 2){

// ����� ����� ��� ������
$PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// ��������� ������� 
$PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>
