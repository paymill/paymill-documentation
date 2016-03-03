---
title: "Clients"
menu: "Clients"
type: "guide"
status: "published"
menuOrder: 5
---

A client represents your customer and links to all of their **means of payments** and **subscriptions**. Clients can be managed via our [API](/API/#clients) or the [clients](https://app.paymill.com/clients) section of our Merchant Centre.

## Creating a client

As a client is a very simple object, creating it only requires no specific details. You can add an **email address** or a **description** if applicable:

```bash
curl https://api.paymill.com/v2.1/clients \
  -u "<YOUR_PRIVATE_KEY>:" \
  -d "email=lovely-client@example.com" \
  -d "description=Lovely Client"
```

<div class="info">
You can access a client's `payment` and `subscription` list directly. To retrieve its payments, transactions, preauthorizations, or refunds, fetch the corresponding collection and use the client's `id` in the `client=<id>` filter parameter.
</div>

## Assigning a client to other resources

When creating a resource, you usually have two choices: *Specify* the client explicitly or leave it out and have it either *assigned* or *created* automatically.

Whether you create a payment, transaction, preauthorization or subscription, the rules are very simple: You can either derive it from an existing resource or create the new resource from scratch.

When **creating a resource based on an existing resource**, e.g. transaction from payment or refund from transaction, you don't need to specify the client, it will be derived from the existing resource automatically.

When **creating a new resource from scratch** without deriving it from an existing one, e.g. transaction from a token or checksum, you can optionally specify a client. When you don't specify one, it will be created automatically.
 
