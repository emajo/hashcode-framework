<?php

namespace Solutions\Example;

use Solver\Script;

class ExampleScript extends Script
{
    public function __construct(protected ExampleParameters $params) {}

    public function run()
    {
        sleep($this->params->param);
        return json_encode([
            'slept' => $this->params->param
        ]);
    }
}