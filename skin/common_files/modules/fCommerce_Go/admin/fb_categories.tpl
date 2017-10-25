{*
931c70159b5130bf19ddb9890eda9bb837333c55, v2 (xcart_4_7_4), 2015-08-11 15:10:10, fb_categories.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<ul class="fb-shop-categories-list level-{$level}">
  {foreach from=$categories item=c}
    <li class="fb-shop-category-item{if $level gt 0} {cycle values="TableSubHead,white-bg"}{/if}{if $c.childs && $fb_shop_config.expanded_category[$c.categoryid] eq 'Y'} opened{/if}"{if $c.avail neq 'Y'} title="{$lng.txt_category_disabled}"{/if}>
      {if $c.childs}
        <span class="expand-collapse{if $fb_shop_config.expanded_category[$c.categoryid] neq 'Y'} closed{/if}"></span>
        <input type="hidden" class="expanded-category" name="fb_shop_config[expanded_category][{$c.categoryid}]" value="{$fb_shop_config.expanded_category[$c.categoryid]}" />
      {/if}
      <label><input type="checkbox" class="level-{$level}" name="fb_shop_config[categories_menu][]" value="{$c.categoryid}"{if ($fb_shop_config.categories_menu and in_array($c.categoryid, $fb_shop_config.categories_menu)) or (not $fb_shop_config.categories_menu and $fb_config_is_empty)} checked="checked"{/if} {if $c.avail neq 'Y'} disabled="disabled"{/if}/><span class="{if $c.avail neq 'Y'} disabled{/if}{if $level eq 0} root-category-title{/if}">{$c.category}</span></label>
      {if $c.childs}
        {include file="modules/fCommerce_Go/admin/fb_categories.tpl" level=$level+1 categories=$c.childs roots="`$roots`,`$c.categoryid`"}
      {/if}
    </li>
  {/foreach}
</ul>
