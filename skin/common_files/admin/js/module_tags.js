/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Module tags feature
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com> 
 * @version    c8aee9c43bb76504cb6b9abd297d153dcdce86d3, v3 (xcart_4_7_7), 2016-09-05 11:09:22, module_tags.js, mixon
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */
var selectedTag = [];

function toggleTag(tag, type) {

  if (tag === selectedTag[type]) {
    return true;
  }

  selectedTag[type] = tag;
  $.cookie('xcart_selected_tag_'+type, tag);

  if (tag !== 'all') {
    $('li[id^="li_'+type+'_"]:not(.'+tag+')').hide();
    $('li[id^="li_'+type+'_"].'+tag).show();
  } else {
    $('li[id^="li_'+type+'_"]').show();
    $('input[id^="tag_'+type+'_"]').attr('checked', false);
    $('input#tag_'+type+'_all').attr('checked', true);
  }

}

$(document).ready(function() {
  $('input[id^="tag_"]:checked').click();
});
