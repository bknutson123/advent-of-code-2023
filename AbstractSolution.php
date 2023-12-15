<?php

abstract class AbstractSolution {
	protected array $data;

	/**
	 * @return void
	 */
	public function __construct($inputFile) {
		$this->data = file($inputFile, FILE_IGNORE_NEW_LINES);
		$this->init();
	}

	abstract function init();
	protected function iterateInput(callable $fn) {
		$file = fopen('input.txt', 'r');

		if ($file) {
			$lineNumber = 1;
			$result = 0;
			while (($line = fgets($file)) !== false) {
				$result += $fn($line, $lineNumber);
				$lineNumber++;
			}

			fclose($file);
		}

		return $result;
	}

	abstract function part1();
	abstract function part2();
}