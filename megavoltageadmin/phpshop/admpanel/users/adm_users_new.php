<?
$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

// ���������� �������������
$AdmUsers=array(
        "0"=>"�������������",
        "1"=>"�������� ����",
        "3"=>"���������");

PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

// �������� GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="�������� ������ ��������������";


// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name19']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// ��������� �����
function setSelectChek($n) {
    global $AdmUsers;
    foreach($AdmUsers as $key=>$val) {
        if($n==$key) $s="selected"; else $s="";
        $select[]=array($val,$key,$s);
        $i++;
    }
    return $select;
}


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;


    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="500, 410";


// ����������� ��������� ����
    $PHPShopGUI->setHeader("�������� ������ ��������������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_account_properties_med[1].gif");

    $Select1=setSelectChek($status);

// ���������� �������� 1
    $Tab1=$PHPShopGUI->setField("E-mail:",$PHPShopGUI->setInput("text","mail_new",$mail,"none",250).$PHPShopGUI->setRadio("enabled_new",1,"����������","checked","left").$PHPShopGUI->setRadio("enabled_new",0,"������",false),"left").
            $PHPShopGUI->setField("������:",$PHPShopGUI->setSelect("status_new",$Select1,150,1)."<br>","left",5).
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("�����������:",
            $PHPShopGUI->setText("Login: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;").$PHPShopGUI->setInput("text","login_new",$login,"none",150).
            $PHPShopGUI->setText("Password: ").$PHPShopGUI->setInput("password","password_new","","none",150),"none",5);


// ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,200));

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
    global $PHPShopOrm;

    $_POST['password_new']=base64_encode($_POST['password_new']);

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



