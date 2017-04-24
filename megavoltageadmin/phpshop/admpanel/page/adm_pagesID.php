<?

$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();
$PHPShopSystem = new PHPShopSystem();


// �������� GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="�������������� �������";
$PHPShopGUI->reload = "right";

// SQL
PHPShopObj::loadClass("orm");
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name11']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopModules,$PHPShopOrm;

    // ��� ����
    if($_COOKIE['winOpenType'] == 'default')
        $dot=".";
    else $dot=false;

    // �������
    $data = $PHPShopOrm->select(array('*'),array('id'=>'='.$_GET['id']));
    extract($data);


    if ($data['skin_enabled']==1) $skin_enabled="checked"; else $skin_enabled="";


    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="650,630";


    // ����������� ��������� ����
    $PHPShopGUI->setHeader('�������������� "'.$name.'"',
            __('������: ').$PHPShopGUI->setLink('http://'.$_SERVER['SERVER_NAME'].'/page/'.$link.'.html','http://'.$_SERVER['SERVER_NAME'].'/page/'.$link.'.html'),$PHPShopGUI->dir."img/i_website_tab[1].gif");

    // �������� 1
    $PHPShopGUI->setEditor($PHPShopSystem->getSerilizeParam("admoption.editor"));
    $oFCKeditor = new Editor('content_new') ;
    $oFCKeditor->Height = '420';
    $oFCKeditor->Config['EditorAreaCSS'] = $_classPath."../templates".chr(47).$PHPShopSystem->getParam("skin").chr(47).$SysValue['css']['default'];
    $oFCKeditor->ToolbarSet = 'Normal';
    $oFCKeditor->Value		= $content ;


    // ���������� �������� 1
    $Tab1=$PHPShopGUI->setField("�������:",$PHPShopGUI->setInput("text","parent_name",Disp_cat($category),"left",450).
            $PHPShopGUI->setInput("hidden","category_new",$category,"left",450).
            $PHPShopGUI->setButton("�������","../icon/folder_edit.gif","100px","�������","none","miniWin('".$dot."./catalog/adm_cat.php?category=".$category."',300,400);return false;"),"none").
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("���������:",$PHPShopGUI->setInput("text","name_new",$name,"left",400),"left").
            $PHPShopGUI->setField("������� ������:",$PHPShopGUI->setInput("text","num_new",$num,"left",50),"none",5).
            $PHPShopGUI->setLine().
            $PHPShopGUI->setField("������:",$PHPShopGUI->setInput("text","link_new",$link,"left",400),"left");

    $SelectValue[]=array('����� � ��������',1,$enabled);
    $SelectValue[]=array('�������������',0,$enabled);
    $SelectValue[]=array('���������� ��������',2,$enabled);

    $Tab1.= $PHPShopGUI->setField("�����:",$PHPShopGUI->setSelect("enabled_new",$SelectValue,150),"none",5);

    // ���������� �������� 2

    $Tab2=$oFCKeditor->AddGUI();

    // ���������� �������� 3
    $Tab3=$PHPShopGUI->setField("Title: ",$PHPShopGUI->setInputText(false,"title_new",$title,'98%',false,"none",false,'100px'),"none");
    $Tab3.=$PHPShopGUI->setField("Description: ",$PHPShopGUI->setInputText(false,"description_new",$description,'98%',false,"none",false,'100px'),"none");
    $Tab3.=$PHPShopGUI->setField("Keywords: ",$PHPShopGUI->setInputText(false,"keywords_new",$keywords,'98%',false,"none",false,'100px'),"none");

    // ����� ����� ��������
    $PHPShopGUI->setTab(array("����������",$Tab2,450),array("����������",$Tab1,450),array("���������",$Tab3,450));

    // ������ ������ �� ��������
    $PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data);

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


function Disp_cat_pod($category)// ����� ��������� � ������ ������������
{
    $sql="select name from ".$GLOBALS['SysValue']['base']['table_name']." where id='$category'";
    $result=mysql_query($sql);
    $row = mysql_fetch_array($result);
    $name=$row['name'];
    return $name." -> ";
}

function Disp_cat($category)// ����� ��������� � ������
{
    $sql="select name,parent_to from ".$GLOBALS['SysValue']['base']['table_name']." where id=$category";
    $result=mysql_query($sql);
    $row = mysql_fetch_array($result);
    $num = mysql_num_rows($result);
    if($num>0) {
        $name=$row['name'];
        $parent_to=$row['parent_to'];
        $dis=Disp_cat_pod($parent_to).$name;
    }
    elseif($category == 1000) $dis="������� ���� �����";
    elseif($category == 2000) $dis="��������� ��������";
    return $dis;
}

// ������� ����������
function actionSave() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopModules;

    if(empty($_POST['enabled_new'])) $_POST['enabled_new']=0;
    $_POST['date_new']=date('U');
    
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name11']);
    $action = $PHPShopOrm->update($_POST,array('id'=>'='.$_POST['newsID']));
    $PHPShopOrm->clean();

    $_GET['id']=$_POST['newsID'];
    $PHPShopGUI->setAction($_GET['id'],'actionStart','none');
}

// ������� ����������
function actionUpdate() {
    global $PHPShopOrm,$PHPShopModules;

    // �������� ������
    $PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$_POST);

    if(empty($_POST['enabled_new'])) $_POST['enabled_new']=0;
    $_POST['date_new']=date('U');
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
