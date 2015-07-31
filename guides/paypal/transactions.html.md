---
title: "PayPal Transactions"
menu: "PayPal Transactions"
type: "guide"
status: "published"
menuOrder: 3
---

Accepting PayPal payments through PAYMILL is easy:

1. Add a "Pay with PayPal" button to your checkout (use images from the [PayPal logo center](https://www.paypal.com/webapps/mpp/logo-center)).
- Safely prepare the transaction on your server by creating a transaction checksum.
- Pass the checksum ID to your website front-end and use our bridge to start PayPal checkout.
- Handle the customer returning to your site along with information about the transaction result.

## Transaction setup

Before you can start PayPal checkout from your website, you need to create a transaction checksum on your server using your private API key. This is to ensure the integrity of transaction data and to prevent your payment from being tampered with along the way.

You can add any type of transaction data to the checksum, this includes shipping/handling costs, shopping cart items, shipping/billing address as well as return/cancel URLs for PayPal.

<div class="info">
Please refer to our [API reference](/API) for more information on transaction details.
</div>

### Mandatory transaction details

A PayPal transaction needs the checksum type to be specified as well as a valid transaction amount and currency. You also need to provide a valid cancel URL and return URL for the customer to return to.

- **checksum_type:** Needs to be set to "PayPal" so that the checksum is later turned into a PayPal transaction.
- **amount:** Transaction amount as an integer, e.g. Euro cents. Must be the overall sum of all transaction components (see optional transaction details).
- **currency:** Valid currency code for this transaction. Will be used for all amounts within the transaction (see optional transaction details).
- **return_url:** Used when your customer completed PayPal checkout and a transaction was created. The transaction outcome can be *successful*, *failed*, or *pending*. You will receive the transaction ID and status information as URL parameters.
- **cancel_url:** Used when your customer cancelled during PayPal checkout and returns to your store. At this URL, offer a way to review or modify the order and ask the customer to restart the checkout.

This example checksum contains all mandatory information for a PayPal transaction:

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

### Optional transaction details

In addition to the mandatory transaction details listed above, you can specify several other components of a transaction:

- **shipping_address:** Shipping address for this transaction. Sent to PayPal where it's shown to the customer during checkout. PayPal also needs this for you to be eligible for seller protection.
- **billing_address:** Billing address for this transaction. Not used by PayPal.
- **items:** List of items purchased in this transaction. Each item must have a name, amount and quantity. Additionally you can specify a description, item number (e.g. EAN/SKU) and the URL in your shop.
- **shipping_costs:** Shipping costs included in the transaction amount. Only necessary if you provide a shopping cart and the item total doesn't match the transaction amount.
- **handling_costs:** Handling costs included in the transaction amount. Only necessary if you provide a shopping cart and the item total doesn't match the transaction amount.
- **client_id:** A new transaction will create a new payment. If you specify a client, the new payment will be attachted to it.
- **request_reusable_payment:** Set this to `1` if you want to ask the buyer at the same time for a billing agreement. This means you can reuse the resulting payment to do further transactions without the need of asking the buyer again for permisson.
- **reusable_payment_description:** The description appears at the checkout page when you request permission for a resuable payment (max. 127 characters).

Please see our guide on [transactions](/guides/reference/transactions.html) for more details on transaction setup.

<p class="important">If you specify a shopping cart, the <strong>item total must match the total transaction amount</strong>. If it doesn't, please use shipping and handling costs to specify the difference. If you don't specify a shopping cart, you also don't have to specify shipping or handling costs.</p>

<div class="info">If the request with `request_reusable_payment=1` was successful, the payment attribute `is_recurring` will be `true`, which means you can reuse it for further transactions or for subscriptions.<br>
See [Create new Transaction with payment](/API/#-transaction-object) and [Create new Subscription](/API/#-subscription-object) for furhter information.
</div>

## PayPal checkout

PayPal transactions are initiated on your website. The customer is redirected to PayPal checkout and subsequently returned to your site where you can handle the result.

1. Include the PAYMILL JavaScript bridge.
- When button is clicked, use our JS bridge to start PayPal checkout.
- Provide callback to handle any errors during transaction setup (e.g. invalid data).

```javascript
paymill.createTransaction({
  type: 'paypal',
  checksum: 'chk_2f82a672574647cd911d'
}, function(error) {
  if (error) {
    // Transaction setup failed, handle error and try again.
    console.log(error);
  }
});
```

## Cancelled transactions

When a customer cancels during PayPal checkout, they will be redirected to your **cancel URL**. This is a separate URL so you can offer your customers to review or modify their order and restart the checkout.

Since no transaction was created at this point, the customer is simply redirected to your cancel URL without any additional parameters.

Here's an example URL called for a cancelled transaction:

```sh
https://www.example.com/shop/checkout/retry
```

## Transaction results

After PayPal checkout, the customer is redirected to your **return URL**. At this point, a transaction has been created and is either successful, failed or pending. The transaction result is provided using the following URL parameters:

- `paymill_trx_id`: PAYMILL transaction ID, used to identify the transaction in PAYMILL's system
- `paypal_trx_id`: PayPal transaction ID, used to identify the transaction in PayPal's system
- `paymill_trx_status`: Transaction result, either `closed`, `failed` or `pending`.
- `paymill_response_code`: Response code providing more details about the transaction status
- `paymill_mode`: Indicates if the transaction was made in `live` or `test` mode.

Here's an example **return URL** call for a successful transaction:

```sh
https://www.example.com/shop/checkout/result?paypal_trx_id=00N9651952085952K&paymill_trx_id=tran_5188e355f984445d4b66a45c43fa&paymill_trx_status=closed&paymill_response_code=20000&paymill_mode=test
```

<div class="important">
While you receive transaction data via URL parameters, you need to verify transaction **integrity** yourself. Simply use the transaction ID to query our API and check if the transaction exists and has the specified status. See [retrieving transaction details](/guides/paypal/transactions.html#retrieving-transaction-details) for more information.
</div>

### Retrieving transaction details

After a transaction has completed, you can retrieve additional transaction details such as the shipping address that was used, from our API:

```sh
curl https://api.paymill.com/v2.1/transactions/tran_5188e355f984445d4b66a45c43fa \
  -u "<YOUR_PRIVATE_KEY>:"
```

You can also find a transaction via its PayPal transaction ID by using the `short_id` filter:

```sh
curl https://api.paymill.com/v2.1/transactions?short_id=00N9651952085952K \
  -u "<YOUR_PRIVATE_KEY>:"
```

Further more you can find a transaction by using the _description_ filter. You should always store a unique identifier (e.g. "shopping_cart_1337") to your transaction description to be able to recover transactions also by your own identifiers.

```sh
curl https://api.paymill.com/v2.1/transactions?description=shopping_cart_1337 \
  -u "<YOUR_PRIVATE_KEY>:"
```

But the most effective way is to activate [transaction webhooks](https://developers.paymill.com/API/#webhooks). They will inform you right away about new transactions or status changes.

### Handling pending transactions

Payments can be delayed for a variety of reasons such as regulatory review by PayPal, restrictions with the buyer's account or your account settings. These transactions are called "pending" and therefore have status `pending` and a [response code](/API/#response-codes) (`3xxxx`) indicating the reason.

Pending transactions will eventually become successful or failed. To handle the result of a pending transaction, register a [webhook or email notification](/API/#webhooks) for the corresponding events, e.g. `transaction.successful` and `transaction.failed`.

<div class="info">
In some cases you have to manually accept a payment. You can do so by logging into your PayPal account. Please check the transaction response code to recognize these cases.
</div>
