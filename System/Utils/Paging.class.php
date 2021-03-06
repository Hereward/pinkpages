<?php
class Paging {

	private function __prepareQueryString($queryString) {				
		
		$temp = explode("&", $queryString);
		if(!$temp) return "";
		
		//!isset($_GET['class_region_filter']) &&
		
		if ($_GET['do'] == 'Listing' && ($_GET['action'] == 'categorySearch' || $_GET['action'] == 'categorySearchAlpha' || $_GET['action'] == 'searchStreetBusiness' || $_GET['action'] == 'search')){
		  //die("hello");
			$params = '';
		  foreach ($temp as $str) {
  	        if((strpos($str, "do=") === FALSE) && (strpos($str, "action=") === FALSE) && (strpos($str, "fr=") === FALSE) && (strpos($str, "pnum=") === FALSE)){
			  $params .= '&'.$str;
			}
		  }		
          
		  $url = new Request();
		  $ret_url = $url->createURL($_GET['do'], $_GET['action'], str_replace("+&+", "+%26+", substr($params, 1, strlen($params))),'boo');
		  //die("[{$_GET['do']}] [{$_GET['action']}] [$params] [$ret_url]");
		  return $ret_url;
		  //$url->createURL($_GET['do'], $_GET['action'], str_replace("+&+", "+%26+", substr($params, 1, strlen($params))));
		}
		
		$output = array();
		foreach ($temp as $str) {
	      if((strpos($str, "fr=") === FALSE) && (strpos($str, "pnum=") === FALSE)) $output[] = $str;		  
		}
		return implode("&", $output);
	}
	
	public static function numberPaging($totalRecords, $fr, $pagingSize, $xtra_pages_count=0) {		       
		if(stripos($_SERVER['PHP_SELF'], 'admin') > 0) {
		  //URL construction for admin pagination	
		  $url = $_SERVER['PHP_SELF']."?".self::__prepareQueryString($_SERVER['QUERY_STRING']);
		}else $url = self::__prepareQueryString($_SERVER['QUERY_STRING']);
		
		if($totalRecords <= $pagingSize) return false;

		$rec_on_last_page = $totalRecords%$pagingSize;
		$last = ($rec_on_last_page == 0)?$totalRecords-$pagingSize:$totalRecords-$rec_on_last_page;
		$last += $xtra_pages_count;
		$totalPages		= ceil($totalRecords/$pagingSize)+$xtra_pages_count;
		$start			= 1;
		$end			= $numOfLinks = 10;
		$half			= ($numOfLinks / 2);
		$curent_page	= ($fr / $pagingSize) + $start;
		if ($numOfLinks > $totalPages ) $numOfLinks = $totalPages;
		if ($fr && $curent_page >= $half) {
			$start	= (($fr / $pagingSize) + $start) - ($half);
			$end	= ($fr / $pagingSize) + $numOfLinks - ($half -1);
			$pLoop = ($fr / $pagingSize);

		}
		if (($start + $numOfLinks) > $totalPages && $totalPages >= $numOfLinks) {
			$start	= $totalPages - $numOfLinks + 1;
			$end	= $totalPages;
			$pLoop = $totalPages - $numOfLinks;
		}
		$start = ($start < 1) ? 1 : $start;
		$pre   = $fr-$pagingSize;
		$next  = $fr+$pagingSize;
		
		if($fr==$last) {
			$start++;
			$end++;
		}
		
		return array(
		          "totalPages"=>$totalPages,
		          "totalRecords"=>$totalRecords,
		          "pagingSize"=>$pagingSize,
		          "url"=>$url,
		          "fr"=>$fr,
		          "start"=>$start,
		          "end"=>$end,
		          "pre"=>$pre,
		          "next"=>$next,
		          "last"=>$last,
		          "diff"=>$xtra_pages_count*10
		          );
	}
}
?>