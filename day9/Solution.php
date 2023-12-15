<?php

namespace day9;

use AbstractSolution;

class Solution extends AbstractSolution {
	public function init() {
		foreach ($this->data as $key => $row) {
			$this->data[$key] = explode(" ", $row);
		}
	}

	private function findNextNumberInSequence($row, $lastNum) {
		if (array_sum($row) == 0) {
			return $row[array_key_last($row)];
		}

		$tempArr = [];
		foreach ($row as $key => $firstNum) {
			if (isset($row[$key + 1])) {
				$secondNum = $row[$key + 1];
				$tempArr[] = $secondNum - $firstNum;
			}
		}
		$nextNumberInSequence = $this->findNextNumberInSequence($tempArr, $tempArr[array_key_last($tempArr)]);
		return $nextNumberInSequence + $lastNum;
	}

	function part1() {
		$rowNextNumbers = [];
		foreach ($this->data as $row) {
			$lastNum = $row[array_key_last($row)];
			$rowNextNumbers[] = $this->findNextNumberInSequence($row, $lastNum);
		}

		return array_sum($rowNextNumbers);
	}

	private function findPreviousNumberInSequence($row, $previousNum) {
		if (array_sum($row) == 0) {
			return $row[0];
		}

		$tempArr = [];
		foreach ($row as $key => $firstNum) {
			if (isset($row[$key + 1])) {
				$secondNum = $row[$key + 1];
				$tempArr[] = $secondNum - $firstNum;
			}
		}
		$previousNumberInSequence = $this->findPreviousNumberInSequence($tempArr, $tempArr[0]);

		return $previousNum - $previousNumberInSequence;
	}

	function part2() {
		$rowPreviousNumbers = [];
		foreach ($this->data as $row) {
			$firstNum = $row[0];
			$rowPreviousNumbers[] = $this->findPreviousNumberInSequence($row, $firstNum);
		}

		return array_sum($rowPreviousNumbers);
	}
}