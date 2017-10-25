{*
b5f14141bc2574b1588a0293b07502d05a9b9968, v3 (xcart_4_7_0), 2015-01-27 13:14:28, admin_review.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $review.review_id}
  {assign var="title" value=$lng.lbl_acr_edit_review}
{else}
  {assign var="title" value=$lng.lbl_add_review}
{/if}

{include file="page_title.tpl" title=$title}

{if $current_page eq 'product_reviews'}
  {assign var=url value="product_modify.php?productid=`$productid`&section=acr_reviews"}
  {assign var=back_url value="product_modify.php?productid=`$productid`&section=acr_reviews"}
{else}
  {assign var=url value="review_modify.php?"}
  {assign var=back_url value="reviews.php?mode=search&page=`$navpage`"}
{/if}
<div align="right">{include file="buttons/button.tpl" button_title=$lng.lbl_acr_back_to_reviews_list href=$back_url}</div>
{if $review}
  {assign var=url value="`$url`&review_id=`$review.review_id`"}
{/if}
<form method="post" action="{$url}">

  <input type="hidden" name="mode" value="review_modify" />
  {if $productid}
  <input type="hidden" name="productid" value="{$productid}" />
  {/if}

  <table cellspacing="1" cellpadding="3" class="data-table">

    <tr>
      <td colspan="3">{include file="main/subheader.tpl" title=$lng.lbl_acr_author_info}</td>
    </tr>

    {assign var="show_user_link" value="N"}
    {if $review.userid gt 0 && ($usertype eq "A" || ($usertype eq "P" && $single_mode))}
      {assign var="show_user_link" value="Y"}
    {/if}
    <tr>
      <td class="FormButton"><label for="author">{$lng.lbl_acr_author}:</label></td>
      <td>&nbsp;</td>
      <td>
        <input type="text" name="review[author]" id="author" value="{$review.author|escape}" size="60" />
        {if $show_user_link eq "Y"}<a href="user_modify.php?usertype=C&amp;user={$review.userid}">{$lng.lbl_view_profile}</a>{/if}
      </td>
    </tr>

    <tr>
      <td class="FormButton"><label for="userid">{$lng.lbl_userid}:</label></td>
      <td>&nbsp;</td>
      <td>
        {if $usertype eq "A" || ($usertype eq "P" && $single_mode)}
          <input type="text" name="review[userid]" id="userid" value="{$review.userid|escape}" size="20" />
        {else}
          <input type="hidden" name="review[userid]" id="userid" value="{$review.userid|escape}" size="20" />
          {$review.userid}
        {/if}
        {if $show_user_link eq "Y"}<a href="user_modify.php?usertype=C&amp;user={$review.userid}">{$lng.lbl_view_profile}</a>{/if}
      </td>
    </tr>

    <tr>
      <td class="FormButton"><label for="email">{$lng.lbl_email}:</label></td>
      <td>&nbsp;</td>
      <td>
        <input type="text" class="input-email" name="review[email]" id="email" value="{$review.email|escape}" size="60" />
      </td>
    </tr>

    <tr>
      <td class="FormButton"><label for="remote_ip">{$lng.lbl_remote_IP}:</label></td>
      <td>&nbsp;</td>
      <td>
        <input type="text" name="review[remote_ip]" id="remote_ip" value="{$review.remote_ip|escape}" size="20" />
      </td>
    </tr>

    <tr>
      <td colspan="3"><br /><br />{include file="main/subheader.tpl" title=$lng.lbl_acr_review_info}</td>
    </tr>

    <tr>
      <td class="FormButton">{$lng.lbl_productid}#:</td>
      <td>&nbsp;</td>
      <td>
        <input type="text" name="review[productid]" id="productid" value="{$review.productid|escape}" size="20" />
        {if $review.productid gt 0}<a href="product_modify.php?productid={$review.productid}">{$review.product} ({$lng.lbl_product_details})</a>{/if}
      </td>
    </tr>

    <tr>
      <td class="FormButton">{$lng.lbl_acr_review_is_verified}:</td>
      <td>&nbsp;</td>
      <td>
        <input type="checkbox" name="review[is_verified]" id="is_verified" value="Y"{if $review.is_verified eq "Y"} checked="checked"{/if} />
        {if $review.orderids} ({$lng.lbl_orders}: 
        {section name=orderids loop=$review.orderids}
          <a href="order.php?orderid={$review.orderids[orderids]}">#{$review.orderids[orderids]}</a>{if !$smarty.section.orderids.last}, {/if}
        {/section})
        {/if}
      </td>
    </tr>

    {if $review}
    {$_month_names = ['1'=>$lng.lbl_month_abbr_1,'2'=>$lng.lbl_month_abbr_2, '3'=>$lng.lbl_month_abbr_3, '4'=>$lng.lbl_month_abbr_4, '5'=>$lng.lbl_month_abbr_5, '6'=>$lng.lbl_month_abbr_6, '7'=>$lng.lbl_month_abbr_7, '8'=>$lng.lbl_month_abbr_8, '9'=>$lng.lbl_month_abbr_9, '10'=>$lng.lbl_month_abbr_10, '11'=>$lng.lbl_month_abbr_11, '12'=>$lng.lbl_month_abbr_12]}
    <tr>
      <td class="FormButton">{$lng.lbl_date}:</td>
      <td>&nbsp;</td>
      <td>
        {html_select_date prefix="review" time=$review.datetime start_year=$config.Company.start_year end_year=$config.Company.end_year+2 month_format="%b" month_names=$_month_names}
        {if $review.datetime eq 0 && $review.review_id}&nbsp;{$lng.txt_acr_no_date}{/if}
      </td>
    </tr>
    {/if}

    <tr>
      <td class="FormButton"><label for="rating">{$lng.lbl_acr_rating}:</label></td>
      <td>&nbsp;</td>
      <td>
        {include file="modules/Advanced_Customer_Reviews/rating_selector.tpl" review_rating=$review.rating field="review[rating]" is_short="Y"}
      </td>
    </tr>

    <tr>
      <td class="FormButton"><label for="status">{$lng.lbl_status}:</label></td>
      <td>&nbsp;</td>
      <td>
        {include file="modules/Advanced_Customer_Reviews/review_status.tpl" review_status=$review.status field="review[status]" is_short="Y"}
      </td>
    </tr>

    <tr>
      <td colspan="3"><br /><br />{include file="main/subheader.tpl" title=$lng.lbl_acr_review_comments}</td>
    </tr>

    <tr>
      <td class="FormButton"><label for="review_message">{$lng.lbl_acr_comment}</label>:</td>
      <td>&nbsp;</td>
      <td>
        <textarea cols="80" rows="5" name="review[message]" id="review_message">{$review.message}</textarea>
        <br />
        {$lng.lbl_acr_max_length|substitute:length:$smarty.const.ACR_TEXT_MAX_LENGTH}
      </td>
    </tr>

    {if $config.Advanced_Customer_Reviews.acr_use_advantages_block eq 'Y'}
    <tr>
      <td class="FormButton"><label for="review_advantages">{$lng.lbl_acr_advantages}</label>:</td>
      <td>&nbsp;</td>
      <td>
        <textarea cols="80" rows="5" name="review[advantages]" id="review_advantages">{$review.advantages}</textarea>
        <br />
        {$lng.lbl_acr_max_length|substitute:length:$smarty.const.ACR_TEXT_MAX_LENGTH}
      </td>
    </tr>

    <tr>
      <td class="FormButton"><label for="review_disadvantages">{$lng.lbl_acr_disadvantages}</label>:</td>
      <td>&nbsp;</td>
      <td>
        <textarea cols="80" rows="5" name="review[disadvantages]" id="review_disadvantages">{$review.disadvantages}</textarea>
        <br />
        {$lng.lbl_acr_max_length|substitute:length:$smarty.const.ACR_TEXT_MAX_LENGTH}
      </td>
    </tr>
    {/if}

    <tr>
      <td align="center" colspan="3">
        <br />
        <input type="submit" value="{if $review.review_id}{$lng.lbl_update}{else}{$lng.lbl_add}{/if}" />
        {$submit_button}
      </td>
    </tr>

  </table>

</form>
