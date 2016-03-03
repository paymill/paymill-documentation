---
title: "Transactions"
menuTitle: "Transactions"
type: "guide"
status: "published"
menuOrder: 3
---

In some cases you may want to refund a transaction; e.g. a customer cancelled his order after it was charged or returns goods.

PAYMILL allows you to easily refund transactions.

- You can refund parts of a transaction until the transaction amount is fully refunded.
- There is no need to define a currency for refunds, because they will be in the same currency as the original transaction

Please see our [API reference][/API/index#refunds] for more information on refunds.

## Refunding a transaction

The refund parameters are the following:

  - **Amount:** Amount to refund (mandatory)
  - **Description:** A description for the refund. Useful for further reference (Optional)
  - **Reason:** Reason of the refund. Can be `duplicate`, `fraudulent` or `requested_by_customer` (optional)

```bash
  curl https://api.paymill.com/v2.1/refunds/<TRANSACTION ID> \
    -u <YOUR_PRIVATE_KEY>: \
    -d "amount=4200"
    -d "description=Order cancelled"
    -d "reason=resquested_by_customer"
```
