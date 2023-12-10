<?php
include_once '../util.php';

function getLinkedTimeDistanceArrayFromFile() {
	iterateInput(function ($line, $lineNumber) use (&$time, &$distance) {
		$colonPosition = strpos($line, ':');
		$substringAfterColon = substr($line, $colonPosition + 1);
		$cleanedString = preg_replace('/\s/', '', $substringAfterColon);

		if ($lineNumber == 1) {
			$time = $cleanedString;
		} else {
			$distance = $cleanedString;
		}
	});

	return [$time, $distance];
}

$timeDistanceArray = getLinkedTimeDistanceArrayFromFile();
$raceMilliseconds = $timeDistanceArray[0];
$raceDistanceRecord = $timeDistanceArray[1];
$sqrt = sqrt($raceMilliseconds**2 - 4 * $raceDistanceRecord);
$high = floor(($raceMilliseconds+$sqrt)/2);
$low = ceil(($raceMilliseconds-$sqrt)/2);

echo "TOTAL: " . $high - $low + 1;