<?php
class File {
	private $file = 'indexes.txt';
	private $ad_con_file = 'ad_con.txt';
	
	function __construct() {}
	/*
	@Description: Read content of Indexes file
	*/
	protected function read() {
		$content = json_decode(file_get_contents($this->file),TRUE);
		return $content;
	}
	/*
	@Description: Write content in Indexes file
	*/
	protected function write($json) {
		file_put_contents($this->file, json_encode($json,TRUE));
	}
	
	protected function read_ad_con() {
		$content = json_decode(file_get_contents($this->ad_con_file),TRUE);
		return $content;
	}
}
?>