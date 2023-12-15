<?php
include_once '../util.php';

iterateInput(function ($line, $lineNumber) use (&$path, &$lookup) {
	if ($lineNumber == 1) {
		$path = str_split($line);
	}

	$pattern = '/(\w+)\s*=\s*\((\w+),\s*(\w+)\)/';
	if (preg_match($pattern, $line, $matches)) {
		$lookupKey = $matches[1];
		$leftPath = $matches[2];
		$rightPath = $matches[3];
		$lookup[$lookupKey]["L"] = $leftPath;
		$lookup[$lookupKey]["R"] = $rightPath;
	}
});

function gcd($a, $b) {
	while (0 != $b) {
		[$a, $b] = [$b, $a % $b];
	}

	return $a;
}

foreach ($lookup as $node => $values) {
	if (str_ends_with($node, 'A')) {
		$steps = 0;
		while (!str_ends_with($node, 'Z')) {
			$node = ('R' == $path[$steps % (count($path) - 1)]) ? $lookup[$node]["R"] : $lookup[$node]["L"];
			++$steps;
		}
		$nodes[] = $steps;
	}
}

$depthToReachEnd = array_reduce($nodes, function ($a, $b) {
	return $a * $b / gcd($a, $b);
}, 1);

echo "Took $depthToReachEnd to get to end!" . PHP_EOL;

