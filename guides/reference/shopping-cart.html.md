---
title: "Shopping Cart Data"
menu: "Shopping Cart Data"
type: "guide"
status: "published"
menuOrder: 7
---

## Providing shopping cart items

You can attach shopping cart data to your transactions, no matter which payment method you use. This data will then be available to your at any time through both our API and Merchant Centre.

Shopping cart items are not mandatory, but we recommend you add them your transactions (regardless of payment method) so you always have this data available in the future, e.g. if you want to run business analytics based on purchase history.

A transaction can have an arbitrary amount of shopping cart items with the following attributes:

- **Name:** Item name (mandatory)
- **Description:** Additional description (optional)
- **Amount:** Price of a single item, can also be *negative* to act as a discount (mandatory)
- **Quantity:** Quantity of this item (mandatory)
- **Item number:** Item number or other identifier (SKU/EAN/…) (optional)
- **URL:** URL of the item in your store (optional)

Simply provide a list of items when creating a transaction:

```sh
curl https://api.paymill.com/v2.1/transactions \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "amount=6000" \
  -d "currency=EUR" \
  -d "token=098f6bcd4621d373cade4e832627b4f6" \
  -d "description=Test Transaction" \
  -d "items[0][name]=Example Product 1" \
  -d "items[0][amount]=1500" \
  -d "items[0][quantity]=2" \
  -d "items[1][name]=Example Product 2" \
  -d "items[1][amount]=1000" \
  -d "items[1][quantity]=3"
```

## PayPal shopping cart

Shopping cart items are displayed to your customer during PayPal checkout. Make sure to add a descriptive title and the correct amounts.

To provide shopping cart items for PayPal transactions, simply add them to the checksum:

```sh
curl https://api.paymill.com/v2.1/checksums \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "checksum_type=paypal" \
  -d "amount=6000" \
  -d "currency=EUR" \
  -d "description=Test Transaction" \
  -d "return_url=https://www.example.com/store/checkout/result" \
  -d "cancel_url=https://www.example.com/store/checkout/retry" \
  -d "items[0][name]=Example Product 1" \
  -d "items[0][amount]=1500" \
  -d "items[0][quantity]=2" \
  -d "items[1][name]=Example Product 2" \
  -d "items[1][amount]=1000" \
  -d "items[1][quantity]=3"
```

<div class="important">
If you provide shopping cart items, the sum of those items (and **shipping/handling costs** if specified) must match the overall transaction amount. Otherwise PayPal will reject the transaction.  
<br>
For example, if you have 10 items at 10EUR, the transaction amount must be 100EUR. If your overall transaction amount is 120EUR, the excess 20EUR must be specified as an additional shopping cart item or shipping/handling costs.
</div>
