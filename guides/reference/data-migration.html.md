---
title: "Migration to PAYMILL Made Easy"
menu: "Data Migration"
type: "guide"
status: "published"
menuOrder: 9
---

Our goal is enable you to migrate to PAYMILL as easy and fast as possible. Therefore we offer you a convenient and secure data transfer - for free.

## 1. Process description

This describes in which format the credit card information is transferred from a third PAYMENT SERVICE PROVIDER (PSP) to PAYMILL. The reason why data is moved is because a merchant is switching from his old PSP to the PAYMILL platform.

Credit card data from a third party PSP shall be imported to the PAYMILL platform. Reason is the switch of a merchant from one PSP to the PAYMILL platform. In order to enable the merchant to use the stored card information from the old PSP, the card data need to be imported to PAYMILL. The card data shall be used for a later reference of payment transactions.

### General Requirements

**File format**

  - .csv file with naming convention for the filename
  - PGP encrypted

**Data transfer**

  - via SFTP to and from PAYMILL
  - Access to the SFTP requires whitelisting of IP addresses and login data which will be secure submitted

**Data type**

  - The data import include credit/debit card data, such as card number, card expiry date, account holder (optional), etc ...
  - From this data PAYMILL generates a token (=Registration) and a payment object which will be used for later reference by the merchant.
  - The import won't include transactions histories, such as previous debits.

**Limitation for number of transaction per file**

  - There's no limitation per file.


### Clarification of terms

**Transaction types generated from the imported data**

  - From the imported data PAYMILL will generate Tokens and payment objects for credit card / debit card

**Payments**

  - Refers to the generated payment object and the Token

**Payment object**

  - The Unique payment object is automatically created by PAYMILL for each imported data.
  - The payment object on PAYMILL side will be assigned to a automatic created client object during the migration. The merchant uses the Paymill client or payment object ID for future debits which reference on the client/ payment object. That means the shopper doesn't need to enter the card details anymore, but the system will use the stored card data from the payment object
  - Each newly generated payment object from the imported data will contain the old Creditcard information of the old PSP token.


### PCI

PAYMILL ([www.paymill.com](http://www.paymill.com)) and or his TPSP is level 2 PCI certified.


## 2. Data import process

### Process description

The following steps should be followed for the import of the Migration data into the PAYMILL system.

<table>
  <thead>
    <tr>
      <th>Step</th>
      <th>Description</th>
      <th>By Whom</th>
      <th>When</th>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td>1</td>
      <td>Merchant orders data migration with PAYMILL</td>
      <td>Merchant to PAYMILL Support</td>
      <td rowspan=5>Clarification phase</td>
    </tr>

    <tr>
      <td>2</td>
      <td>Clarification with merchant/old PSP if standard data requirements can be met (see table below)</td>
      <td>PAYMILL Support with merchant/old PSP</td>
    </tr>

    <tr>
      <td>3</td>
      <td>[OPTIONAL if not default workflow - price on request] Request sample file or sample row of data format and submit to PAYMILL</td>
      <td>PAYMILL Support from old PSP/merchant</td>
    </tr>

    <tr>
      <td>4</td>
      <td>Request and submit IP addresses from old PSP for whitelisting and submit to PAYMILL and submit contact details from old PSP</td>
      <td>PAYMILL Support from old PSP/merchant</td>
    </tr>

    <tr>
      <td>5</td>
      <td>
        OPTIONAL if not default workflow - price on request] Clarify the number of card data records per file and the number of required file imports and submit information to PAYMILL.
        <br>
        DEFAULT workflow is: Default is one csv File with the following naming convention [Channel_ID]_[Special_Merchant_ID]_[Number of file].csv. This File is encrypted with a submitted PGP key.
      </td>
      <td>PAYMILL Support with old PSP/merchant</td>
    </tr>

    <tr class="even">
      <td>6</td>
      <td>Request to initiate data migration to PAYMILL by mail to [support@paymill.com](mailto:support@paymill.com)</td>
      <td>Merchant to PAYMILL Support</td>
      <td rowspan=4>Preparation phase</td>
    </tr>

    <tr class="even">
      <td>7</td>
      <td>Setup SFTP and designated folder for import and Whitelist IP addresses of third party PSP</td>
      <td>PAYMILL</td>
    </tr>

    <tr class="even">
      <td>8</td>
      <td>
        Provide SFTP access data used for the data migration and the "SpecialChannelID" is the Public Live API Key from the Live mode of the merchant (Can be seen in the My Account Area of the Merchant). Special Merchant_ID is a created and submitted ID. Submit the PGP Public Key to encrypt the CSV File.
      </td>
      <td>PAMILL Support to merchant</td>
    </tr>

    <tr class="even">
      <td>9</td>
      <td>Schedule a migration date and time</td>
      <td>Merchant to PAYMILL Support</td>
    </tr>

    <tr>
      <td>10</td>
      <td>Create the csv file with the naming conventions. Encrypt it with the Public PGP Key and move .csv file to designated SFTP folder on the agreed date and time</td>
      <td>old PSP</td>
      <td rowspan=2>Data migration phase</td>
    </tr>

    <tr>
      <td>11</td>
      <td>Fetch the .csv file decrypt it and make the migration (see the csv file definition below). Create the Payment object and Client Object.</td>
      <td>PAYMILL</td>
    </tr>

    <tr class="even">
      <td>12</td>
      <td>Generate a new csv file to match the old token to the new created payment object id and to the new created client object id.</td>
      <td>PAYMILL</td>
      <td rowspan="2">Response phase</td>
    </tr>

    <tr class="even">
      <td>13</td>
      <td>Send this .csv file to the merchant</td>
      <td>PAYMILL Support to merchant</td>
    </tr>  
  </tbody>

</table>

### Minimum data and format required for import

The third PSP should provide the data in a csv file including the following minimal values and format.

The filename should look like this format `[Channel_ID]_[Special_Merchant_ID]_[Number of file].csv`.

The **Channel_ID** is the Public LiveKey from the Merchant and can be found in the Settings of the Account in the Merchant Centre. The **Special_Merchant_ID** is an ID which is send via Mail to the PSP.


<div class="info">
  **Sample:**

  <ul>
    <li>Format expiry: mmyy</li>
    <li>Header: "cc_number", "holder", "year", "month", "ppan-Token", ... (please be sure that the fieldnumber is in increasing value!!)</li>
    <li>Example row: "4111111111111111", "Max Muster", "2017", "02", "f81ec685b368c55c6cfb8e9f69107916", ...</li>
  </ul>
</div>


<table>
  <thead>
    <tr>
      <th>Field No.</th>
      <th>Old PSP field values</th>
      <th>Field type</th>
      <th>Field format description</th>
      <th>Mandatory / Optional</th>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td>1</td>
      <td>&lt;CC_number&gt;</td>
      <td>
        Data type: Alphanumeric
        <br>
        Length: 3..64
      </td>
      <td>Card number in plain text</td>
      <td>Mandatory</td>
    </tr>

    <tr class="even">
      <td>2</td>
      <td>&lt;holder&gt;</td>
      <td>
        Data ty pe: Alpha
        <br>
        Length: 4..128
      </td>
      <td>Card holder</td>
      <td>Optional</td>
    </tr>

    <tr>
      <td>3</td>
      <td>&lt;year&gt;</td>
      <td>
        Data type: Numeric
        <br>
        Length: 4
      </td>
      <td>The expire year of the credit card (YYYY). The year of 2011 is formatted as "2011".</td>
      <td>Mandatory</td>
    </tr>

    <tr class="even">
      <td>4</td>
      <td>&lt;month&gt;</td>
      <td>
        Data type: Numeric
        <br>
        Length: 2
      </td>
      <td>The expire month of the credit card (MM) minimum two characters. E.g. the value "1" must be formatted as "01".</td>
      <td>Mandatory</td>
    </tr>

    <tr>
      <td>5</td>
      <td>&lt;PPAN-Token&gt; or any other value that includes old PSP token</td>
      <td>
        Data type: Alphanumeric
        <br>
        Length: 0..256
      </td>
      <td>Token from old PSP which will be mapped to the payment Object ID as the new "token"</td>
      <td>Mandatory</td>
    </tr>

    <tr class="even">
      <td>6</td>
      <td>&lt;brand&gt;</td>
      <td>
        Data type: Alpha
        <br>
        Length: 3..10
      </td>
      <td>Name of the credit or debit card brand. The complete list of [supported brands](https://developers.paymill.com/en/reference/data-migration/#)</td>
      <td>Optional</td>
    </tr>

    <tr>
      <td>7</td>
      <td>&lt;customer_country&gt;</td>
      <td>
        Data type: Alpha
        <br>
        Length: 2
        <br>
        Country code according to the ISO 3166-1 specification
      </td>
      <td>Country of the Shopper</td>
      <td>Optional</td>
    </tr>

    <tr class="even">
      <td>8</td>
      <td>&lt;identifier&gt;</td>
      <td>
        Data type: Alphanumeric
        <br>
        Length: 3..64
      </td>
      <td>Date or name of the file with which the transactions can be identified per file</td>
      <td>Optional</td>
    </tr>

    <tr>
      <td>9</td>
      <td>&lt;currency&gt;</td>
      <td>
        Data type: alpha
        <br>
        Length: 3
      </td>
      <td>
        Currency of the transaction Currency code according to the ISO 4217
        <br>
        Please be sure you support these currencies in the contract and they are working in live mode
      </td>
      <td>Mandatory</td>
    </tr>

    <tr class="even">
      <td>10</td>
      <td>&lt;client_object&gt;</td>
      <td>
        Data type: Alphanumeric
        <br>
        Length: 0..256
      </td>
      <td>Identifier for a client . Right now not used because clients will be created automatically in PAYMILL.</td>
      <td>Optional</td>
    </tr>
  </tbody>

</table>


### Data mapping for exported data

Is made through the old token which matches with a new Payment object id and a client object id. All Data is linked to the PAYMILL Client Object which was automatically created through the migration script and is entered in the Export csv file.


PAYMILL creates the following .csv for you to map the new payment object ID and the client object ID with the old "token". This file will be delivered to you from our PAYMILL support.

<table>
  <thead>
    <tr>
      <th>Old PSP field values</th>
      <th>Field type</th>
      <th>Field format description</th>
    </tr>
  </thead>

  <tbody>
    <tr>
      <td>&lt;PPAN-Token&gt; or any other value that includes old PSP token</td>
      <td>
        Data type: Alpha
        <br>
        Length: 0..256
      </td>
      <td>Token from old PSP which will be mapped to the payment Object ID as the new token</td>
    </tr>

    <tr class="even">
      <td>&lt;PAYMILL Payment object ID&gt;</td>
      <td>
        Data type: Alpha
        <br>
        Length: 0..256
      </td>
      <td>New Payment object ID which was created in our system for an imported token/ CC Data from the old PSP</td>
    </tr>

    <tr>
      <td>&lt;PAYMILL Client object ID&gt;</td>
      <td>
        Data type: Alphanumeric
        <br>
        Length: 0..256
      </td>
      <td>Identifier for the Client Object ID for a customer which will be created at the migration for every new payment object.</td>
    </tr>
  </tbody>
</table>

<div class="info">
  The PGP key is to encrypt your csv file which is sent to the sftp server (see table 1 row 8).
</div>

```
-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: GnuPG v1.4.12 (GNU/Linux)

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
=hani
-----END PGP PUBLIC KEY BLOCK-----
```
