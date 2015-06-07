---
title: "Quick Start"
menu: "Quick Start"
type: "guide"
status: "published"
order: 1
---

*How to process PayPal payments with PAYMILL*

Accepting PayPal payments through PAYMILL is simple. It's based on the same convenient integration you also use to accept credit card and direct debit payments. You just need to follow these simple steps:

1. Connect your PayPal business account to your PAYMILL account in our Merchant Centre.
- Create a transaction checksum on your server using one of our API libraries.
- Start PayPal checkout on your website using our JavaScript bridge.
- Handle the transaction result as your customer returns from PayPal checkout.

## 1. Connect your PayPal account

To accept payments with PayPal you need a PayPal business account. Make sure you provide all necessary information for your PayPal account to be activated. Next, visit the [payment methods](https://app.paymill.com/settings/payment-methods) section in our Merchant Centre and connect your PAYMILL account to your PayPal account.

Please note that you can start [testing PayPal transactions](…) immediately while your PAYMILL and PayPal accounts are being activated. Simply create a PayPal sandbox account and connect it in our Merchant Centre.

> For more information about the PAYMILL on-boarding process and requirements regarding your PayPal account, please refer to our [on-boarding guide](…).

## 2. Create a transaction checksum

Before starting a PayPal checkout session you need to create a transaction checksum in our API. This ensures that your payment can’t be tampered with along the way.

This checksum is created on your server using your private API key. You can then pass it to your frontend to create the actual transaction using our JavaScript bridge, sending your customer to PayPal for checkout.

You can either call the checksum API directly or use one of our [API libraries](https://developers.paymill.com/en/reference/api-libraries/) on your server. Once you have collected transaction data on your server, creating a checksum is as easy as passing that data to our API in one call:

```sh
curl https://api.paymill.com/v2.1/checksums \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "checksum_type=paypal" \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "description=Test Transaction" \
  -d "return_url=https://www.example.com/store/checkout/result" \
  -d "cancel_url=https://www.example.com/store/checkout/retry"
```

Use the returned checksum ID in your HTML templates or return it to your frontend dynamically via AJAX.

> See [transaction setup](…) for more details on how to add transaction data, address data and shopping cart items to a checksum.

## 3. Start PayPal checkout

After creating a checksum, you can start a PayPal checkout session on your website using our JavaScript bridge. Integrating our bridge is as easy as loading it in a script tag and specifying your API key:

```html
<script src="https://bridge.paymill.de"></script>
<script>PAYMILL_PUBLIC_KEY = "443368146777979106b2ce2042c289a5"</script>
```

Now you can use our bridge to create a transaction, which will start a checkout session and send your customer to PayPal to confirm payment:

```javascript
paymill.createTransaction({type: "paypal", checksum: "chk_2f82a672574647cd911d"});
```

> Please refer to our guide on [transaction setup](…) for more information on error handling during transaction setup.

## 4. Handle transaction result

Your customer will be redirected back to your site after PayPal checkout along with information about the transaction result. Basically, there are two different outcomes of a checkout session and you can provide separate URLs for each:

The **cancel URL** will be used when checkout was cancelled by the customer. You probably want to provide helpful information and ask them to try again.

The **return URL** will be used when a definitive result for the transaction is available. A PayPal transaction can be *successful*, *failed*, or *pending* and you should handle these cases appropriately.

You will be passed transaction status, a detailed response code as well as both PAYMILL and PayPal transaction ID as URL parameters:

```sh
…/checkout/result?paypal_trx_id=00N9651952085952K&paymill_trx_id=tran_5188e355f984445d4b66a45c43fa&paymill_trx_status=closed&paymill_response_code=20000
```

> For more information, please refer to our guide about [handling transaction results](…).
