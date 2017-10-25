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
 * German stopwords
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage Lib
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com>
 * @copyright  Copyright (c) 2001-present Qualiteam software Ltd <info@x-cart.com>
 * @license    https://www.x-cart.com/license-agreement-classic.html X-Cart license agreement
 * @version    cf9e608d41c40f761c6416f642a1d0094a6af214, v5 (xcart_4_7_7), 2017-01-24 09:29:34, stopwords_de.php, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

if ( !defined('XCART_START') ) { header("Location: ../"); die("Access denied"); }

$stopwords = array(
    'aber', 'alle', 'allem', 'allen', 'aller', 'alles', 'als', 'also', 'am', 'an',
    'ander', 'andere', 'anderem', 'anderen', 'anderer', 'anderes', 'anders', 'auch', 'auf', 'aus',
    'bei', 'bin', 'bis', 'bist', 'da', 'dadurch', 'daher', 'damit', 'dann', 'darum',
    'das', 'daß', 'dass', 'dasselbe', 'dazu', 'dein', 'deine', 'deinem', 'deinen', 'derselbe',
    'derselben', 'denselben', 'desselben', 'demselben', 'deiner', 'deines', 'dem', 'den', 'denn', 'der',
    'derer', 'des', 'dessen', 'deshalb', 'dich', 'die', 'dir', 'dies', 'diese', 'dieselbe',
    'dieselben', 'diesem', 'diesen', 'dieser', 'dieses', 'doch', 'dort', 'du', 'durch', 'ein',
    'eine', 'einem', 'einen', 'einer', 'eines', 'einige', 'einigem', 'einigen', 'einiger', 'einiges',
    'einmal', 'er', 'es', 'etwas', 'euch', 'euer', 'eure', 'eurem', 'euren', 'eurer',
    'eures', 'für', 'gegen', 'gewesen', 'hab', 'habe', 'haben', 'hat', 'hatte', 'hätte',
    'hatten', 'hätten', 'hattest', 'hättest', 'hattet', 'hättet', 'hier', 'hin', 'hinter', 'ich',
    'ihn', 'ihnen', 'ihm', 'ihr', 'ihre', 'ihrem', 'ihren', 'ihrer', 'ihres', 'im',
    'in', 'indem', 'ins', 'ist', 'ja', 'jede', 'jedem', 'jeden', 'jeder', 'jedes',
    'jene', 'jenem', 'jenen', 'jener', 'jenes', 'jetzt', 'kann', 'kannst', 'kein', 'keine',
    'keinem', 'keinen', 'keiner', 'keines', 'können', 'könnt', 'konnte', 'könnte', 'konnten', 'könnten',
    'konntest', 'könntest', 'konntet', 'könntet', 'machen', 'man', 'manche', 'manchem', 'manchen', 'mancher',
    'manches', 'mein', 'meine', 'meinem', 'meinen', 'meiner', 'meines', 'mich', 'mir', 'mit',
    'möchte', 'möchtest', 'möchtet', 'muß', 'muss', 'mußte', 'musste', 'müssen', 'müßt', 'müsst',
    'müßte', 'müsste', 'nach', 'nachdem', 'nicht', 'nichts', 'noch', 'nun', 'nur', 'ob',
    'oder', 'ohne', 'sehr', 'seid', 'sein', 'seine', 'seinem', 'seinen', 'seiner', 'seines',
    'selbst', 'sich', 'sie', 'sind', 'so', 'solche', 'solchem', 'solchen', 'solcher', 'solches',
    'soll', 'sollst', 'sollt', 'sollte', 'solltest', 'solltet', 'sondern', 'sonst', 'soweit', 'sowie',
    'über', 'um', 'und', 'uns', 'unsere', 'unserem', 'unseren', 'unserer', 'unseres', 'unter',
    'viel', 'vom', 'von', 'vor', 'wann', 'während', 'war', 'waren', 'warst', 'warum',
    'was', 'weg', 'weil', 'weiter', 'welche', 'welchem', 'welchen', 'welcher', 'welches', 'wenn',
    'wer', 'werde', 'werden', 'werdet', 'weshalb', 'wie', 'wieder', 'wieso', 'will', 'wir',
    'wird', 'wirst', 'wo', 'woher', 'wohin', 'wollen', 'wollte', 'wolltest', 'wolltet', 'wurde',
    'wurden', 'würde', 'würden', 'zu', 'zum', 'zur', 'zwar', 'zwischen'
);

