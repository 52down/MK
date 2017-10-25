<?php /* Smarty version Smarty-3.1.21-dev, created on 2017-10-22 10:09:30
         compiled from "D:\website\MK\skin\common_files\admin\quick_search.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3267459ec523a22c378-08116538%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e88364161836bb69357d5777aad7cae6716f3d42' => 
    array (
      0 => 'D:\\website\\MK\\skin\\common_files\\admin\\quick_search.tpl',
      1 => 1496750410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3267459ec523a22c378-08116538',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'need_quick_search' => 0,
    'lng' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_59ec523a230f49_20039704',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ec523a230f49_20039704')) {function content_59ec523a230f49_20039704($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['need_quick_search']->value=="Y") {?>
    <li class="menu-item quick-search-menu">
        <table>
            <tr>
                <td class="quick-search-form">
                    <form name="qsform" action="" onsubmit="javascript: quick_search($('#quick_search_query').val()); return false;">
                        <input type="text" class="default-value" id="quick_search_query" onkeypress="javascript:$('#quick_search_panel').hide();" onclick="javascript:$('#quick_search_panel').hide();" placeholder="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['lng']->value['lbl_keywords'], ENT_QUOTES, 'UTF-8', true);?>
" />
                    </form>
                </td>
                <td class="main-button">
                    <button onclick="javascript:quick_search($('#quick_search_query').val());return false;">
                        <?php echo $_smarty_tpl->tpl_vars['lng']->value['lbl_search'];?>

                    </button>
                </td>
                <td>
                    <?php echo $_smarty_tpl->getSubTemplate ("main/tooltip_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('text'=>$_smarty_tpl->tpl_vars['lng']->value['txt_how_quick_search_works'],'id'=>"qs_help",'type'=>"img",'alt_image'=>"question_gray.png",'wrapper_tag'=>"div"), 0);?>

                </td>
            </tr>
        </table>
    </li>
<?php }?>
<?php }} ?>
