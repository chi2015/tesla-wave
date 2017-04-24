<p><br></p>

<div align="right">
<strong>См. также:</strong><br>
<a href="/doc/license.html" title="Лицензионное соглашение">&raquo; Лицензионное соглашение</a><br>
<a href="/doc/phpshop-response.html" title="Отзывы клиентов PHPShop">&raquo; Отзывы клиентов PHPShop</a><br>
<a href="/doc/design.html" title="Редактирование дизайна">&raquo; Редактирование дизайна</a><br>
<a href="/skin/" title="База бесплатных шаблонов PHPShop">&raquo; База бесплатных шаблонов PHPShop</a><br>
<a href="/doc/test.html" title="Подключение HTML файлов">&raquo; Подключение HTML файлов</a><br>
<a href="/phptest/" title="Подключение PHP логики">&raquo; Подключение PHP логики</a><br>
<a href="/coretest/" title="Подключение PHP логики через API">&raquo; Подключение PHP логики через API</a>
</div>
<p>
<h1>Подключение HTML файлов</h1>
Исходник этого файла расположен по адресу: /pageHTML/test.php<br>
Возможно использование только HTML тегов.<br>
Для создания php логики используйте файлы в папке <a href="/phptest/" title="Создание php логики">/page/phptest.php</a>

<h1>Для чего это нужно?</h1>
Не всегда удобно создавать страницу во встроенном редакторе, намного удобнее создавать  в специализированных html редакторах, а потом подключать к сайту.
</p>

<h1>Как создать страницу?</h1>
В редакторе создать страницу, например, newstest.php и сохранить ее в папку /pageHTML/.
Итоговый адрес страницы будет: имя_сайта/doc/newstest.html.
</p>
<p>
<h1>Meta заголовки для файла</h1>
Добавить свои заголовки можно в файле phpshop/core/doc.core.php<br>
В функцию  setMeta нужно добавить запись:<br>
<ul>
<pre>
    // Настройка титлов
    function setMeta() {
        $this->meta=array(
                'license'=>'Лицензионное соглашение',
                'design'=>'Редактирование дизайна',
                'test'=>'Подключение HTML файлов'
        );
    }
</pre></ul>
</p>
