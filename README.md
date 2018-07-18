# Lush Digital - Micro Service Metrics
The Library provides Prometheus style metrics to scrape.

## Dependencies
It requires a redis instance running with REDIS_HOST environment variable pointing to it.

## Description
In the middleware RED metrics are being captured, however you are free to implement your own custom metrics just by registering the them with an instance of CollectorRegistry.(for simplicity it is set as a singleton in the IoC)
At display time new metrics will be discovered from Redis, but be aware if you change the definition for a metric, it needs to be purged from Redis.

## Package Contents
* Terminable Middleware
* Route + Controller 

## Installation
Install the package as normal:

```bash
$ composer require lushdigital/microservice-metrics
```

Register the service provider with Lumen in the `bootstrap/app.php` file:
```php
$app->register(LushDigital\MicroServiceMetrics\MetricsServiceProvider::class);
```