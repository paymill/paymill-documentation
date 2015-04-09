---
title: "Getting Started"
menu: "Getting Started"
type: "guide"
---

## ELV* and credit card payment

We would like you to be able to implement our payment solution on your website as quickly as possible. It will be differentiated in stages between the two different payment types. To do this, please carry out the following steps:

<p class"important">
You should consider that direct debit as a payment method needs an activation process of about **7-14 days**. Therefor you won't be able to use direct debit without completed activation process.
Please note too that this service is only available in Germany right now!
</p>

## 1. Creating an Account

On our homepage, go to **My Account** and click on **Register** or use the **Register Now** button.

![Login Form](/Guides/images/getting_started-01.jpg)

Now fill out the **registration form**, after which you will receive an activation e-mail that you will need to confirm.

![Registration Form](/Guides/images/getting_started-02.jpg)

Once your Paymill account has been set up successfully, you will be transferred to the merchant centre. In this area you can view your test key and live key transactions. There is a switch at the upper right to toggle between them.

![Merchant Centre](/Guides/images/getting_started-03.jpg)

## 2. API Keys

You will need two keys to be able to use Paymill:

<p class="info">
**Public Key:**
This key is visible on your payment form and therefore can be seen by third parties. You use the public key to create a token for your customer’s credit card with our JavaScript bridge. More on that below.
</p>


<p class="info">
**Private Key:**
As soon as you have received the token, you can make a payment (transaction) – usually at the end of the order process – with our API. You have to indicate your private key every time you submit a request to our API.
</p>

Important note concerning test keys and live keys:

You receive one pair of test keys and live keys each. Use your test keys for testing. You use the live keys in your working system.

If you do not have a test system, you will need to replace the two test keys with the live keys before you make your system available to your customers!

## 3. Calling up the API Keys in Your Account

In the **Development > API keys tab** of the sidebar you will find your test keys for performing test payments. Before the live keys are displayed, you will have to activate your account. In order to do so, you have to provide some information of your product, your business and your relationship to the company.

![API Keys](/Guides/images/getting_started-04.jpg)

**Quick guide to integrate PAYMILL**

The following PHP example can be copied 1:1 for a quick test of our services.
Please notice that you need a valid PAYMILL account with test keys (s.a.).

TODO: INTEGRATE THE  EXAMPLE


## 4. Payment Form

You can find one example of integrating Paymill in your payment form on GitHub or here as a Gist integration. Further information on the payment form can be found on our payment form page.

Depending on your payment type different form fields are required. For credit card payment your clients need to complete at least the following fields:

  - Creditcard number
  - Expiry month
  - Expiry year
  - Checking number (CVC)
  - Transaction amount (Integer e.g. "15" for 0.15 Euro)
  - Currency (ISO 4217, e.g. "EUR")

```html
<script type="text/javascript">
  var PAYMILL_PUBLIC_KEY = '62477926916d4da496cf4f1a77c4175d';
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="https://bridge.paymill.com"></script>
<script type="text/javascript">
  $(document).ready(function () {

    function PaymillResponseHandler(error, result) {
      if (error) {
        // Displays the error above the form
        $(".payment-errors").text(error.apierror);
      } else {
        $(".payment-errors").text("");
        var form = $("#payment-form");
        // Token
        var token = result.token;

        // Insert token into form in order to submit to server
        form.append("<input type='hidden' name='paymillToken' value='" + token + "'/>");
        form.get(0).submit();
      }
      $(".submit-button").removeAttr("disabled");
    }

    $("#payment-form").submit(function (event) {
      // Deactivate submit button to avoid further clicks
      $('.submit-button').attr("disabled", "disabled");

      if (!paymill.validateCardNumber($('.card-number').val())) {
        $(".payment-errors").text("Invalid card number");
        $(".submit-button").removeAttr("disabled");
        return false;
      }

      if (!paymill.validateExpiry(
        $('.card-expiry-month').val(),
        $('.card-expiry-year').val())
      ) {
        $(".payment-errors").text("Invalid expiration date");
        $(".submit-button").removeAttr("disabled");
        return false;
      }

      paymill.createToken({
      number:         $('.card-number').val(),
      exp_month:      $('.card-expiry-month').val(),
      exp_year:       $('.card-expiry-year').val(),
      cvc:            $('.card-cvc').val(),
      cardholder:     $('.card-holdername').val(),
      amount_int:     $('.card-amount-int').val(), // Integer e.g. "4900" für 49,00 EUR
      currency:       $('.card-currency').val()    // ISO 4217 z.B. "EUR"
      }, PaymillResponseHandler);

      return false;
    });
  });
</script>
```

For ELV* payments your clients need to complete at least the following fields:

  - Accountnumber
  - Bank identification code
  - Account holder

Alternative:

  - IBAN
  - BIC
  - Account holder

```html
<script type="text/javascript">
var PAYMILL_PUBLIC_KEY = '62477926916d4da496cf4f1a77c4175d';
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="https://bridge.paymill.com/"></script>
<script type="text/javascript">
$(document).ready(function () {

function PaymillResponseHandler(error, result) {
if (error) {
// Displays the error above the form
$(".payment-errors").text(error.apierror);
} else {
$(".payment-errors").text("");
var form = $("#payment-form");
// Token
var token = result.token;

// Insert token into form in order to submit to server
form.append("<input type='hidden' name='paymillToken' value='" + token + "'/>");
form.get(0).submit();
}
$(".submit-button").removeAttr("disabled");
}

$("#payment-form").submit(function (event) {
// Deactivate submit button to avoid further clicks
$('.submit-button').attr("disabled", "disabled");

paymill.createToken({
number:        $('.number').val(),             // ELV
bank:          $('.bank').val(),               // ELV
accountholder: $('.accountholder').val()       // ELV
}, PaymillResponseHandler);

return false;
});
});
</script>
```

<p class="important">
**Important information for the credit card data in your HTML form:**
With the payment form, it is essential that you do not put a name attribute with the input tags for credit card data!
In this way, the credit card data will not be returned to your server, and you will stay outside the legal provisions concerning the storage of such data (PCI compliance).
</p>

<p class="important">
**Important information for test data:**
Only specific credit card information / bank details are allowed in test mode. You can find the list here. Usage of any other data will result in error.
</p>

**JavaScript - integrating the Paymill bridge**

  - First you must enter your public key in the PAYMILL_PUBLIC_KEY variable.
  - Then you integrate our JavaScript bridge via the following URL: https://bridge.paymill.com


**Create your payment (ELV, credit card) token with the command createToken.**

  - As soon as the payment form is sent, you use createToken to create a token for your customers’ credit card data.
  - Then you insert the token in your payment form as a hidden field in order to send them back to your server, and all further payment function requests are performed using this token.


Example of integrating the HTML form, the bridge, and the createToken function for credit card:

```html
<script type="text/javascript">
var PAYMILL_PUBLIC_KEY = '62477926916d4da496cf4f1a77c4175d';
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="https://bridge.paymill.com/"></script>
<script type="text/javascript">
$(document).ready(function () {

function PaymillResponseHandler(error, result) {
if (error) {
// Displays the error above the form
$(".payment-errors").text(error.apierror);
} else {
$(".payment-errors").text("");
var form = $("#payment-form");
// Token
var token = result.token;

// Insert token into form in order to submit to server
form.append("<input type='hidden' name='paymillToken' value='" + token + "'/>");
form.get(0).submit();
}
$(".submit-button").removeAttr("disabled");
}

$("#payment-form").submit(function (event) {
// Deactivate submit button to avoid further clicks
$('.submit-button').attr("disabled", "disabled");

if (!paymill.validateCardNumber($('.card-number').val())) {
$(".payment-errors").text("Invalid card number");
$(".submit-button").removeAttr("disabled");
return false;
}

if (!paymill.validateExpiry(
  $('.card-expiry-month').val(),
  $('.card-expiry-year').val())
) {
$(".payment-errors").text("Invalid expiration date");
$(".submit-button").removeAttr("disabled");
return false;
}

paymill.createToken({
number:         $('.card-number').val(),
exp_month:      $('.card-expiry-month').val(),
exp_year:       $('.card-expiry-year').val(),
cvc:            $('.card-cvc').val(),
cardholder:     $('.card-holdername').val(),
amount_int:     $('.card-amount-int').val(),   // Integer z.B. "4900" für 49,00 EUR
currency:       $('.card-currency').val()      // ISO 4217 z.B. "EUR"
}, PaymillResponseHandler);

return false;
});
});
</script>
<div class="payment-errors"></div>
<form id="payment-form" action="request.php" method="POST">
<input class="card-amount-int" type="hidden" value="4900" />
<input class="card-currency" type="hidden" value="EUR" />

<div class="form-row"><label>Card number</label>
<input class="card-number" type="text" value="4111111111111111" size="20" /></div>

<div class="form-row"><label>CVC (Prüfnummer)</label>
<input class="card-cvc" type="text" value="111" size="4" /></div>

<div class="form-row"><label>Name</label>
<input class="card-holdername" type="text" value="Joe Doe" size="20" /></div>

<div class="form-row"><label>Expiry Date (MM/YYYY)</label>
<input class="card-expiry-month" type="text" value="02" size="2" />
<span> / </span>
<input class="card-expiry-year" type="text" value="2015" size="4" /></div>

<div class="form-row"><label>Currency</label>
<input class="card-currency" type="text" value="EUR" size="20" /></div>

<button class="submit-button" type="submit">Submit</button>

</form>
```

Example of integrating the HTML form, the bridge and the createToken function for ELV*:

```html
<script type="text/javascript">
var PAYMILL_PUBLIC_KEY = '62477926916d4da496cf4f1a77c4175d';
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="https://bridge.paymill.com/"></script>
<script type="text/javascript">
$(document).ready(function () {

function PaymillResponseHandler(error, result) {
if (error) {
// Displays the error above the form
$(".payment-errors").text(error.apierror);
} else {
$(".payment-errors").text("");
var form = $("#payment-form");
// Token
var token = result.token;

// Insert token into form in order to submit to server
form.append("<input type='hidden' name='paymillToken' value='" + token + "'/>");
form.get(0).submit();
}
$(".submit-button").removeAttr("disabled");
}

$("#payment-form").submit(function (event) {
// Deactivate submit button to avoid further clicks
$('.submit-button').attr("disabled", "disabled");

paymill.createToken({
number:        $('.number').val(),
bank:          $('.bank').val(),
accountholder: $('.accountholder').val()
}, PaymillResponseHandler);

return false;
});
});
</script>
<div class="payment-errors"></div>
<form id="payment-form" action="request.php" method="POST">

<div class="form-row"><label>Account number</label>
<input class="number" type="text" value="648489890" size="20" /></div>

<div class="form-row"><label>Bank code</label>
<input class="bank" type="text" value="50010517" size="4" /></div>

<div class="form-row"><label>Account holder</label>
<input class="accountholder" type="text" value="Chris Hansen" size="20" /></div>

<button class="submit-button" type="submit">Submit</button>

</form>
```

## 5. Carrying out Payments

Copy our PHP library in a subdirectory, e.g. lib.
You can find our PHP wrapper here: https://github.com/Paymill/Paymill-PHP

**The normal procedure is:**

1. You will need two pieces of information to use the Paymill PHP wrapper:
  - API-Endpoint: https://api.paymill.com/v2
  - Your Private Key from My Account

2. Integrate the wrapper classes in your script.

3. Retrieve the token that you have received in the payment form.

4. Create a new transaction object with the two required parameters from 1.

5. Set the two required parameters for, e.g. the payment function, which in this case would be the amount (see al/li>the API reference for all required attributes).

6. Then perform, e.g. the payment transaction function.

7. If there are any errors, you will receive an exception, a transaction_id is being sent to if it worked.


Here you can find a sample request:

```php
<?php
$token = $_POST['paymillToken'];

if ($token) {
    $request = new Paymill\Request('20c8b46fe20714ad3549a6267dc647ec');
    $transaction = new Paymill\Models\Request\Transaction();
    $transaction->setAmount(4200) // e.g. "4200" for 42.00 EUR
                ->setCurrency('EUR')
                ->setToken($token)
                ->setDescription('Test Transaction');

    $response = $request->create($transaction);

    echo "Transaction: ";
    print_r($response);
}
```

<p class="important">
* Please note that ELV payment is only available in Germany at the moment
</p>
