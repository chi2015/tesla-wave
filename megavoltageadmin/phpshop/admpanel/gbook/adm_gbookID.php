<?
$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("date");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

// �������� GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="�������������� ������";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name7']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

// �������
    $data = $PHPShopOrm->select(array('*'),array('id'=>'='.$_GET['id']));
    extract($data);

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";
    $PHPShopGUI->addJSFiles('../java/popup_lib.js','../java/dateselector.js');
    $PHPShopGUI->addCSSFiles('../skins/'.$_SESSION['theme'].'/dateselector.css');


// ����������� ��������� ����
    $PHPShopGUI->setHeader("�������������� ������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_account_properties_med[1].gif");

// �������� 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('answer_new') ;
    $oFCKeditor->Height = '320';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= $answer ;


// ���������� �������� 1
    $Tab1=$PHPShopGUI->setField("����:",
            $PHPShopGUI->setInput("text","date_new",PHPShopDate::dataV($date,false),"left",70).
            $PHPShopGUI->setCalendar('date_new').
            $PHPShopGUI->setLine().
            $PHPShopGUI->setCheckbox('enabled_new','1','�����',$enabled)
            ,"left");


    $Tab1.=$PHPShopGUI->setField("�����:",$PHPShopGUI->setText("���:&nbsp;&nbsp;","left").
            $PHPShopGUI->setInput("text","name_new",$name,"none",300).$PHPShopGUI->setText("E-mail:","left").$PHPShopGUI->setInput("text","mail_new",$mail,"none",300),"none",5).
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("����:",$PHPShopGUI->setTextarea("title_new",$title,"left",'97%','50px'),"none").
            $PHPShopGUI->setField("�����:",$PHPShopGUI->setTextarea("question_new",$question,"left",'97%','80px'),"none");

// ���������� �������� 2
    $Tab2=$oFCKeditor->AddGUI();

// ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,350),array("�����",$Tab2,350));

// ������ ������ �� ��������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data));

// ����� ������ ��������� � ����� � �����
    $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("button","","������","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("button","delID","�������","right",70,"return onDelete('".__('�� ������������� ������ �������?')."')","but","actionDelete").
            $PHPShopGUI->setInput("submit","editID","��","right",70,"","but","actionUpdate");

// �����
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// ������� �������� �����
function sendMail($name,$mail) {
    global $PHPShopSystem;

    // ���������� ���������� �������� �����
    PHPShopObj::loadClass("mail");

    $zag="��� ����� �������� �� ���� ".$PHPShopSystem->getValue('name');
    $message="��������� ".$name.",

��� ����� �������� �� ���� �� ������: http://".$_SERVER['SERVER_NAME']."/gbook/

������� �� ����������� �������.";
    $PHPShopMail = new PHPShopMail($PHPShopSystem->getValue('admin_mail'),$mail,$zag,$message);
}


// ������� ����������
function actionUpdate() {
    global $PHPShopOrm,$PHPShopModules;

    // �������� ������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));

    $_POST['date_new'] = PHPShopDate::GetUnixTime($_POST['date_new']);
    if(empty($_POST['enabled_new'])) $_POST['enabled_new'] = 0;
    else if(!empty($_POST['mail_new'])) sendMail($_POST['name_new'],$_POST['mail_new']);

    $action = $PHPShopOrm->update($_POST,array('id'=>'='.$_POST['newsID']));
    return $action;
}

// ������� ��������
function actionDelete() {
    global $PHPShopOrm,$PHPShopModules;

    // �������� ������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));

    $action = $PHPShopOrm->delete(array('id'=>'='.$_POST['newsID']));
    return $action;
}

if($UserChek->statusPHPSHOP < 2) {

// ����� ����� ��� ������
    $PHPShopGUI->setAction($_GET['id'],'actionStart','none');

// ��������� �������
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>