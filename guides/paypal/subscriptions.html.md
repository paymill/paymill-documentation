---
title: "PayPal Subscriptions"
menu: "PayPal Subscriptions"
type: "guide"
status: "published"
menuOrder: 5
---

Creating PayPal subscriptions through PAYMILL is easy:

1. Follow the guide to [create a PayPal payment](/guides/paypal/payments.html).
- Keep in mind to assign a client to the payment, as this is necessary for a valid subscription.
- Now simply create a subscription like it is explained in the [subscription guide](/guides/introduction/subscriptions).

## Payment setup

After the payment was created like described in the [create a PayPal payment](/guides/paypal/payments.html) guide, no more interaction with the customer is necessary.
All the following steps are done on your server, they don't differ from the steps of other payment methods like credit card or SEPA. PayPal can be handled the exact same way.

<div class="info">
Please refer to our [API reference](/API/#subscriptions) for more information on subscription details.
</div>

<div class="info">
Keep in mind that you always need a connected PayPal account to be able to run PayPal subscriptions.
If you disconnect your account from PayPal your subscriptions can't be charged any more.
</div>
