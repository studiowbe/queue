<?php

namespace Studiow\Queue\Test;

use Studiow\Queue\HasQueueInterface;
use Studiow\Queue\HasQueueTrait;

class HasQueueClass implements HasQueueInterface
{

    use HasQueueTrait;

    private $multiplier;

    public function __construct($multiplier)
    {
        $this->multiplier = $multiplier;
    }

    public function multiply($input)
    {
        return $input * $this->multiplier;
    }

}
