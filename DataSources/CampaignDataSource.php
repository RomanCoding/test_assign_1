<?php

namespace App\DataSources;

use App\Factories\CampaignFactory;

class CampaignDataSource
{
    public function getCampaigns(): array
    {
        $randomCount = rand(5, 15);
        $result = [];

        for ($i = 0; $i < $randomCount; $i++) {
            $result[] = CampaignFactory::make();
        }

        return $result;
    }
}
