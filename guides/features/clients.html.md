---
title: "Clients"
menuTitle: "Clients"
type: "guide"
status: "published"
menuOrder: 5
---

A client represents a customer and links to all of their **payment methods** and **subscriptions**.

You can use clients to link between PAYMILL and your actual customer accounts in your site or application.

Clients can be managed via our **API** or the **clients section** of our Merchant Centre.

Have a look at the [API reference][/API/index#clients] for more details on managing the clients through the API.

## CREATING A CLIENT

As a client is a very simple object, creating it requires no specific details.

Optionally, you can add an **email address** or a **description** if you wish:

```bash
  curl https://api.paymill.com/v2.1/clients \
    -u "<YOUR_PRIVATE_KEY>:" \
    -d "email=lovely-client@example.com" \
    -d "description=Lovely Client"
```

<div class="info">
  You can access a client's **payments** and **subscriptions** list directly through the `payment` and `subscription` fields directly.

  To retrieve its **payments**, **transactions**, **preauthorizations**, or **refunds**, fetch the corresponding collection and use the client's id in the `client=<id>` filter parameter.
</div>

## ASSIGNING A CLIENT TO OTHER RESOURCES

When creating a resource, you usually have two choices: Specify the client explicitly or leave it out and have it either assigned or created automatically.

Whether you create a **payment**, **transaction**, **preauthorization** or **subscription**, the rules are very simple: You can either derive it from an existing resource or create the new resource from scratch.

When **creating a resource based on an existing one**, e.g. transaction from payment or refund from transaction, you don't need to specify the client, it will be derived from the existing resource automatically.

When creating** a new resource from scratch** without deriving it from an existing one, e.g. transaction from a token or checksum, you can optionally specify a client. When you don't specify one, it will be created automatically.
