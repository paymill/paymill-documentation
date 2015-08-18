---
title: "Address Data"
menu: "Address Data"
type: "guide"
status: "published"
menuOrder: 9
---

You can attach two kinds of addresses to a transaction: a shipping address and a billing address. Both addresses have the following fields:

- **Name:** Personal or company name of the addressee (mandatory)
- **Street address:** Addition to street address, e.g. building, floor, or c/o (mandatory)
- **Address addition:** Additions optional
- **City:** mandatory
- **State:** State or province, (optional, may be required for PayPal in certain countries)
- **Postal code:** Country-specific postal code (optional, may be required for PayPal in certain countries)
- **Country:** Country code (mandatory)
- **Phone:** contact phone number (optional)

## Storing shipping details

If you sell physical products, you probably have a shipping address for each transaction. You can conveniently store this address in our API and retrieve it whenever you need it again.

Simply provide the shipping address when creating a transaction:

```sh
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

The shipping address will be stored with the transaction and you can retrieve it at any time either via our API or the Merchant Centre.

## Storing billing details

You can also store a billing address with a transaction the same way as a shipping address:

```sh
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

Shipping and billing addresses are not mandatory and a transaction can have none, only one or both addresses.

## Providing shipping details for PayPal

PayPal supports multiple workflows for providing shipping details. They also expect you to provide the correct shipping address in order to receive seller protection. We have therefore

### Providing a shipping address

In case of PayPal transactions, you need to store the shipping address in a checksum instead of a transaction:

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
  -d "shipping_address[phone]": "+4989123456"
```

The address will then be displayed to the customer in PayPal checkout. However, the customer can't change the address during PayPal checkout.

<div class="info">
For PayPal transactions, the field "state" is mandatory in several countries. Please consult PayPal's documentation for details.
</div>

### Requesting a shipping address

PayPal Express Checkout Shortcut (ECS) allows your to obtain an address via PayPal. Instead of providing an address yourself, simply specify that you need one. You can also provide a shipping address and allow the buyer to change it during checkout.

To allow the buyer to either provide or change the shipping address, simply set `shipping_address_editable` when setting up a checkout (it's set to `false` by default). Options like this are specified inside the `checkout_options` of a checksum.

<div class="info">
Technically you don't have to provide a shipping address, but PayPal seller protection might require you to do so. When selling physical products, we recommend to always provide or collect a shipping address.
</div>

Overall, there are four different cases to keep in mind:

- If you provide a shipping address:
  - If you don't set `shipping_address_editable` or set it to `false`, the buyer won't be able to change the address.
  - If you set `shipping_address_editable=true`, the buyer will be able to change the address (but doesn't have to).
- If you don't provide a shipping address:
  - If you don't set `shipping_address_editable` or set it to `false`, the buyer won't be able to provide an address.
  - If you set `shipping_address_editable=true`, the buyer will be able to provide an address (but doesn't have to).

Example for how to let the buyer provide a shipping address:

```sh
curl https://api.paymill.com/v2.1/checksums \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "checksum_type=paypal" \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "description=Test Transaction" \
  -d "return_url=https://www.example.com/store/checkout/result" \
  -d "cancel_url=https://www.example.com/store/checkout/retry" \
  -d "checkout_options[shipping_address_editable]=true"
```

Example for how to provide a shipping address but let the buyer change it if they want to:

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
  -d "checkout_options[shipping_address_editable]=true"
```

After successful checkout, your transaction will be updated with the shipping address obtained from PayPal. Simply retrieve [transaction details](/API/#-transaction-details) from our API to get the provided or changed shipping address.

<div class="important">
If you make the shipping address editable, regardless of whether you provide one yourself or not, you should always retrieve the updated transaction after checkout to avoid using the wrong address.
</div>
