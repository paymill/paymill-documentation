---
title: "HOW TO SET UP PAYPAL WITH PAYMILL"
menuTitle: "Getting Started"
type: "guide"
status: "published"
menuOrder: 1
---

Through PAYMILL’s API you can now easily integrate PayPal payments into your existing checkout.

Getting started is very simple. But first, you need to decide which setup is best for your needs:

- Got a shopping cart and would like your customers to checkout with PayPal? [Create PayPal transactions](#paypal-transactions)

- Want to enable a faster checkout experience by securely storing your customers’ PayPal account details for future purchases? [Create a reusable Payment Object](#reusable-paypal-payment)

- Need to setup subscriptions with recurring payments? [PayPal Subscriptions](#subscriptions-with-paypal)


## PayPal Transactions

1. Create a [PAYMILL account](/guides/paypal/activating-paypal#1-paymill-account)
2. Create a [PayPal Business account](/guides/paypal/activating-paypal#2-paypal-account)
3. [Connect](/guides/paypal/activating-paypal#3-connect-your-paypal-account-to-paymill) your PayPal and PAYMILL account
4. [Add](/guides/paypal/transactions) a PayPal button to your checkout
5. Create a [Transaction Checksum](/guides/paypal/transactions#creating-a-checksum)
6. Start the [PayPal Checkout](/guides/paypal/transactions#starting-a-paypal-payment-checkout)
7. Handle the [results](/guides/paypal/transactions#handling-transaction-results) / [cancellation](/guides/paypal/transactions#handling-canceled-payments)

## Reusable PayPal Payment

1. Create a [PAYMILL account](/guides/paypal/activating-paypal#1-paymill-account)
2. Create a [PayPal Business account](/guides/paypal/activating-paypal#2-paypal-account)
3. [Connect](/guides/paypal/activating-paypal#3-connect-your-paypal-account-to-paymill) your PayPal and PAYMILL account
4. [Add](/guides/paypal/transactions) a PayPal button to your checkout
5. [Create](/guides/paypal/payment-method#setting-up-a-paypal-payment-checkout) a Payment Checksum
6. Create a reusable [PayPal Payment](/guides/paypal/payment-method#to-create-a-reusable-payment-without-a-transaction-)
7. Start the [PayPal Checkout](/guides/paypal/payment-method#starting-a-paypal-payment-checkout)
8. Handle the [results](/guides/paypal/payment-method#handling-payment-results) / [cancellation](/guides/paypal/payment-method#handling-canceled-payments)

## Subscriptions with PayPal

1. Create a [PAYMILL account](/guides/paypal/activating-paypal#1-paymill-account)
2. Create a [PayPal Business account](/guides/paypal/activating-paypal#2-paypal-account)
3. [Connect](/guides/paypal/activating-paypal#3-connect-your-paypal-account-to-paymill) your PayPal and PAYMILL account
4. Create a reusable [PayPal Payment](/guides/paypal/payment-method#to-create-a-reusable-payment-without-a-transaction-)
5. Set-up the [PayPal Subscription](/guides/paypal/subscriptions#setting-up-a-subscription-based-on-paypal)
