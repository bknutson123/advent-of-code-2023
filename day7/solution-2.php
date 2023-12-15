<?php
include_once '../util.php';

function getCharacterOccurrences($string) {
	$characters = str_split($string);
	$result = array_count_values($characters);
	print_r($result);
	$jokers = $result['J'] ?? 0;
	unset($result["J"]);
	arsort($result);
	$result = array_values($result);

	return [$result[0] + $jokers, $result[1] ?? 0];
}

function compareHands($a, $b) {
	static $orderMap;

	if (!$orderMap) {
		$order = 'AKQT98765432J';
		$orderMap = array_flip(array_reverse(str_split($order)));
	}

	$charsA = str_split($a['hand']);
	$charsB = str_split($b['hand']);

	for ($i = 0; $i < count($charsA); $i++) {
		$strengthA = $orderMap[$charsA[$i]];
		$strengthB = $orderMap[$charsB[$i]];
		if ($strengthA > $strengthB) {
			return 1;
		}
		if ($strengthB > $strengthA) {
			return -1;
		}
	}

	return 0;
}

$total = 0;
$data = [];
iterateInput(function ($line, $lineNumber) use (&$data) {
	$parts = explode(" ", $line);
	$hand = $parts[0];
	$betAmount = $parts[1];
	$characterCount = getCharacterOccurrences($hand);
	$data[$characterCount[0]][$characterCount[1]][] = ['hand' => $hand, 'betAmount' => $betAmount];
});

$rank = 1;
ksort($data);
foreach ($data as $highestCount => $value) {
	ksort($data[$highestCount]);
	foreach ($data[$highestCount] as $secondHighestCount => $hands) {
		usort($data[$highestCount][$secondHighestCount], 'compareHands');
		foreach ($data[$highestCount][$secondHighestCount] as $index => $hand) {
			$data[$highestCount][$secondHighestCount][$index]['amountWon'] = $rank * $hand['betAmount'];
			$data[$highestCount][$secondHighestCount][$index]['rank'] = $rank;
			$rank++;
		}
	}
}
print_r($data);
$flattenedArray = array_merge([], ...array_merge([], ...$data));
echo PHP_EOL . "TOTAL AMOUNT WON: " . array_sum(array_column($flattenedArray, 'amountWon'));
