# Contributing to PAYMILL Documentation


User experience is one of our main focus at PAYMILL. Therefore we’re striving to provide you with the most clear and accurate documentation possible. We also believe that our users know best what they need.

That’s why we decided to open our documentation source so that you can help us building a better product.

Any contribution is very welcome whether you’re requesting content, spot an error, or want to publish your own guide.

## General Information

### Developers Centre

The documentation is published in the [PAYMILL Developers Centre](http://developers.paymill.com). The Developers Centre is a static website which is automatically generated from the source on a regular basis. It means that no complex CMS is involved and changing content is a matter of editing text files.

### Source

The documentation source is hosted in [GitHub](http://www.github.com). It allows everyone to easily contribute and enables an easy yet powerful publishing workflow.

A GitHub account is required to contribute. If you don’t have one yet you can [sign up here](https://github.com/join), it’s free.

### Format

This documentation is written in Markdown format which allows to  easily create content oriented documents. It’s really easy to get started with and doesn’t require any technical skill.

We’re using a Markdown version called **GitHub Flavored Markdown**. You can read more information about it [here](https://help.github.com/articles/github-flavored-markdown/).

### Folders Structure
#### API

The `API` folder contains the source files for the [PAYMILL API Reference](http://developers.paymill.com/API).

Don’t mind about the `.eco` extension at the end of the file. Our generator requires this but the documents are all regular Markdown.

Files are ordered by topic and always begin with a letter to ensure folder ordering.

#### download

The `download` folder contains downloadable files such as PDFs.

#### guides

the `guides` folder contains the source files for the [PAYMILL Guides](http://developers.paymill.com/guides).

Sub-folders correspond to the different sections. Each section has an `index.html` file which is required to enable it.

The `images` folder doesn’t correspond to a section but contains images included in guides.

### Files structure

#### API Reference files

##### Front Matter

On top of each API file you will find a front matter looking like this:

```yaml
---
title: "Introduction"
anchor: "introduction"
type: "apiDoc"
---
```

- **title** corresponds to the title of the section. It will be displayed as the section heading and as a main navigation item.
- **anchor**  is the name of the anchor. It is the hash part at the end of the URL. e.g. `#introduction` which allows scrolling to the right section directly from the URL.
- **type** indicates to the generator the type of the document. It should always be `apiDoc`.

##### Content Structure

###### Section description (optionnal)

Each section file can start with a free description helping for the understanding of the described object, endpoint …

###### Sub-section

The sub section begins with a **Level 2 headline**. If an object is described it should be surrounded by backticks.

> `## ``Payment`` object for credit card payments`

###### Right side content

Right side content such as **Examples** always come first in a sub-section.

You can set a title for the content using quoting.

`> Title`

For including a **JSON** response example use a code block, setting the code type to `json`.

<pre>
	> Example

	```json
	{
	  "id": "pay_ff7136caa965a9a4e9b3c934",~
	  "type": "paypal",~
	  "client": null,~
	  "holder": "John Doe",~
	  "account": "john.doe@example.com",~
	  "created_at": 1432647580,~
	  "updated_at": 1432647582,~
	  "app_id": null,~
	  "is_recurring": false,~
	  "is_usable_for_preauthorization": false~
	}
	```
</pre>

Code samples for the officially supported languages are included this way:

<pre>
	```bash
	curl https://api.paymill.com/v2.1/payments \
	  -u <YOUR_PRIVATE_KEY>: \
	  -d "token=098f6bcd4621d373cade4e832627b4f6"
	```

	```ruby
	<%- @partial('snippets/ruby/samples/payments/create_new_credit_card_payment_with_token.rb') %>
	```

	```java
	<%- @partial('snippets/java/samples/payments/create_new_credit_card_payment_with_token.java') %>
	```

	```javascript
	<%- @partial('snippets/js/samples/payments/create_new_credit_card_payment_with_token.js') %>
	```

	```python
	<%- @partial('snippets/python/samples/payments/create_new_credit_card_payment_with_token.py') %>
	```

	```php
	<%- @partial('snippets/php/samples/payments/create_new_credit_card_payment_with_token.php') %>
	```

	```csharp
	<%- @partial('snippets/net/samples/payments/create_new_credit_card_payment_with_token.cs') %>
	```
</pre>

	The **cURL** samples are directly included in the file. Other samples are copied from the various wrappers repositories. They all respect the same folder structure so make sure the sample is present in the corresponding repository before including it.

###### Left side content

Left side is dedicated to the description of endpoints and objects.

You can write anything for descriptions but follow the following format for attributes:

<pre>
	### Attributes

	**attribute:**             _type_  
	 Attribute description (optional)
</pre>

#### Guides

The folder structure for guides matches the one on the **Developers Centre**.

Guides have less structure constraint than the API reference but there are still a couple of rules to follow.

##### Front Matter

On top of each Guide file you will find a front matter looking like this:

```yaml
---
title: "Title"
menu: "Menu Title"
type: "guide"
status: "published"
order: 1
---
```

- **title** corresponds to the title of the guide. It will be displayed as the guide heading and slugified for the permalink.
- **menu**  is the title used in navigations.
- **type** indicates to the generator the type of the document. It should always be `guide`.
- **status** is the current status of the document. If you would like to create a guide but not display it on the Developers Centre, set the status to `draft`. Otherwise set it to `published`.
- **order** determines the position of the guide in the navigations. They are sorted in ascending order.

##### index.html files

Each subdirectory you create should contain an `index.html` file. Otherwise it won’t be shown in the navigations.

It should only contain the following front matter:

```yaml
---
title: "title"
type: "guide"
status: "published"
menuOrder: 6
---
```

##### Content

The content of the guides is regular **markdown**.

If you would like to include highlighted content you can use one of the following markups.

**simple notice**

```html
  <p class="info">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
  </p>
```

**important information**

```html
  <p class="important">
    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
  </p>
```

## Contribution ways

You can contribute to the **PAYMILL** documentation in different ways.

### GitHub Issues

GitHub Issues are a great way of giving us feedback on our documentation.

You can read a quick guide on creating issues here:

[https://help.github.com/articles/creating-an-issue/](https://help.github.com/articles/creating-an-issue/)

#### Enhancements

If you feel something is missing or would like more information on a topic you can create a new issue on the repository with the `Request` label.

Make sure to provide a clear description so we can understand your concern.

#### Mistakes

If you find some of the content is wrong like a code sample not working you can create a new issue on the repository with the `Mistake` label.

State clearly in which section you spotted the mistake and why you think it’s wrong.

### Pull Requests

If you feel comfortable with Git and know what a **pull request** is, feel free to fork the repository and submit your changes or new content directly through a **pull request**.

We will review it as soon as possible and publish it once it has been validated by a member of the authoring team.
Further discussion might happen in the comments before we approve a change.

Here is how to create a **pull request**

[https://help.github.com/articles/creating-a-pull-request/](https://help.github.com/articles/creating-a-pull-request/)

## Other Information

If you need more information about contributing to the **PAYMILL** documentation feel free to contact us at [support@paymill.com](mailto:support@paymill.com).

or directly fill an issue regarding the README file like indicated above :)

Thank you for helping us improve your experience with our products.
