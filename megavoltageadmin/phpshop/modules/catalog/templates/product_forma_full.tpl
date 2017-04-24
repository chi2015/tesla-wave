<table cellpadding="5" cellspacing="0" border="0" width="100%" style="margin-bottom: 10px">
  <tr>
    <td>
      <img src="@productImg@" lowsrc="images/shop/no_photo.gif"   alt="@productName@" title="@productName@" border="0"><div class="highslide-caption">@productName@</div>
    </td>
  </tr>
  <tr>
	<td>

      <!-- Вывод имени товара -->
      <div style="padding-bottom:6px"><H1>@productName@</H1></div>
      <!-- Вывод имени товара -->

      <!-- Вывод краткого описания для тематических товаров -->
      @productContent@
      <!-- Вывод краткого описания для тематических товаров -->

    </td>
  </tr>
  <tr>
	<td>

      <div style="padding-bottom:6px; padding-top:6px"> Цена: <strong>@productPrice@</strong> @productValutaName@  </div>

    </td>
  </tr>
  <tr>
	<td align="center">
        <!-- Блок корзина -->
        <img src="phpshop/modules/catalog/templates/basket_put.gif" alt="" border="0" align="absmiddle" hspace="5">
        <a href="?item=@productId@" title="Купить @productName@">В корзину</a>
        <!-- Блок корзина -->
    </td>
  </tr>
</table>
