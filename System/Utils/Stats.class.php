<?php

/***
 * Stats Class
 * Currently stores the banner clicks, but will soon expand
 * 
 ***/

include("System/Config/config.php");
require_once 'MDB/QueryTool.php';
require_once 'MyDB.class.php';

/*
include("../Config/config.php");
include("/app_config.php");
include("/app_boot.php");
*/
class Stats {

    private $myDB;

	/**
     *  __construct
     *
     *  Instantiate MyDB object
     */
	public function __construct() {
	  $this->myDB = new MyDB(DSN, array('errorCallback'=>'myErrHandle'), 2);
	}
	
	/**
		* @desc This function will be used for to insert a record whenever a particular banner is viewed
		* @return.
		*/				
	public function setBannerImpression($businessID, $position, $classificationID, $marketID){
				
		$currentDate	= date('Y-m-d');

		$query		    = "SELECT impressions
		                     FROM banner_stats_impressions
							WHERE business_id = {$businessID}
							  AND position    = '{$position}'
							  AND localclassification_id = {$classificationID}
							  AND market_id   = {$marketID}
							  AND date        = '{$currentDate}'";
							 
		$countResult	= $this->myDB->query($query);		
						
		if(is_array($countResult) && count($countResult) <= 0)
		  {
	          $query = "INSERT INTO banner_stats_impressions (business_id, position, localclassification_id, market_id, date, impressions)
	                    VALUES({$businessID}, '{$position}', {$classificationID}, {$marketID}, now(), 1)";
												
			  $result = $this->myDB->query($query);
						
		  } else {
		  
		      $impressions = $countResult[0]['impressions'] + 1;
		  
		      $query = "UPDATE banner_stats_impressions
			               SET impressions             = {$impressions}
						 WHERE business_id             = {$businessID}
						   AND position                = '{$position}'
						   AND localclassification_id  = {$classificationID}
						   AND market_id               = {$marketID}
						   AND date                    = '{$currentDate}'";
		  
			  $result	=$this->myDB->query($query);
		  }
				
		return $result;	  
	  	
	}	
	
	
	/**
		* @desc This function will be used for to insert a record whenever a particular banner is viewed
		* @return.
		*/				
	public function setBannerClick($bannerID){
	
	    $valid  = $this->validateBannerID($bannerID);
		$result = FALSE;
	
        if( $valid != FALSE) {
				
		  $currentDate	    = date('Y-m-d');
		  $businessID       = $valid['business_id'];
		  $position         = $valid['position'];
		  $classificationID = $valid['localclassification_id'];
		  $marketID         = $valid['market_id'];
		  $bannerLink       = $valid['banner_link'];

		  $query		    = "SELECT clicks
		                         FROM banner_stats_clicks
			  				    WHERE business_id = {$businessID}
							      AND position    = '{$position}'
							      AND localclassification_id = {$classificationID}
							      AND market_id   = {$marketID}
							      AND date        = '{$currentDate}'";
							 
		  $countResult	= $this->myDB->query($query);		
						
		  if(is_array($countResult) && count($countResult) <= 0)
		    {
	            $query = "INSERT INTO banner_stats_clicks (business_id, position, localclassification_id, market_id, date, clicks)
	                      VALUES({$businessID}, '{$position}', {$classificationID}, {$marketID}, now(), 1)";
						  
                $this->myDB->query($query);						  
												
			    $result = $bannerLink;
						
		    } else {
		  
		        $clicks = $countResult[0]['clicks'] + 1;
		  
		        $query = "UPDATE banner_stats_clicks
			                 SET clicks                  = {$clicks}
						   WHERE business_id             = {$businessID}
						     AND position                = '{$position}'
						     AND localclassification_id  = {$classificationID}
						     AND market_id               = {$marketID}
						     AND date                    = '{$currentDate}'";
							 
                $this->myDB->query($query);							 
		  
			    $result = $bannerLink; 
		    }
				
		  return $result;	  
		}
	  	
	}
	
	private function getBannerDetails($bannerID){
	 
	  $query = "SELECT business_id, position, localclassification_id, market_id, banner_link
	              FROM banner
				 WHERE banner_id = {$bannerID}";
				  
	  return $this->myDB->query($query);		  
	
	}
	
	
	/* 
	 * Checks if the $bannerID is an INT
	 * @return TRUE if $bannerID is type int FALSE otherwise
	 */
	 
	private function validateBannerID($bannerID){
	
	  if(is_int($bannerID)){
	    $tmp   = $this->getBannerDetails($bannerID);
		$valid = $tmp[0];
      } else {
	    $valid = FALSE;
	  }	

      return $valid;	  
	
	}
	
}


?>