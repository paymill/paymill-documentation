---
title: "Bridge PayFrame"
menu: "Bridge PayFrame"
type: "guide"
status: "published"
menuOrder: 3
---

PCI DSS 3.0 introduces a new set of requirements for merchants accepting credit card payments. In order to be (or stay) eligible for the simpler form of self assessment (SAQ A), we need to move all credit card data out of the scope of the merchant's website. We therefore offer an **iframe-based credit card form** that achieves SAQ A eligibility.

Please note that this restriction only applies to credit card data, all other functionality is unaffected. In particular, direct debit payments are processed just like before. Merchants can even choose to keep collecting credit card data on their own site, but they will have to comply with SAQ A-EP accordingly.

<div class="info">
  Our credit card frame is available for Chrome, Firefox, Safari and Opera but only for Internet Explorer 8 and above for compatibility and security reasons.
</div>

## Basic Setup

Please use the JavaScript bridge at https://bridge.paymill.com/dss3 instead of https://bridge.paymill.com to use the credit card frame.

```
<script src="https://bridge.paymill.com/dss3"></script>
```

Before we bring the new solution to the standard version of our bridge, we have it available at a separate URL. Later this year we will bring this functionality to the standard version. Once we have updated our standard version, you can move back to the standard URL.

### Embedding the credit card frame

Our bridge provides a method `embedFrame(container, options, callback)` to embed a credit card frame in your page which can subsequently be customized to your needs.

Let's assume you have a checkout form with a variety of fields and added a container element to hold the credit card fields.

```
<form action="/store/orders" method="POST">
  <!-- Other fields of your form -->
  <div id="credit-card-fields">
    <!-- Embedded credit card frame will load here -->
  </div>
  <!-- Other fields of your form -->
</form>
```

You can now embed a credit card frame in this element by either specifying its ID or referencing the DOM node directly, jQuery objects are also supported.

```
// Provide the container element ID:
paymill.embedFrame('credit-card-fields', options, callback);

// Provide a DOM element:
paymill.embedFrame(document.getElementById('credit-card-fields'), options, callback);

// Provide a jQuery object:
paymill.embedFrame($('#credit-card-fields'), options, callback);
```

This loads an iframe containing the new credit card frame. Customization settings passed in `options` will be applied to the form inside the `iframe`. Finally, callback will be called with the result of the embedding operation (see next section).

<div class="important">
  We strongly suggest setting a Content-Security-Policy header to control where scripts or iframes are allowed to be loaded from or connect to. For example:
  <br>
  `default-src 'self'; frame-src 'self' *; script-src 'self' *.paymill.com *.paymill.de 'unsafe-inline'; connect-src 'self' *.paymill.com *.paymill.de; style-src 'self' *.paymill.com *.paymill.de 'unsafe-inline';`
</div>


### Choosing a language

By default, the credit card form uses English for labels, placeholders and error messages. Simply specify the corresponding language code using `lang` in the `options` parameter of `embedFrame`.

```javascript
paymill.embedFrame(container, {
  lang: 'de'
}, callback);
```

Currently, the following languages are supported:

1. English `en`
2. German `de`
3. French `fr`
4. Italian `it`
5. Spanish `es`
6. Portuguese `pt

**Additional Options**

After embedding the credit card frame you can take additional measures to control the form's behavior, both while it's loading and being used.

### Handling successful or failed frame load

Your callback function will be called both when the frame loaded successfully and if it failed to load. In the latter case it will receive an error parameter indicating containing the `error` message.

```
paymill.embedFrame(container, options, function(error) {
  if (error) {
    // Frame could not be loaded, check error object for reason.
    console.log(error.apierror, error.message);
    // Example: "container_not_found"
  } else {
    // Frame was loaded successfully and is ready to be used.
  }
});
```

If the callback is called without an error object, the credit card form is ready to be used. You might want to hide the container element until the frame has loaded and only show it then.

<div class="info">
  If the frame failed to load, no iframe element will be added to the DOM. You can safely call embedFrame again to retry.
</div>

The following errors can occur during frame load:

- `container_not_found` - the container element specified could not be found
- `frame_not_loaded` - frame didn't load for another reason

### Handling content resizing

The dimensions of the iframe's content can change due to several factors like stylesheets loading, error messages being shown or CSS transitions or animations.

By default, the iframe automatically resizes **vertically** to fit its content. This means the iframe element will have a width of 100% but a variable height, starting with `0px` until the frame has loaded.

You can disable this behavior by setting a flag in the `options parameter of `embedFrame`. If you do this, the iframe will have its height also set to `100%`. We recommend setting a fixed container height to accommodate the iframe content.

```javascript
// Disable auto-resize.
paymill.embedFrame(container, {
  resize: false
}, callback);
```

Alternatively, you can take over the resizing process by providing a custom resizing function. The iframe will still have width and height set to `100%` in the beginning, but your function will be called each time the iframe needs a resize. It will be passed an `attrs` parameter containing relevant attributes (currently only the content's height) so you can manipulate the container element accordingly.

```javascript
// Provide custom resizing function.
paymill.embedFrame(container, {
  resize: function(attrs) {
    container.style.height = attrs.height + 'px';
    // Make other adjustments based on iframe dimensions.
  }
}, callback);
```

<div class="info">
With both disabled and custom resizing, the iframe has width and height set to `100%` to fit its container element. It's highly recommended that you only style the container since you have full control over it. The iframe, on the other hand, won't be available until it has loaded and might be removed from the DOM if loading fails.
</div>

## Tokenization

Credit card transactions are still processed through tokens: Using the embedded frame you obtain a credit card token, send it to your server and proceed to create a transaction with it.

### Requesting a token

A token can be obtained using the method `createTokenViaFrame(options, callback). It works just like `createToken but you don't pass credit card data to it. Like `createToken`, it takes a callback that receives either the result of the operation or a potential error.

```
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
    console.log(result.token);
  }
});
```

Your response handler receives the same `error and `result` object as before and doesn't have to change.

In addition to the errors of `createToken`, the following errors can occur when using `createTokenViaFrame`:

- `frame_not_found - no credit card frame was found, make sure you have called `embedFrame` successfully

<div class="important">
  The regular `createToken` still exists and continues to be the appropriate method for creating **direct debit** tokens.
</div>

### Handling errors

Your response handler receives the same `error` and `result` object as before and doesn't have to change.

Additionally, inline error messages will be displayed automatically next to the respective fields.

```javascript
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
    console.log(result.token);
  }
});
```
In addition to the errors of createToken, the following errors can occur when using `createTokenViaFrame`:

- `frame_not_found` – no credit card frame was found, make sure you have called `embedFrame` successfully

### Using 3-D Secure

3-D Secure is also available with the credit card frame and handling remains the same: The default modal dialog will be diplayed automatically or you handle it yourself by providing the optional tdsInit and tdsCleanup callbacks.

```javascript
paymill.createTokenViaFrame(data, callback, tdsInit, tdsCleanup);
```
