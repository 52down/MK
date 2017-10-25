{*
cbd5b33537a292f5a3d487cfe98638e2e7f94a89, v4 (xcart_4_7_5), 2016-02-08 20:36:40, quick_search.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}
{if $need_quick_search eq "Y"}
    <li class="menu-item quick-search-menu">
        <table>
            <tr>
                <td class="quick-search-form">
                    <form name="qsform" action="" onsubmit="javascript: quick_search($('#quick_search_query').val()); return false;">
                        <input type="text" class="default-value" id="quick_search_query" onkeypress="javascript:$('#quick_search_panel').hide();" onclick="javascript:$('#quick_search_panel').hide();" placeholder="{$lng.lbl_keywords|escape}" />
                    </form>
                </td>
                <td class="main-button">
                    <button onclick="javascript:quick_search($('#quick_search_query').val());return false;">
                        {$lng.lbl_search}
                    </button>
                </td>
                <td>
                    {include file="main/tooltip_js.tpl" text=$lng.txt_how_quick_search_works id="qs_help" type="img" alt_image="question_gray.png" wrapper_tag="div"}
                </td>
            </tr>
        </table>
    </li>
{/if}
