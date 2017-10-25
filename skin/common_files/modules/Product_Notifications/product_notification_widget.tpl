{*
f796cd4ac105eb160691c59c49e70773bd16b2d8, v8 (xcart_4_7_7), 2016-09-01 16:39:33, product_notification_widget.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{capture name=prod_notif_javascript_code}
/*
 * Constants used in product notifications widgets
 */
var ProductNotificationWidget_CONST = {ldelim}
  /* Language variables */
  PROD_NOTIF_EMAIL_REGEXP: new RegExp("{$email_validation_regexp|wm_remove|escape:javascript}", "gi"),
  ERR_PROD_NOTIF_EMAIL: "{$lng.err_prod_notif_email|wm_remove|escape:javascript}",
  ERR_SUBMIT_PROD_NOTIF_UNKNOWN: "{$lng.err_submit_prod_notif_unknown|wm_remove|escape:javascript}",
  MSG_SUBMIT_PROD_NOTIF_OK: "{$lng.msg_submit_prod_notif_ok|wm_remove|escape:javascript}",
  MSG_PROD_NOTIF_ALREADY_SUBSCRIBED: "{$lng.msg_prod_notif_already_subscribed|wm_remove|escape:javascript}",
  LBL_PROD_NOTIF_EMAIL_DEFAULT: "{$lng.lbl_prod_notif_email_default|wm_remove|escape:javascript}",

  /* Config variables */
  PROD_NOTIF_L_AMOUNT: {$config.Product_Notifications.prod_notif_L_amount|default:3},

  /* HTML elements IDs */
  ROOT_ELEMENT_ID_PREFIX: 'prod_notif_',
  REQUEST_BUTTON_ELEMENT_ID_PREFIX: 'prod_notif_request_button_',
  EMAIL_INPUT_ELEMENT_ID_PREFIX: 'prod_notif_email_',
  SUBMIT_BUTTON_ELEMENT_ID_PREFIX: 'prod_notif_submit_button_',
  SUBMIT_WAITING_ELEMENT_ID_PREFIX: 'prod_notif_submit_waiting_',
  MESSAGE_ELEMENT_ID_PREFIX: 'prod_notif_submit_message_',

  /* CSS class names */
  ERROR_MSG_CSS: 'prod-notif-request-submit-error-message',
  INVALID_EMAIL_CSS: 'prod-notif-email-error',
  DEFAULT_EMAIL_CSS: 'prod-notif-email-default-value',

  /* Tooltip behavior */
  TOOLTIP_EFFECT_SHOW_EFFECT: 'fadeIn',
  TOOLTIP_EFFECT_HIDE_EFFECT: 'fadeOut',
  TOOLTIP_EFFECT_DELAY: 300,

  /* Widget behavior */
  REQUEST_FORM_SLIDE_DELAY: 300,
  PROD_NOTIF_SUBMIT_PHP: '{$xcart_web_dir}/product_notifications.php',
  PROD_NOTIF_SUBMIT_MODE: 'subscribe'
{rdelim};
{/capture}

{load_defer file="prod_notif_javascript_code" direct_info=$smarty.capture.prod_notif_javascript_code type="js"}
{if $development_mode_enabled}
    {load_defer file="lib/jqueryui/components/tooltip.js" type="js"}
    {* load via deffer since tpl loaded in head -> service_js.tpl *}
    {load_defer file="lib/jqueryui/components/tooltip.css" type="css"}
{else}
    {load_defer file="lib/jqueryui/components/tooltip.min.js" type="js"}
    {* load via deffer since tpl loaded in head -> service_js.tpl *}
    {load_defer file="lib/jqueryui/components/tooltip.min.css" type="css"}
{/if}
{load_defer file="modules/Product_Notifications/product_notification_widget.js" type="js"}
