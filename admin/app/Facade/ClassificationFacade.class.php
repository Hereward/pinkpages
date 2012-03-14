<?php
class ClassificationFacade extends MainFacade {

	public function __construct(MyDB $MyDB){           //Start of The __contructor.purpose is to assign database parmeters to                                                       //a variable acting as an object and using that object to declare
		$this->MyDB = $MyDB;                           //the table name,sequence name and primary column.
		$this->MyDB->table="local_classification";
		$this->MyDB->sequenceName="local_classification";
		$this->MyDB->primaryCol="localclassification_id";
	}

	public function addKeywords($post)
	{
		@$res1 =$this->__userRegisterValidation($post);
		if(!$res1['result'])
		{
			return $res1;
		}
		else
		{
			$SQL="INSERT
		  INTO 
			 local_classification(localclassification_name)
		  VALUES
			   ('{$post['name']}')";	

			$this->MyDB->setWhere("localclassification_name='".$post['name']."'");
			$resultArray=$this->MyDB->getAll();
			if(count($resultArray)>0)
			{
				$retArray = array("result"=>false, "message"=>'Classification Already Exists!! please try some other name');
				return $retArray;
			}
			else
			{
				$result=$this->MyDB->query($SQL);
				$Array = array("result"=>true, "message"=>'Successfully Added');
				return $Array;
			}
		}
	}


	private function __userRegisterValidation(&$data)
	{

		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		if(empty($data['name']))
		{
			$errors[] = "Please Enter Classification name!!";
		}
		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}

	public function countKeywords()
	{
		$ret = 0;
		$this->MyDB->setSelect("count(localclassification_id) as cnt");
		$result = $this->MyDB->getAll();
		$ret = $result[0]['cnt'];
		return $ret;
	}

	public function viewKeywords($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$SQL="SELECT
               * 
		  FROM 
		        local_classification
				
				ORDER BY localclassification_name ASC
		   LIMIT
		         $fr,".DEFAULT_PAGING_SIZE;

		$result=$this->MyDB->query($SQL);
		$res['blogs'] = $result;
		$res['paging'] = Paging::numberPaging($this->countKeywords(), $fr, 10);
		return $res;
	}


	public function countSupressedClass()
	{
		$ret = 0;
		$SQL="SELECT count(localclassification_id) as cnt FROM temp_local_classification";
		$result=$this->MyDB->query($SQL);
		$ret = $result[0]['cnt'];
		return $ret;
	}
	public function viewSupressedClass($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$SQL="SELECT *
				FROM temp_local_classification 
				ORDER BY localclassification_name ASC 
				LIMIT $fr,".DEFAULT_PAGING_SIZE;
		$result=$this->MyDB->query($SQL);
		$res['blogs'] = $result;
		$res['paging'] = Paging::numberPaging($this->countSupressedClass(), $fr, 10);
		return $res;
	}

	public function editKeyword($ID, $keyword)
	{
		$SQL = "UPDATE
				  local_classification
			SET
				  localclassification_name='{$keyword}' 
			WHERE 
				  localclassification_id={$ID}";
		$this->MyDB->query($SQL);
	}

	public function deleteKeyword($post)
	{
		$ID = $_GET['ID'];
		$sql = "SELECT COUNT(businessclassification_id) AS cnt FROM business_classification WHERE localclassification_id=".$this->MyDB->quote($ID);
		$rs = $this->MyDB->query($sql);
		$result = false;
		$msg = 4;
		if($rs[0]['cnt'] == 0) {

			$sql = "DELETE FROM `business_ranks` WHERE `localclassification_id` =".$this->MyDB->quote($ID);
			$this->MyDB->query($sql);

			$this->MyDB->setWhere("localclassification_id=$ID") ;
			$this->MyDB->remove($ID);
			$result = true;
			$msg = 3;
		}
		$Array = array("result"=>$result, "message"=>$msg);
		return $Array;
	}

	public function fetchClassificationDetails($get, $fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$retArray = array();
		$this->MyDB->reset();

		$name 				= (!empty($get['name']))?$get['name']:NULL;


		$condition	="localclassification_name LIKE '%{$name}%'";


		$SQL			="SELECT
											localclassification_id,
											localclassification_name
										  FROM
											    local_classification 
										  WHERE
												$condition
										  ORDER BY 
											  localclassification_name ASC		
										  LIMIT $fr, $noOfRecords";

		$classification=$this->MyDB->query($SQL);

		$this->MyDB->reset();

		$SQL			="SELECT
											count(localclassification_id) AS cnt
										  FROM
											local_classification 
									  	WHERE
											$condition";
		$count_all = $this->MyDB->query($SQL);

		$retArray['classification'] 	= $classification;
		$retArray['paging'] 			= Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		return $retArray;

	}


	public function fetchSupressClassificationDetails($get, $fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$retArray = array();
		$this->MyDB->reset();

		$name 				= (!empty($get['name']))?$get['name']:NULL;


		$condition	="localclassification_name LIKE '%{$name}%'";


		$SQL			="SELECT
											localclassification_id,
											localclassification_name
										  FROM
											    temp_local_classification 
										  WHERE
												$condition
										  ORDER BY 
											  localclassification_name ASC		
										  LIMIT $fr, $noOfRecords";

		$classification=$this->MyDB->query($SQL);

		$this->MyDB->reset();

		$SQL			="SELECT
											count(localclassification_id) AS cnt
										  FROM
											temp_local_classification 
									  	WHERE
											$condition";
		$count_all = $this->MyDB->query($SQL);

		$retArray['classification'] 	= $classification;
		$retArray['paging'] 			= Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		return $retArray;

	}



	public function __validateClassification($get)
	{

		$retArray = array("result"=>false, "message"=>'');
		$errors = array();

		if($get['name'] == '')
		{
			$errors[] = "Enter Classification Name to search";
		}
		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}


	function viewlog($File)
	{
		$fp = fopen("../Uploads/".$File,"r");
		//$file = fgetcsv($fp,65535,",");
		while($var=fgetcsv($fp,1000,","))

		$values[]=$var;//pre($values);
		// $a=$file;prexit($a);
		/*$replaced = eregi_replace(",", "<td>", $var);
		$replaced2 = eregi_replace("\n", "<tr><td>", $replaced);
		$replaced3 = eregi_replace("\r", "<tr><td>", $replaced2);*/

		fclose($fp);
		return $values;
	}


	public function csvFileUpload($file)
	{
		$res1 =$this->__Validation($file);
		if(!$res1['result'])
		{
			return $res1;
		}

		$filename=$_FILES['csvfileName']['name'];setSession("classificationFile",$_FILES['csvfileName']['name']);
		$tmp=$_FILES['csvfileName']['tmp_name'];
		move_uploaded_file($tmp,"../Uploads/".$filename);
		$csvArray=$this->viewlog($filename);
		return $csvArray;

	}

	public function importClassification($post)
	{
		for($i=1; $i<=$_POST['total']; $i++)
		{

			$sql="INSERT INTO `local_classification` (
							`localclassification_id` ,
							`localclass_id` ,
							`localclassification_name`
							)
							VALUES (
							NULL ,'0', '{$_POST['classificationName'.$i]}')";
			$result = $this->MyDB->query($sql);


			$Array = array("result"=>true,"message"=>"Classification Inserted Successfully");				 }
			return $Array;

	}


	private function __Validation(&$file)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		if(empty($file['csvfileName']['name']))
		{
			$errors[] = "Field is blank!!";
		}
		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}


	/**
		 * @desc This function will be used to supress the classification and it will insert the selected record as per
		  	classification and insert it into the temp table and then delete the original data from the original table.
		 * @param value from the url.
		 * @return mixed Return true if all the function return true was successfull or false if failure.
	 */
	public function supressClassification($get)
	{
		$localclassification_id			=$get['ID'];

		//==============================================//
		//Get details from local_classification table	//
		//Insert into temp_local_classification			//
		//Delete from local_classification				//
		//==============================================//

		$fetch_local_classification		="SELECT *
											FROM local_classification
											WHERE localclassification_id ='{$localclassification_id}'";
		$local_classification_result 	=$this->MyDB->query($fetch_local_classification);


		$insert_temp_local_classification="INSERT INTO temp_local_classification (
													localclassification_id,
													localclass_id,
													localclassification_name
													)VALUES (
														'{$local_classification_result['0']['localclassification_id']}',
														'{$local_classification_result['0']['localclass_id']}',
														'{$local_classification_result['0']['localclassification_name']}'
													)";
		$temp_local_classification_result 	=$this->MyDB->query($insert_temp_local_classification);

		//$value=$this->MyDB->affectedRows($temp_local_classification_result);
		//var_dump($value);


		//==================================================//
		//Get details from business_classification table	//
		//Insert into temp_business_classification			//
		//Delete from business_classification				//
		//==================================================//

		$fetch_business_classification		="SELECT *
											FROM business_classification
											WHERE localclassification_id ='{$localclassification_id}'";
		$business_classification_result 	=$this->MyDB->query($fetch_business_classification);


		foreach($business_classification_result as $val)
		{
			$insert_temp_business_classification="INSERT INTO temp_business_classification (
													businessclassification_id,
													business_id,
													localclassification_id
													)VALUES (
														'{$val['localclassification_id']}',
														'{$val['business_id']}',
														'{$val['localclassification_id']}'
													)";
			$temp_business_classification_result 	=$this->MyDB->query($insert_temp_business_classification);
		}



		//==========================================//
		//Get details from business_ranks table		//
		//Insert into temp_business_ranks			//
		//Delete from business_ranks				//
		//==========================================//

		$fetch_business_ranks		="SELECT *
											FROM business_ranks
											WHERE localclassification_id ='{$localclassification_id}'";
		$business_ranks_result 		=$this->MyDB->query($fetch_business_ranks);



		foreach($business_ranks_result as $value)
		{
			$insert_temp_business_ranks="INSERT INTO temp_business_ranks (
													businessrank_id,
													business_id,
													localclassification_id,
													businessrank_rank,
													businessrank_email,
													businessrank_url,
													shirename_id,
													businessrank_cost,
													businessrank_timestamp,
													businessrank_expire,
													user_id,
													businessrank_tempfield
													)VALUES (
														'{$value['businessrank_id']}',
														'{$value['business_id']}',
														'{$value['localclassification_id']}',
														'{$value['businessrank_rank']}',
														'{$value['businessrank_email']}',
														'{$value['businessrank_url']}',
														'{$value['shirename_id']}',
														'{$value['businessrank_cost']}',
														'{$value['businessrank_timestamp']}',
														'{$value['businessrank_expire']}',
														'{$value['user_id']}',
														'{$value['businessrank_tempfield']}'
													)";
			$temp_business_ranks_result 			=$this->MyDB->query($insert_temp_business_ranks);

		}



		$business_ranks_delete				="DELETE
													FROM business_ranks 
													WHERE localclassification_id='{$localclassification_id}'";											
		$this->MyDB->query($business_ranks_delete);



		$business_classification_delete		="DELETE
													FROM business_classification 
													WHERE localclassification_id='{$localclassification_id}'";											
		$this->MyDB->query($business_classification_delete);


		$local_classification_delete		="DELETE
												FROM local_classification 
												WHERE localclassification_id='{$localclassification_id}'";											
		$val1=$this->MyDB->query($local_classification_delete);



		$thesaurus_classifications_delete		="DELETE
												FROM thesaurus_classifications 
												WHERE localclassification_id='{$localclassification_id}'";											
		$this->MyDB->query($thesaurus_classifications_delete);

		$Array = array("result"=>true,"message"=>"Classification Supressed Successfully");
		return $Array;
	}/*End of supressClassification function*/



	/**
		 * @desc This function will be used to release the classification and it will insert the selected record as per
		  	classification and insert it into the temp table and then delete the original data from the original table.
		 * @param value from the url.
		 * @return mixed Return true if all the function return true was successfull or false if failure.
	 */
	public function releaseClassification($get)
	{
		$localclassification_id			=$get['ID'];

		//==============================================//
		//Get details from local_classification table	//
		//Insert into temp_local_classification			//
		//Delete from local_classification				//
		//==============================================//

		$fetch_temp_local_classification		="SELECT *
											FROM temp_local_classification
											WHERE localclassification_id ='{$localclassification_id}'";
		$temp_local_classification_result 	=$this->MyDB->query($fetch_temp_local_classification);


		$insert_local_classification="INSERT INTO local_classification (
													localclassification_id,
													localclass_id,
													localclassification_name
													)VALUES (
														'{$temp_local_classification_result['0']['localclassification_id']}',
														'{$temp_local_classification_result['0']['localclass_id']}',
														'{$temp_local_classification_result['0']['localclassification_name']}'
													)";
		$local_classification_result 	=$this->MyDB->query($insert_local_classification);

		$this->MyDB->reset();
		$temp_local_classification_delete		="DELETE
												FROM temp_local_classification 
												WHERE localclassification_id='{$localclassification_id}'";											
		$this->MyDB->query($temp_local_classification_delete);


		/*		$thesaurus_classifications_delete		="DELETE
		FROM thesaurus_classifications
		WHERE localclassification_id='{$localclassification_id}'";
		$this->MyDB->query($thesaurus_classifications_delete);*/

		//==================================================//
		//Get details from business_classification table	//
		//Insert into temp_business_classification			//
		//Delete from business_classification				//
		//==================================================//

		$temp_fetch_business_classification		="SELECT *
													FROM temp_business_classification
													WHERE localclassification_id ='{$localclassification_id}'";
		$temp_business_classification_result 	=$this->MyDB->query($temp_fetch_business_classification);


		foreach($temp_business_classification_result as $val)
		{
			$insert_business_classification="INSERT INTO business_classification (
													businessclassification_id,
													business_id,
													localclassification_id
													)VALUES (
														'{$val['localclassification_id']}',
														'{$val['business_id']}',
														'{$val['localclassification_id']}'
													)";
			$business_classification_result 	=$this->MyDB->query($insert_business_classification);
		}
		$this->MyDB->reset();
		$temp_business_classification_delete		="DELETE
														FROM temp_business_classification 
														WHERE localclassification_id='{$localclassification_id}'";											
		$this->MyDB->query($temp_business_classification_delete);


		//==========================================//
		//Get details from business_ranks table		//
		//Insert into temp_business_ranks			//
		//Delete from business_ranks				//
		//==========================================//

		$temp_fetch_business_ranks		="SELECT *
											FROM temp_business_ranks
											WHERE localclassification_id ='{$localclassification_id}'";
		$temp_business_ranks_result 		=$this->MyDB->query($temp_fetch_business_ranks);



		foreach($temp_business_ranks_result as $value)
		{
			$insert_business_ranks="INSERT INTO business_ranks (
													businessrank_id,
													business_id,
													localclassification_id,
													businessrank_rank,
													businessrank_email,
													businessrank_url,
													shirename_id,
													businessrank_cost,
													businessrank_timestamp,
													businessrank_expire,
													user_id,
													businessrank_tempfield
													)VALUES (
														'{$value['businessrank_id']}',
														'{$value['business_id']}',
														'{$value['localclassification_id']}',
														'{$value['businessrank_rank']}',
														'{$value['businessrank_email']}',
														'{$value['businessrank_url']}',
														'{$value['shirename_id']}',
														'{$value['businessrank_cost']}',
														'{$value['businessrank_timestamp']}',
														'{$value['businessrank_expire']}',
														'{$value['user_id']}',
														'{$value['businessrank_tempfield']}'
													)";
			$business_ranks_result 			=$this->MyDB->query($insert_business_ranks);

			$this->MyDB->reset();
			$temp_business_ranks_delete				="DELETE
													FROM temp_business_ranks 
													WHERE localclassification_id='{$localclassification_id}'";											
			$this->MyDB->query($temp_business_ranks_delete);
		}

		$Array = array("result"=>true,"message"=>"Classification Released Successfully");
		return $Array;
	}/*End of supressClassification function*/
	
    public function getCtrReport($from_date, $to_date, $classification, $bulkReport = ''){
	
	  $sql = "drop table tmp_ctr_report";
      $this->MyDB->query($sql);	  
	
	  //Create temp reporting table
      $sql = "CREATE TABLE tmp_ctr_report (
                RowNo int(11) NOT NULL auto_increment,
				business_id  int(10) NOT NULL,
                All_Sydney_Ranking int(2) NOT NULL,
                Company varchar(255),
			    Regions int(3),
  		        Impr int(5),
			    Clicks int(5),
			    CTR float,
              PRIMARY KEY (RowNo)
             )";
			 
      $this->MyDB->query($sql);
	  
	  
     //All Sydney Ranks	  
      $sql = "INSERT INTO tmp_ctr_report (business_id, All_Sydney_Ranking, Company)
              SELECT br.business_id, br.businessrank_rank, lb.business_name
	            FROM business_ranks br, local_businesses lb
               WHERE br.shirename_id = 59
			     AND br.localclassification_id = {$classification}
			     AND br.business_id = lb.business_id
		    ORDER BY br.businessrank_rank";
				 
      $this->MyDB->query($sql);
	  
	  //Create another temp table that has impressions by both shirename_id(Regions) and localclassification_id(Classifications)
	  $sql = "drop table tmp_region_impressions";
	  
      $this->MyDB->query($sql);

	  $sql = "CREATE TABLE tmp_region_impressions
               SELECT lc.localclassification_name, st.classification_id, st.region_id, 
			          SUM(st.views) AS views
                 FROM region_classification_stats AS st
	             LEFT JOIN local_classification AS lc
		           ON (st.classification_id=lc.localclassification_id AND lc.localclassification_id = {$classification})
                WHERE lc.localclassification_id = {$classification}
				  AND st.view_date BETWEEN '{$from_date}' AND '{$to_date}'
                GROUP BY st.classification_id, st.region_id
                ORDER BY lc.localclassification_name";												
				
      $this->MyDB->query($sql);
	  
	  //Aggregate and Sum the impressions by Region
	  
	  $sql = "SELECT tmp.business_id, Count(2) as Regions, SUM(tmpr.views) as Impressions
                FROM tmp_ctr_report tmp, business_ranks br, tmp_region_impressions tmpr
               WHERE tmp.business_id = br.business_id							 
				 AND br.shirename_id = tmpr.region_id
				 AND br.localclassification_id = tmpr.classification_id
            GROUP BY tmp.business_id";
			
      $businessImprs = $this->MyDB->query($sql);				 	  
	  	  
	  //Update the reporting table to include the aggregate Region and Impression information
	  foreach($businessImprs as $impression){
	    $sql1 = "UPDATE tmp_ctr_report
		           SET Regions = {$impression['regions']},
				       Impr    = {$impression['impressions']}
				 WHERE business_id = {$impression['business_id']}";

      $this->MyDB->query($sql1);				 
	  }
	  
	  //Calculate the Clicks for each listing in the specified period
	  $sql = "SELECT bs.business_id, sum(views) as Clicks
                FROM business_stats bs
               WHERE bs.view_date between '$from_date' and '$to_date'
               GROUP BY bs.business_id
               ORDER BY business_id desc";
			   
      $businessClicks = $this->MyDB->query($sql);				 			   
	  
	  //Update reporting table to include clicks per time period by business_id
	  foreach($businessClicks as $businessClick){
	    $sql = "UPDATE tmp_ctr_report
		           SET Clicks = {$businessClick['clicks']}
				 WHERE business_id = {$businessClick['business_id']} ";
				 
        $this->MyDB->query($sql);				 
	  }
	  
	  //Finally derive and update the Click Through Ratio (CTR)
	  $sql = "UPDATE tmp_ctr_report
	             SET CTR = (Clicks/Impr)*(100/1)";
				 
      $this->MyDB->query($sql);				 
	  
	  //Calculate Totals for this Classification
	  
	  $sql = "SELECT '', 'AVERAGE/TOTAL' as AVGTots ,ROUND(AVG(Regions),0) as Regions, SUM(Impr) as Impr, SUM(Clicks) as Clicks, ROUND(AVG(CTR), 2) as CTR
                FROM tmp_ctr_report";
				
      $avgsTotals = $this->MyDB->query($sql);				        
	  
	  //Get Classification Name
	  $sql = "SELECT localclassification_name from local_classification where localclassification_id = $classification";
	  
	  $title = $this->MyDB->query($sql);				

	  	  	  	  	  	  	    	  
	  //Output of Reporting Table
	  $sql = "SELECT All_Sydney_Ranking, Company, Regions, Impr, Clicks, ROUND(CTR, 2)
	            FROM tmp_ctr_report
			ORDER BY All_Sydney_Ranking	";
				
      $report = $this->MyDB->query($sql);				
	  
	  if($bulkReport == 1){
	    //Output Top 100 Classifications Report
		return array_merge($report, $avgsTotals);
	  } else {	  
        //Output individual classification Report, Contents in csv format	  
	    header("Content-type: application/octet-stream");
	    header("Content-Disposition: attachment; filename=\"CTR_Report.csv\"");	  
		echo $title[0]['localclassification_name'] . ', For Period ' . $from_date . ' to ' .  $to_date;
		echo "\n";
		echo "All Sydney Ranking, Company, Regions, Impr, Clicks, CTR";
		echo "\n";	  
		foreach ($report as $k=>$data) {		 
          foreach($data as $key=>$value){
		    echo $value.",";
		  }
	      echo "\n";
		}	  
		echo ",AVERAGE/TOTAL, ".$avgsTotals[0]['regions'].", ".$avgsTotals[0]['impr'].", ".$avgsTotals[0]['clicks'].", ".$avgsTotals[0]['ctr'];	  	
		exit;			 			  
	  }	  	 
    }	
	
    public function getCompleteCtrReport(){
	
	  $this->setini();	
	
	  //Get Today's date
	  $endDate = date("Y-m-d");

	  //Go back 12 months and get first day of the month
	  $dateArray =  getDate();
	  $startDate = $dateArray['year'] - 1 . "-" . $dateArray['mon'] . "-" . "01";	 
      
	  $fromDateItr = new DateIterator('month', $startDate, $endDate);	  
	  
	  $report = Array();
	  
	  while($fromDateItr->valid()){
	    $from = $fromDateItr->current();
		
		$to   = date("Y-m-d", strtotime("-1 day" ,strtotime("+1 month", strtotime($from))));
		
		if(strtotime($to) > strtotime($endDate)){
		  $to = $endDate;
		}
								
		//$report[$fromDateItr->key()] = $this->completeCtrSql($from, $to);				
		
        $report[$from .",". $to] = $this->completeCtrSql($from, $to);						
				
		$fromDateItr->next();
      }	  	  	  
	  	  
	  return $report;	  
	}
	
	private function completeCtrSql($fromDate, $toDate){
	/*
	  $sql = "SELECT lb.account_id, lb.business_id, reg.localclassification_name, lb.business_name as Company, reg.Regions, impr.Impressions, clicks.Clicks
                FROM local_businesses lb,
	                (SELECT business_id, b.localclassification_id, lc.localclassification_name, count(2) as Regions
	                   FROM business_ranks b, local_classification lc
				      WHERE b.localclassification_id = lc.localclassification_id
			          GROUP BY business_id, localclassification_id, lc.localclassification_name order by business_id) reg,
                    (SELECT b.business_id, rcs.classification_id, SUM(rcs.views) as Impressions
				       FROM business_ranks b, region_classification_stats rcs
					  WHERE b.shirename_id = rcs.region_id
 					    AND b.localclassification_id = rcs.classification_id
					    AND rcs.view_date between '{$fromDate}' and '{$toDate}'
				      GROUP BY business_id, classification_id) impr,
                    (SELECT bs.business_id, sum(views) as Clicks
                       FROM business_stats bs
                      WHERE bs.view_date between '{$fromDate}' and '{$toDate}'
                      GROUP BY bs.business_id) clicks					
                      WHERE lb.business_id = reg.business_id	 
	                    AND lb.business_id = impr.business_id
	                    AND lb.business_id = clicks.business_id
	                    AND reg.localclassification_id = impr.classification_id
                      ORDER BY localclassification_name, Company";					 
*/
              $sql = "SELECT reg.account_id, reg.business_id, reg.localclassification_name, reg.business_name as Company, reg.Regions, impr.Impressions, clicks.Clicks
                       FROM 
	                    (SELECT lb.account_id, lb.business_id, lb.business_name , b.localclassification_id, lc.localclassification_name, count(2) as Regions
	                       FROM local_businesses lb, business_ranks b, local_classification lc
				          WHERE b.localclassification_id = lc.localclassification_id
							AND b.business_id = lb.business_id
			              GROUP BY business_id, localclassification_id, lc.localclassification_name order by business_id) reg
						   LEFT JOIN	
                        (SELECT  b.business_id, rcs.classification_id, SUM(rcs.views) as Impressions
                           FROM (select business_id, shirename_id, localclassification_id from business_ranks group by business_id, shirename_id, localclassification_id) b 
	                       LEFT JOIN (SELECT * FROM region_classification_stats WHERE view_date between '{$fromDate}' and '{$toDate}') rcs
	                         ON b.shirename_id = rcs.region_id
	                        AND b.localclassification_id = rcs.classification_id
                          GROUP BY business_id, classification_id) impr
						ON (reg.business_id = impr.business_id AND reg.localclassification_id = impr.classification_id)																		
		  			  LEFT JOIN
                        (SELECT distinct brs.business_id, sum(views) as Clicks
                           FROM (SELECT DISTINCT business_id from business_ranks) brs 
					  LEFT JOIN (SELECT business_id, Views FROM business_stats where view_date between '{$fromDate}' and '{$toDate}')  bs
							ON brs.business_id = bs.business_id
                      GROUP BY bs.business_id) clicks					
							ON reg.business_id = clicks.business_id
                      ORDER BY localclassification_name, Company";
					  					  
	  return $this->MyDB->query($sql);
	
	}
	
	public function outputCompleteCtrReport($reports){
	  $count = 0;
      //Output Complete CTR Report, Contents in csv format	  	
	  header("Content-type: application/octet-stream");
	  header("Content-Disposition: attachment; filename=\"CompleteCTR_Report.csv\"");	  	
	
	  foreach($reports as $classification => $report){
	    //echo "Month Starting " . $classification . "\n";
		foreach ($report as $k=>$data) {		 
            foreach($data as $key=>$value){
			  if($count < 1){ 
			    echo $key.",";
			  }	
		    }
			$count++;
	        echo "\n";
			break;
		}	  

		foreach ($report as $k=>$data) {
          foreach($data as $key=>$value){
			echo str_replace(",","",$value).",";
		  }
	      echo $classification . "\n";
		}
	    echo "\n";		
		
	  }
      exit;			 			  		  		
	}
	
	private function setini() {
      //Modify php ini vars to cater for large uploads
      ini_set('upload_max_filesize', '20M');
      //Increase execution time to 2 minutes
      ini_set('max_execution_time' , '3000');
      //Maximum time to allow parsing
      ini_set('max_input_time', '180');
      //Increase the size of possible post requests. Should be >= upload_max_filesize
      ini_set('post_max_size', '20M');
	  //Increase the amount of Memory at PHPs disposal
	  ini_set('memory_limit', '1256M');	  	
	}	
	
	private function region_views_per_day($region='',$date='', $google_filter=FALSE) {
		//die("GOOGLE FILTER = [$google_filter]");
		$query_1 = "SELECT views from region_classification_stats,shire_names 
		WHERE region_classification_stats.region_id = shire_names.shirename_id 
		AND region_classification_stats.view_date='$date' AND region_classification_stats.region_id='$region' ORDER BY
				shire_names.region_code";
		
		$query_2 ="SELECT sum(region_classification_stats.views - region_classification_stats.google_views) AS views from region_classification_stats,shire_names 
		WHERE region_classification_stats.region_id = shire_names.shirename_id 
		AND region_classification_stats.view_date='$date' AND region_classification_stats.region_id='$region' ORDER BY
				shire_names.region_code";
		
		$query = ($google_filter)?$query_2:$query_1;
		$rows = $this->MyDB->query($query);
		
		$total_views = 0;
		foreach ($rows as $row) {
			//$class_total = ($google_filter)?$row['views']-$row['google_views']:$row['views'];
			$class_total = $row['views'];
			$total_views += $class_total;
		}
		return $total_views;
	}
	
	
    private function total_views_per_day($region_rows, $date='', $google_filter=FALSE) {
		$view_data = array();
		foreach ($region_rows as $region) {
			$region_code = $region['region_code'];
			$region = $region['shirename_id'];
			$region_total = $this->region_views_per_day($region, $date, $google_filter);
			
			$view_data[$region_code] = $region_total;
			//$view_data[$date] = $view_package;
		}
		return $view_data;
	}
	
	public function getClassificationRegionTotalsReport($from_date, $to_date, $google_filter) {
		set_time_limit(0);
		ini_set("memory_limit","80M");
		$query ="SELECT * FROM shire_names ORDER BY region_code";
		$region_rows = $this->MyDB->query($query);
		$start_time = time();
		$message = '';
		
        $start_ts = strtotime($from_date);
        $end_ts = strtotime($to_date);
        //die("start_ts=$start_ts|end_ts=$end_ts|FILTER=$google_filter");
        
        
        $query_1 = "SELECT region_id,view_date,views from region_classification_stats,shire_names 
		WHERE region_classification_stats.region_id = shire_names.shirename_id 
		AND region_classification_stats.view_date BETWEEN '$from_date' AND '$to_date' ORDER BY shire_names.region_code";
        
        $query_2 ="SELECT region_id,view_date,sum(region_classification_stats.views - region_classification_stats.google_views) AS views from region_classification_stats,shire_names 
		WHERE region_classification_stats.region_id = shire_names.shirename_id 
		AND region_classification_stats.view_date BETWEEN '$from_date' AND '$to_date' ORDER BY shire_names.region_code";
		
		$query = ($google_filter)?$query_2:$query_1;
		$stat_rows = $this->MyDB->query($query);
		
		$current_ts = $start_ts;
        $result_set = array();
        $count = 0;
        while ($current_ts<=$end_ts) {
           $current_date_str = date('Y-m-d',$current_ts);
           $result_set[$current_date_str] = array();
           
		   foreach ($region_rows as $region) {
		   	  $view_count = 0;
		   	  $region_id =  $region['shirename_id'];
		   	  $region_code = $region['region_code'];
		   	  //$result_set[$current_date_str][$region_code]['region_code']=$region_code;
		      foreach ($stat_rows as $stat_entry) {
		   	     $entry_date = $stat_entry['view_date'];
		   	     $views = $stat_entry['views'];
		   	     $stat_entry_region = $stat_entry['region_id'];
		   	     if ($entry_date == $current_date_str && $stat_entry_region == $region_id) {
		   	     	$view_count+=$views;
		   	     }
		      }
		      $result_set[$current_date_str][$region_code] = $view_count;
		      //$result_set[$current_date_str][$region_id]['views']=$view_count;
		   }
		   
           if ($count > 30) { 
           	 //var_dump($result_set);
             $end_time = time();
             $tot_time = $end_time-$start_time;
             $message = "Operation took $tot_time seconds | GOOGLE FILTER:[$google_filter] | count = $count";
             break;
             
           	 //die("Operation took $tot_time seconds | GOOGLE FILTER:[$google_filter] | count = $count");
           }
		   $current_ts = mktime(0, 0, 0, date("m",$current_ts), date("d",$current_ts)+1, date("Y",$current_ts));
		   $count++;
        }
        
        
        header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"Report_Totals_$from_date--$to_date.csv\"");
		
		//echo "$message \n";
		
		echo "BOOOO \n";
		
        echo "DATE,";
        
       // foreach ($region_rows as $region) {
        for ($i = 0; $i <= count($region_rows)-1; $i++) {
			echo $region_rows[$i]['region_code'] . ' - ' . $region_rows[$i]['shirename_id'];
			if ($i < count($region_rows)-1) { echo ',';}
			//if end($fruits) .",";
		}
		echo "\n";
		
		foreach ($result_set as $date => $values) {
			echo "$date,";
			$i=0;
			foreach ($values as $region_code => $total) {
				echo $total;
			    if ($i < count($values)-1) { echo ',';}
				$i++;
			}
			echo "\n";
		}
		
		/*
        $current_ts = $start_ts;
        $result_set = array();
        
        while ($current_ts<=$end_ts) {
        	$date_str = date('Y-m-d',$current_ts);
        	$date_pack = $this->total_views_per_day($region_rows,$date_str,$google_filter);
        	$result_set[$date_str] = $date_pack;
        	var_dump($result_set);
        	$end_time = time();
        	$tot_time = $end_time-$start_time;
        	die("Operation took $tot_time seconds | GOOGLE FILTER:[$google_filter]");
        	$current_ts = mktime(0, 0, 0, date("m",$current_ts), date("d",$current_ts)+1, date("Y",$current_ts));
        }
        var_dump($result_set);
        die('END DUMP');
        */
	}

	
	public function getClassificationRegionReport($from_date, $to_date, $filter_google) {
		set_time_limit(0);
		ini_set("memory_limit","80M");

		//getting all regions
		$sql = "SELECT 
					`shirename_id` AS region_id, 
					`region_code` AS region_code 
				FROM 
					`shire_names` 
				ORDER BY 
					region_code
				";
		$regions = $this->MyDB->query($sql);
		if ($filter_google) {
			$sql = "SELECT 
				lc.localclassification_name, 
				st.classification_id, 
				st.region_id, 
				sum(st.views - st.google_views) AS views
			FROM
				region_classification_stats AS st
				LEFT JOIN local_classification AS lc
					ON (st.classification_id=lc.localclassification_id)
			WHERE
				st.view_date BETWEEN '$from_date' AND '$to_date'
			GROUP BY
				st.classification_id, st.region_id
			ORDER BY
				lc.localclassification_name
			";
		} else {
			$sql = "SELECT 
				lc.localclassification_name, 
				st.classification_id, 
				st.region_id, 
				sum(st.views) AS views
			FROM
				region_classification_stats AS st
				LEFT JOIN local_classification AS lc
					ON (st.classification_id=lc.localclassification_id)
			WHERE
				st.view_date BETWEEN '$from_date' AND '$to_date'
			GROUP BY
				st.classification_id, st.region_id
			ORDER BY
				lc.localclassification_name
			";
		}		
		$rows = $this->MyDB->query($sql);
//		prexit($rows);
		$classifications = $stat = array();
		foreach ($rows as $r) {
			$classifications[$r['classification_id']][] = $r;
		}
//		pre($classifications);
		$i=0;
		foreach ($classifications as $classification) {
			$temp = array();
			$j=0;
			$total_views = 0;
			foreach ($regions as $region) {
				$temp[$j]['views']=0;
				foreach ($classification as $c) {
					if($c['region_id']==$region['region_id']) {
						$temp[$j]['views']=$c['views'];
						break;
					}
				}
				$temp[$j]['region_code'] = $region['region_code'];
				$total_views += $temp[$j]['views'];
				$j++;
			}
			$stat[$i]['classification_name'] = $classification[0]['localclassification_name'];
			$stat[$i]['total_views'] = $total_views;
			$stat[$i]['regions'] = $temp;
			$i++;
		}
		$d = $i+1;
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"Report.csv\"");
		echo "CLASSIFICATION_NAME,";
		foreach ($regions as $region) {
			echo $region['region_code'].",";
		}
		echo "TOTAL,STARTDATE,ENDDATE";
		echo "\n";
		foreach ($stat as $k=>$data) {
			echo $data['classification_name'].",";
			foreach ($data['regions'] as $reg) {
				echo $reg['views'].",";
			}
			echo $data['total_views'].",$from_date,$to_date\n";
		}
		echo ",";
		echo "=SUM(B2:B$d),=SUM(C2:C$d),=SUM(D2:D$d),=SUM(E2:E$d),=SUM(F2:F$d),=SUM(G2:G$d),=SUM(H2:H$d),=SUM(I2:I$d),=SUM(J2:J$d),=SUM(K2:K$d),=SUM(L2:L$d),=SUM(M2:M$d),=SUM(N2:N$d),=SUM(O2:O$d),=SUM(P2:P$d),=SUM(Q2:Q$d),=SUM(R2:R$d),=SUM(S2:S$d),=SUM(T2:T$d),=SUM(U2:U$d)";
	echo "\n";
		exit;
	}

}
?>