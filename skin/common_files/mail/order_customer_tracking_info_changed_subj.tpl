{*
528f88104626646f29d17b82818b980d0f42236a, v1 (xcart_4_7_8), 2017-05-26 16:11:43, order_customer_tracking_info_changed_subj.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}{$config.Company.company_name}: {$lng.eml_order_customer_tracking_info_changed_subj|substitute:"orderid":$order.orderid}
