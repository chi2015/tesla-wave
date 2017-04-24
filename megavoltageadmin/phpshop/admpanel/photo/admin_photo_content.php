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
    $PHPShopInterface->size="670,630";
    $PHPShopInterface->imgPath="../img/";

    if($_COOKIE['winOpenType'] == 'highslide')
        $PHPShopInterface->link="photo/adm_photoID.php";
    else $PHPShopInterface->link="../photo/adm_photoID.php";
    
    $PHPShopInterface->header=true;
    $PHPShopInterface->dir='../';
    $PHPShopInterface->setCaption(array("&plusmn;","5%"),array("Иконка","30%"),array("Название","60%"));

    if(!PHPShopSecurity::true_num($_GET['id'])) $_GET['id']=0;

    $sql='select * from '.$GLOBALS['SysValue']['base']['table_name23'].' where category='.$_GET['pid'].' order by num';
    $result=mysql_query($sql);
    while (@$row = mysql_fetch_array($result)) {
        $id=$row['id'];
        $PID=$row['PID'];
        $name=$row['name'];
        $info=$row['info'];
        if(($row['enabled'])=="1") {
            $checked="<img name=imgLang src=../img/icon-activate.gif name=imgLang  alt=\"В наличии\">";
        }else {
            $checked="<img src=../img/icon-deactivate.gif name=imgLang  alt=\"Отсутствует\">";
        };

        $picname=str_replace(".","s.",$row['name']);
        $img='<IMG SRC="'.$picname.'" align="left">';
        $content=''.$info.'</strong><br>'.$name;



        $PHPShopInterface->setRow($id,$checked,$img,$content);
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
    <body bottommargin="0" rightmargin="0" topmargin="0" leftmargin="0" bgcolor="ffffff">
        <?
         // Вывод формы при старте
        $PHPShopInterface->setLoader(false,'actionStart');
        ?>
</body>
</html>

