---
title: "Alerting"
menu: "Alerting"
type: "guide"
status: "draft"
order: 2
---

Full transparency of all transactions


## What is PAYMILL Alerting?

PAYMILL Alerting is a new add-on that will send you and your customer a notification by email for every transaction and any change in its status.

**PAYMILL Alerting can send notifications for the following transactions and status changes (successful/failed):**

- Transactions
- Subscriptions
- Refunds
- Chargebacks

The notification will contain all payment information of the customer (e.g. customer name, payment amount)

![notifications](/guides/images/alerting-01.png)

## Your benefits of PAYMILL Alerting

- Easy and fast control mechanism of all your transaction - full transparency is provided
- Convenient way to archive payments, without having to cancel invoice documents
- Safe protection against fraud - you will be informed immediately if a payment is cancelled or refunded

## Add PAYMILL Alerting to your PAYMILL account

Create webhooks manually or automatically via [Invoicing Setup Application](https://udx.paymill.de/?locale=en) to generate PAYMILL Alerting

You have to encode your merchant information to your URL when creating the webhook. Please provide the following parameters and make sure that they are URL- encoded:

Paramater | Description
----------|-----------------------------------------------------------------------------------
email     | Enter the email address that you want to use to receive notifications from PAYMILL
name      | Enter the name of your company / shop
address   | Enter the adress of your company / shop. Spearate each address line by a comma


Exchange the example data with your URL-encoded data (Before activating PAYMILL Alerting please make sure to add the required data like name, address, VAT-ID etc. to your clients description field)

```nohighlight
http://udx.paymill.de/notify?name=Apple%20Store&email=daniel.florey%40gmail.com&address=Jungfernstieg%2012%2C20354%20Hamburg%2CDeutschland
```
