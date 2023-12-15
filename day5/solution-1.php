<?php
include_once '../util.php';

function getNumbersFromLine(string $line) {
	preg_match_all('/\b\d+\b/', $line, $matches);
	return array_map('intval', $matches[0]);
}

function addNotFoundValues(array &$lookupArray, int &$currentIndex, array &$lookupItems) {
	$foundValues = array_keys($lookupArray[$currentIndex]);
	$valuesNotFound = array_diff($lookupItems, $foundValues);
	array_map(function ($valueNotFound) use (&$lookupArray, $currentIndex) {
		$lookupArray[$currentIndex][$valueNotFound] = $valueNotFound;
	}, $valuesNotFound);
}
const LOCATION_INDEX = 6;

$lookupArray = [[], [], [], [], [], [], []];
$currentIndex = -2;
$seeds = [];

$totalValue = iterateInput(function ($line, $lineNumber) use (
	&$currentIndex, &$lookupArray, &$seeds
) {
	if ($line == "\n") {
		return;
	}
	if (str_contains($line, "seeds:")) {
		$seeds = getNumbersFromLine($line);
		$currentIndex += 1;
		return;
	}
	$lookupItems = $seeds;
	if ($currentIndex > 0) {
		$lookupItems = array_values($lookupArray[$currentIndex - 1]);
	}

	if (str_contains($line, ":")) {
		if ($currentIndex >= 0) {
			addNotFoundValues($lookupArray, $currentIndex, $lookupItems);
		}
		$currentIndex += 1;
		return;
	}

	$numbers = getNumbersFromLine($line);
	$destinationRangeStart = $numbers[0];
	$sourceRangeStart = $numbers[1];
	$range = $numbers[2];
	$sourceRangeEnd = $sourceRangeStart + $range;

	foreach ($lookupItems as $lookupItem) {
		if ($lookupItem >= $sourceRangeStart && $lookupItem < $sourceRangeEnd) {
			$difference = $lookupItem - $sourceRangeStart;
			$lookupArray[$currentIndex][$lookupItem] = $destinationRangeStart + $difference;
		}
	}
});

$lastItems = array_values($lookupArray[$currentIndex - 1]);
addNotFoundValues($lookupArray, $currentIndex, $lastItems);

echo "SMALLEST LOCATION: " . min($lookupArray[LOCATION_INDEX]);
