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
$PHPShopGUI->title="����� �������";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name8']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// ��������� ���
function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopModules;
    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";


// ����������� ��������� ����
    $PHPShopGUI->setHeader("�������� �������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_balance_med[1].gif");

// �������� 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('description_new') ;
    $oFCKeditor->Height = '230';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= '' ;
    $oFCKeditor->Mod='textareas';

// ���������� �������� 1
    $Tab1=$PHPShopGUI->setField("����:",$PHPShopGUI->setInput("text","date_new",date("d-m-Y"),"left",70),"left").
            $PHPShopGUI->setField("���������:",$PHPShopGUI->setInput("text","title_new",'',"left",450),"none",5);

    $Tab1.=$PHPShopGUI->setField("�����:",$oFCKeditor->AddGUI());

// �������� 2
    $oFCKeditor = new Editor('content_new') ;
    $oFCKeditor->Height = '320';
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->Value		= '' ;
    $oFCKeditor->Mod='textareas';

// ���������� �������� 2
    $Tab2=$oFCKeditor->AddGUI();

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



