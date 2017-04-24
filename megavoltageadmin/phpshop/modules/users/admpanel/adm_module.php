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
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.users.users_system"));


// ������� ����������
function actionUpdate() {
    global $PHPShopOrm;

    if(empty($_POST['enabled_new'])) $_POST['enabled_new']=0;
    if(empty($_POST['captcha_new'])) $_POST['captcha_new']=0;
    if(empty($_POST['stat_flag_new'])) $_POST['stat_flag_new']=0;

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
    $PHPShopGUI->setHeader("��������� ������ 'Users'","���������",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");

    if($flag==1) $s2="selected";
    else $s1="selected";
    $Select[]=array("�����",0,$s1);
    $Select[]=array("������",1,$s2);

    // ������������ ���������
    if($stat_flag==1) $sf2="selected";
    elseif($stat_flag==2) $sf1="selected";
    else $sf0="selected";
    $Select2[]=array("���",0,$sf0);
    $Select2[]=array("�����",2,$sf1);
    $Select2[]=array("������",1,$sf2);

    // ��������� �� e-mail
    if($mail_check ==1) $sf3='selected';
    else $sf4='selected';
    $Select3[]=array("��������� ������������ �� e-mail",1,$sf3);
    $Select3[]=array("������ ��������� ������������",2,$sf4);

    $Tab1=$PHPShopGUI->setField("������������ ����� �����������:",
            $PHPShopGUI->setCheckbox("enabled_new",1,"����� ����� �� �����",$enabled).$PHPShopGUI->setSelect("flag_new",$Select,100,1),"left",5);

    $Tab1.=$PHPShopGUI->setField("������������ ����� ����������:",$PHPShopGUI->setSelect("stat_flag_new",$Select2,100,1),"left",5);
    $Tab1.=$PHPShopGUI->setLine();
    $Tab1.=$PHPShopGUI->setField("Captcha:",$PHPShopGUI->setCheckbox("captcha_new",1,'������ �� �����',$captcha));
    $Tab1.=$PHPShopGUI->setField("���������:",$PHPShopGUI->setSelect("mail_check_new",$Select3,200,1));

    $Info='��� ���������� � ������� �������� � �������� �������� ����������� ����������� �������� ������������� ���������� $_SESSION[UserName]
     ��� �����������:
     <p>
     $PHPShopUsersElement = new PHPShopUsersElement();<br>
     if($PHPShopUsersElement->is_autorization()) ����������� ��������
     </p>
     ��� ���������� ����� � ����� ����������� �������������� ���� /phpshop/modules/users/templates/users_forma_register.tpl, �������� � ����
     ��������� ���� � ��������� dop_, ������:
          <p>
     &lt;input  type="text" name="dop_�������" size="25"&gt;
        </p>
     ��� ������� � ����� ����� � ������ ������� ������������ �����������:
          <p>
     $PHPShopUsersElement = new PHPShopUsersElement();<br>
     $PHPShopUsersElement->getParam("�������");
     </p>
     ��� ������������� ���������� ����� ����������� ��������� ����� ������ ����� �� ����� � ����������� ���������� @autorizationForma@ � @onlineForma@
     ��� ������� � ���� ������.
';
    $Tab2=$PHPShopGUI->setInfo($Info,250,'97%');


    // ���������� �������� 2
    $Tab3=$PHPShopGUI->setPay($serial,true);

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


