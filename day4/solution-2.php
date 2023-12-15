<?php
include_once '../util.php';

$fileLines = file('input.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$extraScratchCards = array_fill(1, count($fileLines), 1);
iterateInput(function ($line, $lineNumber) use (&$extraScratchCards) {
	$cardHands = explode("|", $line);
	$myHand = extractMatchedNumbers($cardHands[1]);
	$winningHand = extractMatchedNumbers(explode(": ", $cardHands[0])[1]);
	$winningCardsInMyHand = array_values(array_intersect($winningHand, $myHand));
	foreach (array_keys($winningCardsInMyHand) as $winningCardIndex) {
		$extraScratchCards[$lineNumber+$winningCardIndex+1] += $extraScratchCards[$lineNumber];
	}
});

function extractMatchedNumbers($numberString) {
	preg_match_all('/\b\d+\b/', $numberString, $matches);
	return $matches[0] ?? [];
}

echo "TOTAL VALUE: " . array_sum($extraScratchCards);
