<?

class SearchRefineFacade extends MainFacade {

  public function __construct(MyDB $myDB, Request $request) {
		parent::__construct($myDB, $request);
		$this->myDB = $myDB;
  }
 
  public function isSuburb($suburb){
  
    $sql = "SELECT shiretown_townname
              FROM shire_towns
             WHERE shiretown_townname = $suburb";
			 
	$result = $this->MyDB->query($sql);

  	return $result;       
  }
  
  public function isRegion($region){
  
  }
  
  public function getRegionBySuburb($suburb, $state = ''){
    if($state == ''){  
      $sql = "SELECT shirename_shirename, url_alias
                FROM shire_names sn, shire_towns st
               WHERE sn.shirename_id = st.shirename_id
                 AND shiretown_townname = '".mysql_real_escape_string($suburb)."'";
	} else {
      $sql = "SELECT shirename_shirename, url_alias 
                FROM shire_names sn, shire_towns st, local_state lc
               WHERE sn.shirename_id = st.shirename_id 
                 AND sn.shirename_state = lc.localstate_id
	             AND lc.localstate_name = '" . mysql_real_escape_string($state) .
              "' AND st.shiretown_townname = '" . mysql_real_escape_string($suburb) ."'";
    }				   
			   
	$result = $this->myDB->query($sql);			   
	
  	return $result;       	  
  }
  
  public function getSuburbsByRegion($region){
  
    $sql = "SELECT shiretown_townname
              FROM shire_names sn, shire_towns st
             WHERE sn.shirename_id = st.shirename_id
               AND shirename_shirename = '$region'
          ORDER BY shiretown_townname";  
		  
	$result = $this->myDB->query($sql);			   
	
  	return $result;       	  		  
  
  }


}

?>