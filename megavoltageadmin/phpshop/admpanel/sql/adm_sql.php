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
$PHPShopGUI->title="������ � �����";
$PHPShopGUI->reload = "right";

// SQL
PHPShopObj::loadClass("orm");

// ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");


// �������
function getComand() {
    global $PHPShopGUI,$SysValue;
    $bases2='';
    $bases='';

    while (list($val) = each($SysValue['base'])) {

        if($SysValue['base'][$val] != "phpshop_system")
            if($SysValue['base'][$val]!="phpshop_users")
                if(!is_array($SysValue['base'][$val])) {
                    $bases2.="TRUNCATE ".$SysValue['base'][$val].";
                     "; 
                    $bases.=$SysValue['base'][$val].", ";
                }
    }

    $bases=substr($bases,0,strlen($bases)-2);

    $value[]=array('������� ������� SQL','','selected');
    $value[]=array('�������������� ����','OPTIMIZE TABLE '.$bases,false);
    $value[]=array('�������� ����','REPAIR TABLE '.$bases,false);
    $value[]=array('������� �������','DELETE FROM '.$table_name.' WHERE ID=',false);
    $value[]=array('�������� ����',$bases2,false);

    return $PHPShopGUI->setSelect('sql_query',$value,200,'left',false,'SelectQuerySql(this.value)');
}

function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="500,450";

    // ����������� ��������� ����
    $PHPShopGUI->setHeader("������ � �����","������� ������� ��� SQL",$PHPShopGUI->dir."img/i_website_tab[1].gif");

    // ���������� �������� 1
    if($_POST['send']) {
        $IdsArray=split(";\r",$_POST['sql_area']);
        foreach ($IdsArray as $v)
            $result=mysql_query($v);
        if(@$result) $disp= "
> <b>MySQL</b>: ".$_POST['sql_area']."<br><br>
> <b>MySQL: ������ ��������.</b>";
        else $disp="
> <b>MySQL</b>: ".mysql_error()."";
        $Tab1=$PHPShopGUI->setInfo($disp,200);
        $ContentFooter=
                $PHPShopGUI->setInput("button","","�������","right",70,"return onCancel();","but");
    }
    else {
        $Tab1=$PHPShopGUI->setTextarea('sql_area',$disp,false,'98%','200px');
        $Tab1.=getComand();
        $Tab1.='   '.$PHPShopGUI->setLink('adm_sql_file.php','�������� SQL �����','_self');
        $ContentFooter=
                $PHPShopGUI->setInput("button","","������","right",70,"return onCancel();","but").
                $PHPShopGUI->setInput("submit","send","��","right",70,"","but");
    }




    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,250));

    // ������ ������ �� ��������
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data));

    // �����
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

if($UserChek->statusPHPSHOP < 2) {

    // ����� ����� ��� ������
    $PHPShopGUI->setLoader(false,'actionStart');

    // ��������� �������
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();

?>