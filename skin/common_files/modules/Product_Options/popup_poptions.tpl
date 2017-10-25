{*
02d4cf8c7ef5ade74bed509518783931541981b2, v8 (xcart_4_7_6), 2016-03-25 18:10:47, popup_poptions.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
<script type="text/javascript">
//<![CDATA[
var min_avail = {$min_avail|default:0};
var avail = {inc value=$min_avail};
var product_avail = avail;
var txt_out_of_stock = "{$lng.txt_out_of_stock|wm_remove|escape:javascript|replace:"\n":"<br />"|replace:"\r":" "}";

{literal}
function FormValidationEdit() {
  if(!check_exceptions()) {
    if (!this.popup_open_submit) {
      // display alert message
      alert(exception_msg);
    } else {
      // clear flag set in popup_open.js -> submitHandler
      this.popup_open_submit = false;
    }
    return false;
  }
{/literal}
{if $target ne "wishlist"}
{literal}
  else if (min_avail > avail) {
    alert(txt_out_of_stock);
    return false;
  }
{/literal}
{/if}
  {if $product_options_js ne ''}
  {$product_options_js}
  {/if}
{literal}
  return true;
}
{/literal}
//]]>
</script>

<form action="popup_poptions.php" method="post" name="orderform" onsubmit="javascript: return FormValidationEdit.apply(this);">
  <input type="hidden" name="mode" value="update" />
  <input type="hidden" name="id" value="{$id|escape}" />
  <input type="hidden" name="target" value="{$target|escape}" />
  <input type="hidden" name="eventid" value="{$eventid|escape}" />

  <table cellspacing="0" class="product-properties" summary="{$lng.lbl_options|escape}">

    {include file="modules/Product_Options/customer_options.tpl" is_popup_poptions=true}

    <tr>
      <td>&nbsp;</td>
      <td>
        <div class="button-row">
          {include file="customer/buttons/update.tpl" type="input"}
        </div>
      </td>
    </tr>

  </table>

{if $active_modules.Product_Options and $product_options ne '' and $product_options_ex2hide and ($product.product_type ne "C" or not $active_modules.Product_Configurator)}
{* First run is needed to hide exceptions*}
<script type="text/javascript">
//<![CDATA[
if (
  typeof(exceptions2hide) !== 'undefined'
  && exceptions2hide
) {
  check_options();
}
//]]>
</script>
{/if}

</form>
