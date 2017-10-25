{*
f02a1a0b1a70d8f7247467b594775789e415ff2b, v2 (xcart_4_7_4), 2015-09-10 21:26:11, acr_review_reminder.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="mail/salutation.tpl" title=$userinfo.title firstname=$userinfo.firstname lastname=$userinfo.lastname}

{if $config.Advanced_Customer_Reviews.acr_reward_coupon_discount gt 0}
{$lng.txt_acr_add_products_reviews_coupon|substitute:"company_name":$config.Company.company_name:"discount_coupon":$discount_coupon}
{else}
{$lng.txt_acr_add_products_reviews|substitute:"company_name":$config.Company.company_name}
{/if}

{section name=prod_num loop=$products}
 - {$lng.lbl_acr_review_for} {$products[prod_num].product} ({$catalogs.customer}/add_review.php?productid={$products[prod_num].productid}&author={$fullname_url})
{/section}


{include file="mail/signature.tpl"}
