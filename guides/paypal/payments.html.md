---
title: "PayPal Payments"
menu: "PayPal Payments"
type: "guide"
status: "published"
menuOrder: 4
---

A PayPal payment object represents the customer's PayPal account. When carrying out a PayPal transaction, a payment object is automatically created for the PayPal account used to pay. You can attach the payment to an existing client by specifying the client ID when creating a transaction or payment, otherwise a new client will be created automatically. See our guide on [clients and payments](/guides/reference/clients-payments.html) for more details on these relationships.

<div class="info">
One client can have the same PayPal account attached to it multiple times. This is relevant when you create so-called *billing agreements* (see below), because you can have multiple different billing agreements with the same PayPal account.
</div>

<div class="important">
Recurring payments use a special PayPal feature called “reference transactions”. Please contact PayPal and request that feature to be enabled for you.
</div>

## Reusing a PayPal payment object

You can normally use an existing payment object to create transactions and subscriptions. With PayPal, there is usually customer interaction involved.

In order for a PayPal payment object to be reusable you have to obtain a so-called *billing agreement* from your customer. This allows you to charge future payments to their PayPal account and is indicated by `is_recurring=true` in the API response.

Requesting PayPal billing agreements through PAYMILL is easy and can be done either while carrying out a transaction (see [transaction setup](/guides/paypal/transactions#transaction-setup)) or by setting up a special kind of checkout that *only creates a payment object*.

To create a reusable payment **during** a transaction:

1. Prepare the checkout by creating a checksum for a PayPal *transaction* on your server.
- Set a flag to request a billing agreement during checkout, optionally add a description for why you need it.
- Pass the checkout ID to your front-end and start the checkout using our JavaScript bridge.
- When the customer returns, a `paymill_payment_id` will be attached identifying the reusable payment object.

To create a reusable payment **without** a transaction:

1. Prepare the checkout by creating a checksum for a PayPal *payment* on your server.
- Optionally add a description for why you need the billing agreement.
- Pass the checkout ID to your front-end and start the checkout using our JavaScript bridge.
- When the customer returns, a `paymill_payment_id` will be attached identifying the reusable payment object.

## Requesting a billing agreement during a transaction

When creating a checksum for a PayPal *transaction*, simply set `require_reusable_payment=true` to request a billing agreement from your customer during checkout. Your customer will be able to authorize this payment and agree to future payments with a single click.

Optionally, specify `reusable_payment_description` to let the customer know why exactly you need them to agree to future payments. This description will be displayed during checkout and will be added to every subsequent transaction based on this billing agreement.

```sh
curl https://api.paymill.com/v2.1/checksums \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "checksum_type=paypal" \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "description=Test Transaction" \
  -d "return_url=https://www.example.com/store/checkout/result" \
  -d "cancel_url=https://www.example.com/store/checkout/retry" \
  -d "require_reusable_payment=true" \
  -d "reusable_payment_description=Automatically pay invoices using this account."
```

<div class="info">
Please see our [PayPal transaction guide](/guides/paypal/transactions.html) for more information on transaction setup. To learn more about creating a payment *without* a transaction, simply read on.
</div>

## Setting up a PayPal payment checkout

To obtain a PayPal billing agreement without carrying out a transaction yet, you can set up a different type of checksum on your server. Simply specify `checksum_type=paypal` and `checksum_action=payment` to indicate that it's a PayPal checkout but a payment should be created instead of a transaction (which is the default action).

Apart from the checksum type and action, you only need to define a return and cancel URL for PayPal. Optionally you can also add a description for why you need the billing agreement and specify a client ID if you want to assign the new payment to an existing client.

<div class="info">
Please refer to our [API reference](/API) for more information on payment details.
</div>

### Mandatory payment details

A PayPal payment needs the checksum type and action to be specified. You also need to provide a valid cancel URL and return URL for the customer to return to.

- **Checksum type:** Needs to be set to `paypal`.
- **Checksum action:** Needs to be set to `payment` so that the checksum is later turned into a PayPal payment. (`transaction` is the default value.)
- **Return URL:** Used when your customer completed PayPal checkout and a transaction was created. The transaction outcome can be *successful*, *failed*, or *pending*. You will receive the transaction ID and status information as URL parameters.
- **Cancel URL:** Used when your customer cancelled during PayPal checkout and returns to your store. At this URL, offer a way to review or modify the order and ask the customer to restart the checkout.

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

- **Client ID:** Client (ID) where the created payment should belong to (optional).
- **Reusable payment description:** The Description appears at the checkout page (max. 127 characters).

```sh
curl https://api.paymill.com/v2.1/checksums \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "checksum_type=paypal" \
  -d "checksum_action=payment" \
  -d "return_url=https://www.example.com/store/checkout/result" \
  -d "cancel_url=https://www.example.com/store/checkout/retry" \
  -d "client_id=client_b66a45c43fa384f2d45382e355f99"
  -d "reusable_payment_description=Automatically pay invoices using this account."
```

<div class="info">
Please see our guide on [clients and payments](/guides/reference/clients-payments.html) for more details on payment setup.
</div>

## Starting a PayPal payment checkout

Checkouts to create PayPal payments are initiated on your website, just like checkouts for transactions. The customer is redirected to PayPal checkout and subsequently returned to your site where you can handle the result.

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

## Handling cancelled payments

When a customer cancels during PayPal checkout, they will be redirected to your **cancel URL**. This is a separate URL so you can offer your customers to review or modify their order and restart the checkout.

Since no payment was created at this point, the customer is simply redirected to your cancel URL without any additional parameters.

Here's an example URL called for a cancelled payment:

```sh
https://www.example.com/shop/checkout/retry
```

## Handling payment results

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

<div class="info">
If the payment attribute `is_recurring` is `true`, you can reuse it for to create a subsequent **transaction** or **subscription**, either via our API or Merchant Centre. See our [transaction guide](/guides/reference/transactions.html) and [subscription guide](/guides/reference/subscriptions.html) for more information
</div>
