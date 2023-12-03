<?php

function iterateInput(callable $fn) {
	$file = fopen('input.txt', 'r');

	if ($file) {
		$line_number = 1;
		$result = 0;
		while (($line = fgets($file)) !== false) {
			echo "Line $line_number: " . rtrim($line) . PHP_EOL;
			$result += $fn($line);
			$line_number++;
		}

		fclose($file);
	}

	return $result;
}