<?php

class ModifiedMergeSort implements SortingAlgorithmInterface
{
	protected $sizeLimit;
	protected $tmpFiles = [];
	
	function __construct(FileInterface $file, $sizeLimit)
	{
		$this->file = $file;

		// convert to bytes
		$this->sizeLimit = $sizeLimit * 1000000;

		echo "sizeLimit: {$this->sizeLimit} bytes\n";
	}

	public function sort($outputPath = 'output')
	{
		if ($this->file->fileSize > $this->sizeLimit) {

			echo "Splitting file...\n";

			return $this->externalSort();
		}

		// if the file is within the specified size limit, proceed to sorting
		$this->file->read();

		echo "sorting file\n";

		$this->file->list = $this->quickSort($this->file->list);

		return $this->output($outputPath);
	}

	protected function quickSort($array)
	{
		$length = count($array);
		
		if ($length < 2) {
			return $array;
		} else {
			// $pivot point
			$pivot = $array[0];
			
			$left = $right = array();
			
			// loop and compare each item in the array to the pivot value, place item in appropriate partition
			for($i = 1; $i < $length; $i++)
			{
				if ($array[$i] < $pivot) {
					$left[] = $array[$i];
				} else {
					$right[] = $array[$i];
				}
			}

			// recursively sort left and right arrays
			return array_merge($this->quickSort($left), array($pivot), $this->quickSort($right));
		}
	}

	protected function externalSort() {
		// first break up into smaller chunks
		$this->chunk();

		// To be confirmed/implemented
		// After file split put them back together in the right order
		echo "External sort TBC\n";
	}
	

	protected function output($outputPath)
	{
		echo "writing file\n";
		// split file path
		$filePath = explode('/', $this->file->file);

		// take only the file name
		$elements = explode('.', array_pop($filePath));		

		// add 'sorted' and file extension
		$outputName = $outputPath . '/' . array_shift($elements) . '-sorted.' . array_pop($elements);
		
		return $this->file->write($outputName);
	}

	protected function chunk()
	{
		$handle = fopen($this->file->file, "r") or die("Couldn't get handle");

		if ($handle) {

			$tmpNum = 1;

		    while (!feof($handle)) {
		        $buffer = fgets($handle, $this->sizeLimit);

		        $list = explode(',', $buffer);

		        // sort before saving temporary file
		        $list = $this->quickSort($list);

		        // remove empty fields
		        $this->file->list = array_filter($list);

		        $fileName = 'tmp-' . $tmpNum . '.txt';

		        $this->file->write("output/$fileName");

		        $tmpNum += 1;

		        $this->tmpFiles[$fileName]['size'] = fstat($handle)['size'];

		        echo "New file: output/$fileName\n";
		    }

		    fclose($handle);
		}

	}

}