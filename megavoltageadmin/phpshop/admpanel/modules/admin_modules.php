<?php

$TitlePage=__("������");


// �������� ��� ��������
if(!empty($_POST['moduleAction'])) {

    switch($_POST['moduleAction']) {
        case("off"):

            PHPShopObj::loadClass("modules");
            $PHPShopModules = new PHPShopModules($_classPath."modules/");
            $ModValue=$PHPShopModules->getModValue();

            // �������� ����
            if(is_array($ModValue['base'][$_POST['moduleId']]))
            foreach($ModValue['base'][$_POST['moduleId']] as $val) mysql_query("DROP TABLE ".$val);

            // �������� �����
            if(is_array($ModValue['field'][$_POST['moduleId']]))
            foreach($ModValue['field'][$_POST['moduleId']] as $key=>$val) mysql_query("ALTER TABLE `".$val."` DROP `".$key."` ");

            $sql="delete from ".$GLOBALS['SysValue']['base']['table_name2']." where path='".$_POST['moduleId']."'";
            $result=mysql_query($sql);
            header("Location: ./admin.php?p=modules");
            break;

        case("on"):
        // ���������� �� ������
            $Info = GetModuleInfo($_POST['moduleId']);
            $sql="INSERT INTO ".$GLOBALS['SysValue']['base']['table_name2']."  VALUES ('".$_POST['moduleId']."','".$Info ['name']."','".date("U")."')";
            $result=mysql_query($sql);

            // ������������� �� ������
            $modulePath="../modules/".$_POST['moduleId']."/install/module.sql";
            if(file_exists($modulePath)) {
                $moduleSQLFile=file_get_contents($modulePath);
                $SQLArray=explode(";",$moduleSQLFile);
                foreach($SQLArray as $val) $result=mysql_query($val);
                header("Location: ./admin.php?p=modules");
            }
            break;
    }
}


// ���������� �� ������
function GetModuleInfo($name) {
    $path="../modules/".$name."/install/module.xml";
    if(function_exists("xml_parser_create")) {
        if(@$db=readDatabase($path,"module"))
            return $db[0];
    }
}

function ChekInstallModule($path) {
    $sql="select * from ".$GLOBALS['SysValue']['base']['table_name2']." where path='$path'";
    $result=mysql_query($sql);
    $row = mysql_fetch_array($result);
    if(mysql_num_rows($result)>0) {
        $return[0]="#C0D2EC";
        $return[1]= "
<form method=\"post\" name=\"module_$path\">
<input type=\"hidden\" name=\"moduleId\" value=\"$path\">
<input type=\"hidden\" name=\"moduleAction\" value=\"off\">
<BUTTON style=\"width: 10em; height: 2.2em; margin-left:5\"  onclick=\"module_$path.submit()\">
<img src=\"img/icon-deactivate.gif\" border=\"0\" align=\"absmiddle\">
".__('���������')."
</BUTTON>
</form>
                ";
        $return[2]=$row['date'];
    }
    else {
        $return[0]="white";
        $return[1]= "
<form method=\"post\" name=\"module_$path\">
<input type=\"hidden\" name=\"moduleId\" value=\"$path\">
<input type=\"hidden\" name=\"moduleAction\" value=\"on\">
<BUTTON style=\"width: 10em; height: 2.2em; margin-left:5\"  onclick=\"module_$path.submit()\">
<img src=\"img/icon-activate.gif\"  border=\"0\" align=\"absmiddle\">
".__('����������')."
</BUTTON>
</form>";
        $return[2]="";
    }
    return $return;
}

function actionStart() {
    global $PHPShopInterface;
    $PHPShopInterface->razmer="height:600px;";

    $PHPShopInterface->setCaption(array("����������","10%"),array("��������","20%"),array("��������","50%"),array("�����������","10%"),array("����������","10%"));

    $path="../modules/";
    $i=1;
    if (@$dh = opendir($path)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != "." && $file != "..") {

                if(is_dir($path.$file)) {

                    // ���������� �� ������
                    $Info = GetModuleInfo($file);
                   
                    $ChekInstallModule=ChekInstallModule($file);
                    // ���� ���������
                    if(!empty($ChekInstallModule[2])) $InstallDate=date("d-m-y H:s",$ChekInstallModule[2]);
                    else $InstallDate="";

                    $ModuleHomePage='<img src="'.$path.$file.'/install/'.$Info['icon'].'" align="absmiddle">
<a href="http://phpshopcms.ru/module/?id='.$Info['base'].'" target="_blank" title="'.__('�������� ���������').': http://phpshopcms.ru/module/?id='.$Info['base'].'" class="blue">'.$Info['name'].' '.$Info['version'].'</a>';
                    $PHPShopInterface->setRow($i,$ChekInstallModule[1],$ModuleHomePage,$Info['description'],$InstallDate,"phpshop/modules/".$file);
                    $i++;
                }
            }
        }
        closedir($dh);
    }
    $PHPShopInterface->Compile();
}


?>
