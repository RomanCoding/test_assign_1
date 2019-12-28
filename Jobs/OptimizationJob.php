<?php

namespace App\Jobs;

use App\DataSources\CampaignDataSource;
use App\DataSources\EventsDataSource;

class OptimizationJob
{
    public function run()
    {
        $campaignDS = new CampaignDataSource();

        // array of Campaign objects
        $campaigns = $campaignDS->getCampaigns();

        $eventsDS = new EventsDataSource();

        /** @var Event $event */
        foreach ($eventsDS->getEventsSince("2 weeks ago") as $event) {
            // write logic here
        }

    }
}
