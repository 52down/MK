{*
8abdf261b8f31859646c67a2609de7068f6d250f, v6 (xcart_4_7_8), 2017-05-24 12:13:45, gmap.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{strip}
{if $config.General.google_maps_api_key}
{capture name="gmap"}
    <strong>{$description.name}</strong><br />
    ({if $description.type eq "shipping"}
        {$lng.lbl_shipping_address}
    {else}
        {$lng.lbl_billing_address}
    {/if})<br />
    {$description.address}<br />
    {$lng.lbl_phone}: {$description.phone}
{/capture}
<a href="javascript:void(0);" onclick="javascript:GMap.showModal('{$address|escape:htmlcompat|escape:javascript}','{$smarty.capture.gmap|escape:htmlcompat|escape:javascript}');" class="gmarker{if $show_text eq "Y"} gmaker-with-text{/if}">{if $show_text eq "Y"}{$lng.lbl_gmap_show}{/if}</a>
{elseif $parent_tpl ne 'orders_list'}
    <span class="warning">{$lng.txt_no_google_maps_key}</span>
{/if}
{/strip}
