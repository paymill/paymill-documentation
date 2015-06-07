---
title: "Payment Processing"
menu: "Payment Processing"
type: "guide"
status: "published"
order: 700
---

## 1. Using the Libraries

Communicating with the PAYMILL API is based on the transfer of a token. Once you have received a token and all other details from a payment order, it goes without saying that we will make the payment transaction via PAYMILL as simple as possible.

You will need to use the [PAYMILL API](/API) in order to charge your customers.

## 2. Transferring the Data to PAYMILL and Successfully Charging the Amount

Obtain the PAYMILL Token based on the parameters transferred from your [payment form](/guides/introduction/payment-form.html) and start the payment process. In order to do this, you have to use the private key from your [Merchant Centre](http://app.paymill.com) in live mode.

```bash
curl https://api.paymill.com/v2.1/transactions \
  -u 7360a87cba3ae133e53b32fda1abe5af: \
  -d "amount=4200" \
  -d "currency=EUR" \
  -d "token=098f6bcd4621d373cade4e832627b4f6" \
  -d "description=Test Transaction"
```

<p class="important">
Take special note of the private key - which you will need to store in a safe place apart from the public key - so that you can be authorized by PAYMILL. You can find your keys for trial and live mode in the [Merchant Centre](http://app.paymill.com).
</p>

## 3. 3-D Secure

We are pleased that we can offer you the safe [3-D Secure](http://en.wikipedia.org/wiki/3-D_Secure) credit card payment. This relieves you from most fraud problems that may arise and ensures you your amounts paid.

We'll integrate it into PAYMILL for security reasons and will only accept payments from 01.11.2012 with 3-D Secure by default, if the card is enabled for it. For further questions about 3-D Secure please contact our [Support team](mailto:support@paymill.com).

<p class="info">
When a card with 3-D Secure enabled is submitted, our Bridge will open an iframe on top of your page, so that the user can enter his verification code. For more details about it and for customization options, please see the [PAYMILL Bridge documentation](/guides/reference/bridge.html).
</p>

You can learn more about 3-D Secure in our [FAQs](https://www.paymill.com/faq).

## 4. Refunding Payments

The purchaser's credit card is not charged again after the PAYMILL [subscription](/guides/introduction.subscriptions.html) has been cancelled. This also means that any additional payment charges for past purchases will normally not be refunded either.

If you would like to refund a payment, you can find each payment in your [Merchant Centre](http://app.paymill.com) and initiate a refund order there. You can find the technical details in the [API reference](/API).

Refunds can be whole or partial!

Here is the command for refunding payments:

```bash
curl https://api.paymill.com/v2.1/refunds/tran_023d3b5769321c649435 \
  -u 7360a87cba3ae133e53b32fda1abe5af: \
  -d "amount=4200"
```

## 5. Direct Debit payments and return debit

Direct Debit payments are not insured. Just 2 to 3 days after the transaction has been processed you will see in the cockpit if the money has been charged. The payment itself will be directly transfered to your account. Return debits with Direct Debit are provided as a DTAUS file to download from our system. Please find the download in our Merchant Centre. You then have to forward the file with your bank program e.g. Starmoney Business to your bank. Please ask your bank for information on how and with which software the DTAUS file needs to be forwarded to them.


**Important:** debit returns will not be listed in our system anymore as your bank handles them. So please keep track of your account activities.
