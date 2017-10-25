{*
9fd218c4b930bdcfc95e51d8991dc3b52ac848d1, v4 (xcart_4_7_7), 2017-01-09 19:45:32, popup_cookie_settings.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{config_load file="$skin_config"}
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>{$lng.lbl_eucl_change_cookie_settings}</title>
</head>

<body>

<div class="eucl_dialog">
<div class="cookie_settings_description">
{$lng.txt_cookie_settings_description}
</div>

<div class="cookies-settings-block">

  <h3>{$lng.lbl_eucl_strictly_necessary}</h3>

  <div class="settings">
    <span class="setting"><input type="radio" checked="checked" disabled="disabled"/> <label>{$lng.lbl_enabled}</label></span>
  </div>
  <div class="eucl-description">{$lng.txt_eucl_strictly_necessary_desription}</div>

</div>

<form action="popup_cookie_settings.php" method="post">
<input type="hidden" name="mode" value="change_settings" />

<div class="cookies-settings-block">

  <h3>{$lng.lbl_eucl_functional}</h3>

  <div class="settings">

    <span class="setting"><input type="radio" value="Y" id="fa_enabled" name="functional_access"{if $cookie_access[1] eq "Y"} checked="checked"{/if} /> <label for="fa_enabled">{$lng.lbl_enabled}</label></span>
    <span class="setting"><input type="radio" id="fa_disabled" onclick="if (this.checked && $('#oa_disabled')) $('#oa_disabled').click();" name="functional_access"{if $cookie_access[1] ne "Y"} checked="checked"{/if} /> <label for="fa_disabled">{$lng.lbl_disabled}</label></span>

  </div>

  <div class="eucl-description">{$lng.txt_eucl_functional_desription}</div>

</div>

<div class="cookies-settings-block">

  <h3>{$lng.lbl_eucl_other}</h3>

  <div class="settings">

    <span class="setting"><input type="radio" value="Y" id="oa_enabled" onclick="if (this.checked && $('#fa_enabled')) $('#fa_enabled').click();" name="other_access"{if $cookie_access[2] eq "Y"} checked="checked"{/if} /> <label for="oa_enabled">{$lng.lbl_enabled}</label></span>
    <span class="setting"><input type="radio" id="oa_disabled" name="other_access"{if $cookie_access[2] ne "Y"} checked="checked"{/if} /> <label for="oa_disabled">{$lng.lbl_disabled}</label></span>

  </div>

  <div class="eucl-description">{$lng.txt_eucl_other_cookie_desription}</div>

</div>

<br />
<div class="save_close_btn">{include file="customer/buttons/button.tpl" type="input" button_title=$lng.lbl_save_and_close additional_button_class="light-button"}</div>
</form>
</div>

</body>

</html>
