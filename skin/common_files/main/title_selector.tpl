{*
7e396bda7a213f4ae800e7edef50cb7a5d5381d8, v5 (xcart_4_7_8), 2017-04-19 10:42:34, title_selector.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<select name="{$name|default:"title"}" id="{$id|default:"title"}" {include file="main/attr_orig_data.tpl" data_orig_type=$data_orig_type data_orig_value=$data_orig_value data_orig_keep_empty=$data_orig_keep_empty}>
{if $titles}
{foreach from=$titles item=v}
  <option value="{if $use_title_id eq "Y"}{$v.titleid}{else}{$v.title_orig|escape}{/if}"{if ($val eq $v.titleid) or ($compare_title_text eq "Y" and $val|escape eq $v.title_orig|escape)} selected="selected"{/if}>{$v.title}</option>
{/foreach}
{else}
  <option value="{if $use_title_id eq "Y"}{$val}{/if}" selected="selected">{$lng.txt_no_titles_defined}</option>
{/if}
</select>
