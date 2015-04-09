---
title: "Your Account"
menu: "Your Account"
type: "guide"
---

Here are a few basic features and processes that you should be familiar with before switching from test mode to live mode.

## 1. Test Mode and Live Mode

Each account has a test mode and a live mode. All API requests and API references work in both settings. Objects in live mode cannot affect objects in test mode and vice versa. In test mode, credit card transactions are not submitted for billing.

## 2. API-Keys

Each mode has its own set of public and private keys. Only the test keys can be used in test mode. Test mode and live mode each consist of 2 pairs of keys:

<p class="info">
**Public-Key:**
This key is accessible to everyone. Its purpose is to identify your account with PAYMILL. The key is represented in the form as a JavaScript variable.

**Private-Key:**
This key may not be published and is to be kept confidential. It is required on your server for communicating with the PAYMILL API. Requests are then authorized by means of the token and the private key.
</p>

## 3. Activating Your Account for Live Mode

Before activating your account, you can only work with PAYMILL in test mode and won’t be able to carry out any live transactions. The live keys will not be visible to you.

It is very easy to activate your account. You provide us some information about your product, your business and your personal relationship to the business.

Once you activate your account and we have received and validated your documents, the live keys will be generated and available to be downloaded.

As soon as you have received the keys, you will be able to carry out payment transactions directly. You will also be sent a confirmation e-mail.

## 4. 3-D Secure

We are pleased that we can offer you the safe 3-D Secure credit card payment. This relieves you from most fraud problems that may arise and ensures you your amounts paid.

We'll integrate it into PAYMILL for security reasons and will only accept payments from 01.11.2012 with 3-D Secure by default, if the card is enabled for it. For further questions about 3-D Secure please contact our Support team.

<p class="info">
When a card with 3-D Secure enabled is submitted, our Bridge will open an iframe on top of your page, so that the user can enter his verification code. For more details about it and for customization options, please see the PAYMILL Bridge documentation.
</p>

You can learn more about 3-D Secure in our FAQs.

## 5. Direct Debit (only for Germany)

The payment method Direct Debit is currently only available in Germany, the launch of SEPA in further countries is in the making, we will keep you updated on this.
