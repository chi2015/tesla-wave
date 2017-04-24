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
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.seourl.seourl_system"));

// �������������� �������� � ��������
function setLatin($str) {
    $str=strtolower($str);
    $str=str_replace("/", "", $str);
    $str=str_replace("\\", "", $str);
    $str=str_replace("(", "", $str);
    $str=str_replace(")", "", $str);
    $str=str_replace(":", "", $str);
    $str=str_replace(" ", "-", $str);
    $str=str_replace("\"", "", $str);
    $str=str_replace(".", "", $str);
    $str=str_replace("�", "", $str);
    $str=str_replace("�", "", $str);
    $str=str_replace("�", "", $str);
    $str=str_replace("�", "", $str);

    $_Array=array(
            "�"=>"a",
            "�"=>"b",
            "�"=>"v",
            "�"=>"g",
            "�"=>"d",
            "�"=>"e",
            "�"=>"e",
            "�"=>"zh",
            "�"=>"z",
            "�"=>"i",
            "�"=>"i",
            "�"=>"k",
            "�"=>"l",
            "�"=>"m",
            "�"=>"n",
            "�"=>"o",
            "�"=>"p",
            "�"=>"r",
            "�"=>"s",
            "�"=>"t",
            "�"=>"u",
            "�"=>"f",
            "�"=>"h",
            "�"=>"c",
            "�"=>"ch",
            "�"=>"sh",
            "�"=>"sh",
            "�"=>"y",
            "�"=>"e",
            "�"=>"uy",
            "�"=>"ya",
            "�"=>"a",
            "�"=>"b",
            "�"=>"v",
            "�"=>"g",
            "�"=>"d",
            "E"=>"e",
            "�"=>"e",
            "�"=>"gh",
            "�"=>"z",
            "�"=>"i",
            "�"=>"i",
            "�"=>"k",
            "�"=>"l",
            "�"=>"m",
            "�"=>"n",
            "�"=>"o",
            "�"=>"p",
            "�"=>"r",
            "�"=>"s",
            "�"=>"t",
            "�"=>"u",
            "�"=>"f",
            "�"=>"h",
            "�"=>"c",
            "�"=>"ch",
            "�"=>"sh",
            "�"=>"sh",
            "�"=>"e",
            "�"=>"uy",
            "�"=>"ya",
            "."=>"",
            ","=>"",
            "$"=>"i",
            "%"=>"i",
            "&"=>"and");

    $chars = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);

    foreach($chars as $val)
        if(empty($_Array[$val])) @$new_str.=$val;
        else $new_str.=$_Array[$val];

    return $new_str;
}

// ������������� ����� ��������� ����
function setGenerationPhoto() {
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name22']);
    $data = $PHPShopOrm->select(array('id','name'),false,false,array('limit'=>1000));
    
    if(is_array($data))
      foreach($data as $val){
        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name22']);
        $array['seoname_new']=setLatin($val['name']);
        $PHPShopOrm->update($array,array('id'=>'='.$val['id']));
    }
          
}

// ������������� ����� ���������
function setGeneration() {
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name']);
    $data = $PHPShopOrm->select(array('id','name'),false,false,array('limit'=>1000));
    
    if(is_array($data))
      foreach($data as $val){
        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name']);
        $array['seoname_new']=setLatin($val['name']);
        $PHPShopOrm->update($array,array('id'=>'='.$val['id']));
    }
          
}

// ������������� ����� ��������
function setGenerationNews() {
    $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name8']);
    $data = $PHPShopOrm->select(array('id','title'),false,false,array('limit'=>1000));

    if(is_array($data))
      foreach($data as $val){
        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['table_name8']);
        $array['seo_name_new']=setLatin($val['title']);
        $PHPShopOrm->update($array,array('id'=>'='.$val['id']));
    }

}


// ������� ����������
function actionUpdate() {
    global $PHPShopOrm;
    
    // ������������� �����
    if(!empty($_POST['generation'])) setGeneration();
    if(!empty($_POST['generationnews'])) setGenerationNews();
    if(!empty($_POST['generationphoto'])) setGenerationPhoto();
    
    $action = $PHPShopOrm->update($_POST);
    return $action;
}


function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm;
    
    
    $PHPShopGUI->dir=$_classPath."admpanel/";
    $PHPShopGUI->title="��������� ������";
    $PHPShopGUI->size="500,450";
    
    
    // �������
    $data = $PHPShopOrm->select();
    @extract($data);
    
    
    // ����������� ��������� ����
    $PHPShopGUI->setHeader("��������� ������ 'SeoUrl'","���������",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");
    
    // ������� ������� ��� �����
    $ContentField1=$PHPShopGUI->setCheckbox("generation",1,"��������� ������������� ��������� SeoUrl ����� �������� �� �������� ����� ���������.",false);
    $ContentField1.=$PHPShopGUI->setLine();
    $ContentField1.=$PHPShopGUI->setCheckbox("generationnews",1,"��������� ������������� ��������� SeoUrl ����� �������� �� �������� ���������� ��������.",false);
    $ContentField1.=$PHPShopGUI->setLine();
    $ContentField1.=$PHPShopGUI->setCheckbox("generationphoto",1,"��������� ������������� ��������� SeoUrl ����� �������� �� �������� ����� ����-���������.",false);
    
    // ���������� �������� 1
    $Tab1=$PHPShopGUI->setField("�������������",$ContentField1);
    
    $Tab3=$PHPShopGUI->setPay($serial);
    
    // ����� ����� ��������
    $PHPShopGUI->setTab(array("��������",$Tab1,270),array("� ������",$Tab3,270));
    
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