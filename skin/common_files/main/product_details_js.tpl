{*
327156a81ec674b204d2d9aa5e97c53c599c3380, v7 (xcart_4_7_7), 2016-09-05 20:10:17, product_details_js.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<script type="text/javascript">
//<![CDATA[
var requiredFields = [
  ['productcode', "{$lng.lbl_sku|strip_tags|wm_remove|escape:javascript}", false],
  ['product', "{$lng.lbl_product_name|strip_tags|wm_remove|escape:javascript}", false],
  {if $config.SEO.clean_urls_enabled eq "Y"} ['clean_url', "{$lng.lbl_clean_url|strip_tags|wm_remove|escape:javascript}", false], {/if}
  ['descr', "{$lng.lbl_description|strip_tags|wm_remove|escape:javascript}", false],
  ['product_lng[product]', "{$lng.lbl_description|strip_tags|wm_remove|escape:javascript}", false]
];

{literal}

function ChangeTaxesBoxStatus(s) {
  if (s.form.elements.namedItem('taxes[]'))
    s.form.elements.namedItem('taxes[]').disabled = s.options[s.selectedIndex].value == 'Y';
}

function switchPDims(c) {
  var names = ['length', 'width', 'height', 'separate_box', 'items_per_box'];
  for (var i = 0; i < names.length; i++) {
    var e = c.form.elements.namedItem(names[i]);
    if (e) {
      e.disabled = !c.checked;

      // "Ship in a separate box" depends on "Use the dimensions of this product for shipping cost calculation" bt:84873
      if (names[i] == 'separate_box' && !c.checked)
        e.checked = false;
    }  
  }

  switchSSBox(c.form.elements.namedItem('separate_box'));
}

function switchSSBox(c) {
  if (!c)
    return;

  c.form.elements.namedItem('items_per_box').disabled = !c.checked || !c.form.elements.namedItem('small_item').checked;
}
{/literal}
//]]>
</script>
