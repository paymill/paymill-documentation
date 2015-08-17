---
title: "Data Export to 3rd Party PSP"
menu: "Data Export to 3rd Party PSP"
type: "guide"
status: "published"
menuOrder: 10
---

This document describes the process for a data export, which means transaction data shall be exported in a PCI compliant way and transferred to a third party system. The reason for a data export is the switch of a merchant using PAYMILL to another PSP.

## Summary

Credit card data from a merchant of PAYMILL shall be exported because the merchant has decided to switch to another PSP platform. In order to enable the merchant to continue using the stored card information for future processing, the card data needs to be exported from the PAYMILL system and must be provided to the third party Payment Service Provider system. Both the export and the hand-over of the data must be executed in a PCI compliant way.

## General requirements

**File format:**

  - At least 2 Files as .csv file (this depends on which payment methods are used by the merchant - direct debit also needs a third file)
  - File format and file content for one of the files as defined in table 2
  - File format and file content for one of the files as defined in table 3

**File name and content:**

  - All files are named in the following structure: Paymill_[special_number] - example: Paymill_ 8a89a9c73dx9f9c8xx3dce42990534h2

**Data type:**

  - The data export includes only credit card or debit card information for successful tokens/ transactions. The data export includes credit card data, such as card number, card expiry date (optional), account holder (optional), ...
  - The export does not include transaction histories, such as previous debits/ preauthorization/ reversals etc. that are connected to the token/ transactions.
  - The second file includes the internal generated token and a payment object id which the merchant got as response for the payment method.

**Data export via SFTP and Email:**

  - The data export file is submitted to PAYMILL SFTP and can optionally be sent via Mail to the 3rd Party PSP.

**File encryption:**

  - The data export is provided in zip format and password-encrypted on the SFTP via Mail.
  - The password is sent separately via email to the Third-Party PSP.

**Limitation for number of export data per file**
  - There's no limitation per file.

**Export date:**

  - Possible dates need to be requested at least 14 days in advance.
  - Exports are not possible on Fridays.

**The Third-Party PSP has to send a valid PCI certificate to PAYMILL**

## Clarification of terms

**Transactions considered for the data export:**

From the available transactions of a merchant from PAYMILL the payment methods and payment types will be considered for the export.
