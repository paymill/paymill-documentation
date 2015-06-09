---
title: "Setting-up PayPal with PAYMILL"
menu: "Setting-up PayPal with PAYMILL"
type: "guide"
status: "published"
menuOrder: 2
---

Before you can start accepting PayPal payments through PAYMILL, you naturally need a PAYMILL account, a PayPal account and connecting the two.

## Basic setup

### 1. Set up your PayPal account

In order to accept PayPal payments you naturally need a PayPal account. We highly recommend that you create a **business** account because several PayPal features and tariffs are only available to business accounts.

Before you connect your PayPal account to PAYMILL make sure it is **verified**. This means you need to provide all necessary information about your business to PayPal and you might also need to add (and confirm) a bank account or credit card to your PayPal account to serve as a funding source.

### 2. Connect your PayPal account to PAYMILL

Before you can use your PayPal account from your PAYMILL account, you need to connect the two. Simply log into our Merchant Centre and visit the [payment methods] area. You will see a PayPal section where you can connect both your PayPal account for live transactions and a PayPal sandbox account for testing (see below).

You can now use your live or test API keys to do live or test transactions, respectively. Please see our guide on [PayPal transactions](/guides/paypal/transactions.html) for how to continue from here.

## Testing with the PayPal sandbox

The [PayPal sandbox](https://www.paypal.com/de/webapps/mpp/communication/sandbox) lets you create both merchant and buyer accounts to test PayPal checkout with arbitrary configurations (account settings, countries, currencies etc.).

To set up your PayPal sandbox, go to the [PayPal developer portal](https://developer.paypal.com/developer/accounts). Click "Log In" in the upper right corner of the screen and log in using your *real* PayPal account.  
By default, you'll see a "facilitator" account and a "buyer" account. These accounts can already be used for testing – you just need to edit the account to set a password for the first time and you're good to go.  
Alternatively you can clone existing accounts or create entirely new accounts from scratch. To learn more about managing sandbox accounts, please consult [PayPal's documentation](https://developer.paypal.com/docs/classic/lifecycle/sb_about-accounts/).

Once you're set up, you can use those sandbox accounts to test PayPal transactions:

1. Go to the PAYMILL Merchant Centre and connect a **sandbox facilitator account** in the "PayPal sandbox account" slot.
- Make sure you are using your PAYMILL test API keys in your integration.
- Start a PayPal checkout from your test system, this will send you to the PayPal sandbox checkout.
- Log in using a **sandbox buyer account** and proceed with the checkout from the buyer's perspective.

You can log into both the facilitator and buyer account as if they were real PayPal accounts by going to the [PayPal sandbox site](https://www.sandbox.paypal.com/).

<div class="info">
You can set up *customisations* separately for your live and sandbox account. This lets you test a new header image before putting it into your live checkout.
</div>

## Advanced configuration

The PayPal section in our Merchant Centre lets you provide additional configuration options for using PayPal with PAYMILL. Please make sure you understand how these features work before enabling or configuring them.

Also note that some of these features need to be activated for you by PayPal first. If you want  Please contact PayPal Merchant Technical Support (MTS) in if you're interested in using a specific feature.

### Customising PayPal checkout

You can specify your brand name and a header image to be displayed in PayPal checkout. You can either do so in your PayPal account settings or provide the brand name and header URL directly in our Merchant Centre. Please note that settings made at PAYMILL's side take precedence over the settings in your PayPal account.

<div class="important">
Your header image cannot be larger than 750x90 pixels and has to be served via HTTPS.
</div>

<div class="info">
Checkout language is automatically determined by PayPal using the merchant's country, buyer's address and the buyer's history of PayPal's checkout, profile settings and browser settings.
</div>

### Fetching settlement reports

If PayPal settlement reports are available for you, they can be included in your PAYMILL settlement report as well. Simply create SFTP credentials and enter them in our merchant center. We will regularly fetch your settlement reports from PayPal and generate a document in your [invoices section](https://app.paymill.com/invoices).

<div class="info">
If you need settlement reports from PayPal, please contact PayPal and request that feature to be enabled for you.
</div>

### Selling digital goods

==**Do you sell digital products or services?** Support for PayPal Digital Goods will be available soon.==

PayPal Digital Goods lets you sell media like news content, video, blogs, music or in-game content, virtual goods or currencies with special conditions. To take advantage of this, please contact PayPal sales to have your account converted accordingly.

<div class="info">
If you want to use Digital Goods, please contact PayPal and request that feature to be enabled for you.
</div>

<div class="important">
Please note that you can't sell physical and digital goods using the same PayPal account. Digital products are also not covered by PayPal seller protection.
</div>
