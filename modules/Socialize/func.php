<?php
/* vim: set ts=4 sw=4 sts=4 et: */
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| X-Cart Software license agreement                                           |
| Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>         |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
| PLEASE READ  THE FULL TEXT OF SOFTWARE LICENSE AGREEMENT IN THE "COPYRIGHT" |
| FILE PROVIDED WITH THIS DISTRIBUTION. THE AGREEMENT TEXT IS ALSO AVAILABLE  |
| AT THE FOLLOWING URL: https://www.x-cart.com/license-agreement-classic.html |
|                                                                             |
| THIS AGREEMENT EXPRESSES THE TERMS AND CONDITIONS ON WHICH YOU MAY USE THIS |
| SOFTWARE PROGRAM AND ASSOCIATED DOCUMENTATION THAT QUALITEAM SOFTWARE LTD   |
| (hereinafter referred to as "THE AUTHOR") OF REPUBLIC OF CYPRUS IS          |
| FURNISHING OR MAKING AVAILABLE TO YOU WITH THIS AGREEMENT (COLLECTIVELY,    |
| THE "SOFTWARE"). PLEASE REVIEW THE FOLLOWING TERMS AND CONDITIONS OF THIS   |
| LICENSE AGREEMENT CAREFULLY BEFORE INSTALLING OR USING THE SOFTWARE. BY     |
| INSTALLING, COPYING OR OTHERWISE USING THE SOFTWARE, YOU AND YOUR COMPANY   |
| (COLLECTIVELY, "YOU") ARE ACCEPTING AND AGREEING TO THE TERMS OF THIS       |
| LICENSE AGREEMENT. IF YOU ARE NOT WILLING TO BE BOUND BY THIS AGREEMENT, DO |
| NOT INSTALL OR USE THE SOFTWARE. VARIOUS COPYRIGHTS AND OTHER INTELLECTUAL  |
| PROPERTY RIGHTS PROTECT THE SOFTWARE. THIS AGREEMENT IS A LICENSE AGREEMENT |
| THAT GIVES YOU LIMITED RIGHTS TO USE THE SOFTWARE AND NOT AN AGREEMENT FOR  |
| SALE OR FOR TRANSFER OF TITLE. THE AUTHOR RETAINS ALL RIGHTS NOT EXPRESSLY  |
| GRANTED BY THIS AGREEMENT.                                                  |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

/**
 * Module functions
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    979f91f3df26d7c8c74b6c974ce7799762659cf8, v29 (xcart_4_7_8), 2017-03-16 10:49:26, func.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if (!defined('XCART_START')) {
    header('Location: ../../');
    die('Access denied');
}

/**
 * Get proper language code for the Facebook js-library including
 */
function func_get_facebook_lang_code($store_language)
{//{{{
    global $all_languages;

    $fb_langs = array (
    //{{{
      'Afrikaans' => 'af_ZA',
      'Akan' => 'ak_GH',
      'Albanian' => 'sq_AL',
      'Amharic' => 'am_ET',
      'Arabic' => 'ar_AR',
      'Armenian' => 'hy_AM',
      'Assamese' => 'as_IN',
      'Aymara' => 'ay_BO',
      'Azerbaijani' => 'az_AZ',
      'Basque' => 'eu_ES',
      'Belarusian' => 'be_BY',
      'Bengali' => 'bn_IN',
      'Bhojpuri' => 'bp_IN',
      'Bosnian' => 'bs_BA',
      'Breton' => 'br_FR',
      'Bulgarian' => 'bg_BG',
      'Burmese' => 'qz_MM',
      'Burmese' => 'my_MM',
      'Catalan' => 'ca_ES',
      'Cebuano' => 'cx_PH',
      'Cherokee' => 'ck_US',
      'Chewa' => 'ny_MW',
      'Chinese' => 'zh_CN',
      'Classical Greek' => 'gx_GR',
      'Corsican' => 'co_FR',
      'Croatian' => 'hr_HR',
      'Czech' => 'cs_CZ',
      'Danish' => 'da_DK',
//      'Dutch (België)' => 'nl_BE',
      'Dutch' => 'nl_NL',
//      'English (India)' => 'en_IN',
//      'English (Pirate)' => 'en_PI',
//      'English (UK)' => 'en_GB',
      'English' => 'en_US',
//      'English (Upside Down)' => 'en_UD',
      'Esperanto' => 'eo_EO',
      'Estonian' => 'et_EE',
      'Faroese' => 'fo_FO',
      'Filipino' => 'tl_PH',
      'Finnish' => 'fi_FI',
//      'French (Canada)' => 'fr_CA',
      'French' => 'fr_FR',
      'Frisian' => 'fy_NL',
      'Fula' => 'ff_NG',
      'Galician' => 'gl_ES',
      'Ganda' => 'lg_UG',
      'Georgian' => 'ka_GE',
      'German' => 'de_DE',
      'Greek' => 'el_GR',
      'Guarani' => 'gn_PY',
      'Gujarati' => 'gu_IN',
      'Haitian Creole' => 'ht_HT',
      'Hausa' => 'ha_NG',
      'Hebrew' => 'he_IL',
      'Hindi' => 'hi_IN',
      'Hungarian' => 'hu_HU',
      'Icelandic' => 'is_IS',
      'Igbo' => 'ig_NG',
      'Indonesian' => 'id_ID',
      'Irish' => 'ga_IE',
      'Italian' => 'it_IT',
//      'Japanese (Kansai)' => 'ja_KS',
      'Japanese' => 'ja_JP',
      'Javanese' => 'jv_ID',
      'Kannada' => 'kn_IN',
      'Kashmiri' => 'ks_IN',
      'Kazakh' => 'kk_KZ',
      'Khmer' => 'km_KH',
      'Kinyarwanda' => 'rw_RW',
      'Klingon' => 'tl_ST',
      'Korean' => 'ko_KR',
      'Kurdish' => 'ku_TR',
      'Kyrgyz' => 'ky_KG',
      'Lao' => 'lo_LA',
      'Latin' => 'la_VA',
      'Latvian' => 'lv_LV',
      'Leet Speak' => 'fb_LT',
      'Limburgish' => 'li_NL',
      'Lingala' => 'ln_CD',
      'Lithuanian' => 'lt_LT',
      'Macedonian' => 'mk_MK',
      'Malagasy' => 'mg_MG',
      'Malay' => 'ms_MY',
      'Malayalam' => 'ml_IN',
      'Maltese' => 'mt_MT',
      'Marathi' => 'mr_IN',
      'Mongolian' => 'mn_MN',
      'Māori' => 'mi_NZ',
      'Nepali' => 'ne_NP',
      'Northern Ndebele' => 'nd_ZW',
      'Northern Sotho' => 'ns_ZA',
      'Northern Sámi' => 'se_NO',
      'Norwegian (bokmal)' => 'nb_NO',
      'Norwegian (nynorsk)' => 'nn_NO',
      'Oriya' => 'or_IN',
      'Pashto' => 'ps_AF',
      'Persian' => 'fa_IR',
      'Polish' => 'pl_PL',
//    'Portuguese (Brazil)' => 'pt_BR',
      'Portuguese' => 'pt_PT',
      'Punjabi' => 'pa_IN',
      'Quechua' => 'qu_PE',
      'Quiché' => 'qc_GT',
      'Romanian' => 'ro_RO',
      'Romansh' => 'rm_CH',
      'Russian' => 'ru_RU',
      'Sanskrit' => 'sa_IN',
      'Sardinian' => 'sc_IT',
      'Serbian' => 'sr_RS',
      'Shona' => 'sn_ZW',
      'Silesian' => 'sz_PL',
//    'Simplified Chinese (China)' => 'zh_CN',
      'Sinhala' => 'si_LK',
      'Slovak' => 'sk_SK',
      'Slovenian' => 'sl_SI',
      'Somali' => 'so_SO',
      'Sorani Kurdish' => 'cb_IQ',
      'Southern Ndebele' => 'nr_ZA',
      'Southern Sotho' => 'st_ZA',
//    'Spanish (Chile)' => 'es_CL',
//    'Spanish (Colombia)' => 'es_CO',
//    'Spanish (Mexico)' => 'es_MX',
      'Spanish' => 'es_ES',
//    'Spanish (Venezuela)' => 'es_VE',
//    'Spanish' => 'es_LA',
      'Swahili' => 'sw_KE',
      'Swazi' => 'ss_SZ',
      'Swedish' => 'sv_SE',
      'Syriac' => 'sy_SY',
      'Tajik' => 'tg_TJ',
      'Tamazight' => 'tz_MA',
      'Tamil' => 'ta_IN',
      'Tatar' => 'tt_RU',
      'Telugu' => 'te_IN',
      'Thai' => 'th_TH',
      'Traditional Chinese (Hong Kong)' => 'zh_HK',
      'Traditional Chinese (Taiwan)' => 'zh_TW',
      'Tsonga' => 'ts_ZA',
      'Tswana' => 'tn_BW',
      'Turkish' => 'tr_TR',
      'Turkmen' => 'tk_TM',
      'Ukrainian' => 'uk_UA',
      'Urdu' => 'ur_PK',
      'Uzbek' => 'uz_UZ',
      'Venda' => 've_ZA',
      'Vietnamese' => 'vi_VN',
      'Welsh' => 'cy_GB',
      'Wolof' => 'wo_SN',
      'Xhosa' => 'xh_ZA',
      'Yiddish' => 'yi_DE',
      'Yoruba' => 'yo_NG',
      'Zazaki' => 'zz_TR',
      'Zulu' => 'zu_ZA',
    );//}}}

    if (!empty($all_languages[$store_language])) {
        $store_language_name = $all_languages[$store_language]['language'];
    } elseif(!empty($store_language)) {
        foreach($fb_langs as $_language => $_code) {
            if (strpos($_code, $store_language . '_') !== false) {
                $store_language_name = $_language;
                break;
            }
        }
    }


    return !empty($fb_langs[$store_language_name]) ? $fb_langs[$store_language_name] : 'en_US';
}//}}}

function func_soc_tpl_get_canonical_url($params, $smarty)
{//{{{
    global $current_location;

    if (
        !empty($params['canonical_url'])
        && !empty($params['is_product_page'])
    ) {
        // canonical_url can be used only from product.php page
        $_canonical_url = $current_location . '/' . $params['canonical_url'];
        $smarty->assign($params['assign'], $_canonical_url);

        // some libs like twitter support counturl to share counts between http and https links
        $smarty->assign($params['counturl'], str_replace('https://', 'http://', $_canonical_url));
        return;
    }

    $productid = empty($params['productid']) ? 0 : $params['productid'];
    assert('!empty($productid) /* '.__FUNCTION__.': product.productid is not passed to buttons_row.tpl*/');

    if (empty($productid)) {
        $_canonical_url = $current_location . '/';
    } else {
        $_canonical_url = func_get_resource_url('product', $productid);
    }

    if (empty($_canonical_url)) {
        $_canonical_url = $current_location . '/';
    }

    $smarty->assign($params['assign'], $_canonical_url);

    // some libs like twitter support counturl to share counts between http and https links
    $smarty->assign($params['counturl'], str_replace('https://', 'http://', $_canonical_url));
    return;
}//}}}

function func_soc_tpl_is_fb_plugins_enabled($params=array(), $smarty=null)
{//{{{
    global $config, $active_modules;

    $res = $config['Socialize']['soc_fb_like_enabled'] == 'Y'
        || $config['Socialize']['soc_fb_send_enabled'] == 'Y'
        || (!empty($active_modules['Customer_Reviews']) && $config['Socialize']['soc_fb_comments_enabled'] == 'Y')
        || (!empty($active_modules['Advanced_Customer_Reviews']) && $config['Socialize']['soc_fb_comments_enabled'] == 'Y');

    if (!empty($smarty) && !empty($params['assign'])) {
        $smarty->assign($params['assign'], $res);
    } else {
        return $res;
    }
}//}}}

function func_soc_want_more_drawings($tpl, &$smarty) {

    global $want_more_content;

    $tpl = preg_replace('/<div id="want-more" style="margin: -15px 0;">/', '<div id="want-more" style="margin: -15px 0;">' . $want_more_content, $tpl);

    return $tpl;
}

function func_soc_init()
{ //{{{

    global $smarty, $HTTPS, $HTTP_USER_AGENT, $option, $ajax_mode, $sql_tbl, $want_more_content;

    $smarty->registerPlugin('function','func_soc_tpl_get_canonical_url', 'func_soc_tpl_get_canonical_url');
    $smarty->registerPlugin('function','func_soc_tpl_get_og_image', 'func_soc_tpl_get_og_image');
    $smarty->registerPlugin('function','func_soc_tpl_is_fb_plugins_enabled', 'func_soc_tpl_is_fb_plugins_enabled');
    $smarty->registerPlugin('modifier','func_get_facebook_lang_code', 'func_get_facebook_lang_code');

    /*
      HTTP(S) detection
     */
    $smarty->assign('current_protocol', ($HTTPS) ? 'https' : 'http');

    /*
      W3C Validator detection
     */
    $smarty->assign('is_w3c_validator', strpos($HTTP_USER_AGENT, 'W3C_Validator') !== false);

    /*
      "Want more?" message drawing
     */

    /*
     *  Module constants
     */

    // Used for "Pin it" button to truncate product.descr
    define('XC_SOC_PIN_MAX_DESCR', 500);

    if (func_constant('AREA_TYPE') == 'A' && !empty($option) && $option == 'Socialize') {

        if (!empty($ajax_mode)) {

            switch ($ajax_mode) {
                case 'close':
                    db_query("UPDATE $sql_tbl[config] SET value = 'none' WHERE name = 'soc_want_more_box'");
                    break;
                case 'open':
                    db_query("UPDATE $sql_tbl[config] SET value = 'block' WHERE name = 'soc_want_more_box'");
                    break;
            }

            exit();
        }

        $smarty->assign('want_more_box_mode', func_query_first_cell("SELECT value FROM $sql_tbl[config] WHERE name = 'soc_want_more_box'"));

        $want_more_content = func_display('modules/Socialize/want_more.tpl', $smarty, false);

        $smarty->registerFilter('output', 'func_soc_want_more_drawings');
    }

} //}}}

/**
 * Return og:image tag with T or P image according to facebook best-practices
 */
function func_soc_tpl_get_og_image($params, $smarty)
{ //{{{
    $return_image = '';
    $params['images'] = empty($params['images']) ? array() : $params['images'];
    // $params['images'] is from func_get_image_url_by_types

    // The minimum image size is 200 x 200 pixels.
    // https://developers.facebook.com/docs/sharing/best-practices#images
    if (
        !empty($params['images']['T']['url'])
        && $params['images']['T']['x'] >= 200
        && $params['images']['T']['y'] >= 200
        && empty($params['images']['T']['is_default'])
    ) {
        $return_image = $params['images']['T']['url'];
        $choosen_type = 'T';
    }


    // Use images that are at least 1200 x 630 pixels for the best display on high resolution devices.
    // https://developers.facebook.com/docs/sharing/best-practices#images
    foreach(array_keys($params['images']) as $image_type) {
        if (
            $image_type != 'T'
            && !empty($params['images'][$image_type]['url'])
            && $params['images'][$image_type]['x'] >= 200
            && $params['images'][$image_type]['y'] >= 200
            && $params['images'][$image_type]['x'] <= 1400
            && $params['images'][$image_type]['y'] <= 830
            && empty($params['images'][$image_type]['is_default'])
        ) {
            $return_image = $params['images'][$image_type]['url'];
            $choosen_type = $image_type;
            break;
        }
    }

    // fallback to def image_url
    if (empty($return_image)) {
        x_load('files');
        $return_image = is_url($params['def_image']) ? $params['def_image'] : '';
    }

    if (empty($return_image)) {
        $return_image = func_get_default_image('T', 'absolute_path');
    }

    if (empty($return_image)) {
        return '';
    }

    $output = <<<EOT
<meta property="og:image" content="$return_image" />
EOT;

    if (
        !empty($choosen_type)
        && !empty($params['images'][$choosen_type]['x'])
        && !empty($params['images'][$choosen_type]['y'])
    ) {
        $output .= "\n\t<meta property=\"og:image:width\" content=\"{$params['images'][$choosen_type]['x']}\" />\n";
        $output .= "\t<meta property=\"og:image:height\" content=\"{$params['images'][$choosen_type]['y']}\" />";
    }

   return $output;

} //}}}
?>
