# Google Universal Analytics

This module uses the Google Measurement Protocol and add ecommerce information in your google analytics account.

It only works if you have enabled the Google Universal Analytics.

For each new order paid, the module send to Analytics a new transaction and all items attached to this transaction.

## Installation

- Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is GoogleUniversalAnalytics
- Activate it in your Thelia administration panel, then click on "configure" and enter your Analytics id (UA-XXXXX-X) and save it.

## Integration

You need to put a js tag in the file ```order-invoice.html``` in your active front-office template.

```
<script>
    ga(function(tracker) {
        clientId = tracker.get('clientId');
        $.ajax({
           'url': "{url path='/UniversalAnalytics/ClientId'}",
            'data': {
                'clientId': clientId
            }
        });
    });
</script>
```

This script must be placed after the google analytics code, just before the ```</body>``` tag.

## Usage

The ecommerce option must be activated in your view parameter in your Analytics account.