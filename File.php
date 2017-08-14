<?php

class File implements FileInterface
{

	public $file;
	public $list = [];
	public $fileSize;
	
	function __construct($file)
	{
		$this->file = $file;

		$this->fileSize = filesize($file);
	}

	public function read($offset= 0, $maxlen = 500000 )
	{
		$list = file_get_contents($this->file);

		$this->list += explode(',', $list);

		$list = null;
	}

	public function write($file)
	{
		$file = fopen($file, 'w');

		$string = fwrite($file, implode(',', $this->list) );

		fclose($file);
	}

}