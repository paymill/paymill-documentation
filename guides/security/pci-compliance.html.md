---
title: "PCI Compliance"
menu: "PCI Compliance"
type: "guide"
status: "published"
order: 2
---

## How to become PCI-DSS compliant?

Any business involved with the processing, transmission, or storage of credit card data must comply with the Payment Card Industry Data Security Standards (PCI DSS). As of 2015 the new PCI DSS version 3.0 is mandatory and effective to all new and existing PAYMILL users.

While setting up your PAYMILL account you might be asked to fill out the PCI Self-Assessment Questionnaire (SAQ) if you are onboarded with our partner bank Acceptance or Wirecard. Since 2015 the SAQ A has been extended to an additional version for online merchants - SAQ A-EP.

Note that your processed funds will be settled to your bank account only if you have completed your yearly PCI SAQ.

## Which questionnaire will you need to complete?

### 1. SAQ A

If your credit cardholder data functions are fully outsourced to a PCI-DSS compliant provider, meaning your website incl. the payment form are hosted externally, you can complete the SAQ A questionnaire.

This questionnaire needs to be filled once per year to confirm your PCI compliance. For more information follow the guidelines here: [SAQ A guide](https://static.paymill.com/r/a8332dcf722a7a9b4906667ae70cdb9a48126f6d/downloads/SAQ_A_guide.pdf).

### 2. SAQ A-EP

If you are using a partially outsourced solution to handle cardholder data, e.g. PAYMILL direct API integration or plugins, you will fall into the new SAQ A-EP.

Currently this questionnaire needs to be filled once per year by users who are activated with our partner banks Acceptance and Wirecard. Please note this version is longer than the SAQ A (139 questions) and requires you to fulfill a quarterly ASV security scan of your systems by an external PCI security company (approx. 250€ per scan).

For more information follow the guideline here: [SAQ A-EP guide](https://static.paymill.com/r/a8332dcf722a7a9b4906667ae70cdb9a48126f6d/downloads/SAQ_A-EP_guide.pdf).

## How to avoid SAQ A-EP?

Though the new PCI DSS 3.0 guideline helps compliant merchants to be even more secure we understand the additional efforts which the SAQ A-EP process brings with it. In order to make the new requirements more convenient for you, we are working on a new solution which will allow you to fulfill all criteria for the shorter SAQ A process.

As a solution we will provide an extension to our JavaScript Bridge which will guarantee that all cardholder data is fully hosted by PAYMILL. The solution will be delivered beginning Q2 2015 for our main API which will help you smoothly pass the PCI-DSS check.

## Your PCI Support

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
