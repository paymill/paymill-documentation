---
title: "Subscriptions"
menu: "Subscriptions"
type: "guide"
status: "published"
menuOrder: 8
---

## Creating a subscription plan

Before you can create a subscription for a client, you need to create a subscription plan, called “offer”.

An offer is a recurring plan which a client can subscribe to. You can create different offers with different plan attributes, e.g. pricing, billing interval, or trial period. The following data is expected when creating a subscription plan:

- **Name:** A unique name for this subscription plan.
- **Amount:** Amount to charge per billing interval.
- **Currency:** Currency of the subscription amount.
- **Interval:** Defining how often the client should be charged.
- **Trial period:** Optional trial period without charge.

```bash
curl https://api.paymill.com/v2.1/offers \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "interval=1 WEEK" \
  -d "name=Nerd Special"
```

Subscription plans can be managed via [API](/API/#offers) or in our [Merchant Centre](https://app.paymill.com/offers).

## Setting up a subscription

Along with one-time payments, it is also possible to create subscriptions with PAYMILL. This gives you the advantage to charge the registered credit card or direct debit periodically, say, once a month without any additional request or the need to receive renewed authorization from your client.

### Creating a subscription based on an offer

You can generate and manage subscriptions easily in your [Merchant Centre](https://app.paymill.com/subscriptions). As an alternative, you can use our [API](/API) to generate subscriptions. You only have to provide the following references:

- **Offer:** The subscription plan to subscribe to.
- **Payment:** Means of payment belonging to the client that should be billed.
- **Client:** Optional ID of who is subscribing to the subscription plan. If not provided, the client owning the payment is used.
- **Name:** Optional name for this particular subscription.

Here's a minimal example:

```bash
curl https://api.paymill.com/v2.1/subscriptions \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "offer=offer_40237e20a7d5a231d99b" \
  -d "payment=pay_95ba26ba2c613ebb0ca8"
```

### Overriding offer details in a subscription

When creating a subscription based on an offer, you can also override offer details just for this particular subscription. This allows you to apply special conditions such as changing the amount, billing at a different interval or adding a trial period:

```bash
curl https://api.paymill.com/v2.1/subscriptions \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "offer=offer_b33253c73ae0dae84ff4" \
  -d "client=client_81c8ab98a8ac5d69f749" \
  -d "payment=pay_5e078197cde8a39e4908f8aa" \
  -d "amount=3000" \
  -d "currency=EUR" \
  -d "interval=1 week,monday" \
  -d "start_at=<UNIX_TIMESTAMP>"
```

Please note that you have to set a trial period that is differing from the one set in the offer as a specific date in form of a unix timestamp (as opposed to a number of days as you would do it in the offer).

### Creating a subscription without an offer

If you haven't created the offer yet, you can also create the subscription directly and have the offer be automatically generated for you. Simply leave out the offer ID and provide **amount**, **currency** and **interval** (these are mandatory if no offer is specified):

```bash
curl https://api.paymill.com/v2.1/subscriptions \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "client=client_81c8ab98a8ac5d69f749" \
  -d "payment=pay_5e078197cde8a39e4908f8aa" \
  -d "amount=3000" \
  -d "currency=EUR" \
  -d "interval=1 week,monday" \
```

<div class="info">
Instead of creating a new offer, you can also override certain attributes of an existing offer when creating a subscription. See our [API reference](/API/#create-new-subscription-) for further details.
</div>

## Controlling the runtime of a subscription

To determine when a subscription runs, you have multiple options: Control the start date, restrict it's validity, offer a trial, cancel the trial ahead of time, or pause and resume the subscription manually.

The status of a subscription is indicated by its `status` attribute:
- When the subscription is `active` it will run at the specified billing interval and create a transaction at the date announced in `next_capture_at`.
- When the subscription hasn't started yet, has been paused or has expired, it is `inactive`.

### Starting at a certain date

By default, a subscription starts right after it was created and runs the specified billing interval. To delay the start of a subscription, simply provide a **start date** when creating it:

```bash
curl https://api.paymill.com/v2.1/subscriptions \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "offer=offer_40237e20a7d5a231d99b" \
  -d "payment=pay_95ba26ba2c613ebb0ca8" \
  -d "start_at=1400575533"
```

<div class="info">
The date of next capture will automatically be calculated based on the start date and interval and can be read from `next_capture_at`.
</div>

### Stopping at a certain date

Similar to the start date, you can also restrict the **period of validity** for a subscription. When this period expires, the subscription will be stopped automatically. The field `end_of_period` will tell the calculated end date of a subscription.

In this example, we restrict the runtime of the subscription to 2 years, calculated from the start date (which can be specified separately, see above):

```bash
curl https://api.paymill.com/v2.1/subscriptions \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "offer=offer_40237e20a7d5a231d99b" \
  -d "payment=pay_95ba26ba2c613ebb0ca8" \
  -d "period_of_validity=2 YEAR"
```

### Offering/ending a trial period

You can specify a **trial period** during which the subscription runs but is not billed, either while creating the *offer* or the *subscription* (see above). In this example, we add a trial period when creating the subscription (regardless of whether the subscription plan offers one):

```bash
curl https://api.paymill.com/v2.1/subscriptions \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "offer=offer_40237e20a7d5a231d99b" \
  -d "payment=pay_95ba26ba2c613ebb0ca8" \
  -d "trial_period_days=30"
```

A trial period can be **ended** ahead of time by updating the subscription (see below) and setting `trial_end` to `true`:

```sh
curl https://api.paymill.com/v2.1/subscriptions/sub_dc180b755d10da324864 \
  -X PUT \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "offer=offer_40237e20a7d5a231d99b" \
  -d "payment=pay_95ba26ba2c613ebb0ca8" \
  -d "trial_end=true"
```

### Pausing/resuming a subscription

You might want to temporarily discontinue a subscription while it's running, but without permanently cancelling it. You can **pause** and **resume** a subscription simply by updating it and setting `pause` to `true` or `false`, respectively:

```sh
curl https://api.paymill.com/v2.1/subscriptions/sub_dc180b755d10da324864 \
  -X PUT \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "offer=offer_40237e20a7d5a231d99b" \
  -d "payment=pay_95ba26ba2c613ebb0ca8" \
  -d "pause=true"
```

## Updating a subscription

You can directly update the subscription for a specific client. For example, you can change the amount due to be charged and set the price to be valid one-time or until the end of the subscription.

```bash
curl https://api.paymill.com/v2.1/subscriptions/sub_dc180b755d10da324864 \
  -X PUT \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "offer=offer_40237e20a7d5a231d99b" \
  -d "payment=pay_95ba26ba2c613ebb0ca8" \
  -d "currency=USD" \
  -d "interval=1 month,friday" \
  -d "name=Changed Subscription" \
  -d "period_of_validity=14 MONTH" \
  -d "trial_end=false" \
```

<div class="info">
You will find more information on handling plan and amount changes, prorating and refunds in our [API reference](/API/#subscriptions).
</div>

## Cancelling or deleting a subscription

When a subscription should no longer run, you can determine whether it should just be *cancelled* it (i.e. stop the subscription but don't remove the resource) or actually *deleted* (i.e. stop the subscription and remove the resource).

Both cases use a `DELETE` request on the subscription resource and are differentiated using the `remove` parameter.

To just **cancel** the subscription, set it to `false`:

```bash
curl https://api.paymill.com/v2.1/subscriptions/sub_dc180b755d10da324864 \
  -X DELETE \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "remove=false" \
```

To actually **delete** the subscription, set it to `true`:

```bash
curl https://api.paymill.com/v2.1/subscriptions/sub_dc180b755d10da324864 \
  -X DELETE
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "remove=true" \
```

<div class="info">
More information can be found in our [API reference](/API/#cancel-or-delete-subscription-).
</div>
