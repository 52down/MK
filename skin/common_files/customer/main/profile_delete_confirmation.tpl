{*
603d9f84b59dd7c812a997e979b57816af3ca932, v2 (xcart_4_4_0), 2010-07-30 12:40:24, profile_delete_confirmation.tpl, joy
vim: set ts=2 sw=2 sts=2 et:
*}

<h1>{$lng.lbl_confirmation}</h1>

{capture name=dialog}

  <form action="register.php" method="post" name="processform">

    <input type="hidden" name="confirmed" value="Y" />
    <input type="hidden" name="mode" value="delete" />

    <p class="form-text text-block">{$lng.txt_profile_delete_confirmation}</p>

    <div class="buttons-row">
      {include file="customer/buttons/yes.tpl" type="input"}
      <div class="button-separator"></div>
      {include file="customer/buttons/no.tpl" href="register.php?mode=notdelete"}
    </div>

  </form>

{/capture}
{include file="customer/dialog.tpl" title=$lng.lbl_confirmation content=$smarty.capture.dialog noborder=true}
