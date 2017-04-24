<?php

$_classPath="../../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("security");
PHPShopObj::loadClass("orm");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
include($_classPath."admpanel/enter_to_admin.php");


// ��������� ������
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");


// ��������
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.timemachine.timemachine_system"));


function actionPageDateUpdate($date) {
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name11']);
    $mysql_affected_rows=0;
    $data=$PHPShopOrm->select(array('id'),false,false,array('limit'=>1000));
    if(is_array($data))
        foreach($data as $row){

        // ���������� ���� ��� ��������
        $page_data=$date+rand(1000,43000);

        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name11']);
        $PHPShopOrm->update(array('date_new'=>$page_data),array('id'=>'='.$row['id']));
        $mysql_affected_rows++;
    }
    return $mysql_affected_rows;
}

// ������ � ������
function actionLogUpdate($numPageUpdate) {
    global $PHPShopModules;
    $PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.timemachine.timemachine_log"));
    $magic_date=$_POST['date']+$_POST['date_formula'];
    $date=time("U");
    $action=$PHPShopOrm->insert(array('date_new'=>$date,'magic_date_new'=>$magic_date,'num_new'=>$numPageUpdate,));
    return $action;
}

// ������� ����������
function actionUpdate() {
    global $PHPShopOrm;
    $PHPShopOrm->debug=false;

    // ���������� ���� �������
    $numPageUpdate=actionPageDateUpdate($_POST['date']+$_POST['date_formula']);

    // ������ � ������
    actionLogUpdate($numPageUpdate);

    $action = $PHPShopOrm->update($_POST);
    return $action;
}




function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm;


    $PHPShopGUI->dir=$_classPath."admpanel/";
    $PHPShopGUI->title="��������� ������ Time Machine";
    $PHPShopGUI->size="600,450";

// �������
    $data = $PHPShopOrm->select();
    @extract($data);

    $Select[]=array("�����",0,$s1);
    $Select[]=array("������",1,$s2);

    // ����������� ��������� ����
    $PHPShopGUI->setHeader("��������� ������ 'Time Machine'","��������� �����������",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");

    $value[]=array('�������',time("U"),false);
    $value[]=array('l ���� �����',(time("U")-(1*86400)),false);
    $value[]=array('2 ��� �����',(time("U")-(2*86400)),false);
    $value[]=array('3 ��� �����',(time("U")-(3*86400)),false);
    $value[]=array('4 ��� �����',(time("U")-(4*86400)),false);
    $value[]=array('5 ���� �����',(time("U")-(5*86400)),false);
    $value[]=array('������ �����',(time("U")-(6*86400)),false);

    $value2[]=array('- ��������� ������ � �������� 6 �����',-(rand(1,5)*rand(1000,86400)),false);
    $value2[]=array('+ 1 ���',(1*86400),false);
    $value2[]=array('+ 2 ����',(2*86400),false);
    $value2[]=array('- 2 ����',-(1*86400),false);
    $value2[]=array('- 1 ���',-(2*86400),false);

    // ������� ������� ��� �����
    $ContentField=$PHPShopGUI->setSelect('date',$value,300);
    $ContentField2=$PHPShopGUI->setSelect('date_formula',$value2,300);

    // ���������� �������� 1
    $Tab1=$PHPShopGUI->setField('���� ��������� �������� �������� ��',$ContentField);
    $Tab1.=$PHPShopGUI->setField('������� ��������� ����',$ContentField2);

    $PHPShopInterface = new PHPShopInterface();
    $PHPShopInterface->size="500,400";
    $PHPShopInterface->window=true;
    $PHPShopInterface->imgPath="../../../admpanel/img/";
    $PHPShopInterface->setCaption(array("���.","10%"),array("���","10%"),array("� ���.","10%"),array("���.","10%"),
            array("� ���.","10%"),array("�������","50%"));
    $PHPShopInterface->setRow(1,10,10,'*','*','*',"/usr/local/bin/php -q /home/shop.ru/phpshop/modules/timemachine/cron/timemachine.php >/dev/null 2>&1");

    $Info='��� ������� ����� �� ���������� ����� ������� Cron ������� ������� ���� � ����������� php � �����-����������� phpshop/modules/timemachine/cron/timemachine.php � ���������
Cron. ��� �������� ������ ������� ������ ���������� �������� ?pas=���_������. ��� ����� ������ �������������� ���� timemachine.php.

������ ������� ������ ���� � 10.10 :';

    $Tab2=$PHPShopGUI->setTextarea("",$Info,"none",'100%',120);
    $Tab2.=$PHPShopInterface->Compile();
    $Tab2.=$PHPShopInterface->setLine('<br>');
    $Tab2.=$PHPShopGUI->setImage('../install/info.gif',16,16).$PHPShopGUI->setLink('http://ru.wikipedia.org/wiki/Cron','���������� �� ������� Cron');

    // ����� �����������
    $Tab3=$PHPShopGUI->setPay($serial);

    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,270),array("��������",$Tab2,270),array("� ������",$Tab3,270));

    // ����� ������ ��������� � ����� � �����
    $ContentFooter=
            $PHPShopGUI->setInput("hidden","newsID",$id,"right",70,"","but").
            $PHPShopGUI->setInput("button","","������","right",70,"return onCancel();","but").
            $PHPShopGUI->setInput("submit","editID","��","right",70,"","but","actionUpdate");

    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

if($UserChek->statusPHPSHOP < 2) {

// ����� ����� ��� ������
    $PHPShopGUI->setLoader($_POST['editID'],'actionStart');

// ��������� ������� 
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();

?>