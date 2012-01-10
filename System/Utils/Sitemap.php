<?php

/***
 * Usage -> at the command line type php Sitemap.php
 * NB - This process is still partially manual. Once the program has been run the files 
 * need to be manually gzipped then copied to the website's root
 ***/

include("../Config/config.php");
include("SitemapXML.php");
require_once 'MDB/QueryTool.php';
require_once 'MyDB.class.php';


class Sitemap {

    private $MyDB;
	//Max Number of Rows to be contained in each Sitemap
	private $chunkSize = 49998;

	/**
     *  __construct
     *
     *  Instantiate MyDB object
     */
	public function __construct() {
	  $this->MyDB = new MyDB(DSN, array('errorCallback'=>'myErrHandle'), 2);
      $this->main();
	}
	
	private function main() {
	
	  echo "The Sitemaps are being generated";
	  ini_set('memory_limit', '512M');
	  ini_set('max_execution_time', -1);	  		  

      //Get all Ranked Listings
	  $rankedListingURLs = $this->getRankedListingURLs();
	  //Get all the States currently in the local_states table in the database
	  $states = $this->getStates();
	  //Get all Region URLs	 
	  $regionURLs = $this->getRegionURLs($states);
	  //Get all Suburb URLs	 
	  $suburbURLs = $this->getSuburbURLs($states);	  
	  
	  //Combine the Region and Suburb URLs	 
	  $urls = array_merge($suburbURLs, $regionURLs, $rankedListingURLs);	  
	  
	  //Split the URLs array into the $chunkSize value in class header
	  $urlChunks = array_chunk($urls, $this->chunkSize, true);
	  
	  //Instantiate the XML class for output in that format
	  $xml = new SitemapXML();
	  
	  //Loop that creates the individual XML files
	  foreach($urlChunks as $i => $urlChunk){
	    if($i > 1) {
		  $type = 'sitemap';
		} else $type = 'sitemap1';
	    $xml->createSitemapXML($urlChunk, $type, $i+1);
	  }	
	  
	  //Create the SitemapIndex File
	  if(isset($urlChunks)){
	    $chunkKeys = array_keys($urlChunks);
	    $type      = 'sitemapIndex';
        $xml->createSitemapXML($chunkKeys, $type, 0);		
      } 		
		
	  
	  print("Ranked Listing URL count is " . count($rankedListingURLs) . " Region URL count is " . count($regionURLs) . " and Suburb URL count is " . count($suburbURLs));
	  print("\nTotal Chunks are " . count($urlChunks));	  
	  print("\nTotal Count is " . count($urls));

	}
	
/**
*
* urlEncode all the entities in the Suburb or Region Arrays
*
**/	

  private function urlEncodeArray($elements) {
    
	foreach($elements as $i => $element) {
	  $elements[$i] = urlencode($element);	
	}
	
	return $elements;    
  }
  
/**
*
* Get and Create URLs based on Ranked Listings
*
***/	  

  private function getRankedListingURLs() {    
	  $listings = $this->getAllRankedListings();
	  foreach($listings as $listing){
	    //urlencode each element in this array
		$listing = $this->urlEncodeArray($listing);
		//create the ranked listing url for the sitemap
		$rankedListingURLs[] = SITE_PATH . implode('/', $listing);
	  }
  
    return array_unique($rankedListingURLs);  
  }
  
	
/**
*
* Get and Create URLs based on Classification and Region
*
***/	
	
    private function getRegionURLs($states) {
	
	  foreach($states as $state){
	    $regions = $this->getRegionsByState($state['localstate_id']);
		foreach($regions as $region){
		  //urlencode each element in this array
		  $regionEncoded = $this->urlEncodeArray($region);
		  //create the region url for the sitemap
          $url = SITE_PATH . implode('/', $regionEncoded);
          //if the url contains results insert into the $regionURLs array
          if($this->checkRegionResults($region) > 0){
            $regionURLs[] = $url;
          } else {
          //	print("NO Results for REGION URL $url\n");          
          } 
        }  		  
	  }		  	 
	  
      return array_unique($regionURLs);
	}
	
/**
*
* Get and Create URLs based on Classification and Suburb
*
***/		

    private function getSuburbURLs($states) {
	
	  foreach($states as $state){
	    $suburbs = $this->getSuburbsByState($state['localstate_id']);
		foreach($suburbs as $suburb){
		  //urlencode each element in this array
		  $suburbEncoded = $this->urlEncodeArray($suburb);
		  //create the suburb url for the sitemap		
          $url = SITE_PATH . implode('/', $suburbEncoded);                   
		  //if the url contains results insert into the $suburbURLs array
          if($this->checkSuburbResults($suburb) > 0){
            $suburbURLs[] = $url;
          } else {
          	print("NO Results for SUBURB URL $url\n");          
          }          
        }  		  
	  }		  	 
	  
      return array_unique($suburbURLs);		
	}
	
/**
*
* Check the for Ranked and Free Listings by Region
*
***/	
	
    private function checkRegionResults($region) {
      
      $freeCount   = $this->getFreeRegionResults($region);
      $rankedCount = $this->getRankedRegionResults($region);
          	
      return $rankedCount + $freeCount;	
    }
    
/**
*
* Check the for Ranked and Free Listings by Suburb
*
***/	
	
    private function checkSuburbResults($suburb) {
      
      $freeCount   = $this->getFreeSuburbResults($suburb);
      $rankedCount = $this->getRankedSuburbResults($suburb);
          	
      return $rankedCount + $freeCount;	
    }    
	
/**
*
* The database queries are located below
* NB - Order of the columns in the getRegions.. and getSuburbs.. functions are EXTREMELY important
*
***/

	private function getFreeRegionResults($region) {
	  $sql = "SELECT count(2) as count
                FROM shire_names sn, shire_towns st, 
                     local_businesses lb, business_classification bc
               WHERE sn.url_alias = '{$region['url_alias']}'
                 AND sn.shirename_id = st.shirename_id
                 AND st.shiretown_id = lb.shiretown_id
                 AND bc.localclassification_id = '{$region['localclassification_id']}'
                 AND bc.business_id = lb.business_id";
                 			  
	  $count = $this->MyDB->query($sql);	  
	  
      return $count[0]['count']; 
	}
	
	private function getFreeSuburbResults($suburb) {
      $sql = "SELECT count(2) as count
		        FROM business_classification bc, local_businesses lb
		       WHERE bc.localclassification_id = '{$suburb['localclassification_id']}'
		         AND lb.business_suburb = '{$this->MyDB->quote($suburb['shiretown_townname'])}'               
		         AND bc.business_id = lb.business_id";
	  	  	               			  
	  $count = $this->MyDB->query($sql);
/*
	  print($sql ."\n");	  
	  print_r($count);
	  print("\n\n");
*/	  
      return $count[0]['count']; 
	}	
	
	private function getRankedRegionResults($region) {
                 
      $sql = "SELECT count(2) as count
                FROM business_ranks br, shire_names sn
               WHERE br.localclassification_id = '{$region['localclassification_id']}'
                 AND br.shirename_id = sn.shirename_id
                 AND sn.url_alias = '{$region['url_alias']}'";
			  
	  $count = $this->MyDB->query($sql);	  
	  
      return $count[0]['count']; 
	}	
	
	private function getRankedSuburbResults($suburb) {
                       
      $sql = "SELECT count(2) as count
                FROM business_ranks br, shire_names sn, 
                     shire_towns st, local_state ls
               WHERE br.localclassification_id = '{$suburb['localclassification_id']}'
                 AND br.shirename_id = sn.shirename_id
                 AND sn.shirename_id = st.shirename_id
                 AND st.shiretown_townname = 'sans souci'
                 AND sn.shirename_state = ls.localstate_id
                 AND ls.localstate_name = '{$suburb['localstate_name']}'";      
			  
	  $count = $this->MyDB->query($sql);	  
	  
      return $count[0]['count']; 
	}	
	
	private function getStates() {
	  $sql = "SELECT localstate_id, localstate_name
                FROM local_state";
				
      return $this->MyDB->query($sql);
	}
	
	private function getAllRankedListings() {
	  $sql = "SELECT DISTINCT lb.url_alias, lb.business_id, 'listing'
                FROM local_businesses lb, business_ranks br
               WHERE br.business_id = lb.business_id";
			   
	  return $this->MyDB->query($sql);	        			   
	}	
	
	private function getRegionsByState($stateID) {
	  $sql = "SELECT lc.localclassification_name, ls.localstate_name, sn.url_alias, lc.localclassification_id
                FROM local_classification lc, shire_names sn, local_state ls
               WHERE lc.sitemap_order >= 1
	             AND sn.shirename_state = ls.localstate_id
	             AND ls.localstate_id = {$stateID}
               ORDER BY lc.sitemap_order";
			   
	  return $this->MyDB->query($sql);	        			   
	}
	
	private function getSuburbsByState($stateID) {
	  $sql = "SELECT lc.localclassification_name, ls.localstate_name, st.shiretown_townname, lc.localclassification_id
                FROM local_classification lc, shire_towns st, shire_names sn, local_state ls
               WHERE lc.sitemap_order >= 1
                 AND st.shirename_id = sn.shirename_id
	             AND sn.shirename_state = ls.localstate_id
	             AND ls.localstate_id = {$stateID}
               ORDER BY lc.sitemap_order";
			   
	  return $this->MyDB->query($sql);	        			   
	}	
	
}	

$result = new Sitemap();



?>
