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
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.soft.soft_system"));


// ������� ����������
function actionUpdate(){
global $PHPShopOrm;

// �������� ���� �������
$_FILES['file']['ext']=PHPShopSecurity::getExt($_FILES['file']['name']);
if($_FILES['file']['ext']=="csv"){
if(move_uploaded_file($_FILES['file']['tmp_name'], "../../../../UserFiles/File/".$_FILES['file']['name']))
$_POST['filedir_new']=$_FILES['file']['name'];
}
$action = $PHPShopOrm->update($_POST);
return $action;
}


function actionStart(){
global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm;


$PHPShopGUI->dir=$_classPath."admpanel/";
$PHPShopGUI->title="��������� ������";
$PHPShopGUI->size="500,450";


// �������
$data = $PHPShopOrm->select();
@extract($data);


// ����������� ��������� ����
$PHPShopGUI->setHeader("��������� ������ 'SoftCatalog'","��������� �������� ����",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");

// ������� ������� ��� �����
$ContentField1=
$PHPShopGUI->setInput("file","file","","left",350).
$PHPShopGUI->setInput("button","button1","�������","left",70,"window.open('../../../../UserFiles/File/".$filedir."')").
$PHPShopGUI->setInput("hidden","order_db_old","").
'������� ������ <a href="../install/base.csv" title="������� ������" target="_blank">�����-����</a>.'
;

// ���������� �������� 1
$Tab1=$PHPShopGUI->setField("���� ������: <strong>/UserFiles/File/".$filedir."</strong>",$ContentField1);

// ���������� �������� 2
$Info='��� ������ ������ ��������� ������� ��������� ���� � �������� ���������, ���������� ������ �� ������.

������ ���������� �����:

ID;������;����;
page1;1000;/UserFiles/File/f1.rar;
page2;1500;/UserFiles/File/f2.rar;
page3;2000;/UserFiles/File/f3.rar;

���:
page1 - ������ ��������, ��� ������ ����� �������� �������� ��� ��������
1000 - ������ � ������ �����
/UserFiles/File/f1.rar - ���� �� �����. ����� ����� �������������� ��������� � ����� /UserFiles/File
';
$Tab2=$PHPShopGUI->setTextarea("1",$Info,"left",450,200);
$Tab3=$PHPShopGUI->setPay($serial);
// ����� ����� ��������
$PHPShopGUI->setTab(array("��������",$Tab1,270),array("��������",$Tab2,270),array("� ������",$Tab3,270));

// ����� ������ ��������� � ����� � �����
$ContentFooter=
$PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
$PHPShopGUI->setInput("button","","������","right",70,"return onCancel();","but").
$PHPShopGUI->setInput("submit","editID","��","right",70,"","but","actionUpdate");

$PHPShopGUI->setFooter($ContentFooter);
return true;
}

if($UserChek->statusPHPSHOP < 2){

// ����� ����� ��� ������
$PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// ��������� ������� 
$PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();

?>


