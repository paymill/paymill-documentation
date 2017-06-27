---
title: "PayButton"
menu: "PayButton"
type: "guide"
status: "published"
menuOrder: 1
---

Creating a credit card form and integrating it into your site can be a time consuming exercise. To make life easier, we've created the PAYMILL PayButton.

The PayButton makes integrating a payment form into your website much easier.

By using the PayButton, design, validation and encryption are handled for you, allowing you to spend more time perfecting other areas of your website. To get started, simply copy and paste one form element into your website source code, entering your public live key (`data-public-key`). You’ll also need to set the amount (`data-amount`) for each payment. Easy.

<p class="important">
  For your test please use the following credit card numbers
  Visa: 4111 1111 1111 1111 CVV: 123 Expiry Date: > actual month/year
  MasterCard: 5500 0000 0000 0004 CVV: 123 Expiry Date: > actual month/year
</p>

[Video - How to integrate](https://www.youtube.com/watch?v=signiOotacg)

## Example payment

![Example payment](/guides/images/pay_button-01.jpg)

## Example subscription

![Example subscription](/guides/images/pay_button-02.jpg)


Your personal API keys (live and test) can be found by logging into your PAYMILL account and navigating to "My Account"> "Settings"> "API key". After submitting the form a hidden field with the token, which is generated from the credit card data, is stored in your form. This field must be sent to your server and must be processed on server side (the server-side processing will be described below).

## Payment: Embed Code for your website

```html
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<form action="request.php" method="post">
    <script
        src="https://button.paymill.com/v1/"
        id="button"
        data-label="Pay with CreditCard"
        data-title="Buy our product"
        data-description="It's a great product"
        data-submit-button="Pay 2.50 EUR"
        data-amount="250"
        data-currency="EUR"
        data-public-key="517113797587d2ba3ee19bd646ffb7f1"
        data-email="customer@test.com" // Customers email address
        data-email-field="true" // true if data-email not set
        data-elv="true" // Only for ELV payments
        data-lang="de-DE" // Optional language Code
        data-width="180" // Optional width of the paybutton
        data-height="45" // Optional height of the paybutton
        data-inline="true" // (Optional) render the button inline
        data-logo="logo.png" // (Optional) display a custom logo.
        >
    </script>
</form>
```

If you already have requested your customers email address, you should provide the email address with the `data-email` attribute. If you haven´t requested the email address yet please use the `data-email-field` attribute to show the email input field in the PayButton form.

## Subscription: Embed Code for your website

```html
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<form action="subscription.php" method="post">
    <script
        src="https://button.paymill.com/v1/"
        id="button"
        data-label="Pay with CreditCard"
        data-title="Buy our subscription"
        data-description="It's a great product"
        data-submit-button="Subscribe 2.50 EUR/Month"
        data-amount="250"
        data-currency="EUR"
        data-public-key="517113797587d2ba3ee19bd646ffb7f1"
        data-email="customer@test.com" // Customers email address
        data-email-field="true" // true if data-email not set
        data-elv="false" // Only for ELV payments
        data-lang="en-GB" // Optional language Code
        >
    </script>
</form>
```

You can also change the following additional attributes in the form:

Property             | Description                                                                                  | Required
---------------------|----------------------------------------------------------------------------------------------|---------
`data-label`         | Text of the pay button                                                                       | No, defaults to "Pay With Card"
`data-title`         | Text to show at the top of the popup (max. 50 characters)                                    | Yes
`data-description`   | Text to show below the title in the popup (max. 25 characters)                               | Yes
`data-submit-button` | Text to show on the button inside the popup                                                  | Yes
`data-amount`        | How much money to charge                                                                     | Yes
`data-currency`      | The currency to charge                                                                       | No, defaults to "EUR"
`data-public-key`    | Your PAYMILL key                                                                             | Yes
`data-email`         | Your customers email address                                                                 | Optional (Either `data-email` or `data-email-field` is required)
`data-email-field`   | Show email address input field                                                               | Optional (Either `data-email` or `data-email-field` is required)
`data-elv`           | true                                                                                         | Only for ELV payments
`data-lang`          | Language Code                                                                                | Optional parameter "de-DE", "en-GB", "es-ES", "fr-FR", "it-IT", "pt-PT"
`data-width`         | Width of the PayButton                                                                       | No, defaults to 220px
`data-height`        | Height of the PayButton                                                                      | No, defaults to 42px
`data-inline`        | Set to "true" to render the button inline, without the iFrame wrapper and no default CSS.    | No, false by default
`data-logo`          | Set to a relative image URL to display a custom logo. Set to 'false' to show no logo at all. | No, shows the PAYMILL signet by default


Learn more about test credit cards and test bank account numbers under [this page](/guides/reference/testing.html).

If you want to process the returned token in a different way to our proposal this is also possible. Please catch then the token event and further process it in the following script template:

```html
  <script>
  $( "#button" ).on( "token", function( event, token ) {
      // do something useful with the token
  });
  </script>
```

<p class="important">
The PayButton generates no direct transaction for your shop, only a token in a simple way. To perform a complete transaction, the server-side code eg. PHP is required, which is further described below with our PHP Wrapper. We also recommend that all forms are transfered with [SSL](/guides/security/security-standards.html) - this means that all datatraffic between the browser and server is encrypted and the server is verified.
</p>

## Configure the PayButton on the server-side

The easiest way to fully integrate the PayButton is to use our [PayButton example](https://github.com/paymill/paybutton-examples). Here you only need to insert the amount, the currency and your private key in request.php, copy all files to your web server and at the end you get a "Transaction successful" message. We do the rest for you.
For a subscription you can also insert an interval in subscription.php.

<p class="important">
  The following requirements must be met for the server-side configuration:
  You will need access to your server to install and run server-side scripts.
  PHP equal or higher than 5.2 and cURL must be installed on the server.
</p>

Alternatively, you can also use our [API libraries](http://localhost:9778/guides/integration/libraries.html). For the following example configuration we use the PHP wrapper. You must have our PHP Wrapper ([github.com/Paymill/Paymill-PHP](https://github.com/Paymill/Paymill-PHP)).

## Example configuration of the server-side PHP page

Either create a config.php with the specific configuration parameters, or define it directly in the PHP page (see example).

```php
  // Please download the newest version of our Paymill PHP Wrapper at
  // https://github.com/paymill/paymill-php/releases and put it
  // into a folder where it can be autoloaded
  // or
  // Download the newest stable version via composer
  // "paymill/paymill": "v3.*" on packagist.org
  // https://packagist.org/packages/paymill/paymill
  define('PAYMILL_API_KEY', '<PRIVATE_API_KEY | PRIVATE_TEST_KEY>');
```

<p class="info">
  The public and private keys must be exchanged for live operations - Don't forget that!
</p>

This part of the script gets the token that was passed as a form variable via POST (`$token = $_POST['paymillToken'];`) and generates a transaction object that is passed to the API PAYMILL.

```php
if(isset($_POST['paymillToken'])) {
    $token = $_POST['paymillToken'];

    $request = new Paymill\Request(PAYMILL_API_KEY);
    $transaction = new Paymill\Models\Request\Transaction();
    $transaction->setAmount(4200) // e.g. "4200" for 42.00 EUR
                ->setCurrency('EUR')
                ->setToken($token)
                ->setDescription('Test Transaction');

    $transaction = $request->create($transaction);

    if ($transaction->getStatus() == 'closed') {
        echo '<strong>transaction successful!</strong>';
    }
}
```

<p class="info">
  If the currency, amount and description will not be dynamically read out/ transfered from the form, it is required that you'll collect these attributs on yourself.
</p>

## Our PayButton supports the following Browsers

- Chrome Current
- Safari Current
- Firefox Current
- IE 9+
