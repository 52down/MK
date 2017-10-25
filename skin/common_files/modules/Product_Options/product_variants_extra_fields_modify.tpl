{*
5cc5854600293293a69fd76f7a5ffdbe7a9bbccb, v1 (xcart_4_7_4), 2015-08-31 16:58:21, product_variants_extra_fields_modify.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{$lng.txt_section_variants_ef_note}<br />
<br />

{capture name="dialog"}

  <!-- FILTER VARIANTS & EXTRA FIELDS -->

  {if not $variants}{$_visible=true}{/if}
  <div align="right">{include file="main/visiblebox_link.tpl" mark="-variants-ef-filter" title=$lng.lbl_filter_product_variants_ef visible=$_visible}</div>

  <div {if $variants}style="display: none;"{/if} id="box-variants-ef-filter">

    <form action="product_modify.php" method="post" name="product_variants_ef_filter_form">

      <input type="hidden" name="section" value="variants_extra_fields" />
      <input type="hidden" name="mode" value="product_variants_ef_filter" />
      <input type="hidden" name="productid" value="{$product.productid}" />

      <table cellspacing="1" cellpadding="2" width="80%">

        <!-- filter: produvt variants -->

        <tr>
          <td colspan="2">{$lng.lbl_select_options}:<hr /></td>
        </tr>
        
        {foreach from=$product_options item=v}

          {assign var="classid" value=$v.classid}
          
          {if $v.is_modifier eq ""}
            
            <tr{cycle name="classes" values=', class="TableSubHead"'}>
              <td><b>{$v.class}</b>:</td>
              <td>

                {foreach from=$v.options item=o}

                  {assign var="optionid" value=$o.optionid}
                  {assign var="tmp_class" value=$filter_options.options[$classid]}

                  <label class="nowrap">
                    <input type="checkbox" name="search[options][{$classid}][{$optionid}]" value="{$optionid}"{if $tmp_class[$optionid] ne "" or $is_search_all eq "Y"} checked="checked"{/if} />&nbsp;{$o.option_name}
                  </label>&nbsp;&nbsp;

                {/foreach}

              </td>
            </tr>

          {/if}

        {/foreach}

        <!-- filter: extra fields -->

        <tr>
          <td colspan="2"><br />{$lng.lbl_select_extra_fields}:<hr /></td>
        </tr>

        <tr>
          <td colspan="2">
        
            {foreach from=$extra_fields_filter item=v}

              {assign var="tmp_field" value=$filter_options.extra_fields}

              <label class="nowrap">
                <input type="checkbox" name="search[extra_fields][{$v.fieldid}]"{if $tmp_field[$v.fieldid] ne ""} checked="checked"{/if} value="{$v.fieldid}" />&nbsp;{$v.field}
              </label>&nbsp;&nbsp;

            {/foreach}

          </td>    
        </tr>
      
      </table>

      <br /><input type="submit" value="{$lng.lbl_search|strip_tags:false|escape}" />
    
    </form>
    
    <br />

  </div>

  <br />

  <!-- / FILTER VARIANTS & EXTRA FIELDS -->
  {if $variants}
  <form action="product_modify.php" method="post" name="product_variants_ef_form">
    
    <input type="hidden" name="section" value="variants_extra_fields" />
    <input type="hidden" name="mode" value="product_variants_ef_update" />
    <input type="hidden" name="productid" value="{$product.productid}" />
    
    <table cellpadding="3" cellspacing="0" width="100%">

      {foreach from=$variants item="variant" key="variantid"}

        {capture name="variant_title"}
          {$variant.productcode}
          ({foreach from=$variant.options name="variant_options" item=o}
            {$o.class}: {$o.option_name}{if not $smarty.foreach.variant_options.last},{/if}
          {/foreach})
        {/capture}
        
        <tr>
          <td colspan="2">{include file="main/subheader.tpl" title=$smarty.capture.variant_title}</td>
        </tr>

        {foreach from=$extra_fields item="ef"}

          <tr>
            <td class="FormButton" nowrap="nowrap">{$ef.field}:</td>
            <td><input type="text" name="posted_data[extra_fields][{$variantid}][{$ef.fieldid}]" size="50" value="{$variant.variant_extra_fields[$ef.fieldid].value|escape}" /></td>
          </tr>

        {/foreach}

        <tr>
          <td colspan="2"><br /></td>
        </tr>

      {/foreach}

    </table>

    <div id="sticky_content">
      
      <div class="main-button">
        <input type="submit" class="big-main-button" value="{$lng.lbl_apply_changes|strip_tags:false|escape}" />
      </div>

    </div>

  </form>
  {/if}

{/capture}

{include file="dialog.tpl" title=$lng.lbl_product_variants_ef content=$smarty.capture.dialog extra='width="100%"'}
