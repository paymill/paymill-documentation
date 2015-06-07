---
title: "Bridge"
menu: "Bridge"
type: "guide"
status: "published"
order: 1100
---

How exactly does the PAYMILL bridge work and what are its features? These and similar questions are answered in this section.

## 1. Integrating the PAYMILL JS Bridge

You can find an introduction for this in the [payment form](/guides/introduction/payment-form.html) documentation. Besides this, you can integrate the following code on your page:

```html
<script type="text/javascript" src="https://bridge.paymill.com/"></script>
```

<p class="important">
Due to frequent demands of our customers in terms of timeout problems with inserting our JavaScript solution: it may take longer as a manually configured timeout of e.g. 3000ms if a response from the server will be sent back to you.
<br><br>
Therefore please specify **no fixed timeouts in the JavaScript code** of your page, as it would otherwise lead to problems and will take the response from server to different lengths!
</p>

## 2. Creating a Token

The createToken function creates a unique token, which you can transfer to your server and use for charging the purchaser without any second thoughts regarding security:

```javascript
paymill.createToken({
  number:         $('.card-number').val(),       // required
  exp_month:      $('.card-expiry-month').val(), // required
  exp_year:       $('.card-expiry-year').val(),  // required
  cvc:            $('.card-cvc').val(),          // required
  amount_int:     $('.card-amount-int').val(),   // required, e.g. "4900" for 49.00 EUR
  currency:       $('.currency').val(),          // required
  cardholder:     $('.card-holdername').val()    // optional
},
paymillResponseHandler);
```

Mandatory fields:

The JSON object has to contain the following mandatory fields for the paymill.createToken function:

  - `number`      : The credit card number has to be a string without any spaces.
  - `exp_month`   : Two-digit month number for the expiration date
  - `exp_year`    : Four-digit year number for the expiration date
  - `cvc`         : 3-digit check number
  - `amount_int`  : Transaction amount in the smallest currency unit (integer), e.g. `345` for 3.45 €
  - `currency`    : Three character currency code (ISO 4217) of the transaction, eg. `EUR` or `GBP`

Optional fields:

  - `cardholder` : Name of the cardholder

Mandatory for direct debit:

In the case of direct debit connections the JSON object must contain the following fields:

  - `number`        : The account number as a string consisting only of numbers
  - `bank`          : The eight digit bank code of the corresponding bank
  - `accountholder` : The name of the account holder

Alternatively, you can provide IBAN and BIC

  - `iban`          : The IBAN as a string in the official format
  - `bic`           : The BIC or SWIFT code of the corresponding bank
  - `accountholder` : The name of the account holder

Depending on the parameters given, a token for credit card or direct debit is returned.

ResponseHandler functionality:

If an error results from entering the credit card, an error report is displayed on the website. If the process is successful, you will have to add the token to your payment form and transfer it to your server.

Have a look at a complete example of the `paymillResponseHandler` in the following sample code:

```javascript
function paymillResponseHandler(error, result) {
    if (error) {
      // Displays the error above the form
      $(".payment-errors").text(error.apierror);
    } else {
      var form = $("#payment-form");
      // Output token
      var token = result.token;
      // Insert token into form in order to submit to server
      form.append(
      "<input type='hidden' name='paymillToken' value='" + token + "'/>"
      );
      // Submit form
      form.get(0).submit();
    }
}
```

The result of a successful request is a token object like to following:

```javascript
{
  "token": "098f6bcd4621d373cade4e832627b4f6",
  "bin": "427346",
  "binCountry": "DE",
  "brand": "VISA",
  "last4Digits": "1111",
  "ip": "82.135.34.186",
  "ipCountry": "de"
}
```

If an error occurred, the response is given as follows:

```javascript
{
  "apierror": "error_code"
}
```

<p class="important">
The token has a maximum length of 32 chars and expires after 5 minutes, for creating a transaction with it. For the following transactions the corresponding payment object should be used, which expires after 13 months. If the expiry date of the credit card is lower, the expiry of the payment object is being reduced accordingly.
</p>

## 3. Data validation

In order to validate the data from your website, you simply use the validation features integrated in PAYMILL. For example, your credit card number and the expiration date are verified here. You can find detailed information on this in the [payment form](/guides/introduction/payment-form.html).

## 4. How do I test specific error codes?

The following general error codes can be returned independent of the payment method:

  - `internal_server_error`           : Communication with PSP failed
  - `invalid_public_key`              : Invalid Public Key
  - `invalid_payment_data`            : not permitted for this method of payment, credit card type, currency or country
  - `unknown_error`                   : Unknown Error

The following errors can be returned in the case of credit card payment

  - `3ds_cancelled`                   : Password Entry of 3-D Secure password was cancelled by the user
  - `field_invalid_card_number`       : Missing or invalid creditcard number
  - `field_invalid_card_exp_year`     : Missing or invalid expiry year
  - `field_invalid_card_exp_month`    : Missing or invalid expiry month
  - `field_invalid_card_exp`          : Card is no longer valid or has expired
  - `field_invalid_card_cvc`          : Invalid checking number
  - `field_invalid_card_holder`       : Invalid cardholder
  - `field_invalid_amount_int`        : Invalid or missing amount for 3-D Secure
  - `field_invalid_amount`            : Invalid or missing amount for 3-D Secure. **deprecated , [see blog post](https://blog.paymill.com/about-rounding-floats-new-bridge-parameter/)**
  - `field_invalid_currency`          : Invalid or missing currency code for 3-D Secure  

Following error codes can be returned with direct debit:

  - `field_invalid_account_number`    : Missing or invalid bank account number
  - `field_invalid_account_holder`    : Missing or invalid bank account holder
  - `field_invalid_bank_code`         : Missing or invalid bank code
  - `field_invalid_iban`              : Missing or invalid IBAN
  - `field_invalid_bic`               : Missing or invalid BIC
  - `field_invalid_country`           : Missing or unsupported country (with IBAN)
  - `field_invalid_bank_data`         : Missing or invalid bank data combination

## 5. 3-D Secure

If a credit card, which is activated for 3-D Secure is used, the customer has to enter it's password on the bank's website. This process must be completed during the creation of the token. For this reason, an iFrame is displayed during the creation of the token, which enables to enter the password, which is placed in the middle of the page.

![3D Secure](/guides/images/paymill_bridge-01.png)

You can customize the look and feel of the iframe to match your website by providing two callbacks to the createToken method, named tdsInit and tdsCleanup in the following example:

```javascript
paymill.createToken(params, paymillResponseHandler, tdsInit, tdsCleanup);
```

The parameters `tdsInit` and `tdsCleanup` are callback functions specified by your code and they will be called to start or end the process.

```tdsInit(redirect, cancelFn)```

`tdsInit` is called when 3-D Secure has to be initiated. Here you have to open an iframe or popup window and load the page described by the `redirect` parameter. If your customer cancels the 3-D Secure processing by clicking a button provided by your customization you should call the `cancelFn` function to correclty cancel the 3-D Secure processing.

**cancelFn** : a function to be called when the user cancels the process.
**redirect** : an object containing the following keys

  - `url`     : the url to open in your iframe/popup
  - `params`  : an object containing the parameters to be passed to the iframe (url encoded)


<p class="info">
  the parameters have to be passed using a POST request.
</p>

```javascript
var tdsInit = function tdsInit( redirect, cancelCallback ) {
  var url = redirect.url, params = redirect.params;
  var body = document.body ||  document.getElementsByTagName('body')[0];

  var iframe = document.createElement('iframe');
  body.insertBefore(iframe, body.firstChild);

  var iframeDoc = iframe.contentWindow ||  iframe.contentDocument;
  if (iframeDoc.document) iframeDoc = iframeDoc.document;

  var form = iframeDoc.createElement('form');
  form.method = 'post';
  form.action = url;

  for (var k in params) {
    var input = iframeDoc.createElement('input');
    input.type = 'hidden';
    input.name = k;
    input.value = decodeURIComponent(params[k]);
    form.appendChild(input);
  }

  if (iframeDoc.body) iframeDoc.body.appendChild(form);
  else iframeDoc.appendChild(form);

  form.submit();
};
```

`paymill.config('3ds_cancel_label', 'cancel');`

With paymill.config('3ds_cancel_label', 'cancel'); you're able to name your label as you want it to be.

<div class="important">
  The following browsers support 3-D Secure transactions:
  <br><br>
  <ul>
    <li>IE 9+ (IE8 in native WinXP environment)</li>
    <li>Chrome Current</li>
    <li>Safari Current</li>
    <li>Firefox Current</li>
  </ul>
</div>


## 6. Direct Debit (ELV) Mapping API

Direct debit (ELV) is only available for German merchants.
The direct debit (ELV) payment form recognises now the name of the bank for German bank identification codes.

**JavaScript part:**

```javascript
$("#debit-form .debit-bank").bind("paste cut keydown",function(e) {
//Alternativ für IBAN $("#debit-form .debit-iban")....
  var that = this;
  setTimeout(function() {
    paymill.getBankName($(that).val(), function(error, result) {
      error ?
      console.log(error.apierror) :
      $(".debit-bankname").val(result);
    });
  }, 200);
});
```

<p class="important">
  In some cases banks use the same bank code for different branches. The `getBankName()` function will return the same bank name for all branches.
</p>

You need to wrap the field for the bank name with conditional comments within the html part (>= IE8 and other browsers), as we do not offer this functionality for IE6 and IE7.

```html
<div class="form-row">
  <label>Bankleitzahl</label>
  <input class="debit-bank" maxlength="8" type="text" />
</div>
<!--[if gte IE 8]><!-->
<div class="form-row">
  <label>Bankname</label>
  <input class="debit-bankname" type="text"
  disabled="disabled" style="background-color:lightgrey;" />
</div>
<!--<![endif]-->
```
