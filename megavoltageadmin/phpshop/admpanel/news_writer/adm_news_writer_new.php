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
$PHPShopGUI->title="�������� ������ ��������";



function actionStart(){
global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath;

$PHPShopGUI->dir="../";
$PHPShopGUI->size="400,300";


// ����������� ��������� ����
$PHPShopGUI->setHeader("�������� ������ ��������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_mail_forward_med[1].gif");


// ���������� �������� 1
$Tab1=$PHPShopGUI->setField("E-mail:",$PHPShopGUI->setInput("text","mail_new",$mail,"none",330),"none");


// ����� ����� ��������
$PHPShopGUI->setTab(array("��������",$Tab1,120));

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
function actionInsert(){
$sql="INSERT INTO ".$GLOBALS['SysValue']['base']['table_name9']." VALUES ('','".date("d.m.y")."','".$_POST['mail_new']."')";
if(mysql_query($sql)) return true;
  else return mysql_error();
}

if($UserChek->statusPHPSHOP < 2){

// ����� ����� ��� ������
$PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// ��������� ������� 
$PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>
