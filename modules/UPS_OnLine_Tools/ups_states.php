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
 * UPS states declaration
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Modules
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v30 (xcart_4_7_7), 2017-01-24 09:29:34, ups_states.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_SESSION_START') ) { header("Location: ../"); die("Access denied"); }

$ups_states = array(
    'AB' => 'Alberta (Canada)',
    'BC' => 'British Columbia (Canada)',
    'MB' => 'Manitoba (Canada)',
    'NB' => 'New Brunswick (Canada)',
    'NF' => 'Newfoundland/Labrador (Canada)',
    'NS' => 'Nova Scotia (Canada)',
    'NT' => 'NWT/Nunavut (Canada)',
    'ON' => 'Ontario (Canada)',
    'PE' => 'Prince Edward Island (Canada)',
    'QC' => 'Quebec (Canada)',
    'SK' => 'Saskatchewan (Canada)',
    'YT' => 'Yukon (Canada)',
    'AL' => 'Alabama (US)',
    'AK' => 'Alaska (US)',
    'AZ' => 'Arizona (US)',
    'AR' => 'Arkansas (US)',
    'CA' => 'California (US)',
    'CO' => 'Colorado (US)',
    'CT' => 'Connecticut (US)',
    'DE' => 'Delaware (US)',
    'DC' => 'District of Columbia (US)',
    'FL' => 'Florida (US)',
    'GA' => 'Georgia (US)',
    'GU' => 'Guam (US)',
    'HI' => 'Hawaii (US)',
    'ID' => 'Idaho (US)',
    'IL' => 'Illinois (US)',
    'IN' => 'Indiana (US)',
    'IA' => 'Iowa (US)',
    'KS' => 'Kansas (US)',
    'KY' => 'Kentucky (US)',
    'LA' => 'Louisiana (US)',
    'ME' => 'Maine (US)',
    'MD' => 'Maryland (US)',
    'MA' => 'Massachusetts (US)',
    'MI' => 'Michigan (US)',
    'MN' => 'Minnesota (US)',
    'MS' => 'Mississippi (US)',
    'MO' => 'Missouri (US)',
    'MT' => 'Montana (US)',
    'NE' => 'Nebraska (US)',
    'NV' => 'Nevada (US)',
    'NH' => 'New Hampshire (US)',
    'NJ' => 'New Jersey (US)',
    'NM' => 'New Mexico (US)',
    'NY' => 'New York (US)',
    'NC' => 'North Carolina (US)',
    'ND' => 'North Dakota (US)',
    'OH' => 'Ohio (US)',
    'OK' => 'Oklahoma (US)',
    'OR' => 'Oregon (US)',
    'PA' => 'Pennsylvania (US)',
    'RI' => 'Rhode Island (US)',
    'SC' => 'South Carolina (US)',
    'SD' => 'South Dakota (US)',
    'TN' => 'Tennessee (US)',
    'TX' => 'Texas (US)',
    'UT' => 'Utah (US)',
    'VI' => 'Virgin Islands (US)',
    'VT' => 'Vermont (US)',
    'VA' => 'Virginia (US)',
    'WA' => 'Washington (US)',
    'WV' => 'West Virginia (US)',
    'WI' => 'Wisconsin (US)',
    'WY' => 'Wyoming (US)',
    'AA' => 'Armed Forces Americas (US)',
    'AE' => 'Armed Forces Europe (US)',
    'AP' => 'Armed Forces Pacific (US)'
);

$smarty->assign('ups_states', $ups_states);

?>
