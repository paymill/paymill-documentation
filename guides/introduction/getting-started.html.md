---
title: "Getting Started"
menu: "Getting Started"
type: "guide"
status: "published"
menuOrder: 1
---

Integrating PAYMILL is fast and easy. You can start accepting payments in a matter of minutes.

If you'd like to get a quick overview of PAYMILL integration process follow along this quick guide which will show you how to set up a payment form for accepting credit card payments.

## Prerequisites

### PHP

PAYMILL can be integrated in almost any technological stack. Check out the list of the supported languages in our [Libraries](https://developers.paymill.com/guides/integration/libraries.html) page.

For the purpose of this guide, we will use PHP. Don't worry if you are not a PHP expert, it's meant to demonstrate the concepts that you can apply to your own prefered technology.

If PHP is not installed on your system, go to http://php.net/manual/en/install.php and install the proper version for your platform.

<p class="important">
  To use the builtin server, make sure your version is >= 5.4
</p>

### Get the example project

#### Via Git

If you are a git user, you can directly clone the repository

```bash
git clone git@github.com:paymill/quickstart-php.git
```

#### Download the archive

If you don't user Git, the project is also available as a zip archive here : https://github.com/paymill/quickstart-php/archive/master.zip

Download and extract it.


### Run the project

Once you installed the dependencies you can run the project.

```bash
php -S localhost:3000
```
You can now access it in your browser at the following URL: http://localhost:3000

## Let's get started

As you can see the application we are working on is a paid article on easy payments integration.
For 42€, people will be able to buy a guide explaining how to easily integrate payments in their website.

![](/guides/images/quickstart-01.png)

We've got everything in place. We only miss a payment system to start making money!

### Integrate the payment form

The first thing we need to do is to integrate a payment form for the user to submit his credit card details.

In the `index.php` file, locate the following code:

```html
<!-- INSERT PAYMENT FORM HERE -->
<div><img src="/images/comingsoon.png" alt="Coming Soon" /></div>
<!-- END FORM -->

<a class="btn btn-lg btn-success" href="#" role="button">Get your "Easy Payments Guide" now for 42€</a>
```

And replace it with the following form:

```html
<div class="row">
  <form class="payment-form col-lg-5 collapse" id="payment-form" action="/payment.php" method="POST">
    <input type="hidden" name="amount" value="4200">
    <input type="hidden" name="currency" value="EUR">
    <input type="hidden" name="description" value="Easy Payments Guide!!!">

    <div id="credit-card-fields">
      <!-- Embedded credit card frame will load here -->
    </div>

    <button class='form-control btn btn-success submit-button' type='submit'>Get your "Easy Payments Guide" now for 42€</button>
  </form>
</div>
```

This form provides three hidden fields with information to make the PAYMILL transaction:

  - `amount`: The amount charged on the credit card. Please note **it is provided in cents** so we've got 42€ here.
  - `currency`: The currency to use for the transaction.
  - `description`: An optional description that will be attached to the transaction. Here we'll use it to easily identify where the transaction came from.

You may be wondering where the fields for the actual credit card data are. In fact they will be injected later in an iframe thanks to our **Bridge PayFrame** feature. The reason we are doing that is to simplify your security requirement.

<p class="info">
You can learn more about PCI security reading [this guide](https://developers.paymill.com/guides/security/pci-security) and the [Bridge PayFrame](https://developers.paymill.com/guides/reference/bridge-payframe) documentation.
<br>
You could also create your own form but keep in mind you will need to meet the corresponding security requirements.
</p>

Now you need to include the **PayFrame Bridge** javascript code. Add this line at the bottom of the `<body>` in the `views/index.ejs` file.

```html
<script src="https://bridge.paymill.com/"></script>
```

Then below add the following code.

```html
<script>
  // Callback for the PayFrame
  var payFrameCallback = function (error) {
    if (error) {
      // Frame could not be loaded, check error object for reason.
      console.log(error.apierror, error.message);
    } else {
      // Frame was loaded successfully and is ready to be used.
      console.log("PayFrame successfully loaded");
      $("#payment-form").show(300);
    }
  }

  $(document).ready(function () {
    paymill.embedFrame('credit-card-fields', {
      lang: 'en'
    }, payFrameCallback);
  });
</script>
```

When the page has loaded it will insert the **iframe** in your div with the `credit_card_fields` id. We also pass a callback, that we defined as `payFrameCallback`. If an error was returned it will display it in the console, otherwise it will display the form. We hide the form by default so nothing is shown until the **iframe** has finished loading.

We'll add some styling to have our form centered in the `css/styles.css`.

```css
.payment-form {
  float: none;
  margin: 0 auto;
}
```

Now if you reload the page you should see your payment form appear.


### Create a PAYMILL account

Before we continue you'll need to create a PAYMILL account if you don't have one yet. It's free and it only takes a couple of minutes.

Go to https://app.paymill.com/user/register and fill-in the form

![](/guides/images/quickstart-02.jpg)

Once you're done, you'll have access to your PAYMILL merchant interface called the **Merchant Centre**. This is the place where you manage everything about your account.

![](/guides/images/quickstart-03.jpg)

Your account is now in **test mode**. It means you can only make test transactions. No money will be ever charged when in **test mode**. To learn more about the **test mode**, the **live mode** and the activation process, you can check the [Your Account guide](https://developers.paymill.com/guides/introduction/your-account.html).


Go to the **Development > API keys** tab to access your **API Keys** that you'll use to perform operations on your account from your code.

### Create a token

Your server will never handle credit card data for security reasons. You need to send the form data to our servers first. Then we'll issue a token that you will be able to use to create the transaction.

Add the following code below the **PayFrame** callback:

```javascript
//...

var submit = function (event) {
  paymill.createTokenViaFrame({
    amount_int: 4200,
    currency: 'EUR'
  }, function(error, result) {
    // Handle error or process result.
    if (error) {
      // Token could not be created, check error object for reason.
      console.log(error.apierror, error.message);
    } else {
      // Token was created successfully and can be sent to backend.
      var form = $("#payment-form");
      var token = result.token;
      form.append("<input type='hidden' name='token' value='" + token + "'/>");
      form.get(0).submit();
    }
  });

  return false;
}

//...
```

What it does is sending the information to our server securely. If something wrong happens we'll log the error in the console otherwise we'll add an hidden field containing the token to the form so you can submit it to your server.

Then we submit the form.

The only thing left to do is to handle the form submission. Update your code this way:

```javascript
$(document).ready(function () {
  paymill.embedFrame('credit-card-fields', {
    lang: 'en'
  }, payFrameCallback);

  // Form submit handler
  $("#payment-form").submit(submit);
});
```

The only thing left to do is to add your **PAYMILL Public API Key**

```javascript
<script>
  PAYMILL_PUBLIC_KEY = "<PAYMILL_PUBLIC_KEY>"; // Insert your Public API Key here

  // Callback for PayFram initialization
  var payFrameCallback = function (error) {

  // Rest of the code ...

  }
</script>
```

That's it for the client side.

### Create the transaction on your server

We now need to handle the transaction creation on the server.

First we'll install the [PAYMILL PHP Wrapper](https://github.com/paymill/paymill-php)

If you are using **Compose**, you can follow the instructions on GitHub.

Otherwise [download the archive](https://github.com/paymill/paymill-php/archive/master.zip) and unzip the content in the `lib/paymill-php` folder.

Then create a `payment.php` file and insert the following content:

```php
<?php
  require 'lib/paymill-php/autoload.php';

  $apiKey = "<PAYMILL_PRIVATE_KEY>";
  $request = new Paymill\Request($apiKey);
  $transaction = new Paymill\Models\Request\Transaction();
  $transaction->setAmount($_POST['amount'])
              ->setCurrency($_POST['currency'])
              ->setToken($_POST['token'])
              ->setDescription($_POST['description']);
  try {
    $response = $request->create($transaction);
    include("_guide.php");
  } catch(\Paymill\Services\PaymillException $e){
    echo("An error occured while processing the transaction: ");
    echo($e->getErrorMessage());
  }
?>
```
- First we require the PAYMILL PHP Wrapper
- Then we initialize the PAYMILL wrapper with our **Private API Key**
- We initialize a `tansaction` object with it the `amount`, the `currency`, the `token` and the `description`.
- Finally we actually create the Transaction.
- We include the transaction creation in a `try / catch` block so if something wrong happens we show an error. Otherwise we display the content.

You only need the content page now. create the `_guide.php` file and paste the following code

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PAYMILL QUICKSTART</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/styles.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="/">PAYMILL QUICKSTART</a>
        </div>
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">
        <h1>Your payment was successfully processed.</h1>

        <p class="lead">It's easy to integrate payments! You just did it!</p>
        <p class="lead">Thanks for following this Quickstart!
          <br>
          Get further information on <a href="http://developers.paymill.com">the PAYMILL Developer Centre</a>
        </p>
      </div>

    </div>
  </body>
</html>

```

### Get your guide

Restart your server and access `http://localhost:3000`.

Enter the following data in the form:

- **Credit card number**: 4111111111111111
- **Verification number**: 123 (any 3 digits)
- **Cardholder**: John Doe (any name)
- **Expires**: 12 / 2020 (any date in the future)

Press the button and voilà! Isn't it cute?

<p class="important">
  Don't enter real credit card data. Our testing servers don't have the same security level as the production one.
  Only the provided testing data will work in test mode.
  <br>
  You can learn more about testing [here](https://developers.paymill.com/guides/reference/testing.html)
</p>

If you go back to your [Merchant Centre](https://app.paymill.com) and open the **Manage > Transactions** tab, you should see your payment.

### Conclusion

You just saw how easy it is to integrate PAYMILL in your project. Remember, we've been using **PHP** but the process would be exactly the same with any of the others supported languages.

There are many other features available. In a real-world case you would want to wait for the confirmation from the bank after making a transaction using **Webhooks** ...

You can get further reading the [Guides](/guides) and the [API Reference](/API).
