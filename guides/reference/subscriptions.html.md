---
title: "Subscriptions"
menu: "Subscriptions"
type: "guide"
status: "published"
menuOrder: 8
---

## 1. Setting up a Subscription

Along with one-time payments, it is also possible to create subscriptions with PAYMILL. This gives you the advantage to charge the registered credit card or direct debit periodically, say, once a month without any additional request or the need to receive renewed authorization from your client.

<!-- TODO: Include v2.0 variant -->

You can generate and manage subscriptions easily in your [Merchant Centre](http://app.paymill.com). As an alternative, you can use the [PAYMILL API](/API) to generate subscriptions through your website. Here is the relevant sample code:

```bash
curl https://api.paymill.com/v2.1/offers \
  -u 282dbb1313587ea5d8dd71c7f7ac1b27: \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "interval=1 MONTH" \
  -d "name=Test Offer"
```

Each subscription receives a unique ID, which you can activate via the [API reference](/API).

## 2. Creating Clients

Here is the code for creating a client in PAYMILL:

<!-- TODO: Include v2.0 variant -->

```bash
curl https://api.paymill.com/v2.1/clients \
  -u 282dbb1313587ea5d8dd71c7f7ac1b27: \
  -d "email=lovely-client@example.com" \
  -d "description=Lovely Client"
```

<p class="important">
In version 2.1 you can directly update the subscription for a specific client who already has a subscription. For example, you can change the amount due to be charged and set the price to be valid one-time or until the end of the subscription. Further updates are also possible in API V2.1. You can find more information in our workflow documentation.  <!-- TODO:  Link to Workflow Documentation-->
</p>

## 3. Client Assignment

<!-- TODO: Include v2.0 variant -->

When it comes to subscriptions, there is a second important component involving clients: they must be linked to a subscription. You can assign them to a subscription really easily with our [API reference](/API).

An existing client can likewise be assigned to a subscription. Here is an example:

```bash
curl https://api.paymill.com/v2.1/subscriptions \
  -u 282dbb1313587ea5d8dd71c7f7ac1b27: \
  -d "client=client_64b025ee5955abd5af66" \
  -d "offer=offer_40237e20a7d5a231d99b" \
  -d "payment=pay_95ba26ba2c613ebb0ca8"
```

The ID that is created when setting up the new client has to be stored in your own system in order to be able to communicate with PAYMILL and perform operations later.

If you want to use the [Merchant Centre](http://app.paymill.com) the steps would be as followed:

  1. Navigate to "Clients" and create a new client.
  2. Navigate to the client details and create new payment information...
  3. then create a new subscription and add payment and offer (create a new offer or choose an existing one) information.

## 4. Subscription Cancellation

<!-- TODO: Include v2.0 variant -->

Client subscriptions are cancelled using the following simple API request:

```bash
curl https://api.paymill.com/v2.1/subscriptions/sub_dc180b755d10da324864 \
  -u 282dbb1313587ea5d8dd71c7f7ac1b27: \
  -d "remove=false" \
  -X DELETE
```

You will find more information on refunds and other changes in our [API reference](/API).

## 5. Deleting a Subscription

You can delete subscriptions with the following sample code:

```bash
curl https://api.paymill.com/v2.1/subscriptions/sub_dc180b755d10da324864 \
  -u 282dbb1313587ea5d8dd71c7f7ac1b27: \
  -d "remove=true" \
  -X DELETE
```

Should you have any further questions, feel free to view our [API reference](/API) or check our [FAQs](https://www.paymill.com/faq).

## 6. Change existing subscriptions

<!-- TODO: Include v2.0 variant -->

With our v2, you have the ability to change and edit existing subscriptions. This functionalities have been expanded in version v2.1.

```bash
curl https://api.paymill.com/v2/subscriptions/sub_dc180b755d10da324864 \
  -u 90365b70518d8d3101af0e1e8d3413d5: \
  -d "offer=offer_40237e20a7d5a231d99b" \
  -d "payment=pay_95ba26ba2c613ebb0ca8" \
  -d "currency=USD" \
  -d "interval=1 month,friday" \
  -d "name=Changed Subscription" \
  -d "period_of_validity=14 MONTH" \
  -d "trial_end=false" \
  -X PUT
```

Just look at this function in our [Merchant Centre](http://app.paymill.com).
