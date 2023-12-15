<?php

function getLinkedTimeDistanceArrayFromFile() {
	$fileContent = file_get_contents('input.txt');
	$lines = explode("\n", $fileContent);

	$timeArray = [];
	$distanceArray = [];

	foreach ($lines as $line) {
		$words = preg_split('/\s+/', $line, -1, PREG_SPLIT_NO_EMPTY);
		if (isset($words[0]) && $words[0] === 'Time:') {
			$timeArray = array_map('intval', array_slice($words, 1));
		} elseif (isset($words[0]) && $words[0] === 'Distance:') {
			$distanceArray = array_map('intval', array_slice($words, 1));
		}
	}

	return array_map(null, $timeArray, $distanceArray);
}

$timeDistanceArray = getLinkedTimeDistanceArrayFromFile();
$totalWaysToBeatRecords = [];
foreach ($timeDistanceArray as $timeDistance) {
	$raceMilliseconds = $timeDistance[0];
	$raceDistanceRecord = $timeDistance[1];
	$totalWaysToBeatRecord = 0;
	foreach (range(0, $raceMilliseconds) as $speed) {
		$timeLeftToRace = $raceMilliseconds - $speed;
		$distanceTraveled = $speed * $timeLeftToRace;
		if ($distanceTraveled > $raceDistanceRecord) {
			$totalWaysToBeatRecord++;
		}
	}
	$totalWaysToBeatRecords[] = $totalWaysToBeatRecord;
}

echo "TOTAL: " . array_reduce($totalWaysToBeatRecords, fn ($carry, $item) => $carry * $item, 1);