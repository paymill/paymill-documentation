---
title: "Transactions"
menu: "Transactions"
type: "guide"
status: "published"
menuOrder: 4
---

In this document we want to show you some basic and advanced use cases with PAYMILL transactions. Please see our [API reference](/API) for more details on the capabilities of our transaction API.

## Creating a transaction

### Creating a payment token

Processing and storing payment data on your server can be time-consuming and costly, for example you need PCI certification before credit card data can touch your server. You also want a bullet-proof integration on the banking side to make sure your payments actually go through.

To avoid having to store and process payment data on your server, which can be time-consuming and costly as it requires to overcome hurdles like PCI certification, we offer a tokenization API that allows you to exchange payment *data* for a payment *token* right from your website. This token can then be sent to your server in order to create the actual transaction.

We offer two ways for tokenization: You can either directly collect payment details on your website and send them to our API or you can use our [PayFrame](/guides/reference/bridge-payframe.html), an embedded credit card form, for even easier PCI compliance.

#### Direct tokenization

Using our JavaScript bridge, you can create tokens for either credit card data:

```javascript
paymill.createToken({
  amount_int: 4200,
  currency: 'EUR',
  number: '4111111111111111',
  exp_month: '01',
  exp_year: '2020',
  cvc: '123',
  cardholder: 'John Doe'
}, callback);
```

... or bank details for direct debit payments:

```javascript
paymill.createToken({
  amount_int: 4200,
  currency: 'EUR',
  iban: 'DE89 3704 0044 0532 0130 00',
  bic: 'COBADEFFXXX',
  accountholder: 'John Doe'
}, callback);
```

In both cases your `callback` function will receive a token that you can then use in your server-side payment processing.

<div class="important">
Please see our [bridge reference](/guides/reference/bridge.html) for more information on direct tokenization.
</div>

#### PayFrame – embedded credit card form

With our PayFrame you don't have to collect credit card data on your website, enabling you to fill out an even simpler PCI self-assessment questionnaire (SAQ).

Instead of defining credit card fields yourself, you simply provide a container element and use our bridge to load an embedded form:

```javascript
paymill.embedFrame('credit-card-fields', options, callback);
```

Now you can request a token using the embedded form without providing actual payment information:

```javascript
paymill.createTokenViaFrame({
  amount_int: 4200,
  currency: 'EUR'
}, callback);
```

<div class="important">
Please see our [PayFrame guide](/guides/reference/bridge-payframe.html) for more information on how to use the embedded credit card form.
</div>

### Creating a transaction from a token

Having created a token on your website, you can now use it to finalize the transaction on your server by calling our transaction API and providing the token along with other transaction data:

```sh
curl https://api.paymill.com/v2.1/transactions \
  -u <YOUR_PRIVATE_KEY>: \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "token=098f6bcd4621d373cade4e832627b4f6" \
  -d "description=Test Transaction"
```

<div class="important">
You use a token when using a credit card or direct debit account for the first time. For each subsequent transaction you will either have to create a new token since **tokens are not reusable** or you can use the payment object that has automatically been created with the first transaction.
</div>

### Creating a transaction from an existing payment object

A payment object represents a "funding source" for a transaction, e.g. a credit card or bank account. It is automatically created when a new transaction is created from a payment token.

Once a payment object has been created, you can use it to create subsequent transactions without going through tokenization. This also means your customer doesn't have to enter their payment details again.

To reuse an existing payment object, simply specify the payment ID when creating a transaction:

```sh
curl https://api.paymill.com/v2.1/transactions \
  -u <YOUR_PRIVATE_KEY>: \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "payment=pay_2f82a672574647cd911d" \
  -d "description=Test Transaction"
```

Optionally, you can specify the client that owns this payment object:

```sh
curl https://api.paymill.com/v2.1/transactions \
  -u <YOUR_PRIVATE_KEY>: \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "client=client_c781b1d2f7f0f664b4d9" \
  -d "payment=pay_a818b847db6ce5ff636f" \
  -d "description=Test Transaction"
```

<div class="important">
Please note that **PayPal accounts are not reusable** at the moment since transactions require the customer to confirm payment.
</div>

### Creating a transaction from a preauthorization

If you have previously created a preauthorization, you can capture those funds simply by providing the preauthorization ID when creating a transaction:

```sh
curl https://api.paymill.com/v2.1/transactions \
  -u <YOUR_PRIVATE_KEY>: \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "preauthorization=preauth_ec54f67e52e92051bd65" \
  -d "description=Test Transaction"
```

## Providing additional transaction data

### Specifying shipping or handling costs

When you specify shopping cart items, the sum of all items should match the overall transaction amount.

If this is not the case, e.g. because shipping and handling fees apply, you need to specify those as well. If shipping insurance or shipping discount apply, please include those in the shipping amount:

```sh
curl https://api.paymill.com/v2.1/transactions \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "amount=6000" \
  -d "currency=EUR" \
  -d "token=098f6bcd4621d373cade4e832627b4f6" \
  -d "description=Test Transaction" \
  -d "shipping_costs=1000" \
  -d "handling_costs=500"
```

### Specifying an app fee

If you use **PAYMILL Unite**, e.g. for a marketplace application, you can add fees to the transactions of your merchants. Create a transaction as usual and add the fee you want to charge as well as the payment object that should be used to settle that fee:

```sh
curl https://api.paymill.com/v2.1/transactions \
  -u <YOUR_PRIVATE_KEY>: \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "token=098f6bcd4621d373cade4e832627b4f6" \
  -d "description=Test Transaction" \
  -d "fee_amount=420" \
  -d "fee_currency=EUR" \
  -d "fee_payment=pay_3af44644dd6d25c820a8"
```

## Creating a transaction checksum

A checksum is created on your server using your private API key. This ensures the integrity of transaction data and serves to prevent that your payment can be tampered with along the way.

You can either call the checksum API directly or use one of our [API libraries](/guides/integration/libraries.html) on your server. Once you have collected transaction data on your server, creating a checksum is as easy as passing that data to our API in one call:

```sh
curl https://api.paymill.com/v2.1/checksums \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "description=Test Transaction"
```

You can add any type of transaction data to the checksum, this includes shipping/handling costs, shopping cart items, shipping/billing address as well as return/cancel URLs for PayPal.

Here's an example of a checksum for a full-fledged transaction:

```sh
curl https://api.paymill.com/v2.1/checksums \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "checksum_type=paypal" \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "description=Test Transaction" \
  -d "return_url=https://www.example.com/store/checkout/result" \
  -d "cancel_url=https://www.example.com/store/checkout/retry" \
  -d "shipping_address[name]=Max Mustermann" \
  -d "shipping_address[street_address]": "Musterstr. 1", \
  -d "shipping_address[street_address_addition]": "", \
  -d "shipping_address[city]": "Munich", \
  -d "shipping_address[state]": "Bavaria", \
  -d "shipping_address[postal_code]": "80333", \
  -d "shipping_address[country]": "DE", \
  -d "shipping_address[phone]": "+4989123456" \
  -d "billing_address[name]=Max Mustermann" \
  -d "billing_address[street_address]": "Musterstr. 1", \
  -d "billing_address[street_address_addition]": "", \
  -d "billing_address[city]": "Munich", \
  -d "billing_address[state]": "Bavaria", \
  -d "billing_address[postal_code]": "80333", \
  -d "billing_address[country]": "DE", \
  -d "billing_address[phone]": "+4989123456" \
  -d "items[0][name]=Example Product 1" \
  -d "items[0][amount]=1500" \
  -d "items[0][quantity]=2" \
  -d "items[1][name]=Example Product 2" \
  -d "items[1][amount]=1000" \
  -d "items[1][quantity]=3"
```

A transaction created from this checksum will contain all of this data automatically.
