<?php
class LocationFacade extends MainFacade {

    public function __construct(MyDB $MyDB){           //Start of The __contructor.purpose is to assign database parmeters to                                                       //a variable acting as an object and using that object to declare
        $this->MyDB = $MyDB;                           //the table name,sequence name and primary column.
        $this->MyDB->table="shire_towns";
        $this->MyDB->sequenceName="shire_towns";
        $this->MyDB->primaryCol="shiretown_id";
    }

 public function addLocationShires($post)
 {
   @$res1 =$this->__validationShires($post);
	  if(!$res1['result'])
	   {
          return $res1;
        }
         else
         {
   	$SQL="SELECT
	           shirename_id,shirename_shirename,shirename_state
		  FROM
		      shire_names";
	$result=mysql_query($SQL);
	while($var=mysql_fetch_assoc($result))
	{
	  $rows1[]=$var;
	}
	$SQL="SELECT 
	            localstate_id 
		  FROM
		        local_state 
		  WHERE 
		        localstate_name='{$post['state']}'";
	$results=mysql_query($SQL);
	while($res=mysql_fetch_assoc($results))
	{
	  $rows[]=$res;
	}
	if($post['shirename']!=$result['shirename_shirename'])
	{
	 $SQL="INSERT 
	       INTO 
			 shire_names(shirename_shirename,region_code,shirename_state)
		   VALUES
			   ('{$post['shirename']}','{$post['regioncode']}','{$rows[0]['localstate_id']}')";//prexit($SQL);
			   $result=$this->MyDB->query($SQL);
			   
	 $SQL1="INSERT 
	       INTO 
			 bcp_regions(REGION_CODE,REGION_NAME)
		   VALUES
			   ('{$post['regioncode']}','{$post['shirename']}')";//prexit($SQL1);
			   $result1=$this->MyDB->query($SQL1);		   
			   $Array = array("result"=>true, "message"=>'Added successfully');//prexit($Array);
             
	} return $Array;
	}  
  }
  
  private function __validationShires(&$data)
    {

        $retArray = array("result"=>false, "message"=>'');
        $errors = array();
        if(empty($data['shirename'])) 
		{
            $errors[] = "Shirename is blank!!";
        }
		
		if(empty($data['regioncode'])) 
		{
            $errors[] = "Please enter region code!!";
        }
            
        if(count($errors) == 0)
	    {
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }
  
  public function addLocationTowns($post)
  {
    @$res1 =$this->__validationTowns($post);
	if(!$res1['result'])
	 {
        return $res1;
      }
     else
    {
	$SQL="SELECT 
		            shirename_id 
		  FROM
			        shire_names 
		  WHERE
			        shirename_shirename='{$post['shirename']}'";
		$result=mysql_query($SQL);
		while($var=mysql_fetch_assoc($result))
		{
		 $rows[]=$var;
		}
		$SQL="INSERT
			  INTO
				  shire_towns(shirename_id,shiretown_townname,shiretown_postcode)
			  VALUES
				  ({$rows[0]['shirename_id']},'{$post['townname']}',{$post['postcode']})";
	
			  $result=$this->MyDB->query($SQL);
			  $Array = array("result"=>true, "message"=>'Shiretown Added Successfully');
			  return $Array;	
		}	  
  }	
 
   private function __validationTowns(&$data)
    {
        $retArray = array("result"=>false, "message"=>'');
        $errors = array();

        if($data['shirename'] == '0') 
		{
            $errors[] = "Please select Sirename!!";
        }
				
        if(empty($data['townname'])) 
		{
            $errors[] = "Townname is blank!!";
        }
		
		if(empty($data['postcode'])||!preg_match("/^[0-9]+$/",$data['postcode'])) 
		{
            $errors[] = "Postcode is blank or Not Valid.!!";
        }
		if(count($errors) == 0)
	    {
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
	}	
 
 public function countTowns()
  {
	$ret = 0;
	$this->MyDB->setSelect("count(shirename_id) as cnt");
	$result = $this->MyDB->getAll();
	$ret = $result[0]['cnt'];
	return $ret;
  }
 
 public function viewLocationTowns($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
 {
   $SQL="SELECT 
               * 
		FROM 
		       shire_towns
		
		LIMIT
		       $fr,".DEFAULT_PAGING_SIZE;
	
	$result=$this->MyDB->query($SQL);
	$res['blogs'] = $result;
	$res['paging'] = Paging::numberPaging($this->countTowns(), $fr, DEFAULT_PAGING_SIZE);
	return $res;
  }
  
  public function countShires()
  {
	$ret = 0;
	$this->MyDB->setSelect("count(shirename_id) as cnt");
	$result = $this->MyDB->getAll();
	$ret = $result[0]['cnt'];
	return $ret;
  }
  
  public function viewLocationShires($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
  {
     $SQL="SELECT 
               * 
		   FROM 
		        shire_names 
		   LIMIT
		         $fr,".DEFAULT_PAGING_SIZE;
	
	$result=$this->MyDB->query($SQL);
	$res['blogs'] = $result;
	$res['paging'] = Paging::numberPaging($this->countShires(), $fr, DEFAULT_PAGING_SIZE);
	return $res;
  
  }
  
  public function editLocation($ID, $keyword)
  {
   	$SQL = "UPDATE 
				  shire_towns
			SET
				  shiretown_townname={$keyword} 
			WHERE 
				  shirename_id={$ID}";
	$this->MyDB->query($SQL);
  }  
  
   public function deleteLocationTown($post)
  {
  //prexit($post);
      $ID=$_GET['ID'];
	  $SQL="SELECT
	              sn.shirename_id 
		    FROM
			      shire_names AS sn,
				  shire_towns AS st 
			WHERE 
			      sn.shirename_id=st.shirename_id AND st.shiretown_id={$ID} ";
	  $results=$this->MyDB->query($SQL);//prexit($results);
      $SQL="DELETE
	        FROM  
			     shire_towns 
			 WHERE 
		       shiretown_id={$ID} AND shirename_id={$results[0]['shirename_id']} ";			   
		//prexit($SQL);		   	   
	  $res=$this->MyDB->query($SQL);
	  $results1='';
	  $SQL="SELECT
	              sn.shirename_id 
		    FROM
			      shire_names AS sn,
				  shire_towns AS st 
			WHERE 
			      sn.shirename_id=st.shirename_id AND st.shiretown_id={$ID} ";
	  @$results1=$this->MyDB->query($SQL);//prexit($results1);
	  if(empty($results1))
	  {
	  $Array = array("result"=>true, "message"=>'Deleted Successfully');
	  }
	  else
	  {
	   $Array = array("result"=>false, "message"=>'Could not be deleted.this location is already in use for listing.');
	  }
       return $Array; 
  }
  
   public function deleteLocationShire($post)
  {
      $ID=$_GET['ID'];
	  $SQL="SELECT 
	             sn.shirename_id
			FROM 
			     shire_names AS sn,
				 shire_towns AS st
		   WHERE
		         sn.shirename_id=st.shirename_id AND st.shiretown_id={$ID} ";
	  $results=$this->MyDB->query($SQL);	
	  	
        $SQL="DELETE
	          FROM   
			       shire_names AS sn
			  WHERE 
		           sn.shirename_id={$results[0]['shirename_id']}";
				   	
	   // prexit($SQL);	   
	   $result=$this->MyDB->query($SQL);
	   $Array = array("result"=>true, "message"=>'');
       return $Array; 
    }   
  
  public function selectStates()
  {
	$SQL="SELECT
				* 
		  FROM 
				local_state";
	$res=$this->MyDB->query($SQL);
	return $res;
  }
  
  public function selectShires()
  {
	$SQL="SELECT
				* 
		  FROM 
				shire_names";
	$res=$this->MyDB->query($SQL);
	return $res;
  }
  
  public function selectTowns()
  {
	$SQL="SELECT
				* 
		  FROM 
				shire_towns";
	$res=$this->MyDB->query($SQL);
	return $res;
  }
  
  public function editLocationDetails()
	{
		$condition = $_GET['ID'];
		$SQL="SELECT 
		            * 
			  FROM 
			        shire_names AS sn,shire_towns AS st
			  WHERE 
			       st.shiretown_id=$condition AND sn.shirename_id=st.shirename_id";
		$res=$this->MyDB->query($SQL);
		return $res;
	
    }
	
  public function updateEditDetails($post)
   {
   
     $result =$this->__validateEditDetails($post);

		if(!$result['result'])
		{
			return $result;
		}
		
		
      $ID=$_GET['ID'];
	  $SQL="SELECT
	              sn.shirename_id,sn.region_code 
		    FROM
			      shire_names AS sn,
				  shire_towns AS st
		    WHERE
			      sn.shirename_id=st.shirename_id AND st.shiretown_id={$ID} ";
	  $results=$this->MyDB->query($SQL);
      $SQL2="UPDATE
	              shire_names 
			SET
			   shirename_shirename='{$post['shirename']}',
			   region_code='{$post['regioncode']}'
			  
			WHERE 
		       shirename_id={$results[0]['shirename_id']}  ";	
	   $result=$this->MyDB->query($SQL2);
	   
	   $SQL1="UPDATE
	              bcp_regions 
			SET
			   REGION_NAME='{$post['shirename']}',
			   REGION_CODE='{$post['regioncode']}'
			  
			WHERE 
		       REGION_CODE='{$results[0]['region_code']}'  ";
	   $reslt=$this->MyDB->query($SQL1);
	   //return $result;
	   $SQL="UPDATE
	              shire_towns 
			SET
			   shiretown_townname='{$post['townname']}',
			   shiretown_postcode={$post['postcode']}
			WHERE 
		       shiretown_id={$ID} AND shirename_id={$results[0]['shirename_id']} ";			   
		//prexit($SQL);		   	   
		$res=$this->MyDB->query($SQL);
		$Array = array("result"=>true, "message"=>'Updated Successfully');
        return $Array;   		  
   } 	
	
	 public function countLocations()
  {
	$ret = 0;
	$this->MyDB->setSelect("count(shirename_id) as cnt");
	$result = $this->MyDB->getAll();
	$ret = $result[0]['cnt'];
	return $ret;
  }
  
	
		public function viewLocations($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
		{
		
			$SQL="SELECT * 
					FROM shire_names AS sn, shire_towns AS st 
					WHERE sn.shirename_id=st.shirename_id 
					ORDER BY st.shiretown_id DESC 
					LIMIT $fr,".DEFAULT_PAGING_SIZE;
					
			$result=$this->MyDB->query($SQL);
			
			$res['blogs'] 	= $result;
			$res['paging'] 	= Paging::numberPaging($this->countLocations(), $fr, DEFAULT_PAGING_SIZE);
			return $res;
		
		}
	
	public function searchLocations($get,$fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
			$SQL		="SELECT * 
							FROM shire_names AS sn, shire_towns AS st 
							WHERE sn.shirename_id=st.shirename_id AND st.shiretown_townname LIKE '%{$get['name']}%' 
							ORDER BY st.shiretown_id DESC 
							LIMIT $fr,".DEFAULT_PAGING_SIZE;
							
			$result		=$this->MyDB->query($SQL);
			
			$sql		="SELECT count(sn.shirename_id) as cnt 
							FROM  shire_names AS sn, shire_towns AS st 
							WHERE sn.shirename_id=st.shirename_id 
								AND st.shiretown_townname LIKE '%{$get['name']}%' 
							ORDER BY sn.shirename_id DESC";
			$count		=$this->MyDB->query($sql);			 
			$res['blogs'] = $result;
			$res['paging'] = Paging::numberPaging($count[0]['cnt'], $fr, DEFAULT_PAGING_SIZE);
			return $res;
	
	}
	
	public function validatesearch($get)
	{
	 
	  $retArray = array("result"=>false, "message"=>'');
		$errors = array();
		
		if(empty($get['name'])) {
		$errors[] = "Field is blank";
		}
		
		if(count($errors) == 0) {
		$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
   
	}
	
	public function __validateEditDetails($post)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		
		if(empty($post['shirename']))
		{
			$errors[] = "Shirename is blank";
		}
		
		if(empty($post['townname']))
		{
			$errors[] = "Townname is blank";
		}
		
		if(empty($post['postcode']))
		{
			$errors[] = "Postcode is blank";
		}
		
		if(count($errors) == 0) {
		$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}
	
}
?>