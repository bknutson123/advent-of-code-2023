<?php
include_once '../util.php';

$totalValue = iterateInput(function ($line, $lineNumber) {
	$cardHands = explode("|", $line);
	$myHand = extractMatchedNumbers($cardHands[1]);
	$winningHand = extractMatchedNumbers(explode(": ", $cardHands[0])[1]);
	$winningCardsInMyHand = array_intersect($winningHand, $myHand);
	$winningValue = floor(2**sizeof($winningCardsInMyHand)/2);
	return $winningValue;
});

function extractMatchedNumbers($numberString) {
	preg_match_all('/\b\d+\b/', $numberString, $matches);
	return $matches[0] ?? [];
}

echo "TOTAL VALUE: " . $totalValue;
