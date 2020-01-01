<?php

namespace App\Factories;

use App\Models\Event;

class EventFactory extends Factory
{
    public static function make($override = []): Event
    {
        extract($override);
        $self = new self;
        $campaignId = $campaignId ?? rand(1, 10);
        $publisherId = $publisherId ?? rand(1, 10);
        $event = new Event($self->getRandomEventType(), $campaignId, $publisherId);

        return $event;
    }
}
