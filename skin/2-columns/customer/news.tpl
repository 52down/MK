{*
f2dbf5cb9431ad2896fd3b4e20ca2432b155874b, v2 (xcart_4_7_7), 2017-01-12 19:34:36, news.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $active_modules.IContact_Subscription}
  {capture name='icontact_news'}
      <div class="news-box">

        <div class="news">
          <h2>{$lng.lbl_news}</h2>
          <a href="icontact_news.php#subscribe" class="subscribe">{$lng.lbl_subscribe}</a>
        </div>

      </div>

  {/capture}
{/if}

{if $active_modules.News_Management}
  {insert name="gate" func="news_exist" assign="is_news_exist" lngcode=$shop_language}

  {if $is_news_exist}

    {insert name="gate" func="news_subscription_allowed" assign="is_subscription_allowed" lngcode=$shop_language}

    <div class="news-box">

      <div class="news">

        <h2>{$lng.lbl_news}</h2>

        {if $news_message eq ""}

          {$lng.txt_no_news_available}

        {else}

          <strong>{$news_message.date|date_format:$config.Appearance.date_format}</strong><br />
          {$news_message.body}<br /><br />
          {if $active_modules.IContact_Subscription}
            <a href="icontact_news.php" class="prev-news">{$lng.lbl_previous_news}</a>
            &nbsp;&nbsp;
            <a href="icontact_news.php#subscribe" class="subscribe">{$lng.lbl_subscribe}</a>
          {elseif $is_subscription_allowed}
            <a href="news.php" class="prev-news">{$lng.lbl_previous_news}</a>
            &nbsp;&nbsp;
            <a href="news.php#subscribe" class="subscribe">{$lng.lbl_subscribe}</a>
          {/if}

        {/if}

      </div>

    </div>

  {elseif $smarty.capture.icontact_news}
    {$smarty.capture.icontact_news}
  {/if}
{elseif $smarty.capture.icontact_news}
    {$smarty.capture.icontact_news}
{/if}
