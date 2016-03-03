---
title: "Check-List for Go-Live"
menu: "Check-List for Go-Live"
type: "guide"
status: "published"
menuOrder: 8
---

{>> TODO: Style the list + make dynamic checks <<}

You are almost ready to switch to live-mode and and accept payments from your customers. To ensure a smooth transition, please make sure to consider the following requirements:

- Did you switch your test keys for live keys?
- Does the amount you send to the bridge match the amount of your first transaction?
- Does the currency you send to the bridge match the currency of your first transaction?
- Do you have error handling in place to avoid missing a failed transaction?
- Did you ensure that you only offer currencies and credit card brands to your customer that are activated for your account?
- Will there be a delay between the time your customer enters his credit card data and the time his first transaction is charged?
- All done?

Congratulations, you can get started!
