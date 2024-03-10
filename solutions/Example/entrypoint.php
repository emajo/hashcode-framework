<?php

namespace Solutions\Example;

require_once __DIR__ . "/../../vendor/autoload.php";

use Solver\Runners\ShellRunner\ShellRunner;
use Solver\Runners\SyncRunner\SyncRunner;
use Solver\Solution;

$solution = new Solution(
    new SyncRunner,
    // new ShellRunner,
    ExampleScript::class,
    collect([
        new ExampleParameters(0, 0),
        new ExampleParameters(5, 5),
        new ExampleParameters(100, 5),
    ])
);

$solution->run();
