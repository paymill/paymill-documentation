---
title: "PAYMILL JavaScript Bridge"
menuTitle: "PAYMILL Bridge"
type: "guide"
status: "published"
menuOrder: 2
---

The PAYMILL Bridge is a JavaScript tool allowing you to easily and securely pass your customers payment information to our system while still having full control on your checkout workflow and design.

## PAYMENT METHODS

The Javascript Bridge is available for all of the payment methods provided by PAYMILL.

### Credit Card

There are two ways to use the bridge for credit card transactions:

  - Creating your own form and using the bridge for passing the data to our server: Most flexible solution but a little bit more constraining on the legal side.
  - Using the PayFrame provided by the bridge which integrates a customizable form through an iFrame. Legal requirements are then minimal.

  {>> TODO: Link to the credit card getting-started and PCI info <<}


### Direct Debit

You can pass the customer data through the bridge using your own form.

### PayPal

Use the PAYMILL bridge to initiate PayPal transactions.

## INTEGRATING THE BRIDGE IN YOUR WEBSITE

Integrating the PAYMILL Bridge into your website is very straightforward. Just include the JavaScript library file directly from our server:

```html
    <script type="text/javascript" src="https://bridge.paymill.com/"></script>
```

<div class="important">
Due to frequent demands of our customers in terms of timeout problems with inserting our JavaScript solution: it may take longer as a manually configured timeout of e.g. 3000ms if a response from the server will be sent back to you.
<br>
Therefore please **specify no fixed timeouts** in the JavaScript code of your page, as it would otherwise lead to problems and will take the response from server to different lengths!
</div>

## USING THE BRIDGE

Once the bridge is integrated on your website, you can initiate a transaction with your customer data the following way:

```javascript
  paymill.createToken({
    // Transaction details + customer payment data
  },
  paymillResponseHandler);
```

You'll then get a response from the server indicating wether the token creation was a success or not.

You can handle the response in the handler passed to `createToken`:

```javascript
  function paymillResponseHandler(error, result) {
      if (error) {
        // Handle the error
        console.log(error)
      } else {
        // Do something with the received token
        console.log(result.token)
      }
  }
```

### Handling Success

In case of success, you'll receive a response object containing a `token` amongst other information:

```json
  {
    "token": "<PAYMILL_TOKEN>",
    "ip": "82.135.34.186",
    "ipCountry": "de",
    // .......
  }
```

The `token` is a temporary alias for the customer's payment information. It allows you to safely process the transaction on your server without handling sensitive data.

<div class="info">
The `token` is a string with a maximum length of 32 chars.
</div>

<div class="important">
The `token` will **expire within 5 minutes**. You need to process the transaction on your server before the token expires.
<br>
If you would like to make further transactions with the same payment information, you will need to use the corresponding **Payment Object** which expires only after **13 months**.
<br>
{>> TODO: Add information specific to the expiration of a payment object when a credit card expires in the corresponding guide (payment methods?) <<}
</div>

### Handling Failure

```json
  {
    "apierror": "error_code"
  }
```

The `apierror` field contains an code corresponding to the reason wich made the token creation fail.

You can find the explanation of the different error codes in the [API Reference][/API#response-codes].

## PAYMENT METHOD SPECIFIC INFORMATION

This guide showed you the basics about the PAYMILL Bridge. If you would like more information about integrating a specific payment method with it, please read the corrsponding guide:

{>>TODO: Add links to the different guides detailing the process<<}
