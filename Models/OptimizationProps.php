<?php

namespace App\Models;

class OptimizationProps
{
    public $threshold;
    public $sourceEvent;
    public $measuredEvent;
    public $ratioThreshold;

    public function __construct($sourceEvent, $measuredEvent, $threshold, $ratioThreshold)
    {
        $this->sourceEvent = $sourceEvent;
        $this->measuredEvent = $measuredEvent;
        $this->threshold = $threshold;
        $this->ratioThreshold = $ratioThreshold;
    }

    /**
     * Check if given event should be counted and return metric name.
     *
     * @param Event $event
     * @return null|string
     */
    public function getMetricName(Event $event)
    {
        if ($event->getType() === $this->measuredEvent) {
            return 'measured';
        }
        if ($event->getType() === $this->sourceEvent) {
            return 'source';
        }
        return null;
    }
}
