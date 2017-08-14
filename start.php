<?php

// lift php memory limit
ini_set('memory_limit', -1);

require 'contracts/FileInterface.php';
require 'contracts/SortingAlgorithmInterface.php';
require 'File.php';
require 'ModifiedMergeSort.php';

echo "starting...\n";

$startTime = microtime(true);

// set the file path
$filePath = $argv[1];

// assert file size limit if required, default to 1 MB
// if the file is bigger than this it will be split up into chunks of the size specified
$memoryLimit = isset($argv[2]) ? $argv[2] : 1;

// select output directory
// make sure the output directory exists first
$output = isset($argv[3]) ? $argv[3] : "output";

$file = new File($filePath);

$sortingAlgorithm = new ModifiedMergeSort($file, $memoryLimit);

$sortingAlgorithm->sort($output);

// output execution time and memory utilisation

$executionTime = round( (microtime(true) - $startTime) * 1000, 1);

echo "Execution Time: " . $executionTime . " Milliseconds\n";

echo "Memory usage: " . memory_get_usage(true) / 1024 . " KiB\n";

echo "Memory peak usage: " . memory_get_peak_usage(true) / 1024 . " KiB\n";

?>