<?php

namespace App\Factories;

abstract class Factory
{
    protected $availableEventTypes = [
        'install',
        'purchase',
        'app_open',
        'registration'
    ];

    abstract public static function make($override = []);

    protected function getRandomEventType($count = 1)
    {
        return array_rand(array_flip($this->availableEventTypes), $count);
    }
}
