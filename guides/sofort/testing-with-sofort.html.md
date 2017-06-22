---
title: "Testing Sofort"
menuTitle: "Testing"
type: "guide"
status: "published"
menuOrder: 3
---

If you'd like to test Sofort, you can do so with Paymill Test keys!
Please be aware that when using **Test Keys** no transactions will be executed. You only simulate the behavior of our system in a live environment.

First of all, exactly as in Live mode you must create a checksum. This is done via our API and as identification your **test private API key** is required. The call looks like this:

```bash
curl https://api.paymill.com/v2.1/checksums \
  -u "<YOUR_TEST_PRIVATE_KEY>"\
  -d "checksum_type=sofort"\
  -d "amount=100"\
  -d "currency=EUR"\  
  -d "description=Test Transaction"\
  -d "first_name=Paymill"\
  -d "last_name=Test"\
  -d "street_address=Test street 123"\
  -d "postal_code=12345"\
  -d "country=DE"\
  -d "city=Munich"\
  -d "email=test@customer.de"\
  -d "return_url=https://www.example.com/store/checkout/result"\
  -d "cancel_url=https://www.example.com/store/checkout/retry"
```

The response from our side looks like this:

```JSON
{
  "data": {
    "id":"chk_9fc0af0f6107706e2d4b8d7e71b5",
    "checksum":"edc26c087697a277230539da0e89b1ab96b93bc635e980c78573de6be3041689c77401bc299aa8c98cda33abe6b097f3df009feb495b19215f407c9655401c1b",
    "data":"amount=100&currency=EUR&description=Test+Transaction&first_name=first_name=Paymill&last_name=Test&street_address=Test+street+123&postal_code=12345&country=DE&city=Munich&email=test@customer.de&return_url=https%3A%2F%2Fwww.example.com%2Fstore%2Fcheckout%2Fresult&cancel_url=https%3A%2F%2Fwww.example.com%2Fstore%2Fcheckout%2Fretry",
    "type":"sofort",
    "action": "transaction",
    "app_id":null,
    "created_at": 1496135509,
    "updated_at": 1496135509
  },
  "mode": "test"
}
```
Now you can use the bridge and the checksum to create a transaction. Please make sure you are using the checksum "id" and not the the checksum "data", when calling the following JS bridge function:

```Javascript
paymill.createTransaction({
  checksum: 'chk_9fc0af0f6107706e2d4b8d7e71b5'
}, function(error) {
  if (error) {
    // Payment setup failed, handle error and try again.
    console.log(error);
  }
});
```

Once you call this function, our JS Bridge will recognize the type of the checksum and create the transaction. You will be redirected to our test page. This page is only meant to serve as a Test environment.
The page looks like this:

![](/guides/images/Sofort-Test-Mode.png)

Clicking on the "Log In" button will redirect you to your **return_url**, that you have specified in the checksum.
Clicking on the "Terminate Session" will redirect you to the **cancel_url** you specified previously in the checksum.
This page shows you a mockup of what your customers will see when they get redirected to **Sofort**.
You do not have to store the *Sofort transaction ID*, as we will show this to you in the PAYMILL Merchant Centre und the transaction details.
