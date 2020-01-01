<?php

namespace App\Models;

class Event
{
    private $type;
    private $campaignId;
    private $publisherId;
    private $ts; // not sure what is this field about, but let it be

    public function __construct($type, $campaignId, $publisherId)
    {
        $this->type = $type;
        $this->campaignId = $campaignId;
        $this->publisherId = $publisherId;
    }

    public function getType()
    {
        // for example "install"
        return $this->type;
    }

    public function getTs()
    {
        return $this->ts;
    }

    public function getCampaignId()
    {
        return $this->campaignId;
    }

    public function getPublisherId()
    {
        return $this->publisherId;
    }
}
