---
title: "Testing with PayPal Sandbox"
menuTitle: "Testing"
type: "guide"
status: "published"
menuOrder: 7
---

If you'd like to test your set-up, you can use the **PayPal Sandbox** with your **PAYMILL Account** in `test` mode.

The **PayPal Sandbox** is a **PayPal** account similar to your normal account except for the fact payments are never processed.

The **PayPal Sandbox** allows you to create multiple *merchant* and *buyer* accounts. This allows you to test your **PayPal Checkout** with arbitrary configurations (account settings, countries, currencies, etc).

To set up your **PayPal sandbox**, go to the [PayPal developer portal](https://developer.paypal.com/developer/accounts). Click `Log In` in the upper right corner of the screen and log in **using your real PayPal account**.

By default, you'll see a *facilitator* account and a *buyer* account.

![](/guides/images/PayPal-Testing-1.png)

These accounts can already be used for testing. You just need to edit them to set a password the first time and you're good to go.

Alternatively you can **clone existing accounts** or create **entirely new accounts** from scratch. To learn more about **managing sandbox accounts**, please consult the [PayPal documentation](https://developer.paypal.com/docs/classic/lifecycle/sb_about-accounts/).


Once you have your **test accounts** ready, you can use them to test **PayPal Checkouts**.

1. Go to the [PAYMILL Merchant Centre](http://app.paymill.com) and connect a **sandbox facilitator account**. See the [PayPal Activation guide](/guides/paypal/activating-paypal) to learn how to connect a **PayPal Account** to **PAYMILL**.
2. Make sure you are using your **PAYMILL test API keys** in your integration.
3. [Start a PayPal checkout](/guides/paypal/transactions#starting-a-paypal-payment-checkout) from your test system.
4. Log in using a **sandbox buyer account** and proceed with the checkout from the buyer's perspective.

The whole **PayPal checkout** will be identical to a real one so you can see your users experience by yourself.

<p class="info">
You can log into both the *facilitator* and *buyer* account as if they were real **PayPal accounts** by going to the [PayPal sandbox site](https://www.sandbox.paypal.com/).
</p>
