<?php

/**
 * Обработчик блога
 * @author PHPShop Software
 * @version 1.3
 * @package PHPShopCore
 */
class PHPShopBlog extends PHPShopCore {

    /**
     * Конструктор
     */
    function PHPShopBlog() {
        
        // Имя Бд
        $this->objBase = $GLOBALS['SysValue']['base']['blog']['blog_log'];

        // Путь для навигации
        $this->objPath = "/blog/blog_";

        // Отладка
        $this->debug = false;

        // Список экшенов
        $this->action = array("nav" => "ID");
        parent::PHPShopCore();
        
        // Настройка
        $this->option();
    }

    /**
     * Настройки
     */
    function option() {
        $PHPShopOrm = new PHPShopOrm($GLOBALS['SysValue']['base']['blog']['blog_system']);
        $this->data = $PHPShopOrm->select();
    }

    /**
     * Экшен по умолчанию
     */
    function index() {
        global $PHPShopModules;

        // Выборка данных
        $this->dataArray = parent::getListInfoItem(array('*'), false, array('order' => 'id DESC'));

        // 404
        if (!isset($this->dataArray))
            return $this->setError404();

        if (is_array($this->dataArray))
            foreach ($this->dataArray as $row) {

                // Определяем переменные
                $this->set('newsId', $row['id']);
                $this->set('newsData', $row['date']);
                $this->set('newsZag', $row['title']);

                // Добавлено ниже
                $this->set('newsKratko', $row['description']);

                if (!empty($row['content'])) {
                    $this->set('blogComStart', '');
                    $this->set('blogComEnd', '');
                } else {
                    $this->set('blogComStart', '<!--');
                    $this->set('blogComEnd', '-->');
                }
                // Перехват модуля
                $PHPShopModules->setHookHandler(__CLASS__, __FUNCTION__, $this, $row);

                // Подключаем шаблон
                $this->addToTemplate($this->getValue('templates.main_news_forma'), false, array('news' => 'blog', 'Новости' => $this->data['title']));
            }

        // Пагинатор
        $this->setPaginator();

        // Мета
        $this->title = "Блог - " . $this->PHPShopSystem->getValue("name");

        // Подключаем шаблон
        $this->parseTemplate($this->getValue('templates.news_page_list'), false, array('news' => 'blog', 'Новости' => $this->data['title']));
    }

    /**
     * Пагинация в подробном описании
     * @return string
     */
    function setPaginatorContent() {

        // Расчет записей
        $curId = $this->PHPShopNav->getId();
        $prevId = $curId - 1;
        $nextId = $curId + 1;

        // Проверка записей
        $PHPShopOrm = new PHPShopOrm($this->objBase);
        $PHPShopOrm->Option['where'] = ' or ';
        $PHPShopOrm->debug = $this->debug;
        $PHPShopOrm->sql = 'select id from ' . $this->objBase . ' where id=' . $prevId . ' or id=' . $nextId;
        $row = $PHPShopOrm->select();

        // Проверка на последнюю запись
        if (count($row) == 1)
            $data[0] = $row;
        else
            $data = $row;

        if (is_array($data)) {

            if ($data[0]['id'] == $prevId)
                $navigat = '<a href="./ID_' . $prevId . '.html" title="' . $this->getValue('lang.prev_page') . '">' .
                        $this->getValue('lang.prev_page') . '</a>';
            else
                $navigat = '';

            if ($data[1]['id'] == $nextId)
                $navigat.=' | <a href="./ID_' . $nextId . '.html" title="' . $this->getValue('lang.next_page') . '">' .
                        $this->getValue('lang.next_page') . '</a>';
            else
                $navigat.='';
        }
        return $navigat;
    }

    /**
     * Экшен выборки подробной информации при наличии переменной навигации ID
     * @return string
     */
    function ID() {
        global $PHPShopModules;

        // Безопасность
        if (!PHPShopSecurity::true_num($this->PHPShopNav->getId()))
            return $this->setError404();

        // Выборка данных
        $row = parent::getFullInfoItem(array('*'), array('id' => '=' . $this->PHPShopNav->getId()));

        // 404
        if (!is_array($row))
            return $this->setError404();

        // Определяем переменые
        $this->set('newsData', $row['date']);
        $this->set('newsZag', $row['title']);
        $this->set('newsKratko', $row['description']);
        $this->set('newsPodrob', $row['content']);

        // Пагинатор
        $this->set('paginatorContent', $this->setPaginatorContent());

        // Перехват модуля
        $PHPShopModules->setHookHandler(__CLASS__, __FUNCTION__, $this, $row);

        // Подключаем шаблон
        $this->addToTemplate($this->getValue('templates.main_news_forma_full'), false, array('news' => 'blog', 'Новости' => $this->data['title']));

        // Мета
        $this->title = $row['title'] . " - " . $this->PHPShopSystem->getValue("name");
        $this->description = strip_tags($row['description']);
        $this->lastmodified = PHPShopDate::GetUnixTime($row['date']);

        // Подключаем шаблон
        $this->parseTemplate($this->getValue('templates.news_page_full'), false, array('news' => 'blog', 'Новости' => $this->data['title']));
    }

    function meta() {
        global $PHPShopModules;
        parent::meta();

        // Перехват модуля
        $PHPShopModules->setHookHandler(__CLASS__, __FUNCTION__, $this);
    }

}

?>