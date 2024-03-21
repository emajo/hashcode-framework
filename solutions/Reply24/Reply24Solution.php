<?php

namespace Solutions\Reply24;

use Solver\Solution;
use Utils\DirUtils;

class Reply24Solution extends Solution
{
    protected function onFinish(string $runId): void
    {
        parent::onFinish($runId);
        $scriptFile = collect(explode('\\', $this->script))->last();
        $this->notifier->pushFile(DirUtils::getScriptDir() . "/{$scriptFile}.txt", "Source code for run {$runId} \n 💻 💻 💻 💻 💻 💻 💻");
    }
}
