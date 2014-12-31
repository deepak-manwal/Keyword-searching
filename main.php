<?php 
require ('file.php');
require ("scraper.php");
require ("search.php");
class Main {

	function __construct()
	{
		$this->scraper = new Scraper(); 
		$this->search = new Search(); 
		$this->index();
	}
	/*
	@Description: Read content URL
	*/
	function index() {
		//creating index for url
		//$urls = 'http://localhost/sts_admin_panel/,http://localhost/codeigniter/';
		$urls = $this->input("Enter URL seperated by comma: ");
		$time = microtime(true);
		$index_ar = $this->scraper->create_keywords_index($urls);
		echo (microtime(true) - $time) . ' second taken in crawling url, and indexing keywords'.PHP_EOL;
		
		
		//index are ready, Entered in search mode
		//$search = 'cats,dogs';//hardcoded input
		//$search = 'the dogs,  the cats';//hardcoded input
		$search = $this->input("Entered Search mode , please provide the keyword list seperated by comma :- ");
		$time = microtime(true);
		$keywords = $this->search->omit($search);
		$result = $this->search->search_keywords($keywords);
		echo (microtime(true) - $time) . ' second taken in searching'.PHP_EOL;
		
		//outputing
		echo "Results in decending order".PHP_EOL;
		foreach($result as $url=>$count)
		{
			echo "$url : $count Keyword matched\n";
		}
	}
	/*
	@Description: Getting input from user
	*/
	function input($message) {
		echo $message;
		$handle = fopen ("php://stdin","r");
		$str = fgets($handle);
		$str = trim($str);
		if(!strlen($str))//checking for valid string
		{
			echo "ABORTING! Please Provide valid Input";
			die;
		}
		return $str;
	}
}

$some  = new Main();
?>