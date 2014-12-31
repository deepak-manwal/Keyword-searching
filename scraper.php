<?php 
/*Hiding unwanted warnings of DOM parser*/
error_reporting(E_ERROR | E_PARSE);
class Scraper extends File {

	function __construct() {}
	/*
	@Description: Read content URL
	*/
	private function get_contents($url) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		$data = curl_exec($ch);
		curl_close($ch);

		return $data;
	}
	
	/*
	 @Description: Getting keywords from Url content
	*/
	private function get_keywords($url) {
		$html = $this->get_contents($url);

		//parsing begins here:
		$doc = new DOMDocument();
		$doc->loadHTML($html);
		$nodes = $doc->getElementsByTagName('title');

		//get and display what you need:
		$title = $nodes->item(0)->nodeValue;

		$metas = $doc->getElementsByTagName('meta');
		$keywords = '';
		for ($i = 0, $len = $metas->length; $i < $len; $i++)
		{
			$meta = $metas->item($i);
			if($meta->getAttribute('name') == 'keywords')
			{
				$keywords = $meta->getAttribute('content');
			}
		}

		$key_ar = explode(',',$keywords);
		$key_ar = array_map('trim',$key_ar);
		$key_ar = array_map('strtoLower',$key_ar);
		return $key_ar;
	}
	
	/*
	 @Description: Created Indexed array for each url
	*/
	function create_keywords_index($urls) {
		$url_ar = explode(',',$urls);
		$result = array();
		foreach($url_ar as $url) {
			$keywords = array_count_values($this->get_keywords($url));
			$rs = array('url'=>$url,
						'keywords'=>$keywords
					);
			array_push($result, $rs);
		}
		$this->write($result);//writing keywords to Local file
		return $result;
	}
}
?>