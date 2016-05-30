<?php

namespace Studiow\Queue\Test;

class InvokableClass
{

    private $multiplier;

    public function __construct($multiplier)
    {
        $this->multiplier = $multiplier;
    }

    public function __invoke($input)
    {
        return $input * $this->multiplier;
    }

}
