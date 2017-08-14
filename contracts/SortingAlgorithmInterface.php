<?php

interface SortingAlgorithmInterface
{
	/**
	 * Sort a list of intergers (file contents) in acending order.
	 * 
	 * @param string $outputPath
	 * @return void
	 */
	public function sort($outputPath);
}