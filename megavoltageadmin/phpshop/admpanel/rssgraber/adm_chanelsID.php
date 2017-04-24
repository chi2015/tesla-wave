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
$PHPShopGUI->title="�������������� ������ RSS";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name24']);

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
   
    if($enabled) $fl="checked"; else $fl2="checked";

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="400,480";
    $PHPShopGUI->includeJava='<SCRIPT language="JavaScript" src="../java/popup_lib.js"></SCRIPT>
    <SCRIPT language="JavaScript" src="../java/dateselector.js"></SCRIPT>';
    $PHPShopGUI->includeCss='<LINK href="../skins/'.$_SESSION['theme'].'/dateselector.css" type=text/css rel=stylesheet>';

    // ����������� ��������� ����
    $PHPShopGUI->setHeader("�������������� ������ RSS","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_subscription_med[1].gif");



    $Select1=setSelectChek($day_num);


    $DateField='<div style="padding:10"><span name=txtLang id=txtLang>�&nbsp;&nbsp;</span>
<input type="text" name="start_date_new" id="start_date_new"  maxlength="10" value="'.date( "d-m-Y",$start_date).'" style="width:80px;">
<IMG onclick="popUpCalendar(this, product_edit.start_date_new, \'dd-mm-yyyy\');" height=16 hspace=3 src="../icon/date.gif" width=16 border=0 align="absmiddle">
<span name=txtLang id=txtLang>��</span>
<input type="text" name="end_date_new"  maxlength="10" value="'.date( "d-m-Y",$end_date).'" style="width:80px;" >
<IMG onclick="popUpCalendar(this, product_edit.end_date_new, \'dd-mm-yyyy\');" height=16 hspace=3 src="../icon/date.gif" width=16 border=0 align="absmiddle"></div>';

    // ���������� �������� 1
    $Tab1=$PHPShopGUI->setField("����� �����:",$PHPShopGUI->setInput("text","link_new",$link,"none",300),"none").
            $PHPShopGUI->setField("������ � ����:",$PHPShopGUI->setSelect("day_num_new",$Select1,50),"left",5).
            $PHPShopGUI->setField("���-�� ������� �� ���:",$PHPShopGUI->setInput("text","news_num_new",$news_num,"left",100),"none",5).
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("���� ������ (dd-mm-yyyy):",$DateField,"none").
            $PHPShopGUI->setField("������:",$PHPShopGUI->setRadio("enabled_new",1,"��������",@$fl,"left").$PHPShopGUI->setRadio("enabled_new",0,'���������',@$fl2),"none");



    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,300));

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

// ������� ����������
function actionUpdate() {
    global $PHPShopOrm,$PHPShopModules;

    // �������� ������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST));

    $_POST['link_new'] = mysql_escape_string($_POST['link_new'])  ;
    $_POST['news_num_new'] = intval($_POST['news_num_new']);
    if ($_POST['news_num_new'] == "" || $_POST['news_num_new'] == 0) $_POST['news_num_new']=1;
    $tm_date = explode("-",ereg_replace("[^0-9\-]","",$_POST['start_date_new']));
    $_POST['start_date_new'] = strtotime("$tm_date[2]-$tm_date[1]-$tm_date[0]");
    $tm_date = explode("-",ereg_replace("[^0-9\-]","",$_POST['end_date_new']));
    $_POST['end_date_new'] = strtotime("$tm_date[2]-$tm_date[1]-$tm_date[0]");
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