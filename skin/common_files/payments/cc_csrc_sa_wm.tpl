{*
6304b1d0f6f1187cf52b94c289072dabf7559ce0, v2 (xcart_4_7_4), 2015-08-17 13:11:11, cc_csrc_sa_wm.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
<h1>CyberSource - Secure Acceptance Web/Mobile</h1>
{$lng.txt_cc_configure_top_text}
<br /><br />
{$lng.txt_cc_csrc_sa_wm_configure_note|substitute:"current_location":$current_location}
<br /><br />
{capture name=dialog}
    <form action="cc_processing.php?cc_processor={$smarty.get.cc_processor|escape:"url"}" method="post" enctype="multipart/form-data">
        <table cellspacing="10">
            <tr>
                <td>{$lng.lbl_cc_currency}:</td>
                <td>
                    {include file="main/select_currency.tpl" name="param03" current_currency=$module_data.param03}
                </td>
            </tr>
            <tr>
                <td>{$lng.lbl_cc_testlive_mode}:</td>
                <td>
                    <select name="testmode">
                        <option value="Y"{if $module_data.testmode eq "Y"} selected="selected"{/if}>{$lng.lbl_cc_testlive_test}</option>
                        <option value="N"{if $module_data.testmode eq "N"} selected="selected"{/if}>{$lng.lbl_cc_testlive_live}</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>{$lng.lbl_use_preauth_method}:</td>
                <td>
                    <select name="use_preauth">
                        <option value="">{$lng.lbl_auth_and_capture_method}</option>
                        <option value="Y"{if $module_data.use_preauth eq "Y"} selected="selected"{/if}>{$lng.lbl_auth_method}</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>{$lng.lbl_cc_order_prefix}:</td>
                <td><input type="text" name="param04" size="32" value="{$module_data.param04|escape}" /></td>
            </tr>

            <tr>
                <td colspan="2"><hr /></td>
            </tr>

            <tr>
                <td>{$lng.lbl_cc_csrc_profileid}:</td>
                <td><input type="text" name="param01" size="32" value="{$module_data.param01|escape}" /></td>
            </tr>
            <tr>
                <td>{$lng.lbl_cc_csrc_access_key}:</td>
                <td><input type="text" name="access_key" size="32" value="{$module_data.params.access_key|escape}" /></td>
            </tr>
            <tr>
                <td>{$lng.lbl_cc_csrc_secret_key}:</td>
                <td><textarea name="secret_key" cols="64" rows="4">{$module_data.params.secret_key|escape}</textarea></td>
            </tr>
            <tr>
                <td><hr /></td>
            </tr>

        </table>
        <br /><br />
        <input type="submit" value="{$lng.lbl_update|strip_tags:false|escape}" />
    </form>
{/capture}
{include file="dialog.tpl" title=$lng.lbl_cc_settings content=$smarty.capture.dialog extra='width="100%"'}
