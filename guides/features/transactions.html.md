---
title: "Transactions"
menuTitle: "Transactions"
type: "guide"
status: "published"
menuOrder: 2
---

{>> TODO: Add transaction states info to the guide + more information? <<}

A transaction is the action of charging a customer through a given payment method. When a transaction is

Have a look at the [API reference][/API/index#transactions] for more details on the capabilities of our transaction API.

{>> TODO: Add link to Payment Methods guide <<}
{>> The available payment methods are:

  - Credit / Debit card
  - SEPA Direct Debit
  - PayPal <<}
  {>> TODO: Add links to payment methods guide <<}

## Creating a transaction

There are three ways to create a transaction:

  - From a token
  - From a payment object
  - From a preauthorization

### Creating a transaction from a token

A token is generated with the **PAYMILL Javascript Bridge**.

You create a transaction from a token when you don't have a payment object stored for your customers.

It allows you to charge the customer payment method straight away from a payment form.

_Example of transaction from a token:_

```bash
  curl https://api.paymill.com/v2.1/transactions \
    -u <YOUR_PRIVATE_KEY>: \
    -d "amount=4200" \
    -d "currency=EUR" \
    -d "token=<PAYMILL_TOKEN>" \
    -d "description=Test Transaction"
```

Please read the guides for more information about token generation from the JS Bridge.
{>> TODO: Link to the JS bridge guides  <<}

### Creating a transaction from a Payment Object

A Payment Object represents a _"funding source"_ for a transaction. This source can be for example a credit card or a bank account.

<div class="important">
  Payment Objects are currently **not available for PayPal transactions**
</div>

You can find more information in the Payment Objects guide.
{>> TODO: Add link to the Payment Objects guide <<}

Once a payment object has been created, you can use it to create subsequent transactions without going through the tokenization process. This also means that your customer doesn't have to enter their payment details again. It is a secure way of storing payment information of your customers without having to be PCI compliant since the actual payment information remains on the PAYMILL servers.
{>> TODO: Add a link to PCI guide <<}

_Example of transaction from a payment object:_

```bash
  curl https://api.paymill.com/v2.1/transactions \
    -u <YOUR_PRIVATE_KEY>: \
    -d "amount=4200" \
    -d "currency=EUR" \
    -d "payment=pay_2f82a672574647cd911d" \
    -d "description=Test Transaction"
```

You can optionally specify the client that owns the payment object:

```bash
  curl https://api.paymill.com/v2.1/transactions \
    -u <YOUR_PRIVATE_KEY>: \
    -d "amount=4200" \
    -d "currency=EUR" \
    -d "client=client_c781b1d2f7f0f664b4d9" \
    -d "payment=pay_a818b847db6ce5ff636f" \
    -d "description=Test Transaction"
```

### Creating a transaction from a preauthorization

A Preauthorization allows you to ensure the funds are available in the customer bank account but charge the amount later.
Read the guide on Preauthorizations for more information.

If you have previously created a preauthorization, you can capture the funds simply by providing the preauthorization ID when creating a transaction.

_Example of transaction from a preauthorization object:_

```bash
  curl https://api.paymill.com/v2.1/transactions \
    -u <YOUR_PRIVATE_KEY>: \
    -d "amount=4200" \
    -d "currency=EUR" \
    -d "preauthorization=preauth_ec54f67e52e92051bd65" \
    -d "description=Test Transaction"
```

## PROVIDING ADDITIONAL TRANSACTION DATA

You can pass additional data along with your transactions.


### Address Data

You can attach two kinds of addresses to a transaction: a shipping address and a billing address.

An address contains the following fields:

  - **Name:** Personal or company name of the addressee (mandatory)
  - **Street address:** Addition to street address, e.g. building, floor, or c/o (mandatory)
  - **Address addition:** Additions optional (optional)
  - **City:** (mandatory)
  - **State:** State or province, (optional)
  - **Postal code:** Country-specific postal code (optional)
  - **Country:** Country code (mandatory)
  - **Phone:** contact phone number (optional)

#### Shipping Details

In case you are selling physical goods, you probably have a shipping address for each transaction. You can conveniently store this address in our API and retrieve it whenever you need it again.

Shipping and billing addresses are not mandatory and a transaction can have none, only one or both addresses.

Simply provide the shipping address when creating a transaction:

```bash
  curl https://api.paymill.com/v2.1/transactions \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "amount=4200" \
    -d "currency=EUR" \
    -d "token=<PAYMILL_TOKEN>" \
    -d "description=Test Transaction" \
    -d "shipping_address[name]=Max Mustermann" \
    -d "shipping_address[street_address]": "Musterstr. 1", \
    -d "shipping_address[street_address_addition]": "", \
    -d "shipping_address[city]": "Munich", \
    -d "shipping_address[state]": "Bavaria", \
    -d "shipping_address[postal_code]": "80333", \
    -d "shipping_address[country]": "DE", \
    -d "shipping_address[phone]": "+4989123456"
```

The shipping address will be stored with the transaction. You can retrieve it at any time either via our API or the Merchant Centre.

#### Billing Details

You can also store a billing address with a transaction the same way as a shipping address:

```bash
  curl https://api.paymill.com/v2.1/transactions \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "amount=4200" \
    -d "currency=EUR" \
    -d "token=<PAYMILL_TOKEN>" \
    -d "description=Test Transaction" \
    -d "billing_address[name]=Max Mustermann" \
    -d "billing_address[street_address]": "Musterstr. 1", \
    -d "billing_address[street_address_addition]": "", \
    -d "billing_address[city]": "Munich", \
    -d "billing_address[state]": "Bavaria", \
    -d "billing_address[postal_code]": "80333", \
    -d "billing_address[country]": "DE", \
    -d "billing_address[phone]": "+4989123456"
```

### Shopping cart data

You can attach shopping cart data to your transactions, no matter which payment method you use. This data will then be available to your at any time through both our API and Merchant Centre.

Shopping cart items are not mandatory, but we recommend you add them your transactions (regardless of payment method) so you always have this data available in the future, e.g. if you want to run business analytics based on purchase history.

A transaction can have an arbitrary amount of shopping cart items with the following attributes:

  - **Name**: Item name (mandatory)
  - **Description**: Additional description (optional)
  - **Amount**: Price of a single item, can also be negative to act as a discount (mandatory)
  - **Quantity**: Quantity of this item (mandatory)
  - **Item number**: Item number or other identifier (SKU/EAN/...) (optional)
  - **URL**: URL of the item in your store (optional)

Simply provide the list of items when creating a transaction:

```bash
  curl https://api.paymill.com/v2.1/transactions \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "amount=6000" \
    -d "currency=EUR" \
    -d "token=<PAYMILL_TOKEN>" \
    -d "description=Test Transaction" \
    -d "items[0][name]=Example Product 1" \
    -d "items[0][amount]=1500" \
    -d "items[0][quantity]=2" \
    -d "items[1][name]=Example Product 2" \
    -d "items[1][amount]=1000" \
    -d "items[1][quantity]=3"
```

### Shipping / handling costs

When you specify shopping cart items, the sum of all items should match the overall transaction amount.

{>> TODO: Figure out why there is no information about shopping card items in the API Ref <<}

{>> TODO: Add link to shopping cart items guide <<}

If this is not the case, e.g. because shipping and handling fees apply, you need to specify those as well. If shipping insurance or shipping discount apply, please include those in the shipping amount:

{>> TODO: Figure out why shipping and handling costs don't appear in the API Reference <<}

```bash
  curl https://api.paymill.com/v2.1/transactions \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "amount=6000" \
    -d "currency=EUR" \
    -d "token=<PAYMILL_TOKEN>" \
    -d "description=Test Transaction" \
    -d "shipping_costs=1000" \
    -d "handling_costs=500"
```

### App fee

If you are using **PAYMILL Connect**, (e.g. for a marketplace application), you can add fees to the transactions of your merchants.
Create a Transaction as usual and add the fee you would like to to charge as well as the Payment Object that should be used to settle that fee:

{>> TODO: Link to the connect guide <<}

```bash
  curl https://api.paymill.com/v2.1/transactions \
    -u <YOUR_PRIVATE_KEY>: \
    -d "amount=4200" \
    -d "currency=EUR" \
    -d "token=<PAYMILL_TOKEN>" \
    -d "description=Test Transaction" \
    -d "fee_amount=420" \
    -d "fee_currency=EUR" \
    -d "fee_payment=pay_3af44644dd6d25c820a8"
```
