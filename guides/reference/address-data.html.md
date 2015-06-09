---
title: "Address Data"
menu: "Address Data"
type: "guide"
status: "published"
menuOrder: 6
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
  -d "token=098f6bcd4621d373cade4e832627b4f6" \
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
  -d "token=098f6bcd4621d373cade4e832627b4f6" \
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
**This feature will be available soon.**

PayPal Express Checkout Shortcut (ECS) allows your to obtain an address via PayPal. Instead of providing an address yourself, simply specify that you need one.

<div class="info">
For the time being, if no shipping address is provided the customer will be prevented from entering one during PayPal checkout.
</div>
