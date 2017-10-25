{*
f02a1a0b1a70d8f7247467b594775789e415ff2b, v5 (xcart_4_7_4), 2015-09-10 21:26:11, acr_review_reminder.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}

<b>{include file="mail/salutation.tpl" title=$userinfo.title firstname=$userinfo.firstname lastname=$userinfo.lastname}</b>
<br /><br />

{if $config.Advanced_Customer_Reviews.acr_reward_coupon_discount gt 0}
  {$lng.txt_acr_add_products_reviews_coupon|substitute:"company_name":$config.Company.company_name:"discount_coupon":$discount_coupon}
{else}
  {$lng.txt_acr_add_products_reviews|substitute:"company_name":$config.Company.company_name}
{/if}
<table width="100%" cellpadding="5" cellspacing="5" style="padding-top: 15px">

{section name=prod_num loop=$products}
<tr>

  <td style="border: 1px solid #EFEFEF; width: 10%; padding: 5px; text-align: center;">
  <a href="{$catalogs.customer}/product.php?productid={$products[prod_num].productid}">{include file="product_thumbnail.tpl" productid=$products[prod_num].productid image_x=$products[prod_num].image_x product=$products[prod_num].product tmbn_url=$products[prod_num].image_url}</a> 
  </td>

  <td>
  {$lng.lbl_acr_review_for} <a href="{$catalogs.customer}/add_review.php?productid={$products[prod_num].productid}&author={$fullname_url}">{$products[prod_num].product}</a>
  </td>
</tr>
{/section}

</table>
<br />
{include file="mail/html/signature.tpl"}

