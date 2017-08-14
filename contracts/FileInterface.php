<?php

interface FileInterface
{
	/**
	 * Read a file.
	 * 
	 * @param string $file
	 * @return void
	 */
	public function read();

	/**
	 * create a new file.
	 * 
	 * @param string $file
	 * @return void
	 */
	public function write($file);
}