<?php

class PHPShopShop extends PHPShopCore {

    /**
     * Конструктор
     */
    function PHPShopShop() {

        // Список экшенов
        $this->action = array("nav" => array("CID", "ID"));

        parent::PHPShopCore();

        // Настройка модуля
        $this->system();
        $this->PHPShopConnectXML = new PHPShopConnectXML($this->data['domain']);
        $this->PHPShopConnectXML->key = $this->data['url_key'];
    }

    function navigation($name) {
        $dis = null;
        $spliter = ParseTemplateReturn($this->getValue('templates.breadcrumbs_splitter'));
        $home = ParseTemplateReturn($this->getValue('templates.breadcrumbs_home'));

        $post = $this->PHPShopConnectXML->query('table_name', 'select', 'id,name,parent_to', 'id=' . intval($this->catalog_parent));
        $xml = $this->PHPShopConnectXML->send($post);
        $db = $this->PHPShopConnectXML->readxml($xml);
        if (is_array($db)) {
            foreach ($db as $v) {
                $dis.= $spliter . '<A href="/' . $this->PHPShopNav->getPath() . '/CID_' . $v['id'] . '_' . PHPShopString::toLatin($v['name']) . '.html">' . $v['name'] . '</a>';
            }
        }

        $dis = $home . $dis . $spliter . '<b>' . $name . '</b>';
        $this->set('breadCrumbs', $dis);
    }

    /**
     * Настройка модуля 
     */
    function system() {
        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['catalog']['catalog_system']);
        $this->data = $PHPShopOrm->select();
    }

    /**
     * Стоимость
     */
    function price($price, $baseinputvaluta) {
        $price = $price * $_SESSION['option']['valuta'][$baseinputvaluta]['kurs'];
        return number_format($price, $this->number_format, ".", "");
    }

    function CID() {
        $dis = null;
        if (PHPShopSecurity::true_num($GLOBALS['SysValue']['nav']['id'])) {

            // Данные каталога
            $post = $this->PHPShopConnectXML->query('table_name', 'select', 'id,name,parent_to', 'id=' . intval($GLOBALS['SysValue']['nav']['id']), 'num');
            $xml = $this->PHPShopConnectXML->send($post);
            $db = $this->PHPShopConnectXML->readxml($xml);
            if (is_array($db)) {
                $this->catalog_name = $db[0]['name'];
                $this->catalog_parent = $db[0]['parent_to'];
            }


            $post = $this->PHPShopConnectXML->query('table_name', 'select', 'id,name,parent_to', 'parent_to=' . intval($GLOBALS['SysValue']['nav']['id']), 'num');
            $xml = $this->PHPShopConnectXML->send($post);
            $db = $this->PHPShopConnectXML->readxml($xml);

            // Если каталоги
            if (is_array($db)) {
                foreach ($db as $row) {
                    $this->set('catalogName', $row['name']);
                    $this->set('catalogId', $row['id']);
                    $this->set('catalogtLatName', PHPShopString::toLatin($row['name']));
                    $dis.=parseTemplateReturn($GLOBALS['SysValue']['templates']['catalog']['catalog_forma'], true);
                }

                $this->set('catalogShopList', $dis);
                $dis = parseTemplateReturn($GLOBALS['SysValue']['templates']['catalog']['catalog_list'], true);
            }
            // Если товары
            else {

                $post = $this->PHPShopConnectXML->query('table_name2', 'select', 'id,name,price,pic_small,pic_big,baseinputvaluta,description', 'category=' . $GLOBALS['SysValue']['nav']['id'] . ' and enabled="1"', 'num', $this->data['limit']);
                $xml = $this->PHPShopConnectXML->send($post);
                $db = $this->PHPShopConnectXML->readxml($xml);

                if (is_array($db)){
                    foreach ($db as $row) {
                        $this->set('productName', $row['name']);
                        $this->set('productId', $row['id']);
                        $this->set('productValutaName', $_SESSION['option']['money']);
                        $this->set('productLatName', PHPShopString::toLatin($row['name']));
                        $this->set('productImg', 'http://' . $this->data['domain'] . $row['pic_small']);
                        $this->set('productImgBigFoto', 'http://' . $this->data['domain'] . $row['pic_big']);
                        $this->set('productPrice', $this->price($row['price'], $row['baseinputvaluta']));
                        $this->set('productDescription', $row['description']);
                        $dis.=ParseTemplateReturn($GLOBALS['SysValue']['templates']['catalog']['product_forma_list'], true);
                    }
                }   else return $this->setError404();
            }

            // Мета
            $this->title = $this->catalog_name . ' - ' . $this->PHPShopSystem->getValue("name");


            if ($xml == 'Login error!')
                $dis = PHPShopText::notice(__('Ошибка подключения, проверьте параметры доступа!'));

            // Определяем переменные
            $this->set('pageContent', $dis);
            $this->set('pageTitle', $this->catalog_name);


            // Навигация
            $this->navigation($this->catalog_name);

            // Подключаем шаблон
            $this->parseTemplate($this->getValue('templates.page_page_list'));
        } else
            $this->setError404();
    }

    function ID() {

        if (PHPShopSecurity::true_num($GLOBALS['SysValue']['nav']['id'])) {
            $post = $this->PHPShopConnectXML->query('table_name2', 'select', 'id,name,price,pic_small,pic_big,content,category', 'id=' . $GLOBALS['SysValue']['nav']['id'] . ' and enabled="1"');
            $xml = $this->PHPShopConnectXML->send($post);
            $db = $this->PHPShopConnectXML->readxml($xml);
            if (is_array($db)) {
                foreach ($db as $row) {
                    $this->set('productName', $row['name']);
                    $this->set('productId', $row['id']);
                    $this->set('productImg', 'http://' . $this->data['domain'] . $row['pic_big']);
                    $this->set('productPrice', $row['price']);
                    $this->set('productContent', $row['content']);
                    $dis = ParseTemplateReturn($GLOBALS['SysValue']['templates']['catalog']['product_forma_full'], true);
                }

                // Мета
                $this->title = $row['name'] . ' - ' . $this->PHPShopSystem->getValue("name");


                // Данные каталога
                $post = $this->PHPShopConnectXML->query('table_name', 'select', 'id,name,parent_to', 'id=' . intval($row['category']), 'num');
                $xml = $this->PHPShopConnectXML->send($post);
                $db = $this->PHPShopConnectXML->readxml($xml);
                if (is_array($db)) {
                    $this->catalog_name = $db[0]['name'];
                    $this->catalog_parent = $db[0]['id'];
                }


                // Навигация
                $this->navigation($row['name']);

                // Определяем переменные
                $this->set('pageContent', $dis);
                $this->set('pageTitle', $row['name']);

                // Подключаем шаблон
                $this->parseTemplate($this->getValue('templates.page_page_list'));
            }
            else
                $this->setError404();
        }
        else
            $this->setError404();
    }

}

?>