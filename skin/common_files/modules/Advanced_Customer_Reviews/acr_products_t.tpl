{*
16fd72c950254a8d4861815dac0d6147af93e43f, v4 (xcart_4_7_0), 2014-12-23 10:13:26, acr_products_t.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<tr{interline name=products_matrix foreach_iteration="`$smarty.foreach.products_matrix.iteration`" foreach_total="`$smarty.foreach.products_matrix.total`"}>

  {foreach from=$row item=product name=products}

    {if $product}
      <td{interline name=products foreach_iteration="`$smarty.foreach.products.iteration`" foreach_total="`$smarty.foreach.products.total`" additional_class="product-cell"}>
      {if $product.general_rating}
        {include file="modules/Advanced_Customer_Reviews/general_product_rating.tpl" general_rating=$product.general_rating productid=$product.productid is_multicolumns=$is_multicolumn}
        {if $break_line eq "Y"}
          <br />
        {/if}
      {/if}
      </td>

      {if $column_separator eq "Y"}
        {if !$smarty.foreach.products.last}
          <td class="column_separator"><div>&nbsp;</div></td>
        {/if}
      {/if}

    {/if}
  {/foreach}
</tr>
