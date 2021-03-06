<?php
class AdminListingFacade extends MainFacade {

	/**
	 *  __construct
	 *
	 *  Instantiate MyDB object
	 */
	private $shireIDs;
	private $classificationIDs;

	public function __construct(MyDB $MyDB, Request $request) {

		parent::__construct($MyDB, $request);
		$this->MyDB = $MyDB;
		$this->MyDB->table=TBL_LOCAL_BUSINESS;
		$this->MyDB->sequenceName=TBL_LOCAL_BUSINESS;
		$this->MyDB->primaryCol="business_id";
	}/* END __construct */


	public function export_class_relationships() {
		$start_time = time();
		$db_link = mysql_connect('localhost', 'pinkpages', 'waiz7ahW')
		or die('Could not connect: ' . mysql_error());
		//echo 'Connected successfully';
		mysql_select_db('ppo_dev') or die('Could not select database');
			
		$data_store = array();
		$final_master = array();


		$output = '';
		$tot_count = 0;
		$business_count = 0;
		// Performing SQL query
		$query1 = 'SELECT business_id,business_name FROM `local_businesses`';
		$result1 = mysql_query($query1) or die('Query 1 failed: ' . mysql_error());


		$output .= "ID,NAME,RELATED CLASS\n";


		while ($business_ids = mysql_fetch_array($result1, MYSQL_ASSOC)) {
			$business_id = $business_ids['business_id'];
			$business_name = $business_ids['business_name'];
			$query2 = "SELECT
					lc.localclassification_name,lc.localclassification_id
				FROM
					business_classification AS bc
					LEFT JOIN local_classification AS lc
						ON (bc.localclassification_id=lc.localclassification_id)
				WHERE
					bc.business_id=$business_id";

			$result2 = mysql_query($query2) or die('Query 2 failed: ' . mysql_error());
			$num_rows = mysql_num_rows($result2);
			if ($num_rows > 1) {
				$business_count++;
				//echo "$business_count Found: $business_id|$business_name  >> NUMROWS = $num_rows \n\n";
				//$output .= "\t<tr>\n";
				$output .= "$business_id,";
				$output .= "$business_name,";
				//$output .= "\t\t<td>";
				$i = 1;
				$class_list = array();
				$row = '';
				while ($classifications = mysql_fetch_array($result2, MYSQL_ASSOC)) {
					$name = $classifications['localclassification_name'];
					$id = $classifications['localclassification_id'];
					$row .= "$name|$id"; //$col_value;

					if ($i < $num_rows) { $row .= ', '; }
					$class_list["classid_$id"] = $name;

					$i++;
				}

				array_push($data_store,$class_list);
				$output .= "$row\n";

			}
			$tot_count++;

		}

		$query3 = 'SELECT * FROM `local_classification`';
		$result3 = mysql_query($query3) or die('Query 3 failed: ' . mysql_error());

		while ($unique_classification = mysql_fetch_array($result3, MYSQL_ASSOC)) {
			$localclassification_id = $unique_classification['localclassification_id'];
			$localclassification_name = $unique_classification['localclassification_name'];
			$sublist = array();
			$flag = array();
			foreach ($data_store as $c_group) {

				if (array_key_exists("classid_$localclassification_id", $c_group)) {
					foreach ($c_group as $key=>$value) {

						if ("classid_$localclassification_id" != $key && (!array_key_exists($key, $flag))) {
							array_push($sublist,"$key|$value");
							$flag[$key] = TRUE;
						}
					}
				}

			}

			$final_master["$localclassification_id|$localclassification_name"]=$sublist;
		}

		$final_master_string = '';

		foreach ($final_master as $id=>$value) {
			$final_master_string .= "$id,";
			$string = implode(', ',$value);
			$final_master_string .= "$string\n";
		}

		$final_output2 = $final_master_string;

		$end_time = time();
		$tot_time = $end_time-$start_time;
		$message = "Operation took $tot_time seconds";

		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"class_reationships.csv\"");

		echo $final_output2;
		exit;
	}


	public function addlist($post,$logo)
	{
		$logoname=$logo['logo']['name'];
		$res12 =$this->__userRegisterValidation($post);
		if(!$res12['result']){
			return $res12;
		}

		$this->MyDB->setWhere("business_email='".$post['email']."'");
		$result=$this->MyDB->getAll();
		if(count($result)>0)
		{
			$retArray = array("result"=>false, "message"=>'Username Already Exists!! please try some other name');
			return $retArray;
		}
			
		else{
			$sub=explode(';',$_POST['suburb']);
			$image=explode('\ ',$_POST['logo']);
			$sql2="SELECT
			            shiretown_id 
				   FROM 
				        shire_towns
				   WHERE
				        shiretown_postcode='".$post['postcode']."' 
						AND shiretown_townname='".$sub[1]."'";
			$rec=$this->MyDB->query($sql2);
			if($post['listing']==1)
			{
				$a=1;
			}
			else
			{
				$a=0;
			}
			$sql=array('business_initials'=>$post['initials'],
            'business_name'=>$post['name'],
            'business_street1'=>$post['street1'],
            'business_street2'=>$post['street2'],
            'business_suburb'=>$sub[1],
            'business_postcode'=>$post['postcode'],
            'business_phonestd'=>$post['phonestd'],
            'business_phone'=>$post['phone'],
            'business_faxstd'=>$post['faxstd'],
            'business_fax'=>$post['fax'],
            'business_email'=>$post['email'],
            'business_url'=>$post['url'],
            'business_origin'=>$post['origin'],
            'shiretown_id'=>$rec[0]['shiretown_id'],
            'business_mobile'=>$post['mobile'],
            'business_contact'=>$post['contact'],
            'bold_listing'=>$a,
            'client_id'=>getSession("client_id"),
            'business_logo'=>$logoname ,
            'business_description'=>$post['description'],
            'classification'=>$post['classification'],
            'business_state'=>$post['state'],
			'business_addDate'=>'');
			$this->MyDB->save($sql);
			$rec=array("result"=>true, "message"=>'');
			return $rec;
		}
	}


	public function selectStates()
	{
		$sql="SELECT
				  *
			FROM 
				  local_state";
		$res=$this->MyDB->query($sql);
		return $res;
	}

	private function __userRegisterValidation(&$data)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		if(empty($data['initials']))
		{
			$errors[] = "initials is blank!!";
		}
		if(empty($data['name']))
		{
			$errors[] = "name is blank!!";
		}
			
		if(empty($data['street1']))
		{
			$errors[] = "street1 is blank!!";
		}
		if(empty($data['street2']))
		{
			$errors[] = "street2 is blank!!";
		}
		if(empty($data['postcode']))
		{
			$errors[] = "postcode is blank!!";
		}

		if(empty($data['phone'])||!preg_match("/^[0-9]+$/",$data['phone']))
		{
			$errors[] = "phone is blank!!or not valid";
		}
		if(empty($data['phonestd'])||!preg_match("/^[0-9]+$/",$data['phonestd']))
		{
			$errors[] = "phonestd is blank!!or not valid";
		}
		if(empty($data['faxstd'])||!preg_match("/^[0-9]+$/",$data['faxstd']))
		{
			$errors[] = "faxstd is blank!!or not valid";
		}
		if(empty($data['fax'])||!preg_match("/^[0-9]+$/",$data['fax']))
		{
			$errors[] = "fax is blank!!or not valid";
		}
		if(!preg_match("/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/",$data['email'])||empty($data['email']))
		{
			$errors[] = "email is not valid!!";
		}
		if(empty($data['url']))
		{
			$errors[] = "url is blank!!";
		}
		if(empty($data['origin']))
		{
			$errors[] = "origin is blank!!";
		}
		if(empty($data['mobile'])||!preg_match("/^[0-9]+$/",$data['mobile']))
		{
			$errors[] = "mobile is blank!!or not valid";
		}
		if(empty($data['contact'])||!preg_match("/^[0-9]+$/",$data['contact']))
		{
			$errors[] = "contact is blank!!or not valid";
		}
		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}


	public function fetchTownDetails()
	{
		/*
		 $sql="select *
		 from shire_towns st, shire_names sn
		 where st.shirename_id = sn.shirename_id";
		 */

		$sql = "select st.shiretown_id, st.shirename_id, st.shiretown_townname, st.shiretown_postcode, sn.shirename_id,
                       sn.shirename_shirename, sn.shirename_state, sn.region_code, ls.localstate_name
                  from shire_towns st, shire_names sn, local_state ls
                 where st.shirename_id = sn.shirename_id	
                   and sn.shirename_state = ls.localstate_id";
			
		$rec=$this->MyDB->query($sql);
		return $rec;
	}

	public function viewfetchDetails($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$retArray = array();
		/*$this->MyDB->addWhere("client_id!=0");
		 $res=$this->MyDB->getAll($fr, $noOfRecords);*/
		$SQL="SELECT
		          * 
			  FROM 
			        local_businesses
			  WHERE expired=0
			        AND bold_listing=1
			  LIMIT $fr, $noOfRecords";
		$res= $this->MyDB->query($SQL);
		$SQL="SELECT
		          count(business_id) AS cnt 
			  FROM 
			      local_businesses
			  WHERE expired=0
                  AND bold_listing=1";

		$count_all = $this->MyDB->query($SQL);
		$retArray['listings'] = $res;
		$retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		return $retArray;
	}

	public function fetchClassificationDetails()
	{
		$sql="SELECT
		             *
			  FROM
			         local_classification";
		$rec=$this->MyDB->query($sql);
		return $rec;
	}

	public function fetchDetails($post)
	{
		$this->MyDB->addWhere("client_id!=0");
		$res=$this->MyDB->getAll();
		return $res;
	}

	public function addClassificationDetail($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;

		foreach($post['addclassification'] as $value)
		{

			$add_classification = "INSERT INTO `business_classification` (`businessclassification_id`, `business_id`, `localclassification_id`) VALUES ('', '{$BusinessID}', '{$value}')";

			$result  =$this->MyDB->query($add_classification);

		}
		$addClass=array("result"=>true, "message"=>'Classification Added Successfully',"ID"=>$BusinessID);
		return $addClass;
	}


	public function classificationList($get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;

		$list_classification	="SELECT business_classification.localclassification_id, local_classification.localclassification_name FROM business_classification,local_classification WHERE business_id='".$BusinessID."' AND business_classification.localclassification_id=local_classification.localclassification_id";
		$result					=$this->MyDB->query($list_classification);
		return $result;
	}

	public function deleteClassification($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;

		foreach($post['deleteClass'] as $value)
		{

			$del_classification = "DELETE FROM `business_classification` WHERE `business_id` ='".$BusinessID."' AND `localclassification_id` = '".$value."'";

			$result  =$this->MyDB->query($del_classification);

		}
		$delClass=array("result"=>true, "message"=>'Classification Added Successfully',"ID"=>$BusinessID);
		return $delClass;
	}

	public function addRank($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$list_classification	="SELECT business_classification.localclassification_id, local_classification.localclassification_name FROM business_classification,local_classification WHERE business_id='".$BusinessID."' AND business_classification.localclassification_id=local_classification.localclassification_id";
		$result_class					=$this->MyDB->query($list_classification);

		$list_region="SELECT * FROM shire_names";
		$result_region=$this->MyDB->query($list_region);
			
		//$deleteQuery	="DELETE FROM business_ranks WHERE `business_id` ='{$BusinessID}'";
		//$this->MyDB->query($deleteQuery);

		foreach($result_region as $valRegion)
		{
			foreach($result_class as $valClass)
			{

				$key = $valRegion['shirename_id']."_".$valClass['localclassification_id'];
					



					
					
				if(isset($post[$key]) && !empty($post[$key]))
				{
					$rank = $post[$key];

					/*	$rankDetails		="SELECT * FROM `business_ranks` WHERE `businessrank_rank`='{$rank}' AND  	`localclassification_id` ='{$valClass['localclassification_id']}' AND `shirename_id` = '{$valRegion['shirename_id']}'";
					 $rankDetails_result		=$this->MyDB->query($rankDetails);
					 var_dump($rankDetails_result);*/

					/* $rankQuery      ="INSERT INTO `business_ranks` (
					 `businessrank_id` ,
					 `business_id` ,
					 `localclassification_id` ,
					 `businessrank_rank` ,
					 `businessrank_email` ,
					 `businessrank_url` ,
					 `shirename_id` ,
					 `businessrank_cost` ,
					 `businessrank_timestamp` ,
					 `businessrank_expire` ,
					 `user_id` ,
					 `businessrank_tempfield`
					 )
					 VALUES (
					 '' , '{$BusinessID}', '{$valClass['localclassification_id']}', '{$rank}', '', '', '{$valRegion['shirename_id']}', '', '' , '' , ".getSession("userid").", ''
					 )";
					 $result_rank		=$this->MyDB->query($rankQuery);*/

					$tempArray[]		=array('classification'=>$valClass['localclassification_id'],'rank'=>$rank,'region'=>$valRegion['shirename_id']);

				}
			}

		}

		foreach($tempArray as $value)
		{
			$rankDetails		="SELECT * FROM `business_ranks` WHERE `businessrank_rank`='{$value['rank']}' AND  	`localclassification_id` ='{$value['classification']}' AND `shirename_id` = '{$value['region']}'";
			$rankDetails_result	=$this->MyDB->query($rankDetails);
			//var_dump(count($rankDetails_result));

			if(count($rankDetails_result) > 0)
			{
					
				$retArray = array("result"=>false, "message"=>'This Rank is not available under this classification and region.');
				return $retArray;
					
			}break;
		}

		$deleteQuery	="DELETE FROM business_ranks WHERE `business_id` ='{$BusinessID}'";
		$this->MyDB->query($deleteQuery);

		foreach($tempArray as $value)
		{
			$rankQuery      ="INSERT INTO `business_ranks` (
										`businessrank_id` ,
										`business_id` ,
										`localclassification_id` ,
										`businessrank_rank` ,
										`businessrank_email` ,
										`businessrank_url` ,
										`shirename_id` ,
										`businessrank_cost` ,
										`businessrank_timestamp` ,
										`businessrank_expire` ,
										`user_id` ,
										`businessrank_tempfield`
										)
										VALUES (
										'' , '{$BusinessID}', '{$value['classification']}', '{$value['rank']}', '', '', '{$value['region']}', '', '' , '' , ".getSession("userid").", ''
										)";
			$result_rank		=$this->MyDB->query($rankQuery);

		}



		$addRank=array("result"=>true, "message"=>'rank Added Successfully',"ID"=>$BusinessID);
		return $addRank;
	}

	public function rankDetails($get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$rank_query		="SELECT * FROM business_ranks WHERE business_id={$BusinessID}";
		$rank_list		=$this->MyDB->query($rank_query);
		return $rank_list;
	}


	public function editListingFetchDetails()
	{
		$rec=$this->fetchTownDetails();
		$condition = $_GET['ID'];
		$res = $this->MyDB->get($condition);
		return $res;
	}


	public function editListing($post,$file)
	{
		$image=$file['logo']['name'];//prexit($image);
		$shire=explode(',',$_POST['region']);
		$sub=explode(',',$post['suburb']);

		$result =$this->__userlistingValidation($post);
		if(!$result['result'])
		{
			return $result;
		}
		$SQL2="SELECT
		             shiretown_id
			   FROM
			         shire_towns
			   WHERE
			         shiretown_postcode='".$post['postcode']."'
					 AND
					   shiretown_townname='".$sub[1]."'";
		$rec=$this->MyDB->query($SQL2);
		if(@$post['listing']==1)
		{
			$a=1;
		}
		else
		{
			$a=0;
		}

		$ID			=$_GET['ID'];
		$condition  =$ID;
		$desc=$post['description'];//prexit($desc);
		if($image==''&& $desc=='')
		{
			$SQL="UPDATE
		              local_businesses
			    SET
						business_initials='{$post['initials']}',
						business_name='{$post['name']}',
						business_street1='{$post['street1']}',
						business_street2='{$post['street2']}',
						business_suburb='{$sub[1]}',
						business_postcode='{$post['postcode']}',
						business_phonestd='{$post['phonestd']}',
						business_phone='{$post['phone']}',
						business_faxstd='{$post['faxstd']}',
						business_fax='{$post['fax']}',
						business_email='{$post['email']}',
						business_url='{$post['url']}',
						business_origin='{$post['origin']}',
						shiretown_id='{$rec[0]['shiretown_id']}',
						business_mobile='{$post['mobile']}',
						business_contact='{$post['contact']}',
						shire_name='{$shire[1]}',
						shire_town='{$sub[1]}',
						classification='{$post['classification']}',
						business_state='{$post['state']}' WHERE business_id=$condition";

		}elseif($image!=''&& $desc!=''){
			$SQL="UPDATE
				            local_businesses 
					 SET
					    business_initials='{$post['initials']}',
						business_name='{$post['name']}',
						business_street1='{$post['street1']}',
						business_street2='{$post['street2']}',
						business_suburb='{$sub[1]}',
						business_postcode='{$post['postcode']}',
						business_phonestd='{$post['phonestd']}',
						business_phone='{$post['phone']}',
						business_faxstd='{$post['faxstd']}',
						business_fax='{$post['fax']}',
						business_email='{$post['email']}',
						business_url='{$post['url']}',
						business_origin='{$post['origin']}',
						shiretown_id='{$rec[0]['shiretown_id']}',
						business_mobile='{$post['mobile']}',
						business_contact='{$post['contact']}',
						shire_name='{$shire[1]}',
						shire_town='{$sub[1]}',
						business_logo='{$image}',
						business_description='{$post['description']}',
						classification='{$post['classification']}',
						business_state='{$post['state']}' WHERE business_id=$condition";

		}
		elseif($image==''&& $desc!=''){
			$SQL="UPDATE
				            local_businesses 
					 SET
					    business_initials='{$post['initials']}',
						business_name='{$post['name']}',
						business_street1='{$post['street1']}',
						business_street2='{$post['street2']}',
						business_suburb='{$sub[1]}',
						business_postcode='{$post['postcode']}',
						business_phonestd='{$post['phonestd']}',
						business_phone='{$post['phone']}',
						business_faxstd='{$post['faxstd']}',
						business_fax='{$post['fax']}',
						business_email='{$post['email']}',
						business_url='{$post['url']}',
						business_origin='{$post['origin']}',
						shiretown_id='{$rec[0]['shiretown_id']}',
						business_mobile='{$post['mobile']}',
						business_contact='{$post['contact']}',
						business_description='{$post['description']}',
						shire_name='{$shire[1]}',
						shire_town='{$sub[1]}',
						classification='{$post['classification']}',
						business_state='{$post['state']}' WHERE business_id=$condition";

		}
		elseif($image!=''&& $desc==''){
			$SQL="UPDATE
				            local_businesses 
					 SET
					    business_initials='{$post['initials']}',
						business_name='{$post['name']}',
						business_street1='{$post['street1']}',
						business_street2='{$post['street2']}',
						business_suburb='{$sub[1]}',
						business_postcode='{$post['postcode']}',
						business_phonestd='{$post['phonestd']}',
						business_phone='{$post['phone']}',
						business_faxstd='{$post['faxstd']}',
						business_fax='{$post['fax']}',
						business_email='{$post['email']}',
						business_url='{$post['url']}',
						business_origin='{$post['origin']}',
						shiretown_id='{$rec[0]['shiretown_id']}',
						business_mobile='{$post['mobile']}',
						business_contact='{$post['contact']}',
						business_logo='{$image}',
						shire_name='{$shire[1]}',
						shire_town='{$sub[1]}',
						classification='{$post['classification']}',
						business_state='{$post['state']}' WHERE business_id=$condition";

		}
		$this->MyDB->query($SQL);
		$result = array("result"=>true, "message"=>'Update Successfully');
		return $result;


		/*$sub=explode(';',$_POST['suburb']);
		 @$image=explode('\ ',@$_POST['logo']);
		 $sql2="SELECT
		 shiretown_id
		 FROM
		 shire_towns
		 WHERE
		 shiretown_postcode='".$post['postcode']."'
		 AND shiretown_townname='".$sub[1]."'";
		 $rec=$this->MyDB->query($sql2);
			if(@$post['listing']==1)
			{
			$a=1;
			}
			else
			{
			$a=0;
			}
			$ID			=$_GET['ID'];
			$condition     =$ID;
			$img=@$_POST['logo']; $desc=$post['description'];
			if($img==''||$desc=='')
			{
			$sql=array('business_initials'=>$post['initials'],
			'business_name'=>$post['name'],
			'business_street1'=>$post['street1'],
			'business_street2'=>$post['street2'],
			'business_suburb'=>$sub[1],
			'business_postcode'=>$post['postcode'],
			'business_phonestd'=>$post['phonestd'],
			'business_phone'=>$post['phone'],
			'business_faxstd'=>$post['faxstd'],
			'business_fax'=>$post['fax'],
			'business_email'=>$post['email'],
			'business_url'=>$post['url'],
			'business_origin'=>$post['origin'],
			'shiretown_id'=>$rec[0]['shiretown_id'],
			'business_mobile'=>$post['mobile'],
			'business_contact'=>$post['contact'],
			'bold_listing'=>$a,
			'classification'=>$post['classification'],
			'business_state'=>$post['state']);
			}
			else
			{
			$sql=array('business_initials'=>$post['initials'],
			'business_name'=>$post['name'],
			'business_street1'=>$post['street1'],
			'business_street2'=>$post['street2'],
			'business_suburb'=>$sub[1],
			'business_postcode'=>$post['postcode'],
			'business_phonestd'=>$post['phonestd'],
			'business_phone'=>$post['phone'],
			'business_faxstd'=>$post['faxstd'],
			'business_fax'=>$post['fax'],
			'business_email'=>$post['email'],
			'business_url'=>$post['url'],
			'business_origin'=>$post['origin'],
			'shiretown_id'=>$rec[0]['shiretown_id'],
			'business_mobile'=>$post['mobile'],
			'business_contact'=>$post['contact'],
			'bold_listing'=>$a,
			'business_logo'=>$image[0] ,
			'business_description'=>$post['description'],
			'classification'=>$post['classification'],
			'business_state'=>$post['state']);
			}
			$this->MyDB->setWhere("business_id=$condition") ;
			$this->MyDB->update($sql);
			$Array = array("result"=>true, "message"=>'Updated Successfully');
			return $Array;
			*/
	}


	private function __userlistingValidation(&$data)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		if($data['classification']=='--Select One--')
		{
			$errors[] = "Please Select any Classification!!";
		}
		if(empty($data['initials']))
		{
			$errors[] = "initials is blank!!";
		}
		if(empty($data['name']))
		{
			$errors[] = "name is blank!!";
		}
		if(empty($data['street1']))
		{
			$errors[] = "street1 is blank!!";
		}
		if(empty($data['street2']))
		{
			$errors[] = "street2 is blank!!";
		}
		if($data['region']=='--Select One--')
		{
			$errors[] = "Please Select any Region!!";
		}
		if(@$data['suburb']=='--Select One--')
		{
			$errors[] = "Please Select any Suburb!!";
		}
		if(empty($data['postcode']))
		{
			$errors[] = "postcode is blank!!";
		}
		/*if(!preg_match("/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/",$data['email'])||empty($data['email']))
		 {
		 $errors[] = "email is not valid!!";
		 }*/
		if(empty($data['description']))
		{
			$errors[] = "description is blank!!";
		}

		if(empty($data['contact']))
		{
			$errors[] = "contact is blank!!";
		}
		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}
	public function delList()
	{
		$ID			=$_GET['ID'];
		$condition  =$ID;
		$this->MyDB->remove($condition);
		$Array = array("result"=>true, "message"=>'Deleted Successfully');
		return $Array;
	}

	function viewlog($File)
	{
		//set_time_limit(1000);
		$fp = gzopen($File,"r");
		dev_log::write("gzopen -File $File has been opened.");
		while($var=fgetcsv($fp)){
			$values[]=$var;
			/*
		  if(trim($var[1]) && trim($var[5]) && trim($var[7])){
		  //print("ROW INSERTED");
		  $values[]=$var;
		  }
		  */

		}
		gzclose($fp);
        dev_log::write("gzopen -File $File has been closed.");
		return $values;
	}

	//Place these functions into their own classes
	private function gz_parse($file, $path){
		$fp = gzopen("$path$file", "rb") or die("Cannot open file");
		set_time_limit(0);
		// iterate through file
		// retrieve and print each field
		while (!feof($fp)) {
			$line = fgetcsv($fp, 0, ',', '"');
			/*print("<br />");
			 print_r($line);
			 print("<br />");*/
		}
		// close file
		gzclose($fp) or die("Cannot close file");

	}

	private function gz_read($file, $path) {
		//print("<br /> <strong>outPUT Start</strong><br />");
		$rows = gzfile("$path/$file");
		/*
		 foreach($rows as $row) {
		 echo "<br />$row<br />";
		 }
		 */
		dev_log::write("gz_read -File $path/$file has ". count($rows) . " rows that have been read into an Array");
		return $rows;
	}

	public function sys_get_temp_dir()
	{
		// Try to get from environment variable
		if (function_exists("sys_get_temp_dir"))
		{
			return sys_get_temp_dir();
		}
		else if ( !empty($_ENV['TMP']) )
		{
			return realpath( $_ENV['TMP'].'/' );
		}
		else if ( !empty($_ENV['TMPDIR']) )
		{
			return realpath( $_ENV['TMPDIR'].'/' );
		}
		else if ( !empty($_ENV['TEMP']) )
		{
			return realpath( $_ENV['TEMP'].'/' );
		}

		// Detect by creating a temporary file
		else
		{
			// Try to use system's temporary directory
			// as random name shouldn't exist
			$temp_file = tempnam( md5(uniqid(rand(), TRUE)), '' );
			if ( $temp_file )
			{
				$temp_dir = realpath( dirname($temp_file) );
				unlink( $temp_file );
				return $temp_dir.'/';
			}
			else
			{
				return FALSE;
			}
		}
	}

	private function setini() {
		//Modify php ini vars to cater for large uploads
		ini_set('upload_max_filesize', '10M');
		//Increase execution time to 2 minutes
		ini_set('max_execution_time' , '200000');
		//Maximum time to allow parsing
		ini_set('max_input_time', '180');
		//Increase the size of possible post requests. Should be >= upload_max_filesize
		ini_set('post_max_size', '10M');
		//Increase the amount of Memory at PHPs disposal
		ini_set('memory_limit', '512M');
	}



	public function csvFileUpload($file)
	{
		dev_log::timer('set');
		//dev_log::write("csvFileUpload = ".$uploadDir . $file);
		try {
			//print("Debug inside csvFileUpload<br />");
			//print_r($_FILES);
			$this->setini();
			//$check = move_uploaded_file($_FILES['csvfile']['tmp_name'],$_FILES['csvfile']['name']);
			$res1 =$this->__Validation($file);
			if(!$res1['result'])
			{
				//print("<br /><strong>No File Uploaded</strong><br />"	   );
				return $res1;
			}
			else
			{
				$tmp       = $_FILES['csvfile']['tmp_name'];
				$uploadDir = $this->sys_get_temp_dir();
				$file      = $_FILES['csvfile']['name'];
				setSession("file",$uploadDir.'/'.$file);
				$values = array();
				dev_log::write("Attempting csvFileUpload : ".$uploadDir .'/'. $file);
					
				//die("Attempting to upload file $tmp to $uploadDir/$file");
				if (move_uploaded_file($tmp, $uploadDir .'/'. $file) or die("Cannot copy uploaded file [$uploadDir/$file]")) {
					// display success message
					//die()
					//die( "File successfully uploaded to " . $uploadDir .'/'. $file . " [{$_FILES['data']['name']}]");
					echo "File successfully uploaded to " . $uploadDir .'/'. $file;
					echo "<br />Now attempt to extract file to " .$uploadDir .'/'. $file ." <br />";
					//$values = $this->gz_read($file, $uploadDir);
			        //$report[] = count($values);
				}
				
				//dev_log::timer('get');
				//dev_log::write("csvFileUpload = ".$uploadDir . $file);
				
				//$viewlog = $this->viewlog($uploadDir .'/'. $file);
				//$report[] = count($viewlog);
				$report = $this->insertCSV("$uploadDir/$file"); //$viewlog

				return $report;
			}
		} catch (Exception $e) {
			echo 'PHP Exception: ' . $e->getMessage();
		}
	}

	/* class_relationships_upload -- added by Hereward Fenton 21 march 2012 */
	public function class_relationships_upload($file)
	{
		$query_1 = "TRUNCATE `class_relationships`";
		//dev_log::write("class_relationships_upload - $query");
		$rows = $this->MyDB->query($query_1);
		try {
			//print("Debug inside csvFileUpload<br />");
			//print_r($_FILES);
			$this->setini();
			//$check = move_uploaded_file($_FILES['csvfile']['tmp_name'],$_FILES['csvfile']['name']);
			$res1 =$this->__Validation($file);

			//dev_log::write("class_relationships_upload - init");

			$output = '';
			if(!$res1['result'])
			{
				//print("<br /><strong>No File Uploaded</strong><br />"	   );
				return $res1;
			}
			else
			{
				//dev_log::write("class_relationships_upload - init");
				$tmp       = $_FILES['csvfile']['tmp_name'];
				$uploadDir = $this->sys_get_temp_dir();
				$file      = $_FILES['csvfile']['name'];
				setSession("file",$uploadDir.$file);
					
				//print("<br />Attempting to upload file $tmp to $uploadDir$file <br />");
				if(move_uploaded_file($tmp, $uploadDir . $file) or die("Cannot copy uploaded file")){
					// display success message
					echo "File successfully uploaded to " . $uploadDir . $file;
					echo "<br />Now attempt to extract file to " .$uploadDir . $file ." <br />";

					$row = 1;
					if (($handle = fopen("$uploadDir$file", "r")) !== FALSE) {
						while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
							$num = count($data);
							//dev_log::write("class_relationships_upload ZZ -  ".var_export($data, true));
							//echo "<p> $num fields in line $row: <br /></p>\n";
							//dev_log::write("class_relationships_upload DATA[0] -  ".$data[0]);
							$row++;
							if ($row > 10000) { break;}

							$arr = explode('|', $data[0]);

							$class_id = $arr[0];
							//dev_log::write("class_relationships_upload -  ARR[0] = ".var_export($arr[0], true));
							$related = '';
							if ($num >0 && (is_numeric($class_id))) {
								for ($i=1; $i <= $num-1; $i++) {
									if ($data[$i]) {
										if ($i > 1) {
											$related .= ',';
										}
										$arr = explode('|', $data[$i]);
										$raw = $arr[0];
										$arr2 = explode('_', $raw);
										$count_arr2 = count($arr2);
										
									    if (count($arr2)>1) {
									    	$related .= $arr2[1];
									    } else {
									    	$related .= $arr2[0];
									    }

									}
								}
							}
							if ($related) {
								$related = trim($related,',');
								$related = mysql_real_escape_string($related);
								
								$query_2 = "INSERT INTO `class_relationships` (`class_id` ,`related`) VALUES ($class_id, '$related')";
								//dev_log::write("class_relationships_upload - $query");
								$rows = $this->MyDB->query($query_2);
							}
							
						}
						fclose($handle);
					}


					//$values = $this->gz_read($file, $uploadDir);
					//$report[] = count($values);
				} else {
					echo "File was <strong>NOT</strong> successfully uploaded to " . $uploadDir . $_FILES['data']['name'];
				}
				//$viewlog = $this->viewlog($uploadDir . $file);
				//$report[] = count($viewlog);
				//$report[] = $this->insert_class_relationships($viewlog);

				//return $report;
			}
		} catch (Exception $e) {
			echo 'PHP Exception: ' . $e->getMessage();
		}
	}
	
	/*
	public function alias_fix($state='') {
		//die('hello');
		set_time_limit(200000);
		if (!$state) {
			$state = 'ACT';
		}
		
		$output = array();
		$q1 = "SELECT business_id, business_name, business_suburb, url_alias FROM `local_businesses` WHERE business_state =  'ACT'";
		$rows = $this->MyDB->query($q1) or die('Query 1 failed: ' . mysql_error());
		
		//var_dump($res1);
		//die();
		$i = 0;
		foreach ($rows as $row) {
			$str = "{$row['business_name']} {$row['business_suburb']} {$row['business_id']}";
			$str = strtolower($str);
			//$str = preg_replace('/&/', '', $str);
			//$str = preg_replace('/\s+/', '-', $str);
			//$str = preg_replace('/[^a-z0-9\-]+/', '', $str);
			$str = preg_replace('/[^a-z0-9]+/', '-', $str);
			$str = trim($str, '-');
			
			
			$q2 = "UPDATE `local_businesses` SET url_alias = '$str' WHERE business_id = '{$row['business_id']}'";
		    $rows2 = $this->MyDB->query($q1) or die('Query 1 failed: ' . mysql_error());
			$output[] = array('query'=> $q2, "business_id" => $row['business_id'], "name" => $row['business_name'], 'alias' => $str);
			$i++;
			if ($i>500) {
				break;
			}
			
		}
		
		//var_dump($output);
		$count = count($output);
		die("ALIAS FIX: OPERATION COMPLETED NORMALLY. Update Count = [$count]");

		
	}
	*/
	
	
	
	
/* url_alias_upload -- added by Hereward Fenton 21 march 2012 */
	public function url_alias_upload($file)
	{
		//$query_1 = "TRUNCATE `url_alias`";

		//$rows = $this->MyDB->query($query_1);
		try {
			//print("Debug inside csvFileUpload<br />");
			//print_r($_FILES);
			$this->setini();
			//$check = move_uploaded_file($_FILES['csvfile']['tmp_name'],$_FILES['csvfile']['name']);
			$res1 =$this->__Validation($file);

			

			$output = '';
			if(!$res1['result'])
			{
				//print("<br /><strong>No File Uploaded</strong><br />"	   );
				return $res1;
			}
			else
			{
	
				$tmp       = $_FILES['csvfile']['tmp_name'];
				$uploadDir = $this->sys_get_temp_dir();
				$file      = $_FILES['csvfile']['name'];
				setSession("file",$uploadDir.$file);
					
				//print("<br />Attempting to upload file $tmp to $uploadDir$file <br />");
				if(move_uploaded_file($tmp, $uploadDir . $file) or die("Cannot copy uploaded file")){
					// display success message
					echo "File successfully uploaded to " . $uploadDir . $file;
					echo "<br />Now attempt to extract file to " .$uploadDir . $file ." <br />";
                    //$values = $this->gz_read($file, $uploadDir);
                    //$viewlog = $this->viewlog($uploadDir . $file);
				    //$report[] = count($viewlog);
				    //$report[] = $this->insertCSV($viewlog);
				
					$row = 1;
					if (($handle = fopen("$uploadDir$file", "r")) !== FALSE) {
						while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
							if ($row==1) {
								 dev_log::timer('get');
								 dev_log::write("BEGIN extraction");
							}
							$num = count($data);
							//dev_log::write("url_alias_upload  -  ".var_export($data, true));
							//echo "<p> $num fields in line $row: <br /></p>\n";
							//dev_log::write("url_alias_upload DATA[0] -  ".$data[0]);
							$row++;
							//if ($row > 1000) { break;}

							

							$business_id = $data[0];
							//dev_log::write("url_alias_upload -  ARR[0] = ".var_export($arr[0], true));
							
							$raw_alias = $data[1];
							
							$cleaned_alias = str_replace("*", '', $raw_alias);
							$cleaned_alias = str_replace("?", '', $cleaned_alias);
							$cleaned_alias = trim($cleaned_alias);
							$cleaned_alias = mysql_real_escape_string($cleaned_alias);

							$query = "UPDATE local_businesses SET url_alias = '$cleaned_alias' WHERE business_id = $business_id";
                            
							dev_log::write("ROW = $row | QUERY = $query");
							$rows = $this->MyDB->query($query);
						
							
						}
						fclose($handle);
					}
                    dev_log::timer('get');
                    dev_log::write("END extraction (ROW = $row)");

					//$values = $this->gz_read($file, $uploadDir);
					//$report[] = count($values);
				} else {
					echo "File was <strong>NOT</strong> successfully uploaded to " . $uploadDir . $_FILES['data']['name'];
				}
				//$viewlog = $this->viewlog($uploadDir . $file);
				//$report[] = count($viewlog);
				//$report[] = $this->insert_url_alias($viewlog);

				//return $report;
			}
		} catch (Exception $e) {
			echo 'PHP Exception: ' . $e->getMessage();
		}
	}




	public function insertCSV($csv_file_path)
	{

        dev_log::write("-----------------------------");
        dev_log::write("Insert new listings - BEGIN");
        //die("FORCED TERMINATION");
        //dev_log::timer('get');
        $classiIDs = array();
        
        $this->shireIDs    = $this->fetchTownDetails();
		$this->classificationIDs = $this->fetchClassificationDetails();
        
		set_time_limit(200000);
		
		$success = 0;
		$failure = 0;
		//Remove Existing Entries
		//$this->deleteExistingFreeListings();
		$class_id = '2677';
		$state = '';
		$shireDetails = '';
		$shireID      = '';
		$shireName    = '';
		
		
		//dev_log::write("Identifying Classifications and State from CSV data");
		//$i = 1;
		
		$business_listing_insert_total = 0;
		/*
		foreach($post as $row){
			if((isset($row[8])) || (isset($row[9])) || (isset($row[10])) || (isset($row[11])) || (isset($row[12]))){
				$classiIDs = array_merge($classiIDs,$this->getClassificationIDs(array($row[8], $row[9], $row[10], $row[11], $row[12])));
			}
			
			$classiIDs = array_unique($classiIDs);
		    if((!$state) && (isset($row[5]))){
				$shireDetails = $this->getShireID($row[4], $row[5]);
				$state        = $shireDetails['shireState'];
				
			}
			
			$i++;
			
			if ($i > 20000) {
				break;
			}
			
		}
		*/
		
		//$class_id_str = implode(',', $classiIDs);
		//$state = 'NSW';
		
		//dev_log::write("Deleting OLD free listings");
		dev_log::timer('get');
		//dev_log::write("STATE = $state | CLASSIFICATIONS = $class_id_str");
		//print("<br />STATE = $state | CLASSIFICATIONS = $class_id_str<br />");
		//die();
		//$this->deleteFreeListingsClassification($class_id_str,$state); // Removed on 25 May 2012 - Hereward
		//$this->purge_regions_victoria();
		
        $failed_sqls = array();

		//Get all the ShireIDs
		

		//Uncomment references to these file if you want the SQL to be output to files also
		//$fp1     = fopen('local_business_queries.sql', "ab+") or die ("Cannot open file");
		//$fp2     = fopen('classification_queries.sql', "ab+") or die ("Cannot open file");
        
        $total_lines = '?'; //count($post);
        $handle = gzopen($csv_file_path, 'r');
		dev_log::write("Inserting NEW free listings");
		dev_log::timer('get');
		
		
		$current_line = 0;
		//foreach($post as $row) {
		 while (($row = fgetcsv($handle, 10000, ",")) !== FALSE) {
			// $row = gzgets($handle, 10000);
		  //print_r($row);
		  //die();
		
		
			//Find ShireID
			if($row[5]){

				$shireDetails = $this->getShireID($row[4], $row[5]);
				$shireID      = $shireDetails['shireID'];
				$shireName    = $shireDetails['shireRegion'];
				$state        = $shireDetails['shireState'];
			}

			//Some default values for free listings;
			$boldListing                   = 0;
			$archived                      = 0;
			$faxSTD                        = '';
			$fax                           = '';
			$email                         = '';
			$url                           = '';
			$origin                        = '';
			$shireTown                     = '';
			$mobile                        = '';
			$contact                       = '';
			$bold                          = '';
			$accountID                     = '';
			$logo                          = '';
			$description                   = '';
			$name                          = mysql_real_escape_string($row[1]);
			$street1                       = mysql_real_escape_string($row[2]);
			$street2                       = mysql_real_escape_string($row[3]);
			$suburb                        = mysql_real_escape_string($row[4]);
			$url_alias                     = mysql_real_escape_string($row[13]);
			
			$business_id = $row[0];
			
			dev_log::write("processing line $current_line | name=[$name]");
			//die("FORCED TERMINATION");

			$sql="INSERT INTO `local_businesses` (
			                `business_id` ,
							`business_initials` ,
							`business_name` ,
							`business_street1` ,
							`business_street2` ,
							`street1_status`,
							`street2_status`,
							`business_suburb` ,
							`business_state` ,
							`business_postcode` ,
							`business_phonestd` ,
							`business_phone` ,
							`business_faxstd` ,
							`business_fax` ,
							`business_email` ,
							`business_url` ,
							`business_origin` ,
                            `shiretown_id`,							
							`shire_name` ,
							`shire_town` ,
							`business_mobile` ,
							`business_contact` ,
							`bold_listing` ,
							`archived` ,
							`account_id` ,
							`business_logo` ,
							`business_description`
							)
							VALUES (
							'$business_id', 'Free', '{$name}', '{$street1}', '{$street2}', 0, 0, '{$suburb}', '{$state}', '{$row[5]}', '{$row[6]}', '{$row[7]}', '{$faxSTD}', '{$fax}', '{$email}', '{$url}', '{$origin}', '{$shireID}', '{$shireName}', '{$shireTown}', '{$mobile}', '{$contact}', {$boldListing}, {$archived}, '{$accountID}', '{$logo}', '{$description}');";						 

			//$res1	=   mysql_query($sql);

			//Find and assign all Classification Codes
		   

			if($row[8] || $row[9] || $row[10] || $row[11] || $row[12]){
				$classiIDs = $this->getClassificationIDs(array($row[8], $row[9], $row[10], $row[11], $row[12]));
				//$res2               = $this->insertClassificationID($classiIDs, $row[0]);
				
				//Only bother writing entry to file if there is at least one classification
				if(count($classiIDs)) {
					//Insert into local_businesses
					$res1	=   mysql_query($sql);
                    $last_insert_id = mysql_insert_id();
                    //dev_log::write("INSERT ID = $last_insert_id");
					if($res1){
						$business_listing_insert_total++;
						$success++;
						dev_log::write("Business Listing Insert Total = $business_listing_insert_total");
						if ($last_insert_id) {
							$url_alias .= "-$last_insert_id";
							$update_url_sql = "UPDATE local_businesses SET url_alias = '$url_alias' WHERE business_id = '$last_insert_id'";
							$res_update_url	=   mysql_query($update_url_sql);
							if (!$res_update_url) {
								$msg = "FAILED SQL: (UPDATE URL ALIAS) current line = [$current_line] ". mysql_error() ." SQL= [$update_url_sql]";
						        dev_log::write($msg);
						        die($msg);
							}
							
						}
						 //$row[0] = $last_insert_id;
					} else {
						//print("<br /> SQL Insert Error " . mysql_error());
						//print("<br /> $sql <br />");
						$failed_sqls[] = mysql_error() . "      " . $sql;
						$failure++;
						$msg = "FAILED SQL: (MAIN INSERT) current line = [$current_line] ". mysql_error() ." SQL= [$sql]";
						dev_log::write($msg);
						die($msg);
					}

					//Insert into business_classification
					$sql2   = $this->insertClassificationID($classiIDs, $last_insert_id);
					$res2   =   mysql_query($sql2);

					//fwrite($fp1, $sql) or die("Cannot write first query to file");
					//fwrite($fp2, $sql2) or die("Cannot write second query to file");
					if($res2){
						$success++;
					} else {
						//print("<br /> SQL Insert Error " . mysql_error());
						//print("<br /> $sql <br />");
						
						$failed_sqls[] = mysql_error() . "      " . $sql2;
						$failure++;
						$msg = "FAILED SQL: (INSERT CLASS ID) current line = [$current_line] ". mysql_error() ." SQL= [$sql2]";
						dev_log::write($msg); 
						die($msg);
						
					}

				}
			}


			$Array = array("result"=>true,"message"=>"Business inserted successfully");
			$current_line++;
			//if ($current_line > 1000) { die("FORCED TERMINATION");}
		}
		gzclose($handle);
		
		if($failure) {
		print("<br />$failure rows failed to be inserted into the database<br />");
        //dev_log::write("$failure rows failed to be inserted into the database");
		}
        
		if($success) {
		print("<br />$business_listing_insert_total listings were successfully inserted into the database<br />");
		 //dev_log::write("$success rows were successfully inserted into the database");
		}

		//fclose($fp1) or die ("Cannot close file");
		//fclose($fp2) or die ("Cannot close file");

		//return array('success'=>$success, 'failure'=>$failure);
		
		
		dev_log::write("Insert new listings - END");
		dev_log::timer('get');
		
		return 1; //array('success'=>$success, 'failure'=>$failure, 'failed_sqls'=>$failed_sqls);
	}

	private function __Validation(&$data)
	{
		//print("Debug inside __Validation");
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		if(empty($data['name']))
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

	private function getShireID($suburb, $postcode = ''){
		foreach($this->shireIDs as $shireID) {
			/*
			if(strtolower($shireID['shiretown_townname']) == strtolower(trim($suburb))){
				$shireDetails = array('shireID' => $shireID['shiretown_id'], 'shireRegion' => $shireID['shirename_shirename'], 'shireState' => $shireID['localstate_name']);
				return $shireDetails;
				break;
			}  else 
			*/
			if (trim($shireID['shiretown_postcode']) == trim($postcode)) {
				$shireDetails = array('shireID' => $shireID['shiretown_id'], 'shireRegion' => $shireID['shirename_shirename'], 'shireState' => $shireID['localstate_name']);
				return $shireDetails;
				break;
			}
		}
		return 0;
	}

	private function getClassificationIDs($codes){
		$ids = array();
		foreach($this->classificationIDs as $classificationCode) {
			foreach($codes as $code) {
				if($classificationCode['localclassification_code'] == trim($code)){
					array_push($ids, $classificationCode['localclassification_id']);
				}
			}
		}
		return $ids;
	}

	/*
	 private function insertClassificationID($classificationIDs, $businessID){
	 foreach($classificationIDs as $classificationID){
	 $sql1 = "INSERT INTO `business_classification` (`business_id`, `localclassification_id`) VALUES ('{$businessID}', '{$classificationID}')";
	 $result1  = $this->MyDB->query($sql1);
	 }
	 }
	 */

	private function insertClassificationID($classificationIDs, $businessID){
		$sql2 = '';
		foreach($classificationIDs as $classificationID){
			$sql2 .= "INSERT INTO `business_classification` (`business_id`, `localclassification_id`) VALUES ('{$businessID}', '{$classificationID}');";
			return $sql2;
			//$result1  = $this->MyDB->query($sql1);
		}
	}

	private function deleteExistingFreeListings(){
		print("Deleting Free Listings");
		//Delete all Entries from the FREE_BUSINESSES TABLE. DATABASE WILL ENFORCE REFERENTIAL INTEGRITY with FREEBUSINESS_CLASSIFICATION table
		$sql = "delete from local_businesses where business_initials = 'Free';";
		$result  = $this->MyDB->query($sql);
	}

	private function deleteClassRelationships(){
		print("Deleting Class Relationships");
		//Delete all Entries from the FREE_BUSINESSES TABLE. DATABASE WILL ENFORCE REFERENTIAL INTEGRITY with FREEBUSINESS_CLASSIFICATION table
		$sql = "delete from class_relationships";
		$result  = $this->MyDB->query($sql);
	}
	
	private function purge_regions_victoria() { 
		//print("Deleting Free Listings");
		//dev_log::write("Deleting Free Listings");
		$shirename_ids = '300,301,302,303,304,305,306,307,308,309,310,311,312,314,315';
		$sql_01 = "SELECT DISTINCT business_id from business_ranks WHERE shirename_id IN ($shirename_ids)";
		//dev_log::write($sql_01);
		$rows =$this->MyDB->query($sql_01);

		//$deleteQuery	="DELETE FROM business_ranks WHERE `business_id` ='{$BusinessID}'";
		//$this->MyDB->query($deleteQuery);
		$id_list = array();
		
		foreach($rows as $row) {
			$id = $row['business_id'];
			if (!in_array($id, $id_list)) {
				array_push($id_list, $id);
			}
		}

		$in_string = implode(',', $id_list);
		
		$kill_count = count($id_list);

		//Delete all Entries from the FREE_BUSINESSES TABLE. DATABASE WILL ENFORCE REFERENTIAL INTEGRITY with FREEBUSINESS_CLASSIFICATION table
		$sql_02 = "delete from local_businesses where business_initials = 'Free' AND business_id IN ($in_string)";
		
		//die("KILL LIST = $sql_02");
		//dev_log::write($sql_02);
		
		//die('deleteFreeListingsClassification');
		$result  = $this->MyDB->query($sql_02);
		//dev_log::write("KILL COUNT = $kill_count");
		
		
	}

	private function deleteFreeListingsClassification($class_ids, $state){
		//print("Deleting Free Listings");
		//dev_log::write("Deleting Free Listings");
		$sql_01 = "SELECT * from business_classification WHERE localclassification_id IN ($class_ids)";
		//dev_log::write($sql_01);
		$rows =$this->MyDB->query($sql_01);

		//$deleteQuery	="DELETE FROM business_ranks WHERE `business_id` ='{$BusinessID}'";
		//$this->MyDB->query($deleteQuery);
		$id_list = array();
		
		foreach($rows as $row) {
			$id = $row['business_id'];
			if (!in_array($id, $id_list)) {
				array_push($id_list, $id);
			}
		}

		$in_string = implode(',', $id_list);
		
		$kill_count = count($id_list);

		//Delete all Entries from the FREE_BUSINESSES TABLE. DATABASE WILL ENFORCE REFERENTIAL INTEGRITY with FREEBUSINESS_CLASSIFICATION table
		$sql_02 = "delete from local_businesses where business_initials = 'Free' AND business_id IN ($in_string) AND business_state='$state'";
		dev_log::write($sql_02);
		
		die('deleteFreeListingsClassification');
		$result  = $this->MyDB->query($sql_02);
		dev_log::write("KILL COUNT = $kill_count");
	}

	public function importCSV($post)
	{
		$success = 0;
		$failure = 0;
		//Remove Existing Entries
		$this->deleteExistingFreeListings();

		print("<br />ImportCSV Function. Importing ");
		print_r($_POST['total']);
		print(" rows<br />");
		//print_r($_POST['total']);
		//print_r($_POST);
		print("<br />");
		//print("Generating SQL <br />");
		//Get all the ShireIDs
		$shireIDs          = $this->fetchTownDetails();
		$classificationIDs = $this->fetchClassificationDetails();
		//print_r($classificationIDs);
		//print_r(array_values($shireIDs));
		//$shireIDFKs = array_intersect($_POST, $shireIDs);
		//print_r($shireIDFKs);

		for($i=1; $i<=$_POST['total']; $i++)
		{
			//Find ShireID
			if($_POST['BisinessSuburb'.$i]){
				$_POST['shiretown_id'.$i] = $this->getShireID($shireIDs, $_POST['BisinessSuburb'.$i], $_POST['BisinessState'.$i]);
			}

			//Some default values for free listings;
			$_POST['bold_listing'.$i]      = 0;
			$_POST['archived'.$i]          = 0;
			$_POST['BisinessState'.$i]     = 'NSW';
			$_POST['Bisinessfaxstd'.$i]    = '';
			$_POST['Bisinessfax'.$i]       = '';
			$_POST['Bisinessemail'.$i]     = '';
			$_POST['Bisinessurl'.$i]       = '';
			$businessName                  = mysql_real_escape_string($_POST['BisinessName'.$i]);
			/*
			 $sql="INSERT INTO `local_businesses` (
			 `business_id` ,
			 `business_initials` ,
			 `business_name` ,
			 `business_street1` ,
			 `business_street2` ,
			 `street1_status`,
			 `street2_status`,
			 `business_suburb` ,
			 `business_state` ,
			 `business_postcode` ,
			 `business_phonestd` ,
			 `business_phone` ,
			 `business_faxstd` ,
			 `business_fax` ,
			 `business_email` ,
			 `business_url` ,
			 `business_origin` ,
			 `shiretown_id`,
			 `shire_name` ,
			 `shire_town` ,
			 `business_mobile` ,
			 `business_contact` ,
			 `bold_listing` ,
			 `archived` ,
			 `account_id` ,
			 `business_logo` ,
			 `business_description`
			 )
			 VALUES (
			 '{$_POST['BisinessInitial'.$i]}',
			 '',
			 '{$businessName}',
			 '{$_POST['BisinessStreet1'.$i]}',
			 '{$_POST['BisinessStreet2'.$i]}',
			 0,
			 0,
			 '{$_POST['BisinessSuburb'.$i]}',
			 'NSW',
			 '{$_POST['BisinessPostcode'.$i]}',
			 '{$_POST['Bisinessphonestd'.$i]}',
			 '{$_POST['Bisinessphone'.$i]}',
			 '{$_POST['Bisinessfaxstd'.$i]}',
			 '{$_POST['Bisinessfax'.$i]}',
			 '{$_POST['Bisinessemail'.$i]}',
			 '{$_POST['Bisinessurl'.$i]}',
			 '{$_POST['Bisinessorigin'.$i]}',
			 '{$_POST['shiretown_id'.$i]}',
			 '{$_POST['shire_name'.$i]}',
			 '{$_POST['shire_town'.$i]}',
			 '{$_POST['Bisinessmobile'.$i]}',
			 '{$_POST['Bisinesscontact'.$i]}',
			 {$_POST['bold_listing'.$i]},
			 {$_POST['archived'.$i]},
			 '{$_POST['account_id'.$i]}',
			 '{$_POST['Bisinesslogo'.$i]}',
			 '{$_POST['business_description'.$i]}'
			 );";
			 //print("<br /> $sql <br />");
			 $res	=   mysql_query($sql);
			 */
			$sql="INSERT INTO `local_businesses` (
							`business_id` ,
							`business_initials` ,
							`business_name` ,
							`business_street1` ,
							`business_street2` ,
							`street1_status`,
							`street2_status`,
							`business_suburb` ,
							`business_state` ,
							`business_postcode` ,
							`business_phonestd` ,
							`business_phone` ,
							`business_faxstd` ,
							`business_fax` ,
							`business_email` ,
							`business_url` ,
							`business_origin` ,
                            `shiretown_id`,							
							`shire_name` ,
							`shire_town` ,
							`business_mobile` ,
							`business_contact` ,
							`bold_listing` ,
							`archived` ,
							`account_id` ,
							`business_logo` ,
							`business_description`
							)
							VALUES (
							'{$_POST['BisinessInitial'.$i]}', 'Free', '{$businessName}', '{$_POST['BisinessStreet1'.$i]}', '{$_POST['BisinessStreet2'.$i]}', 0, 0, '{$_POST['BisinessSuburb'.$i]}', 'NSW', '{$_POST['BisinessPostcode'.$i]}', '{$_POST['Bisinessphonestd'.$i]}', '{$_POST['Bisinessphone'.$i]}', '{$_POST['Bisinessfaxstd'.$i]}', '{$_POST['Bisinessfax'.$i]}', '{$_POST['Bisinessemail'.$i]}', '{$_POST['Bisinessurl'.$i]}', '{$_POST['Bisinessorigin'.$i]}', '{$_POST['shiretown_id'.$i]}', '{$_POST['shire_name'.$i]}', '{$_POST['shire_town'.$i]}', '{$_POST['Bisinessmobile'.$i]}', '{$_POST['Bisinesscontact'.$i]}', {$_POST['bold_listing'.$i]}, {$_POST['archived'.$i]}, '{$_POST['account_id'.$i]}', '{$_POST['Bisinesslogo'.$i]}', '{$_POST['business_description'.$i]}');";						 

			$res1	=   mysql_query($sql);

			if($res1){
				//print("SQL Insert Success");
				//print("<br /> $sql <br />");
				$success++;
			} else {
				print("<br /> SQL Insert Error " . mysql_error());
				print("<br /> $sql <br />");
				$failure++;
			}

			//Find and assign all Classification Codes

			if($_POST['BisinessClass1'.$i] || $_POST['BisinessClass2'.$i] || $_POST['BisinessClass3'.$i] || $_POST['BisinessClass4'.$i] || $_POST['BisinessClass5'.$i]){
				$classiIDs = $this->getClassificationIDs($classificationIDs, array($_POST['BisinessClass1'.$i], $_POST['BisinessClass2'.$i], $_POST['BisinessClass3'.$i], $_POST['BisinessClass4'.$i], $_POST['BisinessClass5'.$i]));
				$res2               = $this->insertClassificationID($classiIDs, $_POST['BisinessInitial'.$i]);
			}


			$Array = array("result"=>true,"message"=>"Business inserted successfully");
		}
		if($failure)
		print("<br />$failure rows failed to be inserted into the database<br />");

		if($success)
		print("<br />$success rows were successfully inserted into the database<br />");

		/*
		 for($i=1; $i<=$_POST['total']; $i++)
		 {

		 $sql="INSERT INTO `local_businesses` (
		 `business_id` ,
		 `business_initials` ,
		 `business_name` ,
		 `business_street1` ,
		 `business_street2` ,
		 `business_suburb` ,
		 `business_state` ,
		 `business_postcode` ,
		 `business_phonestd` ,
		 `business_phone` ,
		 `business_faxstd` ,
		 `business_fax` ,
		 `business_email` ,
		 `business_url` ,
		 `business_origin` ,
		 `shiretown_id` ,
		 `shire_name` ,
		 `shire_town` ,
		 `business_mobile` ,
		 `business_contact` ,
		 `bold_listing` ,
		 `archived` ,
		 `account_id` ,
		 `client_id` ,
		 `business_logo` ,
		 `business_description`
		 )
		 VALUES (
		 NULL , '{$_POST['BisinessInitial'.$i]}', '{$_POST['BisinessName'.$i]}', '{$_POST['BisinessStreet1'.$i]}', '{$_POST['BisinessStreet2'.$i]}', '{$_POST['BisinessSuburb'.$i]}', '{$_POST['BisinessState'.$i]}', '{$_POST['BisinessPostcode'.$i]}', '{$_POST['Bisinessphonestd'.$i]}', '{$_POST['Bisinessphone'.$i]}', '{$_POST['Bisinessfaxstd'.$i]}', '{$_POST['Bisinessfax'.$i]}', '{$_POST['Bisinessemail'.$i]}', '{$_POST['Bisinessurl'.$i]}', '{$_POST['Bisinessorigin'.$i]}', '{$_POST['shiretown_id'.$i]}', '{$_POST['shire_name'.$i]}', '{$_POST['shire_town'.$i]}', '{$_POST['Bisinessmobile'.$i]}', '{$_POST['Bisinesscontact'.$i]}', '{$_POST['bold_listing'.$i]}', '{$_POST['archived'.$i]}', '{$_POST['account_id'.$i]}', '{$_POST['client_id'.$i]}', '{$_POST['Bisinesslogo'.$i]}', '{$_POST['business_description'.$i]}'
		 );";
		 print("<br /> $sql <br />");
		 //$res	=   mysql_query($sql);


		 $Array = array("result"=>true,"message"=>"Business inserted successfully");
		 }
		 */
		/*
		 print("<strong>POST ARRAY START</strong>");
		 print_r($_POST);
		 print("<strong>POST ARRAY END</strong>");
		 print("<br />");
		 */

		return $Array;
	}



	public function searchList($get,$fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{
		$retArray = array();
		$SQL="SELECT
	                *
			FROM	
			       local_businesses
			WHERE expired=0
			       AND client_id!=0 
				   AND
				   business_name LIKE '%{$get['businessname']}%'
			LIMIT 
			$fr,$noOfRecords";
			$res=$this->MyDB->query($SQL);//prexit($res);
			// $this->MyDB->addWhere("client_id!=0  AND business_name LIKE '%{$get['businessname']}%' ");
			// $res=$this->MyDB->getAll($fr, $noOfRecords);prexit($res);
			$SQL1="SELECT
		          count(business_id) AS cnt 
			  FROM 
			      local_businesses
			  WHERE expired=0
			      AND client_id!=0
				  AND business_name LIKE '%{$get['businessname']}%'
			 ";

			$count_all = $this->MyDB->query($SQL1);//prexit($count_all);
			$retArray['listings'] = $res;
			$retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
			return $retArray;

	}

	public function validatesearch($get)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		if(empty($get['businessname']))
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

	public function fetchRegion()
	{
		$SQL="SELECT
		            *
			  FROM
			        shire_names";
		$rec=$this->MyDB->query($SQL);
		return $rec;
	}

	public function getSuburb($get)
	{
		$SQL="SELECT
		*
		FROM
		shire_towns
		WHERE shirename_id='{$get['ID']}'";
		$rec=$this->MyDB->query($SQL);
		return $rec;
	}

}
?>