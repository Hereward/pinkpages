<?php

class SitemapXML {

  /***
  * 
  * $type has 3 possible values sitemap1, sitemap, sitemapIndex
  * $arrayRows is an array of strings that simply contains the URLS
  *
  ***/

  public function createSitemapXML($arrayRows, $type, $chunkCount){
  
    if($type == 'sitemap1'){                  
      $content   = $this->createXMLHeader();
	  $content  .= $this->createBasepathXML();
	  foreach($arrayRows as $arrayRow){
	   $content .= $this->addSitemapEntry($arrayRow);
	  } 
	  $content  .= $this->createXMLFooter();
	  $fileName  = "sitemap".$chunkCount.".xml";
	} else if($type == 'sitemap'){
      $content   = $this->createXMLHeader();
	  //$content  .= $this->createBasepathXML();
	  foreach($arrayRows as $arrayRow){
	   $content .= $this->addSitemapEntry($arrayRow);
	  } 
	  $content  .= $this->createXMLFooter();		
	  $fileName  = "sitemap".$chunkCount.".xml";	  
	} else if($type == 'sitemapIndex'){
      $content  = $this->createSitemapIndexHeader();	
	  foreach($arrayRows as $arrayRow){
        $content .= $this->addSitemapIndexEntry(SITE_PATH."sitemap". ($arrayRow + 1) . ".xml.gz");	
	  }
      $content .= $this->createSitemapIndexFooter();			  
	  $fileName  = "sitemapindex.xml";	  
	}
	
	if(isset($fileName) && isset($content)){
      $this->createFile($fileName, $content);
    }else {
	  echo "No Content to create sitemap.xml";	  
	}  
	  
  }
  
  private function createFile($filename, $content){
    //file_put_contents($filename, $content) or die("\nCannot write file ".$filename);
	file_put_contents($filename.".gz", gzencode($content, 9)) or die("\nCannot write file ".$filename);	  
	echo "\nFilename " . $filename . " was successfully written\n";
  }

  /***
  *  
  *  Functions that create the sitemap index xml
  *  
  *
  ***/

  public function createSitemapIndexHeader() {

    $xml  = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    return $xml;
  }
  
  /***
  *  Adds an entry to the sitemap index 
  *  Format example http://www.example.com/sitemap2.xml.gz
  ***/
  public function addSitemapIndexEntry($url) {
  
    $xml  = '<sitemap>';
	$xml .= '   <loc>'.$url.'</loc>';
    $xml .= '   <lastmod>'.date('Y-m-d',mktime()).'</lastmod>';
    $xml .= '</sitemap>';	
  
    return $xml;
  }
  
  public function createSitemapIndexFooter() {
  
    $xml = '</sitemapindex>';
	
	return $xml;

  }  
 
  /***
  *  
  *  Functions that create the sitemap xml
  *  
  *
  ***/  

 
  function createBasepathXML() {
	
    $file_modified_time = date('Y-m-d',mktime());
	
	$xml  = "<url>";
    $xml .= "  <loc>".SITE_PATH."</loc>";
    $xml .= "  <lastmod>$file_modified_time</lastmod>";
    $xml .= "  <changefreq>monthly</changefreq>";
    $xml .= "  <priority>1.0</priority>";
	$xml .= "</url>";
	
	return $xml;
	
 }
 
 function createXMLHeader() {
 
    $xml  = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

	return $xml;
 }
  
 function addSitemapEntry($url) {
 	
 	$file_modified_time = date('Y-m-d', mktime());
	
	 $xml  = "<url>";
     $xml .= "  <loc>$url</loc>";
     $xml .= "  <lastmod>$file_modified_time</lastmod>";
     $xml .= "  <changefreq>weekly</changefreq>";
     $xml .= "  <priority>0.8</priority>";
	 $xml .= "</url>";
	
	return $xml;
 } 
 
 function createXMLFooter() {
	return '</urlset>';
 }

} 
?>