{*
8d6dd9adb53834c62472b5eb98980c6447d5dad8, v6 (xcart_4_7_8), 2017-03-13 12:47:33, address_buttons.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
<div class="buttons-box">
    <a href="javascript:void(0);" class="update-profile" title="{$lng.lbl_save}" style="display: none;" tabindex="-1">{$lng.lbl_save}</a>
    {* <a href="javascript:void(0);" class="restore-value" title="{$lng.lbl_restore}" style="display: none;" tabindex="-1"></a> *}
    {if $change_mode ne 'Y'}
        <a href="javascript:void(0);" class="edit-profile" id="pencil_edit_opc_profile" title="{$lng.lbl_change}" tabindex="-1"></a>
    {elseif not $active_modules.Bongo_International}
        <a href="javascript:void(0);" class="cancel-edit" id="cross_cancel_edit_opc_profile" title="{$lng.lbl_cancel}" tabindex="-1"></a>
    {/if}
</div>

