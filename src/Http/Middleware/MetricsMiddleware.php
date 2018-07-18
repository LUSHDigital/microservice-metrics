<?php

namespace LushDigital\MicroServiceMetrics\Http\Middleware;

use Closure;
use Prometheus\CollectorRegistry;

class MetricsMiddleware
{

    /**
     * @var CollectorRegistry
     */
    private $collectorRegistry;

    /**
     * Metrics constructor.
     * @param CollectorRegistry $metrics
     */
    public function __construct(CollectorRegistry $metrics)
    {
        $this->collectorRegistry = $metrics;
    }

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    /**
     * @param $request
     * @param $response
     * @throws \Prometheus\Exception\MetricsRegistrationException
     */
    public function terminate($request, $response)
    {
        $httpRequestsTotal = $this->collectorRegistry->registerCounter('http', 'requests_total', 'request counter', ['service', 'code', 'path', 'method']);
        $httpRequestsTotal->incBy(1, [env('SERVICE_NAME'), $response->status(), '/' . $request->path(), $request->method()]);

        $requestDuration = round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000, 2);
        $httpRequestDurationMilliseconds = $this->collectorRegistry->registerHistogram('http', 'request_duration_milliseconds', 'histogram for better visiblity of service performance', ['service', 'code', 'path', 'method'], [50, 80, 100, 120, 150, 200, 300, 500, 800, 1000, 2000, 5000]);
        $httpRequestDurationMilliseconds->observe($requestDuration, [env('SERVICE_NAME'), $response->status(), '/' . $request->path(), $request->method()]);
    }

}