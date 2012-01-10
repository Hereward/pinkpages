<?php
class DateIterator implements Iterator {
	private $increment;
	private $startDate;
	private $endDate;

	private $currentDate;

	private $iterations = 0;

	/**
	 *
	 * @param string $increment Anything that strtotime can understand. eg. day, week, month, year
	 * @param int|string $startDate
	 * @param int|string $endDate
	 * @return
	 */
	function __construct($increment, $startDate, $endDate) {
		$this->increment = $increment;

		if(is_int($startDate)) {
			$this->startDate = $startDate;
		} else {
			$this->startDate = strtotime($startDate);
		}

		if(is_int($endDate)) {
			$this->endDate = $endDate;
		} else {
			$this->endDate = strtotime($endDate);
		}
		$this->currentDate = $this->startDate;
	}

	function current() {
		return date("Y-m-d", $this->currentDate);
	}

	function next() {
		$current = date("Y-m-d", $this->currentDate);
		$this->currentDate = strtotime($current." + 1 ".$this->increment);
		$this->iterations++;
	}

	function valid() {
		return $this->currentDate <= $this->endDate;
	}

	function rewind() {
		$this->currentDate = $this->startDate;
	}
	function key() {
		return $this->iterations;
	}
}
?>