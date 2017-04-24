<?php

class PHPShopCart extends PHPShopCore {

    function PHPShopCart() {
        $this->action = array("nav" => "index", "post" => "order");
        parent::PHPShopCore();
        $this->system();
    }

    /**
     * Настройка модуля 
     */
    function system() {
        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['catalog']['catalog_system']);
        $this->data=$PHPShopOrm->select();
    }

    function index() {
        $dis = null;
        $sum = 0;
        $num = 0;

        // Парсируем переменные
        $url = parse_url("http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
        $Query = $url["query"];
        $QueryArray = parse_str($Query, $output);

        // Считаем корзину
        if (isset($output['item'])) {
            $_SESSION['CART'][$output['item']] = $_PRODUCT[$output['item']];
            $_SESSION['CART'][$output['item']]['num']++;
            session_register('CART');
        }

        // Операции над корзиной
        switch ($_POST['operation']) {

            case("+"): $_SESSION['CART'][$_POST['cart_id']]['num']++;
                break;

            case("-"): {
                    $_SESSION['CART'][$_POST['cart_id']]['num']--;
                    if ($_SESSION['CART'][$_POST['cart_id']]['num'] <= 0)
                        unset($_SESSION['CART'][$_POST['cart_id']]);
                }
                break;

            case("X"): {
                    unset($_SESSION['CART'][$_POST['cart_id']]);
                }
                break;
        }




        if (count($_SESSION['CART']) > 0) {
            $dis.='<br>
<table cellSpacing="1" cellPadding="3" width="97%" bgColor="#d2d2d2" >
<tr bgColor="#F0F0F0">
	<td><strong>Наименование</strong></td>
	<td width="20"><strong>Шт.</strong></td>
	<td><strong>Цена</strong></td>
	<td width="100"></td>
</tr>
';

            if (is_array($_SESSION['CART']))
                foreach ($_SESSION['CART'] as $key => $val) {
                    $dis.='<tr bgColor="#ffffff">
	<td><a href="' . $GLOBALS['SysValue']['system']['path'] . '/shop/ID_' . $val['id'] . '_' . PHPShopString::toLatin($val['name']) . '.html">' . $val['name'] . '</a></td>
	<td>' . $val['num'] . '</td>
	<td>' . $val['price'] . ' ' . $GLOBALS['LoadItems']['modules']['cart']['valuta'] . '</td>
	<td align="center">
	<form method="post" action="./">
	<input type="hidden" name="cart_id" value="' . $key . '">
	<input type="submit" value="+" style="width:20px;color:green" name="operation" title="Добавить 1 шт.">
	<input type="submit" value="-" style="width:20px;color:red" name="operation" title="Удалить 1 шт.">
	<input type="submit" value="X" style="width:20px" name="operation" title="Удалить из корзины">
	</form>
	</td>
</tr>';
                    @$sum+=$val['price'] * $val['num'];
                    @$num+=$val['num'];
                }

            $dis.='<tr>
    <td colspan="2"><strong>Итого</strong></td>
	<td><strong>' . $num . '</strong></td>
	<td colspan="2"><strong>' . $sum . '</strong> ' . $_SESSION['option']['money'] . '</td>
</tr>
</table>';
        }else
            $dis.='<h4>Корзина</h4>Ваша корзина пуста.';


        // Определяем переменные
        $this->set('pageTitle', 'Корзина');


        if (count($_SESSION['CART']) > 0)
            $dis.='<p><form method="get" action="http://' . $this->data['domain'] . '/order/" name=forma_order">
                <input type="hidden" value="' . $this->cart() . '" name="c">
                <input type="hidden" value="onlineprice" name="from">
                <input type="hidden" value="' . $this->data['partner'] . '" name="partner">
                <input type="button" value="Продолжить покупку" onclick="javascript:history.back(1);">
                <input type="submit" name="order" value="Оформить заказ >"></form></p>';

        // Мета
        $this->title = "Корзина - " . $this->PHPShopSystem->getValue("name");

        // Определяем переменные
        $this->set('pageContent', $dis);
        $this->set('pageTitle', 'Корзина');


        // Подключаем шаблон
        $this->parseTemplate($this->getValue('templates.page_page_list'));
    }

    function cart() {
        $cart = null;
        foreach ($_SESSION['CART'] as $k => $val)
            $cart.='c[' . $k . ']=' . $val['num'] . '&';
        $cart = substr($cart, 0, strlen($cart) - 1);
        return base64_encode(($cart));
    }

}

?>