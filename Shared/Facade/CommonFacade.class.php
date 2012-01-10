<?php
/**
* @title   CommonFacade.class.php

* @desc    This is an CommonFacade class. The purpose of this class is to perform the functions that are needed in every page. 
*/
class CommonFacade extends MainFacade {

    public function __construct(MyDB $MyDB){
        $this->MyDB = $MyDB;
        $this->MyDB->table=TBL_BANNER;
        $this->MyDB->sequenceName=TBL_BANNER;
        $this->MyDB->primaryCol="banner_id";
    }
	
		/**
		* @desc This function will be used for getting the banner and place where it had to be pasted. 
		* @return mixed Return true if banner fetching was successfull or false if failure.
		*/			
    public function getBanner($pageID)
    {		
		$condition		="banner_page={$pageID} AND status='1'";
        $QUERY			="SELECT * FROM banner WHERE $condition";
        $result			=$this->MyDB->query($QUERY);
		return $result;
    }	
   
   public function addIp()
   {
   	$ip=$_SERVER['REMOTE_ADDR'];
	$sql="select * from site_visitors where IP='{$ip}'";
	$results=$this->MyDB->query($sql);
	if($ip == @$results[0]['ip'])
	{
	  	
		
	}else{
		$sql = "INSERT INTO site_visitors (`id`, `IP`) VALUES (NULL, '$ip')";
		$this->MyDB->query($sql);
		
		$select_query="select * from site_stats where datereport='0000-00-00'";
		$ipResult=$this->MyDB->query($select_query);
		if(count($ipResult)==0)
			{
		     $SQL="INSERT INTO `pinkpages`.`site_stats` (
				`id` ,
				`unique_visitors` ,
				`total_visits` ,
				`total_visit_home_page` ,
				`unique_visit_home_page`
				)
				VALUES (
				NULL , '0', '0', '0', '0'
				)";
			 $this->MyDB->query($SQL);	
		  }
		
		$unique_visitors		=@$ipResult['0']['unique_visitors']+1;
		$unique_visit_home_page	=@$ipResult['0']['unique_visit_home_page']+1;
		
		$update_query	="UPDATE site_stats SET `unique_visitors` = '$unique_visitors',
						`unique_visit_home_page` = '$unique_visit_home_page' where datereport='0000-00-00'";
	   $this->MyDB->query($update_query);
	   
	   $date= date('Y-m-d');
	   $query="select * from site_stats where datereport='{$date}'";
	   $result=$this->MyDB->query($query);
	   $unique_visitors1		=@$result['0']['unique_visitors']+1;
	   $unique_visit_home_page1	=@$result['0']['unique_visit_home_page']+1;
	   $update_dateRecord	="UPDATE site_stats SET `unique_visitors` = '$unique_visitors1',
						`unique_visit_home_page` = '$unique_visit_home_page1' where datereport='{$date}'";
	   $this->MyDB->query($update_dateRecord);
	}
		$select_query="select * from site_stats where datereport='0000-00-00'";
		$ipResult=$this->MyDB->query($select_query);


		$total_visits			=@$ipResult['0']['total_visits']+1;
		$total_visit_home_page	=@$ipResult['0']['total_visit_home_page']+1;

			$update_query	="UPDATE site_stats SET 
						`total_visits` = '$total_visits',
						`total_visit_home_page` = '$total_visit_home_page' where datereport='0000-00-00'";
			$this->MyDB->query($update_query);
		//----------datewise record
		$date= date('Y-m-d');
		$query="select * from site_stats where datereport='{$date}'";
		$result=$this->MyDB->query($query);
		$total_visits1					=@$result['0']['total_visits']+1;
		$total_visit_home_page1	=@$result['0']['total_visit_home_page']+1;
		$unique_visitors1		=@$result['0']['unique_visitors']+1;
		$unique_visit_home_page1	=@$result['0']['unique_visit_home_page']+1;
		
		if(count($result)=='')
		{
			$SQL="INSERT INTO `pinkpages`.`site_stats` (
				`id` ,
				`unique_visitors` ,
				`total_visits` ,
				`total_visit_home_page` ,
				`unique_visit_home_page`,
				`datereport`
				)
				VALUES (
				NULL , '0', '0', '0', '0','{$date}'
				)";
			 $this->MyDB->query($SQL);
		}else{
			$update_query	="UPDATE site_stats SET 
						`total_visits` = '$total_visits1',
						`total_visit_home_page` = '$total_visit_home_page1' where datereport='{$date}'";
			$this->MyDB->query($update_query);
		}	
   }
   
	public function popularPageCount($page_id)
	{
	$PAGE_DETAIL_QUERY	="SELECT * FROM page_details WHERE page_id='$page_id'";
	$PAGE_DETAIL_RESULT	=$this->MyDB->query($PAGE_DETAIL_QUERY);
	
	$homePageCount		=$PAGE_DETAIL_RESULT['0']['count']+1;
	
	$update_query	="UPDATE page_details SET `count` = '$homePageCount' WHERE page_id='$page_id'";
	$this->MyDB->query($update_query);
	
	$date=date('Y-m-d');
	$select_page_stats="SELECT page_id,views FROM page_stats WHERE page_id='$page_id' AND datereport='$date'";
	$views=$this->MyDB->query($select_page_stats);
	if(count($views)==0)
	{
	 $page_views=@$views[0]['views']+1;
	 $insert_page_stats= "INSERT
	                      INTO `page_stats` (`id`,`page_id`,`datereport`,`views`)
						  VALUES (NULL,'{$page_id}','{$date}','{$page_views}')"; 
	// prexit($insert_page_stats);					  
     $this->MyDB->query($insert_page_stats);
	}
	else
	{
	$page_views=$views[0]['views']+1;
	$update_page_stats= "UPDATE page_stats SET views ='$page_views' WHERE page_id='$page_id' AND datereport ='$date'";
	//prexit($update_page_stats);
	$this->MyDB->query($update_page_stats);
	}
	}
   
   
}
/*END OF CommonFacade */

?>