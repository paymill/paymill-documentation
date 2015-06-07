---
title: "Risk Management"
menu: "Risk Management"
type: "guide"
status: "published"
order: 5
---

The security of your transactions is our highest priority! PAYMILL has implemented various internal and external methods of risk inspection, which check every transaction that goes though our system for suspicious behaviour. If you would further wish to disable individual methods, we will also take care of that for you. If this is the case, or if you have any questions about our security systems, please send a brief request to [support@paymill.com](mailto:support@paymill.com).

Below you will find a detailed overview of what PAYMILL does for the security of your transactions.

## 3-DS

3-D Secure is an additional layer of security that was directly developed by Visa and Master Card. It asks for further authentication within the payment process. After sending the payment transaction, your customer is asked to enter his secret PIN on a separate page, after which the final payment is authorized.

Visa's 3-D Secure system is called [Verified by Visa](http://www.visaeurope.com/en/cardholders/verified_by_visa.aspx) and Master Card calls its system [Master Card Secure](http://www.mastercard.co.uk/securecode.html).

PAYMILL enables both systems for you by default.

## 3-DS+

If, for certain reasons, the 3-D Secure server is not available for authorization (which can, for example, occur as the result of an act of nature), or if certain individual types of cards do not work with the 3-D Secure system, the risks can be further minimized through PAYMILL's 3-DS+ settings.

Your security increases in that you are not responsible for damages in cases of fraud. However, forwarding the buyer a second time usually also results in poorer conversion on your website.

For more information on the topics of liability shift ( "liability shift") and conversion, please look at our [FAQ](https://support.paymill.com/hc/).

## IP-Based Checks

Transactions coming from certain countries associated with high-risk will not be accepted. You may also designate regions and/or BIN-ranges that PAYMILL should exclude for you.

By checking every transaction against our IP black list, PAYMILL can simultaneously refuse transactions that originate from IPs suspected of fraud. By default, IPs that are known to be associated with anonymization services will also be refused.

## Black Lists

All of your transactions are compared to our extensive library of black lists. We check credit card numbers or IPs. If you would like to add a specific transaction to the black list, we will gladly take care of that for you.

## Velocity Checks

Special algorithms review all transactions for conspicuous and unusual behavior. These algorithms are based on defined rules, e.g. how many transactions are allowed in a certain period per card.

## Max/Min Amount

You can set individual maximum and minimum amounts for the acceptance of a transaction; for example, €1 - €150.

## External Risk Assessments

Below you will find a selection of external risk assessments that can be implemented upon request.

### SCHUFA

A German financial institution that collects and evaluates information regarding individual payment behavior. There are currently more than 100 million records in your database that affect more than 60 million individuals in Germany.

### InfoScore

One of the leading European service providers for the financial aspects of customer loyalty.

### DeltaVista

The Swiss market leader for the disbursement and collection of loans. Their range of services offers reliable credit ratings to companies and individuals within Switzerland.

## Device Fingerprinting

The device fingerprinting method allows for the connection of a transaction with the device from which it was initiated (e.g. the PC). This can be used to evaluate the payment behavior of a particular device over a period of time, as well as to offer real-time fraud protection.

This function is continuously being beta tested. If you are interested in participating, please contact [support@paymill.com](mailto:support@paymill.com).
