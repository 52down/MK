{*
872a852c9bc939eb30045da1c29870e957eea9d8, v1 (xcart_4_7_3), 2015-05-30 22:26:12, aw_products.tpl, mixon

vim: set ts=2 sw=2 sts=2 et:
*}

{if $aw_add_container}<div class="aw-tcell aw-products">{/if}

{foreach from=$aw_categories item=c key=catid}
  {if $aw_categories|count gt 1}
    <h3>
      <a href="#category{$c.id|escape:html}" id="{$c.id|escape:html}" data-type="category">{$c.name}</a>
    </h3>
  {/if}
  <ul>
    {foreach from=$c.goods item=p key=poductid}
      <li>
        <div class="aw-product">
          <article class="aw-card">
            <a href="#category{$c.id|escape:html}!product{$p.id|escape:html}" id="{$p.id|escape:html}" data-type="product" data-category-id="{$c.id|escape:html}">
              <figure class="aw-card-figure">
                <img class="aw-card-image" alt="{$p.name}" src="{$p.thumb_url}" />
              </figure>
              <div class="aw-card-body">
                <h4 class="aw-card-title" title="{$p.name}">{$p.name|truncate:50}</h4>
                <p class="aw-card-price">
                  <strong>{$p.min_price} {$p.currency}</strong> / <span>{$p.unit}</span>
                </p>
                <p class="aw-card-text">
                {$lng.lbl_aw_min_order_qty} <span>{$p.moq} {if $p.moq gt 1}{$p.units}{else}{$p.unit}{/if}</span>
                </p>
            </div>
          </a>
        </article>
      </div>
    </li>
  {/foreach}
  </ul>
  {if $c.goods|count eq 0}
  <p>
    {$lng.lbl_no_results_found}
  </p>
  {/if}
{/foreach}

{if $aw_add_container}</div>{/if}
