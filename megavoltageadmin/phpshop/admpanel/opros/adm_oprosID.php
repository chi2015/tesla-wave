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
$PHPShopGUI->title="�������������� ������";

// SQL
$PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name21']);

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");

// ����� �������
function dispFaq($n) {
    global $PHPShopSystem,$SysValue,$_classPath;

    // ��� ����
    if($_COOKIE['winOpenType'] == 'default')
        $dot=false;
    else $dot="./opros/";

    $PHPShopInterface = new PHPShopInterface();
    $PHPShopInterface->size="500,400";
    $PHPShopInterface->window=true;
    $PHPShopInterface->imgPath="../img/";
    $PHPShopInterface->link=$dot."adm_valueID.php";
    $PHPShopInterface->setCaption(array("������� ������","50%"),array("������","10%"),array("�����","10%"));

// �������
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name20']);
    $data = $PHPShopOrm->select(array('SUM(total) as sum'),array('category'=>'='.$n));
    $sum=$data['sum'];

    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name20']);
    $data = $PHPShopOrm->select(array('*'),array('category'=>'='.$n),false,array("limit"=>"1000"));

    if(is_array($data))
        foreach($data as $row) {
            extract($row);
            $PHPShopInterface->setRow($id,$name,$total,@number_format(($total*100)/$sum,"1",".","").'%');
        }

    return $PHPShopInterface->Compile();
}


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

    // ��� ����
    if($_COOKIE['winOpenType'] == 'default')
        $dot=false;
    else $dot="./opros/";


// �������
    $data = $PHPShopOrm->select(array('*'),array('id'=>'='.$_GET['id']));
    extract($data);

    if($flag==1)  $fl="checked"; else  $fl2="checked";

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="630,530";


// ����������� ��������� ����
    $PHPShopGUI->setHeader("�������������� ������","������� ������ ��� ������ � ����.",$PHPShopGUI->dir."img/i_website_statistics_med[1].gif");



// ���������� �������� 1
    $Tab1=
            $PHPShopGUI->setField("���������:",$PHPShopGUI->setTextarea("name_new",$name,"left",'97%','30px'),"none").
            $PHPShopGUI->setField("��������:",$PHPShopGUI->setInput("text","dir_new",$dir,"none",400).$PHPShopGUI->setText("* ������: /page/adres.html,news/. ����� ������� ��������� ������� ����� �������. "),"left",5).
            $PHPShopGUI->setField("�����:",$PHPShopGUI->setRadio("flag_new",1,"��������",@$fl,"none").$PHPShopGUI->setLine().
            $PHPShopGUI->setRadio("flag_new",0,'������',@$fl2),"none");


    $Tab2=dispFaq($id).$PHPShopGUI->setDiv("right",
            $PHPShopGUI->setInput("button","name_new","����� �������","right",150,"miniWin('".$dot."adm_value_new.php?categoryID=".$id."',500,400)").
            $PHPShopGUI->setInput("button","name_new","��������","right",150,"onReload();"));
           
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
