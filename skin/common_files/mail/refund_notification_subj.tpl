{*
9ed27b112a46cb360618b909a81f51dd2038c4d5, v1 (xcart_4_7_7), 2017-01-23 15:04:06, refund_notification_subj.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}{$config.Company.company_name}: {$lng.eml_refund_notification_subj|substitute:"orderid":$order.orderid}
