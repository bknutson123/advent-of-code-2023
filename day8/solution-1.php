<?php
include_once '../util.php';

iterateInput(function ($line, $lineNumber) use (&$path, &$lookup) {
	if ($lineNumber == 1) {
		$path = $line;
	}

	$pattern = '/(\w+)\s*=\s*\((\w+),\s*(\w+)\)/';
	if (preg_match($pattern, $line, $matches)) {
		$lookupKey = $matches[1];
		$leftPath = $matches[2];
		$rightPath = $matches[3];
		$lookup[$lookupKey]["L"] = $leftPath;
		$lookup[$lookupKey]["R"] = $rightPath;
	}
});

function findEndOfRoad(string $path, int $pathPosition, string $currentLocation, array $lookup, int $depth) {
	$pathLength = strlen($path) - 1;
	if ($currentLocation == "ZZZ" && $pathPosition == 0) {
		return $depth;
	}

	$newPathPosition = $pathPosition + 1;
	if ($newPathPosition >= $pathLength) {
		$newPathPosition = 0;
	}
	if ($path[$pathPosition] == "L") {
		return findEndOfRoad($path, $newPathPosition, $lookup[$currentLocation]["L"], $lookup, $depth + 1);
	} else {
		return findEndOfRoad($path, $newPathPosition, $lookup[$currentLocation]["R"], $lookup, $depth + 1);
	}
}


$depthToReachEnd = findEndOfRoad($path, 0, "AAA", $lookup, 0);
echo "Took $depthToReachEnd to get to end!" . PHP_EOL;

