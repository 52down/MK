{*
b00f54887428e3836369a99d55eda321cfa5c047, v3 (xcart_4_7_7), 2016-09-28 19:20:49, modules_tags.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $modules_filter_tags}
{load_defer file="admin/js/module_tags.js" type="js"}
{$lng.lbl_modules_filter_by_tag}
<div class="modules-tags">
{foreach from=$modules_filter_tags item=tag key=tag_key}
  <div class="modules-tag">
    <input type="radio" name="selectedtags_{$tag_type}" id="tag_{$tag_type}_{$tag_key}" class="ui-helper-hidden-accessible" onclick="javascript: toggleTag('{$tag_key}','{$tag_type}');"{if $tag.checked} checked="checked"{/if} /><label for="tag_{$tag_type}_{$tag_key}" class="ui-button ui-widget ui-corner-all ui-button-text-only"><span class="ui-button-text">{$tag.label} <span class="tag-count">{$tag.count}</span></span></label>
  </div>
{/foreach}
</div>
{/if}
