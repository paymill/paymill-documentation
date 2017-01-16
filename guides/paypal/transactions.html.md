---
title: "PayPal Transactions"
menuTitle: "PayPal Transactions"
type: "guide"
status: "published"
menuOrder: 3
---

Processing **PayPal Transactions** through **PAYMILL** is easy:

1. Add a *"Pay with PayPal"* button to your checkout (you need to use images from the [PayPal logo center](https://www.paypal.com/webapps/mpp/logo-center)).
2. Create a [Transaction Checksum](#creating-a-checksum) on your server.
3. Pass the **Checksum ID** to your website front-end and use the [PAYMILL Bridge](https://developers.paymill.com/guides/reference/bridge) to start **PayPal Checkout**.
4. Handle the customer returning to your site along with information about the transaction result.

## Setting Up A PayPal Checkout

### Creating a Checksum

Before starting a **PayPal Checkout** from your website, you need to create a [Transaction Checksum](https://developers.paymill.com/API/#checksums) on your server.

The **Checksum** is a value you generate on your server via the **PAYMILL API** using your **private API Key**. It ensures the integrity of the **Transaction** data, preventing them from being tampered with along the way.

Some **Transaction** data can be added to the **Checksum**, including shipping/handling costs, shopping cart items, shipping/billing addresses and custom return/cancel URLs for **PayPal Checkouts**.

**Mandatory Parameters**

- `checksum_type`: Needs to be set to `paypal` so that the **Checksum** is turned into a **PayPal Transaction**.
- `amount`: Transaction amount as an integer, e.g. Euro cents. It must be the overall sum of all transaction components.
- `currency`: Currency code for this transaction. Will be used for all the amounts within the transaction. You can find the list of valid currency codes [here](https://wikipedia.org/wiki/ISO_4217).
- `return_url`: The URL where the customer is redirected when he completed a **PayPal checkout** and a transaction was created. The **Transaction status** can be `successful`, `failed` or `pending`. The **Transaction ID** and **status** are passed as URL parameters.
- `cancel_url`: The URL where the customer is redirected when he cancels the **PayPal checkout**. At this URL you can offer your customer to review or modify the order and restart the checkout.

Example checksum with mandatory parameters for a PayPal transaction:

```bash
curl https://api.paymill.com/v2.1/checksums \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "checksum_type=paypal" \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "description=Test Transaction" \
  -d "return_url=https://www.example.com/store/checkout/result" \
  -d "cancel_url=https://www.example.com/store/checkout/retry"
```

**Optional Parameters**

In addition to the mandatory parameters listed above, you can also specify the following ones:

- `description`: Use this field to provide additional information about the transaction, like the *shopping cart ID* or anything else. Note that the description is limited to 128 characters.
- `shippings_address`: The shipping address of the customer for this transaction. It will be sent to **PayPal** where it will be shown to the customer during checkout. **PayPal** also needs this for you to be eligible for *seller protection*.
- `billing_address`: The billing address of the customer for this transaction. It will not be used by PayPal.
- `items`: The list of purchased items related to this transaction. Each item must have a *name*, *amount* and *quantity*. Additionally you can specify a *description*, the *item reference (e.g. EAN/SKU)* and the *URL of the item in your shop*.
- `shipping_amount`: Shipping cost (in cents). Included in the transaction amount. Only necessary if you provide a shopping cart and the item total doesn't match the transaction amount.
- `handling_amount`: Handling cost (in cents) included in the transaction amount. Only necessary if you provide a shopping cart and the item total doesn't match the transaction amount.
- `client`: **PAYMILL client ID** (e.g. "client_88a388d9dd48f86c3136"). A new **Transaction** will create a new **Payment**. If you specify a **Client**, the new **Payment** will be attached to it.

You can find more information about **Transactions** in the [corresponding guide](/guides/reference/transactions.html).


<p class="important">
If you specify a shopping cart, **the items total must match the transaction total amount**.
<br>
In case there is a difference, please use shipping and handling costs to match this **total amount**.
<br><br>
These parameters are not required if you didn't specify a shopping cart.
</p>


#### STARTING A PAYPAL PAYMENT CHECKOUT

**PayPal Transactions** are initiated on your website. The customer is redirected to **PayPal Checkout** to confirm the payment with his **PayPal Account** then returned to your site where you can handle the result.

To add the **PayPal Checkout** to your website:

1. Include the [PAYMILL JavaScrip Bridge](https://developers.paymill.com/guides/reference/bridge)
2. Use our JS bridge to start **PayPal Checkout** when the button is clicked
3. Provide a callback to handle any errors happening during payment setup (e.g. invalid data)

```javascript
paymill.createTransaction({
  checksum: 'chk_2f82a672574647cd911d'
}, function(error) {
  if (error) {
    // Payment setup failed, handle error and try again.
    console.log(error);
  }
});
```

#### HANDLING CANCELED PAYMENTS

When a customer cancels during **PayPal Checkout**, he will be redirected to the `cancel_url` you provided during **Checksum creation**. On this URL you can offer your customer to review or modify his order and restart the checkout.

Since no transaction was created at this point, the customer is simply redirected to your `cancel_url` without any additional parameters.

Example URL called for a cancelled transaction:

```http
https://www.example.com/shop/checkout/retry
```

#### HANDLING TRANSACTION RESULTS

Upon a successful **PayPal Checkout**, the customer is redirected to the `return_url` you provided during **Checksum creation**. At this point, a **Transaction** has been created. The transaction result is provided using the following URL parameters:

- `paymill_trx_id`: **PAYMILL Transaction ID**, used to identify the transaction in **PAYMILL's system**
- `paypal_trx_id`: **PayPal Transaction ID**, used to identify the transaction in **PayPal's system**
- `paymill_trx_status`: **Transaction** result, either `closed`, `failed` or `pending`.
- `paymill_response_code`: Response code providing more details about the transaction status. See the [API Reference](https://developers.paymill.com/API/#response-codes) for more details on response codes.
- `paymill_mode`: Indicates if the transaction was made in `live` or test `mode`.

Example URL called for a successful transaction:

```http
https://www.example.com/shop/checkout/result?paypal_trx_id=00N9651952085952K&paymill_trx_id=tran_5188e355f984445d4b66a45c43fa&paymill_trx_status=closed&paymill_response_code=20000&paymill_mode=test
```

<p class="important">
While you receive transaction data via URL parameters, **you need to verify transaction integrity yourself**. Simply use the **Transaction ID** to query our API and check if the transaction exists and has the specified status. See [retrieving transaction details](#retrieving-transaction-details) for more information.
</p>


## Retrieving Transaction Details

After a transaction has completed, you can retrieve additional transaction details such as the shipping address that was used, from our API:

```bash
curl https://api.paymill.com/v2.1/transactions/tran_5188e355f984445d4b66a45c43fa \
  -u "<YOUR_PRIVATE_KEY>:"
```

You can also find a transaction via its **PayPal Transaction ID** by using the `short_id` filter:

```bash
curl https://api.paymill.com/v2.1/transactions?short_id=00N9651952085952K \
  -u "<YOUR_PRIVATE_KEY>:"
```

Further more you can find a transaction by using the description filter. You should always store a unique identifier (e.g. "shopping_cart_1337") to your transaction description to be able to recover transactions also by your own identifiers.

```bash
curl https://api.paymill.com/v2.1/transactions?description=shopping_cart_1337 \
  -u "<YOUR_PRIVATE_KEY>:"
```

But the most effective way is to activate [transaction webhooks](https://developers.paymill.com/API/#webhooks). They will inform you right away about new transactions or status changes.

## Handling Pending Transactions

Payments can be delayed for a variety of reasons such as regulatory review by **PayPal**, restrictions with the buyer's account or your account settings. These transactions are called "pending" and therefore have the status `pending` and a [response code](https://developers.paymill.com/API/#response-codes) (`3xxxx`) indicating the reason.

Pending transactions will eventually become `successful` or `failed`. To handle the result of a pending transaction, [register a webhook or email notification](https://developers.paymill.com/API/#webhooks) for the corresponding events, e.g. `transaction.successful` and `transaction.failed`.

Find more information about **Webhooks** in the [API Reference](https://developers.paymill.com/API/#webhooks).

<p class="info">
In some cases you have to manually accept a payment. You can do so by logging into your PayPal account. Please check the [transaction response code](https://developers.paymill.com/API/#response-codes) to recognize these cases.
</p>
