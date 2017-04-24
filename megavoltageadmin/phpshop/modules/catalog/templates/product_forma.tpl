<table cellpadding="5" cellspacing="0"  width="100%" style="margin-bottom: 10px; border:outset;border-width: 1px;border-color:Silver">
  <tr>
    <td>
      <a class="highslide" onclick="return hs.expand(this)" href="@productImgBigFoto@" target="_blank" getParams="null" title="@productName@"><img src="@productImg@" lowsrc="images/shop/no_photo.gif"   alt="@productName@" title="@productName@" border="0"></a>
    </td>
  </tr>
  <tr>
	<td>

      <!-- Вывод имени товара -->
      <div style="padding-bottom:6px"><a href="@path@/shop/ID_@productId@_@productLatName@.html" title="@productName@">@productName@</a></div>
      <!-- Вывод имени товара -->

      <!-- Вывод краткого описания для тематических товаров -->
      @productDescription@
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
        <a href="?item=@productId@#cart" title="Купить @productName@">В корзину</a>
        <!-- Блок корзина -->
    </td>
  </tr>
</table>
