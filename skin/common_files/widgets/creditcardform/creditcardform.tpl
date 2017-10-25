{*
09d46970de4b3605245381ed8ecd8b55fffd1d3e, v3 (xcart_4_7_5), 2016-02-12 18:28:36, creditcardform.tpl, aim

vim: set ts=2 sw=2 sts=2 et:
*}

{*
  Supported params:

    $containerName - container name, default empty
    $cardName - show card name, default 'N'
    $cardCode - show card code, default 'N'
*}

{include file="widgets/css_loader.tpl" css="widgets/creditcardform/creditcardform.css"}

{*
   The input fields for card data do not have a "name" attribute.
   This is done so the data is not stored on the server when the form is submitted.
*}

<div class="cc-form-container{if $containerName} {$containerName}{/if}">
  <div class="header-line"></div>
  <div class="content">
    <div class="header">
      <div class="lock"></div>
      <h3 class="hidden">{$lng.lbl_secure_credit_card_payment}</h3>
    </div>

    <div class="cc-form">
      <div class="cardType">
        <div class="title">{$lng.lbl_card_type}:</div>
        <div class="value">
          <select id="card_type">
            <option disabled selected>{$lng.lbl_chose_credit_card_type}</option>
            <option value="VISA">Visa</option>
            <option value="MC">MasterCard</option>
            <option value="JCB">JCB</option>
            <option value="DICL">Diners Club</option>
            <option value="DC">Discover</option>
            <option value="AMEX">American Express</option>
          </select>
          <div class="btn-group">
            <a class="dropdown-toggle icon blank" data-toggle="dropdown" href="#">
              <span class="card mc"></span>
            </a>
            <ul class="dropdown-menu pull-right">
              <li><a href="#" data-value="VISA">Visa</a></li>
              <li><a href="#" data-value="MC">MasterCard</a></li>
              <li><a href="#" data-value="JCB">JCB</a></li>
              <li><a href="#" data-value="DICL">Diners Club</a></li>
              <li><a href="#" data-value="DC">Discover</a></li>
              <li><a href="#" data-value="AMEX">American Express</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="cardNumber">
        <div class="title">{$lng.lbl_card_number}:</div>
        <div class="value">
          <input size="25" id="cc_number" placeholder="XXXX-XXXX-XXXX-XXXX" type="text" autocomplete="off" required="required">
        </div>
      </div>

      <div class="cardExpire">
        <div class="title">{$lng.lbl_expiration_date}:</div>
        <div class="value">
          <div class="top-line">
            <div class="top-text">{$lng.lbl_month} / {$lng.lbl_year}</div>
          </div>
          <div class="bottom-line">
            <div class="left-text">{$lng.lbl_valid_thru}</div>
            <div class="month-container">
              <select id="cc_expire_month" required="required">
                <option value="01" selected="selected">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
            </div>
            <div class="year-container">
              <select id="cc_expire_year" required="required">
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="cardName"{if $cardName eq 'Y'}{else} data-disabled="Y"{/if}>
        <div class="title">{$lng.lbl_cardholder_name}:</div>
        <div class="value">
          <input size="40" id="cc_name" placeholder="{$lng.lbl_cardholder_name}" type="text" autocomplete="off" required="required">
        </div>
      </div>

      <div class="cardCVV2"{if $cardCode eq 'Y'}{else} data-disabled="Y"{/if}>
        <div class="title">{$lng.lbl_security_code}:</div>
        <div class="value">
          <input size="5" maxlength="4" id="cc_cvv2" type="text" autocomplete="off">
          <div class="right-text">
            <span class="default-text">{$lng.lbl_credit_card_security_code}</span>
            <span class="VISA">{$lng.lbl_last_three_numbers_on_the_back}</span>
            <span class="MC">{$lng.lbl_last_three_numbers_on_the_back}</span>
            <span class="JCB">{$lng.lbl_last_three_numbers_on_the_back}</span>
            <span class="AMEX">{$lng.lbl_four_digit_numberon_the_front}</span>
          </div>
        </div>
        <div class="icon-container">
          <div class="icon mc"></div>
        </div>
      </div>

    </div>

  </div>
</div>

{load_defer file="widgets/creditcardform/creditcardform.js" type="js"}
