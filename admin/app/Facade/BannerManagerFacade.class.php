<?php
class BannerManagerFacade extends MainFacade {

   public function __construct(MyDB $MyDB) {

        $this->MyDB = $MyDB;

        $this->MyDB->table=TBL_BANNER;
        $this->MyDB->sequenceName=TBL_BANNER;
        $this->MyDB->primaryCol="banner_id";
    }/* END __construct */
	
	
		/**
		* @desc This function will be used for adding the details of banner.
		* @return mixed Return true if addition was successfull or false if failure.
		*/
		
    public function getMonths(){
	
		$monthArray = array (1=>"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

		$valMonth="";
		foreach ($monthArray as $key => $val)
		{
			if(isset($_POST['FMonth']) && $key==$_POST['FMonth'])
			{
				$selMonth  ='selected="selected"';
				$valMonth.='<option value="'.$key.'" '.$selMonth.'>'.$val.'</option>';
			}else
			{
				$selMonth  ='';
				$valMonth.='<option value="'.$key.'" '.$selMonth.'>'.$val.'</option>';
			}
		}
		
		return $valMonth;
		
    }	
	
	public function getDates(){
		$valDate ="";
		for($i=1;$i<=31;$i++)
		{
			if(isset($_POST['FDate']) && $i==$_POST['FDate'])
			{
				$selDate ='selected="selected"';
				$valDate.='<option value="'.$i.'" '.$selDate.'>'.$i.'</option>';
			}else
			{
				$selDate ='';
				$valDate.='<option value="'.$i.'" '.$selDate.'>'.$i.'</option>';
			}
		}
		
		return $valDate;
		
	}
	
	public function getYears(){
		$valYear ="";
		for($y=2007;$y<=2020;$y++)
		{
			if(isset($_POST['FYear']) && $y==$_POST['FYear'])
			{
				$selYear ='selected="selected"';
				$valYear.='<option value="'.$y.'" '.$selYear.'>'.$y.'</option>';
			}else
			{
				$selYear ='';
				$valYear.='<option value="'.$y.'" '.$selYear.'>'.$y.'</option>';
			}
		}

		return $valYear;
	
	}
				 
   	public function addBannerDetails($post,$logo)
    {
		$result =$this->__bannerAddValidation($post,$logo);
		if(!$result['result'])
		{
		return $result;
		}
			$classification 		= (!empty($post['classification']))?$post['classification']:0;		
			$title					= $post['title'];
			$description			= $post['description'];
			$bannercheck			= $post['bannercheck'];
            $duration               = $post['duration'];			
			$page					= $post['page'];
			$position 				= (!empty($post['position']))?$post['position']:NULL;			
				if($bannercheck == '1')
				{
					$width			= $post['width'];
					$height			= $post['height'];
					$alttext		= $post['alttext'];
					$link			= $post['link'];
					$html			= '';
					$bannerType		= '1';
				}else{
					$width			='';
					$height			='';
					$alttext		='';
					$link			='';
					$html			=$post['html'];
					$bannerType		='2';
				}
				if($html != '' && $logo['banner']['name'] !='')
				{
				$rec=array("result"=>false, "message"=>'Select any one option from Image or HTML');
				return $rec;
				}
				

		
		$image=$logo['banner']['name'];
		$tmp=$logo['banner']['tmp_name'];		
		move_uploaded_file($tmp, BANNER_UPLOAD_PATH."$image");
		
		$banner_location = BANNER_UPLOAD_PATH;
		
		 $QUERY		="INSERT INTO `banner` (
		`banner_title` ,
		`group_id`,
		`banner_desc` ,
		`banner_name` ,
		`banner_width` ,
		`banner_height` ,
		`alt_text` ,
		`banner_page` ,
		`banner_location` ,		
		`banner_link` ,		
		`html_code` ,
		`banner_type` ,
		`add_date` ,
		`expiry_date` ,		
		`localclassification_id`,
		`market_id`,		
		`position`,
		`status`,
		`category`
		)
		VALUES (
		'$title', '0', '$description','$image','$width','$height','$alttext','5', '$banner_location','$link','$html','$bannerType', NOW(), ADDDATE(NOW(), $duration),'$classification','$market','$position', '1','1'
		)"; 		
			
		$this->MyDB->query($QUERY);
		$rec=array("result"=>true, "message"=>'Added Successfully');
		return $rec;
        }
	
	
		/**
		* @desc This function will be used for adding the details of banner.
		* @return mixed Return true if addition was successfull or false if failure.
		*/
				 
   	public function addClassificationBannerDetails($post,$logo)
    {
		$result =$this->__classificationBannerAddValidation($post,$logo);
		if(!$result['result'])
		{
		return $result;
		}

			$classification 		= (!empty($post['classification']))?$post['classification']:NULL;

			$id                    = explode(",", $post['accountid']);
			$businessID             = $id[0];
			$accountID              = $id[1];
			$title					= $post['title'];
			$description			= (isset($post['description'])) ? $post['description'] : '';
			$bannercheck			= $post['bannercheck'];		
            
			$duration               = $post['duration'];									
			//If the banner contract is recurring;
			if($duration == -1){
			  $duration = "'"."3000-01-01"."'";
			} else {
			  $duration = 'ADDDATE(CURDATE(), '.$post["duration"].')';
			}

			$market                 = $post['market'];
			$position 				= (!empty($post['position']))?$post['position']:NULL;
				if($bannercheck == '1')
				{
					$width			= $post['width'];
					$alttext		= $post['alttext'];
					$link			= $post['link'];
					$html			= '';
					$bannerType		= '1';
				}else{
					$width			='';
					$alttext		='';
					$link			='';
					$html			=$post['html'];
					$bannerType		='2';
				}
				if($html != '' && $logo['banner']['name'] !='')
				{
				$rec=array("result"=>false, "message"=>'Select any one option from Image or HTML');
				return $rec;
				}
				
				
		
		$image=$logo['banner']['name'];
		$tmp=$logo['banner']['tmp_name'];		
		move_uploaded_file($tmp, BANNER_UPLOAD_PATH."$image");
		$banner_location = BANNER_UPLOAD_PATH;
		
		 $QUERY		="INSERT INTO `banner` (
		`business_id` ,		 
		`account_id` ,
		`banner_title` ,
		`group_id`,
		`banner_desc` ,
		`banner_name` ,
		`banner_width` ,
		`alt_text` ,
		`banner_page` ,
		`banner_location` ,		
		`banner_link` ,		
		`html_code` ,
		`banner_type` ,
		`add_date` ,
		`expiry_date` ,		
		`localclassification_id`,
		`market_id`,		
		`position`,
		`status`,
		`category`
		)
		VALUES (
		'$businessID', '$accountID', '$title', '0', '$description','$image','$width','$alttext','5', '$banner_location','$link','$html','$bannerType', NOW(), $duration,'$classification','$market','$position', '1','1'
		)"; 		
				
		$this->MyDB->query($QUERY);
		$rec=array("result"=>true, "message"=>'Classification Banner Added Successfully');
		//return $rec;
        }		
		/**
		* @desc This function will be used for adding the details of Affiliate banner.
		* @return mixed Return true if affiliate banner addition was successfull or false if failure.
		*/
				 
   	public function addAffiliateBannerDetails($post,$logo)
    {
		$result =$this->__affiliateBannerAddValidation($post,$logo);
		if(!$result['result'])
		{
		return $result;
		}
			$title			=$post['title'];		
			$width			=$post['width'];
			$height			=$post['height'];
			$alttext		=$post['alttext'];

		$image=$logo['banner']['name'];
		$tmp=$logo['banner']['tmp_name'];		
		move_uploaded_file($tmp, BANNER_UPLOAD_PATH."$image");
		
		
		$QUERY		="INSERT INTO `affiliate_banner` (
		`banner_id` ,
		`banner_name` ,
		`banner_title` ,
		`banner_width` ,
		`banner_height` ,
		`is_published` ,
		`alt_text` ,
		`add_date`,
		`status`		
		)
		VALUES (
		'' ,'$image','$title','$width','$height','1','$alttext',NOW(),'1'
		)";
		
		$this->MyDB->query($QUERY);
		$rec=array("result"=>true, "message"=>'Added Successfully');
		return $rec;
        }		
		
		
		/**
		* @desc This function will be used for editing the details of banner.
		* @return mixed Return true if editing was successfull or false if failure.
		*/		
		
	public function editBannerDetails($get,$post,$logo)
    {
	
		$result =$this->__bannerEditValidation($post,$logo);
		if(!$result['result'])
		{
		return $result;
		}
			$bannerID				=$get['ID'];
			$title					=$post['title'];
			$description			=$post['description'];
			$bannercheck			=$post['bannercheck'];
			$page					=$post['page'];
				if($bannercheck == '1')
				{
					$width			=$post['width'];
					$height			=$post['height'];
					$alttext		=$post['alttext'];
					$link			=$post['link'];
					$html			='';
					$bannerType		='1';
				}else{
					$width			='';
					$height			='';
					$alttext		='';
					$link			='';
					$html			=$post['html'];
					$bannerType		='2';
				}
				
			
		$QUERY			="SELECT banner_name FROM banner WHERE banner_id='{$bannerID}'";
		$bannerValue	=$this->MyDB->query($QUERY);
			if($logo['banner']['name'] == '')
			{				
				$image=$bannerValue['0']['banner_name'];
			}else{
		
				$image=$logo['banner']['name'];
				$tmp=$logo['banner']['tmp_name'];		
				move_uploaded_file($tmp, BANNER_UPLOAD_PATH."$image");
				
			}
		
		$QUERY		="UPDATE `banner` SET 
		`banner_title` = '$title',
		`banner_desc` = '$description',
		`banner_name` = '$image',
		`banner_width` = '$width',
		`banner_height` = '$height',
		`alt_text` = '$alttext',
		`banner_link` = '$link',
		`banner_page` = '$page',
		`html_code` = '$html',
		`banner_type` = '$bannerType'
		 WHERE `banner_id` ='{$bannerID}'"; 
		
		$this->MyDB->query($QUERY);
		$rec=array("result"=>true, "message"=>'Site Updated Successfully');
		return $rec;
        }
		
		/**
		* @desc This function will be used for editing the details of banner.
		* @return mixed Return true if editing was successfull or false if failure.
		*/		
		
	public function editClassificationBannerDetails($get,$post,$logo)
    {
		$result =$this->__bannerClassificationEditValidation($post,$logo);
		if(!$result['result'])
		{
		return $result;
		}
		
			$classification 		= (!empty($post['classification']))?$post['classification']:NULL;					
			$bannerID				=$get['ID'];
			$title					=$post['title'];
			$description			=$post['description'];
			$bannercheck			=$post['bannercheck'];
			$position 				= (!empty($post['position']))?$post['position']:NULL;
			
			$width 					= (!empty($post['width']))?$post['width']:NULL;
			$height 				= (!empty($post['height']))?$post['height']:NULL;
			$alttext 				= (!empty($post['alttext']))?$post['alttext']:NULL;
			$link 					= (!empty($post['link']))?$post['link']:NULL;
			$html 					= (!empty($post['html']))?$post['html']:NULL;
	
			
		/*		if($bannercheck == '1')
				{
					$width			=$post['width'];
					$height			=$post['height'];
					$alttext		=$post['alttext'];
					$link			=$post['link'];
					$bannerType		='1';
				}else{
					$html			=$post['html'];
					$bannerType		='2';
				}*/
				
		
		$QUERY			="SELECT banner_name FROM banner WHERE banner_id='{$bannerID}'";
		$bannerValue	=$this->MyDB->query($QUERY);
			if($logo['banner']['name'] == '')
			{				
				$image=$bannerValue['0']['banner_name'];
			}else{
				 $image=$logo['banner']['name'];
				$tmp=$logo['banner']['tmp_name'];		
				move_uploaded_file($tmp, BANNER_UPLOAD_PATH."$image");
				
			}
		if($bannercheck == '1')
		{
		$QUERY		="UPDATE `banner` SET 
		`banner_title` = '$title',
		`banner_desc` = '$description',
		`banner_name` = '$image',
		`banner_width` = '$width',
		`banner_height` = '$height',
		`alt_text` = '$alttext',
		`banner_link` = '$link',
		`banner_page` = '5',
		`localclassification_id` = '$classification',
		`position` = '$position',
		`banner_type` = '1'
		 WHERE `banner_id` ='{$bannerID}'";
		 }else{
		$QUERY		="UPDATE `banner` SET 
		`banner_title` = '$title',
		`banner_desc` = '$description',
		`banner_name` = '$image',
		`alt_text` = '$alttext',
		`banner_page` = '5',
		`html_code` = '$html',
		`localclassification_id` = '$classification',
		`position` = '$position',
		`banner_type` = '2'
		 WHERE `banner_id` ='{$bannerID}'"; 
		 } 
		
		$this->MyDB->query($QUERY);
		$rec=array("result"=>true, "message"=>'Classification Banner Updated Successfully');
		return $rec;
        }

		
		/**
		* @desc This function will be used for editing the details of banner.
		* @return mixed Return true if editing was successfull or false if failure.
		*/		
		
	public function editAffiliateBannerDetails($get,$post,$logo)
    {
	
		$result =$this->__AffiliateBannerEditValidation($post,$logo);
		if(!$result['result'])
		{
		return $result;
		}		
			$bannerID		=$get['ID'];
			$title			=$post['title'];
			$width			=$post['width'];
			$height			=$post['height'];
			$alttext		=$post['alttext'];

		
		$QUERY			="SELECT banner_name FROM affiliate_banner WHERE banner_id='{$bannerID}'";
		$bannerValue	=$this->MyDB->query($QUERY);
		if($logo['banner']['name'] == '')
		{
		$image=$bannerValue['0']['banner_name'];
		}else{
		$image=$logo['banner']['name'];
		$tmp=$logo['banner']['tmp_name'];		
		//move_uploaded_file($tmp,"../Uploads/banner/$image");
		move_uploaded_file($tmp, BANNER_UPLOAD_PATH."$image");		
		}
		
		$QUERY		="UPDATE `affiliate_banner` SET 
		`banner_title` = '$title',		
		`banner_name` = '$image',
		`banner_width` = '$width',
		`banner_height` = '$height',
		`alt_text` = '$alttext'
		 WHERE `banner_id` ='{$bannerID}'";
		
		$this->MyDB->query($QUERY);
		$rec=array("result"=>true, "message"=>'Updated Successfully');
		return $rec;
        }		
				


		/**
		* @desc This function will be used for counting the number of list that has to be displayed.
		* @return mixed Return true if count was successfull or false if failure.
		*/
	public function countViewListing()
    {
		$ret = 0;
		$this->MyDB->setSelect("count(banner_id) as cnt");
        $result = $this->MyDB->getAll();
		$ret = $result[0]['cnt'];
        return $ret;
    }
	

		/**
		* @desc This function will be used for getting the details of banner. 
		* @return mixed Return true if selection was successfull or false if failure.
		*/			
    public function viewListing($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
    {
        $QUERY				= "SELECT * FROM banner WHERE category='0' ORDER BY banner_id DESC LIMIT $fr,".DEFAULT_PAGING_SIZE."";
        $result				= $this->MyDB->query($QUERY);
		
		$fetch_count		= "SELECT COUNT(banner_id) AS cnt FROM banner WHERE category='0'";
        $result_count		= $this->MyDB->query($fetch_count);
		$count				= $result_count[0]['cnt'];
		
		$res['banner']		= $result;
		$res['paging']		= Paging::numberPaging($count, $fr, DEFAULT_PAGING_SIZE);
		return $res;
    }
	
			/**
		* @desc This function will be used for getting the details of banner. 
		* @return mixed Return true if selection was successfull or false if failure.
		*/			
    public function ClassificationBannerManager($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
    {
		$count_banner			= "SELECT COUNT(banner_id) AS cnt FROM banner WHERE `category`='1' ";
        $count_result			= $this->MyDB->query($count_banner);
		$count					= $count_result[0]['cnt'];
		
        $QUERY="SELECT b.*, lb.business_name
		          FROM banner b, local_businesses lb
				 WHERE b.category='1' 
				   AND b.account_id = lb.account_id
				   AND b.account_id != ''
				   AND b.business_id = lb.business_id
				 ORDER BY localclassification_id DESC LIMIT $fr,".DEFAULT_PAGING_SIZE."";
        $result=$this->MyDB->query($QUERY);
		
		foreach ($result as $k=>$category) {
			$sql = "SELECT localclassification_name FROM local_classification  WHERE localclassification_id={$category['localclassification_id']}";
			$rs = $this->MyDB->query($sql);
			
		$result[$k]['classification_name'] = $rs[0]['localclassification_name'];
			}
					
		$res['banner']	= $result;
		$res['paging']	= Paging::numberPaging($count, $fr, DEFAULT_PAGING_SIZE);
		return $res;
    }
	

		/**
		* @desc This function will be used for counting the number of list that has to be displayed.
		* @return mixed Return true if count was successfull or false if failure.
		*/
	public function countviewReport($ID)
    {
		$ret = 0;
		$banner_id	=$ID['ID'];
		$QUERY="SELECT count(daily_stats_id) as cnt FROM daily_banner_stats WHERE banner_id='{$banner_id}'";
        $result=$this->MyDB->query($QUERY);
		$ret = $result[0]['cnt'];
        return $ret;
    }
	

		/**
		* @desc This function will be used for getting the details of banner. 
		* @return mixed Return true if selection was successfull or false if failure.
		*/			
    public function viewReport($ID,$fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
    {
		$currentdate= date("Y-m-d");
		$banner_id	=$ID['ID'];
      // 	echo $QUERY="SELECT * FROM daily_banner_stats WHERE banner_id='{$banner_id}' AND 'day' BETWEEN '$currentdate' AND (SELECT min(day) FROM daily_banner_stats WHERE banner_id='{$banner_id}')";
		
		$MIN_DATE		="SELECT min(day) AS minday FROM daily_banner_stats WHERE banner_id='{$banner_id}'";
		$MIN_DATE_RESULT=$this->MyDB->query($MIN_DATE);
		$minday=$MIN_DATE_RESULT[0]['minday'];
		
		$explodedMinDay=(explode("-",$minday));
		@$minYear	=$explodedMinDay[0];
		@$minMonth	=$explodedMinDay[1];
		@$minDate	=$explodedMinDay[2];
		
		$explodedMaxDay=(explode("-",$currentdate));
		$maxYear	=$explodedMaxDay[0];
		$maxMonth	=$explodedMaxDay[1];
		$maxDate	=$explodedMaxDay[2];
		
		
		$first_date = strtotime($minday);
		$second_date = time();
		
		$offset = $second_date-$first_date;
		
		$Totaldays	=  floor($offset/(60*60*24))+1;
		
		
		

		
		$banner_id	=$ID['ID'];
       	$QUERY="SELECT * FROM daily_banner_stats WHERE banner_id='{$banner_id}' LIMIT $fr,".DEFAULT_PAGING_SIZE."";
        $result=$this->MyDB->query($QUERY);
		$res['banner']	= $result;
		$res['paging']	= Paging::numberPaging($this->countviewReport($ID), $fr, DEFAULT_PAGING_SIZE);
		return $res;
    }
	
	public function totalDates($ID)
    {
	
		$currentdate= date("Y-m-d");
		$banner_id	=$ID['ID'];
		@$MIN_DATE		="SELECT min(day) AS minday FROM daily_banner_stats WHERE banner_id='{$banner_id}'";
		@$MIN_DATE_RESULT=$this->MyDB->query($MIN_DATE);
		@$minday=$MIN_DATE_RESULT[0]['minday'];
		
		$explodedMinDay=(explode("-",$minday));
		$minYear	=$explodedMinDay[0];
		$minMonth	=$explodedMinDay[1];
		$minDate	=$explodedMinDay[2];
		
		$explodedMaxDay=(explode("-",$currentdate));
		$maxYear	=$explodedMaxDay[0];
		$maxMonth	=$explodedMaxDay[1];
		$maxDate	=$explodedMaxDay[2];
		
		
		$first_date = strtotime($minday);
		$second_date = time();
		
		$offset = $second_date-$first_date;
		
		$Totaldays	=  floor($offset/(60*60*24));
		
		
		
		$startDate = date("Y-m-d", mktime(0, 0, 0, $minMonth, $minDate, $minYear));
		$endDate = date("Y-m-d", mktime(0, 0, 0,$minMonth , $minDate+$Totaldays, $minYear));
		$temp=array();
		for($i=0;$i<=$Totaldays;$i++)
		{
		$temp[] = date("Y-m-d", mktime(0, 0, 0,$minMonth,  $minDate+$i, $minYear));
		}
		return $temp;
    }	
	
	
	
		/**
		* @desc This function will be used for getting the details of banner. 
		* @return mixed Return true if selection was successfull or false if failure.
		*/			
    public function linkDate($date)
    {
		$banner_id	=$date['ID'];
		$day		=$date['Date'];
        $QUERY="SELECT * FROM hourley_banner_stats WHERE day='{$day}' AND banner_id='{$banner_id}'";
        $result=$this->MyDB->query($QUERY);
		return $result;
    }			
	
	

		/**
		* @desc This function will be used for counting the number of list that has to be displayed.
		* @return mixed Return true if count was successfull or false if failure.
		*/
	public function countViewAffilateListing()
    {
		$ret = 0;
		$QUERY="SELECT count(banner_id) as cnt FROM affiliate_banner";
        $result=$this->MyDB->query($QUERY);
		$ret = $result[0]['cnt'];
        return $ret;
    }
	

		/**
		* @desc This function will be used for getting the details of banner. 
		* @return mixed Return true if selection was successfull or false if failure.
		*/			
    public function viewAffilateListing($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
    {
        $QUERY="SELECT * FROM affiliate_banner ORDER BY banner_id DESC LIMIT $fr,".DEFAULT_PAGING_SIZE."";
        $result=$this->MyDB->query($QUERY);
		$res['banner']	= $result;
		$res['paging']	= Paging::numberPaging($this->countViewAffilateListing(), $fr, DEFAULT_PAGING_SIZE);
		return $res;
    }	
	
	
		/**
		* @desc This function will be used for getting the details of banner on the basis of specified id.
		* @return mixed Return true if selection was successfull or false if failure.
		*/	
	public function selectedListing($get)
    {
		$bannerID	=$get['ID'];
        $QUERY="SELECT * FROM banner WHERE banner_id='{$bannerID}'";
        $res=$this->MyDB->query($QUERY);
        return $res;
    }
	
	
		/**
		* @desc This function will be used for getting the details of banner on the basis of specified id.
		* @return mixed Return true if selection was successfull or false if failure.
		*/	
	public function selectedAffiliateListing($get)
    {
		$bannerID	=$get['ID'];
        $QUERY="SELECT * FROM affiliate_banner WHERE banner_id='{$bannerID}'";
        $res=$this->MyDB->query($QUERY);
        return $res;
    }	
	
	/**
	* @desc This function will be used for changig the status of banner on the basis of specified page id.
	* @return mixed Return true if status change was successfull or false if failure.
	*/	
	public function changeStatus($get)
    {
		$bannerID				= $get['ID'];
		$page					= $get['page'];
				
		$condition  			= "banner_id={$bannerID}";
		$QUERY					= "SELECT status from banner WHERE $condition";
		$res					= $this->MyDB->query($QUERY);
		
		if($page != 4 && $page != 5)
		{
				$page;
				$QUERY1					="UPDATE `banner` SET `status` = '0' WHERE `banner_page` ='{$page}'"; 
				$this->MyDB->query($QUERY1);
		}
		 

		if($res['0']['status'] =='0')
		{
			$data 		= array('status'=>'1');
		}else{
    	    $data 		= array('status'=>'0');
		}
        $this->MyDB->setWhere($condition);
		$res			= $this->MyDB->update($data);
		$statusResult	= array("result"=>true, "message"=>'Status Changed Successfully');		
        return $statusResult;
    }
	
	/**
	* @desc This function will be used for changig the status of banner on the basis of specified page id.
	* @return mixed Return true if status change was successfull or false if failure.
	*/	
	public function change_classification_status($get)
    {
		$bannerID				= $get['ID'];
		
				
		$condition  			= "banner_id={$bannerID}";
		$QUERY					= "SELECT status from banner WHERE $condition";
		$res					= $this->MyDB->query($QUERY);
				 

		if($res['0']['status'] =='0')
		{
			$data 		= array('status'=>'1');
		}else{
    	    $data 		= array('status'=>'0');
		}
        $this->MyDB->setWhere($condition);
		$res			= $this->MyDB->update($data);
		$statusResult	= array("result"=>true, "message"=>'Status Changed Successfully');		
        return $statusResult;
    }
	
	
	public function removeBanner($get)
	{
		$removeQuery		="UPDATE `banner` SET `banner_name` = '' WHERE `banner_id` ={$get['ID']}";
		$this->MyDB->query($removeQuery);
		
		$removeBanner=array("result"=>true, "message"=>'Banner removed successfully');		
        return $removeBanner;
	}
	
		/**
		* @desc This function will be used for changig the status of banner on the basis of specified id.
		* @return mixed Return true if status change was successfull or false if failure.
		*/	
	public function changeAffStatus($get)
    {
		$bannerID	=$get['ID'];
		
		$condition  ="banner_id={$bannerID}";
		$QUERY		="SELECT status from affiliate_banner WHERE $condition";
		$res=$this->MyDB->query($QUERY);

		if($res['0']['status'] =='0')
		{
		
		$SQL	="UPDATE affiliate_banner SET `status` = '1' WHERE banner_id ={$bannerID}";

		}else{
		
		$SQL	="UPDATE affiliate_banner SET `status` = '0' WHERE banner_id ={$bannerID}";

		}
		$res=$this->MyDB->query($SQL);
		$statusResult=array("result"=>true, "message"=>'Status Changed Successfully');		
        return $statusResult;

    }	
	


		/**
		* @desc This function will be used for adding validation to the details of banner.
		* @return mixed Return true if validation was successfull or false if failure.
		*/
 	private function __bannerAddValidation(&$data,&$logo)
    {

        $retArray = array("result"=>false, "message"=>'');
        $errors = array();
		$bannercheck	=$data['bannercheck'];
		
        if(empty($data['title'])) 
		{
            $errors[] = "Title is blank!!";
        }
		
/*        
        //This column no longer required

		if(empty($data['description'])) 
		{
            $errors[] = "Description is blank!!";
        }
*/
		
	if($bannercheck == '1')
	{
        if(empty($logo['banner']['name'])) 
		{
            $errors[] = "Please Select any Banner";
        }
        if(empty($data['width'])) 
		{
            $errors[] = "Width is blank!!";
        }
    
        if(empty($data['link'])) 
		{
            $errors[] = "Link is blank!!";
        }
	}
	
	if($bannercheck == '2')
	{
    
        if(empty($data['html'])) 
		{
            $errors[] = "Please enter HTML code for the Banner!!";
        }
	}	
		
		if($data['page']=='SelectOne') 
		{
            $errors[] = "Please Select Banner Page!!";
        }
		
			

					
        if(count($errors) == 0) 
		{
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }
	
		/**
		* @desc This function will be used for adding validation to the details of banner.
		* @return mixed Return true if validation was successfull or false if failure.
		*/
 	private function __classificationBannerAddValidation(&$data,&$logo)
    {

        $retArray = array("result"=>false, "message"=>'');
        $errors = array();
		$bannercheck	=$data['bannercheck'];
		
        if($data['accountid'] == '0') 
		{
            $errors[] = "Please select a Business Name!!";
        }		
		
        if($data['classification'] == '0') 
		{
            $errors[] = "Select any Classification!!";
        }
						
		if($data['position'] == '0') 
		{
            $errors[] = "Select any Position!!";
        }
			
        if(empty($data['title'])) 
		{
            $errors[] = "Title is blank!!";
        }
        
/*
        //Column no longer required		
		if(empty($data['description'])) 
		{
            $errors[] = "Description is blank!!";
        }
		
*/		
	if($bannercheck == '1')
	{
        if(empty($logo['banner']['name'])) 
		{
            $errors[] = "Please Select any Banner";
        }
        if(empty($data['width'])) 
		{
            $errors[] = "Width is blank!!";
        }

/*		
        //Column no longer required
        if(empty($data['height'])) 
		{
            $errors[] = "Height is blank!!";
        }		
*/    
        if(empty($data['link'])) 
		{
            $errors[] = "Link is blank!!";
        }
	}
	
	if($bannercheck == '2')
	{
    
        if(empty($data['html'])) 
		{
            $errors[] = "Please enter HTML code for the Banner!!";
        }
	}	
		
					
        if(count($errors) == 0) 
		{
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }	
	
	/**
		* @desc This function will be used for adding validation to the details of banner.
		* @return mixed Return true if validation was successfull or false if failure.
		*/
 	private function __affiliateBannerAddValidation(&$data,&$logo)
    {

        $retArray = array("result"=>false, "message"=>'');
        $errors = array();
		
		        
        if(empty($logo['banner']['name'])) 
		{
            $errors[] = "Please Select any Banner";
        }
        if(empty($data['width'])) 
		{
            $errors[] = "Width is blank!!";
        }
		
        if(empty($data['height'])) 
		{
            $errors[] = "Height is blank!!";
        }
        if(empty($data['title'])) 
		{
            $errors[] = "Title is blank!!";
        }				
    		
        if(count($errors) == 0) 
		{
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }	
	

		/**
		* @desc This function will be used for adding validation to the details of banner.
		* @return mixed Return true if validation was successfull or false if failure.
		*/	
		private function __bannerEditValidation(&$data,&$logo)
    	{

        $retArray = array("result"=>false, "message"=>'');
        $errors = array();
		$bannercheck	=$data['bannercheck'];
		
        if(empty($data['title'])) 
		{
            $errors[] = "Title is blank!!";
        }
        if(empty($data['description'])) 
		{
            $errors[] = "Description is blank!!";
        }
      
       if($bannercheck == '1')
	{

        if(empty($data['width'])) 
		{
            $errors[] = "Width is blank!!";
        }
    
        if(empty($data['link'])) 
		{
            $errors[] = "Link is blank!!";
        }
	}
	
		if($bannercheck == '2')
	{
    
        if(empty($data['html'])) 
		{
            $errors[] = "Please enter HTML code for the Banner!!";
        }
	}
		
		if($data['page']=='SelectOne') 
		{
            $errors[] = "Please Select Banner Page!!";
        }
			
			
        if(count($errors) == 0) 
		{
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }	
	
		/**
		* @desc This function will be used for adding validation to the details of banner.
		* @return mixed Return true if validation was successfull or false if failure.
		*/	
		private function __bannerClassificationEditValidation(&$data,&$logo)
    	{

        $retArray = array("result"=>false, "message"=>'');
        $errors = array();
		$bannercheck	=$data['bannercheck'];
	
        if($data['classification'] == '0') 
		{
            $errors[] = "Select any classification!!";
        }
        
		if($data['position'] == '0') 
		{
            $errors[] = "Select any position!!";
        }
				
			
				
        if(empty($data['title'])) 
		{
            $errors[] = "Title is blank!!";
        }
        if(empty($data['description'])) 
		{
            $errors[] = "Description is blank!!";
        }
      
       if($bannercheck == '1')
	{

        if(empty($data['width'])) 
		{
            $errors[] = "Width is blank!!";
        }
    
        if(empty($data['link'])) 
		{
            $errors[] = "Link is blank!!";
        }
	}
	
		if($bannercheck == '2')
	{
    
        if(empty($data['html'])) 
		{
            $errors[] = "Please enter HTML code for the Banner!!";
        }
	}
		

			
			
        if(count($errors) == 0) 
		{
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }	
	
		/**
		* @desc This function will be used for adding validation to the details of banner.
		* @return mixed Return true if validation was successfull or false if failure.
		*/	
		private function __AffiliateBannerEditValidation(&$data,&$logo)
    	{

        $retArray = array("result"=>false, "message"=>'');
        $errors = array();
				
        if(empty($data['width'])) 
		{
            $errors[] = "Width is blank!!";
        }
		
        if(empty($data['height'])) 
		{
            $errors[] = "Height is blank!!";
        }
		
		if(empty($data['title'])) 
		{
            $errors[] = "Title is blank!!";
        }

        if(count($errors) == 0) 
		{
            $retArray['result'] = true;
        }
        $retArray['message'] = $errors;
        return $retArray;
    }		
	
	
		/**
		* @desc This function will be used for deleting the banner on the basis of required ID.
		* @return mixed Return true if deletion was successfull or false if failure.
		*/	
    public function deleteBanner($get)
    {
        $bannerID		=$_GET['ID'];       
        $QUERY			="DELETE 
		      				FROM 
			       				banner 
			  				WHERE
			       				banner_id=".$bannerID."";
		$this->MyDB->query($QUERY);
        $Array = array("result"=>true, "message"=>'Deleted Successfully');
        return $Array;
    }		
        	
		
		/**
		* @desc This function will be used for deleting the banner on the basis of required ID.
		* @return mixed Return true if deletion was successfull or false if failure.
		*/	
    public function deleteAffiliateBanner($get)
    {
        $bannerID		=$_GET['ID'];       
        $QUERY			="DELETE 
		      				FROM 
			       				 affiliate_banner 
			  				WHERE
			       				banner_id=".$bannerID."";
		$this->MyDB->query($QUERY);
        $Array = array("result"=>true, "message"=>'Deleted Successfully');
        return $Array;
    }
	
	public function fetchClassification()
	{
		$classificationFetch			=" SELECT * FROM local_classification 
		                                   Order by localclassification_name";
		$result							=$this->MyDB->query($classificationFetch);
		return $result;
	}
	
	public function fetchMarkets(){
	  $marketFetch                      = "SELECT * FROM markets";
	  $result                           = $this->MyDB->query($marketFetch);
	  return $result;
	}
	
	public function fetchRegionsFromMarket($market_id){
	  $sql                              = "SELECT sn.shirename_id, sn.shirename_shirename
                                             FROM markets_to_shires mts, shire_names sn
                                            WHERE mts.market_id = ".$market_id."
                                              AND mts.shirename_id = sn.shirename_id";
											  
      $results                          = $this->MyDB->query($sql);
	  return $results;
	}
	
	public function fetchGroup()
	{
		$groupFetch						="SELECT * FROM  groups ";
		$result							=$this->MyDB->query($groupFetch);
		return $result;
	}
	
	/**
	*@desc  This function is used for fetching all the regions.
	*/
	public function fetchRegion($business_id=0)
	{
		
		$SQL="SELECT * FROM shire_names";
		$rec=$this->MyDB->query($SQL);
		return $rec;
	}


	public function getPosition($get)
	{	
		$localclassification_id			= $get['classificationId'];
        $market_id                      = $get['marketId'];		
		$duration                       = $get['durationId']; 
		$fetch_classification			= "SELECT position FROM banner WHERE localclassification_id={$localclassification_id} and market_id={$market_id} and NOW() between add_date and expiry_date";				
		$classification_result			= $this->MyDB->query($fetch_classification);
		return $classification_result;
	}
	
	
	public function getPositionEdit($get)
	{	
		$banner_id						= $get['ID'];
		$position						= array('A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E');
		$fetch_classification			= "SELECT localclassification_id,position FROM banner WHERE banner_id={$banner_id}";
		$classification_result			= $this->MyDB->query($fetch_classification);
		$localclassification_id			= $classification_result[0]['localclassification_id'];
		$fetch_position					= "SELECT position FROM banner WHERE localclassification_id={$localclassification_id}";
		$position_result				= $this->MyDB->query($fetch_position);
		
		
		foreach($position_result as $res){
			unset($position[$res["position"]]);
		}
		$getArray=array($classification_result[0]['position']=>$classification_result[0]['position']);
		$finalArray = array_merge($position, $getArray);
		//pre($finalArray);
		
		return $finalArray;
	}	
	
	public function getOnlineBannerReport($from_date, $to_date, $markets, $classifications){
			  
      $dates             = $this->datesArray($from_date, $to_date);		  		  	  
      $positions         = array('A', 'B', 'C');					  	  
	  $results           = array();
	  $positionResults   = array();	  
	    
	  foreach($dates as $i => $date){
	      $sql = "SELECT position
	              FROM banner
			     WHERE market_id = " . $markets .
			      " AND localclassification_id = " . $classifications .
				  " AND '" . $date . "' between DATE(add_date) AND DATE(expiry_date)
				  ORDER BY position"; 
				            				 
          $pos = $this->MyDB->query($sql);				  					  		  		 
		  		  		  
          array_push($results, array('date' => "$date",  "positions" => $pos));				  		  		  		  
		  
	  }
	  
	  $table = '';
	  foreach($results as $result){
		$table .= "<tr><td>".$result['date']."</td>";	  
        foreach($result as $i => $values){		
		  if(is_array($values)){
            foreach($values as $value){
  		      $table .= "<td>SOLD POSITION ".$value['position']."</td>";
		    }
          }
		}
	    $table .= "</tr>";
	  }
	  
	  //return $results;	  
	  return $table;
	}
	
	private function datesArray($from_date, $to_date){
      $dateIterator = new DateIterator('day', $from_date, $to_date);	
	  $dates = array();		  
	  
	  while ($dateIterator->valid()){
        array_push($dates, $dateIterator->current());
		$dateIterator->next();		  			
      }	  
	  
	  return $dates;
	
	}
	
    public function getDownloadBannerReport($from_date, $to_date){
      $sql = "select lb.account_id, lb.business_name, b.banner_title, m.market_name as Market_Name, lc.localclassification_code as Classification_Code, lc.localclassification_name as Classification_Name, b.position Position, b.add_date as Start_Date, b.expiry_date as End_Date
               from banner b, local_classification lc, markets m, local_businesses lb 
              where b.add_date <= '" . $to_date . "' 
	            AND b.expiry_date >= '" . $from_date . "'
	            AND lc.localclassification_id = b.localclassification_id
	            AND m.market_id = b.market_id
			    AND b.account_id = lb.account_id
	            AND b.business_id = lb.business_id				
	            AND b.account_id != ''";			
				
	  return $this->MyDB->query($sql);	  
    }	
	
	public function getMarketFromID($marketID){
	  $sql = "SELECT market_name
	            FROM markets
			   WHERE market_id = " . $marketID;			 
			   
	  return $this->MyDB->query($sql);	  			   
	}
	
	public function getClassificationFromID($classificationID){
	  $sql = "SELECT localclassification_name
	            FROM local_classification
			   WHERE localclassification_id = " . $classificationID;
			   
	  return $this->MyDB->query($sql);	  			   
	}	
	
    public function getAccountIDs(){
      $sql = "SELECT lb.business_id, lb.account_id, lb.business_name
                FROM local_businesses lb, (select distinct business_id from business_ranks) br
               WHERE lb.business_id = br.business_id
                 AND lb.account_id != ''
			   ORDER BY account_id";
	  
	  return $this->MyDB->query($sql);
    }	
	
	public function searchClassificationBannerDetail($get)
	{
		$classification 			= (!empty($get['classification']))?$get['classification']:NULL; 
		$title 						= (!empty($get['title']))?$get['title']:NULL;
		
		if($classification == '' && $title != '')
		{
			$table		= "banner b, local_classification lc, local_businesses lb, markets m";
			$condition	= "lb.business_name LIKE '%{$title}%' AND b.account_id = lb.account_id AND b.account_id != '' AND b.business_id = lb.business_id AND b.localclassification_id = lc.localclassification_id AND b.market_id = m.market_id";
		}elseif($classification != '' && $title == '')
		{
			$table		= "banner b, local_classification lc, local_businesses lb, markets m";
			$condition	= "b.localclassification_id = '{$classification}' AND  lc.localclassification_id='{$classification}' AND b.account_id = lb.account_id AND b.account_id != '' AND b.business_id = lb.business_id AND b.localclassification_id = lc.localclassification_id AND b.market_id = m.market_id";
			   
		}else
		{
			$table		= "banner b, local_classification lc, local_businesses lb, markets m";
			$condition	= "lb.business_name LIKE '%{$title}%' AND b.localclassification_id = '{$classification}' AND  lc.localclassification_id='{$classification}' AND b.account_id = lb.account_id AND b.account_id != '' AND b.business_id = lb.business_id AND b.localclassification_id = lc.localclassification_id AND b.market_id = m.market_id";
		}
		
//=============
		$fetch_classification_banner		= "SELECT * 
													FROM $table 
													WHERE $condition ";													

		$total_banner						= $this->MyDB->query($fetch_classification_banner);



		//$retArray['total_banner'] = $total_banner;
		//$retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		return $total_banner;
				
	}			
       
   

}
?>