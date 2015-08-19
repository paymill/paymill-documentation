---
title: "PayPal Subscriptions"
menu: "PayPal Subscriptions"
type: "guide"
status: "published"
menuOrder: 5
---

Creating PayPal subscriptions through PAYMILL is easy:

1. Create a payment object that can be used for recurring transactions.
- Create a subscription based on that reusable payment object.

<div class="important">
Recurring payments use a special PayPal feature called “reference transactions”. Please contact PayPal and request that feature to be enabled for you.
</div>

## Creating a reusable PayPal means of payment

A PayPal payment object represents the customer's PayPal account. In order for it to be reusable you have to obtain a so-called *billing agreement* from your customer. This allows you to charge future payments to their PayPal account and is indicated by `is_recurring=true` in the API response.

You can create a reusable PayPal payment object during a regular PayPal transaction or you can just request a billing agreement without carrying out a transaction. See our [PayPal payment guide](/guides/paypal/payments.html) for more information.

<div class="info">
When creating a subscription, you can explicitly link it to a client. Otherwise the owner of the payment will automatically be used.
</div>

## Setting up a subscription based on PayPal

Using an existing client and payment object, you can create a subscription either via our API or Merchant Centre.

Simply follow the instructions in our [subscriptions guide](/guides/reference/subscriptions.html) to use the client and payment object to create a subscription.

<div class="important">
For PayPal subscriptions to run successfully, your PayPal account used to create them needs to be connected to PAYMILL.
<strong>If you disconnect your PayPal account or connecting a different PayPal account, all pre-existing PayPal subscriptions will fail!</strong>
Use the [subscription settings](https://app.paymill.com/settings/subscriptions) in our Merchant Centre to specify what should happen in these cases.
</div>
