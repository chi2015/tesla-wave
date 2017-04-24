<?
$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("orm");
PHPShopObj::loadClass("admgui");


$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

$PHPShopSystem = new PHPShopSystem();

// Локализация
PHPShopObj::loadClass("lang");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "xhtml11.dtd">
<html>
    <head>
        <title><?=__('Выбор каталога');?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=<?=$GLOBALS['PHPShopLangCharset']?>">
        <LINK href="../skins/<?=$PHPShopSystem->getSerilizeParam("admoption.theme")?>/texts.css" type="text/css" rel="stylesheet">
        <LINK href="../skins/<?=$PHPShopSystem->getSerilizeParam("admoption.theme")?>/dtree.css" type=text/css rel=stylesheet>
        <SCRIPT language=JavaScript src="../java/dtree4.js" type="text/javascript"></SCRIPT>
        <script>

            if(parent.window.hs)
            exp = parent.window.hs.getExpander();

            function doAction(name,cat){
                var winOpenType = '<?=$_COOKIE['winOpenType'];?>';

                switch (winOpenType) {

                    case 'highslide':
                        exp.iDoc.getElementById('parent_name').value=name;
                        if(exp.iDoc.getElementById('parent_to_new'))
                            exp.iDoc.getElementById('parent_to_new').value=cat;
                        else exp.iDoc.getElementById('category_new').value=cat;
                        return parent.window.hs.close();
                        break;

                    default:
                        window.opener.document.getElementById('parent_name').value=name;
                        if(window.opener.document.getElementById('parent_to_new'))
                            window.opener.document.getElementById('parent_to_new').value=cat;
                        else window.opener.document.getElementById('category_new').value=cat;

                        window.close(null);
                        return false;
                        break;

                }

            }

        </script>
    </head>

    <body bottommargin="0" leftmargin="5" topmargin="0" rightmargin="5" bgcolor="#ffffff">
        <div align="center" style="padding:5px"><a href="javascript: window.d.openAll();"><?=__('Развернуть все');?></a> | <a href="javascript: window.d2.closeAll();"><?=__('Свернуть все');?></a></div>
        <table cellpadding="0" cellspacing="0" bgcolor="ffffff" style="border: 2px;border-style: inset;" width="100%" height="300">
            <tr>
                <td valign="top">
                    <?
                    // Дерево каталогов
                    $CatalogTree = &new CatalogTree($GLOBALS['SysValue']['base']['table_name']);
                    $CatalogTree->addcat(0,-1,'Корень');
                    $CatalogTree->addcat(3000,0,'Меню','../img/imgfolder.gif');
                    $CatalogTree->addcat(1000,3000,'Главное меню сайта','Главное меню сайта');
                    $CatalogTree->addcat(2000,3000,'Начальная страница','Начальная страница');
                    $CatalogTree->create();
                    $CatalogTree->disp();
                    ?>
                </td>
            </tr>
        </table>
        <div align="center" style="padding:5px"><a href="javascript: window.d.openAll();"><?=__('Развернуть все');?></a> | <a href="javascript: window.d.closeAll();"><?=__('Свернуть все');?></a></div>
    </body>
</html>