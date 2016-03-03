---
title: "API Libraries"
menu: "API Libraries"
type: "guide"
status: "published"
menuOrder: 1
---

We offer various libraries via our PAYMILL API. If you have programmed your own library, simply let us know by writing us at [support@paymill.com](mailto:support@paymill.com).

Have a good look at our [getting started guide](/guides/introduction/getting-started.html) and the [API reference](/API) to get started right away in your IDE.


These libraries are hosted and maintained by PAYMILL. Nevertheless we always appreciate pull requests on [GitHub](http://www.github.com/Paymill) to ensure our libraries are up to date. We greatly appreciate your input.

## Java

### Install via Maven

```xml
<dependency>
  <groupId>com.paymill</groupId>
  <artifactId>paymill-java</artifactId>
  <version>5.0.0</version>
</dependency>
```

### More information

Learn more about the Java library [here](https://developers.paymill.com/en-gb/java-wrapper-payment-library)

Read the docs and get the source code on [GitHub](https://github.com/Paymill/Paymill-Java)

---------------------

## JavaScript

### Use with node

```bash
  npm install paymill-wrapper
```

or to install it globally


```bash
  npm install -g paymill-wrapper
```

You can also add `paymill-wrapper` to your `package.json` dependecies.

Use the module with `var paymill = require("paymill-wrapper");`.


### More information

Read the docs and get the source code on [GitHub](https://github.com/paymill/paymill-js)


---------------------

## .Net

### Install with Nuget

To install Wrapper for the PAYMILL API, run the following command in the [Package Manager Console](http://docs.nuget.org/docs/start-here/using-the-package-manager-console)

```bash
PM> Install-Package PaymillWrapper
```

More info [here](https://www.nuget.org/packages/PaymillWrapper)


### Install manually

Download the lastest stable release from [https://paymill.codeplex.com/releases](https://paymill.codeplex.com/releases).


### More information

Learn more about the .Net library [here](https://developers.paymill.com/en-gb/net-wrapper-payment-library)

Read the docs and get the source code on [GitHub](https://github.com/paymill/paymill-net)


---------------------

## PHP

### Install with Composer

If you don't already use Composer, then you probably should read the installation guide [http://getcomposer.org/download](http://getcomposer.org/download).

Please include this library via Composer in your composer.json and execute `composer update` to refresh the autoload.php.

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/paymill/paymill-php"
    }
  ],
  "require": {
    "paymill/paymill": "dev-master"
  }
}
```

### Without Composer

Read the documentation [here](https://github.com/Paymill/Paymill-PHP).

### More information

Learn more about the PHP library [here](https://developers.paymill.com/en-gb/php-wrapper-payment-library)

Read the docs and get the source code on [GitHub](https://github.com/Paymill/Paymill-PHP)


---------------------

## Python

### Installation

You can either choose to install the package from PyPi executing following line:

```bash
pip install paymill-wrapper
```

Or you can check out the project, and install it locally. Navigate to the root directory and execute following line:

```bash
pip install . -r requirements.txt
```


### More information

Learn more about the Python library [here](https://paymill.com/en-gb/python-wrapper-payment-library)

Read the docs and get the source code on [GitHub](https://github.com/paymill/paymill-python)


---------------------

## Ruby

### Installation

Add this line to your application's Gemfile:

```ruby
gem 'paymill_ruby'
```

And then execute:

```bash
bundle
```


### More information

Learn more about the Ruby library [here](https://paymill.com/en-gb/ruby-wrapper-payment-library)

The PAYMILL Gem in [RubyGems](https://rubygems.org/gems/paymill_ruby)

Read the docs and get the source code on [GitHub](https://github.com/Paymill/paymill-ruby)


---------------------


## Community libraries

<div class="important">
These libraries are not hosted or maintained by PAYMILL. We cannot guarantee these libraries are up to date. Please feel free to create a pull request on [GitHub](https://github.com/Paymill) to keep the community libraries up to date.
</div>

**Closure** by [Thom Lawrence](https://github.com/hotwoofy): More information on [GitHub](https://github.com/hotwoofy/clj-paymill).

---------------------

**Codeigniter** by [Saldum](https://github.com/Saldum): More information on [GitHub](https://github.com/Saldum/Paymill-Codeigniter).

---------------------

**ColdFusion** by [Richard Herbert](http://www.cfpaymill.com): More information on [GitHub](https://github.com/richardherbert/cfPaymill).

---------------------

**Common Lisp** by [Peter Wood](https://github.com/a0-prw): More information on [GitHub](https://github.com/paymill/cl-paymill).

---------------------

**Node** by [Thomas Schaaf](https://github.com/thomaschaaf): More information on [GitHub](https://github.com/komola/paymill-node).
