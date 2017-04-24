<?php
$_classPath = "../";
include($_classPath . "class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("xml");
PHPShopObj::loadClass("admgui");
PHPShopObj::loadClass("orm");
PHPShopObj::loadClass("date");
PHPShopObj::loadClass("security");

$PHPShopBase = new PHPShopBase($_classPath . "inc/config.ini");
$PHPShopBase->chekAdmin();

// Системные настройки
$PHPShopSystem = new PHPShopSystem();

// Редактор GUI
$PHPShopInterface = new PHPShopInterface();
$PHPShopInterface->winOpenType = $PHPShopSystem->getSerilizeParam("admoption.wintype");
$PHPShopIcon = new PHPShopIcon();


define("PATH", "http://www.phpshop.ru/update/update3.php?server=" . $_SERVER["SERVER_NAME"] . "&from=cms&version=" . $SysValue['upload']['version']);
define("TIME_LIMIT", 600);

$RegTo = $SysValue['license']['regto'];
$ProductName = $SysValue['license']['product_name'];
$ProductNameVersion = $SysValue['license']['product_name'] . " (" . __('сборка') . " " . $SysValue['upload']['version'] . ")";


// Проверяем на root
if ($_SESSION['logPHPSHOP'] == "root" and $_SESSION['pasPHPSHOP'] == "cm9vdA==" and !getenv("COMSPEC"))
    $rootNote = "rootNote()";
else
    $rootNote = "";


// Проверяем update
$support_status = false;
if (!getenv("COMSPEC") and function_exists("xml_parser_create") and !$_SESSION['chekUpdate'])
    if (@$db = readDatabase(PATH, "update")) {

        foreach ($db as $k => $v) {
            if ($db[$k]['name'] > $SysValue['upload']['version'])
                $support_status = $db[$k]['status'];
        }

        // Отключаем проверку обновлений для текущей сессии
        $_SESSION['chekUpdate'] = true;
    }


// Регистрируем тему
$_SESSION['theme'] = $PHPShopSystem->getSerilizeParam("admoption.theme");
if (empty($_SESSION['theme']))
    $_SESSION['theme'] = 'classic';

// Регистрируем оконный менеджер
setcookie("winOpenType", $PHPShopSystem->getSerilizeParam("admoption.wintype"), time() + 60 * 60 * 24 * 30, "/phpshop/", $_SERVER['SERVER_NAME'], 0);
$_SESSION['winOpenType'] = $PHPShopSystem->getSerilizeParam("admoption.wintype");

// Регистрируем язык
$_SESSION['lang'] = $PHPShopSystem->getSerilizeParam("admoption.lang");
PHPShopObj::loadClass("lang");

// Подключение JS меню модулей
function CreateModulesMenu() {
    global $PHPShopIcon;
    $sql = "select path from " . $GLOBALS['SysValue']['base']['table_name2'];
    $result = mysql_query($sql);

    while ($row = mysql_fetch_array($result)) {
        $path = $row['path'];
        $menu = "../modules/" . $path . "/install/module.xml";
        @$data = implode("", file($menu));
        if (@$db = readDatabase($data, "adminmenu", false)) {
            $DIR = "../modules/" . $path . "/install/";
            @$dis_js.='
	  stm_aix("p1i1","p1i0",[0,"' . $db[0]['title'] . '","","",-1,-1,0,"","_self","","","img/arrow_r.gif","",7,7]);
      stm_bp("p2",[1,2,-1,0,3,3,18,0,100,"",-2,"",-2,100,2,2,"#000000",MenuColor,"",3,1,1,"#666666"]);';

            // JS меню
            $podmenu = readDatabase($data, "podmenu", false);
            foreach ($podmenu as $val)
                @$dis_js.='
stm_aix("p2i0","p1i0",[0,"' . $val['podmenu_name'] . '","","",-1,-1,0,"' . $val['podmenu_action'] . '","_self","","","' . $DIR . $val['podmenu_icon'] . '","' . $DIR . $val['podmenu_icon'] . '",16,16]);
	  ';
            @$dis_js.='stm_ep();';

            // Иконки
            $icon = readDatabase($data, "menu", false);



            if (is_array($icon)) {
                foreach ($icon as $val)
                    $IconTab.= $PHPShopIcon->setIcon("../modules/" . $path . "/install/" . $val['menu_icon'], $val['menu_name'], $val['menu_action']);
            }
        }
    }
    $disp = '
stm_aix("p0i1","p0i0",[1,"' . __('Модули') . '&nbsp;&nbsp;","","",-1,-1,0,"","_self","","","","",5,20]);
stm_bp("p1",[1,4,-1,0,3,3,16,0,100,"",-2,"",-2,100,2,2,"#000000",MenuColor,"",3,1,1,"#666666 #878480 #666666 #666666"]);
stm_aix("p10i1","p2i0",[0,"' . __('Скачать модули') . '","","",-1,-1,0,"http://www.phpshopcms.ru/module/","_blank","","","icon/databases_arrow.png","icon/databases_arrow.png"]);
stm_aix("p10i1","p2i0",[0,"' . __('Обзор доступных модулей') . '","","",-1,-1,0,"?p=modules","_self","","","icon/plugin.gif","icon/plugin.gif"]);
stm_aix("p10i1","p2i0",[0,"' . __('Регистрация модулей') . '","","",-1,-1,0,"javascript:miniWin(\'modules/adm_modreg.php\',510,460)","_self","","","icon/key.png","icon/key.png"]);
' . @$dis_js . '
stm_ep();
stm_ep();
';
    if (is_array($icon))
        $IconTab = $PHPShopIcon->setBorder() . $IconTab;
    return array($disp, $IconTab);
}

// Загружаем файл обработчика
if (!empty($_GET['p'])) {
    $fileLoad = $_GET['p'] . "/admin_" . $_GET['p'] . ".php";
    if (file_exists($fileLoad) and $UserChek->statusPHPSHOP < 2)
        require($fileLoad);
}
elseif (!empty($_GET['plugin'])) {

    $option = explode("/", $_GET['plugin']);
    if (is_array($option) and !empty($option[1]) and !strstr('.', $option[1]))
        $fileLoad = "../modules/" . $option[0] . "/admpanel/admin_" . $option[1] . ".php";
    else
        $fileLoad = "../modules/" . $_GET['plugin'] . "/admpanel/admin_" . $_GET['plugin'] . ".php";

    if (file_exists($fileLoad) and $UserChek->statusPHPSHOP < 2)
        require($fileLoad);
}
else
    require("catalog/admin_catalog.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "xhtml11.dtd">
<html>
    <head>
        <title><?= $ProductName . " -> " . __('Панель управления') . " -> " . $TitlePage; ?></title>
        <META http-equiv=Content-Type content="text/html; charset=<?= $GLOBALS['PHPShopLangCharset'] ?>">
            <META name="engine-copyright" content="PHPShop.ru">
                <LINK href="skins/<?= $_SESSION['theme'] ?>/dateselector.css" type="text/css" rel=stylesheet>
                    <script language="JavaScript1.2" src="java/phpshop.js" type="text/javascript"></script>

                    <?
                    if ($PHPShopSystem->getSerilizeParam("admoption.wintype") == "highslide") {
                        echo '<script type="text/javascript" src="java/highslide/highslide-full.packed.js"></script>
        <link rel="stylesheet" type="text/css" href="java/highslide/highslide.css" />
        <script type="text/javascript">
            hs.graphicsDir = "java/highslide/graphics/";
            hs.outlineType = "rounded-windows";
            hs.wrapperClassName = "draggable-header";
            hs.showCredits = false;
            hs.headingText = "<em style=\'font-weight:normal;font-size:10px\'>' . __('Администрирование') . ' > ' . addslashes($PHPShopSystem->getParam("name")) . '</em>";
            hs.dimmingOpacity = 0.5;
            hs.dimmingDuration = 50;
        </script>';
                    }
                    ?>

                    <LINK href="skins/<?= $PHPShopSystem->getSerilizeParam("admoption.theme") ?>/texts.css" type=text/css rel=stylesheet>
                        <script type="text/javascript" language="JavaScript1.2"  src="java/popup_lib.js"></script>
                        <script type="text/javascript" language="JavaScript1.2" src="java/stm31.js"></script>
                        <script type="text/javascript" language="JavaScript1.2" src="java/dateselector.js"></script>
                        <script type="text/javascript">

                            // Проверка пароля root
<?= $rootNote; ?>

                            winOpenType = '<?= $PHPShopSystem->getSerilizeParam("admoption.wintype") ?>';

                            // На весь экран
                            window.moveTo(0, 0);
                            window.resizeTo(screen.availWidth, screen.availHeight);

                            // Проверка обновлений
                            function ChekUpdate(flag) {
                                var update = "<?= $support_status; ?>";
                                var version = "<?= $SysValue['upload']['version']; ?>";
                                var path = "<?= PATH ?>";
                                var soft = "<?= $SysValue['license']['product_name'] ?>";
                                var cookieValue = GetCookie('update');
                                if (update == 'active') {
                                    window.status = "<?= __('Внимание! Доступно обновление для'); ?> " + soft + " " + version;
                                    if (!cookieValue | flag == "true")
                                        if (confirm("<?= __('Доступно обновление для'); ?> " + soft + " " + version + "\n\n<?= __('Для установки обновления запустите утилиту Updater из пакета EasyControl для Windows. Загрузить EasyControl с сервера разработчика?'); ?>")) {
                                            window.open("http://www.phpshopcms.ru/version/setup_cms.exe");
                                        }
                                }
                                else if (flag == "true")
                                    alert("<?= __('Для'); ?> " + soft + " " + version + " <?= __('обновления отсутствуют.'); ?>");
                            }

                        </script>
                        </head>
                        <body  <?= $onload ?> >
                            <table cellpadding="0" cellpadding="0" class="iconlist">
                                <tr>
                                    <td>
                                        <script type="text/javascript" language="JavaScript1.2" src="skins/<?= $PHPShopSystem->getSerilizeParam("admoption.theme") ?>/menu.js"></script>
                                        <script>
                                            // Основное меню
<?
include('java/menu.php');
?>


                                            // Модули
<?
$CreateModulesMenu = CreateModulesMenu();
echo $CreateModulesMenu[0];
?>


                                            // Дописываем меню
                                            stm_aix("p0i8", "p0i1", [1, "<?= __('Дополнительно'); ?>&nbsp;&nbsp;&nbsp; "]);
                                            stm_bpx("p13", "p3", []);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('Форум CMS Free'); ?>", "", "", -1, -1, 0, "javascript:window.open('http://forum.phpshopcms.ru/')", "_self", "", "", "icon/icon_info.gif", "icon/icon_info.gif"]);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('Бесплатные шаблоны для сайта'); ?>", "", "", -1, -1, 0, "javascript:window.open('http://www.phpshopcms.ru/doc/skins.html')", "_self", "", "", "icon/icon_info.gif", "icon/icon_info.gif"]);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('Скрипт Интернет-магазина'); ?> PHPShop Pro 1C", "", "", -1, -1, 0, "javascript:window.open('http://www.phpshop.ru/docs/product5.html')", "_self", "", "", "icon/icon_info.gif", "icon/icon_info.gif"]);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('Скрипт Интернет-магазина'); ?> PHPShop Enterprise", "", "", -1, -1, 0, "javascript:window.open('http://www.phpshop.ru/docs/product.html')", "_self", "", "", "icon/icon_info.gif", "icon/icon_info.gif"]);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('Скрипт Интернет-магазина'); ?> PHPShop Start", "", "", -1, -1, 0, "javascript:window.open('http://www.phpshop.ru/docs/product2.html')", "_self", "", "", "icon/icon_info.gif", "icon/icon_info.gif"]);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('Персональный дизайн с установкой в CMS'); ?>", "", "", -1, -1, 0, "javascript:window.open('http://www.phpshop.ru/docs/service.html#1')", "_self", "", "", "icon/icon_info.gif", "icon/icon_info.gif"]);
                                            stm_ep();
                                            stm_aix("p0i7", "p0i1", [1, "&nbsp;<?= __('Cправка'); ?>&nbsp;&nbsp;"]);
                                            stm_bpx("p12", "p4", []);
                                            stm_aix("p12i1", "p4i1", [0, "<?= __('Новости'); ?>", "", "", -1, -1, 0, "http://www.phpshop.ru/news/", "_self", "", "", "icon/book_next.gif", "icon/book_next.gif"]);
                                            stm_aix("p12i2", "p4i1", [0, "<?= __('Наличие обновления'); ?>", "", "", -1, -1, 0, "javascript:ChekUpdate('true')", "_self", "", "", "icon/wand.gif", "icon/wand.gif"]);
                                            stm_aix("p12i4", "p4i1", [0, "<?= __('О программе'); ?>", "", "", -1, -1, 0, "javascript:miniWin('about/adm_about.php',700,550)", "_self", "", "", "icon/image.gif", "icon/image.gif"]);
                                            stm_aix("p13i0", "p2i0", [0, "<?= __('Авторизация'); ?>", "", "", -1, -1, 0, "javascript:window.close()", "_self", "", "", "icon/door.gif", "icon/door.gif"]);
                                            stm_aix("p13i1", "p2i0", [0, "<?= __('Домой'); ?>", "", "", -1, -1, 0, "javascript:window.open('/')", "_self", "", "", "icon/house.gif", "icon/house.gif"]);
                                            stm_ep();
                                            stm_ep();
                                            stm_em();
                                        </script>
                                    </td>
                                    <td align="right" id="phpshop">
                                        <a href="http://www.phpshop.ru" target="_blank" class="phpshop" title="<?= __('Все права защищены'); ?>©PHPShop.ru">
<?= $ProductNameVersion ?></a>
                                    </td>

                                </tr>
                            </table>
                            <?
                            $Tab1 = $PHPShopIcon->setIcon("icon/open.gif", "Каталог", "window.location.replace('?p=catalog')") .
                                    $PHPShopIcon->setBorder() .
                                    $PHPShopIcon->setIcon("icon/joystick.gif", "Система", "miniWin('system/adm_system.php',510,450)") .
                                    $PHPShopIcon->setIcon("icon/xhtml.gif", "Заголовки", "miniWin('system/adm_system_promo.php',500,600)") .
                                    $PHPShopIcon->setBorder() .
                                    $PHPShopIcon->setIcon("icon/page_lightning.gif", "Новости", "window.location.replace('?p=news')") .
                                    $PHPShopIcon->setIcon("icon/photo_album.gif", "Фотогалереи", "window.location.replace('?p=photo')") .
                                    $PHPShopIcon->setIcon("icon/page_refresh.gif", "Банеры", "window.location.replace('?p=banner')") .
                                    $PHPShopIcon->setIcon("icon/page_attach.gif", "Блоки", "window.location.replace('?p=menu')") .
                                    $PHPShopIcon->setIcon("icon/page_error.gif", "Отзывы", "window.location.replace('?p=gbook')") .
                                    $PHPShopIcon->setIcon("icon/comments.gif", "Рассылка", "window.location.replace('?p=news_writer')") .
                                    $PHPShopIcon->setIcon("icon/page_link.gif", "Ссылки", "window.location.replace('?p=links')") .
                                    $PHPShopIcon->setIcon("icon/page_edit.gif", "Опросы", "window.location.replace('?p=opros')") .
                                    $PHPShopIcon->setIcon("icon/rss.gif", "RSS каналы", "window.location.replace('?p=rssgraber')") .
                                    $PHPShopIcon->setIcon("icon/plugin.gif", "Модули", "window.location.replace('?p=modules')");

                            // Модули
                            $Tab1.=$CreateModulesMenu[1];

                            $Tab1.=$PHPShopIcon->setBorder() .
                                    $PHPShopIcon->setIcon("icon/database_key.gif", "SQL", "miniWin('sql/adm_sql.php',500,450)") .
                                    $PHPShopIcon->setIcon("icon/database_save.gif", "Создание резевной копи", "miniWin('dumper/dumper.php',500,500)") .
                                    $PHPShopIcon->setBorder();

                            // Обновление
                            if ($support_status == "active" and $SysValue['update']['chek_enabled'] == "true")
                                $Tab1.=$PHPShopIcon->setIcon("icon/update.gif", "Доступно обновление", "ChekUpdate('true')");

                            $Tab1.=$PHPShopIcon->setIcon("icon/door.gif", "Авторизация", "window.close()") .
                                    $PHPShopIcon->setIcon("icon/house.gif", "Сайт", "window.open('../../')");

                            // Дополнительный блок справа
                            if (!empty($addTab))
                                $Tab1.=$addTab;

                            $PHPShopIcon->setTab($Tab1);
                            $PHPShopIcon->Compile();

                            // Вывод
                            $PHPShopInterface->setLoader(false, 'actionStart');
                            ?>
                        </body>
                        </html>