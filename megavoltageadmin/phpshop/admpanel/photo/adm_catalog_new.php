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
$PHPShopGUI->reload = "left";


// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name22']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;


    // ��� ����
    if($_COOKIE['winOpenType'] == 'default')
        $dot=".";
    else $dot=false;

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="650,630";

// ����������� ��������� ����
    $PHPShopGUI->setHeader("�������� ������ ��������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img//i_filemanager_med[1].gif");

// �������� 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('content_new') ;
    $oFCKeditor->Height = '420';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= $content ;


// ���������� �������� 1
    $Tab1=
            $PHPShopGUI->setField("��������:",$PHPShopGUI->setInput("text","name_new",'����� ������� ����',"left",450),"none").
            $PHPShopGUI->setField("�������:",$PHPShopGUI->setInput("text","parent_name",'������',"left",450).
            $PHPShopGUI->setInput("hidden","parent_to_new",0,"left",450).
            $PHPShopGUI->setButton("�������","../icon/folder_edit.gif","100px","�������","none","miniWin('".$dot."./photo/adm_cat.php?category=".$parent_to."',300,400);return false;"),"none").
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField($PHPShopGUI->setCheckbox("enabled_new",1,"����������","checked"),$PHPShopGUI->setInputText(false,"num_new",1,30,"������� ��� ������")).
            $PHPShopGUI->setField("�������� � ��������:",$PHPShopGUI->setInputText(false,"page_new",'',550,'<br>������: page/,news/. ����� ������� ��������� ������� ����� ������� ��� ��������.'));

// ���������� �������� 2
    $Tab2=$oFCKeditor->AddGUI();


// ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,450),array("����������",$Tab2,450));

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
