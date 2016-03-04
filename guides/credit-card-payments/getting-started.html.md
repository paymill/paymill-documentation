---
title: "Getting Started With Credit Card Payments"
menuTitle: "Getting Started"
type: "guide"
status: "published"
menuOrder: 1
---

Credit Card is the primary payment method supported by PAYMILL.

You can easily offer credit and debit cards payments on your website using one of our integration methods.


<div class="important">
  The Credit Card payment method must be used beside any other payment method. You cannot use the other payment methods without using Credit Card.
</div>

## INTEGRATION METHODS

Before choosing an integration method, you should be aware of the PCI DSS 3.0 requirements. Please read the PCI Security guide to understand what are the requirements for each method.

{>> TODO: Add link to the PCI Security Guide <<}

### With the PAYMILL Bridge

The PAYMILL Bridge offers you full flexibility in your checkout design and access to the full set of features PAYMILL has to offer.

<div class="info">
Due to PCI DSS 3.0 requirements, defining a custom credit card form could mean that you need to annually fill in an extended form of self-assessment questionnaire (SAQ A-EP).
</div>

{>> TODO: Insert link to the Bridge guide and cc integration guide <<}

### With the PAYMILL Bridge PayFrame

In order to be (or stay) eligible for the simpler form of self assessment (SAQ A), you need to move all credit card data out of the scope of your website. For that purpose we offer an **iframe-based** credit card form that achieves SAQ A eligibility.

{>> TODO: Insert link to PayFrame and Bridge guide <<}
