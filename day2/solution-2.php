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

$totalValue = iterateInput(function ($line, $lineNumber) use ($highestRedValue, $highestGreenValue, $highestBlueValue) {
	$blueNumbers = getIntValueBefore($line,"blue");
	$redNumbers = getIntValueBefore($line, "red");
	$greenNumbers = getIntValueBefore($line, "green");
	$maxBlueNumber = max($blueNumbers);
	$maxRedNumber = max($redNumbers);
	$maxGreenNumber = max($greenNumbers);

	return $maxBlueNumber * $maxRedNumber * $maxGreenNumber;
});

echo "TOTAL VALUE: " . $totalValue;

