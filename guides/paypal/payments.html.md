---
title: "PayPal Payments"
menu: "PayPal Payments"
type: "guide"
status: "published"
menuOrder: 4
---

Requesting PayPal billing agreements through PAYMILL is easy:

1. Add a "Pay with PayPal" button to your checkout (use images from the [PayPal logo center](https://www.paypal.com/webapps/mpp/logo-center)).
- Safely prepare the request on your server by creating a PayPal payment checksum.
- Pass the checksum ID to your website front-end and use our bridge to start PayPal checkout.
- Handle the customer returning to your site along with information about the transaction result.

## Payment setup

Before you can start the PayPal checkout from your website, you need to create a payment checksum on your server using your private API key. This is to ensure the integrity of the payment data and to prevent your payment from being tampered with along the way.

You need to define a return and cancel URL for PayPal. Optionally you can also add a client ID if you want to assign the new payment to an existing client.

<div class="info">
Please refer to our [API reference](/API) for more information on payment details.
</div>

### Mandatory payment details

A PayPal payment needs the checksum type and action to be specified. You also need to provide a valid cancel URL and return URL for the customer to return to.

- **checksum_type:** Needs to be set to "paypal".
- **checksum_action:** Needs to be set to "payment" so that the checksum is later turned into a PayPal payment.
- **return_url:** Used when your customer completed PayPal checkout and a transaction was created. The transaction outcome can be *successful*, *failed*, or *pending*. You will receive the transaction ID and status information as URL parameters.
- **cancel_url:** Used when your customer cancelled during PayPal checkout and returns to your store. At this URL, offer a way to review or modify the order and ask the customer to restart the checkout.

This example checksum contains all mandatory information for a PayPal transaction:

```sh
curl https://api.paymill.com/v2.1/checksums \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "checksum_type=paypal" \
  -d "checksum_action=payment" \
  -d "return_url=https://www.example.com/store/checkout/result" \
  -d "cancel_url=https://www.example.com/store/checkout/retry"
```

### Optional payment details

In addition to the mandatory payment details listed above, you can specify several other components of a payment:

- **client_id:** Client (ID) where the created payment should belong to (optional).
- **reusable_payment_description:** The Description appears at the checkout page (max. 127 characters).

Please see our guide on [payments](/guides/reference/payments.html) for more details on payment setup.

## PayPal checkout

PayPal payments are initiated on your website. The customer is redirected to PayPal checkout and subsequently returned to your site where you can handle the result.

1. Include the PAYMILL JavaScript bridge.
- When button is clicked, use our JS bridge to start PayPal checkout.
- Provide callback to handle any errors during payment setup (e.g. invalid data)

```javascript
paymill.createPayment({
  checksum: 'chk_2f82a672574647cd911d'
}, function(error) {
  if (error) {
    // Payment setup failed, handle error and try again.
    console.log(error);
  }
});
```

## Cancelled payments

When a customer cancels during PayPal checkout, they will be redirected to your **cancel URL**. This is a separate URL so you can offer your customers to review or modify their order and restart the checkout.

Since no payment was created at this point, the customer is simply redirected to your cancel URL without any additional parameters.

Here's an example URL called for a cancelled payment:

```sh
https://www.example.com/shop/checkout/retry
```

## Payment results

After PayPal checkout, the customer is redirected to your **return URL**. At this point, a payment has been created. The payment result is provided using the following URL parameters:

- `paymill_payment_id`: PAYMILL payment ID, used to identify the payment in PAYMILL's system.
- `paymill_response_code`: Response code providing more details about the transaction status.
- `paymill_mode`: Indicates if the transaction was made in `live` or `test` mode.

Here's an example URL called for a successful transaction:

```sh
https://www.example.com/shop/checkout/result?paymill_payment_id=pay_2af32f858a47babeff78aeef&paymill_response_code=20000&paymill_mode=test
```

### Retrieving payment details

After a payment has created, you can retrieve additional payment details from our API, such as the country of the customer:

```sh
curl https://api.paymill.com/v2.1/payments/pay_2af32f858a47babeff78aeef \
  -u "<YOUR_PRIVATE_KEY>:"
```

<div class="info">If the payment attribute `is_recurring` is `true`, you can reuse it for creating transactions or subscriptions.<br>
See [Create new Transaction with payment](/API/#-transaction-object) and [Create new Subscription](/API/#-subscription-object) for furhter information.
</div>
