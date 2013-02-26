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
	
	private function filterParams($params,$boo=''){	
		//dev_log::write("HELLO");
	  if ($boo) {
	      //var_dump($this->searchParams);
	       //var_dump($params);
	       //var_dump($params);
	       //die("A");
	   }
	
	  foreach($params as $i => $param){
	      //if ($boo) { die("B"); }
	     $strpos = strpos($param, '=');
	     $string_bit = substr($param, 0, $strpos);
	     if ($boo) {
	     	//dev_log::write("STRINGBIT=[$string_bit]");
	     }
	    if(in_array($string_bit, $this->searchParams)) {
	    	//if ($boo) { die("C"); }
	      $subject = substr($param, strpos($param, '=')+1, strlen($param));
	      $new_val = str_replace($this->filterURL, '', $subject);
		  $values[] = $new_val; //str_replace($this->filterURL, '', substr($param, strpos($param, '=')+1, strlen($param)));
	      if ($boo) {
	      	
	      	//dev_log::write("XXX [$subject] [$new_val]");
	      	//die("C");
	      	//die("D[$subject]");
	       //var_dump($values);
	       //var_dump($params);
	       //die("XXX[$subject]");
	      }
		} else {
			
		//	if ($boo) { die("E[$subject]"); }
		  $values = $params;
		}
	  }
	  
	  
	  //die();
	 if ($boo) {
	 	
	       //var_dump($values);
	       //var_dump($params);
	       //var_dump($values);
	       //die();
	      // die("F");
	   }
	  return $values;
	}

	public function createURL($do='', $action='', $params='', $boo='') {
		
		$url = $this->sitePath;		
		//die("[$do] [$action] [$params]");
		if(REWRITE_URL && $do == 'Listing' && $action == 'categorySearch' && isset($params)) {
			//if ($boo) { die("flag 1"); }
		  $paramsArr = array();
		  if($params!='') {	
		  
			$temp = explode('&', $params);
									
			if($temp) {
				//if ($boo) { die("[B]"); }	  
			  $values = $this->filterParams(array_values($temp),$boo);
			  
			  if ($boo) {
			  	//var_dump(array_values($temp));
			  	//var_dump($temp);
			  //var_dump($values);
			  //die();
			  }
			  
			  $paramsArr = array_merge($paramsArr, $values);
			  
			}
		  }
		  if ($boo) {  
		  	//var_dump($paramsArr);
		  	//die(implode("/", $paramsArr));
		  }	 
		  $url = $url.implode("/", $paramsArr);			
		//if ($boo) { die("[$url]"); }
		} elseif(REWRITE_URL && $do == 'Listing' && $action == 'categorySearchByRegion' && isset($params)) {
			
		//if ($boo) { die("flag 2"); }
			  
		    $url = ($do)?$url.CONTROLLER."?do=$do":$url;
			$url = ($action)?$url."&action=$action":$url;
			$url = ($params)?"$url&$params":$url;
			

		} elseif(REWRITE_URL){	
		//if ($boo) { die("flag 3"); }
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