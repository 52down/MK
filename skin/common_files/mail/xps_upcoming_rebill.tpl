{*
a26546caee6d4cd5438ef532e0f1d5a40f4b83f1, v4 (xcart_4_7_6), 2016-06-10 12:05:52, xps_upcoming_rebill.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{include file="mail/mail_header.tpl"}


{include file="mail/salutation.tpl" title=$userinfo.title firstname=$userinfo.firstname lastname=$userinfo.lastname}

{$lng.eml_xps_upcoming_rebill_info|substitute:days:$config.XPayments_Subscriptions.xps_notification_days}

{$lng.lbl_product_name}: {$product.product}
{$lng.lbl_xps_date_of_next_payment}: {$subscription.real_next_date|date_format:$config.Appearance.date_format}
{$lng.lbl_xps_subscription_fee}: {currency value=$subscription.fee plain_text_message=Y} {alter_currency value=$subscription.fee plain_text_message=Y}

{include file="mail/signature.tpl"}
