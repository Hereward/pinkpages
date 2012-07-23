<?php
class KeyFacade extends MainFacade {

    /**
     *  __construct
     *
     *  Instantiate MyDB object
     */
    public function __construct(MyDB $MyDB, Request $request) {

        parent::__construct($MyDB, $request);
        $this->MyDB = $MyDB;
        $this->MyDB->table="local_classification";
        $this->MyDB->sequenceName="local_classification";
        $this->MyDB->primaryCol="localclassification_id";
    }/* END __construct */

 public function fetchClassificationDetails()
    {
        $sql="SELECT *
			  FROM
			  local_classification
			  order by localclassification_name ";
        $rec=$this->MyDB->query($sql);
        return $rec;
    }

public function fetchUniqueKeywords()
    {
        $sql="SELECT Distinct Keyword
              FROM keywords
              ORDER BY KEYWORD";
        $rec=$this->MyDB->query($sql);
        return $rec;
    }
	
	/**
     *  loadAjax
     *
     *  Load Keywords and/or Classifications for ajax suggest
     * 
     * @param   array   get        	keyword
     * @return  object  			Json object
     * 
     */
	public function loadAjax($get) {		
		if(isset($get['keyword'])){
		  $classifications = $this->fetchClassificationfromKeyword($get['keyword']);
		  header("Content-Type: application/html");		  		  		  		 
          echo '<div class="keywordoutput">';
	      echo '  <ul class="synonym_output">';
		  foreach($classifications as $classification){		  
            echo "<li>".$classification['localclassification_name']."</li>";
		  }
		  echo'  </ul>';
          echo'</div>';
		}
	}	
			
public function fetchClassificationFromKeyword($keyword) {

        $sql = "SELECT lc.localclassification_name
                  FROM local_classification lc, keywords k
                 WHERE k.keyword = '".$keyword."'
                   AND k.localclassification_id = lc.localclassification_id
			  ORDER BY lc.localclassification_name";				   
				   
        $rec=$this->MyDB->query($sql);
        return $rec;				   		
}

public function fetchKeywordFromClassification($classificationID) {
	   
		$sql = "SELECT k.keyword, k.id
                  FROM keywords k, local_classification lc
                 WHERE k.localclassification_id = ".$classificationID."
                   AND lc.localclassification_id = ".$classificationID."
              ORDER BY lc.localclassification_name";   
		   				   
        $rec=$this->MyDB->query($sql);
        return $rec;				   		
}
	
 public function addlist($post)
	{
     @$res1 =$this->__synonymValidation($post);
	
	  if(!$res1['result'])
	   {
          return $res1;
        }
         else
         {
      $name = mysql_real_escape_string($post['name']);
      $sql2="SELECT 
			       localclassification_id 
			 FROM 
				   local_classification
			 WHERE
			       localclassification_name='".$name."'"; 
   
            $rec=$this->MyDB->query($sql2);
            $keyword = mysql_real_escape_string($post['keyword']);
            $sql="INSERT
			      INTO 
				      keywords(localclassification_id,keyword)
				  VALUES
				      ({$rec[0]['localclassification_id']},'$keyword')";	  
					      
            $this->MyDB->query($sql);
            $rec=array("result"=>true, "message"=>'Added Successfully');
            return $rec;
		}	
      }
	  
	  private function __synonymValidation(&$data)
    {

        $retArray = array("result"=>false, "message"=>'');
        $errors = array();
		
        if($data['name'] == '0') 
		{
             $errors[] = "Please Select any Classification";
        }
        if(empty($data['keyword']))
		{
             $errors[] = "Synonym is blank!!";
        }
       
        if(count($errors) == 0)
	    {
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }
	  
 /* public function viewfetchDetails($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
    {   		
	    $retArray = array();
        $this->MyDB->addWhere("localclassification_id!=0");
        $res=$this->MyDB->getAll($fr, $noOfRecords);
		$SQL="SELECT
		          count(localclassification_id) AS cnt 
			  FROM 
			      local_classification
			  WHERE 
			       localclassification_id!=0";
		      
	    $count_all = $this->MyDB->query($SQL);
        $retArray['listings'] = $res;
        $retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
        return $retArray;
      }	 */
	 
	 public function countLocations()
  {
	$ret = 0;
	$SQL="SELECT count(localclassification_id) AS cnt 
	      FROM keywords";
	$result = $this->MyDB->query($SQL);	  
		      
	/*$this->MyDB->setSelect("count(localclassification_id) as cnt");
	$result = $this->MyDB->getAll();*/
	$ret = $result[0]['cnt'];
	return $ret;
  } 
	  


    //Function used for keys_show.tpl	  
	public function viewfetchDetails($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
	 $SQL="SELECT 
	             *
		   FROM
		         local_classification AS lc,
				 keywords AS kw 
		   WHERE 
		         lc.localclassification_id=kw.localclassification_id
				 ORDER BY kw.id DESC
				 LIMIT $fr,".DEFAULT_PAGING_SIZE;
	 $result=$this->MyDB->query($SQL);
	 $res['blogs'] = $result;
	$res['paging'] = Paging::numberPaging($this->countLocations(), $fr, 10);
	return $res;
		
	} 
	
  public function editKeyword($ID, $keyword)
  {
    if(AccessDetails::isAdmin(getSession('username'))) { 
	  $SQL = "UPDATE 
				  keywords
		  	SET
			 	  keyword='{$keyword}' 
			WHERE 
				  id={$ID}";
	  $this->MyDB->query($SQL);
    }	  
  }  
  
   public function deleteKey()
  {
    if(AccessDetails::isAdmin(getSession('username'))) {
      $ID			=$_GET['ID'];
	  $SQL = "DELETE 
			  FROM keywords
			  WHERE 
				  id={$ID}";
	  $this->MyDB->query($SQL);
	
 	/*$this->MyDB->setWhere("localclassification_id=$ID") ;
    $this->MyDB->remove($ID);*/
      $Array = array("result"=>true, "message"=>'Deleted Successfully');
      return $Array; 
    }	  
	return "";
  }  
  
  public function editFetchDetails($post)
  {
   $SQL="SELECT *
         FROM keywords AS kw,local_classification lc 
		 WHERE kw.localclassification_id=lc.localclassification_id
	     AND
  	       lc.localclassification_name='{$post['name']}'";
 	$this->MyDB->query($SQL);	   
  }
	   
}	  
 ?> 
	