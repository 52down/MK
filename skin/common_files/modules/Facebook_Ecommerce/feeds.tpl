{*
ad3a6575cb5e92118af4310c5e95ab1cfd69619c, v4 (xcart_4_7_8), 2017-05-24 10:42:28, feeds.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{capture name=js_feed_files_snippet}
  var fe_js_ajax_session_quick_key = "{get_ajax_session_quick_key|escape:javascript}";
  var fe_formname = '{$controller_g}form';

  $(document).ready(function() {

    // delete handler
    var aja_save_url = 'facebook_ecomm_ajax_delete_feed.php?posted_ajax_session_quick_key='+fe_js_ajax_session_quick_key;
    $('#feeds_files').on('click', 'a.fe-delete', function() {
      var parent_tr = $(this).parent().parent();
        if ($(this).data('id_in_db')) {
          // delete from db and FS
          $.post(aja_save_url + '&mode=delete', 'id=' + encodeURIComponent($(this).data('id_in_db')));
        }
        // remove tr row
        parent_tr.remove();
        return false;
    });

    $('#feeds_files').on('click', 'a.fe-refresh', function() {
        if ($(this).data('id_in_db')) {
          document.getElementById(fe_formname).fe_feed_id.value = $(this).data('id_in_db');
          submitForm(document.getElementById(fe_formname), 'refresh');
        }
        return false;
    });

  });

{/capture}

{load_defer file="js_feed_files_snippet" direct_info=$smarty.capture.js_feed_files_snippet type="js"}

<form action="configuration.php?option=Facebook_Ecommerce&amp;controller_g={$controller_g}" method="post" name="{$controller_g}form" id="{$controller_g}form">

  <table width="100%">

    <tr>
      <td>
        <table width="100%">
            <tr>
              <td colspan="2" class="TableSeparator">&nbsp;</td>
            </tr>

            {cycle name=$cycle_name values=" class='TableSubHead', " assign="row_style"}
            <tr {$row_style}>
              <td width="40%">{if $active_modules.XMultiCurrency}{$lng.lbl_cc_currency}{else}{$lng.lbl_facebook_ecomm_currency}{/if}</td>
              <td>
                <select id="fe_currency" name="fe_currency">
                  {foreach item=currency from=$availCurrencies}
                    <option value="{$currency.code}" {if $currency.selected eq 'Y'}selected="selected"{/if}>{$currency.name}</option>
                  {/foreach}
                </select>
              </td>
            </tr>

            {cycle name=$cycle_name values=" class='TableSubHead', " assign="row_style"}
            <tr {$row_style}>
              <td width="40%">{$lng.lbl_language}</td>
              <td>
                <select id="fe_language" name="fe_language">
                  {foreach from=$all_languages item=v}
                    {if ($v.code ne $config.default_admin_language or $is_no_default ne 'Y') and $v.language ne ''}
                      <option value="{$v.code|escape}"{if $v.code eq $shop_language} selected="selected"{/if}>{$v.language}</option>
                    {/if}
                  {/foreach}
                </select>
              </td>
            </tr>

            {cycle name=$cycle_name values=" class='TableSubHead', " assign="row_style"}
            <tr {$row_style}>
              <td width="40%">{$lng.lbl_facebook_ecomm_age_group}</td>{* https://developers.facebook.com/docs/marketing-api/dynamic-product-ads/product-catalog/v2.9#feed-format *}
              <td>
                <select id="fe_age_group" name="fe_age_group">
                      <option value="newborn">newborn</option>
                      <option value="infant">infant</option>
                      <option value="toddler">toddler</option>
                      <option value="kids">kids</option>
                      <option value="adult" selected="selected">adult</option>
                </select>
              </td>
            </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td>
        <div class="main-button">
          <input type="hidden" name="mode" value="" />
          <input type="hidden" name="fe_feed_id" value="" />
          <input type="submit" class="big-main-button configure-style" value="{$lng.lbl_facebook_ecomm_generate_feed|strip_tags:false|escape}" />
          {include file="main/tooltip_js.tpl" id="t_how_to_add_facebook_fields" text=$lng.txt_facebook_ecomm_feed_format_help width='450' sticky=true}
        </div>
      </td>
    </tr>

  </table>
</form>

<table width="100%" id="feeds_files">

  <tr>
    <td colspan="7"><br />{include file="main/subheader.tpl" title=$lng.lbl_facebook_ecomm_last_feeds}</td>
  </tr>

  <tr class="TableHead">
    <td width="1%">&nbsp;</td>
    <td width="74%">{$lng.lbl_url}</td>
    <td width="2%">&nbsp;</td>
    <td width="10%">{$lng.lbl_facebook_ecomm_update_date}</td>
    <td width="2%">&nbsp;</td>
    <td width="3%">&nbsp;</td>
    <td width="10%">{$lng.lbl_facebook_ecomm_fetch_date}</td>
  </tr>

  {foreach from=$feeds_list item=feed}
    <tr{cycle name=$type values=", class='TableSubHead'"}>
      <td><a href='{$feed.url}' title="{$lng.lbl_download}"><i type="button" class="fa fa-download"></i></a></td>
      <td>{$feed.url|escape}</td>
      <td align="center"><a href='javascript:void(0);' class='fe-refresh' title="{$lng.lbl_update}" data-id_in_db='{$feed.id}'><i type="button" class="fa fa-refresh"></i></a></td>
      <td align="center">{$feed.update_date|date_format:$config.Appearance.datetime_format}</td>
      <td align="center"><a href='javascript:void(0);' class='fe-delete' title="{$lng.lbl_delete}" data-id_in_db='{$feed.id}'><i type="button" class="fa fa-trash-o"></i></a></td>
      <td>{$feed.in_data|escape}</td>
      <td align="center">{if $feed.fetch_date}{$feed.fetch_date|date_format:$config.Appearance.datetime_format}{/if}</td>
    </tr>
  {foreachelse}
    <tr>
      <td colspan="7" align="center">{$lng.lbl_facebook_ecomm_no_feeds}</td>
    </tr>
  {/foreach}

</table>

{include file="main/navigation.tpl"}
