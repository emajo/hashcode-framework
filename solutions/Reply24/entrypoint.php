<?php

namespace Solutions\Reply24;

require_once __DIR__ . "/../../vendor/autoload.php";

use Solver\Notifiers\TelegramNotifier;
use Solver\Runners\ShellRunner\ShellRunner;
use Solver\Runners\SyncRunner\SyncRunner;

$solution = new Reply24Solution(
    Reply24Script::class,
    collect([
        new Reply24Parameters(filename: 'input1'),
        new Reply24Parameters(filename: 'input2'),
        new Reply24Parameters(filename: 'input3'),
    ]),
    // new SyncRunner,
    new ShellRunner,
    new TelegramNotifier,
);

$solution->run();
