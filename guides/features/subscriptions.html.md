---
title: "Subscriptions"
menuTitle: "Subscriptions"
type: "guide"
status: "published"
menuOrder: 4
---

Along with one-time payments, it is also possible to create subscriptions with PAYMILL. This gives you the ability to charge a registered payment method periodically, say, once a month without any additional request or the need to receive renewed authorization from your client.

Before you can create a subscription for a client, you need to create a subscription plan, which is called an offer.

Have a look at the [API Reference](/API#subscriptions) for more details on Subscriptions.

<div class="important">
Please be aware that subscriptions are currently not available for the **PayPal** payment method.
</div>

## Offers

Before creating subscriptions might want to set-up offers.

An offer is a plan which a client can subscribe to. You can create different offers with different plan attributes, e.g. pricing, billing interval, or trial period.

The following data is expected when creating a subscription plan:

  - **Name:** A unique name for this subscription plan. (mandatory)
  - **Amount:** Amount to charge per billing interval. (mandatory)
  - **Currency:** Currency of the subscription amount. (mandatory)
  - **Interval:** Defining how often the client should be charged. (mandatory)
  - **Trial period:** Trial period without charge. (optional)

```bash
  curl https://api.paymill.com/v2.1/offers \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "amount=4200" \
    -d "currency=EUR" \
    -d "interval=1 WEEK" \
    -d "name=Nerd Special"
```

Offers can be managed either via the API or the Merchant Centre.

Read the [Reference](/API#offers) for full information on Offers management with the API.

## Creating a subscription

### Based on an offer

If you already have set-up offers, creating a subscription is very straightforward.

You only need to provide the following attributes:

  - **Offer:** The subscription plan to subscribe to. (mandatory)
  - **Payment:** Means of payment belonging to the client that should be billed. (mandatory)
  - **Client:** ID of the client subscribing to the plan. If not provided, the client owning the payment is used. (optional)
  - **Name:** Name for this particular subscription. (optional)

```bash
  curl https://api.paymill.com/v2.1/subscriptions \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "offer=<OFFER ID>" \
    -d "payment=<PAYMENT ID"\
    -d "offer=<CLIENT ID>" \
    -d "name=some name"\    
```

### Without an offer

If you haven't created the offer yet, you can create the subscription directly and have the offer be automatically generated for you.

This might for example be useful when you provide custom subscriptions based on many parameters and don't want to create offers for every possible combination.

You will then need to provide the amount, currency and interval instead of the offer id:

```bash
  curl https://api.paymill.com/v2.1/subscriptions \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "client=<CLIENT ID>" \
    -d "payment=<PAYMENT ID>" \
    -d "amount=3000" \
    -d "currency=EUR" \
    -d "interval=1 week,monday" \
```

<div class="info">
Instead of creating a new offer, you can also override certain attributes of an existing offer when creating a subscription.
See the [API Reference](/API#subscriptions) for further details.
</div>

## Controlling the runtime of a subscription

There are many ways you can act on a subscription runtime:

  - Control the start date
  - Restrict it's validity
  - Offer a trial
  - Cancel the trial ahead of time
  - Pause and resume the subscription manually.

The status of a subscription is indicated by its `status` attribute:

  - When the subscription is `active` it will run at the specified billing interval and create a transaction at the date specified with the `next_capture_at` parameter.
  - When the subscription hasn't started yet, has been paused or has expired, it is `inactive`.

### Starting a subscription at a specific date

By default, a subscription starts right after it was created and runs the specified billing interval. To delay the start of a subscription, simply pass a UNIX Timestamp with the `start_at` parameter when creating it:

```bash
  curl https://api.paymill.com/v2.1/subscriptions \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "offer=<OFFER ID>" \
    -d "payment=<PAYMENT ID>" \
    -d "start_at=1400575533"
```

<div class="info">
  The date of next capture will automatically be calculated based on the start date and the interval.
  The next capture date can be read from a subscription object through the `next_capture_at` field.
</div>

### Stopping a subscription at a specific date

Similar to the start date, you can also restrict the period of validity for a subscription. When this period expires, the subscription will be stopped automatically. The field `end_of_period` will specify the calculated end date of a subscription.

In this example, we restrict the runtime of the subscription to 2 years, calculated from the start date (which can be specified separately, like above):

```bash
  curl https://api.paymill.com/v2.1/subscriptions \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "offer=offer_40237e20a7d5a231d99b" \
    -d "payment=pay_95ba26ba2c613ebb0ca8" \
    -d "period_of_validity=2 YEAR"
```

### Managing trial periods

You might want to offer a trial period to your customers. If you do so, your subscription will run but the customer won't be billed until the end of the specified period.

The trial period can be specified either in an offer or while creating a new subscription.

Here is an example of a trial period added to a subscription upon creation (it would override the trial period of the offer if it existed):

```bash
  curl https://api.paymill.com/v2.1/subscriptions \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "offer=<OFFER ID>" \
    -d "payment=<PAYMENT ID>" \
    -d "trial_period_days=30"
```

A trial period can be ended ahead of time by updating the subscription (see below) and setting `trial_end` to `true`:

```bash
  curl https://api.paymill.com/v2.1/subscriptions/<SUBSCRIPTION ID> \
    -X PUT \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "offer=<OFFER ID>" \
    -d "payment=<PAYMENT ID>" \
    -d "trial_end=true"
```

### Pausing/resuming a subscription

You might need to temporarily discontinue a subscription while it's running, but without permanently cancelling it.

You can pause and resume a subscription simply by updating it and setting the pause attribute to `true` or `false`, respectively:

```bash
  curl https://api.paymill.com/v2.1/subscriptions/<SUBSCRIPTION ID> \
    -X PUT \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "offer=<OFFER ID>" \
    -d "payment=<PAYMENT ID>" \
    -d "pause=true"
```

## UPDATING A SUBSCRIPTION

You can directly update the subscription for a specific client. For example, you can change the amount due to be charged and set the price to be valid one-time or until the end of the subscription.

```bash
  curl https://api.paymill.com/v2.1/subscriptions/<SUBSCRIPTION ID> \
    -X PUT \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "offer=<OFFER ID>" \
    -d "payment=<PAYMENT ID>" \
    -d "currency=USD" \
    -d "interval=1 month,friday" \
    -d "name=Changed Subscription" \
    -d "period_of_validity=14 MONTH" \
    -d "trial_end=false" \
```

<div class="info">
  You will find more information on handling plan and amount changes, prorating and refunds in our [API reference](/API#subscriptions).
</div>

## CANCELLING OR DELETING A SUBSCRIPTION

When a subscription should no longer run, you can determine whether it should just be cancelled (i.e. stop the subscription but don't remove the resource) or actually deleted (i.e. stop the subscription and remove the resource).

Both cases use a `DELETE` request on the subscription resource and are differentiated using the `remove` parameter.

To just **cancel** the subscription, set it to `false`:

```bash
  curl https://api.paymill.com/v2.1/subscriptions/<SUBSCRIPTION ID> \
    -X DELETE \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "remove=false" \
```

To actually **delete** the subscription, set it to true:

```bash
  curl https://api.paymill.com/v2.1/subscriptions/<SUBSCRIPTION ID> \
    -X DELETE
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "remove=true" \
```
