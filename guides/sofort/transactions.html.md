---
title: "Sofort Transactions"
menuTitle: "Sofort Transactions"
type: "guide"
status: "published"
menuOrder: 2
---

Processing **Sofort Transactions** through **PAYMILL** is easy:

1. Add a *Sofort* button to your checkout
2. Create a [Sofort Checksum](#creating-a-sofort-checksum) on your server.
3. Pass the **Checksum ID** to your website front-end and use the [PAYMILL Bridge](https://developers.paymill.com/guides/reference/bridge) to start **Sofort Checkout**.
4. Handle the customer returning to your site along with information about the transaction result.

### Creating a Sofort checksum

Before starting a **Sofort Checkout** from your website, you need to create a [Transaction Checksum](https://developers.paymill.com/API/#checksums) on your server.

The **Checksum** is a value you generate on your server via the **PAYMILL API** using your **private API Key**. It ensures the integrity of the **Transaction** data, preventing them from being tampered with along the way.

Some **Transaction** data can be added to the Sofort **Checksum**. More details in the next section.

**Mandatory Parameters**

- `checksum_type`: Needs to be set to `sofort` so that the **Checksum** will create a **Sofort Transaction**.
- `amount`: Transaction amount as an integer, e.g. Euro cents. It must be the overall sum of all transaction components.
- `currency`: Currency code for this transaction. For Sofort only `EUR` is allowed.
- `billing_address` is an address object. More info can be found [here](https://developers.paymill.com/API/index#address-object) You must pass the following values when creating the checksum:

- `billing_address[name]` : First and Last name of the customer.
- `billing_address[country]` : Country of the customer in 2-letter country code according to [ISO 3166-1 alpha-2](https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
- `billing_address[street_address]`: The street address of the customer
- `billing_address[city]` : The city of the customer
- `billing_address[postal_code]` : The postal code of the customer
- `client_email` : Email address of the customer
- `return_url`: The URL where the customer is redirected when he completed a **Sofort checkout**. The **Transaction status** can be `successful`, `failed` or `pending`. The **Transaction ID** and **status** are passed as URL parameters.
- `cancel_url`: The URL where the customer is redirected when he cancels the **Sofort checkout**. More information on the handling a cancelled transaction can be found [here](/guides/sofort/transactions#handling-cancelled-payments).


**Optional Parameters**

- `description` : Description of the transaction, which will be displayed in the Merchant Centre
- `client`: **PAYMILL client ID** (e.g. "client_88a388d9dd48f86c3136"). A new **Transaction** will create a new **Payment**. If you specify a **Client**, the new **Payment** will be attached to it.
- `billing_address[phone]` : The telephone number of the customer

These values will be displayed in the transaction details in your Merchant Centre.

Example checksum parameters for a Sofort transaction:

```bash
curl https://api.paymill.dev/v2.1/checksums \
  -u "<YOUR_PRIVATE_KEY>"\
  -d "checksum_type=sofort"\
  -d "amount=100"\
  -d "currency=EUR"\
  -d "billing_address[name]=Paymill Test"\
  -d "billing_address[street_address]=Test street 123"\
  -d "billing_address[postal_code]=12345"\
  -d "billing_address[country]=DE"\
  -d "billing_address[city]=Munich"\
  -d "billing_address[phone]=123123123"
  -d "customer_email=test@customer.de"\
  -d "description=Test Transaction"\
  -d "client=client_88a388d9dd48f86c3136a4s"
  -d "return_url=http://requestb.in/1cg1r3a1"\
  -d "cancel_url=http://requestb.in/1cg1r3a1"
```

You can find more information about **Transactions** in the [corresponding guide](/guides/reference/transactions.html).

#### Starting a SOFORT payment checkout

**Sofort Transactions** are initiated on your website. The customer is redirected to the **Sofort Website** to finish the transaction with their **Online Banking Account** and is returned to your site afterwards where you can handle the result.

To add the **Sofort Checkout** to your website:

1. Include the [PAYMILL JavaScrip Bridge](https://developers.paymill.com/guides/reference/bridge)
2. Use our JS bridge to start a **Sofort Checkout** when the customer chooses **Sofort**
3. Provide a callback to handle any errors happening during payment setup (e.g. invalid data)

Inside the Javascript this function muss be called with the checksum ID you received earlier.

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

#### Handling cancelled payments

When a customer cancels during **Sofort Checkout**, he will be redirected to the `cancel_url` you provided during **Checksum creation**. On this URL you can offer your customer to review or modify his order and restart the checkout. You can handle this scenario how you see fit. Please note that our system will react differently in live and test mode.

In `test mode` your customer is redirected to your cancel_url without any additional parameters.

Example URL called for a cancelled transaction in `test mode`:

```http
https://requestb.in/xabkgtxa
```

In `live mode` however a transaction will be created and the cancel_url will have parameters added to it.
You can see an example of the cancel_url that is being called in `live mode` here:

```http
https://requestb.in/xabkgtxa?paymill_trx_id=tran_f9ac7ffa300d2e98944dfc389d19&paymill_trx_status=failed&paymill_response_code=50700&paymill_mode=live
```

This will help you have an overview why the transaction was not successful and how many customers cancelled the transaction.

#### Handling transaction results

Upon a successful **Sofort Checkout**, the customer is redirected to the `return_url` you provided during **Checksum creation**. At this point, a **Transaction** has been created. The transaction result is provided using the following URL parameters:

- `paymill_trx_id`: **PAYMILL Transaction ID**, used to identify the transaction in **PAYMILL's system**
- `sofort_trx_id`: **Sofort Transaction ID**, used to identify the transaction in **Sofort's system**
- `paymill_response_code`: Response code providing more details about the transaction status. See the [API Reference](https://developers.paymill.com/API/#response-codes) for more details on response codes.
- `paymill_mode`: Indicates if the transaction was made in `live` or test `mode`.

You can see an example of a successful transaction response here (in the case the return_url was https://requestb.in/1jux9n71):

```http
https://requestb.in/1jux9n71?paymill_trx_id=tran_94619af97ebcb49b56340e07848f&paymill_trx_status=closed&paymill_response_code=20000&paymill_mode=test
```


<p class="important">
While you receive transaction data via URL parameters, **you need to verify transaction integrity yourself**. Simply use the **Transaction ID** to query our API and check if the transaction exists and has the specified status. See [retrieving transaction details](#retrieving-transaction-details) for more information. Or set up a webhook with an event transaction.successful.
</p>


## Retrieving Transaction Details

After a transaction has completed, you can retrieve additional transaction details, from our API:

```bash
curl https://api.paymill.com/v2.1/transactions/tran_5188e355f984445d4b66a45c43fa \
  -u "<YOUR_PRIVATE_KEY>:"
```

Furthermore you can find a transaction by using the description filter. You should always store a unique identifier (e.g. "shopping_cart_1234") to your transaction description to be able to recover transactions also by your own identifiers.

```bash
curl https://api.paymill.com/v2.1/transactions?description=shopping_cart_1234 \
  -u "<YOUR_PRIVATE_KEY>:"
```

But the most effective way is to activate [transaction webhooks](https://developers.paymill.com/API/#webhooks). They will inform you right away about new transactions or status changes.

## Handling Pending Transactions

Payments can be delayed for a variety of reasons such as regulatory review by **Sofort**, restrictions with the buyer's account or your account settings. These transactions are called "pending" and therefore have the status `pending` and a [response code](https://developers.paymill.com/API/#response-codes) (`3xxxx`) indicating the reason.

Pending transactions will eventually become `successful` or `failed`. To handle the result of a pending transaction, [register a webhook or email notification](https://developers.paymill.com/API/#webhooks) for the corresponding events, e.g. `transaction.successful` and `transaction.failed`.

Find more information about **Webhooks** in the [API Reference](https://developers.paymill.com/API/#webhooks).
