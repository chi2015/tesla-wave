<?

$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("security");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

$PHPShopSystem = new PHPShopSystem();


// �������� GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="�������� ����� ��������";
$PHPShopGUI->reload = "right";


// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name11']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");



function Disp_cat_pod($category)// ����� ��������� � ������ ������������
{
    global $SysValue;
    $sql="select name from ".$SysValue['base']['table_name']." where id='$category'";
    $result=mysql_query($sql);
    $row = mysql_fetch_array($result);
    @$name=$row['name'];
    return @$name." -> ";
}

function Disp_cat($category)// ����� ��������� � ������
{
    global $SysValue;
    $sql="select name,parent_to from ".$SysValue['base']['table_name']." where id=$category";
    $result=mysql_query($sql);
    @$row = mysql_fetch_array($result);
    @$num = mysql_num_rows($result);
    if($num>0) {
        $name=$row['name'];
        $parent_to=$row['parent_to'];
        $dis=Disp_cat_pod($parent_to).$name;
    }
    elseif($category == 1000) $dis="������� ���� �����";
    elseif($category == 2000) $dis="��������� ��������";
    return @$dis;
}


function GetLastId()// ����� ������
{
    $sql="select id from ".$GLOBALS['SysValue']['base']['table_name11']." order by id desc limit 0, 1";
    $result=mysql_query($sql);
    $row = mysql_fetch_array($result);
    return $row['id'];
}


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopModules;

         // ��� ����
    if($_COOKIE['winOpenType'] == 'default')
        $dot=".";
    else $dot=false;

    if(!PHPShopSecurity::true_num($_GET['catalogID'])) $_GET['catalogID']=null;

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="650,630";

    // ����������� ��������� ����
    $PHPShopGUI->setHeader("�������� ����� ��������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_website_tab[1].gif");

    // �������� 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('content_new') ;
    $oFCKeditor->Height = '420';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= '' ;


    // ���������� �������� 1
    $Tab1=$PHPShopGUI->setField("�������:",$PHPShopGUI->setInput("text","parent_name",Disp_cat($_GET['catalogID']),"left",450).
            $PHPShopGUI->setInput("hidden","category_new",$_GET['catalogID'],"left",450).
            $PHPShopGUI->setButton("�������","../icon/folder_edit.gif","100px","�������","none","miniWin('".$dot."./catalog/adm_cat.php?category=".$category."',300,400);return false;"),"none").
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("���������:",$PHPShopGUI->setInput("text","name_new",$name,"left",400),"left").
            $PHPShopGUI->setField("������� ������:",$PHPShopGUI->setInput("text","num_new",$num,"left",50),"none",5).
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("������:",$PHPShopGUI->setInput("text","link_new","page".GetLastId(),"left",400),"left");
           

    $SelectValue[]=array('����� � ��������',1,1);
    $SelectValue[]=array('�������������',0,'');
    $SelectValue[]=array('���������� ��������',2,'');

    $Tab1.= $PHPShopGUI->setField("�����:",$PHPShopGUI->setSelect("enabled_new",$SelectValue,150),"none",5);

    // ���������� �������� 2
    $Tab2=$oFCKeditor->AddGUI();

    // ���������� �������� 3
    $Tab3=$PHPShopGUI->setField("Title: ",$PHPShopGUI->setInputText(false,"title_new",$title,'98%',false,"none",false,'100px'),"none");
    $Tab3.=$PHPShopGUI->setField("Description: ",$PHPShopGUI->setInputText(false,"description_new",$description,'98%',false,"none",false,'100px'),"none");
    $Tab3.=$PHPShopGUI->setField("Keywords: ",$PHPShopGUI->setInputText(false,"keywords_new",$keywords,'98%',false,"none",false,'100px'),"none");


    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,450),array("����������",$Tab2,450),array("���������",$Tab3,450));

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
    
    $_POST['date_new']=date('U');
    $action = $PHPShopOrm->insert($_POST);
    return $action;
}

if($UserChek->statusPHPSHOP < 2) {

    // ����� ����� ��� ������
    $PHPShopGUI->setLoader($_POST['editID'],'actionStart');

    // ��������� �������
    $PHPShopGUI->getAction();
}
else $UserChek->BadUserFormaWindow();
?>



