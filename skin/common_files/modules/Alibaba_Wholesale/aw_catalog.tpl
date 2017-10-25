{*
585b2e492adcdfc54a759f69ab82dba915bd187e, v2 (xcart_4_7_3), 2015-06-03 18:52:16, aw_catalog.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{include file="page_title.tpl" title=$lng.lbl_aw_catalog}

{capture name=dialog}

  <div class="aw-table aw-container">

    <div class="aw-trow aw-search-panel">
      <div class="aw-tcell aw-logo"></div>
      <div class="aw-tcell aw-search-keywords">
        <input type="text" name="search_substring" value="{$search_substring}" placeholder="{$lng.lbl_aw_search_placeholder}" />
        <button class="aw-filter-btn" title="{$lng.lbl_use_filter}"></button>
      </div>
      <div class="aw-tcell aw-search-btn">
        <button>{$lng.lbl_search}</button>
      </div>
    </div>

    <div class="aw-trow">
      <div class="aw-tcell"></div>
      <div class="aw-tcell">
        <div class="aw-filter-panel">
          <div>
            <label for="aw_price_from">
              {$lng.lbl_aw_price_from}:<input name="aw_price_from" id="aw_price_from" value="{$config.Alibaba_Wholesale.alibaba_wholesale_pricefrom|escape:html}"/>
            </label>
            <label for="aw_price_to">
              {$lng.lbl_aw_price_to}:<input name="aw_price_to" id="aw_price_to" value="{$config.Alibaba_Wholesale.alibaba_wholesale_priceto|escape:html}"/>
            </label>
            <label for="aw_sort_by">
              {$lng.lbl_aw_sort_by}:
              <select name="aw_sort_by" id="aw_sort_by">
                <option value="bbPrice-asc" {if $config.Alibaba_Wholesale.alibaba_wholesale_sort_by eq 'bbPrice-asc'}selected="selected"{/if}>{$lng.lbl_aw_price_asc}</option>
                <option value="bbPrice-desc" {if $config.Alibaba_Wholesale.alibaba_wholesale_sort_by eq 'bbPrice-desc'}selected="selected"{/if}>{$lng.lbl_aw_price_desc}</option>
              </select>
            </label>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="aw-table aw-container">

    <div class="aw-trow aw-content aw-search">
      <div class="aw-tcell aw-categories">
        <!-- Categories placeholder -->
      </div>
      <div class="aw-tcell aw-products">
        <!-- Products placeholder -->
      </div>
    </div>

  </div>

{/capture}
{include file="dialog.tpl" content=$smarty.capture.dialog extra='id="aw_catalog" width="100%"'}

{load_defer file="lib/colorbox/colorbox.css" type="css"}

<script type="text/javascript">
//<![CDATA[
var awCboxOpts = {
  transition: "fade",
  speed: 350,
  initialWidth: 200,
  initialHeight: 200,
  scalePhotos: true,
  scrolling: true,
  opacity: 0.3,
  open: false,
  preloading: true,
  overlayClose: true,
  slideshow: true,
  slideshowSpeed: 2500,
  slideshowStart: '{$lng.lbl_cb_start_slideshow|wm_remove:escape:javascript}',
  slideshowStop: '{$lng.lbl_cb_stop_slideshow|wm_remove:escape:javascript}',
  current: '{$lng.lbl_cb_current_format|wm_remove:escape:javascript}',
  previous: '{$lng.lbl_previous|wm_remove:escape:javascript}',
  next: '{$lng.lbl_next|wm_remove:escape:javascript}',
  close: '{$lng.lbl_close|wm_remove:escape:javascript}',
  onOpen: function () { $('.ui-dialog, .ui-widget-overlay').fadeOut('slow'); },
  onClosed: function () { $('.ui-dialog, .ui-widget-overlay').fadeIn('slow'); }
};
var awProductsPerPage = {$config.Appearance.products_per_page_admin};
//]]>
</script>

{load_defer file="lib/colorbox/jquery.colorbox-min.js" type="js"}

<script type="text/javascript" src="{$SkinDir}/modules/Alibaba_Wholesale/controller.js"></script>
