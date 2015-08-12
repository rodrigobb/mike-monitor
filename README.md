# mike-monitor
Proof of concept for a Dashboard feed by RabbitMQ

## Setting up

### Requirements

* RabbitMQ installed (https://www.rabbitmq.com/download.html)
* Node.js and npm installed
* Composer installed (https://getcomposer.org/download/)

### Installation

* Clone project
* run npm and composer install
```bash
$ npm install
$ composer install
```

### Starting socket server

Run
``` bash
npm start
```

## Structure

### Exchange declaration
```
$channel->exchange_declare('mike_monitor', 'topic', false, false, false);
```

### TOPIC Structure
```html
<source>.<section>.<level>
```

Examples:

* monitor.ping.info
* monitor.homepage.error