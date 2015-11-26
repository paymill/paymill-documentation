---
title: "PAYMILL Connect"
menuTitle: "Connect"
type: "guide"
status: "published"
order: 4
---

PAYMILL Connect gives a third party application the right to create transactions on hour behalf.

For example if you created a mobile application using our [Mobile SDK](/guides/integration/mobile-sdk.html) and want to allow it to create transactions directly,
Connect is the way to go.


## How does it work?

1. Send your user to PAYMILL Connect: Add the PAYMILL Connect button that brings your user to PAYMILL Connect.
2. They connect their account: Your User can Sign up for free or simply Login to their PAYMILL account.
3. We'll send them back: Now you can access the merchant's account with OAuth2



## Registering an application

For users to connect with you, you first need to create an application.

Navigate to your [Merchant Centre](http://app.paymill.com) and open the [Marketplaces > Own Apps](https://app.paymill.com/unite) page. There you can register a new application. You can create up to 10 applications in your account.

<p class="info">
As applications don't depend on the live/test mode of your account, you will see them all in both modes.
</p>


## OAuth2 Workflow

The OAuth2 workflow consists of three steps.

1. First you request an authorization from the merchant by redirecting him to PAYMILL.
2. If he grants you the requested permissions, we redirect him back to you together with an authorization code. With this code you can request an access token (which is the same as the api key in our case).
3. After you got the access token, you can execute API calls with it on the merchants account. The access token might be invalidated over time (for security reasons). If this happens you can request a new one without requesting authorization again by using refresh tokens you get together with the access token.
If an access token is not valid any more you get the following error on API-calls: `key_inactive`

### Requesting an authorization code

To request an authorization code for another merchants account, you'll have to redirect that merchant to the authorization page on our servers.

The target url for this redirect is [https://connect.paymill.com/authorize](https://connect.paymill.com/authorize) and you will need to append a few query parameters to the GET request:

- **`client_id` (required):** The App ID which you find on the App tab in your settings.
- **`response_type` (required):** fixed string set to "code".
- **`scope` (required):** a space-separated list of permissions you want to request. You get more information about permissions further down.
- **`redirect_uri` (optional):** if you set this, it is used to redirect the merchant to this uri, instead of the static redirect_uri from your App settings. This enables you to use dynamic uris, e.g. for different servers. If you use this feature it is highly recommended to use the checksum parameter too, as otherwise the service will be vulnerable to diverse attacks.
- **`custom_param` (optional):** whatever you send in this parameter will just be appended to the redirect uri, when we send the merchant back to you. This can be used together with the static redirect uri to identify the merchant, once he comes back. This string has to be url encoded.
- **`checksum` (optional):** to verify the correctness of the query string you can add the checksum parameter (see [checksum validation](#checksum-validation)).

**Example**

```
https://connect.paymill.com/authorize
    ?client_id=app_1d70acbf80c8c35ce83680715c06be0d15c06be0d
    &scope=transactions_rw%20refunds_rw
    &response_type=code
```

When the merchant is redirected back to your page, we'll append a few query parameters to the uri you provided when registering your application, depending on the outcome of the request.

If the merchant authorizes your request, the parameter code, containing your **authorization code**, is appended.

If an error occurs or if the merchant denies authorization, the parameters `error` and `error_description are appended. `error` contains an error key, `error_description` a descriptive message for that error in english. If you want to react to errors programmatically, always rely on the error key and not on the `error_description`.

**Success response**

```nohighlight
https://example.com/?code=16a892ebeb21eb286396a1962796af830cbaa3c4
```

**Error response**

```nohighlight
https://example.com/?error=access_denied&error_description=The+user+denied+access+to+your+application
```


error                       | error_description                          
----------------------------|--------------------------------------------
`access_denied`             | The user denied access to your application
`invalid_request`           | Invalid or missing response type           
`invalid_scope`             | An unsupported scope was requested         
`unsupported_response_type` | Authorization code grant type not supported


#### Checksum Validation

To verify the correctness of the query string you can add a checksum parameter.

The checksum is generated with **HMAC**. The used algorithm is **sha256** and the hash key is your **hash token**. It has to be created over the complete query string and has to be added (at the end) to the query string as the parameter checksum afterwards.

<p class="info">
  You can find the **hash token** in your application details in your [Merchant Centre](http://app.paymill.com)
</p>

**Example**

Connect URL:
```
  https://connect.paymill.com/?client_id=app_1d70acbf80c8c35ce8368ab15c06be0d15c06be0d&scope=transactions_rw%20refunds_rw&response_type=code
```

`<QUERY_STRING>`:
```nohighlight
client_id=app_1d70acbf80c8c35ce83680715c06be0d15c06be0d&scope=transactions_rw%20refunds_rw&response_type=code
```

`<HASH_TOKEN>`:
```nohighlight
f596b70540a62909a3db6be222ce10266bc07c2b529b7b34037fc60b
```

Hashing function (example in PHP)
```php
$checksum = hash_hmac('sha256', '<QUERY_STRING>', '<HASH_TOKEN>');
```

Resulting checksum:
```nohighlight
024f9d722cb8a2e9bdcaff3e732d26a2730bea1bdae5db11ad0a1f8af5bd571b
```

New connect URL with checksum:
```
https://connect.paymill.com/?client_id=app_1d70acbf80c8c35ce83680715c06be0d15c06be0d&scope=transactions_rw%20refunds_rw&response_type=code&checksum=024f9d722cb8a2e9bdcaff3e732d26a2730bea1bdae5db11ad0a1f8af5bd571b
```

<p class="important">
If you are using the optional parameters `redirect_uri` and/or `custom_param` you also need to include them into the query string to have a valid connect URL.
</p>


#### Permissions

There are 3 different permissions for each PAYMILL API endpoint:

- **Read**: read all objects from this api endpoint.
- **Write**: write objects to this api endpoint, read and edit objects written by yourself.
- **ReadWrite**: read all objects, write new objects, edit anything.

A permission is specified by the name of an api endpoint, like `transactions`, followed by an underscore, followed by `r` (read), `w` (write), or `rw` (read and write).

**Example**: `transactions_rw` (read and write transactions), `clients_r` (read clients), `refunds_w` (create new refunds).

Currently available endpoints:

- `clients`
- `offers`
- `payments`
- `preauthorizations`
- `refunds`
- `subscriptions`
- `transactions`
- `webhooks`

<p class="info">
We combine the `r` and `w` flag automatically. If you request permissions like `transactions_r` `transactions_w` then we will combine this into a single `transactions_rw`.
</p>

<p class="important">
Not all combinations of permissions do make sense. For example it is not useful to request `refunds_w` without `transaction_w` because you can not refund transactions without being able to write transactions. Which permissions are really needed completely depends on your use case. We also ask you to request only the really necessary permissions for your app.
</p>

### Creating the access token

If a merchant authorized your request you are handed an authorization code you can exchange for an access token. The access token as described in OAuth2 is a private api key to your merchants account. The api key is also equipped with the permissions you specified during the authorization request.

In order to create the access token, you have to call the access token endpoint at https://connect.paymill.com/token with a `POST` request. The request body must contain the request parameters using `application/x-www-form-urlencoded` format.

- **`client_id` (required)**: the application id you created when registering an application.
- **`client_secret` (required)**: the access key as show in your app settings. This is automatically the same value as your private api key / private test api key)
- **`grant_type` (required)**: string set to the fixed value `authorization_code`
- **`code` (required**): the authorization code retrieved earlier


<p class="important">
An authorization code expires within 30 seconds. If you don't request an access token within the time span, the code is invalidated and you'll get an error response when requesting the access token.
</p>

A successful response contains a private api key to the merchants account plus his public api key and a refresh token. If the private api key is a live key, then the response also includes the currencies and payment methods supported by the merchant. The response is sent as `application/json`:

```json
{
    "access_token": "55727e05094c17ef44649a1710b00d57",
    "expires_in": null,
    "token_type": "bearer",
    "scope": "transactions_rw refunds_rw",
    "refresh_token": "07fda540e5283039683f6400651b5eaf",
    "merchant_id": "mer_1d70acbf80c8c35ce83680715c06be0d15c06be0d",
    "is_active": true,
    "methods": ["visa", "mastercard"],
    "currencies": ["EUR", "GPB"],
    "payment_methods": [
        {
            "type": "visa",
            "currency": "EUR",
            "acquirer": "wirecard"
        },
        {
            "type": "visa",
            "currency": "GBP",
            "acquirer": "wirecard"
        },
        {
            "type": "mastercard",
            "currency": "EUR",
            "acquirer": "wirecard"
        }
    ],
    "access_keys": {
        "test": {
            "public_key": "342070708285cd3d98606d2986cb470f",
            "private_key": "4fe2b5ba56ff916eb4e644bad381e62e"
        },
        "live": {
            "public_key": "8175823c16dd0c7b222e9ea0e7352e51",
            "private_key": "55727e05094c17ef44649a1710b00d57"
        }
    },
    "livemode": true,
    "public_key": "8175823c16dd0c7b222e9ea0e7352e51",
}
```
- `access_token` is the private access key for the merchant account. If live access keys are available it's the same as live access key else same test access key.
- `expires_in` expiration timestamp. In our case this is always null. This tells that the access_key does not expire.
- `token_type` defines the token type (not important).
- `scope` the permissions connected with this access_token
- `refresh_token` is the code you need to do refresh token request.
- `merchant_id` is the unique identifier of the connected merchant.
- `is_active is true if the merchant can do live transaction with the mentioned payment_methods.
- `payment_methods` may contain a list of active payment methods which are combinations of card type, currency and acquirer:
  - `type` may contain one of the following values:
    - `visa`: Visa cards
    - `mastercard`: MasterCard cards
    - `amex`: American Express cards
    - `jcb`: JCB cards
    - `dinersclub`: DinersClub cards
    - `cup`: China UnionPay cards
    - `elv`: Direct debit (ELV, Germany only).
  - `currency` may contain every 3-letter currency code supported by PAYMILL and specified by **ISO 4217**
  - `acquirer` may contain one of our acquirers ("acceptance", "wirecard") for your payment method configuration.
- `access_keys` contains test and live keys. Live keys are available only if the connected merchant can do live transactions.
- `public_key` is the public key of the merchant. If live access keys are available it's the same as live access key else same test access key.

<p class="info">
If you request a live api key for a merchant account which can't process live transactions yet then `is_active` is false and the live section of the `access_keys` array is missing. You can always request a new api key by using the refresh token. [See Refreshing An Access Token](#refreshing-an-access-token) for details.
</p>

If something went wrong, an error response is returned as follows:

```json
{
    "error": "invalid_grant",
    "error_description": "Token is no longer valid"
}
```

**Possible errors are:**

- `invalid_request`:	Request is invalid (no POST request).
- `unsupported_grant_type`:	grant_type parameter not set to authorization_code.
- `invalid_grant`:	Authorization code is invalid or expired.
- `invalid_scope`:	The requested permissions are not a subset of the originally requested permissions.

### Refreshing an access token

Whenever requesting an access token (either by providing an authorization code or refresh token) you are given a refresh token along side with the access token. This refresh token can be used to generate a new access token at any time.

<p class="important">
Generating a new api key with an refresh token invalidates the previously generated api key. There can only be one key per authorization at any time.
</p>

Trading a refresh token for an access token works similarly as creating an access token with an authorization code: you POST a few parameters to https://connect.paymill.com/token and receive an access token response as described in [Creating the access token](#creating-the-access-token).

Possible parameters contain:
- `client_id` (required): the application id you created when [registering an application](#registering-an-application).
- `client_secret` (required): the access key as show in your app settings. This is automatically the same value as your private api key / private test api key)
- `grant_type` (required): fixed string set to refresh_token.
- `refresh_token` (required): the refresh token as given when the last access token was created.
- `scope` (optional): optional set of permissions for the new access token. Must be a subset of the originally requested permissions. Set to the **originally requested permissions** if omitted.

The response is identical to the one described in Creating the access token.

## API extensions for applications

### Collecting application fees

If creating a transaction through a merchant's PAYMILL account, you can collect a fee for this transaction by adding the `fee_amount`, `fee_payment` and optionally the `fee_currency parameter. The fee is specified in the same format as the transaction amount. The fee payment should represent a payment of the merchant which will be billed in order to collect the fee.

```bash
curl -XPOST https://api.paymill.com/v2/transactions
    -d amount=4200
    -d token=098f6bcd4621d373cade4e832627b4f6
    -d currency=EUR
    -d fee_amount=420
    -d fee_payment=pay_917018675b21ca03c4fb
    -d fee_currency=EUR
    -u <ACCESSTOKEN>:
```

This request will charge an amount of 42.00€ through the merchants account. PAYMILL will collect the default disagio and transaction fee. Your additional fee is drawn from the remaining amount.

<p class="important">
  - A merchant will receive the full transaction amount upfront. The application fee is accumulated and collected on a weekly basis and then transferred to the application.
  - The fee_amount relates to the parameter fee_currency so if fee_currency equals "USD" and fee_amount equals "100" we will charge 100 USD cents as a fee even if the transaction is in another currency.
  - If fee_currency is not set, the currency of the transaction is used. This might cause problems, if your account does not support the same currencies as your merchants accounts. Therefore we suggest to always use fee_currency.
</p>

The transaction now also contains a list of fee objects:

```json
{
    "data": {
        "id": "tran_54645bcb98ba7acfe204",
        "amount": 4200,
        ...
        "fees": [
            {
                "type": "application",
                "application": "app_1d70acbf80c8c35ce83680715c06be0d15c06be0d",
                "payment": "pay_917018675b21ca03c4fb",
                "amount": 420,
                "currency": "EUR",
                "billed_at": null
            }
        ]
    }
}
```
### Sharing payment information

When accessing our API by using an API key from your merchant, all objects which are created are also only available in this merchant account. This is not desirable for payment information as you probably wan't to store it on your own account and use it for transactions on your merchant's accounts.

In order to achieve this, you can use a payment objects and token with all merchants which are connected to your application. This is true for all API endpoints which accept a payment id or token as a POST parameter.

The general approach is as follows (for example with transactions):

1. You post a payment id as payment parameter, along with client, amount and currency to https://api.paymill.com/v2/transactions
2. We lookup the payment and client in the merchant account the used API key is valid for.
3. If the lookup fails, we look up the payment and client in the application's merchant account.
4. If this lookup fails to, we return the usual API error ("payment not found").
5. If either lookup succeeds, we use the found payment object.
6. If it's a payment object from the application's merchant account, the object is duplicated and stored with the merchant's account.
7. The transaction object is returned, containing the payment information.

The same process is true for the token parameter.


<p class="important">
As described in 6., a payment object which belongs to the application owner's account, is duplicated the first time it's used with another merchant. You therefore require the write permission in order to share payment objects. You also need the read permission in order to use a payment object from the merchant account.

So, if you intent on sharing payment information with your connected merchants, you should request read and write permissions to the payments endpoint.
</p>
