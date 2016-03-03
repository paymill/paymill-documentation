---
title: "Transaction Checksums"
menuTitle: "Checksums"
type: "guide"
status: "published"
menuOrder: 2
---

Checksum validation is a simple method to ensure the integrity of transferred data. Basically, we generate a hash out of the given parameters and your private API key.

If you send us a request with transaction data and the generated checksum, we can easily validate the data an ensure it was not tempered along the way.

For transactions that are started client-side, such as PayPal checkout, it is required to first create a checksum on your server and then provide that checksum when starting the transaction in the browser.

Have a look at the [API Reference](/API#checkums) for more details on Checksums creation.


## CREATING A TRANSACTION CHECKSUM

You can create a checksum on your server using your private API Key either calling the API directly or using one of our [API Libraries](https://developers.paymill.com/guides/integration/libraries.html). Just pass the transaction data to the Checksums endpoint:

```bash
  curl https://api.paymill.com/v2.1/checksums \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "amount=4200" \
    -d "currency=EUR" \
    -d "description=Test Transaction"
```

You can add any type of transaction data to the checksum, this includes shipping/handling costs, shopping cart items, shipping/billing address as well as return/cancel URLs for PayPal.

{>> TODO: Add links to various cited transaction data <<}


_Example of Checksum for a full-fledged transaction:_

```bash
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
