{*
41562c5cfeb62cd856c8982b2d194c8a49e4f4c3, v10 (xcart_4_7_7), 2016-12-26 19:10:26, order_data.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{$lng.lbl_products_ordered}:
-----------------

{section name=prod_num loop=$products}
{$lng.lbl_sku|mail_truncate}{$products[prod_num].productcode}
{$lng.lbl_product|mail_truncate}{$products[prod_num].product}
{$lng.lbl_quantity|mail_truncate}{$products[prod_num].amount}
{if $products[prod_num].product_options ne ""}
{$lng.lbl_selected_options}:
{include file="modules/Product_Options/display_options.tpl" options=$products[prod_num].product_options options_txt=$products[prod_num].product_options_txt is_plain="Y"}
{/if}
{$lng.lbl_item_price|mail_truncate}{currency value=$products[prod_num].display_price display_sign=$product.extra_data.price_show_sign plain_text_message=Y}
{if $order.extra.tax_info.display_cart_products_tax_rates eq "Y" and $_userinfo.tax_exempt ne "Y"}

{foreach from=$products[prod_num].extra_data.taxes key=tax_name item=tax}
{if $tax.tax_value gt 0}{$tax.tax_display_name} {if $tax.rate_type eq "%"}{include file="main/display_tax_rate.tpl" value=$tax.rate_value}%{else}{currency value=$tax.rate_value plain_text_message=Y}{/if}{/if}

{/foreach}
{/if}


{/section}
{section name=giftcert loop=$giftcerts}
{$lng.lbl_gift_certificate|mail_truncate}{$giftcerts[giftcert].gcid}
{$lng.lbl_amount|mail_truncate}{currency value=$giftcerts[giftcert].amount plain_text_message=Y}

{$lng.lbl_recipient|mail_truncate}{$giftcerts[giftcert].recipient}
{if $giftcerts[giftcert].send_via eq "P"}
{$lng.lbl_gc_send_via_postal_mail}
{$lng.lbl_mail_address|mail_truncate}{$giftcerts[giftcert].recipient_firstname} {$giftcerts[giftcert].recipient_lastname}
    {$giftcerts[giftcert].recipient_address}, {$giftcerts[giftcert].recipient_city},
    {if $giftcerts[giftcert].recipient_countyname ne ''}{$giftcerts[giftcert].recipient_countyname} {/if}{$giftcerts[giftcert].recipient_state} {$giftcerts[giftcert].recipient_country}, {$giftcerts[giftcert].recipient_zipcode}
{$lng.lbl_phone|mail_truncate}{$giftcerts[giftcert].recipient_phone}
{else}
{$lng.lbl_recipient_email|mail_truncate}{$giftcerts[giftcert].recipient_email}
{/if}

{/section}

{$lng.lbl_total}:
-------
{$lng.lbl_payment_method|mail_truncate}{$order.payment_method}
{$lng.lbl_delivery|mail_truncate}{$order.shipping|trademark:'use_alt'}
{$lng.lbl_subtotal|mail_truncate}{currency value=$order.display_subtotal plain_text_message=Y}

{if $order.discount gt 0}{$lng.lbl_discount|mail_truncate}{currency value=$order.discount plain_text_message=Y}{/if}

{if $order.coupon and $order.coupon_type ne "free_ship"}
{$lng.lbl_coupon_saving|mail_truncate}{currency value=$order.coupon_discount plain_text_message=Y} ({$order.coupon})
{/if}
{if $order.discounted_subtotal ne $order.subtotal}
{$lng.lbl_discounted_subtotal|mail_truncate}{currency value=$order.display_discounted_subtotal plain_text_message=Y}

{/if}
{$lng.lbl_shipping_cost|mail_truncate}{if $order.coupon and $order.coupon_type eq "free_ship"}{currency value=0 plain_text_message=Y}{else}{currency value=$order.display_shipping_cost plain_text_message=Y}{/if}
{if $active_modules.Pitney_Bowes}
{include file="modules/Pitney_Bowes/shipping_details.tpl" nohtml='Y'}
{/if}

{if $order.need_giftwrap eq "Y"}
{$lng.lbl_giftreg_gift_wrapping|mail_truncate}{currency value=$order.giftwrap_cost plain_text_message=Y}
{/if}

{if $order.coupon and $order.coupon_type eq "free_ship"}
{$lng.lbl_free_ship_coupon_record|substitute:"code":$order.coupon}
{/if}

{if $order.applied_taxes and $order.extra.tax_info.display_taxed_order_totals ne "Y"}
{foreach key=tax_name item=tax from=$order.applied_taxes}
{if $tax.rate_type eq "%"}{include file="main/display_tax_rate.tpl" value=$tax.rate_value assign="rate_value"}{assign var="tax_display_name" value="`$tax.tax_display_name` `$rate_value`%"}{else}{assign var="tax_display_name" value=$tax.tax_display_name}{/if}{$tax_display_name|mail_truncate}{currency value=$tax.tax_cost plain_text_message=Y}

{/foreach}
{/if}
{if $order.payment_surcharge ne 0}
{if $order.payment_surcharge gt 0}{$lng.lbl_payment_method_surcharge|mail_truncate}{else}{$lng.lbl_payment_method_discount|mail_truncate}{/if}{currency value=$order.payment_surcharge plain_text_message=Y}
{/if}
{if $order.giftcert_discount gt 0}
{$lng.lbl_giftcert_discount|mail_truncate}{currency value=$order.giftcert_discount plain_text_message=Y}
{/if}

{$lng.lbl_total|mail_truncate}{currency value=$order.total plain_text_message=Y}

{if $_userinfo.tax_exempt ne "Y"}
{if $order.applied_taxes and $order.extra.tax_info.display_taxed_order_totals eq "Y"}
{$lng.lbl_including}:
{foreach key=tax_name item=tax from=$order.applied_taxes}
{if $tax.rate_type eq "%"}{include file="main/display_tax_rate.tpl" value=$tax.rate_value assign="rate_value"}{assign var="tax_display_name" value="`$tax.tax_display_name` `$rate_value`%"}{else}{assign var="tax_display_name" value=$tax.tax_display_name}{/if}{$tax_display_name|mail_truncate}{currency value=$tax.tax_cost plain_text_message=Y}

{/foreach}
{/if}
{else}
{$lng.txt_tax_exemption_applied|strip_tags}
{/if}

{if $order.applied_giftcerts}
{$lng.lbl_applied_giftcerts}:
{section name=gc loop=$order.applied_giftcerts}
    {$order.applied_giftcerts[gc].giftcert_id|mail_truncate}{currency value=$order.applied_giftcerts[gc].giftcert_cost plain_text_message=Y}

{/section}
{/if}

{if $order.extra.special_bonuses ne ""}
{include file="mail/special_offers_order_bonuses.tpl" bonuses=$order.extra.special_bonuses}
{/if}

{if $order.extra.bongo_checkout ne "" and $active_modules.Bongo_International}
  {include file="modules/Bongo_International/mail/order_data.tpl"}
{/if}

{if $order.extra.interaco ne ""}
{include file="payments/cc_bean_interaco_report.tpl" plainText="Y"}
{/if}

{if $active_modules.Pitney_Bowes}
{include file="modules/Pitney_Bowes/order_tracking.tpl" nohtml='Y'}
{/if}
