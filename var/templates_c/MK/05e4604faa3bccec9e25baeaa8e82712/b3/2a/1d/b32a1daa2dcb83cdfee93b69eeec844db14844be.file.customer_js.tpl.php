<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 09:48:25
         compiled from "D:\website\MK\skin\common_files\modules\Cloud_Search\customer_js.tpl" */ ?>
<?php /*%%SmartyHeaderCode:267959ec4d492788d0-99158493%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b32a1daa2dcb83cdfee93b69eeec844db14844be' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\modules\\Cloud_Search\\customer_js.tpl',
      1 => 1496750452,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '267959ec4d492788d0-99158493',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'config' => 0,
    'active_modules' => 0,
    'cloud_search_currency_rate' => 0,
    'lng' => 0,
    'cloud_search_dynamic_prices' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec4d492b6086_01217372',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec4d492b6086_01217372')) {function content_59ec4d492b6086_01217372($_smarty_tpl) {?><?php if (!is_callable('smarty_function_currency')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.currency.php';
if (!is_callable('smarty_function_load_defer')) include 'D:\\website\\MK\\include\\templater\\plugins\\function.load_defer.php';
?>
<?php $_smarty_tpl->_capture_stack[0][] = array('cloud_search_js', null, null); ob_start(); ?>

var Cloud_Search = {
  apiKey: '<?php echo strtr($_smarty_tpl->tpl_vars['config']->value['cloud_search_api_key'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
  price_template: '<?php echo smarty_function_currency(array('value'=>0.0),$_smarty_tpl);?>
',
  <?php if ($_smarty_tpl->tpl_vars['active_modules']->value['XMultiCurrency']&&$_smarty_tpl->tpl_vars['cloud_search_currency_rate']->value) {?>
  currencyRate: <?php echo $_smarty_tpl->tpl_vars['cloud_search_currency_rate']->value;?>
,
  <?php }?>
  lang: {
    'lbl_showing_results_for': '<?php echo strtr($_smarty_tpl->tpl_vars['lng']->value['lbl_cloud_search_showing_results_for'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
    'lbl_see_details': '<?php echo strtr($_smarty_tpl->tpl_vars['lng']->value['lbl_see_details'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
    'lbl_see_more_results_for': '<?php echo strtr($_smarty_tpl->tpl_vars['lng']->value['lbl_cloud_search_see_more_results_for'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
    'lbl_suggestions': '<?php echo strtr($_smarty_tpl->tpl_vars['lng']->value['lbl_cloud_search_suggestions'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
    'lbl_products': '<?php echo strtr($_smarty_tpl->tpl_vars['lng']->value['lbl_products'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
    'lbl_categories': '<?php echo strtr($_smarty_tpl->tpl_vars['lng']->value['lbl_cloud_search_categories'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
    'lbl_manufacturers': '<?php echo strtr($_smarty_tpl->tpl_vars['lng']->value['lbl_cloud_search_manufacturers'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
    'lbl_pages': '<?php echo strtr($_smarty_tpl->tpl_vars['lng']->value['lbl_cloud_search_pages'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
',
    'lbl_did_you_mean': '<?php echo strtr($_smarty_tpl->tpl_vars['lng']->value['lbl_cloud_search_did_you_mean'], array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'
  }
};

<?php if ($_smarty_tpl->tpl_vars['cloud_search_dynamic_prices']->value) {?>
    

    (function () {
        var ajax = null;

        Cloud_Search.EventHandlers = {
            OnPopupRender: [
                function () {
                    var popup = $('#instant_search_menu'),
                        products = $('.block-products dd', popup),
                        prices = products.find('.price .currency'),
                        pids = [];

                    prices.hide();

                    ajax !== null && ajax.abort();

                    products.each(function () {
                        pids.push($(this).attr('data-id'));
                    });

                    if (pids) {
                        ajax = $.getJSON(
                            xcart_web_dir + '/cloud_search_api.php',
                            { method: 'get_prices', ids: pids.join(',') },
                            updatePrices
                        );
                    }

                    function updatePrices(actualPrices) {
                        prices.each(function (index) {
                            var e = $(this),
                                priceHtml = e.html(),
                                price = actualPrices[index];

                            price !== null && e.html(priceHtml.replace(/[\d\.\,]+/, price));
                        }).show();
                    }
                }
            ]
        };
    })();

    
<?php }?>


(function () {
  var cs = document.createElement('script'); cs.type = 'text/javascript'; cs.async = true;
  cs.src = '//cdn-qualiteamsoftwar.netdna-ssl.com/cloud_search_xcart.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(cs, s);
})();



<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php echo smarty_function_load_defer(array('file'=>"cloud_search_js",'direct_info'=>Smarty::$_smarty_vars['capture']['cloud_search_js'],'type'=>"js"),$_smarty_tpl);?>

<?php echo smarty_function_load_defer(array('file'=>"modules/Cloud_Search/js/lib/jquery.hoverIntent.minified.js",'type'=>"js"),$_smarty_tpl);?>

<?php echo smarty_function_load_defer(array('file'=>"lib/handlebars.min.js",'type'=>"js"),$_smarty_tpl);?>

<?php }} ?>
