---
title: "Security Standards"
menu: "Security Standards"
type: "guide"
status: "published"
menuOrder: 1
---

Security is our number one priority! If you have any questions or concerns regarding security, please contact us at [security@paymill.com](mailto:security@paymill.com).

## PCI DSS (Payment Card Industry Data Security Standard)

Any business accepting credit cards online needs to comply with the Payment Card Industry Data Security Standard (PCI DSS). PCI DSS is in place to make the internet safer and more secure by ensuring that the sensitive data of your customers is handled in a recognised and secure manner.

One of the beautiful things about PAYMILL is that we make it super easy for our merchants to be PCI DSS compliant. By using the PAYMILL Javascript Bridge, your clients' sensitive data is sent directly to PAYMILL. The sensitive data never touches your servers and this drastically reduces the scope of your compliance requirements.

While using PAYMILL you'll be PCI DSS compliant in no time! You will simply need to complete a short Self Assessment Questionnaire (SAQ). Just fill out the questionnaire, send it back and, if all is done correctly, you'll be compliant and accepting payments!

If you have any questions please send an e-mail to [security@paymill.com](mailto:security@paymill.com).

## SSL and HTTPS

We use HTTPS on all our websites. In addition, we regularely verify our security certificates and encryption algorithms.

### What exactly is SSL?

SSL is a way to securely transfer data over the Internet. It encrypts the message and confirms its integrity between server and browser.

SSL validates, if the browser is communicating with the right server - in other words, it makes sure that no one is intercepting and logging your data. PAYMILL is using SSL so that all confidential credit information is transferred securely.

### Should I use SSL on my website?

We only allow accessing our API using SSL encryption (https). It reduces the risk that some one is intercepting and logging credit card information.

We recommend that you use SSL on your domain, but it is not required. Visitors usually trust websites more that provide SSL encryption - or in other words: customers are more likely to buy from you!

### How do I implement SSL?

It should not take more than half an hour to implement SSL on your website. Generally, the price is €10 to €500 - depending on the provider and the type of certificate.

We recommend that you select a certificate from a major provider, such as VeriSign. Prices range from €30 to €100 per month. Ask your web administrator to assist you.

Also: you can always contact us. We are happy to help you in any way we can!

### Do I need SSL as the first step?

No, of course not. You can thoroughly test our website before you implement SSL. If you want to process credit card payments before you have integrated SSL on your page, make sure you host your website on a web hosting service, that can provide a secure subdomain, for example Heroku.

### So do you use SSL in your API as well?

Of course we do. We do everything to guarantee the security of all credit card information: paymill.js only works for SSL-encrypted connections. Your [Merchant Centre](http://app.paymill.com) runs on SSL as well.

## 3-D Secure

For security reasons we offer [3-D Secure](http://en.wikipedia.org/wiki/3-D_Secure) to help you avoid fraud and ensure payments. Starting 31.01.2013,
3-D Secure will be enabled by default for all compatible credit cards.

<div class="info">
  With 3-D Secure an HTTP Status 202 is returned as a reponse and you receive a forwarded link to it or a popup opens.
</div>

More on 3-D Secure can be found in our [3-D Secure Fact Sheet](https://www.paymill.com/downloads/pm_infoblatt-3DSecure-EN_130115.pdf).

## Disclosure

In case you find a bug or security issue on our website, please let us know about it as soon as possible. Please send an e-mail to [security@paymill.com](mailto:security@paymill.com) - we will reply personally within 24 hours. We would appreciate it if you would refrain from announcing any issue publicly until we have resolved it.

<div class="info">
  If you prefer to send us a secure email, you can use our PGP public key from below. This key is also available on [MIT's PGP server](http://pgp.mit.edu:11371/pks/lookup?op=vindex&search=0x48A840871C53F424).
</div>

```
------BEGIN PGP PUBLIC KEY BLOCK-----
Version: GnuPG v1.4.13 (GNU/Linux)

mQENBFD/384BCAC5w36KZEJ8cm8DeGQRpnws5JByh0Nfg6SWpRyakCq6FDr75UNL
PInQuJbKRNnM8e/ph4beWD12AgASr6Lc7iFF+vNovjRm/bhSkYy2dBdDc30uJYiV
k0srOvC8W6LSe40TFHblw9Ae1MFSvbwd0oXfliSiQp58+FnxW61JdMjELsSKekZG
GMwUiMfh6QIjgl4UQI/JyvqAKo9KJPYjex6rilPNd+V0HAel4073rGq26s59jWZb
KUd8bwcwnEbCu9AO4eFj9yHlJSRKWGfJ/zx9xTrgjDDRCMgzG0TRtC9ECBGlNtDV
TIC2GYd+6TAC81WF6n61i02u2mKx9OHjVGCvABEBAAG0PFNlY3VyaXR5IFJlc3Bv
bnNlIFRlYW0gKFBheW1pbGwgR21iSCkgPHNlY3VyaXR5QHBheW1pbGwuY29tPokB
OAQTAQIAIgUCUP/fzgIbAwYLCQgHAwIGFQgCCQoLBBYCAwECHgECF4AACgkQSKhA
hxxT9CRtLwf/cijRmC0IQEFoLaMVMkgOGwCHStC4X13PRjEBbmNbf7NcB6eP9e8C
oqFeogX4vaF4yimQHEcIiZd0O5Xe60XVuqF8KguVvLvFyGVXNfStp6Cv7v7UMgXf
wd3ZHaTSt3IHSJGRlKU12Ld/CNvFMpb+gM8x77JNkUlK0pYHHMDaE9vrPhqHExQo
JSylO+06lZqkxt5Rt2UuyGD4vUyaBCNLrVBLncSB0C7Ri1iyfBCm3XfTEk3o9S9g
WzvU9XCDHSGrk9Y7e07/iPdsLn2gvO+cOT0svxNx0msOoh2Ilvtktiq0gNqcLseC
/PI4o6wt2flSSzpJ1JegYBuFDWLF5nMaHLkBDQRQ/9/OAQgAt1xQeMnEzCq18Avp
+RvrnzUlg94DBVW40FgODKBWJH1xRcURatNpwdPqs2ZlhAW+dQJB07lcV0D+mhWG
x9QHmLKCEUzyH/4zLNXw9Cah7LIwnZI1vRj09UFP14xNYoyYXy+LP46vHTGv7+iJ
zDmGOiFmNIMeA/f8Sug/45LqwvS7BbdgDzfVLJTakU45Ok+lepKc3dhDq9IuS4X1
7wtvfCrdr05lGJVkQDQB5VsejOd+LrqIHBqxvEv04QJEMqfQJUcdUP2s/6r5P7dp
2gwOd9KCqD++CNql6rKkFwwFo8fqzgvyk1PrQEadwXWeqSG3iK5iF6qWJWnkxHBA
M+qvDwARAQABiQEfBBgBAgAJBQJQ/9/OAhsMAAoJEEioQIccU/QksioH/jeePN2b
03tjnC2SrrSg59F0/ocC2/Wf+XrKaWdXr+PLRP44RbnyxAh2rZbqYhIV5eE4RJPL
2gK095aOygWVLrLXgpQZefRjfWhSBNoVsa8DZKsL3OiEZuJMW/h+T2AYYqsS7oej
ej/epS2CxZT65KDhjswbHBWXd7HgoFhrqTssx4g5Ep4bQQeF9rYiqgAQ5F6pvyDd
p7CKS0twKMADkqccxz7D1lgM6TNAb0Q4kiMr+1tCb9WwbNUV6Uts5HNMjoA/TxUG
09Jcyv7zFG2VIsi85PRW4t6N7UdbdJGNV7hBNzaYx+rXbqRKGeeRTw/19nxmGV1k
0a1F1xKhnugDwsg=
=vguQ
-----END PGP PUBLIC KEY BLOCK-----
```

## Security community

We would like to thank the following people who helped improve the security of PAYMILL even more:

- Shahee Mirza,               [@shaheemirza](https://twitter.com/shaheemirza)
- Yaroslav Olejnik
- Atulkumar Hariba Shedage
- Nitesh Shilpkar
- Vedachala Ballal,           [@vedachalaka](https://twitter.com/vedachalaka)
- Sudhanshu Chauhan
- Harsha Vardhan Boppana
- Kamil Sevi,                 [@kamilsevi](https://twitter.com/kamilsevi)
- A.S. Javid Hussain
- Ali Hasan Ghauri
- Siddhesh Gawde,             [@pen3t3r](https://twitter.com/pen3t3r)
- Ahmad Ashraff,              [@yappare](https://twitter.com/yappare)
- Tejash Patel,               [@tejash1991](https://twitter.com/tejash1991)
- Ehraz Ahmed,                [@securityexe](https://twitter.com/securityexe)
- Umraz Ahmed,                [@umrazahmed](https://twitter.com/umrazahmed)
- Anand Meyyappan,            [@anandm47](https://twitter.com/anandm47)
- Frans Rosén,                [@detectify](https://twitter.com/detectify)
- Jigar Thakkar,              [@jigarthakkar39](https://twitter.com/jigarthakkar39)
- Muhammad Mujtaba,           [@mushti](https://twitter.com/mushti)
- Michael Blake
- Mohankumar Vengatachalam,   [@vimokumar](https://twitter.com/vimokumar)
- Shubham Raj
- Jon,                        [@Bitquark](https://twitter.com/Bitquark)
- Florian Wesch,              [@dividuum](https://twitter.com/dividuum)
- Mathias Bynens,             [@mathias](https://twitter.com/mathias)
- Tom Van Goethem,            [@tomvangoethem](https://twitter.com/tomvangoethem)
- Adam Ziaja,                 [@adamziaja](https://twitter.com/adamziaja)
- Sparsh Sharma,              [@sparsh_23june](https://twitter.com/sparsh_23june)
- Dibyendu Sikdar,            [@dibsyhex](https://twitter.com/dibsyhex)
- Rafael Pablos
- Mahipal Singh Rajpurohit,   [@rajgurumahi007](https://twitter.com/rajgurumahi007)
- Rakesh Singh,               [@zerodayguys](https://twitter.com/zerodayguys)
- Ajay Singh Negi,            [@AjaySinghNegi](https://twitter.com/AjaySinghNegi)
- S.Venkatesh,                [@pranavvenkats](https://twitter.com/pranavvenkats)
- Babar Khan Akhunzada,       [@Babar1337Khan](https://twitter.com/Babar1337Khan)
- Koutrouss Naddara
- Faisal Ahmed,               [@Faisal_GB](https://twitter.com/Faisal_GB)
- Konka Karthik
- Mazen Gamal,                [@MazenGamal](https://twitter.com/MazenGamal)
- Ranjan Kathuria,            [@kathuriaranjan](https://twitter.com/kathuriaranjan)
- Robin Tiwari
- Blindu Eusebiu,             [@testalways](https://twitter.com/testalways)
- Abdul Haq Khokhar,          [@Abdulhaqkhokhar](https://twitter.com/Abdulhaqkhokhar)
- Osama Mahmood,              [@OsamaMahmood007](https://twitter.com/OsamaMahmood007)
- Pulkit Pandey,              [@pulkitpandey92](https://twitter.com/pulkitpandey92)
- Talha Mahmood
- Hammad Mahmood
- Abdul Rehman,               [@Abdul_R3hman](https://twitter.com/Abdul_R3hman)
- Mohamed Abdelbaset Elnoby,  [@SymbianSyMoh](https://twitter.com/SymbianSyMoh)
- BALAJI P R,                 [@balag_py](https://twitter.com/balag_py)
- Hammad Qureshi,             [@TheHmadQureshi](https://twitter.com/TheHmadQureshi)
- Shahmeer Amir,              [@shahmeer_amir](https://twitter.com/shahmeer_amir)
- Syed Daniyal,               [@noob_hack](https://twitter.com/noob_hack)
- Hamid Ashraf,               [@hamihax](https://twitter.com/hamihax)
- Ramin Farajpour Cami,       [@MF4rr3ll](https://twitter.com/MF4rr3ll)
- Mohamed Chamli,             [@chamli_mohamed](https://twitter.com/chamli_mohamed)
- Roberto Zanga,              [@MindfreakS01](https://twitter.com/MindfreakS01)
- Konduru Jashwanth,          [@kondurujashwan5](https://twitter.com/kondurujashwan5)
- C Vishnu Vardhan Reddy,     [@Vishnu_dfx](https://twitter.com/Vishnu_dfx)
- Sumit Sahoo
- Bharat Sewani,              [@bharatsewani199](https://twitter.com/bharatsewani199)
- SaifAllah benMassaoud       [@benmassaou](https://twitter.com/benmassaou)
- Ahmed Adel Abdelfattah,     [@00SystemError00](https://twitter.com/00SystemError00)
- Pratap Chandra 
- Sree Visakh Jain,           [@sree_visakh](https://twitter.com/@sree_visakh)
- Ketankumar B. Godhani       [@KBGodhani](https://twitter.com/KBGodhani)
- Nikhil Mittal               [@nikhilmittal641](https://twitter.com/nikhilmittal641)
- Mansoor Gilal               [@MansoorGilal](https://twitter.com/MansoorGilal)
- Mandeep Jadon               [@1337tr0lls](https://twitter.com/1337tr0lls)
- Chirag Solanki              [@chirag77solanki](https://twitter.com/chirag77solanki)
- Muzamil Shah                [@muzamilshah254](https://twitter.com/muzamilshah254)
- Ehraz Ahmed                 [@ehrazofficial](https://twitter.com/ehrazofficial)
- Tommy DeVoss                [@thedawgyg](https://twitter.com/thedawgyg)
- Suleman Malik               [@sulemanmalik_3](https://twitter.com/sulemanmalik_3)
- Harikrishnan                [@hari_cybex](https://twitter.com/hari_cybex)
- Vismit Sudhir Rakhecha      [@rvismit](https://twitter.com/rvismit)
