---
title: "PayPal Transactions"
menu: "PayPal Transactions"
type: "guide"
status: "published"
order: 3
---

## Initiating a PayPal transaction

PayPal transactions are initiated on your website. The customer is redirected to PayPal checkout and subsequently returned to your site where you can handle the result.

Create a checksum for the PayPal transaction in your backend:

1. Include PAYMILL JavaScript bridge (link to bridge docs?)
2. Include a “Pay with PayPal” button, only use images from  [link to PayPal logo center]
3. When button is clicked, use bridge to start PayPal checkout
4. Handling failed transaction setup
5. Provide callback to handle any errors during transaction setup (e.g. invalid data)

## Handling transaction results

After PayPal checkout, the customer is redirected to your site. Transaction result (ID, status, response code) are attached.
You can specify separate return URLs for failed and successful transactions when creating the checksum.

1. (Explain URL parameters)
2. Based on the ID you can retrieve transaction details in your backend (Provide example)
3. Handling pending payments
4. Payments can be delayed for a variety of reasons [examples]. These transactions are called “pending” and therefore have status “pending” and a response code indicating the reason [link to response codes].

Pending transactions will eventually become successful or failed. To handle the result of a pending transaction, register a webhook or email notification for the corresponding events (e.g. transaction.successful and transaction.failed [link to webhook docs]).
