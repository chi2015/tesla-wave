<?
$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

PHPShopObj::loadClass("system");
$PHPShopSystem = new PHPShopSystem();

PHPShopObj::loadClass("security");


// Редактор GUI
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();
$PHPShopGUI->title="Работа с базой";
$PHPShopGUI->reload = "right";

// SQL
PHPShopObj::loadClass("orm");

// Модули
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath."modules/");



function actionStart() {
    global $PHPShopGUI,$PHPShopSystem,$SysValue,$_classPath,$PHPShopOrm,$PHPShopModules;

    $PHPShopGUI->dir="../";
    $PHPShopGUI->size="500,450";

    // Графический заголовок окна
    $PHPShopGUI->setHeader("Работа с базой","Укажите команды для SQL",$PHPShopGUI->dir."img/i_website_tab[1].gif");

    // Содержание закладки 1
    if($_POST['send']) {

        // Расширение
        $_FILES['file']['ext']=PHPShopSecurity::getExt($_FILES['file']['name']);

        if($_FILES['file']['ext']=="sql") {
            if(move_uploaded_file(@$_FILES['file']['tmp_name'], "../csv/".@$_FILES['file']['name']))
            @$fp = fopen("../csv/".$_FILES['file']['name'], "r");
        }
        if ($fp) {
            $fstat = fstat($fp);
            $CsvContent=@fread($fp,$fstat['size']);
            fclose($fp);
        }
        $IdsArray2=split(";\r",$CsvContent);
        while (list($key, $val) = each($IdsArray2))
            $result=mysql_query($val);

        if(@$result) $disp= "><strong> MySQL: запрос выполнен.</strong>";
        else $disp="<strong>> MySQL: </strong>".mysql_error()."";
        $Tab1=$PHPShopGUI->setInfo($disp,200);
        $ContentFooter=
                $PHPShopGUI->setInput("button","","Закрыть","right",70,"return onCancel();","but");
    }
    else {
        $Tab1=$PHPShopGUI->setField('Выберете файл с разширением sql',$PHPShopGUI->setInput('file','file',false,false,400));
        $ContentFooter=
                $PHPShopGUI->setInput("button","","Отмена","right",70,"return onCancel();","but").
                $PHPShopGUI->setInput("submit","send","ОК","right",70,"","but");
    }




    // Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное",$Tab1,250));

    // Запрос модуля на закладку
    if($PHPShopModules->setAdmHandler($_SERVER["SCRIPT_NAME"],__FUNCTION__,$data));

    // Футер
    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

if($UserChek->statusPHPSHOP < 2) {

    // Вывод формы при старте
    $PHPShopGUI->setLoader(false,'actionStart');

    // Обработка событий
    $PHPShopGUI->getAction();

}else $UserChek->BadUserFormaWindow();

?>