<?php

function iterateInput(callable $fn) {
	$file = fopen('input.txt', 'r');

	if ($file) {
		$lineNumber = 1;
		$result = 0;
		while (($line = fgets($file)) !== false) {
//			echo "Line $lineNumber: " . rtrim($line) . PHP_EOL;
			$result += $fn($line, $lineNumber);
			$lineNumber++;
		}

		fclose($file);
	}

	return $result;
}

function getLookupArray() {
	$file = fopen('input.txt', 'r');

	if ($file) {
		$line_number = 0;
		$lookupArray = [];
		while (($line = fgets($file)) !== false) {
			$line = str_replace(["\r", "\n"], '', $line);
			for ($columnNumber = 0; $columnNumber <= strlen($line) - 1; $columnNumber++) {
				$lookupArray[$line_number][$columnNumber] = $line[$columnNumber];
			}
			$line_number++;
		}

		fclose($file);
	}

	return $lookupArray;
}