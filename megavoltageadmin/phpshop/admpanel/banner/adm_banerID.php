<?

$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

// �������� GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="�������������� ������";
$PHPShopSystem = new PHPShopSystem();

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name15']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// ��������� ���
function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

// �������
    $data = $PHPShopOrm->select(array('*'),array('id'=>'='.$_GET['id']));
    extract($data);


    if($enabled==1) $fl="checked";
    else $fl2="checked";


    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";


// ����������� ��������� ����
    $PHPShopGUI->setHeader("�������������� ������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_select_another_account_med[1].gif");


    $Field1=$PHPShopGUI->setInput("text","name_new",$name,"none",300).
            $PHPShopGUI->setRadio("enabled_new",1,"���������� �����",@$fl).
            $PHPShopGUI->setRadio("enabled_new",0,"������ �����",@$f2);

    $Field2=$PHPShopGUI->setInput("text","limit_all_new",$limit_all,"none",100).
            $PHPShopGUI->setCheckbox("clean_st",1,"�������� �������� ".@$count_today." / ".$count_all,false);

// ���������� �������� 1
    $Tab1=$PHPShopGUI->setField("������������:",$Field1,"none").
            $PHPShopGUI->setField("����� �������:",$Field2,"none");

// �������� 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('content_new') ;
    $oFCKeditor->Height = '300';
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= $content ;
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];

// ���������� �������� 2
    $Tab2=$oFCKeditor->AddGUI();

// ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,350),array("����������",$Tab2,350));

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


// ������� ��������
function actionDelete() {
    global $PHPShopOrm,$PHPShopModules;

    // �������� ������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));


    $action = $PHPShopOrm->delete(array('id'=>'='.$_POST['newsID']));
    return $action;
}


// ������� ����������
function actionUpdate() {
    global $PHPShopOrm,$PHPShopModules;

    // �������� ������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));

    if($_POST['clean_st']==1) {
        $_POST['count_all_new']='0';
        $_POST['count_today_new']='0';
    }

    $action = $PHPShopOrm->update($_POST,array('id'=>'='.$_POST['newsID']));
    return $action;
}



if(($UserChek->statusPHPSHOP < 2) or ($UserChek->statusPHPSHOP == 3)) {

// ����� ����� ��� ������
    $PHPShopGUI->setAction($_GET['id'],'actionStart','none');

// ��������� ������� 
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();
?>
