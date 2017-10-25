{*
141c878b03b2b0cdd5d2b31c952f4e1031962148, v10 (xcart_4_7_8), 2017-05-18 15:44:49, service_head.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{get_title page_type=$meta_page_type page_id=$meta_page_id}
{include file="customer/meta.tpl"}
{include file="customer/service_js.tpl"}
{include file="customer/service_css.tpl"}

<link rel="shortcut icon" type="image/png" href="{$current_location}/favicon.ico" />

{if $config.SEO.canonical eq 'Y' or $active_modules.Segment}
  <link rel="canonical" href="{$current_location}/{$canonical_url}" />
{/if}
{if $config.SEO.clean_urls_enabled eq "Y"}
  <base href="{$catalogs.customer}/" />
{/if}

{if $active_modules.Refine_Filters}
  {include file="modules/Refine_Filters/service_head.tpl"}
{/if}

{if $active_modules.Socialize ne ""}
  {include file="modules/Socialize/service_head.tpl"}
{/if}

{if $active_modules.Lexity ne ""}
  {include file="modules/Lexity/service_head.tpl"}
{/if}

{if $active_modules.Bongo_International}
  {include file="modules/Bongo_International/service_head.tpl"}
{/if}

{if $active_modules.Facebook_Ecommerce}
  {include file="modules/Facebook_Ecommerce/base_snippet_head.tpl"}
{/if}

{load_defer_code type="css"}
{load_defer_code type="js"}
