# mike-monitor
Proof of concept for a Dashboard feed by RabbitMQ

## Exchange declaration
```
$channel->exchange_declare('mike_monitor', 'topic', false, false, false);
```

## TOPIC Structure
```html
<source>.<section>.<level>
```

Examples:

* monitor.ping.info
* monitor.homepage.error