<?php

namespace App\Models;

class Campaign
{
    /** @var OptimizationProps $optProps */
    private $optProps;

    /** @var int */
    private $id;

    /** @var array */
    private $publisherBlacklist;

    public function __construct($id, OptimizationProps $optProps)
    {
        $this->id = $id;
        $this->optProps = $optProps;
    }

    public function getOptimizationProps()
    {
        return $this->optProps;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBlackList()
    {
        return $this->publisherBlacklist;
    }

    public function saveBlacklist($blacklist)
    {
        // dont implement
    }
}
