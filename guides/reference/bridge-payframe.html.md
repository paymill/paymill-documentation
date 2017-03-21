---
title: "Bridge PayFrame"
menu: "Bridge PayFrame"
type: "guide"
status: "published"
menuOrder: 3
---

PCI DSS 3.0 introduces a new set of requirements for merchants accepting credit card payments. In order to be (or stay) eligible for the simpler form of self assessment (SAQ A), we need to move all credit card data out of the scope of the merchant's website. We therefore offer an **iFrame-based credit card form** that achieves SAQ A eligibility. You can find out more information on the SAQ-A questionnaire [here](https://www.pcisecuritystandards.org/documents/SAQ_A_v3.pdf).
This guide explains how to integrate the Payframe and receive a token from Paymill.


_Our credit card frame is available for Chrome, Firefox, Safari and Opera but only for Internet Explorer 8 and above for compatibility and security reasons._

You can view and download an example file [here](https://github.com/Savaage/paymill-documentation/blob/MR11/download/paymill_payframe.html).

### Load the Paymill Bridge and your public key

First your Paymill public key has to be loaded. This is done with JS and can look like this:

```
<script type="text/javascript">
      var PAYMILL_PUBLIC_KEY = '<YOUR_PUBLIC_KEY>';
    </script>
```
Second the Paymill bridge has to be loaded. This can look like this:

```
<script type="text/javascript" src = "https://bridge.paymill.com/"></script>
```

### Embedding the credit card frame

Our bridge provides a method `embedFrame(container, options, callback)` to embed a credit card frame in your page which can subsequently be customized to your needs. Please be aware that the whole next part hast to be a part of a Javascript. Meaning it has to be inside the following:
```
<script type = “text/javascript”>
.
.
.
</script>
```

### Define the parameters of the method embedFrame

Now we can define options and callback. The code for this can be taken from this example:

```javascript
      var options = {
        lang: 'en'
        };

      var callback = function(error){
	//Frame could not be loaded, check error object for reason
        if(error){
          console.log(error.apierror,error.message);
	// Example: "container_not_found"
          }
	//Frame was loaded successfully
          else {
          }
       };
```
Further language options are listed below.

If the callback is called without an error object, the credit card form is ready to be used. You might want to hide the container element until the frame has loaded and only show it then.

The following errors can occur during frame load:

- `container_not_found` - the container element specified could not be found
- `frame_not_loaded` - frame didn't load for another reason

Now we can embed the frame. For his purpose we can define function initPayframe:

```javascript
       var initPayframe = function() {
         paymill.embedFrame('credit-card-fields', options, callback);
       };

```
### Creating a Token and submitting the form

The last step is to define the submit button functionality. For this purpose the function submitForm can be defined. This function will call the paymill.createTokenViaFrame. It can look like this:

```javascript
var submitForm = function() {
         paymill.createTokenViaFrame({
            amount_int: 420, // 420 for 4.20 amount_int hast to be an integer, required
            currency: 'EUR', // required
            email: 'test@customer.com' //required
            },
         function(error, result) {
              // Handle error or process result.
            if (error) {
                // Token could not be created, check error object for reason.
              console.log(error.apierror, error.message);
            }
              // Token was created successfully and can be sent to backend.
            else {
	      // If you want to log the response in the console
              console.log(result.token);
	      // Fetch the token, and add it to the form, which is then submitted to your server
              var form = document.getElementById("payment-form");
              var tokenField = document.getElementById("paymillToken");
              tokenField.value = result.token;
              form.submit();
              }
            }
          );
        }
```
The amount, currency and email fields are required and have to be submitted! Afterwards if there are no errors, the token is appended to the form which is then submitted to your server.
Your response handler receives the same `error` and `result` object as before and doesn't have to change.

The following errors can occur when using `createTokenViaFrame`:

  - `frame_not_found`                 : no credit card frame was found, make sure you have called `embedFrame` successfully
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
  - `field_invalid_email`             : Invalid email address
  - `field_invalid_amount_int`        : Invalid or missing amount for 3-D Secure
  - `field_invalid_amount`            : Invalid or missing amount for 3-D Secure. **deprecated , [see blog post](https://blog.paymill.com/about-rounding-floats-new-bridge-parameter/)**
  - `field_invalid_currency`          : Invalid or missing currency code for 3-D Secure  


_The regular `createToken` still exists and continues to be the appropriate method for creating **direct debit** tokens._

The whole part explained above was part of the Javascript, and all Javascripts were in the head. Make sure these steps are done:

1. load your public key
2. load the Paymill bridge.
3. call `embedFrame` and append the token to the form and define the submit button functionality.

If this is done, please close the last JS with </script> and close the head </head>.

### Choosing a language

By default, the credit card form uses English for labels, placeholders and error messages. Simply specify the corresponding language code using `lang` in the `options` parameter of `embedFrame`. As this was already defined above, all you have to do is insert another language here in oder to change the language of the payframe.

```javascript  
	var options = {
        lang: 'en'
        };
```

**Available languages:**

- Czech `cs`
- Danish `da`
- Dutch `nl`
- English `en`
- French `fr`
- German `de`
- Hungarian `hu`
- Italian `it`
- Japanese `ja`
- Latvian `lv`
- Norwegian `no`
- Norwegian (Bokmål) `nb`
- Polish `pl`
- Portuguese `pt`
- Romanian `ro`
- Russian `ru`
- Slovak `sk`
- Slovenian `sl`
- Spanish `es`
- Swedish `sv`
- Turkish `tr`
- Finish `fi`

_If you need additional languages or can even provide a translation yourself, please <a href="mailto:support@paymill.com?subject=PayFrame%20translation">contact us</a>._

### Additional Options

After embedding the credit card frame you can take additional measures to control the form's behavior, both while it's loading and being used.


### Handling content resizing

The dimensions of the iFrame's content can change due to several factors like stylesheets loading, error messages being shown or CSS transitions or animations.

By default, the iFrame automatically resizes **vertically** to fit its content. This means the iFrame element will have a width of 100% but a variable height, starting with `0px` until the frame has loaded.

You can disable this behavior by setting a flag in the `options` parameter. If you do this, the iFrame will have its height also set to `100%`. We recommend setting a fixed container height to accommodate the iFrame content.

```javascript
 var options = {
        lang: 'en'
        resize: false
        };
```

Alternatively, you can take over the resizing process by providing a custom resizing function. The iFrame will still have width and height set to `100%` in the beginning, but your function will be called each time the iFrame needs a resize. It will be passed an `attrs` parameter containing relevant attributes (currently only the content's height) so you can manipulate the container element accordingly.

```javascript
// Provide custom resizing function.
 var options = {
  resize: function(attrs) {
    container.style.height = attrs.height + 'px';
    // Make other adjustments based on iFrame dimensions.
    }
  };
```

_With both disabled and custom resizing, the iFrame has width and height set to `100%` to fit its container element. It's highly recommended that you only style the container since you have full control over it. The iFrame, on the other hand, won't be available until it has loaded and might be removed from the DOM if loading fails._

### Using 3-D Secure

3-D Secure is also available with the credit card frame and handling remains the same: The default modal dialog will be displayed automatically or you handle it yourself by providing the optional tdsInit and tdsCleanup callbacks.

```javascript
paymill.createTokenViaFrame(data, callback, tdsInit, tdsCleanup);
```
### Submitting the form for further work

The only thing left to do is to define the body, the form itself and the submit button.
This will submit the form to our desired file for further handling. You can check the API reference [here](https://developers.paymill.com/API/index)!

```html
  </head>
    <!-- the initPayframe() has to wait for everything to load -->
    <body onload = "initPayFrame()">
      <!-- please specify the file with which you handle the received token in the field action ="request.php" -->
      <form id = "payment-form" action = "request.php" method = "POST">
        <div id = "credit-card-fields"></div>
        <!-- here you can specify any other fields you have in your checkout -->
        <input id = "paymillToken" name = "paymillToken" type = "hidden" />
        <!-- insert a button to submit the form -->
        <input type = "button" value = "Submit" onclick = "submitForm()">
      </form>

    </body>
</html>
```
The above example code calls the initPayframe on load, then defines the request.php as the file to submit the form to. If you have any further fields in your checkout you would like to add, you can add them after `<div id = "credit-card-fields"></div>`.
Last step is the definition of what the submit button does. That's it! You're ready to use the Payframe solution from PAYMILL!
You can view and download an example file [here](https://github.com/paymill/paymill-documentation/blob/master/download/paymill_payframe.html).
A file that will create a transaction if used together with the Payframe can be found here: [here](https://github.com/paymill/paymill-documentation/tree/master/download/request.php).
