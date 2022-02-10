<?php

use Utils\FileManager;
use Utils\Log;

global $fileName;
/** @var FileManager */
global $fileManager;
/** @var Client[] */
global $clients;
/** @var Ingredient[] */
global $ingredients;

$fileName = 'a';

include_once 'reader.php';
//include_once 'analyzer.php';

$output = [];

// Codice

var_dump($ingredients);


foreach ($ingredients as $i) {
    $output[] = $i->name;
}

// Output
$output = count($output) . ' ' . implode(' ', $output);
Log::out('Output...');
$fileManager->outputV2($output);
