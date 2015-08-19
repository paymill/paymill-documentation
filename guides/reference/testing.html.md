---
title: "Testing"
menu: "Testing"
type: "guide"
status: "published"
menuOrder: 1
---

## 1. Which credit card information should you use for testing?

In order to perform test payments, simply use the following credit card numbers.
That way nothing can go wrong. Moreover, the system won't have any difficulty accepting this format. When testing 3-D Secure payments you will get an extra password page. Please read the 3-D Secure frame carefully and enter the displayed or any custom password in the hints field.

<div class="important">
  **From August 2014**
  <br>
  only the testdata listed here will be valid. In case you have already invested test payments, please check your used data.
</div>

<div class="important">
  For all cards below you can use any three digits for the CVC.
  Please be sure to choose a future date for the credit card expiry date to avoid an error being displayed.
  Please be aware that these cards will work in test mode only.
</div>

**Without 3-D Secure**

<table style="width: 100%">
  <tr>
    <td width="30%">Visa</td>
    <td width="70%">4111111111111111</td>
  </tr>
  <tr>
    <td>Mastercard</td>
    <td>5500000000000004</td>
  </tr>
  <tr>
    <td>AmEx</td>
    <td>340000000000009</td>
  </tr>
  <tr>
    <td>JCB</td>
    <td>3530111333300000</td>
  </tr>
  <tr>
    <td>Maestro UK</td>
    <td>6759000000000000</td>
  </tr>
  <tr>
    <td>Carte Bleue</td>
    <td>4973010000000004</td>
  </tr>
  <tr>
    <td>Diners Club</td>
    <td>30000000000004</td>
  </tr>
  <tr>
    <td>Discover</td>
    <td>6011111111111117</td>
  </tr>
  <tr>
    <td>China UnionPay</td>
    <td>6240008631401148</td>
  </tr>
</table>

**With 3-D Secure**

<table style="width: 100%">
  <tr>
    <td width="30%">Visa</td>
    <td width="70%">4012888888881881</td>
  </tr>
  <tr>
    <td>Mastercard</td>
    <td>5169147129584558</td>
  </tr>
</table>

<div class="important">
  The format of tokens in live and test mode differs. In live-mode the token has a length of 32 characters, whereas in test-mode the token is shorter, can only be used once and always begins with "tok_".
</div>


### Which Direct Debit (ELV) information can be used for your tests?

<div class="important">
  Please note: Payments via Direct Debit (ELV) is currently only available for german clients.
</div>

For creating test payments use following testdata.

**Direct Debit**

<table style="width: 100%">
  <tr>
    <th >Account holder</th>
    <th >Account number</th>
    <th >Bank code</th>
  </tr>
  <tr>
    <td>Chris Hansen</td>
    <td>648489890</td>
    <td>50010517</td>
  </tr>
  <tr>
    <td>Chris Hansen</td>
    <td>12345678</td>
    <td>10000000</td>
  </tr>
</table>

**SEPA**

<table style="width: 100%">
  <tr>
    <th>Account holder</th>
    <th><a href="http://en.wikipedia.org/wiki/International_Bank_Account_Number">IBAN</a></th>
    <th><a href="http://www.experian.co.uk/payments/glossary/bic-code-%28bank-identifier-code%29.html">BIC</a></th>
  </tr>
  <tr>
    <td>Alex Tabo</td>
    <td>DE12500105170648489890</td>
    <td>BENEDEPPYYY</td>
  </tr>
  <tr>
    <td>Alex Tabo</td>
    <td>DE93100000000012345678</td>
    <td>BENEDEPPYYY</td>
  </tr>
</table>

### How do I trigger failing refunds

You cannot trigger a failing refund.


## 2. How do I debug the PAYMILL bridge?

Simply use your develop extension (Chrome Bug, Firebug, etc.) for customer debugging.


## 3. How do I test specific error codes?

Only the here listed credit card information / bank details are allowed in test mode. Usage of any other data will result this error:

`Real creditcard/bank account data prohibited in testmode: Please use only provided testdata.`

The following error codes can be returned for specific errors. Please implement an appropriate error handling, so you can deal with these errors.


### How do I test BRIDGE specific error codes?

The generic error codes, regardless of the means of payment will be returned:

- `internal_server_error` : Communication with PSP failed
- `invalid_public_key` : Invalid Public Key
- `unknown_error` : Unknown Error

The following errors can be returned in the case of credit card payment:

- `3ds_cancelled` : Password Entry of 3-D Secure password was cancelled by the user
- `field_invalid_card_number` : Missing or invalid creditcard number
- `field_invalid_card_exp_year` : Missing or invalid Expiry Year
- `field_invalid_card_exp_month` : Missing or invalid Expiry Month
- `field_invalid_card_exp` : Card is no longer valid or not anymore
- `field_invalid_card_cvc` : Invalid Checking Number
- `field_invalid_card_holder` : Invalid Cardholder
- `field_invalid_amount_int` : Invalid or missing amount for 3-D Secure
- `field_invalid_amount` : Invalid or missing amount for 3-D Secure **deprecated**, see [blog post](https://blog.paymill.com/about-rounding-floats-new-bridge-parameter)
- `field_invalid_currency` : Invalid or missing currency code for 3-D Secure

The following errors can be returned in the case of ELV-payments:

- `field_invalid_account_number` : Missing or invalid account number
- `field_invalid_account_holder` : Missing or invalid account holder
- `field_invalid_bank_code` : Missing or invalid bank code
- `field_invalid_iban` : Missing or invalid IBAN
- `field_invalid_bic` : Missing or invalid BIC

### How do I test credit card-specific error codes?

The following error codes are returned by us to live transactions. The tests in the test mode are possible with a special credit card, in which you will get back a different error depending on the input of a specific expiration date.

<div class="info">
  Please use the following credit card number: **5105105105105100** the CVV is any 3-digit number you can choose on your own. **It is important that you use only the following expiration dates of the credit card to get back the complete entry error code**.
</div>

Expiry date | Error code | Response text description
-|-|-
01/2020 | 50501 | `RESPONSE_BACKEND_TIMEOUT_ACQUIRER` <br> The interface to the acquirer does not respond, so we get no response if the transaction was completed successfully
02/2020 | 50001 | `RESPONSE_BACKEND_BLACKLISTED` <br> The credit card is on a blacklist
03/2020 | 50201 | `RESPONSE_BACKEND_ACCOUNT_BLACKLISTED` <br> This customer account is on a black list
04/2020 | 40103 | `RESPONSE_DATA_CARD_LIMIT_EXCEEDED`  <br> The credit card limit was exceeded with this transaction, or has already exceeded
05/2020 | 50102 | `RESPONSE_BACKEND_CARD_DENIED` <br> This card was rejected without reasons
06/2020 | 50103 | `RESPONSE_BACKEND_CARD_MANIPULATION` <br> This card was declined due to card manipulations
07/2020 | 40105 | `RESPONSE_DATA_CARD_EXPIRY_DATE` <br> The credit card expiration date is incorrect
08/2020 | 40101 | `RESPONSE_DATA_CARD_CVV` <br> The CVV is incorrect
09/2020 | 40100 | `RESPONSE_DATA_CARD` <br> There are problems with the credit card. Further details can not be passed
10/2020 | 40104 | `RESPONSE_DATA_CARD_INVALID` <br> The credit card is invalid
11/2020 | 50103 | `RESPONSE_BACKEND_CARD_MANIPULATION` <br> The credit card might be manipulated or stolen
12/2020 | 40001 | `RESPONSE_DATA_INVALID` <br> There is a general problem with the payment data
01/2021 | 40102 | `RESPONSE_DATA_CARD_EXPIRED` <br> The credit card expired or is not yet valid
02/2021 | 40106 | `RESPONSE_DATA_CARD_BRAND` <br> Credit card brand is required
03/2021 | 40201 | `RESPONSE_DATA_ACCOUNT_COMBINATION` <br> Mismatch with the bank account data combination
04/2021 | 50300 | `RESPONSE_BACKEND_3D` <br> There is a technical error with 3-D Secure
05/2021 | 40202 | `RESPONSE_DATA_ACCOUNT_AUTH_FAILED` <br> The user authentication failed
06/2021 | 50502 | `RESPONSE_BACKEND_TIMEOUT_RISK` <br> There is a risk management transaction timeout
07/2021 | 40301 | `RESPONSE_DATA_3D_AMOUNT_CURRENCY_MISMATCH` <br> Currency or amount mismatch
08/2021 | 40401 | `RESPONSE_DATA_INPUT_AMOUNT_TOO_LOW` <br> The amount is too low or zero
09/2021 | 40402 | `RESPONSE_DATA_INPUT_USAGE_TOO_LONG` <br> The usage field is too long
10/2021 | 40403 | `RESPONSE_DATA_INPUT_CURRENCY_NOT_ALLOWED` <br> The currency is not configured for the customer
11/2021 | 50104 | `RESPONSE_BACKEND_CARD_RESTRICTED` <br> The transaction is declined by the authorization system (card restricted by bank)
12/2021 | 50105 | `RESPONSE_BACKEND_CARD_CONFIGURATION` <br> The configuration data is invalid
01/2022 | 50600 | `RESPONSE_BACKEND_TRANSACTION_DUPLICATE` <br> Duplicate transaction
02/2022 | 50002 | `RESPONSE_BACKEND_IP_BLACKLISTED` <br> This IP Address is on a black list

You can find the complete list of error codes in the [API reference](/API). The CVC and date tests are to be disregarded as long as they have valid values (see example above).

<!-- ### How to test chargebacks?

For testing chargebacks use following credit card values

<table style="width: 100%">
  <tr>
      <td>MasterCard</td>
      <td>5105105105105100</td>
  </tr>
</table>

The following response messagess could be returned

<table style="width: 100%">
  <tr>
    <th>Expiry Date</th>
    <th>Response</th>
  </tr>
  <tr>
    <td>09/2019</td>
    <td>`STATE_CHARGEBACK_ERROR`</td>
  </tr>
  <tr>
    <td>10/2019</td>
    <td>`STATE_MISSING_TRANSACTION`</td>
  </tr>
  <tr>
    <td>11/2019</td>
    <td>`STATE_NOT_PROCESSED`</td>
  </tr>
  <tr>
    <td>12/2019</td>
    <td>`STATE_PROCESSED`</td>
  </tr>
</table> -->

## 4. How do I test webhooks?

With webhooks we give you the possibility to react automatically to certain events which happen within our system. A webhook can be set in live and testmode and is basically a URL where we send an HTTP POST request to every time one of the events attached to that webhook is triggered. Alternatively you can define an email address where we send the event's information to. You can manage your webhooks via the API as explained in our [API Reference](/API) or within the settings in your Merchant Centre.

## 5. How do I test subscriptions?

Right now you can test subscriptions in testmode only with live conditions. This means that you have to wait the set timeuntil the subscription time has been processed. Right now we cannot manually trigger the subscription.

## 6. Which PAYMILL features do I verify regarding integration in live mode?

When integrating PAYMILL, you should be sure to check the following items before switching to live mode:

- Have the test keys been exchanged with the live keys? You will find the keys in [your account](http://app.paymill.com).
- Are validation errors for the credit card correctly displayed in the ResponseHandler for the createToken function?
- A valid [token](/guides/reference/bridge.html) is transferred to us by your server.
- Confidential credit card details such as number, card validity, and the CVC are not sent to your server in the form.
- All values sent via the [payment form](/guides/introduction/payment-form.html) are valid.
- Are all API errors correctly intercepted?
