{*
f02a1a0b1a70d8f7247467b594775789e415ff2b, v1 (xcart_4_7_4), 2015-09-10 21:26:11, acr_your_coupon_subj.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{config_load file="$skin_config"}{$lng.eml_acr_your_coupon_subj|substitute:"user":$fullname:"company_name":$config.Company.company_name:"discount_coupon":$discount_coupon}
