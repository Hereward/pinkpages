<?php 

/**
 *  UrlFacade.class.php
 *
 *  The creation of this class for canonical URL checking may have
 *  been a little overkill, but there have been issues with
 *  the PPO URLs and I wanted to validate each url segment.
 *  Once the site is stable with respect to the transitioning URL
 *  Structure, this class may be 'switched off' and replaced with
 *  simpler, faster code.
 *
 *  ToDos
 *  Get State from Suburb/Region if state is Null
 *  Include pagination parameters in all the canonicals
 *
 *
 */



class UrlFacade extends MainFacade {

   	private $searchSessionDetails = array('suburb', 'region', 'state', 'category');

	/**
     *  __construct
     *
     *  Instantiate MyDB object
     */
	public function __construct(MyDB $myDB, Request $request) {

		parent::__construct($myDB, $request);
		$this->myDB = $myDB;
		$this->myDB->table=TBL_LOCAL_BUSINESS;
		$this->myDB->sequenceName=TBL_LOCAL_BUSINESS;
		$this->myDB->primaryCol="business_id";
	}/* END __construct */
	
  /**
   * Get a Canonical URL
   *
   * Get a Canonical URL based on the Types and parameters contained within the $_GET array
   *
   * @param  string  $type The type of Canonical to be generated. Possible Types are 'listing', 'suburb', 'region', 'state', 'country'
   * @param  array   $get  The $_GET array
   * @return string  The generated Canonical URL
   */
	
	public function getCanonical($type, $get){
	
	  switch ($type) {
	    case 'listing':
		  $url = $this->getListingCanonical($get);
	      break;	  
	    case 'suburb':
		  $url = $this->getSuburbCanonical($get);
	      break;
		case 'region':
		  $url = $this->getRegionCanonical($get);
	      break;
		case 'state':
		  $url = $this->getStateCanonical($get);
	      break;		  
	  }
	  
	  return $url;
		
	}
	
	public function getRegionFromSuburb($suburbName){
	
      $suburbName = GeneralUtils::handle_input($suburbName);	
	
	  $sql = "SELECT sn.shirename_shirename
                FROM shire_towns st, shire_names sn
               WHERE shiretown_townname = '{$suburbName}'
                 AND st.shirename_id = sn.shirename_id";
				 
      $results = $this->myDB->query($sql);
	  
	  $region = $results[0]['shirename_shirename'];
	  
	  return $region;
				       				 		
	}
	
	
	//all Australia
	private function getCountryCanonical(){
	
	}
	
	//All NSW, or VIC, ACT, etc
	private function getStateCanonical($get){
		
	  //Check and/or resolve $get['category']
	  if($get['category']){
        $cat        = GeneralUtils::handle_input($get['category']);
	    $categoryDB = $this->validateClassificationName($cat);
		//If a single category is returned 
		if($cat == $categoryDB){
		  $category = $categoryDB;
		//If multiple categories are installed  
		} else if(is_array($categoryDB)){
		  $category = (in_array($cat, $categoryDB)) ? $cat : '';
		}
	  } 
	  
      //Check and/or resolve $get['search']	  
	  if($get['search']){
        $search     = GeneralUtils::handle_input($get['search']);
	    $searchDB   = $this->validateClassificationID($search);
		//If a single classificationID is returned 
		if($search == $searchDB){
		  $classificationID = $searchDB;
		//If multiple categories are installed  
		} else if(is_array($searchDB)){
		  $classificationID = (in_array($search, $searchDB)) ? $search : '';
		}
	  }
	  	  
	  //Check and/or resolve the state $get['state']	  
	  if(isset($get['state'])){
	    $localState   = GeneralUtils::handle_input($get['state']);
		$stateDB = $this->validateStateName($localState);
		if(strcasecmp($localState, $stateDB)==0){
		  $state = $stateDB;
		} else if(is_array($stateDB)){
		  $state = (in_array($localState, $stateDB)) ? $localState : ''; 
		}
	  } else $state = 'NSW';
	  	  
	  if(isset($category) && isset($state) && isset($classificationID)){
	    $url = urlencode($category) . "/" . $state . "/" . $classificationID;
		if(isset($get['pnum']) && isset($get['fr']))
	      $url = urlencode($category) . "/" . $state . "/" . $classificationID . "/pnum/" . $get['pnum'] . "/fr/" . $get['fr'];		
	  } else $url = false;
	  	 
	  return $url;		
	
	
	}
	
	private function getRegionCanonical($get){

	  //Check and/or resolve $get['category']
	  if($get['category']){
        $cat        = GeneralUtils::handle_input($get['category']);
	    $categoryDB = $this->validateClassificationName($cat);
		//If a single category is returned 
		if($cat == $categoryDB){
		  $category = $categoryDB;
		//If multiple categories are installed  
		} else if(is_array($categoryDB)){
		  $category = (in_array($cat, $categoryDB)) ? $cat : '';
		}
	  } 

      //Check and/or resolve $get['search']	  
	  if($get['search']){
        $search     = GeneralUtils::handle_input($get['search']);
	    $searchDB   = $this->validateClassificationID($search);
		//If a single classificationID is returned 
		if($search == $searchDB){
		  $classificationID = $searchDB;
		//If multiple categories are installed  
		} else if(is_array($searchDB)){
		  $classificationID = (in_array($search, $searchDB)) ? $search : '';
		}
	  }
	  
	  //Check and/or resolve the suburb $get['shire_town']
	  if($get['shire_name']){
	    $shireName   =  GeneralUtils::handle_input($get['shire_name']);
	    $shireNameDB =  $this->validateRegionName($shireName);
		if($shireNameDB){
		  $region = $shireNameDB;
		} else if(is_array($shireNameDB)){
		  $region = (in_array($shireName, $shireNameDB)) ? $shireName : '';
		}
	  }

	  //Check and/or resolve the state $get['state']	  
	  if($get['state']){
	    $localState   = GeneralUtils::handle_input($get['state']);
		$stateDB = $this->validateStateName($localState);
		if(strcasecmp($localState, $stateDB)==0){
		  $state = $stateDB;
		} else if(is_array($stateDB)){
		  $state = (in_array($localState, $stateDB)) ? $localState : ''; 
		}
	  } else $state = 'NSW';
	  
	  if(isset($category) && isset($state) && isset($region) && isset($classificationID)){
	    $url = urlencode($category) . "/" . $state . "/" . urlencode($region) . "/" . $classificationID;
		if(isset($get['pnum']) && isset($get['fr']))
	      $url = urlencode($category) . "/" . $state . "/" . urlencode($region) . "/" . $classificationID . "/pnum/" . $get['pnum'] . "/fr/" . $get['fr'];		
	  } else $url = false;
	  	 
	  return $url;	
	
	}
	
  /**
   * Get Suburb Canonical URL
   *
   * Get a Canonical URL for a Suburb search /{classification name}/{state}/{suburb}/{classification ID}
   *
   * @param  array   $get  The $_GET array
   * @return string  The generated Canonical URL
   */
	
	private function getSuburbCanonical($get){
	
	  //Check and/or resolve $get['category']
	  if($get['category']){
        $cat        = GeneralUtils::handle_input($get['category']);
	    $categoryDB = $this->validateClassificationName($cat);
		//If a single category is returned 
		if($cat == $categoryDB){
		  $category = $categoryDB;
		//If multiple categories are installed  
		} else if(is_array($categoryDB)){
		  $category = (in_array($cat, $categoryDB)) ? $cat : '';
		}
	  } 

      //Check and/or resolve $get['search']	  
	  if($get['search']){
        $search     = GeneralUtils::handle_input($get['search']);
	    $searchDB   = $this->validateClassificationID($search);
		//If a single classificationID is returned 
		if($search == $searchDB){
		  $classificationID = $searchDB;
		//If multiple categories are installed  
		} else if(is_array($searchDB)){
		  $classificationID = (in_array($search, $searchDB)) ? $search : '';
		}
	  }
	  
	  //Check and/or resolve the suburb $get['shire_town']
	  if($get['shire_town']){
	    $shireTown   =  GeneralUtils::handle_input($get['shire_town']);
	    $shireTownDB =  $this->validateSuburbName($shireTown);
		if((!is_array($shireTownDB)) && (!is_array($shireTown)) && strcasecmp($shireTown, $shireTownDB) == 0){
		  $suburb = $shireTownDB;
		} else if(is_array($shireTownDB)){
		  $suburb = (in_array($shireTown, $shireTownDB)) ? $shireTown : '';
		}
	  }

	  //Check and/or resolve the state $get['state']	  
	  if($get['state']){
	    $localState   = GeneralUtils::handle_input($get['state']);
		$stateDB = $this->validateStateName($localState);
		if(strcasecmp($localState, $stateDB)==0){
		  $state = $stateDB;
		} else if(is_array($stateDB)){
		  $state = (in_array($localState, $stateDB)) ? $localState : ''; 
		}
	  } else $state = 'NSW';
	  
	  if(isset($category) && isset($state) && isset($suburb) && isset($classificationID)){
	    $url = urlencode($category) . "/" . $state . "/" . urlencode($suburb) . "/" . $classificationID;
		if(isset($get['pnum']) && isset($get['fr']))
	      $url = urlencode($category) . "/" . $state . "/" . urlencode($suburb) . "/" . $classificationID . "/pnum/" . $get['pnum'] . "/fr/" . $get['fr'];		
	  } else $url = false;
	  	 
	  return $url;
	}
	
	private function getListingCanonical($get){
	
      $businessID = GeneralUtils::handle_input($get['ID']);	  
	  
	  if($businessID){
	    $urlAlias = $this->getUrlAlias($businessID);
	  }
	  
	  if(isset($businessID) && isset($urlAlias)){
	    $url = $urlAlias."/".$businessID."/listing";
	  } else $url = false;
	  	  
	  return $url;
	 
	}
	
	private function getUrlAlias($businessID){
	  $sql = "SELECT url_alias
	            FROM local_businesses
               WHERE business_id = " . $businessID;
			   			   
      $results = $this->myDB->query($sql);			   
	  
	  $urlAlias = $results[0]['url_alias'];
	  
	  return $urlAlias;
	}
	
	private function validateAtom($param, $validateFunction){
	
	}
	
	private function getStateFromShireID($regionID){
	
	}
			
	private function getStateFromShireName($regionID){
	
	}	
	
	private function getShireFromSuburbID($suburbID){
	
	}
	
	private function getShireFromSuburbName($suburbName){
	
	}	
	
	private function validateClassificationName($classificationName){
	
	  $sql = "SELECT lc.localclassification_name
                FROM local_classification lc
               WHERE lc.localclassification_name = '" . $this->myDB->quote(GeneralUtils::handle_input($classificationName)) ."'";
			   			   
      $results = $this->myDB->query($sql);
	  
	  if(count($results) == 1){
        return $results[0]['localclassification_name'];
	  } else return $results;
	
	}
	
	private function validateClassificationID($classificationID){
	
	  $sql = "SELECT lc.localclassification_id
                FROM local_classification lc
               WHERE lc.localclassification_id = " . GeneralUtils::handle_input($classificationID);

      $results = $this->myDB->query($sql);
	  	  
	  if(count($results) == 1){
        return $results[0]['localclassification_id'];
	  } else return $results;
	
	}
	
	private function validateRegionName($regionName){
	  $sql = "SELECT url_alias
	            FROM shire_names
			   WHERE shirename_shirename = '" . $regionName . "'";
      $results = $this->myDB->query($sql);
	  
	  if(count($results) == 1) {
	    return $results[0]['url_alias'];
	  } else return $results;
	  
	}	
	
	private function validateSuburbName($suburbName){
	  $sql = "SELECT shiretown_townname
	            FROM shire_towns
			   WHERE shiretown_townname = '" . $suburbName . "'";
			   			   
      $results = $this->myDB->query($sql);
	  
	  if(count($results) == 1) {
	    return $results[0]['shiretown_townname'];
	  } else return $results;
	  
	}
	
	private function validateStateName($stateName){
	  $sql = "SELECT localstate_name
                FROM local_state ls 
               WHERE ls.localstate_name = '" . $stateName . "'";
      
      $results = $this->myDB->query($sql);			   
	  
	  if(count($results) == 1) {
	    return $results[0]['localstate_name'];
	  } else return $results;
	  	
	}
	
  /**
   * Set Session Information for use in the Listing Meta Tags
   *
   * @param  array   $details Information used in the listing meta tags
   * @return void
   */
	
	public function setListingDetails($details = array()){
	
      if(count($details) >  0){
	    $this->unSetSessionDetails();
	    foreach($details as $key=>$value){
          setSession($key, $value);
		}
	  } else
	      $this->unSetSessionDetails();
	}
	
	private function unSetSessionDetails($details = array()){
	
	  if(count($details) == 0){
	    $details = $this->searchSessionDetails;
	  }
	
      if(count($details) >  0){
	    foreach($details as $value){
          unset($_SESSION[USERNAMESPACE]["$value"]);
		}
	  }		
	}
		
}
	
?>	