<?php
include_once '../util.php';

function getNumbersFromLine(string $line) {
	preg_match_all('/\b\d+\b/', $line, $matches);

	return array_map('intval', $matches[0]);
}

function findSeedValue($value, $lookupMap, $mapIndex) {
	if ($mapIndex == 0) {
		return $value;
	}
	foreach ($lookupMap[$mapIndex] as $lookup) {
		$destinationBeginningRange = $lookup[0];
		$destinationEndRange = $lookup[0] + $lookup[2];
		$sourceRangeStart = $lookup[1];
		if ($value >= $destinationBeginningRange && $value < $destinationEndRange) {
			$difference = $value - $destinationBeginningRange;

			return findSeedValue($sourceRangeStart + $difference, $lookupMap, $mapIndex - 1);
		}
	}

	return findSeedValue($value, $lookupMap, $mapIndex - 1);
}

function isValueInSeeds($value, $seeds) {
	for ($i = 0; $i < count($seeds) - 1; $i += 2) {
		$min = $seeds[$i];
		$max = $seeds[$i] + $seeds[$i + 1];
		if ($value >= $min && $value <= $max) {
			return true;
		}
	}

	return false;
}

$lookupMap = [];
$currentMap = 0;

iterateInput(function ($line, $lineNumber) use (
	&$lookupMap, &$currentMap
) {
	if (strpos($line, 'map:') !== false) {
		$currentMap += 1;
		$lookupMap[$currentMap] = [];
	} else {
		$numbers = getNumbersFromLine($line);
		if (!empty($numbers)) {
			$lookupMap[$currentMap][] = $numbers;
		}
	}
});

$initialSeeds = $lookupMap[0][0];
foreach ($lookupMap[7] as $values) {
	$locationValue = $values[0];
	$range = $values[2];
	foreach (range(0, 3000000) as $locationValue) {
		$seedValue = findSeedValue($locationValue, $lookupMap, 7);
		if (isValueInSeeds($seedValue, $initialSeeds)) {
			echo "SMALLEST LOCATION: " . $locationValue;
			exit;
		}
	}
}