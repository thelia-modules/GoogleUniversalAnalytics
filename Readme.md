# Google Universal Analytics

This module uses the Google Measurement Protocol and add ecommerce information in your google analytics account.

It only works if you have enabled the Google Universal Analytics.

For each new order paid, the module send to Analytics a new transaction and all items attached to this transaction.

## Installation

If you are using Thelia 2.0.* please download from branch 2.0 or tag 2.0.*.

If you are using Thelia 2.1.* please download from branch master or tag 2.1.*

Following which version of the module you use, the integration is different. Read carefully the good readme.

- Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is GoogleUniversalAnalytics
- Activate it in your Thelia administration panel, then click on "configure" and enter your Analytics id (UA-XXXXX-X) and save it.

## Integration

No integration needed, the hook ```order-invoice.after-javascript-include``` is used

This script must be placed after the google analytics code.

## Usage

The ecommerce option must be activated in your view parameter in your Analytics account.