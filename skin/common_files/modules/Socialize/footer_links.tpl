{*
29051901dc7456d195c2b063ac70069d9a6a54b4, v6 (xcart_4_7_4), 2015-08-24 12:44:49, footer_links.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{if $active_modules.Socialize and ($config.Socialize.soc_fb_page_url ne "" or $config.Socialize.soc_tw_user_name ne "") and $usertype eq "C"}
  <ul class="soc-footer-links">
    {if $config.Socialize.soc_fb_page_url ne ""}
      <li><a href="{$config.Socialize.soc_fb_page_url}" target="_blank"><img src="{$SkinDir}/modules/Socialize/images/facebook.png" title="{$lng.lbl_soc_facebook}" alt="{$lng.lbl_soc_facebook}" /></a></li>
    {/if}
    {if $config.Socialize.soc_tw_user_name ne ""}
      <li><a href="http://twitter.com/{$config.Socialize.soc_tw_user_name}" target="_blank"><img src="{$SkinDir}/modules/Socialize/images/twitter.png" title="{$lng.lbl_soc_twitter}" alt="{$lng.lbl_soc_twitter}" /></a></li>
    {/if}
    {if $config.Socialize.soc_pin_username ne ""}
      <li><a href="http://pinterest.com/{$config.Socialize.soc_pin_username}" target="_blank"><img src="{$SkinDir}/modules/Socialize/images/pinterest.png" title="{$lng.lbl_soc_pinterest}" alt="{$lng.lbl_soc_pinterest}" /></a></li>
    {/if}
  </ul>
{/if}
