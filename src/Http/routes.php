<?php

$this->app->get('/metrics', 'LushDigital\MicroServiceMetrics\Http\Controllers\MetricsController@metrics');