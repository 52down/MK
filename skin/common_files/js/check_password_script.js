/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Password checking script
 * 
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Ruslan R. Fazlyev <rrf@x-cart.com> 
 * @version    fcbf70c99aa2648e4ae50b1b906138bf5e4521f9, v4 (xcart_4_7_6), 2016-04-07 11:41:05, check_password_script.js, aim
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

function checkPasswordStrength(field1, field2) {
  var err = false;
  var field;
  var uname = '';
  var i;

  if (!field1 || !field2)
    return !err;

  if (field1.form.elements.namedItem('password_is_modified') && field1.form.elements.namedItem('password_is_modified').value != 'Y')
    return !err;

  if (field1.value != field2.value) {
        markErrorField(field2);
    alert(txt_password_match_error);
    field2.focus();
    field2.select();
    return err;
  }
  else {
    field = field1;
    }

 
  var _names = {'uname':'', 'username':'', 'user':'', 'email':''};
  for (i in _names) {
    if (field.form.elements.namedItem(i) && field.form.elements.namedItem(i) != '') {
      uname = field.form.elements.namedItem(i);
      break;
    }
  }

  if (!(field.value.match(/.{7,}/) && field.value.match(/[a-z]/i) && field.value.match(/[0-9]/) && field.value.match(/\S/)) || uname == '' || field.value == uname.value) {
    err = true;
  }
  
  if (err) {
        markErrorField(field);
    alert(txt_simple_password);
    field.focus();
    field.select();
  }

  return !err;
}

