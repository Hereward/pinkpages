<?php
class Request {

	var $attributes = array();

	private $sitePath;
	//private $searchParams = array('category', 'shire_town', 'shire_name', 'search', 'hours', 'payment', 'brand', 'val', 'service');
	//Allowable search params for the classification searches
    private $searchParams = array('category', 'shire_town', 'shire_name', 'state', 'search', 'postcode');	
	
	//Characters that should be removed when generating a url
	//private $filterURL = array('&', '%26');
    private $filterURL = array();	
	
	public function __construct($sitePath = SITE_PATH) {
		$this->sitePath = $sitePath;
		//setting all $_GET values to this		
		foreach ($_GET as $key=>$val) {
			$this->setAttribute($key, $val);
		}
	}

	function getAttribute($name) {
		if( array_key_exists($name, $this->attributes) )
		return $this->attributes[$name];	// attributes.get(name)
		else
		return NULL;
	}

	function setAttribute($name, $value) {

		// Name cannot be null
		if($name == NULL) {
			return;
		}

		// Null value is the same as removeAttribute() !!!!!!!!!!
		if($value === NULL) {
			$this->removeAttribute($name);
			return;
		}

		$this->attributes[$name] = $value; // attributes.put(name, value)
	}

	function zapArrayElement($key, &$array) {

		$idx = array_search( $key, array_keys($array) );

		if( $idx === NULL || $idx === False) {
			return False; // Not found, nothing to do
		} else {
			array_splice( $array, $idx, 1);
			return True;
		}
	}

	function removeAttribute($name) {

		// Remove the specified element from the attributes array, including the key.
		$this->zapArrayElement($name, $this->attributes);

	}

	function setAttributeArray($Arr) { //sets attributes of array assoc to respective values

		if(is_array($Arr)) {

			foreach ($Arr as $key=>$val) {
				$this->setAttribute("$key", "$val");
			}
		}
	}

	function redirect($do='', $action='', $params='') {

		$url = $this->createURL($do, $action, $params);
		header("Location:".$url);
	}
	
	private function filterParams($params){	
	
	  foreach($params as $i => $param){
	   
	    if(in_array(substr($param, 0, strpos($param, '=')), $this->searchParams)){
		  $values[] = str_replace($this->filterURL, '', substr($param, strpos($param, '=')+1, strlen($param)));
		} else $values = $params;
	  }
	  return $values;
	}

	public function createURL($do='', $action='', $params='') {
		
		$url = $this->sitePath;		
		
		if(REWRITE_URL && $do == 'Listing' && $action == 'categorySearch' && isset($params)) {
			  
		  $paramsArr = array();
		  if($params!='') {		  
			$temp = explode('&', $params);
									
			if($temp) {
			  $values = $this->filterParams(array_values($temp));
			  $paramsArr = array_merge($paramsArr, $values);
			}
		  }
		  $url = $url.implode("/", $paramsArr);				  

		} else if(REWRITE_URL){	
	
		  $paramsArr = array();
		  if($do) $paramsArr[] = $do;
		  if($action) $paramsArr[] = $action;
		  if($params!='') {
			$temp = split("[&=]", $params);
			if($temp) {
			  $paramsArr = array_merge($paramsArr, $temp);
			}
		  }
		  $url = $url.implode("/", $paramsArr);		
		
		} else {

			$url = ($do)?$url.CONTROLLER."?do=$do":$url;
			$url = ($action)?$url."&action=$action":$url;
			$url = ($params)?"$url&$params":$url;
		}
		return $url;
	}
	
	public function createNaturalURL($do='', $action='', $params='') {
		    $url = $this->sitePath;				
			$url = ($do)?$url.CONTROLLER."?do=$do":$url;
			$url = ($action)?$url."&action=$action":$url;
			$url = ($params)?"$url&$params":$url;
      return $url;
	}	

	public function prepareQS($qs, $repArray) {

		$xtra = array();
		$qs_arr = explode("&", $qs);
		if(is_array($qs_arr)) {
			foreach ($qs_arr as $k=>$v) {
				if(is_array($repArray)) {
					foreach ($repArray as $k1=>$v1) {
						if(strpos($qs_arr[$k], $k1."=") !== false) {
							unset($qs_arr[$k]);
							$xtra[] = "$k1=$v1";
							break;
						}

					}
				}
			}
		}
		return implode("&", array_merge($xtra, $qs_arr));
	}

	public function replaceQS($qs, $repArray) {

		$xtra = array();
		$qs_arr = explode("&", $qs);
		if(is_array($repArray)) {
			if(is_array($qs_arr)) {
				foreach ($qs_arr as $k=>$v) {
					foreach ($repArray as $k1=>$v1) {
						if(isset($qs_arr[$k])) {
							if(strpos($qs_arr[$k], $k1."=") !== false) {
								unset($qs_arr[$k]);
							}
						}
					}
				}
			}
		}
		foreach ($repArray as $k=>$v) {
			$xtra[] = $k."=".$v;
		}
		//		prexit(array_merge($qs_arr, $repArray));
		return implode("&", array_merge($qs_arr, $xtra));
	}
}
?>