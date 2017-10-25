{*
0520abd712e523c608eb0fbbf22828c2c67d6257, v2 (xcart_4_7_7), 2016-10-03 16:47:26, payment_xcc.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{include file="widgets/creditcardform/creditcardform.tpl" containerName="transparent-redirect-box" cardCode="Y"}

{if $payment_standalone eq ''}
{load_defer file="lib/jquery.bind-first.min.js" type="js"}
{load_defer file="js/ps_paypal_redirect.js" type="js"}
{/if}

{getvar var='paypal_redirect_payment_id' func='func_paypal_get_redirect_payment_id'}

{capture name=paypal_redirect_javascript_code}
var pptr_msg_token_error  = '{$lng.txt_ajax_error_note|wm_remove|escape:"javascript"}';
var pptr_msg_being_placed = '{$lng.msg_order_is_being_placed|wm_remove|escape:"javascript"}';
$(document).ready(function() {ldelim}
    new ajax.widgets.paypal_redirect('{$paypal_redirect_payment_id}');
{rdelim});
{/capture}
{load_defer file="paypal_redirect_javascript_code_file" direct_info=$smarty.capture.paypal_redirect_javascript_code type="js"}
