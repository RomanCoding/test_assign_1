<?php

namespace App\Jobs;

use App\DataSources\CampaignDataSource;
use App\DataSources\EventsDataSource;
use App\Models\Campaign;
use App\Models\Event;

class OptimizationJob
{
    public function run()
    {
        $campaignDS = new CampaignDataSource();

        /** @var Campaign[] $campaigns */
        $campaigns = $campaignDS->getCampaigns();

        $eventsDS = new EventsDataSource($campaigns);
        $events = $eventsDS->getEventsSince("2 weeks ago");

        $eventsKeyByCampaign = [];

        /** @var Event $event */
        foreach ($events as $event) {
            $eventsKeyByCampaign[$event->getCampaignId()][] = $event;
        }

        // reduce array to key by campaign ID
        $campaigns = array_reduce($campaigns, function ($carry, $campaign) {
            /** @var Campaign $campaign */
            $carry[$campaign->getId()] = $campaign;
            return $carry;
        }, []);

        foreach ($eventsKeyByCampaign as $campaignId => $events) {
            $campaign = $campaigns[$campaignId];
            $optProps = $campaign->getOptimizationProps();
            $blacklist = $campaign->getBlackList() ?? [];
            // filter events to keep only needed types
            $events = array_filter($events, function ($event) use ($campaign) {
                /** @var Event $event */
                return $event->getType() === $campaign->getOptimizationProps()->measuredEvent
                    || $event->getType() === $campaign->getOptimizationProps()->sourceEvent;
            });

            $events = array_reduce($events, function ($carry, $event) use ($campaign) {
                /** @var Event $event */
                $pubId = $event->getPublisherId();
                if (!isset($carry[$pubId])) {
                    $carry[$pubId] = [
                        'measured' => 0,
                        'source' => 0
                    ];
                }
                $carry[$pubId][$campaign->getOptimizationProps()->getMetricName($event)]++;
                return $carry;
            }, []);

            foreach ($events as $publisherId => $stats) {
                if ($stats['source'] < $optProps->threshold) {
                    continue;
                }
                $index = array_search($publisherId, $blacklist);

                if ($stats['measured'] < $optProps->ratioThreshold * $stats['source']) {
                    if ($index !== false) {
                        $blacklist[] = $publisherId;
                        // $mailService->sendEmailToPublisher()
                        // and make him sad he was blacklisted ;(
                    }
                } else {
                    if ($index !== false) {
                        unset($blacklist[$index]);
                        // $mailService->sendEmailToPublisher()
                        // and make him happy he was unblacklisted ;)
                    }
                }
            }
            $campaign->saveBlacklist($blacklist);
        }
    }
}
