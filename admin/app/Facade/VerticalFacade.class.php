<?php
class VerticalFacade extends MainFacade {

    public function __construct(MyDB $MyDB){           //Start of The __contructor.purpose is to assign database parmeters to                                                       //a variable acting as an object and using that object to declare
        $this->MyDB = $MyDB;                           //the table name,sequence name and primary column.
        $this->MyDB->table="vertical";
        $this->MyDB->sequenceName="vertical";
        $this->MyDB->primaryCol="vertical_id";
    }

	 public function fetchClassifications()
    {
        $SQL="SELECT 
		            *
			  FROM
			        local_classification";
        $rec=$this->MyDB->query($SQL);
        return $rec;
    }
	
	public function verticalAdd($post)
	{//prexit($post);
	 $res1 =$this->__userRegisterValidation($post);
     if(!$res1['result'])
	 {
      return $res1;
     }
     elseif($post['vertical_description']!='' && $post['classification'][0]!='select')
	  {
	      $sql = "INSERT
		          INTO 
				        `vertical` (`vertical_id`, `vertical_title`, `vertical_description`, `insert_time`)
			      VALUES 
				        (NULL, '{$post['vertical_title']}', '{$post['vertical_description']}', NOW())";
	      $this->MyDB->query($sql);
	      $sql="SELECT 
		             vertical_id
			   FROM
			         vertical";
		  $a=$this->MyDB->getInsertId($sql);
	      for($i=0;$i<count($post['classification']);$i++)
	      {
	       $sql="SELECT
		               localclassification_id
			     FROM
				       local_classification
				 WHERE 
				       localclassification_name='{$post['classification'][$i]}'";
	       $res[]=$this->MyDB->query($sql);
	       }
	      foreach($res as $row)
		  {
	       $sql1 = "INSERT
		            INTO 
					      `vertical_classification` (`id`, `vertical_id`, `classification_id`) 
				 	VALUES
					       ('','{$a}','{$row[0]['localclassification_id']}')";
	       $this->MyDB->query($sql1);
    	  }
	    $retArray = array("result"=>true, "message"=>'Added');
        return $retArray;
	   }
	  elseif($post['vertical_description']=='' && $post['classification'][0]!='select')
	  {
	   $sql = "INSERT 
	           INTO
			        `vertical` (`vertical_id`, `vertical_title`,`insert_time`)
			   VALUES
			        (NULL, '{$post['vertical_title']}',NOW())";
	   $this->MyDB->query($sql);
	   $sql="SELECT 
	               vertical_id 
			 FROM 
			       vertical";
	   $a=$this->MyDB->getInsertId($sql);
	   for($i=0;$i<count($post['classification']);$i++)
	   {
	    $sql="SELECT 
		            localclassification_id 
			  FROM 
			        local_classification
			  WHERE 
			        localclassification_name='{$post['classification'][$i]}'";
	    $res[]=$this->MyDB->query($sql);
	    }
	   foreach($res as $row)
	   {
	    $sql1 = "INSERT
		         INTO
				     `vertical_classification` (`id`, `vertical_id`, `classification_id`)
				 VALUES
				     ('','{$a}','{$row[0]['localclassification_id']}')";
	    $this->MyDB->query($sql1);
	   }
	  $retArray = array("result"=>true, "message"=>'Added');
      return $retArray;
	 }
	 
	 elseif($post['vertical_description']=='' && $post['classification'][0]=='select')
	  {
	    $retArray = array("result"=>true, "message"=>'Please select an classification');
        return $retArray;
	 }
  }
	
	
	 private function __userRegisterValidation(&$data)
    {

        $retArray = array("result"=>false, "message"=>'');
        $errors = array();
        if(empty($data['vertical_title'])) 
		{
            $errors[] = "Vertical Title is blank!!";
        }
       if($data['classification'][0]=='select') 
		{
            $errors[] = "Please Select any Classification!!";
        }
		if(count($errors) == 0) 
		{
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }
	
	public function viewVerticles($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
	$FinalArr = array();
		$sql="SELECT
	             *
	        FROM
			      vertical 
			LIMIT 
			     $fr,10	  ";
				  
		$listings=$this->MyDB->query($sql);		  
		$i=0;
		foreach ($listings as $k=>$category)
		{
			$ln = array();
			$FinalArr[$i]['vertical_id']=$category['vertical_id'];
			$FinalArr[$i]['vertical_title']=$category['vertical_title'];
			$FinalArr[$i]['vertical_description']=$category['vertical_description'];
			
			$sql="SELECT
	             *
	        FROM
			      vertical_classification as vc,local_classification as lc
	        WHERE
			      vc.vertical_id={$category['vertical_id']} AND vc.classification_id=lc.localclassification_id";
				  $temp=$this->MyDB->query($sql);
			
			foreach ($temp as $k=>$lname)
			{
				$ln[]=$lname['localclassification_name'];	
			}
			$FinalArr[$i]['Name']= implode(",<br/>", $ln);
			$i++;
		}		  
		$SQL="SELECT
                    count(vertical_id) AS cnt
			  FROM  
			        vertical"; 		
	     $count_all = $this->MyDB->query($SQL);
		 
		  $retArray['listings'] = $FinalArr;
        $retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
        return $retArray;
	 }
	
	public function delete()
	{
	  $id=$_GET['ID'];
	  $sql="SELECT  
	               vc.id 
			FROM
			      vertical_classification as vc, vertical as vr
		    WHERE
			      vc.vertical_id=$id";
	  $a=$this->MyDB->query($sql);
	  
	  
	  $sql="DELETE
	               vertical,vertical_classification
		    FROM
			      vertical  , vertical_classification 
		    WHERE
			      vertical_classification.vertical_id=vertical.vertical_id 
				  AND
				  vertical_classification.vertical_id=$id";
	  $this->MyDB->query($sql);
	  $retArray = array("result"=>true, "message"=>'deleted');
      return $retArray;
	}
	
	public function fetchEditableDetails($post)
	{
	  $id=$_GET['ID'];
	  $sql="SELECT
	               local_classification.localclassification_id,vertical.vertical_title,vertical.vertical_description, vertical.vertical_id,vertical_classification.vertical_id 
		    FROM
			      vertical_classification,local_classification,vertical 
			WHERE
			      vertical.vertical_id=vertical_classification.vertical_id 
				  AND
			      vertical_classification.vertical_id=$id
				  AND
				  vertical_classification.classification_id=local_classification.localclassification_id";
	  $a=$this->MyDB->query($sql);
	  return $a;
	}
	
	public function editAddData($post)
	{
	 $id=$_GET['ID'];
	// if($post['classification'][0]=="select"){ echo "yes";}else{echo "nay";exit;}
	 
	 $result =$this->__userlistingValidation($post);
	 if(!$result['result'])
	 {
	   if($post['classification'][0]=='select')
	   {
	    $retArray = array("result"=>false, "message"=>'Please Select any classification');
        return $retArray;
	 
	   
	   }
	   if(empty($post['classification'][0])||($post['classification'][0])=='select'&&$post['vertical_title']!='' && $post['vertical_description']!='') 
	   {
	   $sql1="UPDATE
		              vertical
			    SET
				     vertical_title='{$post['vertical_title']}',
				     vertical_description='{$post['vertical_description']}' 
				WHERE
				     vertical_id=$id ";
	      $this->MyDB->query($sql1);
	    $retArray = array("result"=>true, "message"=>'Updated');
        return $retArray;
	 
	   }
  
	 }
	 elseif($post['vertical_title']!='' && $post['vertical_description']!=''&& $post['classification'][0]!='select')
	    {// prexit($post['classification']);
		
	      $sql1="UPDATE
		              vertical
			    SET
				     vertical_title='{$post['vertical_title']}',
				     vertical_description='{$post['vertical_description']}' 
				WHERE
				     vertical_id=$id ";
	      $this->MyDB->query($sql1);
	 
	      $sql2="DELETE
		               vertical_classification 
				 FROM
				       vertical_classification,vertical 
				WHERE
				       vertical_classification.vertical_id=vertical.vertical_id
					   AND
					   vertical_classification.vertical_id=$id";
	      $this->MyDB->query($sql2);
	 
	      for($i=0;$i<count($post['classification']);$i++)
	      {
           $sql="SELECT
		                localclassification_name,localclassification_id
			     FROM
				        local_classification 
				 WHERE
				        localclassification_id='{$post['classification'][$i]}'";
	       $res[]=$this->MyDB->query($sql);
	      }
	      foreach($res as $row)
		  {//prexit($row);
	       $sql3="INSERT
		          INTO 
				      `vertical_classification` (`id`, `vertical_id`, `classification_id`)
				  VALUES 
				      ('','{$id}','{$row[0]['localclassification_id']}')";
	       $this->MyDB->query($sql3);
	      }
	    $retArray = array("result"=>true, "message"=>'Updated');
        return $retArray;
	   }
	   
	   elseif($post['vertical_title']!='' && $post['vertical_description']!=''&&($post['classification'][0])=='select')
	    { 
		
	      $sql1="UPDATE
		              vertical
			    SET
				     vertical_title='{$post['vertical_title']}',
				     vertical_description='{$post['vertical_description']}' 
				WHERE
				     vertical_id=$id ";
	      $this->MyDB->query($sql1);
	       
	     
	    $retArray = array("result"=>true, "message"=>'Updated');
        return $retArray;
	   }
	   
	  elseif($post['vertical_title']=='' && $post['vertical_description']!=''&&($post['classification'][0])!='select')
	  {
	    
		 $sql1="UPDATE
		              vertical
				SET
				      vertical_description='{$post['vertical_description']}' 
			    WHERE 
				      vertical_id=$id ";
	      $this->MyDB->query($sql1);
	 
	      $sql2="DELETE
		              vertical_classification 
				 FROM
				      vertical_classification,vertical
				 WHERE
				      vertical_classification.vertical_id=vertical.vertical_id
					  AND
					  vertical_classification.vertical_id=$id";
	      $this->MyDB->query($sql2);
	 
	      for($i=0;$i<count($post['classification']);$i++)
	      {
          $sql="SELECT
		                localclassification_name,localclassification_id
			     FROM
				        local_classification 
				 WHERE
				        localclassification_id='{$post['classification'][$i]}'";
	       $res[]=$this->MyDB->query($sql);
	      }
	      foreach($res as $row)
		  {
	       $sql3="INSERT
		          INTO 
				      `vertical_classification` (`id`, `vertical_id`, `classification_id`)
				  VALUES 
				       ('','{$id}','{$row[0]['localclassification_id']}')";
	       $this->MyDB->query($sql3);
	      }
	    $retArray = array("result"=>true, "message"=>'Updated');
        return $retArray;
	   }
	   
	   elseif($post['vertical_title']=='' && $post['vertical_description']!=''&&($post['classification'][0])=='select')
	    { 
		 
	      $sql1="UPDATE
		              vertical
			    SET
				      vertical_description='{$post['vertical_description']}' 
				WHERE
				     vertical_id=$id ";
	      $this->MyDB->query($sql1);
	       
	     
	    $retArray = array("result"=>true, "message"=>'Updated');
        return $retArray;
	   }
	   
	   
	  elseif($post['vertical_title']!='' && $post['vertical_description']==''&&($post['classification'][0])!='select')
	  {
	  
	   $sql1="UPDATE
		            vertical 
			  SET
			        vertical_title='{$post['vertical_title']}' 
			  WHERE
			        vertical_id=$id ";
	      $this->MyDB->query($sql1);
	 
	      $sql2="DELETE
		               vertical_classification
			     FROM
				       vertical_classification,vertical
			     WHERE
				       vertical_classification.vertical_id=vertical.vertical_id 
					   AND
					   vertical_classification.vertical_id=$id";
	      $this->MyDB->query($sql2);
	 
	      for($i=0;$i<count($post['classification']);$i++)
	      {
          $sql="SELECT
		                localclassification_name,localclassification_id
			     FROM
				        local_classification 
				 WHERE
				        localclassification_id='{$post['classification'][$i]}'";
	       $res[]=$this->MyDB->query($sql);
	      }
	      foreach($res as $row)
		  {
	       $sql3="INSERT
		          INTO
				      `vertical_classification` (`id`, `vertical_id`, `classification_id`)
				  VALUES 
				      ('','{$id}','{$row[0]['localclassification_id']}')";
	       $this->MyDB->query($sql3);
	      }
	    $retArray = array("result"=>true, "message"=>'Updated');
        return $retArray;
	  }
	  
	   elseif($post['vertical_title']!='' && $post['vertical_description']==''&&($post['classification'][0])=='select')
	    { 
		 
	      $sql1="UPDATE
		              vertical
			    SET
				      vertical_title='{$post['vertical_title']}' 
				WHERE
				     vertical_id=$id ";
	      $this->MyDB->query($sql1);
	       
	     
	    $retArray = array("result"=>true, "message"=>'Updated');
        return $retArray;
	   }
	  
	  elseif($post['vertical_title']=='' && $post['vertical_description']==''&&($post['classification'][0])=='select')
	   {
	    $retArray = array("result"=>true, "message"=>'Record not changed');
         return $retArray;
	   }
	  	
	 
  }
	
	private function __userlistingValidation(&$data)
    {
        $retArray = array("result"=>false, "message"=>'');
        $errors = array();
		if($data['classification'][0]=='select') 
		{
            $errors[] = "Please Select any Classification!!";
        }
        if(count($errors) == 0) 
		{
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }
	
 public function searchVertical($get, $fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
 {
  
	   $FinalArr = array();
		$sql="SELECT
	                 *
	          FROM
			         vertical
			  WHERE 
			         vertical_title LIKE '%{$get['name']}%'";
				  
		$listings=$this->MyDB->query($sql);		  
		$i=0;
		foreach ($listings as $k=>$category)
		{
			$ln = array();
			$FinalArr[$i]['vertical_id']=$category['vertical_id'];
			$FinalArr[$i]['vertical_title']=$category['vertical_title'];
			$FinalArr[$i]['vertical_description']=$category['vertical_description'];
			
			$sql="SELECT
	             *
	        FROM
			      vertical_classification as vc,local_classification as lc
	        WHERE
			      vc.vertical_id={$category['vertical_id']} AND vc.classification_id=lc.localclassification_id";
				  $temp=$this->MyDB->query($sql);
			
			foreach ($temp as $k=>$lname)
			{
				$ln[]=$lname['localclassification_name'];	
			}
			$FinalArr[$i]['Name']= implode(",<br/>", $ln);
			$i++;
		}		  
		
	$SQL="SELECT
                    count(vertical_id) AS cnt
		  FROM  
			        vertical
		  WHERE  
		            vertical_title='{$get['name']}'			
		 "; 		
	     $count_all = $this->MyDB->query($SQL);
		 
	$retArray['listings'] = $FinalArr;
    $retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
	return $retArray;
		 
   
 }	
 
  public function validatesearch($get)
  {
   $retArray = array("result"=>false, "message"=>'');
        $errors = array();
		if(empty($get['name'])) 
		{
            $errors[] = "Please enter name to search!!";
        }
        if(count($errors) == 0) 
		{
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
  }
 	
}
?>	