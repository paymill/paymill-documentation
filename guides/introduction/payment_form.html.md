---
title: "Payment Form"
menu: "Payment Form"
type: "guide"
status: "draft"
---

Paymill enables you to integrate credit card payments quickly, securely, simply and individually on your website. Our service is surely adhered with the credit card guidelines regarding sensitive customer payment data. You therefore do not have to worry about issues such as credit card information security.

You can integrate our Paymill payment form in your own website in three easy steps for the purpose of receiving credit card payments without any problems. This will save you from dealing with a complicated technical integration process.

## 1. Collecting Credit Card Data

At first, the Paymill Bridge (a JS integration) has to be integrated in your website. Ideally, it should be integrated before the closing </body> tag.

The Paymill bridge is required to create a unique token from the credit card. The credit card number can be verified if desired.


<p class="important">
You should always use your test key for non-live transactions, like the ones described in the documentation. Using your live key will be considered as a real request, and funds will be drawn from your account and/or credit card.
</p>

The public key that has been assigned will identify your website in Paymill for the unique creation of a token and will be given to you when you register on Paymill. Your complete code should look similar to this code snippet:

``` html
<script type="text/javascript">
  var PAYMILL_PUBLIC_KEY = '443368146777979106b2ce2042c289a5';
</script>
<script type="text/javascript" src="https://bridge.paymill.com/"></script>
```

<p class="info">
You will find your test keys and live keys in your account. It is important to always differentiate between the two keys in your own account. The key that you use and the activation status of your account will determine whether you employ the live key on your website, for instance. This will lead to real payment which involves costs.
</p>

Where do I find my keys?

Click on Development and go to the API Keys point. At first you will find your test keys that you can use to process test payments. As far as the live keys are concerned, you will have to activate your account first.



![Test Keys](/guides/images/payment_form-01.jpg)


## 2. Setting up and Integrating a Payment Form

In order for your website to meet legal standards, credit card information cannot be stored or transferred to your server. For this reason, the data are replaced with a token before being transferred to your server. Your server thus does not receives any sensitive credit card information!

The data are only referenced via the token and your private key. The token can be stored on your web server without you having to have a PCI compliance certification.

<p class="important">
Please note that the bridge sends the request data to our PCI-compliant server, which in turn talks with the credit card institutions. For this reason, the bridge might take a few seconds to deliver a response to your code. Therefore, please do not specify any fixed timeouts in your Javascript code when dealing with the Paymill bridge.
</p>

The data is referenced via the token and your private key only. The token can be stored on your server, without the need of getting PCI Compliance certified.

In order to obtain the necessary mandatory information for the token, you may use the following credit card form:

```html
<form id="payment-form" action="#" method="POST">

  <input class="card-amount-int" type="hidden" value="15" />
  <input class="card-currency" type="hidden" value="EUR" />

  <div class="form-row">
    <label>Card number</label>
    <input class="card-number" type="text" size="20" />
  </div>

  <div class="form-row">
    <label>CVC</label>
    <input class="card-cvc" type="text" size="4" />
  </div>

  <div class="form-row">
    <label>Name</label>
    <input class="card-holdername" type="text" size="4" />
  </div>

  <div class="form-row">
    <label>Expiry date (MM/YYYY)</label>
    <input class="card-expiry-month" type="text" size="2" />
    <span></span>
    <input class="card-expiry-year" type="text" size="4" />
  </div>


  <button class="submit-button" type="submit">Submit</button>

</form>
```

You can find more information on optional fields that can be transferred in our API Reference.

<p class="info">
In order to test the payment process, you may use the following credit card numbers:

**Visa**:       4111111111111111
**Mastercard**: 5105105105105100
**Maestro UK**: 6799851000000032
**Discover**:   6011587918359498 (Support by Paymill is planned)
**Solo**:       6334580500000000 (Support by Paymill is planned)

Please, always enter an expiration date in the future. Expiration dates in the past will cause the transaction to fail.

**3-D Secure credit card**

**Visa**:4012888888881881

You can use this test card number to run a test against a 3-D Secure enabled transaction. Using 3-D secure adds an additional layer of security to your transactions and helps to protect merchants against fraud.
**Note that the 3-D Secure test card can only be used when using your API live key.**
Using the 3-D Secure test card while using the API test key will cause an error to be thrown. As it is a test card, there's no need to worry about being charged when testing with the API live key.
</p>

<p class="info">
**Important information for test data**
Only specific credit card information / bank details are allowed in test mode. You can find the list here. Usage of any other data will result in error.
</p>

Data validation

In order to validate the data from your website, you can simply use the validation functions integrated in Paymill.

`validateCardNumber(cardNumber)`: Validates credit card number formatting.

```javascript
// This credit card number is valid
paymill.validateCardNumber('4111111111111111');

// These credit card numbers are invalid
paymill.validateCardNumber('4111-1111-1111-1111');
paymill.validateCardNumber('4111 1111 1111 1111');
paymill.validateCardNumber('12345678');
paymill.validateCardNumber('test111');
```

`validateExpiry(month, year)`: Validates whether the expiry date is in the future.

```javascript
paymill.validateExpiry('02', '15');      // false
paymill.validateExpiry('02', '10');      // false
paymill.validateExpiry('02', '2020');    // true
paymill.validateExpiry(2, 2020);         // true
```

`validateCvc(cvcNumber)`: Validates whether the credit card number contains a valid verification code.

```javascript
paymill.validateCvc('111'); // true
paymill.validateCvc('foo'); // false
```

`cardType(cardNumber)`: Returns the card type as a string. Possible types are Visa, MasterCard and similar. If a card is not recognized, the value is returned as “unknown”.

```javascript
paymill.cardType('4111111111111111'); // Visa
paymill.cardType('378282246310005'); // American Express
```

`validateAccountNumber(accountNumber)`: Checks, if value returns a correct bank account number.

```javascript
paymill.validateAccountNumber('648489890'); // true
paymill.validateAccountNumber('foo'); // false
```

`validateBankCode(bankCode)`: Checks, if value returns a correct bank code.

```javascript
paymill.validateBankCode('50010517'); // true
paymill.validateBankCode('foo'); // false
```

`validateIban(iban, verbose)`: Checks, if value returns a correct German IBAN. If the parameter verbose is set and the IBAN is not valid, it returns an exception.

```javascript
paymill.validateIban('DE89 3704 0044 0532 0130 00'); // true
paymill.validateIban('foo'); // false
paymill.validateIban('GB29 NWBK 6016 1331 9268 19'); // false
paymill.validateIban('GB29 NWBK 6016 1331 9268 19', true);
// field_invalid_country exception
```

<p class="important">
Payments may only be processed via the Paymill bridge.
Credit card data may not be transferred, logged, or saved to your server. In order to guarantee that you simply need to **leave out the name attribute in the form fields**. Then this form field will not be transferred to the merchant’s server either.
Every payment form that you send to Paymill should be sent via SSL for security reasons. If you do not have an SSL certificate, you can still use our services. However, we urge you to integrate SSL.
</p>

## 3. Setting up and Integrating a Payment Form

Creating a Token

In order to create a unique token, the credit card data needs to be verified and converted.

The credit card information is sent via SSL to the Paymill Payment Service Provider (PSP), which converts the credit card information to a token. A JavaScript function in your payment form is triggered, and this deactivates the Submit button and calls up a JavaScript event that is then sent to the Paymill Payment Service Provider (PSP).

The credit card number and the credit card expiration date have to be set as mandatory variables. Other fields are optional. Here is a sample code for securely transferring credit card data that you can use in any JavaScript framework (not just in jQuery):

```javascript
$(document).ready(function() {
  $("#payment-form").submit(function(event) {
    // Deactivate submit button to avoid further clicks
    $('.submit-button').attr("disabled", "disabled");

    paymill.createToken({
      number: $('.card-number').val(),  // required, ohne Leerzeichen und Bindestriche
      exp_month: $('.card-expiry-month').val(),   // required
      exp_year: $('.card-expiry-year').val(),     // required, vierstellig z.B. "2016"
      cvc: $('.card-cvc').val(),                  // required
      amount_int: $('.card-amount-int').val(),    // required, integer, z.B. "15" für 0,15 Euro
      currency: $('.card-currency').val(),    // required, ISO 4217 z.B. "EUR" od. "GBP"
      cardholder: $('.card-holdername').val() // optional
    }, PaymillResponseHandler);                   // Info dazu weiter unten

    return false;
  });
});
```

The data is transferred via SSL to the Paymill Payment Service Provider (PSP). The Paymill PSP validates the data and returns a unique token to you as a token object together with an empty error report object. In the event of an error, the token object would be empty and the error report object filled.

The data transfer is picked up by the PaymillResponseHandler function in your form in the browser. A JSON object is returned as a result. There are always 2 objects that are issued: error and result. One of the two is always a NULL value and thus functional/non-functional.

For example, a successful response (response object) with the following characteristics:

```javascript
{
  "token":"4ff43649b5853"
}
```

Data Transfer to Your Server

The response (response object) for the form data is picked up by the PaymillResponseHandler function and transferred to your website:

```javascript
function PaymillResponseHandler(error, result) {
  if (error) {
    // Shows the error above the form
    $(".payment-errors").text(error.apierror);
    $(".submit-button").removeAttr("disabled");
  } else {
    var form = $("#payment-form");
    // Output token
    var token = result.token;
    // Insert token into form in order to submit to server
    form.append("");
  }
}
```

In order to integrate a complete Paymill payment form on your website for testing, copy our entire code from our GitHub repository.
