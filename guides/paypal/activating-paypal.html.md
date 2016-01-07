---
title: "Activating PayPal with PAYMILL"
menuTitle: "Activating PayPal"
type: "guide"
status: "published"
menuOrder: 2
---

Before you can start accepting PayPal payments with PAYMILL you will need:

- a PAYMILL account.
- a PayPal account.
- to connect both.

## Basic Setup

### 1. PAYMILL account

If you don't have a PAYMILL account yet don't worry. Creating one is easy. The process is described in the [Getting Started](/guides/introduction/getting-started) guide.

If you need more information about how to get your PAYMILL account live, you can also go to the [Your Account](/guides/introduction/your-account) section.

### 2. PayPal account

In order to accept PayPal payments you also need a PayPal account: simply go to the PayPal website and <a href="https://www.paypal.com/webapps/mpp/product-selection" target="_blank">signup</a>

We highly recommend you to create a **business account** as some PayPal features and tariffs are not available to individual accounts.

Before you can proceed to the next step you must make sure that your PayPal account is verified. This means you need to provide all necessary information about your business to PayPal and you might also need to add (and confirm) a bank account or credit card to serve as a funding source. You can find more information about this in your **PayPal account interface**.

### 3. Connect your PayPal account to PAYMILL

The last activation step consists in connecting the two accounts:
simply go to the [Merchant Centre](http://app.paymill.com) and visit the Payment Methods page under the **Settings** section.

![PayPal Activation 1](/guides/images/PayPal-activation-1.png)

Click on the **Connect To PayPal** button under the **PayPal** section and you will be redirected to the **PayPal** login page.

<p class="important">
Your **PAYMILL Account** can be either in **Test** or **Live** mode. Please make sure which mode is active before attempting to connect your **PayPal Account**.

When in test mode you need to connect a **PayPal Sandbox** account in your **Merchant Centre**.
<br><br>
You can only use your real account in **Live Mode**.
Please see the [Your Account](/guides/introduction/your-account) section for more information about live activation.
<br><br>
You can get more information about the **PayPal Sandbox** in the [PayPal Testing](/guides/paypal/testing-with-paypal-sandbox) guide.
</p>

![PayPalActivation2](/guides/images/PayPal-activation-2.png)
*Sandbox Connected*

### 4. Done!

You can now use your **API Keys** to make PayPal transactions.

Some more configuration options are available for PayPal with PAYMILL. Please see the [Advanced Configuration](/guides/paypal/advanced-configuration) guide to learn about them.
