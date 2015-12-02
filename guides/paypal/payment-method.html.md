---
title: "PayPal Payment Method"
menuTitle: "Payment Method"
type: "guide"
status: "published"
menuOrder: 4
---

As the others payment methods in the PAYMILL API, a **PayPal customer account** is represented by a [Payment Object](https://developers.paymill.com/API/#-payment-object-for-paypal).

When carrying out a PayPal transaction, a payment object is automatically created for the PayPal account used for the payment.


## Related Clients

If a client exists for this payment method, you can attach the [Payment Object](https://developers.paymill.com/API/#-payment-object-for-paypal) to the corresponding [Client Object](https://developers.paymill.com/API/#-client-object) by specifying the [ClientObject](https://developers.paymill.com/API/#-client-object) ID:

- When creating a [Transaction](https://developers.paymill.com/API/#-transaction-object)
- When creating the [ClientObject](https://developers.paymill.com/API/#-client-object)


If you don't specify a [ClientObject](https://developers.paymill.com/API/#-client-object) ID, a new one will be created automatically.

See our guide on [clients and payments](https://developers.paymill.com/guides/reference/clients-payments.html) for more details on these relationships.

<p class="info">
You can attach the same **PayPal Account** to a **Client** multiple times. This is relevant when you create billing agreements (see below), because you can have multiple billing agreements with the same PayPal account.
</p>


## Reusing a PayPal Payment Object

PAYMILL allows you to reuse a **PaymentObject** to create new **Transactions** and **Subscriptions** without requiring the customer payment details again.

With **PayPal** you need to obtain a so-called *billing agreement* from the customer to allow the [Payment Object](https://developers.paymill.com/API/#-payment-object-for-paypal) to be used for charging the customer **PayPal** account again.

This agreement is indicated by the `is_recurring` set to `true` in the API response.

Requesting **PayPal** billing agreements through **PAYMILL** is easy and can be done either while carrying out a transaction (see [transaction setup](https://developers.paymill.com/guides/paypal/transactions#transaction-setup)) or by setting up a special kind of checkout that *only creates a payment object*.


### To create a reusable payment **during** a transaction:

1. Prepare the checkout by [creating a checksum](/guides/paypal/transactions#creating-a-checksum) for a **PayPal** transaction on your server.

2. Set a flag to request a billing agreement during the checkout. Optionally add a description for why you need it.

3. Pass the **checkout ID** to your front-end and start the checkout using our [JavaScript bridge](https://developers.paymill.com/guides/reference/bridge).

4. When the customer returns, a `paymill_payment_id` will be attached identifying the reusable **Payment Object**.


When [creating the checksum](/guides/paypal/transactions#creating-a-checksum) for a **PayPal transaction**, simply set `require_reusable_payment=true` to request a billing agreement from your customer during checkout.
Your customer will be able to authorize this payment and agree to future payments with a single click.

Optionally, specify `reusable_payment_description` to let the customer know why exactly you need them to agree to future payments.
This description will be displayed during checkout and will be added to every subsequent transaction based on this billing agreement.

Example checksum creation:

```bash
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

<p class="info">
Please see our [PayPal transaction guide](/guides/paypal/transactions) for more information on transaction setup.
</p>


### To create a reusable payment **without** a transaction:

1. Prepare the checkout by **creating a checksum** for a **PayPal payment** on your server.

2. Optionally add a description for why you need the billing agreement.

3. Pass the **checkout ID** to your front-end and start the checkout using our [JavaScript bridge](https://developers.paymill.com/guides/reference/bridge).

4. When the customer returns, a `paymill_payment_id` will be attached identifying the reusable **Payment Object**.


To obtain a **PayPal billing agreement** without carrying out a transaction, you can set up a different type of checksum on your server.

Simply specify `checksum_type=paypal` and `checksum_action=payment` to indicate that you are processing a **PayPal checkout** but a **Payment** should be created instead of a **Transaction** (the default behavior).


**Mandatory Parameters**

When creating a checksum for a **PayPal payment** there are some mandatory parameters you need to pass:

- `checksum_type`: needs to be set to `paypal`
- `checksum_action`: needs to be set to `payment` so that the checksum is later turned into a PayPal payment.
- `return_url`: the URL where the customer is redirected when he completed a **PayPal checkout** and a transaction was created.
- `cancel_url`: the URL where the customer is redirected when he cancels the **PayPal checkout**. At this URL you can offer your customer to review or modify the order and restart the checkout.

Example checksum creation with mandatory parameters:

```bash
curl https://api.paymill.com/v2.1/checksums \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "checksum_type=paypal" \
  -d "checksum_action=payment" \
  -d "return_url=https://www.example.com/store/checkout/result" \
  -d "cancel_url=https://www.example.com/store/checkout/retry"
```

**Optional Parameters**

In addition to the mandatory parameters listed above, you can also specify the following ones:

- `client_id`: the **ID** of the associated **Client**. If specified an existing **Client Object** will be attached to the created **Payment Object**. Otherwise a new one will be created.
- `reusable_payment_description`: a description that will appear in the checkout page. Useful to provide more information to the customer. (max 127 chars)

**Example checksum creation with optional parameters:**

```bash
curl https://api.paymill.com/v2.1/checksums \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "checksum_type=paypal" \
  -d "checksum_action=payment" \
  -d "return_url=https://www.example.com/store/checkout/result" \
  -d "cancel_url=https://www.example.com/store/checkout/retry" \
  -d "client_id=client_b66a45c43fa384f2d45382e355f99"
  -d "reusable_payment_description=Automatically pay invoices using this account."
```

#### STARTING A PAYPAL PAYMENT CHECKOUT

Checkouts to create **PayPal Payments** are initiated on your website, just like checkouts for other transactions. The customer is redirected to **PayPal Checkout** to confirm the payment with his **PayPal Account** then returned to your site where you can handle the result.

To add the **PayPal Checkout** to your website:

1. Include the [PAYMILL JavaScrip Bridge](https://developers.paymill.com/guides/reference/bridge)
2. Use our JS bridge to start **PayPal Checkout** when the button is clicked
3. Provide a callback to handle any errors happening during payment setup (e.g. invalid data)

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

#### HANDLING CANCELED PAYMENTS

When a customer cancels during **PayPal Checkout**, he will be redirected to the `cancel_url` you provided during **Checksum creation**. On this URL you can offer your customer to review or modify his order and restart the checkout.

Since no payment was created at this point, the customer is simply redirected to your `cancel_url` without any additional parameters.

Example URL called for a cancelled payment:

```http
https://www.example.com/shop/checkout/retry
```

#### HANDLING PAYMENT RESULTS

Upon a successful **PayPal Checkout**, the customer is redirected to the `return_url` you provided during **Checksum creation**. At this point, a **Payment** has been created. The payment result is provided using the following URL parameters:

- `paymill_payment_id`: **PAYMILL Payment Object ID**, used to identify the **Payment** in the **PAYMILL's system**.
- `paymill_response_code`: Response code providing more details about the status.
- `paymill_mode`: Indicates if the transaction was made in `live` or `test` mode.

Example URL called for a successful transaction:

```http
https://www.example.com/shop/checkout/result?paymill_payment_id=pay_2af32f858a47babeff78aeef&paymill_response_code=20000&paymill_mode=test
```

##### Retrieving payment details

After a **Payment** has been created, you can retrieve additional **Payment** details from our **API**, such as the country of the customer:

```bash
curl https://api.paymill.com/v2.1/payments/pay_2af32f858a47babeff78aeef \
  -u "<YOUR_PRIVATE_KEY>:"
```

<p class="info">
You can find more information about retrieving a **Payment Object** in our [API Reference](https://developers.paymill.com/API/#-payment-details)
</p>

<p class="info">
If the payment attribute `is_recurring` is `true`, you can reuse it to create a subsequent **Transactions** or **Subscriptions**, either via our **API** or **Merchant Centre**. See our [Transactions guide](/guides/reference/transactions) and [Subscriptions guide](/gudes/reference/subscriptions) for more information.
</p>
