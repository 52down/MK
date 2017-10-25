{*
ed4cc33571c303f96edf738cfbadb95c238c98a1, v3 (xcart_4_6_5), 2014-08-25 18:15:16, category_selector.tpl, aim
vim: set ts=2 sw=2 sts=2 et:
*}
{load_defer file="js/category_selector.js" type="js"}
<div id='layer' style="display:none; position:absolute; background-color:#FFFBD3; border:1px solid #000000;left:0px;top:0px;z-index: 10;"></div>
<iframe  scrolling="no" frameborder="0" style="position:absolute;top:0px;left:0px;display:none;width:100px;height:14px;" id="iframe" src="{$ImagesDir}/spacer.gif"></iframe>
<select id="{$id}" name="{$name}" multiple="multiple" size="7" style="width: 99%; min-width: 200px;" onchange="javascript: showTitle(this.options[this.selectedIndex].text, 'right');">
  <option value="home" {if $banner.home_page eq 'Y'}selected="selected"{/if}>---{$lng.lbl_bs_home_page}---</option>
  <option value="pages" {if $banner.pages eq 'Y'}selected="selected"{/if}>---{$lng.lbl_bs_secondary_pages}---</option>
  {foreach from=$categories item=c key=catid}
    <option value="{$catid}" {if $c.selected eq 'Y'} selected="selected"{/if}>{$c.category_path}</option>
  {/foreach}
</select>
<script type="text/javascript">
//<![CDATA[
   $("#{$id}").resizable();
//]]>
</script>
