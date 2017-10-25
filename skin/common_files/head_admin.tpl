{*
9841fb6a094be1959d94fe3034de4f0194b94b3d, v8 (xcart_4_7_5), 2016-01-22 11:30:49, head_admin.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $login ne ""}
{include file="quick_search.tpl"}
{/if}

<div id="head-admin">

  <div id="logo-gray">
    <a href="{$current_area}/home.php"><img src="{$ImagesDir}/logo_gray.png" alt="" /></a>
  </div>

  {if $login}

    {getvar var='top_news' func='func_tpl_get_admin_top_news'}
    {if $top_news}
      <div class="admin-top-news">
        {$top_news.description|default:$top_news.title}
      </div>
    {/if}

    <div id="admin-top-menu">
        <ul>
        {include file="admin/top_menu.tpl"}
        </ul>
    </div>

  {/if}

  <div class="clearing"></div>

  {if $login and $menu}
    {include file="`$menu`/menu_box.tpl"}
  {/if}

</div>
