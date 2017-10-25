{*
09d46970de4b3605245381ed8ecd8b55fffd1d3e, v2 (xcart_4_7_5), 2016-02-12 18:28:36, progress.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{load_defer file="modules/Amazon_Feeds/controller.js" type="js"}

<h2>{$lng.lbl_amazon_feeds_processing}</h2>
<hr />
<p>{$lng.txt_amazon_feeds_time_consuming_operation}</p>
<div class="afds-progress" data-controller="{$controller_name}">
  <div class="afds-progress-bar" role="progressbar">
  </div>
  <div class="afds-progress-bar-text">
    0%
  </div>
</div>

<script type="text/javascript">
//<![CDATA[
  var txt_amazon_feeds_on_close_page_warning = '{$lng.txt_amazon_feeds_close_page_warning}';
//]]>
</script>
