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
$PHPShopGUI->title="�������������� ���������� �����";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name14']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// ��������� �����
function setSelectChek($n) {
    $i=1;
    while($i<=10) {
        if($n==$i) $s="selected"; else $s="";
        $select[]=array($i,$i,$s);
        $i++;
    }
    return $select;
}


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

// �������
    $data = $PHPShopOrm->select(array('*'),array('id'=>'='.$_GET['id']));
    extract($data);

    if($flag==1) $fl="checked";
    else $fl2="checked";

    if($element==0) $s1="selected";
    else $s2="selected";

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";


// ����������� ��������� ����
    $PHPShopGUI->setHeader("�������������� ���������� �����","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_select_another_account_med[1].gif");

// �������� 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('content_new') ;
    $oFCKeditor->Height = '320';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value = $content;


    $Select1=setSelectChek($num);

    $Select2[]=array("�����",0,@$s1);
    $Select2[]=array("������",1,@$s2);

// ���������� �������� 1
    $Tab1=$PHPShopGUI->setField("��������:",$PHPShopGUI->setInput("text","name_new",$name,"none",300).$PHPShopGUI->setRadio("flag_new",1,"����������",@$fl,"left").$PHPShopGUI->setRadio("flag_new",0,"������",@$fl2),"left").
            $PHPShopGUI->setField("�������:",$PHPShopGUI->setSelect("num_new",$Select1,50,1),"left",5).
            $PHPShopGUI->setField("������������:",$PHPShopGUI->setSelect("element_new",$Select2,100,1),"none",5).
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("�������� � ��������:",$PHPShopGUI->setInput("text","dir_new",$dir,"left",500),"none");

// ���������� �������� 2
    $Tab2=$oFCKeditor->AddGUI();

// ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,350),array("��������",$Tab2,350));

    // ������ ������ �� ��������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data));

// ����� ������ ��������� � ����� � �����
    $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("button","","������","right",70,"return onCancel()","but").
            $PHPShopGUI->setInput("button","delID","�������","right",70,"return onDelete('".__('�� ������������� ������ �������?')."')","but","actionDelete").
            $PHPShopGUI->setInput("submit","editID","��","right",70,"","but","actionUpdate");


// �����
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
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



