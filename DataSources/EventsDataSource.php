<?php

namespace App\DataSources;

use App\Factories\EventFactory;
use App\Models\Campaign;

class EventsDataSource
{
    /** @var Campaign[] $campaigns */
    private $campaigns;

    public function __construct($campaigns)
    {
        // in real world, we won't need this.
        // but I want to have real Campaign ID to use it later
        $this->campaigns = $campaigns;
    }

    public function getEventsSince(string $dateString): array
    {
        $result = [];

        foreach ($this->campaigns as $campaign) {
            $randomCount = rand(1, 99);
            for ($i = 0; $i < $randomCount; $i++) {
                $result[] = EventFactory::make(['campaignId' => $campaign->getId()]);
            }
        }

        return $result;
    }
}
