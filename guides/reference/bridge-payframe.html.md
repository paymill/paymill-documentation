---
title: "Bridge PayFrame"
menu: "Bridge PayFrame"
type: "guide"
status: "published"
menuOrder: 3
---

PCI DSS 3.0 introduces a new set of requirements for merchants accepting credit card payments. In order to be (or stay) eligible for the simpler form of self assessment (SAQ A), we need to move all credit card data out of the scope of the merchant's website. We therefore offer an **iFrame-based credit card form** that achieves SAQ A eligibility.

Please note that this restriction only applies to credit card data, all other functionality is unaffected. In particular, direct debit payments are processed just like before. Merchants can even choose to keep collecting credit card data on their own site, but they will have to comply with SAQ A-EP accordingly.

<div class="info">
  Our credit card frame is available for Chrome, Firefox, Safari and Opera but only for Internet Explorer 8 and above for compatibility and security reasons.
</div>

### Loading the necessary Scripts

First your Paymill public key has to be loaded. This is done with JS and can look like this:

```
<script type="text/javascript">
      var PAYMILL_PUBLIC_KEY = '2733005259312dcc48f078d54f2096b6';
      var VALIDATE_CVC = true;
    </script>
```
Second the Paymill bridge has to be loaded. This looks like this:

```
<script type="text/javascript" src = "https://bridge.paymill.com/"></script>
```

### Embedding the credit card frame

Our bridge provides a method `embedFrame(container, options, callback)` to embed a credit card frame in your page which can subsequently be customized to your needs. Please be aware that this whole next part hast to be a part of Javascript. Meaning it has to be inside the following:
```
<script type = “text/javascript”>
.//the whole next part
.//should be in 
.//here!
</script>
```
Now we can define options and callback. The code for this can be taken from this example: 

```
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

```
       var initPayframe = function() {
         paymill.embedFrame('credit-card-fields', options, callback);
       };

```
### Creating a Token and submitting the form

The last step is to define the submit button functionality. For this purpose the function submitForm can be defined. This function will call the paymill.createTokenViaFrame. It can look like this: 
```
var submitForm = function() {
         paymill.createTokenViaFrame({
            amount_int: 420, // 420 for 4.20 amount_int hast to be an integer
            currency: 'EUR',
            email: 'test@customer.com'
            },
         function(error, result) {
              // Handle error or process result.
            if (error) {
                // Token could not be created, check error object for reason.
              console.log(error.apierror, error.message);
            }
              // Token was created successfully and can be sent to backend.
            else {
              console.log(result.token);
              var form = document.getElementById("payment-form");
              var tokenField = document.getElementById("paymillToken");
              tokenField.value = result.token;
              form.submit();
              }
            }
          );
        }
```
The amount, currency and email fields are required and have to be submitted! Afterward if there are no errors, the token is appended to the form which is then submitted. 
Your response handler receives the same `error and `result` object as before and doesn't have to change.

In addition to the errors of `createToken`, which can be found in the Documentation about our bridge, the following errors can occur when using `createTokenViaFrame`:

- `frame_not_found - no credit card frame was found, make sure you have called `embedFrame` successfully

<div class="important">
  The regular `createToken` still exists and continues to be the appropriate method for creating **direct debit** tokens.
</div>

Don’t forget to close the script after this has been done with </script>

### Choosing a language

By default, the credit card form uses English for labels, placeholders and error messages. Simply specify the corresponding language code using `lang` in the `options` parameter of `embedFrame`. As this was already defined above, all you have to do is insert another language here in oder to change the language of the payframe.

```      var options = {
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

<div class="info">
If you need additional languages or can even provide a translation yourself, please <a href="mailto:support@paymill.com?subject=PayFrame%20translation">contact us</a>.
</div>

## Additional Options

After embedding the credit card frame you can take additional measures to control the form's behavior, both while it's loading and being used. 


### Handling content resizing

The dimensions of the iFrame's content can change due to several factors like stylesheets loading, error messages being shown or CSS transitions or animations.

By default, the iFrame automatically resizes **vertically** to fit its content. This means the iFrame element will have a width of 100% but a variable height, starting with `0px` until the frame has loaded.

You can disable this behavior by setting a flag in the `options parameter. If you do this, the iFrame will have its height also set to `100%`. We recommend setting a fixed container height to accommodate the iFrame content.

```
 var options = {
        lang: 'en'
        resize: false
        };
```

Alternatively, you can take over the resizing process by providing a custom resizing function. The iFrame will still have width and height set to `100%` in the beginning, but your function will be called each time the iFrame needs a resize. It will be passed an `attrs` parameter containing relevant attributes (currently only the content's height) so you can manipulate the container element accordingly.

```
// Provide custom resizing function.
 var options = {
  resize: function(attrs) {
    container.style.height = attrs.height + 'px';
    // Make other adjustments based on iFrame dimensions.
    }
  };
```

<div class="info">
With both disabled and custom resizing, the iFrame has width and height set to `100%` to fit its container element. It's highly recommended that you only style the container since you have full control over it. The iFrame, on the other hand, won't be available until it has loaded and might be removed from the DOM if loading fails.
</div>

### Using 3-D Secure

3-D Secure is also available with the credit card frame and handling remains the same: The default modal dialog will be displayed automatically or you handle it yourself by providing the optional tdsInit and tdsCleanup callbacks.

```javascript
paymill.createTokenViaFrame(data, callback, tdsInit, tdsCleanup);
```
