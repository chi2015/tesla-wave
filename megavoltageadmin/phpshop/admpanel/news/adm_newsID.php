<?

$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("admgui");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

// �������� GUI
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="�������������� �������";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name8']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

// �������
    $data = $PHPShopOrm->select(array('*'),array('id'=>'='.$_GET['id']));
    extract($data);

    $MyStyle=$_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";
    $PHPShopGUI->addJSFiles('../java/popup_lib.js','../java/dateselector.js');
    $PHPShopGUI->addCSSFiles('../skins/'.$_SESSION['theme'].'/dateselector.css');


// ����������� ��������� ����
    $PHPShopGUI->setHeader("�������������� �������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_balance_med[1].gif");

// �������� 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('description_new') ;
    $oFCKeditor->Height = '230';
    $oFCKeditor->Config['EditorAreaCSS'] = $MyStyle;
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= $description;
    $oFCKeditor->Mod='textareas';

// ���������� �������� 1
    $Tab1=$PHPShopGUI->setField("����:",
            $PHPShopGUI->setInput("text","date_new",$date,"left",70).
            $PHPShopGUI->setCalendar('date_new'),"left").
            $PHPShopGUI->setField("���������:",$PHPShopGUI->setInput("text","title_new",$title,"left",450),"none",5);

    $Tab1.=$PHPShopGUI->setField("�����:",$oFCKeditor->AddGUI());


// �������� 2
    $oFCKeditor = new Editor('content_new') ;
    $oFCKeditor->Height = '320';
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Config['EditorAreaCSS'] = $MyStyle;
    $oFCKeditor->Value		= $content;
    $oFCKeditor->Mod='textareas';

// ���������� �������� 2
    $Tab2=$oFCKeditor->AddGUI();

// ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,350),array("��������",$Tab2,350));

    // ������ ������ �� ��������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data));


// ����� ������ ��������� � ����� � �����
    $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("button","","������","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("button","delID","�������","right",70,"return onDelete('".__('�� ������������� ������ �������?')."')","but","actionDelete").
            $PHPShopGUI->setInput("submit","editID","���������","right",70,"","but","actionUpdate").
            $PHPShopGUI->setInput("submit","saveID","���������","right",80,"","but","actionSave");

   // �����
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

// ������� ����������
function actionSave() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopModules;

    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name8']);
    $action = $PHPShopOrm->update($_POST,array('id'=>'='.$_POST['newsID']));
    $PHPShopOrm->clean();

    $_GET['id']=$_POST['newsID'];
    $PHPShopGUI->setAction($_GET['id'],'actionStart','none');
}

// ������� ����������
function actionUpdate() {
    global $PHPShopOrm,$PHPShopModules;

    // �������� ������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));

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



