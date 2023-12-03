<?php
include_once '../util.php';

function getIntValueBefore($originalString, $beforeString) {
	$pattern = "/(\d+)(?=\s*$beforeString)/";
	preg_match_all($pattern, $originalString, $matches);
	return $matches[1] ?: [];
}

$highestRedValue = 12;
$highestGreenValue = 13;
$highestBlueValue = 14;

$totalValue = iterateInput(function ($line) use ($highestRedValue, $highestGreenValue, $highestBlueValue) {
	$blueNumbers = getIntValueBefore($line,"blue");
	$redNumbers = getIntValueBefore($line, "red");
	$greenNumbers = getIntValueBefore($line, "green");
	if (
		empty(array_filter($blueNumbers, fn ($blueVal) => $blueVal > $highestBlueValue)) &&
		empty(array_filter($redNumbers, fn ($redVal) => $redVal > $highestRedValue)) &&
		empty(array_filter($greenNumbers, fn ($greenVal) => $greenVal > $highestGreenValue))
	) {
		$gameId = getIntValueBefore($line,":");
		echo "GAME $gameId[0] is a match!!" . PHP_EOL;
		return $gameId[0];
	}

	return 0;
});

echo "TOTAL VALUE: " . $totalValue;

