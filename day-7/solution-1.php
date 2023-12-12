<?php
include_once '../util.php';

function getCharacterOccurrences($string) {
	$characters = str_split($string);
	$result = array_count_values($characters);
	arsort($result);
	$result = array_values($result);

	return [$result[0], $result[1] ?? 0];
}

function compareHands($a, $b) {
	static $orderMap;

	if (!$orderMap) {
		$order = 'AKQJT98765432';
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

echo "COUNT FOR 1: " . count($data[1][1]) . PHP_EOL;
echo "LAST RANK FOR 1: " . $data[1][1][196]['rank'] . PHP_EOL;
echo "COUNT FOR 2[1]: " . count($data[2][1]) . PHP_EOL;
echo "LAST RANK FOR 2[1]: " . $data[2][1][240]['rank'] . PHP_EOL;
echo "COUNT FOR 2[2]: " . count($data[2][2]) . PHP_EOL;
echo "LAST RANK FOR 2[2]: " . $data[2][2][189]['rank'] . PHP_EOL;
echo "COUNT FOR 3[1]: " . count($data[3][1]) . PHP_EOL;
echo "LAST RANK FOR 3[1]: " . $data[3][1][176]['rank'] . PHP_EOL;
echo "COUNT FOR 3[2]: " . count($data[3][2]) . PHP_EOL;
echo "LAST RANK FOR 3[2]: " . $data[3][2][101]['rank'] . PHP_EOL;
echo "COUNT FOR 4[1]: " . count($data[4][1]) . PHP_EOL;
echo "LAST RANK FOR 4[1]: " . $data[4][1][91]['rank'] . PHP_EOL;
echo "COUNT FOR 5: " . count($data[5][0]) . PHP_EOL;
$flattenedArray = array_merge([], ...array_merge([], ...$data));
echo "TOTAL AMOUNT WON: " . array_sum(array_column($flattenedArray, 'amountWon'));
