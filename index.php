<?php

require_once 'vendor/autoload.php';

$job = new \App\Jobs\OptimizationJob();

$job->run();

