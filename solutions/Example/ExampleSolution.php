<?php

namespace Solutions\Example;

use Solver\Solution;
use Utils\DirUtils;

class ExampleSolution extends Solution
{
    protected function onFinish(string $runId): void
    {
        parent::onFinish($runId);
        $scriptFile = collect(explode('\\', $this->script))->last();
        $this->notifier->pushFile(DirUtils::getScriptDir() . "/{$scriptFile}.php", "Source code for run {$runId} \n 💻 💻 💻 💻 💻 💻 💻");
    }
}