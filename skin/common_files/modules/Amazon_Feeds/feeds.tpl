{*
09d46970de4b3605245381ed8ecd8b55fffd1d3e, v3 (xcart_4_7_5), 2016-02-12 18:28:36, feeds.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<form action="configuration.php?option={$option|escape}&amp;{XCAmazonFeedsDefs::CONTROLLER}={$controller}" method="post" name="{$controller}form">

  <table width="100%">

    <tr>
      <td>
        {include file="modules/Amazon_Feeds/feeds_logo.tpl"}
      </td>
    </tr>

    <tr>
      <td>
        <table width="100%">
          <tr>
            <th colspan="3">{include file="main/subheader.tpl" title=$lng.txt_amazon_feeds_select}</th>
          </tr>
          {foreach from=$feed_types item=feed_type key=feed_id}
            <tr>
              <td>{$lng.$feed_type}</td>
              <td>{include file="widgets/onoff/onoff.tpl" name=$feed_id checked="{${$feed_id}}"}</td>
              {if $feed_id eq XCAmazonFeedsDefs::SESSION_VAR_PRODUCT}
                <td>
                  {include file="widgets/onoff/onoff.tpl" name={XCAmazonFeedsDefs::SESSION_VAR_FULL} checked="{${XCAmazonFeedsDefs::SESSION_VAR_FULL}}" on_name="{$lng.lbl_amazon_feeds_full}" off_name="{$lng.lbl_amazon_feeds_diff}"}
                </td>
              {else}
                <td></td>
              {/if}
            </tr>
            {if $feed_id eq XCAmazonFeedsDefs::SESSION_VAR_PRODUCT}
              <tr><td colspan="3"><hr /></td></tr>
            {/if}
          {/foreach}
        </table>
      </td>
    </tr>

    <tr>
      <td>
        <div class="main-button">
          <input type="submit" class="big-main-button configure-style" value="{$lng.lbl_amazon_feeds_submit|strip_tags:false|escape}" />
        </div>
      </td>
    </tr>

  </table>
</form>

<table width="100%">

  <tr>
    <td colspan="5"><br />{include file="main/subheader.tpl" title=$lng.lbl_amazon_feeds_last_feeds}</td>
  </tr>

  <tr class="TableHead">
    <td width="5%">&nbsp;</td>
    <td width="30%">{$lng.lbl_amazon_feeds_type}</td>
    <td width="25%">{$lng.lbl_amazon_feeds_submit_date}</td>
    <td width="15%">{$lng.lbl_amazon_feeds_status}</td>
    <td width="25%">{$lng.lbl_amazon_feeds_status_date}</td>
  </tr>

  {foreach from=$feeds_list item=feed}
    <tr{cycle name=$type values=", class='TableSubHead'"}>
      <td>&nbsp;</td>
      <td align="center">{$feed.type|escape}</td>
      <td align="center">{$feed.submit_date|escape|date_format:$config.Appearance.datetime_format}</td>
      <td align="center" title="{$feed.status.descr|escape}">{$feed.status.code|escape}</td>
      <td align="center">{$feed.status_date|escape|date_format:$config.Appearance.datetime_format}</td>
    </tr>
  {foreachelse}
    <tr>
      <td colspan="5" align="center">{$lng.lbl_amazon_feeds_no_feeds}</td>
    </tr>
  {/foreach}

  <tr>
    <td colspan="5"><hr /></td>
  </tr>
  <tr>
    <td colspan="5" align="right">
      <form action="configuration.php?option={$option|escape}&amp;{XCAmazonFeedsDefs::CONTROLLER}={XCAmazonFeedsDefs::CONTROLLER_FEEDS_CHECK}" method="post" name="{XCAmazonFeedsDefs::CONTROLLER_FEEDS_CHECK}form">
      <div class="main-button">
        <input type="submit" class="big-main-button configure-style" value="{$lng.lbl_amazon_feeds_check_status|strip_tags:false|escape}" />
      </div>
      </form>
    </td>
  </tr>

</table>

{include file="main/navigation.tpl"}
