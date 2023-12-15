<?php
include_once '../util.php';

$lookup = getLookupArray();
$total = 0;
foreach ($lookup as $rowIndex => $row) {
	foreach ($row as $columnIndex => $char) {
		if ($char === '*') {
			$var1 = checkForNumberAtIndex($lookup, $rowIndex - 1, $columnIndex);
			$var2 = checkForNumberAtIndex($lookup, $rowIndex - 1, $columnIndex - 1);
			$var3 = checkForNumberAtIndex($lookup, $rowIndex - 1, $columnIndex + 1);
			$var4 = checkForNumberAtIndex($lookup, $rowIndex, $columnIndex - 1);
			$var5 = checkForNumberAtIndex($lookup, $rowIndex, $columnIndex + 1);
			$var6 = checkForNumberAtIndex($lookup, $rowIndex + 1, $columnIndex);
			$var7 = checkForNumberAtIndex($lookup, $rowIndex + 1, $columnIndex - 1);
			$var8 = checkForNumberAtIndex($lookup, $rowIndex + 1, $columnIndex + 1);
			$gearRatio = 1;
			$parts = 0;
			for ($i = 1; $i <= 8; $i++) {
				$varName = "var$i";
				if ($$varName > 0) {
					$gearRatio *= $$varName;
					$parts += 1;
				}
			}
			if ($parts > 1) {
				$total += $gearRatio;
			}
		}
	}
}

function checkForNumberAtIndex(array &$lookup, $rowIndex, $columnIndex): int {
	if (
		$rowIndex < 0 ||
		$rowIndex > count($lookup) - 1 ||
		$columnIndex < 0 ||
		$columnIndex > count($lookup[$rowIndex]) - 1
	) {
		return 0;
	}
	$numberStr = '0';
	if (is_numeric($lookup[$rowIndex][$columnIndex])) {
		$numberStr = $lookup[$rowIndex][$columnIndex];
		for ($startColIndex = $columnIndex - 1; $startColIndex >= 0; $startColIndex--) {
			$value = $lookup[$rowIndex][$startColIndex];
			if (!is_numeric($value)) {
				break;
			}
			$numberStr = $value . $numberStr;
		}
		for ($endColIndex = $columnIndex + 1; $endColIndex <= count($lookup[$rowIndex]) - 1; $endColIndex++) {
			$value = $lookup[$rowIndex][$endColIndex];
			if (!is_numeric($value)) {
				break;
			}
			$numberStr .= $value;
		}
		removeNumberStringFromLookup($lookup, $rowIndex, $startColIndex, $endColIndex);
	}

	return intval($numberStr);
}

function removeNumberStringFromLookup(array &$lookup, $rowIndex, $startColIndex, $endColIndex) {
	for ($i = $startColIndex; $i <= $endColIndex; $i++) {
		$lookup[$rowIndex][$i] = ".";
	}
}


echo "TOTAL FOR ALL ROWS: $total\n";
