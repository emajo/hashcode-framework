<?php

namespace Solutions\Reply24;

require_once __DIR__ . "/../../vendor/autoload.php";

use Solver\Notifiers\TelegramNotifier;
use Solver\Runners\ShellRunner\ShellRunner;
use Solver\Runners\SyncRunner\SyncRunner;

$solution = new Reply24Solution(
    Reply24Script::class,
    collect([
        new Reply24Parameters(filename: '00-trailer'),
        new Reply24Parameters(filename: '01-comedy'),
        new Reply24Parameters(filename: '02-sentimental'),
        new Reply24Parameters(filename: '03-adventure'),
        new Reply24Parameters(filename: '04-drama'),
        new Reply24Parameters(filename: '05-horror'),
    ]),
    // new SyncRunner,
    new ShellRunner,
    new TelegramNotifier,
);

$solution->run();
