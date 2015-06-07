---
title: "PCI Security"
menu: "PCI Security"
type: "guide"
status: "published"
order: 2
---

## How to become PCI-DSS compliant?

Any business involved with the processing, transmission, or storage of credit card data must comply with the Payment Card Industry Data Security Standards (PCI DSS). PCI DSS version 3.0 is in place and mandatory to all new and existing PAYMILL users.

While setting up your PAYMILL account you will be asked to fill out the [PCI](https://www.pcisecuritystandards.org/merchants/self_assessment_form.php) Self-Assessment Questionnaire (SAQ) if you are onboarded with our partner banks Acceptance or Wirecard. Your processed funds will only be settled to your bank account if you have completed your yearly PCI SAQ successfully.

## Which questionnaire will you need to complete?

### 1. SAQ A

According to the PCI Security Standards Council, you will be eligible for SAQ A if you fulfill the following requirements:

- Your company accepts only card-not-present (e-commerce or mail/telephone-order) transactions;
- All payment acceptance and processing are entirely outsourced to PCI DSS validated third-party service providers;
- Your company has no direct control of the manner in which cardholder data is captured, processed, transmitted, or stored;
- Your company does not electronically store, process, or transmit any cardholder data on your systems or premises, but relies entirely on a third party(s) to handle all these functions;
- Your company has confirmed that all third party(s) handling acceptance, storage, processing, and/or transmission of cardholder data are PCI DSS compliant; and
- Your company retains only paper reports or receipts with cardholder data, and these documents are not received electronically.

SAQ A needs to be filled once per year to confirm your PCI compliance. For more information follow the guidelines here: [SAQ A guide](https://static.paymill.com/r/a8332dcf722a7a9b4906667ae70cdb9a48126f6d/downloads/SAQ_A_guide.pdf)

### 2. SAQ A-EP

The PCI Security Standards Council has confirmed the following requirements which will make you eligible for SAQ A-EP:

- Your company accepts only e-commerce transactions;
- All processing of cardholder data is outsourced to a PCI DSS validated third-party payment processor;
- Your e-commerce website does not receive cardholder data but controls how consumers, or their cardholder data, are redirected to a PCI DSS validated third-party payment processor
- Your e-commerce website is not connected to any other systems within your environment (this can be achieved via network segmentation to isolate the website from all other systems);
- If merchant website is hosted by a third-party provider, the provider is validated to all applicable PCI DSS requirements (e.g., including PCI DSS Appendix A if the provider is a shared hosting provider);
- All elements of payment pages that are delivered to the consumer’s browser originate from either the merchant’s website or a PCI DSS compliant service provider(s);
- Your company does not electronically store, process, or transmit any cardholder data on your systems or premises, but relies entirely on a third party(s) to handle all these functions;
- Your company has confirmed that all third party(s) handling storage, processing, and/or transmission of cardholder data are PCI DSS compliant; and
- Your company retains only paper reports or receipts with cardholder data, and these documents are not received electronically.

Currently this questionnaire needs to be filled once per year by users who are activated with our partner banks Acceptance and Wirecard. Please note this version is longer than the SAQ A (139 questions) and requires you to fulfill a quarterly ASV security scan of your systems by an external PCI security company (costs apply).

For more information follow the guideline here: [SAQ A-EP guide](https://static.paymill.com/r/a8332dcf722a7a9b4906667ae70cdb9a48126f6d/downloads/SAQ_A-EP_guide.pdf).

## Would you like to be eligible for SAQ A?

Though the new PCI DSS 3.0 requirements help compliant merchants to be even more secure, we understand the additional efforts which the SAQ A-EP process brings with it. In order to make the new requirements more convenient for you, we released a new flexible solution, which is in line with the SAQ A requirements.

The following documents will guide you on how to implement and migrate to the PayFrame solution which could help you to be eligible for the SAQ A process. This solution will not compromise any of your known PAYMILL benefits like customising the look and feel of your payment form.

Guide on how to embed the PCI 3.0 PayFrame solution: [Bridge PayFrame](/guides/reference/bridge-payframe.html)

Guide on how to migrate from the old API bridge solution to the new PCI 3.0 compliant PayFrame solution: [Bridge PayFrame Migration Guide](/guides/reference/bridge-payframe-migration.html)

**Note:** if you are currently using one of the following plugins supported by PAYMILL, you will need to update to the versions stated below. Then the PayFrame will be enabled by default. The respective plugin versions will be released in the order you see below in the upcoming weeks:

- Shopware: PAYMILL plugin v1.6.0
- OpenCart: PAYMILL plugin v1.6.0
- Magento: PAYMILL plugin v3.10.0
- OXID 4.7+: PAYMILL plugin v2.8.0
- OXID 4.6: PAYMILL plugin v2.7.0
- xt:Commerce 4: PAYMILL plugin v2.9.0
- xt:Commerce 3: PAYMILL plugin v1.7.0
- PrestaShop: PAYMILL plugin v2.2.0
- Wordpress: PAYMILL plugin v1.10.0

## Want to learn more how the PAYMILL solution works within your webshop?

We have assembled how the PAYMILL solution works as part of your website. This could help you understanding the functionalities and interactions better in order to fill out the PCI SAQ. For particular questions about your website we recommend you to seek advice from your website developer or shop system. For questions around PCI DSS you can reach out to the PCI contacts of our partner banks.

- [English](https://www.paymill.com/en/faq/how-does-paymills-payframe-solution-work)
- [German](https://www.paymill.com/de/faq/wie-funktionieren-die-payframe-losungen)
- [French](https://www.paymill.com/fr/faq/comment-fonctionne-la-solution-payframe)

## Need support?

Contact the PCI support for detailed questions around PCI DSS and SAQ.

**Acceptance**

```nohighlight
Partner Bank: Acceptance
Contact: SRC GmbH (Acceptance Lufthansa AirPlus)
Phone: +49 (0) 228/2806-166 (standard call costs apply)
```

**Wirecard Bank AG**

```nohighlight
Partner Bank: Wirecard Bank AG
Contact: PCI Competence Center der usd AG
Phone: +49 6102 8631-720 (standard call costs apply)
E-Mail: support@pci.wirecardbank.com
Available Monday - Friday between 8-18h
```
