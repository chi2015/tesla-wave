<?php

/**
 * Обработчик первой страницы
 * @author PHPShop Software
 * @version 1.0
 * @package PHPShopCore
 */
class PHPShopIndex extends PHPShopCore {

    /**
     * Конструктор
     */
    function PHPShopIndex() {
        // Имя Бд
        $this->objBase=$GLOBALS['SysValue']['base']['table_name11'];
        $this->debug=false;

        // Шаблон главной страницы
        $this->template='templates.index';
        parent::PHPShopCore();
    }


    /**
     * Экшен по умолчанию
     */
    function index() {
        global $PHPShopModules;

        // Выборка данных
        $row=parent::getFullInfoItem(array('*'),array('category'=>"=2000",'enabled'=>"='1'"));

        // Определяем переменные
        $this->set('mainContent',Parser($row['content']));
        $this->set('mainContentTitle',$row['name']);

        // Перехват модуля
        $PHPShopModules->setHookHandler(__CLASS__,__FUNCTION__, $this, $row);

    }
}
?>