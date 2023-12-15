<?php

if ($argc < 3) {
	echo "Usage: php script.php <day> <method>\n";
	exit(1);
}

$day = $argv[1];
$part = $argv[2];

$namespace = "day$day";
$classFile = __DIR__ . "/$namespace/Solution.php";
include_once "./AbstractSolution.php";
require_once $classFile;
$className = "$namespace\\Solution";
$inputFile = __DIR__ . "/$namespace/input.txt";
$class = new $className($inputFile);
echo "ANSWER FOR PART 1: " . $class->part1() . PHP_EOL;
echo "ANSWER FOR PART 2: " . $class->part2() . PHP_EOL;