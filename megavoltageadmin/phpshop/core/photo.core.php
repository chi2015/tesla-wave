<?php

/**
 * Обработчик фото галереи
 * @author PHPShop Software
 * @version 1.2
 * @package PHPShopCore
 */
class PHPShopPhoto extends PHPShopCore {

    /**
     * @var Int  Кол-во фото в длину
     */
    var $ilim = 4;

    /**
     * Конструктор
     */
    function PHPShopPhoto() {

        // Кол-во фото на странице
        $num_row = 30;

        // Имя Бд
        $this->objBase = $GLOBALS['SysValue']['base']['table_name23'];

        // Отладка
        $this->debug = false;

        // Список экшенов
        $this->action = array("nav" => "CID");

        // Массив для обработки хлебных крошек
        $this->navigationArray = 'CatalogPhoto';

        // БД для хлебных крошек
        $this->navigationBase = 'base.table_name22';
        parent::PHPShopCore();

        $this->page = $GLOBALS['SysValue']['nav']['page'];
        if (strlen($this->page) == 0)
            $this->page = 1;

        $this->num_row = $num_row;
    }

    /**
     * Экшен по умолчанию, заглушка
     */
    function index() {

        // Подключаем шаблон ошибки
        $this->parseTemplate($this->getValue('templates.error_page_forma'));
    }

    /**
     * Экшен выборки информации при наличии переменной навигации CID
     */
    function CID() {

        // ID категории
        $this->category = PHPShopSecurity::TotalClean($this->PHPShopNav->getId(), 1);
        $this->PHPShopPhotoCategory = new PHPShopPhotoCategory($this->category);
        $this->category_name = $this->PHPShopPhotoCategory->getName();

        $PHPShopOrm = new PHPShopOrm($this->getValue('base.table_name22'));
        $PHPShopOrm->debug = $this->debug;
        $row = $PHPShopOrm->select(array('id,name'), array('parent_to' => "=" . $this->category, 'enabled' => "='1'"), false, array('limit' => 1));

        // Если фото
        if (empty($row['id'])) {

            $this->ListPhoto();
        }
        // Если каталоги
        else {

            $this->ListCategory();
        }
    }

    /**
     * Вывод списка фото
     */
    function ListPhoto() {
        $disp = null;
        $i = 0;

        // Путь для навигации
        $this->objPath = '/photo/CID_' . $this->category . '_';

        // Выборка данных
        $this->dataArray = parent::getListInfoItem(array('*'), array('category' => '=' . $this->category, 'enabled' => "='1'"), array('order' => 'num'));
        if (is_array($this->dataArray))
            foreach ($this->dataArray as $row) {

                $name_s = str_replace(".", "s.", $row['name']);

                // Размер изображения
                $realsize = @getimagesize('http://' . $_SERVER['SERVER_NAME'] . $name_s);

                if (!empty($realsize[0]))
                    $width = 'width="' . $realsize[0] . '"';
                else
                    $width = null;
                if (!empty($realsize[1]))
                    $height = 'height="' . $realsize[1] . '"';
                else
                    $height = null;

                $disp.='<TD valign="top" align="center" style="width:92px;padding:2px;">
 <a class="highslide" onclick="return hs.expand(this)" target="_blank" href="' . $row['name'] . '">
 <img ' . $width . ' ' . $height . ' src="' . $name_s . '" border="0"></a><div class="highslide-caption">' . $row['info'] . '</div>
</TD>';
                if ($i < $this->ilim - 1) {
                    $i++;
                } else {
                    $i = 0;
                    $disp.='</TR><TR>';
                }
            }
        // Если есть описание каталога
        if (empty($this->LoadItems['CatalogPhoto'][$this->category]))
            $content = $this->PHPShopPhotoCategory->getContent();
        elseif (!empty($this->LoadItems['CatalogPhoto'][$this->category]['content_enabled']))
            $content = $this->PHPShopPhotoCategory->getContent();

        $dis = '<script type="text/javascript" src="/highslide/highslide-p.js"></script>
<link rel="stylesheet" type="text/css" href="/highslide/highslide.css" />

<script type="text/javascript">
hs.registerOverlay({
  html: \'<div class="closebutton" onclick="return hs.close(this)" title="Закрыть"></div>\',
  position: \'top right\',
  fade: 2 // fading the semi-transparent overlay looks bad in IE
});


hs.graphicsDir = \'/highslide/graphics/\';
hs.wrapperClassName = \'borderless\';
</script>
<p>' . $content . '<p>
<table border="0" cellspacing="0" cellpadding="0" >
<tr height="94">
' . $disp . '
</tr>
</table>';

        $this->set('pageContent', Parser($dis));
        $this->set('pageTitle', $this->category_name);

        // Пагинатор
        $this->setPaginator();

        // Мета
        $this->title = $this->category_name . " - " . $this->PHPShopSystem->getValue("name");

        // Навигация хлебные крошки
        $this->navigation($row['parent_to'], $this->category_name);

        // Подключаем шаблон
        $this->parseTemplate($this->getValue('templates.page_page_list'));
    }

    /**
     * Вывод списка категорий фото
     */
    function ListCategory() {

        // Выборка данных
        $PHPShopOrm = new PHPShopOrm($this->getValue('base.table_name22'));
        $PHPShopOrm->debug = $this->debug;
        $dataArray = $PHPShopOrm->select(array('name', 'id'), array('parent_to' => '=' . $this->category), array('order' => 'num'), array('limit' => 100));
        if (is_array($dataArray))
            foreach ($dataArray as $row) {
                $dis.=PHPShopText::li($row['name'], "/photo/CID_" . $row['id'] . ".html");
            }

        //$disp="<h1>".$this->category_name."</h1>";

        // Если есть описание каталога
        if (!empty($this->LoadItems['CatalogPhoto'][$this->category]['content_enabled']))
            $disp.=$this->PHPShopPhotoCategory->getContent();

        $disp.=PHPShopText::ul($dis);

        $this->set('pageContent', Parser($disp));
        $this->set('pageTitle', $this->category_name);

        // Мета
        $this->title = $this->category_name . " - " . $this->PHPShopSystem->getValue("name");

        // Навигация хлебные крошки
        $this->navigation($this->category, $this->category_name);

        // Подключаем шаблон
        $this->parseTemplate($this->getValue('templates.page_page_list'));
    }

}

/**
 * Фото галерея
 * Упрощенный доступ к категориями фото галереи
 * @author PHPShop Software
 * @version 1.0
 * @package PHPShopObj
 */
class PHPShopPhotoCategory extends PHPShopObj {

    /**
     * Конструктор
     * @param int $objID ИД категории
     */
    function PHPShopPhotoCategory($objID) {
        $this->objID = $objID;
        $this->objBase = $GLOBALS['SysValue']['base']['table_name22'];
        parent::PHPShopObj();
    }

    /**
     * Выдача имени категории
     * @return string
     */
    function getName() {
        return parent::getParam("name");
    }

    /**
     * Выдача описания категории
     * @return string
     */
    function getContent() {
        return parent::getParam("content");
    }

}

?>