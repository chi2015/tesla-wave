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
$PHPShopGUI->title="�������� ������";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name7']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopModules;


    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";
    $PHPShopGUI->addJSFiles('../java/popup_lib.js','../java/dateselector.js');
    $PHPShopGUI->addCSSFiles('../skins/'.$_SESSION['theme'].'/dateselector.css');

// ����������� ��������� ����
    $PHPShopGUI->setHeader("�������� ������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_account_properties_med[1].gif");

// �������� 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('answer_new') ;
    $oFCKeditor->Height = '320';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= '' ;


// ���������� �������� 1
    $Tab1=$PHPShopGUI->setField("����:",
            $PHPShopGUI->setInput("text","date_new",PHPShopDate::dataV(false,false),"left",70).
            $PHPShopGUI->setCalendar('date_new'),"left").
            $PHPShopGUI->setField("�����:",$PHPShopGUI->setText("���:&nbsp;&nbsp;","left").
            $PHPShopGUI->setInput("text","name_new",'',"none",300).$PHPShopGUI->setText("E-mail:","left").$PHPShopGUI->setInput("text","mail_new",$mail,"none",300),"none",5).
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("����:",$PHPShopGUI->setTextarea("title_new",'',"left",'97%','50px'),"none").
            $PHPShopGUI->setField("�����:",$PHPShopGUI->setTextarea("question_new",'',"left",'97%','80px'),"none");

// ���������� �������� 2
    $Tab2=$oFCKeditor->AddGUI();

// ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,350),array("�����",$Tab2,350));

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
    
    $_POST['date_new'] = PHPShopDate::GetUnixTime($_POST['date_new']);
    if(!empty($_POST['question_new'])) $_POST['enabled_new'] = 1;
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



