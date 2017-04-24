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
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.comment.comment_system"));

// ������� ����������
function actionUpdate() {
    global $PHPShopOrm;

    if(empty($_POST['enabled_new'])) $_POST['enabled_new']=0;
    if(empty($_POST['flag_new'])) $_POST['flag_new']=0;

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
    $PHPShopGUI->setHeader("��������� ������ 'Comment'","���������",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");

    if($flag==0) $s0="selected";
    else $s1="selected";
    $Select[]=array("������",1,$s1);
    $Select[]=array("�����",0,$s0);
    

    $Tab1=$PHPShopGUI->setField("������������ ����� ������������:",
            $PHPShopGUI->setCheckbox("enabled_new",1,"����� ����� �� �����",$enabled).$PHPShopGUI->setSelect("flag_new",$Select,100,1),"left",5);

     $Info='
     ��� ������������� ���������� ����� ������ ��������� ������������ ��������� ����� ������ ����� �� ����� � ����������� ���������� @lastcommentForma@
     ��� ������� � ���� ������ � ������������ �����.
';
    $Tab2=$PHPShopGUI->setInfo($Info,250,'97%');

    // ���������� �������� 2
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

if($UserChek->statusPHPSHOP < 2) {

    // ����� ����� ��� ������
    $PHPShopGUI->setLoader($_POST['editID'],'actionStart');

    // ��������� �������
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>