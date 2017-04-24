<?

$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("security");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

// Системные настройки
$PHPShopSystem = new PHPShopSystem();

// Редактор GUI
PHPShopObj::loadClass("admgui");
$PHPShopInterface = new PHPShopInterface();

function actionStart() {
    global $PHPShopInterface;
    $PHPShopInterface->size="850,630";
    $PHPShopInterface->imgPath="../img/";

    if($_COOKIE['winOpenType'] == 'highslide')
        $PHPShopInterface->link="page/adm_pagesID.php";
    else $PHPShopInterface->link="../page/adm_pagesID.php";

    $PHPShopInterface->setCaption(array("&plusmn;","5%"),array("Ссылка","20%"),array("Название","40%"),array("Реальное размещение","30%"));

    if(!PHPShopSecurity::true_num($_GET['pid'])) $_GET['pid']=0;


    if(!empty($_REQUEST['words']))
        $sql="select * from ".$GLOBALS['SysValue']['base']['table_name11']." where name REGEXP'".$_REQUEST['words']."' or link REGEXP'".$_REQUEST['words']."'";
    elseif($_GET['pid']=="all") $sql="select * from ".$GLOBALS['SysValue']['base']['table_name11']." order by name";
    else $sql="select * from ".$GLOBALS['SysValue']['base']['table_name11']." where category=".$_GET['pid'].' order by num';
    $result=mysql_query($sql);
    while (@$row = mysql_fetch_array($result)) {
        $id=$row['id'];
        $name=$row['name'];
        $link=$row['link'];
        
        switch ($row['enabled']) {
            case '0': $checked='<img src="../img/icon-deactivate.gif" title="Блокировка">'; break;
            case '1': $checked='<img name=imgLang src="../img/icon-activate.gif"  title="Показывать">';break;
            case '2': $checked='<img name=imgLang src="../img/icon-move-banner.gif" title="Внутренняя">';break;
        }

        $PHPShopInterface->setRow($id,$checked,$link,$name,"http://".$_SERVER['SERVER_NAME']."/page/".$link.".html");
    }
    $PHPShopInterface->_CODE_ADD_BUTTON=$PHPShopInterface->setInput("hidden","catal",$_GET['pid'],"none",100);
    $PHPShopInterface->Compile();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "xhtml11.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?=$GLOBALS['PHPShopLangCharset']?>">
        <LINK href="../skins/<?=$PHPShopSystem->getSerilizeParam("admoption.theme")?>/texts.css" type=text/css rel=stylesheet>
        <script language="JavaScript1.2" src="../java/phpshop.js" type="text/javascript"></script>
    </head>
    <body bottommargin="0" rightmargin="0" topmargin="0" leftmargin="0" bgcolor="ffffff">

        <?
        // Вывод формы при старте
        $PHPShopInterface->setLoader(false,'actionStart');
        ?>
    </body>
</html>