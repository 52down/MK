{*
a74fe6885509c651f2ee37e8b41267a193293cc7, v1 (xcart_4_7_0), 2015-02-27 17:35:59, bottom.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<div class="box">

  <div class="wrapper-box">

    {if $active_modules.Users_online}
      {include file="modules/Users_online/menu_users_online.tpl"}
    {/if}
    <div class="footer-links">
      <a href="help.php">{$lng.lbl_help_zone}</a>
      <a href="help.php?section=contactus&amp;mode=update">{$lng.lbl_contact_us}</a>
      {foreach from=$pages_menu item=p}
        {if $p.show_in_menu eq 'Y'}
          <a href="pages.php?pageid={$p.pageid}">{$p.title|amp}</a>
        {/if}
      {/foreach}
    </div>

    <div class="subbox">
      <div class="prnotice">
        {include file="main/prnotice.tpl"}
      </div>
      <div class="copyright">
        {include file="copyright.tpl"}
      </div>
      {if $active_modules.Socialize}
        {include file="modules/Socialize/footer_links.tpl"}
      {/if}
    </div>

  </div><!--/wrapper-box-->

</div>
