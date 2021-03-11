<?php

use Utils\Autoupload;
use Utils\Cerberus;
use Utils\Collection;
use Utils\FileManager;
use Utils\Log;

require_once '../../bootstrap.php';

/* CONFIG */
$fileName = 'a';

include 'reader.php';

/* VARIABLES */
/** @var FileManager $fileManager */
/** @var Collection|Foo[] $FOO */
/** @var int $DURATION */

$SCORE = 0;

/* FUNCTIONS */
/**
 * @param $semaphores
 * @return string
 */
function getOutput($semaphores)
{
    $output = [];
    $output[] = count($semaphores);
    $output = implode("\n", $output);
    return $output;
}

/* ALGO */


$fileManager->outputV2(getOutput([]), 'score_' . $SCORE);