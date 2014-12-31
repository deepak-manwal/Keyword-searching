<?php
class Search extends File {
	
	function __construct() {}
	/*
	 @Description: Searching keyword in indexed array
	*/
	function search_keywords($keywords) {
		$index_ar = $this->read();
		$result = array();
		foreach($keywords as $index=>$needle)
		{
			foreach($index_ar as $url)
			{
				if(!isset($result[$url['url']]))
					$result[$url['url']] = 0;
				$temp_needle = strtoLower($needle);
				if(array_key_exists($temp_needle,$url['keywords']))//found
				{
				  $result[$url['url']] += $url['keywords'][$temp_needle];
				}
			}
		}
		$result = array_filter($result);//removing url where no keyword found
		arsort($result);//short by decending order
		return $result;
	}
	
	function omit($keywords)
	{
		$keywords = str_replace(',',' ', $keywords);
		array_map('trim',$keywords);
		$keywords = explode(' ',$keywords);
		$keywords = array_filter($keywords);
		$ad_con = $this->read_ad_con();
		$final = array();
		foreach($keywords as $index=>$key) {
			if(!in_array($key, $ad_con))
				array_push($final, $key);
		}
		return $final;
	}
}
?>