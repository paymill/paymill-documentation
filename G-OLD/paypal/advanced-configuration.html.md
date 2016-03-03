---
title: "Advanced PayPal Configuration"
menuTitle: "Advanced Configuration"
type: "guide"
status: "published"
menuOrder: 6
---

The **PayPal** section in our [Merchant Centre](http://app.paymill.com) lets you provide additional configuration options for using **PayPal** with **PAYMILL**.

<p class="important">
Please read carefully below how these features work and ensure you need them, as most of them require an activation on the **PayPal** side.
</p>


## Customising PayPal Checkout

It is possible to display your own **brand name** and **header image** in the **PayPal checkout**.

1. Connect to your [Merchant Centre](http://app.paymill.com).
2. Go to *Settings* > [Payment methods](https://app.paymill.com/settings/payment-methods)
![](/guides/images/PayPal-advanced_settings-1.png)
3. In the **PayPal** section, click on the `CUSTOMISE` button.
![](/guides/images/PayPal-advanced_settings-2.png)
4. Enter your **Brand Name** and an URL to the **Header Image**. The URL **must be HTTPS** and the image be **750x90 pixels max**.
5. Save your chages.

<p class="info">
Checkout language is automatically determined by **PayPal** using the merchant's country, the buyer's address and the buyer's history of **PayPal checkouts**, profile and browser settings.
</p>

<p class="info">
You can also make the changes directly in your **PayPal account**. Hovever be aware that settings made on **PAYMILL** side **take precedence** over the settings on the **PayPal** side.
</p>

## Fetching Settlement Reports

<p class="important">
Please contact PayPal and request that feature to be enabled for you.
</p>

If **PayPal settlement reports** are available for you, they can be included in your **PAYMILL settlement report** as well. Simply create SFTP credentials and enter them in our [Merchant Centre](http://app.paymill.com):


1. Go to *Settings* > [Payment methods](https://app.paymill.com/settings/payment-methods).
	![](/guides/images/PayPal-advanced_settings-1.png)
2. Make sure your are in `live` mode.
3. In the **PayPal** section, click on the `CUSTOMISE` button.
![](/guides/images/PayPal-advanced_settings-2.png)
4. Click on `Advanced settings`.
5. Enter your SFTP credentials.
6. Save your changes. Our system will attempt a connection and warn you if the credentials don't seem to work.


We will regularly fetch your settlement reports from **PayPal** and generate a document in your [invoices section](https://app.paymill.com/invoices).

<p class="info">
To stop receiving settlement reports, simply remove your credentials from your **PAYMILL Merchant Centre**.
</p>

## Selling Digital Goods

<p class="important">
Please contact PayPal and request that feature to be enabled for you.
</p>

[PayPal Digital Goods](https://developer.paypal.com/docs/classic/products/digital-goods/) lets you sell media like news content, video, blogs, music, in-game content, virtual goods or currencies with special conditions. To take advantage of this functonnality please contact **PayPal sales** to have your account converted accordingly.

Digital Goods can easily be activated in our Merchant Centre:


1. Go to *Settings* > [Payment methods](https://app.paymill.com/settings/payment-methods).
![](/guides/images/PayPal-advanced_settings-1.png)
2. In the **PayPal** section, click on the `CUSTOMISE` button.
![](/guides/images/PayPal-advanced_settings-2.png)
4. Click on `Advanced settings`.
![](/guides/images/PayPal-advanced_settings-3.png)
5. Check the checkbox for Digital Goods.
6. Save your changes.

<p class="info">
Digital Goods can be enabled/disabled separately for your `sandbox` and `live` account.
</p>

<p class="important">
Please note that **you can't sell physical and digital goods** using the same **PayPal account**.

Digital products are also not covered by **PayPal seller protection** as it can only be applied to physical goods.
</p>
