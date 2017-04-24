<p><br></p>

<div align="right">
<strong>��. �����:</strong><br>
<a href="/doc/license.html" title="������������ ����������">&raquo; ������������ ����������</a><br>
<a href="/doc/phpshop-response.html" title="������ �������� PHPShop">&raquo; ������ �������� PHPShop</a><br>
<a href="/doc/design.html" title="�������������� �������">&raquo; �������������� �������</a><br>
<a href="/skin/" title="���� ���������� �������� PHPShop">&raquo; ���� ���������� �������� PHPShop</a><br>
<a href="/doc/test.html" title="����������� HTML ������">&raquo; ����������� HTML ������</a><br>
<a href="/phptest/" title="����������� PHP ������">&raquo; ����������� PHP ������</a><br>
<a href="/coretest/" title="����������� PHP ������ ����� API">&raquo; ����������� PHP ������ ����� API</a>
</div>
<p>
<p><h1>������������</h1>
����� � ��������� ����������� �� ������: <strong>phpshop/templates/���_�������/</strong><br>
��� �������� ������� ����� ������ � ������� ����� �������� ���������������� �����. ����� ��������� �� ����� <strong>HTML</strong>. <br><br>
� ������ �������� ��������� ������: @����������@ ���������� �� ��������� ������ ������� � ������������� � ����. ������ �������� ��������� ���������� <a href="#id7">����</a>. 
<p>������� � ������ 3.0 ���������� ����������� ������������� <a href="#id8">PHP ������ � ��������</a> ����� ���������� ������.</p>
<pre style="padding:10">
main/index.tpl - ������ �������� <strong>(�������� ������)</strong>
main/shop.tpl -  ��� ��������� �������� <strong>(�������� ������)</strong>
main/left_menu.tpl -  ������ ������ ���������� �����    
main/right_menu.tpl -  ������ ������� ���������� �����
<br><br>
serach/search_page_list.tpl -  ������ ������ ������ ���������
<br><br>
news/news_page_list.tpl -  ������ �������� �������� ������
news/news_page_full.tpl - ������ �������� �������� ��������
news/main_news_forma.tpl -  ������ ����� �������� ������
news/main_news_forma_full.tpl - ������ ����� �������� ��������
<br><br>
gbook/gbook_page_list.tpl - ������ ������ �������     
gbook/main_gbook_forma.tpl - ������ ����� �������  
gbook/gbook_forma_otsiv.tpl - ������ ����� ���������� ������   
<br><br>
map/map_page_list.tpl -  ������ ������ ����� �����
<br><br>
links/links_page_list.tpl -  ������ ������ ������
links/main_links_forma.tpl -  ������ ����� ������
<br><br>
page/page_page_list.tpl -  ������ ����� ������ �������
<br><br>
error/error_page_forma.tpl -  ����� 404 ������
<br><br>
news/news_main_mini.tpl -  ������ ��������� ������� ������
<br><br>
banner/baner_list_forma.tpl -  ������ �������� ����
<br><br>
catalog/catalog_forma.tpl -  ������ �������� ����������� �����
catalog/catalog_forma_2.tpl -  ������ �������� ����������� �����
catalog/catalog_forma_3.tpl -  ������ �������� ������ ������� 
catalog/catalog_forma.tpl -  ������ ��������
catalog/podcatalog_forma.tpl -  ������ �����������
</pre>
<a name="id7"></a>
<p><h1>���������� �������������</h1>
����� � ��������� ����������� �� ������: phpshop/templates/���_�������/
<ol>
<li><b>������� � ��������� �������� (���_�������/main)</b><br><br>

<ul>
<li>@pageTitl@ - ���� ��������
<li>@pageDesc@ - �������� ��������
<li>@pageKeyw@ - �������� �����
<li>@pageMeta@ - ���� ��������
<li>@pageReg@ - ��������
<li>@pageProduct@ - ������ �����
<li>@pageDomen@ - �������� �� �����
<li>@pageCss@ - ���� � ������ �������
<li>@leftCatal@ - ����� ���� ����� ���������
<li>@leftMenu@ - ����� ����� ����� ��������� ����������
<li>@rightMenu@ - ����� ����� ������ ��������� ����������
<li>@mainContentTitle@ - ��������� ��������� ������� �� ������� ��������
<li>@mainContent@ - ���������� ��������� ������� �� ������� �������� 
<li>@DispShop@ - ����� �������������� ������� 
<li>@miniNews@ - ����� ��������� ��������
<li>@banersDisp@ - ����� �������� ����
<li>@pageReg@ - ��������
<li>@name@ - ����� ����� �����
<li>@descrip@ - ����� �������� �����
<li>@serverName@ - ����� ����� �������
<li>@topMenu@ - ������� ������������� ����
<li>@pageCatal@ - ����� �������� ������ (�������)
<li>@oprosDisp@ - ����� �������
<li>@skinSelect@ - ����� ����� �������
<li>@telNum@ - ��� �������� ��������
<li>@leftMenuName@ - �������� ���������� �����
<li>@leftMenuContent@ - ���������� ���������� �����
<li>@topMenuLink@ - ������ �� �������� �������� ����
<li>@topMenuName@ - ��� �������� �������� ���� 
</ul><br>
<li><b>�������� (���_�������/page)</b><br><br>
<ul>
<li>@pageTitle@ - �������� ��������
<li>@pageContent@ - ������� ��������
<li>@pageNav@ - ����� ��������� �� ���������, ���������� ���� ��� "HR"
<li>@pageName@ - ��� ��������
<li>@catName@ - ��� �������� ������
<li>@podcatalogName@ - ��� ����������� ������
</ul><br>
<li><b>������� (���_�������/catalog)</b><br><br>
<ul>
<li>@catalogName@ - �������� ��������
<li>@catalogPodcatalog@ - �������� ������, ����������� �� ���� �������
<li>@catalogUid@ - ID ��������
<li>@catalogd@ - ID ��������
<li>@catalogCat@ - ��� �������� ��������
<li>@parentName@ - ��� �������� ��������
<li>@catalogList@ - ����� ������ ������������
<li>@podcatalogName@ - ��� �����������
<li>@podcatalogContent@ - �������� ����������
</ul><br>
<li><b>�������� ����(���_�������/baner)</b><br><br>
<ul>
<li>@banerContent@ - ������� ������
</ul><br>
<li><b>������ (���_�������/gbook)</b><br><br>
<ul>
<li>@producFound@ - ����: ������� �������
<li>@productNum@ - ���-�� �������
<li>@productNumOnPage@ - ����: ���-�� �� ��������
<li>@productNumRow@ - ���-�� �� ��������
<li>@productPage@ - ����: ������� ��������
<li>@productPageThis@ - ������� ��������
<li>@productPageNav@ - ����� ���������
<li>@productPageDis@ - ����� ��������
<li>@gbookData@ - ���� ������
<li>@gbookMail@ - ����� ������
<li>@gbookTema@ - ���� ���������
<li>@gbookOtsiv@ - �����
<li>@gbookOtvet@ - ����� �������������
</ul><br>
<li><b>�������� (������) (���_�������/links)</b><br><br>
<ul>
<li>@producFound@ - ����: ������� �������
<li>@productNum@ - ���-�� �������
<li>@productNumOnPage@ - ����: ���-�� �� ��������
<li>@productNumRow@ - ���-�� �� ��������
<li>@productPage@ - ����: ������� ��������
<li>@productPageThis@ - ������� ��������
<li>@productPageNav@ - ����� ���������
<li>@productPageDis@ - ����� ��������
<li>@linksImage - ������ ������
<li>@linksName@ - �������� ������
<li>@linksOpis@ - ������� ������
</ul><br>
<li><b>������� (���_�������/news)</b><br><br>
<ul>
<li>@producFound@ - ����: ������� �������
<li>@productNum@ - ���-�� �������
<li>@productNumOnPage@ - ����: ���-�� �� ��������
<li>@productNumRow@ - ���-�� �� ��������
<li>@productPage@ - ����: ������� ��������
<li>@productPageThis@ - ������� ��������
<li>@productPageNav@ - ����� ���������
<li>@productPageDis@ - ����� ��������
<li>@newsData@ - ���� ����������
<li>@newsZag@ - �������� �������
<li>@newsKratko@ - ������� ������� �������
<li>@newsAll@ - ������ �� �����������
<li>@newsPodrob@ - ��������� ������� �������
<li>@mesageText@ - ��������� ��� ��������
</ul><br>
<li><b>����� (���_�������/search)</b><br><br>
<ul>
<li>@productNum@ - ������� �������
<li>@productSite@ - �������� �����
<li>@productName@ - �������� ��������� ��������
<li>@productDes@ - ������� �������� ��������
</ol>
<p><br></p>
<a name="id8"></a>
<h1>������������� PHP ������ � ��������</h1>
<p>��� ������� php ���� � ������� *.tpl ������� ���������� php ��� �����
    ������ @php .... php@ � ������ ����� �������, ��� ����������� ����� ����������.</p>
������ ������ ��������� ���������� � ����� ����� �������: <br>
<pre>
@php 
phpinfo(); 
php@
</pre>

<p>����������� �� �������� php �� ����������. ��� ����������� ������ �
    ���������� php ����� ������������ ���������� ��������� �� ������ � ���������
    ����� � ���� ������. ��� ��������� ������� �� �������� PHP �������
    ��������� � <a href="http://www.php.ru/manual/" target="_blank">����������� �� PHP</a>.</p>