<?php
/**
 * @file
 * Contains \LushDigital\MicroServiceMetrics\Http\Controllers\MetricsController.
 */

namespace LushDigital\MicroServiceMetrics\Http\Controllers;

use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;

/**
 * A controller to display metrics for microservices.
 *
 * Provides Prometheus style metrics to scrape.
 *
 * @package LushDigital\MicroServiceMetrics\Http\Controllers
 */
class MetricsController extends BaseController
{
    private $registry;

    private $renderer;

    public function __construct(CollectorRegistry $registry, RenderTextFormat $renderer)
    {
        $this->registry = $registry;
        $this->renderer = $renderer;
    }

    public function metrics()
    {
        $rawMetrics = $this->renderer->render($this->registry->getMetricFamilySamples());

        return response($rawMetrics, Response::HTTP_OK, ['Content-Type' => RenderTextFormat::MIME_TYPE]);
    }
}
