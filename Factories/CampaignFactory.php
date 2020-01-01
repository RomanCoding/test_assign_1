<?php

namespace App\Factories;

use App\Models\Campaign;
use App\Models\OptimizationProps;

class CampaignFactory extends Factory
{
    public static function make($override = []): Campaign
    {
        $self = new self;
        [$sourceEvent, $measuredEvent] = $self->getRandomEventType(2);
        $threshold = rand(3, 5);
        $ratioThreshold = rand(10, 30) / 100;
        $optProps = new OptimizationProps($sourceEvent, $measuredEvent, $threshold, $ratioThreshold);

        $id = rand(1, 999);
        $campaign = new Campaign($id, $optProps);

        return $campaign;
    }
}
