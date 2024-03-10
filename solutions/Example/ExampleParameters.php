<?php

namespace Solutions\Example;

use Solver\Parameters;

class ExampleParameters extends Parameters
{
    public function __construct(
        public ?int $sleepTime = 0,
    ) {}
}