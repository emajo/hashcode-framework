<?php

namespace Solutions\Example;

require_once __DIR__ . "/../../vendor/autoload.php";

use Solver\Notifiers\TelegramNotifier;
use Solver\Runners\ShellRunner\ShellRunner;
use Solver\Runners\SyncRunner\SyncRunner;

$solution = new ExampleSolution(
    ExampleScript::class,
    collect([
        new ExampleParameters(sleepTime: 5),
        new ExampleParameters(sleepTime: 100),
        new ExampleParameters(sleepTime: 0),
    ]),
    // new SyncRunner,
    new ShellRunner,
    new TelegramNotifier,
);

$solution->run();
