---
title: "Mobile SDK"
menu: "Mobile SDK"
type: "guide"
status: "published"
menuOrder: 2
---


The SDKs enable you to integrate payments quickly, securely, simply and individually into your mobile application. Following our guidelines makes credit card information handling and PCI-DSS compliance super easy.

**General**

- Maximum security - Highly encrypted communication protects your customer data
- Simplicity - Project integration and PCI-DSS compliance as easy as it gets
- Native User Experience - no html, no redirects
- No restrictions - fully customizable checkout experience

**Developers**

- Simple project integration
- No dependencies
- Simple API
- Fully functional open source payment screens
- Simple device and reliability handling


<div class="important">
  <div class="row">
    <p class="col-lg-8">
      Install the Mobile App to create transactions and preauthorizations directly from the SDK.
    </p>
    <a href="https://developers-v1.paymill.com/en/mobile-app-install/" target="_blank" class="btn btn-medium btn-primary col-lg-4">Install the Mobile App</a>
  </div>  
</div>


<div class="important">
The SDKs are suitable for purchasing both physical and virtual goods. However, we strongly recommend you to check if your target platform / distribution channel / marketplace allows alternative payment methods for virtual goods.
<br><br>
The SDK is not intended to be used for mobile POS solutions. If you plan to use the SDK this way, you should first consult with the PCI Security Standards Council.
</div>


## Integration

We deliver the SDKs in the most convenient way for you - a framework with a bundle for iOS and a jar file for Android.

- Just drop them into your project
- No external dependencies are included or required

For details how to integrate the SDK with a particular IDE or build system and OS requirements, please check the SDK documentation for each platform:


<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#integration-ios" role="tab" data-toggle="tab">iOS</a></li>
  <li><a href="#integration-android" role="tab" data-toggle="tab">Android</a></li>
</ul>


<div class="tab-content">
  <div class="tab-pane active" id="integration-ios">
    <ul>
      <li>Tested with iOS versions 6 to 8.3</li>
      <li><a href="https://github.com/paymill/paymill-ios/releases">SDK</a></li>
      <li><a href="https://github.com/paymill/paymill-ios/tree/master/samples/vouchermill">Sample App</a></li>
      <li><a href="https://github.com/paymill/paymill-example-ios-parse-honeystore">App integration HowTo</a></li>
      <li><a href="http://paymill.github.io/paymill-ios/docs/sdk">Documentation</a></li>
    </ul>
  </div>

  <div class="tab-pane" id="integration-android">
    <ul>
      <li>Tested with Android versions 2.2 (API 8) to 4.2</li>
      <li><a href="https://github.com/paymill/paymill-android/releases">SDK</a></li>
      <li><a href="https://github.com/paymill/paymill-android/tree/master/samples/vouchermill">Sample App</a></li>
      <li><a href="http://paymill.github.io/paymill-android/docs/sdk/">Documentation</a></li>
    </ul>
  </div>
</div>

## Generating a token

After successfully integrating the SDK, the most common and reliable way to integrate payments into your app is to generate a token and afterwards process transactions, preauthorizations and subscriptions from your backend. If you are not familiar with the payment token itself from PAYMILL, please check the [documentation of the JS-Bridge](/guides/reference/bridge.html).

In order to generate a token you need a PMParams and a PMMethod object. Both objects should always be created from the PMFactory class. The PMParams object represents the information about the order - description, amount and currency. A PMMethod represents the customer's credit or debit card information. You simply call the PMManager asynchronous method generateToken with both objects, the mode (live or test) and the according public key. In the callback you will receive either the token as a string or - if an error occurs - a PMError that contains additional information about the failure.




<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#token-ios" role="tab" data-toggle="tab">iOS</a></li>
  <li><a href="#token-android" role="tab" data-toggle="tab">Android</a></li>
</ul>


<div class="tab-content">
<div class="tab-pane active" id="token-ios">
<pre>
```
//locals
PMError *error;
PMPaymentParams *params;

// the payment method ( cc or dd data)
id<PMPaymentMethod> method = [PMFactory genCardPaymentWithAccHolder:@"Max Mustermann" cardNumber:@"4111111111111111" expiryMonth:@"12" expiryYear:@"2015" verification:@"1234" error:&error];

if(!error) {
  // the payment parameters (currency, amount, description)
  params =  [PMFactory genPaymentParamsWithCurrency:@"EUR" amount:100 description:nil error:&error];
}
else {
  //handle validation error
  NSLog(@"PM Error:%@", error.message);
}
if(!error) {
[PMManager generateTokenWithMethod:method parameters:params success:^(NSString *token) {
    // transaction successfully created
    NSLog(@"PM Token:%@", token);
  } failure:^(PMError *error) {
    // transaction creation failed
    NSLog(@"PM Error:%@", error.message);
  }];
}
else {
  //handle validation error
  NSLog(@"PM Error:%@", error.message);
}
```</pre>
</div>

<div class="tab-pane" id="token-android">
<pre>
```
protected void onCreate(Bundle savedInstanceState) {
  super.onCreate(savedInstanceState);
  PMManager.addListener(listener);
}

PMGenerateTokenListener listener = new PMGenerateTokenListener() {
  public void onGenerateTokenFailed(PMError error) {
    Log.e("PM", "Error:" + error.toString());
  }

  public void onGenerateToken(String token) {
    Log.d("PM", "Token:" + token);
  }
};

public void test() {
  // the payment method ( cc or dd data)
  PMPaymentMethod method = PMFactory.genCardPayment("Max Mustermann", "4111111111111111", "12", "2015", "1234");
  // the payment parameters (currency, amount, description)
  PMPaymentParams params = PMFactory.genPaymentParams("EUR", 100, null);
  PMManager.generateToken(getApplicationContext(), method, params, PMService.ServiceMode.TEST, "yourpublickey");
}

protected void onDestroy() {
  super.onDestroy();
  PMManager.removeListener(listener);
}
```</pre>
</div>
</div>

<div class="info">
  You can find your public keys under "My Account / Settings / API Keys".
</div>

Once you have successfully retrieved the payment token, you can send it to your backend. From there you can directly access our API and use all of its features.

<div class="important">
  Please consider using a secure channel like SSL to transfer the tokens.
</div>


## The payment screens

When we say no restrictions, we really mean it. You are free to design your own credit / debit card form and integrate it into your app, wherever you feel is right.

![mobile sceeens](/guides/images/mobile_sdk-01.png)

Not only this, we also provide you with a fully functional, easy to integrate and easy to style, open source example of a payment screen through our sample app. You can copy the screen into your project, style it and use it like presented in the code samples below. If you have a completely different idea of a payment screen, you might still consider using the card validation functions, as implementing them is a very time consuming task.

<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#screens-ios" role="tab" data-toggle="tab">iOS</a></li>
  <li><a href="#screens-android" role="tab" data-toggle="tab">Android</a></li>
</ul>


<div class="tab-content">
<div class="tab-pane active" id="screens-ios">
<pre>
```
//locals
PMError *error;
PMPaymentParams *params;
// the payment parameters (currency, amount, description)
params =  [PMFactory genPaymentParamsWithCurrency:@"EUR" amount:100 description:nil error:&error];
if(!error) {
  PMPaymentViewSettings *pmViewSettings = [[PMPaymentViewSettings alloc] init];
  pmViewSettings.pm_action = TOKEN;
  pmViewSettings.pm_types = ALL;

  PMPaymentViewController *paymentVC = [PMPaymentViewController createWithParams:params publicKey:@"" paymentViewSettings:pmViewSettings styleSettings:nil modalTransitionStyle:UIModalTransitionStyleCoverVertical success:^(id result) {
    //success
    NSLog(@"PM Token:%@", ((NSString *)result));
  } failure:^(PMError * error) {
    //failure
    NSLog(@"PM Error:%@", error.message);

  }
} else {
  //handle validation error
  NSLog(@"PM Error:%@", error.message);
}
```</pre>
</div>

<div class="tab-pane" id="screens-android">
<pre>
```
public void test() {
  // the payment parameters (currency, amount, description)
  PMPaymentParams params = PMFactory.genPaymentParams("EUR", 100, null);
  // create the intent and start the activity.
  Intent i = PMActivity.Factory.getTokenIntent(getApplicationContext(), params, PMService.ServiceMode.TEST, "yourpublickey");
  startActivityForResult(i, PMActivity.REQUEST_CODE);
}

public void onActivityResult(int requestCode, int resultCode, Intent data) {
  PMActivity.Result result = PMActivity.Factory.getResultFrom( requestCode, resultCode, data);
  if (result == null) {
    // this is not the result we were looking for
    return;
  } else {
    if (result.isCanceled()) {
      // payment screen was canceled
      Log.d("PM", "Payment screen was canceled");
    } else if (result.isError()) {
      // payment screen error
      Log.d("PM", "Error:" + result.getError().toString());
    } else {
      // success
      Log.d("PM", "Token:" + result.getResultToken());
    }
  }
}
```</pre>
</div>
</div>

## Creating transactions and preauthorizations

In some cases, the integration using the token generation will require a lot of extra effort to implement in your backend and app-to-backend communication. Or you might not even have a dedicated backend. Either way: we got you covered. The SDK allows you to trigger transactions and preauthorizations directly from the app and it is very simple.


<div class="important">
  <div class="row">
    <p class="col-lg-8">
      Install the Mobile App to create transactions and preauthorizations directly from the SDK.
    </p>
    <a href="https://paymill.com/mobile-app-install" target="_blank" class="btn btn-medium btn-primary col-lg-4">Install the Mobile App</a>
  </div>  
</div>

First, you need to initialize the SDK with a mode (test or live) and the according public key. If the init is successful, you can proceed and call all methods in the PMManager. We recommend you to init as soon as possible in your app. The SDK will only use resources, when it processes a request.

After you have initialized the SDK you can create a transaction with a token you previously generated (note, that you need to use the same amount and currency for the transaction to succeed). Another approach is to directly trigger the transaction using a PMParams and a PMMethod objects. As with the token generation these are the details about your transaction (amount, currency, description) and the payment method (credit or debit card data) respectively. You will receive a Transaction object or a PMError in case of failure.

<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#transactions-ios" role="tab" data-toggle="tab">iOS</a></li>
  <li><a href="#transactions-android" role="tab" data-toggle="tab">Android</a></li>
</ul>


<div class="tab-content">
<div class="tab-pane active" id="transactions-ios">
<pre>
```
//locals
PMError *error;
PMPaymentParams *params;

// the payment method (cc or dd data)
id<PMPaymentMethod> method = [PMFactory genCardPaymentWithAccHolder:@"Max Mustermann" cardNumber:@"4111111111111111" expiryMonth:@"12" expiryYear:@"2015" verification:@"1234" error:&error];

if(!error) {
  // the payment parameters (currency, amount, description)
  params =  [PMFactory genPaymentParamsWithCurrency:@"EUR" amount:100 description:nil error:&error];
} else {
  //handle validation error
  NSLog(@"PM Error:%@", error.message);
}
if(!error) {
  [PMManager transactionWithMethod:method parameters:params consumable:NO success:^(PMTransaction *transaction) {
  // transaction successfully created
  NSLog(@"PM Transaction:%@", transaction.id);
}
failure:^(PMError *error) {
  // transaction creation failed
  NSLog(@"PM Error:%@", error.message);
  }];
} else {
  //handle validation error
  NSLog(@"PM Error:%@", error.message);
}

```</pre>
</div>

<div class="tab-pane" id="transactions-android">
<pre>
```
// init the sdk as soon as possible
PMManager.init(getApplicationContext(), PMService.ServiceMode.TEST, "yourpublickey",null, null);
......
protected void onCreate(Bundle savedInstanceState) {
  super.onCreate(savedInstanceState);
  PMManager.addListener(listener);
}
PMTransListener listener= new PMTransListener() {
  public void onTransactionFailed(PMError error) {
    Log.e("PM", "Error:" + error.toString());
  }

  public void onTransaction(Transaction transaction) {
    Log.d("PM", "Transaction:" + transaction.getId());
  }
};
public void test() {
  // the payment method ( cc or dd data)
  PMPaymentMethod method = PMFactory.genCardPayment("Max Mustermann", "4111111111111111", "12", "2015", "1234");
  // the payment parameters (currency, amount, description)
  PMPaymentParams params = PMFactory.genPaymentParams("EUR", 100, null);
  // add the listener
  PMManager.addListener(listener);
  // trigger the transaction
  PMManager.transaction(getApplicationContext(), method, params, false);
}
protected void onDestroy() {
  super.onDestroy();
  PMManager.removeListener(listener);
}
```</pre>
</div>
</div>

<div class="important">
  When you create transactions from within your app, you should always use some form of external validation, if possible. For example, a transaction detail call to our API from a system in your control.
  <br><br>
  Creating preauthorizations is identical to creating transactions. Please note, that our API does not support descriptions for preauthorizations, so this parameter will be ignored.
</div>

## Error handling

There are many things that can go wrong, while processing transactions. Your app or even the operating system may crash, the device may lose network connectivity or run out of battery. We use a very simple, yet powerful approach to help you deal with these situations. We simply mark each transaction with a "consumed" flag on our servers and let you retrieve a list of all "not yet consumed" transactions. There are two things that you have to implement to make use of this feature.

First, when you create transactions you have to set the Boolean flag "consumable" to true. When you receive the result and process it successfully, you have to call the consume method with the ID of the transaction.

The second part is a recovery routine, that you need to call every time you think, that your app might be recovering from an error - for example at application start or when the device reconnects to the network. The routine should look similar to the pseudo-code below:

```
for (transaction in not-consumed-transactions) {
  if (!isDoneProcessing(transaction)  {
    startOrResumeProcessing(transaction);
    // this should start (or resume) your own processing of transactions
  }
  markConsumed(transaction);
}
```

Let's consider the three possible time spans, when something can interrupt the normal transaction process and how your recovery routine will deal with it.

1. The initial transaction request never reaches our servers. This situation is not critical, as you neither have consumed the transaction, nor charged the user.

2. The transaction reaches our servers, but you either don't receive the result or start processing the transaction, but not finish (entirely). This means you have charged the user, but you have not (fully) delivered the purchased item. In that case, the transaction will appear in the list of not consumed transaction. The recovery routine will (re)start the processing and in the end - mark the transaction consumed.

3. You have fully processed the transaction, but the "consumption" request never reaches our servers and the transaction is thus still marked not consumed. This case is also important, as you don't want your app to process the transaction more than once. To prevent that, the recovery routine first checks if the given transaction is already processed, and if so just proceeds with consuming it.


Following is the recovery routine from our sample application. In this case we process the transaction by simply saving it to a local database on the device.

<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#errors-ios" role="tab" data-toggle="tab">iOS</a></li>
  <li><a href="#errors-android" role="tab" data-toggle="tab">Android</a></li>
</ul>


<div class="tab-content">
<div class="tab-pane active" id="errors-ios">
<pre>
```
//locals
NSError *error = nil;
//fetch request initialization
NSManagedObjectContext *context = [self managedObjectContext];
NSFetchRequest *fetchRequest = [[NSFetchRequest alloc] init];
NSEntityDescription *entity = [NSEntityDescription entityForName:@"Voucher" inManagedObjectContext:context];
[fetchRequest setEntity:entity];
NSPredicate *voucherPredicate = [NPredicate predicateWithFormat:@"(transactionId == %@)", transaction.id];
[fetchRequest setPredicate:productPredicate]
// lookup the voucher with the transaction id in the db
NSArray *fetchedObjects = [context executeFetchRequest:fetchRequest error:&error];
if(fetchedObjects == nil) {
  //handle error
}
// we have not yet saved this transaction
else if(fetchedObjects.count == 0) {
  NSManagedObject *record = [NSEntityDescription insertNewObjectForEntityForName:@"Voucher" inManagedObjectContext:context];
  [record setValue:transaction.id forKey:@"transactionId"];
  ...
  if( ! [context save:&error] ) {
    //we couldn't save the voucher in DB
  }
}
// either way we now have to consume the transaction...
if(!error) {
  [PMManager consumeTransactionForId:transaction.id success:^(NSString *id){
    NSLog(@"PM Transaction consumed: %@", id);
  }
  failure:^(PMError *error) {
    NSLog(@"PM Error: %@", error.message);
  }];
}
```</pre>
</div>

<div class="tab-pane" id="errors-android">
<pre>
```
private void createOrRecoverTransaction(Transaction transaction)
throws Exception {
  // lookup the voucher with the transaction id in the db
  VouchersDbAdapter dbHelper = new VouchersDbAdapter(context);
  dbHelper.open();
  Cursor cursor = dbHelper.fetchVoucher(transaction.getId());
  // we have not yet saved this transaction
  if (cursor == null) {
    // Lets see if the description is ok
    Voucher create = Voucher.fromTransaction(transaction);
    dbHelper.createVoucher(create);
  }
  // either way we now have to consume the transaction...
  PMManager.consumeTransaction(context, transaction);
}
```</pre>
</div>
</div>

## Lists and the device ID

Sometimes it is useful to retrieve a list of the transactions and preauthorizations that you created. However, you probably don't want to have access to all ever created transactions with your merchant account, but just the ones created from the same device / app installation. The SDK handles this automatically for you.

The first time you init it, a unique device id for the app installation is generated by the server and persisted on the device. This id is always transmitted, when you create transactions or preauthorizations.


<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#lists-ios" role="tab" data-toggle="tab">iOS</a></li>
  <li><a href="#lists-android" role="tab" data-toggle="tab">Android</a></li>
</ul>


<div class="tab-content">
<div class="tab-pane active" id="lists-ios">
<pre>
```
[PMManager getTransactionsList:^(NSArray *transactions) {
  //success
  NSLog(@"PM Transactions count:%d", transactions.count);
} failure:^(PMError *error) {
  //failure
  NSLog(@"PM Error:%@", error.message);
}];
```</pre>
</div>

<div class="tab-pane" id="lists-android">
<pre>
```
// init the sdk as soon as possible
PMManager.init(getApplicationContext(), PMService.ServiceMode.TEST,
"yourpublickey",null, null);
......
protected void onCreate(Bundle savedInstanceState) {
  super.onCreate(savedInstanceState);
  PMManager.addListener(listener);
}

PMListTransListener listener = new PMListTransListener() {
  @Override
  public void onListTransactionsFailed(PMError error) {
    Log.e("PM", "Error:" + error.toString());
  }

  @Override
  public void onListTransactions(Collection<Transaction> transactions) {
    Log.d("PM", transactions.size()+" transactions available.");
  }
};

public void test() {
  PMManager.listTransactions(getApplicationContext());
}

@Override
protected void onDestroy() {
  super.onDestroy();
  PMManager.removeListener(listener);
}
```</pre>
</div>
</div>

<div class="important">
  We use the term "app installation" because we don't use an actual device identifier, but simply persist a random generated id. If the app is reinstalled, the persisted id will be lost and a new one will be generated.
</div>

## Going live

Before going live, you need to activate your account. Please make sure that you disable the 3-D Secure request in your activation form. If your account has already been activated, please contact [support@paymill.com](mailto:support@paymill.com) and request to disable 3-D Secure, because you want to use the mobile SDK. This is required, as 3-D Secure does not work on mobile devices yet.
