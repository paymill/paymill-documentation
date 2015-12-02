---
title: "PayPal Subscriptions"
menuTitle: "Subscriptions"
type: "guide"
status: "published"
menuOrder: 5
---

Creating PayPal subscriptions through PAYMILL is simple:

- Create a [Payment Object](/guides/paypal/payment-method#reusing-a-paypal-payment-object) that can be used for **recurring transactions**.
- Create a [Subscription](/guides/reference/subscriptions) based on that [Reusable Payment Object](/guides/paypal/payment-method#reusing-a-paypal-payment-object).

<p class="important">
Recurring payments use a special PayPal feature called [reference transactions](https://developer.paypal.com/docs/classic/express-checkout/integration-guide/ECReferenceTxns/). Please contact **PayPal** and request that feature to be enabled for you.
</p>

## Creating A Reusable PayPal Payment Object

A **PayPal Payment Object** represents the customer's **PayPal account**. In order for it to be reusable you have to obtain a so-called billing agreement from your customer. This allows you to charge future payments to their **PayPal account**.

A **reusable PayPal Payment Object** is indicated by the attribute `is_recurring` set to `true` in the **API response**.

You can create a **reusable PayPal Payment Object** [during a regular PayPal Transaction](/guides/paypal/payment-method#to-create-a-reusable-payment-during-a-transaction-) or you can just [request a billing agreement without carrying out a transaction](/guides/paypal/payment-method#to-create-a-reusable-payment-without-a-transaction-).

See the [PayPal Payments guide](/guides/paypal/payment-method) for more information.

<p class="info">
When creating a **Subscription**, you can explicitly link it to a **Client**. Otherwise the owner of the **Payment** will automatically be used.
</p>

## Setting Up A Subscription Based On PayPal

You can create a **PayPal Subscription** either via our API or Merchant Centre, using existing **Client** and **PayPal Payment** objects.

The process is then the same one as with other **Payment Methods**.

See the [Subscriptions guide](/guides/reference/subscriptions.html) for a detailed explanation.

<p class="important">
For **PayPal Subscriptions** to run successfully, the **PayPal account** used for their creation **needs to be connected to PAYMILL**. If you disconnect your **PayPal account** or connect a **different one**, **all pre-existing PayPal subscriptions will fail!** Use the [subscription settings](https://app.paymill.com/settings/subscriptions) in your **Merchant Centre** to specify what should happen in case of failure.
</p>

![](/guides/images/PayPal-subscriptions-1.png)
