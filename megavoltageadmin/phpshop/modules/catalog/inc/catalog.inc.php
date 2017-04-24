<?php

class PHPShopCatalogXML extends PHPShopElements {

    var $number_format = 2;

    function PHPShopCatalogXML() {
        $this->debug = true;
        parent::PHPShopElements();

        // Настройка модуля
        $this->system();

        PHPShopObj::loadClass('string');
        include_once($GLOBALS['SysValue']['class']['connectxml']);
        $this->PHPShopConnectXML = new PHPShopConnectXML($this->data['domain']);
        $this->PHPShopConnectXML->key = $this->data['url_key'];

        
        // Настройки магазина
        if(empty($_SESSION['option']['kurs']))
        $this->option();
    }

    /**
     * Настройка модуля 
     */
    function system() {
        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['catalog']['catalog_system']);
        $this->data = $PHPShopOrm->select();
    }

    function option() {
        $post = $this->PHPShopConnectXML->query('table_name3', 'select', 'kurs');
        $xml = $this->PHPShopConnectXML->send($post);
        $option = $this->PHPShopConnectXML->readxml($xml);

        $_SESSION['option']['kurs'] = $option[0]['kurs'];
        $_SESSION['data'] = $this->data;


        $post = $this->PHPShopConnectXML->query('table_name24', 'select', '*');
        $xml = $this->PHPShopConnectXML->send($post);
        $valuta = $this->PHPShopConnectXML->readxml($xml);

        if (is_array($valuta))
            foreach ($valuta as $val)
                $_SESSION['option']['valuta'][$val['id']] = $val;

        $_SESSION['option']['money'] = $_SESSION['option']['valuta'][$option[0]['kurs']]['code'];
    }

    /**
     * Каталог
     */
    function catalog($num = false) {
        $dis = null;
        $post = $this->PHPShopConnectXML->query('table_name', 'select', 'id,name,parent_to', 'parent_to=0', 'num', $num);
        $xml = $this->PHPShopConnectXML->send($post);
        $db = $this->PHPShopConnectXML->readxml($xml);
        if (is_array($db))
            foreach ($db as $row) {
                $this->set('catalogName', $row['name']);
                $this->set('catalogId', $row['id']);
                $this->set('catalogtLatName', PHPShopString::toLatin($row['name']));
                $dis.=parseTemplateReturn($GLOBALS['SysValue']['templates']['catalog']['catalog_forma'], true);
            }

        if ($xml == 'Login error!')
            $dis = PHPShopText::notice(__('Ошибка подключения, проверьте параметры доступа!'));

        $this->set('leftMenuName', 'Каталог');
        $this->set('leftMenuContent', PHPShopText::ul($dis));
        return $this->parseTemplate($this->getValue('templates.left_menu'));
    }

    /**
     * Стоимость
     */
    function price($price, $baseinputvaluta) {
        $price = $price * $_SESSION['option']['valuta'][$baseinputvaluta]['kurs'];
        return number_format($price, $this->number_format, ".", "");
    }

    function product($cat, $limit = 5, $order = 'RAND()') {
        static $highslide_load;


        $post = $this->PHPShopConnectXML->query('table_name2', 'select', 'id,name,price,pic_small,pic_big,baseinputvaluta,description', 'category=' . $cat . ' and enabled="1"', $order, $limit);
        $xml = $this->PHPShopConnectXML->send($post);
        $db = $this->PHPShopConnectXML->readxml($xml);

        if (empty($highslide_load)) {

            $dis = '<!-- Вывод подключения выплывающих картинок -->
<script type="text/javascript" src="/highslide/highslide-p.js"></script>
<link rel="stylesheet" type="text/css" href="/highslide/highslide.css"/>
<script type="text/javascript">
hs.registerOverlay({html: \'<div class="closebutton" onclick="return hs.close(this)" title="Закрыть"></div>\',position: \'top right\',fade: 2});
hs.graphicsDir = \'/highslide/graphics/\';
hs.wrapperClassName = \'borderless\';
</script>
<!-- Вывод подключения выплывающих картинок -->
';
            $highslide_load = true;
        }

        if (is_array($db))
            foreach ($db as $row) {
                $this->set('productName', $row['name']);
                $this->set('productId', $row['id']);
                $this->set('productValutaName', $_SESSION['option']['money']);
                $this->set('productLatName', PHPShopString::toLatin($row['name']));
                $this->set('productImg', 'http://' . $this->data['domain'] . $row['pic_small']);
                $this->set('productImgBigFoto', 'http://' . $this->data['domain'] . $row['pic_big']);
                $this->set('productPrice', $this->price($row['price'], $row['baseinputvaluta']));
                $this->set('productDescription', $row['description']);
                $dis.=ParseTemplateReturn($GLOBALS['SysValue']['templates']['catalog']['product_forma'], true);
            }

        if ($xml == 'Login error!')
            $dis = PHPShopText::notice(__('Ошибка подключения, проверьте параметры доступа!'));

        $this->set('leftMenuName', 'Рекомендуем');
        $this->set('leftMenuContent', $dis);
        return $this->parseTemplate($this->getValue('templates.left_menu'));
    }

    function add($id, $num = false) {

        if (PHPShopSecurity::true_num($id)) {

            $post = $this->PHPShopConnectXML->query('table_name2', 'select', 'id,name,price,baseinputvaluta', 'id=' . $id . ' and enabled="1"');
            $xml = $this->PHPShopConnectXML->send($post);
            $db = $this->PHPShopConnectXML->readxml($xml);

            if (is_array($db)) {
                $_SESSION['CART'][$id] = $db[0];
                if (PHPShopSecurity::true_num($num))
                    $_SESSION['CART'][$id]['num']+=$num;
                else
                    $_SESSION['CART'][$id]['num']++;
            }
        }
    }

    // Вывод корзины
    function cart() {
        $sum = 0;
        $num = 0;
        if (!empty($_SESSION['CART']) and is_array($_SESSION['CART']))
            foreach ($_SESSION['CART'] as $key => $val) {
                $sum+=$val['price'] * $val['num'];
                $num+=$val['num'];
            }

        $dis = "В корзине: <strong>" . $num . "</strong> шт.<br>";
        $dis.= "Сумма: <strong>" . $sum . "</strong> " . $_SESSION['option']['money'] . "<br>";

        if ($num > 0)
            $dis.= '<p>
	  <form method="get" action="/cart/">
	  <input type="submit" value="Оформить заказ >">
	  </form></p>';

        $this->set('leftMenuName', '<a name="cart"></a>Корзина');
        $this->set('leftMenuContent', $dis);

        $this->set('rightMenu', $this->parseTemplate($this->getValue('templates.right_menu')), true);
    }

    /**
     * Вывод товаров 
     */
    function display() {
        $this->set('leftMenu', $this->catalog($this->data['left']), true);
        $this->set('leftMenu', $this->product($this->data['left'], $this->data['limit_left']), true);
        $this->set('rightMenu', $this->product($this->data['right'], $this->data['limit_right']), true);
    }

}

$PHPShopCatalogXML = new PHPShopCatalogXML();

// Добавление в корзину
if (!empty($GLOBALS['SysValue']['nav']['query']['item']))
    $PHPShopCatalogXML->add($GLOBALS['SysValue']['nav']['query']['item'], $GLOBALS['SysValue']['nav']['query']['nim']);

// Вывод товаров
if ($GLOBALS['SysValue']['nav']['path'] != 'cart') {
    $PHPShopCatalogXML->cart();
    $PHPShopCatalogXML->display();
}
?>