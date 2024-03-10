<?php

namespace Solutions\Example;

require_once __DIR__ . "/../../vendor/autoload.php";

use Solver\Runners\ShellRunner\ShellRunner;
use Solver\Runners\SyncRunner\SyncRunner;
use Solver\Solution;

$solution = new Solution(
    // new SyncRunner,
    new ShellRunner,
    ExampleScript::class,
    collect([
        new ExampleParameters(sleepTime: 5),
        new ExampleParameters(sleepTime: 100),
        new ExampleParameters(sleepTime: 0),
    ])
);

$solution->run();
