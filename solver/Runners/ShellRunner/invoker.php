<?php

namespace Solver\Runners\ShellRunner;

/**
 * This file is responsible for invoking a script and gets automaticcally called by the ShellRunner.
 */

require_once __DIR__ . "../../../../vendor/autoload.php";

use ReflectionMethod;
use Solver\Notifier;
use Solver\Parameters;
use Solver\Script;
use Utils\ColoredString\BackgroundColor;
use Utils\ColoredString\ForegroundColor;
use Utils\File;
use Utils\Log;

/**
 * It takes 
 * - the script class name
 * - parameters array
 * - id
 * - output directory 
 * - optional notifier class name
 * as command line arguments.
 */
$scriptClass = $argv[1];
$paramsArray = json_decode($argv[2], true);
$id = join('-', array_values($paramsArray)) . '_' . $argv[3];
$outputPath = $argv[4];
$notifierClass = $argv[5] ?? null;


/**
 * The script is instantiated and executed using the provided parameters.
 */
$reflector = new ReflectionMethod($scriptClass, '__construct');

/** @var Parameters $paramsClass */
$paramsClass = $reflector->getParameters()[0]->getType()->getName();
$scriptParams = $paramsClass::fromArray($paramsArray);

/** @var Script $script */
$script = new $scriptClass($scriptParams);
$result = $script->run();


/**
 * The result is written to the output directory.
 */
File::write($outputPath, $result);


/**
 * A log message is printed indicating the completion of the script execution.
 */
Log::out("Script {$scriptClass} with id {$id} finished", 0, ForegroundColor::BLACK, BackgroundColor::GREEN);


/**
 * If a notifier has been set the output file is sent to the user.
 */
if($notifierClass) {
    /** @var Notifier $notifier */
    $notifier = new $notifierClass;
    $notifier->pushFile($outputPath, "Script with id {$id} finished \n 💃 🦄 👩🏾‍❤️‍💋‍👩🏼 🏋🏿 🥸 🫃🏽 🌈");
}
