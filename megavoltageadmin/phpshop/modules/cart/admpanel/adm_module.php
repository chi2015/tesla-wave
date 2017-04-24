<?php

$_classPath = "../../../";
include($_classPath . "class/obj.class.php");
PHPShopObj::loadClass("base");
PHPShopObj::loadClass("system");
PHPShopObj::loadClass("security");
PHPShopObj::loadClass("orm");

$PHPShopBase = new PHPShopBase($_classPath . "inc/config.ini");
include($_classPath . "admpanel/enter_to_admin.php");


// Настройки модуля
PHPShopObj::loadClass("modules");
$PHPShopModules = new PHPShopModules($_classPath . "modules/");


// Редактор
PHPShopObj::loadClass("admgui");
$PHPShopGUI = new PHPShopGUI();

// SQL
$PHPShopOrm = new PHPShopOrm($PHPShopModules->getParam("base.cart.cart_system"));

// Функция обновления
function actionUpdate() {
    global $PHPShopOrm;

// Копируем базу товаров
    $_FILES['file']['ext'] = PHPShopSecurity::getExt($_FILES['file']['name']);
    if ($_FILES['file']['ext'] == "csv") {
        if (move_uploaded_file($_FILES['file']['tmp_name'], "../../../../UserFiles/Price/" . $_FILES['file']['name']))
            $_POST['filedir_new'] = $_FILES['file']['name'];
    }

// Копируем базу каталога
    $_FILES['catalog']['ext'] = PHPShopSecurity::getExt($_FILES['catalog']['name']);
    if ($_FILES['catalog']['ext'] == "csv") {
        if (move_uploaded_file($_FILES['catalog']['tmp_name'], "../../../../UserFiles/Price/" . $_FILES['catalog']['name']))
            $_POST['catdir_new'] = $_FILES['catalog']['name'];
    }

    if (empty($_POST['enabled_new']))
        $_POST['enabled_new'] = 0;
    if (empty($_POST['enabled_market_new']))
        $_POST['enabled_market_new'] = 0;
    if (empty($_POST['enabled_search_new']))
        $_POST['enabled_search_new'] = 0;
    if (empty($_POST['enabled_speed_new']))
        $_POST['enabled_speed_new'] = 0;

    $PHPShopOrm->debug = false;
    $action = $PHPShopOrm->update($_POST);
    return $action;
}

function actionStart() {
    global $PHPShopGUI, $PHPShopSystem, $_classPath, $PHPShopOrm, $PHPShopModules;


    $PHPShopGUI->dir = $_classPath . "admpanel/";
    $PHPShopGUI->title = "Настройка модуля Cart";
    $PHPShopGUI->size = "500,500";


// Выборка
    $data = $PHPShopOrm->select();
    @extract($data);

    if ($enabled == 1)
        $enabled = "checked"; else
        $enabled = "";
    if ($enabled_market == 1)
        $enabled_market = "checked"; else
        $enabled_market = "";

    // Графический заголовок окна
    $PHPShopGUI->setHeader("Настройка модуля 'Cart'", "Настройки файловой базы", $PHPShopGUI->dir . "img/i_display_settings_med[1].gif");

    // Создаем объекты для формы
    $ContentField1 =
            $PHPShopGUI->setInput("file", "file", "", "left", 350) .
            $PHPShopGUI->setInput("button", "button1", "Скачать", "left", 70, "window.open('../../../../UserFiles/Price/" . $filedir . "')") .
            $PHPShopGUI->setLine() .
            $PHPShopGUI->setLink($href = "../install/price.csv", 'Скачать пример файла базы', $target = '_blank', $style = false);

    $ContentField3 =
            $PHPShopGUI->setInput("file", "catalog", "", "left", 350) .
            $PHPShopGUI->setInput("button", "button1", "Скачать", "left", 70, "window.open('../../../../UserFiles/Price/" . $catdir . "')") .
            $PHPShopGUI->setLine() .
            $PHPShopGUI->setLink($href = "../install/catalog.csv", 'Скачать пример файла каталога', $target = '_blank', $style = false);


    $ContentField2 = $PHPShopGUI->setInputText("E-mail: ", "email_new", $email, 200, ' *для заказов');
    $ContentField2.=$PHPShopGUI->setInputText("Валюта: ", "valuta_new", $valuta, 50);

    $ContentField2.=$PHPShopGUI->setTextarea("message_new", $message, "none", "97%", 70);

    // Содержание закладки 1
    $Tab1 = $PHPShopGUI->setField("База файлов: /UserFiles/Price/" . $filedir . "", $ContentField1);
    $Tab1.=$PHPShopGUI->setField("База каталога: /UserFiles/Price/" . $catdir . "", $ContentField3);
    $Tab1.=$PHPShopGUI->setField("Заказ", $ContentField2);


    $Tab2 = $PHPShopGUI->setCheckbox("enabled_speed_new", 1, "Обработка базы товаров только в прайсе (увеличение скорости работы
        остальных страниц) ", $enabled_speed);
    $Tab2.=$PHPShopGUI->setLine();
    $Tab2.=$PHPShopGUI->setCheckbox("enabled_market_new", 1, "Вывод страниц в столбик с кнопкой заказа", $enabled_market);
    $Tab2.=$PHPShopGUI->setLine();
    $Tab2.=$PHPShopGUI->setCheckbox("enabled_new", 1, "Вывод корзины на сайте", $enabled);
    $Tab2.=$PHPShopGUI->setLine();
    $Tab2.=$PHPShopGUI->setCheckbox("enabled_search_new", 1, "Вывод товаров только при поиске", $enabled_search);
    $Tab2.=$PHPShopGUI->setInputText("Пагинация: ", "num_new", $num, 50, ' *позиций на странице в прайсе');

    // Содержание закладки 2
    $Info = 'Для работы модуля требуется создать текстовый файл с ячейками информации, содержащие данные по файлам.

Пример содержания файла базы товаров:

ID;Артикул;Наименование;Цена;Категория
page1;prod1;Елка;100;1
page2;prod2;Дед мороз;1000;1
page3;prod3;Снегурочка;1500;2

где:
ID  - ИД товара или ссылка на страницу
Категория - ID категории из файла каталога товаров

Пример содержания файла каталога товаров:

ID;Наименование
1;Игрушки
2;Напитки


Шаблоны:
Для вывода формы корзины на сайте разместите переменную @miniCart@ в шаблонах index.tpl и shop.tpl в нужном вам месте.
Переменная @miniCart@ автоматически дописывается в начало левого текстового блока. Если вам нужно разместить ее в другом месте, то снимите галочку
"Вывод корзины на сайте" и впишите переменную @miniCart@ в ручном режиме.

Прайс-лист доступен: http://' . $_SERVER['SERVER_NAME'] . '/price/
Форма заказа:  http://' . $_SERVER['SERVER_NAME'] . '/order/

Для добавления ссылку на прайс-лист в главное меню создайте новую страницу в главном меню с ссылкой ../price/price

Шаблон формы заказа находится в файле phpshop/modules/cart/templates/order_forma.tpl
Для добавления новых полей в форму заказа просто добавьте новые поля в этот файл.

При включенной опции "Вывод страниц в столбик" блок генерации списка категорий будет переделан под формат ссылки market и
страницы в каталоге будут отображаться в столбик. При формате файла в виде ссылок в поле артикул, страницы имеющие такую ссылку, будут
выведены с дополнительной информацией по цене и кнопкой добавления в корзину.

Для произвольного включения формы добавления в корзину нужно снять галочку "Вывод страниц в столбик" и для нужных страниц в поле описания
добавить запись @php $Product = new ProductDisp(3); php@, где 3 - это ID товара в файле базы.
';
    $Tab3 = $PHPShopGUI->setTextarea("", $Info, "left", '98%', 300);

    $rent = $PHPShopGUI->setImage('../install/shopbuilder.jpg', 262, 95, 'left') . '<b>Готовый магазин на 
        платформе PHPShop Enterprise</b><br>
Аренда готового интернет-магазина через 10 минут после регистрации. 
Переход с аренды интернет-магазина в любой момент на полную пожизненную лицензию с сохранением всех данных магазина. 

<h2>Протестируйте аренду интернет-магазина в течении 45 дней бесплатно!</h2>
Вы можете бесплатно протестировать все возможности PHPShop Enterprise, создав аккаунт за несколько минут.
' .$PHPShopGUI->setButton('Создать аккаунт сейчас', '../install/icon.gif', 250, 30, "none", "javascript:window.open('https://user.shopbuilder.ru/users/register')");

    $Tab4 = $PHPShopGUI->setInfo($rent, false, '97%');

    $Tab5 = $PHPShopGUI->setPay($serial);

    // Вывод формы закладки
    $PHPShopGUI->setTab(array("Основное", $Tab1, 310), array("Опции", $Tab2, 310), array("Описание", $Tab3, 310), array("Аренда", $Tab4, 310), array("О Модуле", $Tab5, 310));




    // Вывод кнопок сохранить и выход в футер
    $ContentFooter =
            $PHPShopGUI->setInput("hidden", "newsID", $id, "right", 70, "", "but") .
            $PHPShopGUI->setInput("button", "", "Отмена", "right", 70, "return onCancel();", "but") .
            $PHPShopGUI->setInput("submit", "editID", "ОК", "right", 70, "", "but", "actionUpdate");

    $PHPShopGUI->setFooter($ContentFooter);
    return true;
}

if ($UserChek->statusPHPSHOP < 2) {

// Вывод формы при старте
    $PHPShopGUI->setLoader($_POST['editID'], 'actionStart');

// Обработка событий 
    $PHPShopGUI->getAction();
}else
    $UserChek->BadUserFormaWindow();
?>