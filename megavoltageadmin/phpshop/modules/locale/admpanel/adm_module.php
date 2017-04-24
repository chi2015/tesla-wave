<?
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
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.locale.locale_system"));


// ������� ����������
function actionUpdate() {
    global $PHPShopOrm;

    if(empty($_POST['skin_enabled_new'])) $_POST['skin_enabled_new']=0;

    $action = $PHPShopOrm->update($_POST);
    return $action;
}


// ����� �������
function GetSkins($skin) {
    global $SysValue,$PHPShopGUI;
    $dir="../../../templates";
    if (is_dir($dir)) {
        if (@$dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {

                if($skin == $file)
                    $sel="selected";
                else $sel="";

                if($file!="." and $file!=".." and $file!="index.html")
                    $value[]=array($file,$file,$sel);
            }
            closedir($dh);
        }
    }

    return $PHPShopGUI->setSelect('skin_new',$value,150,false,'������ 2-�� �����: ');
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
    $PHPShopGUI->setHeader("��������� ������ 'Locale'","���������",$PHPShopGUI->dir."img/i_display_settings_med[1].gif");
    
    // ���������� �������� 1
    $Tab1=$PHPShopGUI->setInputText('�������� �����: ','name_new',$name);
    $Tab1.=GetSkins($skin);
    $Tab1.=$PHPShopGUI->setCheckbox('skin_enabled_new',1,'������������',$skin_enabled);


    $Tab3=$PHPShopGUI->setPay($serial,false);
    
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


