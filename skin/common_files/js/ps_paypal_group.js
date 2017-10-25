/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Paypal methods configuration
 * 
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com> 
 * @version    f29bd86ca98e19bd60f6a08dbe424de293151419, v14 (xcart_4_7_4), 2015-10-08 20:25:41, ps_paypal_group.js, random
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

function view_solution(solution) {

  $('#pp_promo').html(pp_promo[solution]);

  $('tr[id^="sol_"]:not(#sol_'+solution+')').hide();
  $('tr#sol_'+solution).show();

}

function changeExpressMethod()
{
  if (
    !document.getElementById('method_email')
    || !document.getElementById('method_api')
    || !document.getElementById('method_payflow')
    || (!document.getElementById('method_email').checked && !document.getElementById('method_api').checked && !document.getElementById('method_payflow').checked)
  ) {
    return false;
  }

  if (document.getElementById('method_email').checked) {
    $('#express_email').animate({opacity: 1.0}, 'fast', function() {
      $('#express_email').prop('disabled', false);
    });
    $('#method_api_settings, #method_payflow_settings').fadeOut('fast', function() {
      // Force hide due to a bug with fadeOut for elements with hidden parent
      $('#method_api_settings, #method_payflow_settings').hide();
    });
    $('#method_api_and_email_settings').fadeIn('fast', function() {
      $('#method_api_and_email_settings').show();
    });

  } else {
    $('#express_email').animate({opacity: 0.25}, 'fast', function() {
      $('#express_email').prop('disabled', true);
    });
    toShow = (document.getElementById('method_api').checked) ? '#method_api_settings, #method_api_and_email_settings' : '#method_payflow_settings';
    toHide = (document.getElementById('method_payflow').checked) ? '#method_api_settings, #method_api_and_email_settings' : '#method_payflow_settings';
    
    $(toHide).fadeOut('fast', function() {
      $(toHide).hide();
    });
    $(toShow).fadeIn('fast', function() {
      $(toShow).show();
    });
  }

  return true;
}

$(document).ready(
  function() {
    $('#pp_promo').html(pp_promo[paypal_solution]);
    changeExpressMethod();
  }
);
