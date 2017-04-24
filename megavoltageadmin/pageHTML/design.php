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
<p><h1>Шаблонизатор</h1>
Папка с шаблонами расположена по адресу: <strong>phpshop/templates/имя_шаблона/</strong><br>
Имя текущего шаблона можно узнать в разделе смены шаблонов административной части. Файлы выполнены на языке <strong>HTML</strong>. <br><br>
В файлах шаблонов действует логика: @переменная@ заменяется на результат вывода функции и подставляется в файл. Список основных перемнных расположен <a href="#id7">ниже</a>. 
<p>Начиная с версии 3.0 существует возможность использования <a href="#id8">PHP логики в шаблонах</a> через встроенный парсер.</p>
<pre style="padding:10">
main/index.tpl - Первая страница <strong>(основная правка)</strong>
main/shop.tpl -  Все остальные страницы <strong>(основная правка)</strong>
main/left_menu.tpl -  Шаблон левого текстового блока    
main/right_menu.tpl -  Шаблон правого текстового блока
<br><br>
serach/search_page_list.tpl -  Шаблон список поиска продуктов
<br><br>
news/news_page_list.tpl -  Шаблон страница новостей кратко
news/news_page_full.tpl - Шаблон страница новотсей подробно
news/main_news_forma.tpl -  Шаблон формы новостей кратко
news/main_news_forma_full.tpl - Шаблон формы новостей подробно
<br><br>
gbook/gbook_page_list.tpl - Шаблон списка отзывов     
gbook/main_gbook_forma.tpl - Шаблон формы отзывов  
gbook/gbook_forma_otsiv.tpl - Шаблон форма заполнения отзыва   
<br><br>
map/map_page_list.tpl -  Шаблон список карты сайта
<br><br>
links/links_page_list.tpl -  Шаблон список ссылок
links/main_links_forma.tpl -  Шаблон формы ссылки
<br><br>
page/page_page_list.tpl -  Шаблон формы вывода страниц
<br><br>
error/error_page_forma.tpl -  Форма 404 ошибки
<br><br>
news/news_main_mini.tpl -  Шаблон последние новости кратко
<br><br>
banner/baner_list_forma.tpl -  Шаблон банерной сети
<br><br>
catalog/catalog_forma.tpl -  Шаблон каталога стандартная форма
catalog/catalog_forma_2.tpl -  Шаблон каталога развернутая форма
catalog/catalog_forma_3.tpl -  Шаблон каталога прямой переход 
catalog/catalog_forma.tpl -  Шаблон каталога
catalog/podcatalog_forma.tpl -  Шаблон подкаталога
</pre>
<a name="id7"></a>
<p><h1>Переменные шаблонизатора</h1>
Папка с шаблонами расположена по адресу: phpshop/templates/имя_шаблона/
<ol>
<li><b>Главная и остальные страницы (имя_шаблона/main)</b><br><br>

<ul>
<li>@pageTitl@ - титл страницы
<li>@pageDesc@ - описание страницы
<li>@pageKeyw@ - ключевые слова
<li>@pageMeta@ - мета страницы
<li>@pageReg@ - копирайт
<li>@pageProduct@ - версия софта
<li>@pageDomen@ - копирайт на домен
<li>@pageCss@ - путь к стилям шаблона
<li>@leftCatal@ - вывод меню левой навигации
<li>@leftMenu@ - вывод блока левой текстовой информации
<li>@rightMenu@ - вывод блока правой текстовой информации
<li>@mainContentTitle@ - заголовок текстовой области на главную страницу
<li>@mainContent@ - содержимое текстовой области на главной странице 
<li>@DispShop@ - вывод соответсвующих страниц 
<li>@miniNews@ - вывод последних новостей
<li>@banersDisp@ - вывод банерной сети
<li>@pageReg@ - копирайт
<li>@name@ - вывод имени сайта
<li>@descrip@ - вывод описания сайта
<li>@serverName@ - вывод имени сервера
<li>@topMenu@ - главное навигационное меню
<li>@pageCatal@ - вывод каталога статей (страниц)
<li>@oprosDisp@ - вывод опросов
<li>@skinSelect@ - выбор смены дизайна
<li>@telNum@ - имя телефона компании
<li>@leftMenuName@ - заглавие текстового блока
<li>@leftMenuContent@ - содержание текстового блока
<li>@topMenuLink@ - ссылка на страницу главного меню
<li>@topMenuName@ - имя страницы главного меню 
</ul><br>
<li><b>Страницы (имя_шаблона/page)</b><br><br>
<ul>
<li>@pageTitle@ - заглавие страницы
<li>@pageContent@ - контент страницы
<li>@pageNav@ - вывод навигации по страницам, появляется если тег "HR"
<li>@pageName@ - имя страницы
<li>@catName@ - имя каталога статей
<li>@podcatalogName@ - имя подкаталога статей
</ul><br>
<li><b>Каталог (имя_шаблона/catalog)</b><br><br>
<ul>
<li>@catalogName@ - заглавие каталога
<li>@catalogPodcatalog@ - заглавие сраниц, ссылающяяся на этот каталог
<li>@catalogUid@ - ID каталога
<li>@catalogd@ - ID каталога
<li>@catalogCat@ - имя родителя каталога
<li>@parentName@ - имя родителя каталога
<li>@catalogList@ - вывод списка подкаталогов
<li>@podcatalogName@ - имя подкаталога
<li>@podcatalogContent@ - описание подкатлога
</ul><br>
<li><b>Банерная сеть(имя_шаблона/baner)</b><br><br>
<ul>
<li>@banerContent@ - контент банера
</ul><br>
<li><b>Отзывы (имя_шаблона/gbook)</b><br><br>
<ul>
<li>@producFound@ - Язык: найдено позиций
<li>@productNum@ - кол-во позиций
<li>@productNumOnPage@ - Язык: кол-во на странице
<li>@productNumRow@ - кол-во на странице
<li>@productPage@ - Язык: текущяя страница
<li>@productPageThis@ - текущяя страница
<li>@productPageNav@ - вывод навигации
<li>@productPageDis@ - вывод контента
<li>@gbookData@ - дата отзыва
<li>@gbookMail@ - почта автора
<li>@gbookTema@ - тема сообщения
<li>@gbookOtsiv@ - отзыв
<li>@gbookOtvet@ - ответ администрации
</ul><br>
<li><b>Партнеры (ссылки) (имя_шаблона/links)</b><br><br>
<ul>
<li>@producFound@ - Язык: найдено позиций
<li>@productNum@ - кол-во позиций
<li>@productNumOnPage@ - Язык: кол-во на странице
<li>@productNumRow@ - кол-во на странице
<li>@productPage@ - Язык: текущяя страница
<li>@productPageThis@ - текущяя страница
<li>@productPageNav@ - вывод навигации
<li>@productPageDis@ - вывод контента
<li>@linksImage - кнопка ссылки
<li>@linksName@ - название ссылки
<li>@linksOpis@ - контент ссылки
</ul><br>
<li><b>Новости (имя_шаблона/news)</b><br><br>
<ul>
<li>@producFound@ - Язык: найдено позиций
<li>@productNum@ - кол-во позиций
<li>@productNumOnPage@ - Язык: кол-во на странице
<li>@productNumRow@ - кол-во на странице
<li>@productPage@ - Язык: текущяя страница
<li>@productPageThis@ - текущяя страница
<li>@productPageNav@ - вывод навигации
<li>@productPageDis@ - вывод контента
<li>@newsData@ - дата публикации
<li>@newsZag@ - заглавие новости
<li>@newsKratko@ - краткий контент новости
<li>@newsAll@ - ссылка на подробности
<li>@newsPodrob@ - подробный контент новости
<li>@mesageText@ - сообщение для подписки
</ul><br>
<li><b>Поиск (имя_шаблона/search)</b><br><br>
<ul>
<li>@productNum@ - найдено позиций
<li>@productSite@ - название сайта
<li>@productName@ - заглавие найденной страницы
<li>@productDes@ - краткое описание страницы
</ol>
<p><br></p>
<a name="id8"></a>
<h1>Использование PHP логики в шаблонах</h1>
<p>Для вставки php кода в шаблоны *.tpl следует разместить php код между
    тегами @php .... php@ в нужном месте шаблона, где планируется вывод информации.</p>
Пример вывода системной информации в любом месте шаблона: <br>
<pre>
@php 
phpinfo(); 
php@
</pre>

<p>Ограничение по функциям php не существует. При обнаружении ошибки в
    синтаксисе php будет сформировано внутреннее сообщение об ошибке с указанием
    места в коде ошибке. Для получения справки по функциям PHP следует
    обратится к <a href="http://www.php.ru/manual/" target="_blank">Руководству по PHP</a>.</p>