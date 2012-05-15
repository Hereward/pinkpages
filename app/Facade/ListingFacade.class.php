<?php
class ListingFacade extends MainFacade {

	/**
     *  __construct
     *
     *  Instantiate MyDB object
     */
	public function __construct(MyDB $myDB, Request $request) {

		parent::__construct($myDB, $request);
		$this->myDB = $myDB;
		$this->myDB->table=TBL_LOCAL_BUSINESS;
		$this->myDB->sequenceName=TBL_LOCAL_BUSINESS;
		$this->myDB->primaryCol="business_id";
	}/* END __construct */
	
	private function replaceChars($string) {
	  $specialCharacters = array(
	    '#' => '%',
	    '-' => '%',
	    '`' => '%',
	    "\'" => '%',				
	    "'" => '%',
		" " => '%'
	  );
	  
      return str_replace(array_keys($specialCharacters), $specialCharacters, $string);
	}

	function SearchResult($fr=0, $perPage=DEFAULT_PAGING_SIZE,$get)
	{	
		$res 				= array();
		$addTable 			= "";
		$RegionCondition	= "";
		$RegionID			= array();

		$SearchVal1 		= (!empty($get['Search1']))?$get['Search1']:NULL;
		$SearchVal2 		= (!empty($get['Search2']))?$get['Search2']:NULL;
		$SearchOption 		= (!empty($get['SearchOption']))?$get['SearchOption']:NULL;
		$SortCondition 		= (!empty($get['sortby']))?$get['sortby']:NULL;

		$classificationId 	= (!empty($get['clasId']))?$get['clasId']:NULL;
		$StateSearch 		= (!empty($get['state']))?$get['state']:NULL;
		$StateSearch		= explode("__",$StateSearch);

		$shirename 			= (!empty($get['shirename']))?$get['shirename']:NULL;
		$shirename			= explode("__",$shirename);

		$shiretown 			= (!empty($get['shiretown']))?$get['shiretown']:NULL;
		$shiretown			= explode("__",$shiretown);

		//$SearchVal1 = $this->myDb->quote($SearchVal1);
		//$SearchVal2 = $this->myDb->quote($SearchVal2);	
		
		if(isset($SearchVal2) && $SearchVal2 != '')
		{
			$fetchRegionID		="SELECT shirename_id FROM shire_names WHERE shirename_shirename LIKE '%".$SearchVal2."%'";
			$RegionID = $this->myDB->query($fetchRegionID);
		}

		if(count($RegionID) == '1' && count($RegionID) != '0')
		{
			$region_id = $RegionID[0]['shirename_id'];
		}

		/*if(isset($region_id))
		{
		$RegionCondition = " OR business_ranks.shirename_id = '{$region_id}'";
		}*/

		if($SearchVal1 != '' && $SearchVal2 == '')
		{
			$condition="lb.business_name LIKE '%".$this->replaceChars($SearchVal1)."%'";
		}else{
			$condition="(lb.business_name LIKE '%".$this->replaceChars($SearchVal1)."%') AND (lb.business_postcode LIKE '%".$SearchVal2."%' OR lb.shire_name LIKE '%".$SearchVal2."%'OR lb.business_suburb LIKE '%".$SearchVal2."%' OR lb.business_state LIKE '%".$SearchVal2."%' ".$RegionCondition.")";
		}


		$condition .= " AND lb.expired=0 ";

		//fetching count
		$sql = "SELECT
					COUNT(lb.business_id) AS cnt
				FROM
					local_businesses AS lb
				WHERE
					$condition				
		";
		$result = $this->myDB->query($sql);
		$count=$result['0']['cnt'];

		$sql				= "SELECT DISTINCT
									lb.business_phonestd, 
									lb.business_id, 
									lb.url_alias, 									
									lb.business_phone, 
									lb.business_url, 
									lb.bold_listing, 
									lb.business_street1, 
									lb.business_street2, 
									lb.business_postcode, 
									lb.business_suburb, 
									lb.business_state, 
									lb.business_name,
									lb.street1_status,
									lb.street2_status,
									lb.map_status,
									lb.business_email,
									lb.business_description,
									lb.business_logo,
									lb.business_email,
									lb.archived
								FROM 
									local_businesses AS lb
								WHERE 
									$condition 
								ORDER BY 
									lb.business_name ASC
								LIMIT 
									$fr,".DEFAULT_PAGING_SIZE;
		//prexit($sql);
		$result = $this->myDB->query($sql);
		
		if(count($result)>0) {
            $this->successfulSearch($get,"Business Name");
			$classificationFacade = new ClassificationFacade($this->myDB);
			foreach ($result as $k=>$category) {
				$classification_name = $this->getClassificationsByBusiness($category['business_id']);
				$result[$k]['classification_name'] = $classification_name;
				$result[$k]['is_ranked'] = $this->isRanked($category['business_id']);
				if(REWRITE_URL){
				  $result[$k]['link'] = $this->request->createURL("{$category['url_alias']}/{$category['business_id']}/listing");				
				  $result[$k]['url'] = $this->request->createURL("{$category['url_alias']}/{$category['business_id']}/listing");
                } else {				  
				  $result[$k]['link'] = $this->request->createURL("Listing", "boldListing", "ID={$category['business_id']}");
				  $result[$k]['url'] = $this->request->createURL("Listing", "googleMapView", "Street={$category['business_street1']}&Suburb={$category['business_suburb']}&State={$category['business_state']}&Postcode={$category['business_postcode']}&businessId={$category['business_id']}&name={$category['business_name']}&classification={$classification_name}");
                }  								
			}
		}
		else
		{
			$this->failedSearch($get,"Business Name");
		}
		$res['blogs'] 	= $result;
		$res['paging'] 	= Paging::numberPaging($count, $fr, DEFAULT_PAGING_SIZE);
		return $res;
	}

	public function getClassificationsByBusiness($business_id) {
		$classifications = '';
		$sql = "SELECT
					lc.localclassification_name 
				FROM
					business_classification AS bc
					LEFT JOIN local_classification AS lc
						ON (bc.localclassification_id=lc.localclassification_id)
				WHERE
					bc.business_id=$business_id
				";
		$result = $this->myDB->query($sql);
		foreach ($result as $row) {
			$classifications .= ucwords(strtolower($row['localclassification_name'])).", ";
		}
		return rtrim($classifications, ", ");
	}
	
    public function getOneClassification($localclassification_id) {
		$classifications = '';
		$sql = "SELECT
					*
				FROM
					local_classification
						
				WHERE
					localclassification_id=$localclassification_id
				";
		$result = $this->myDB->query($sql);

		return $result;
	}
	
     public function getClassificationsByBusinessComplete($business_id) {
		$classifications = array();
		$sql = "SELECT
					* 
				FROM
					business_classification AS bc
					LEFT JOIN local_classification AS lc
						ON (bc.localclassification_id=lc.localclassification_id)
				WHERE
					bc.business_id=$business_id
				";
		$result = $this->myDB->query($sql);

		return $result;
		
	}

	private function isRanked($business_id) {
		$sql = "SELECT COUNT(businessrank_id) AS cnt FROM business_ranks WHERE business_id=$business_id";
		$result = $this->myDB->query($sql);
		return $result[0]['cnt'];
	}

	public function failedSearch($post,$type)
	{

		$SearchVal1 		= (!empty($post['Search1']))?$post['Search1']:NULL;
		$SearchVal2 		= (!empty($post['Search2']))?$post['Search2']:NULL;
		$SearchVal1			=$this->myDB->quote($SearchVal1);
		$SearchVal2			=$this->myDB->quote($SearchVal2);


		$failed_searches=0;
		$sql="SELECT * FROM site_stats";
		$res=$this->myDB->query($sql);
		if($res[0]['failed_searches']=='')
		{
			$sql="INSERT INTO site_stats('failed_searches') VALUES('0') WHERE id=1";
			$this->myDB->query($sql);
		}
		else
		{
			$failed_searches=$res[0]['failed_searches']+1;
			$SQL="UPDATE site_stats SET failed_searches='{$failed_searches}' WHERE id=1";
			$this->myDB->query($SQL);

			$date=date("Y-m-d,H:m:s");
			$sql = "INSERT INTO `failed_searches` (`searchid`, `search_date`, `search_type`, `search_term`, `businessname`, `suburb`, `street`, `regionid`) VALUES (NULL, '{$date}', '{$type}', '{$SearchVal1}', '{$SearchVal2}', '{$SearchVal2}', '{$SearchVal2}', NULL)";
			$this->myDB->query($sql);
		}

	}
	
	public function successfulSearch($post, $type)
	{	
		$SearchVal1 		= (!empty($post['Search1']))?$post['Search1']:NULL;
		$SearchVal2 		= (!empty($post['Search2']))?$post['Search2']:NULL;
		$SearchVal1			=$this->myDB->quote($SearchVal1);
		$SearchVal2			=$this->myDB->quote($SearchVal2);
        //dev_log::write("successfulSearch - $type | $SearchVal1 | $SearchVal2 ");
		//$date=date("Y-m-d,H:m:s");
		$date= date("Y-m-d H:i:s");
		$sql = "INSERT INTO `successful_searches` (`searchid`, `search_date`, `search_type`, `search_term`, `businessname`, `suburb`, `street`, `regionid`) VALUES (NULL, '{$date}', '{$type}', '{$SearchVal1}', '{$SearchVal2}', '{$SearchVal2}', '{$SearchVal2}', NULL)";
		$this->myDB->query($sql);
	}	
	
	private function allSearch($post, $type)
	{
		$SearchVal1 		= (!empty($post['Search1']))?$post['Search1']:NULL;
		$SearchVal2 		= (!empty($post['Search2']))?$post['Search2']:NULL;
		$SearchVal1			=$this->myDB->quote($SearchVal1);
		$SearchVal2			=$this->myDB->quote($SearchVal2);

		$date=date("Y-m-d,H:m:s");
		$sql = "INSERT INTO `all_searches` (`searchid`, `search_date`, `search_type`, `search_term`, `businessname`, `suburb`, `street`, `regionid`) VALUES (NULL, '{$date}', '{$type}', '{$SearchVal1}', '{$SearchVal2}', '{$SearchVal2}', '{$SearchVal2}', NULL)";
		$this->myDB->query($sql);
	}		

	public function searchKeyword($val1,$val2,$get)
	{
		$SearchValue 	= (!empty($get['Search2']))?$get['Search2']:NULL;
		/*	$QUERY			="SELECT shire_names.shirename_id,shire_names.shirename_shirename,shire_towns.shiretown_townname
		FROM shire_names,shire_towns
		WHERE shire_names.shirename_id=shire_towns.shirename_id
		AND shire_towns.shiretown_townname LIKE '%".$SearchValue."%' GROUP BY shire_names.shirename_shirename";*/
		$resultOuter=array();
		$QUERY_OUTER	="SELECT * FROM shire_names";
		$result			=$this->myDB->query($QUERY_OUTER);

		if(count($result) > 0)
		{

			$i=0;
			foreach($result as $val)
			{
				$Condition 		="shirename_id='{$val['shirename_id']}' AND shiretown_townname LIKE '%".$SearchValue."%'";
				$QUERY_INNER	="SELECT * FROM shire_towns WHERE {$Condition}";

				$resultOuter[$i]['shirename']	=$this->myDB->query($QUERY_INNER);
				$resultOuter[$i]['region']		=$val['shirename_shirename'];
				$i++;

			}

		}
		return $resultOuter;
	}


	public function getRegion($val1,$val2,$get)
	{
		$SearchValue 	= (!empty($get['Search1']))?$get['Search1']:NULL;
		$SearchRegion 	= (!empty($get['Region']))?$get['Region']:NULL;

		$condition="(local_classification.localclassification_name LIKE '%".$SearchValue."%') AND (local_businesses.shire_name LIKE '%".$SearchRegion."%')";

		$sql="SELECT count(local_classification.localclassification_name) AS count_localclassification_name,local_classification.localclassification_id,local_classification.localclassification_name
			  			FROM local_classification,local_businesses,business_classification 
							WHERE ($condition)
								AND local_businesses.expired=0 
								AND (local_businesses.business_id=business_classification.business_id) 
								AND (local_classification.localclassification_id=business_classification.localclassification_id) 
							GROUP BY local_classification .localclassification_name";


		$result = $this->myDB->query($sql);
		if(count($result)>0) {
			foreach ($result as $k=>$classification) {
				$result[$k]['link'] = $this->request->createURL("Listing", "categorySearch", "search={$classification['localclassification_id']}&category={$classification['localclassification_name']}&val={$this->request->getAttribute('Search2')}");
			}
		}


		return $result;
	}


	public function getSuburbResult($val1,$val2,$get)
	{
		$SearchValue 	= (!empty($get['Search1']))?$get['Search1']:NULL;
		$SearchSuburb 	= (!empty($get['Suburb']))?$get['Suburb']:NULL;

		$condition="(local_classification.localclassification_name LIKE '%".$SearchValue."%') AND(local_businesses.business_postcode LIKE '%".$SearchSuburb."%' OR local_businesses.business_suburb LIKE '%".$SearchSuburb."%' OR local_businesses.business_state LIKE '%".$SearchSuburb."%')";

		$sql="SELECT count(local_classification.localclassification_name) AS count_localclassification_name,local_classification.localclassification_id,local_classification.localclassification_name
			  			FROM local_classification,local_businesses,business_classification 
							WHERE ($condition)
								AND local_businesses.expired=0 
								AND (local_businesses.business_id=business_classification.business_id) 
								AND (local_classification.localclassification_id=business_classification.localclassification_id) 
							GROUP BY local_classification .localclassification_name";


		$result = $this->myDB->query($sql);
		if(count($result)>0) {
			foreach ($result as $k=>$classification) {
				$result[$k]['link'] = $this->request->createURL("Listing", "categorySearch", "search={$classification['localclassification_id']}&category={$classification['localclassification_name']}&val={$this->request->getAttribute('Search2')}");
			}
		}


		return $result;
	}


	//====================================================================//
	//             Refine Dispaly on the basis category selection         //
	//====================================================================//

	public function refineKeywordSearchArray($get)
	{
		$addTable 		= "";
		$search 		= (!empty($get['search']))?$get['search']:NULL;
		$condition 		= $main_cond	= " bc.localclassification_id=".$this->myDB->quote($search)." AND lb.expired=0 ";
		$condition 		.= " AND br.localclassification_id=bc.localclassification_id ";
		$category 		= (!empty($get['category']))?$get['category']:NULL;
		$val 			= (!empty($get['val']))?$get['val']:NULL;
		$SortCondition 	= (!empty($get['sortby']))?$get['sortby']:NULL;
		$Suburb 		= (!empty($get['Suburb']))?$get['Suburb']:NULL;
		$shire_id = 0;
		if($val == '')
		{
			$val 			= (!empty($get['Suburb']))?$get['Suburb']:NULL;
		}else{
			$val 			= (!empty($get['val']))?$get['val']:NULL;
		}

		if(isset($get['state']) && !empty($get['state'])) {
			$temp = explode("__",$get['state']);
			if(isset($temp[1])) {
				$condition .= " AND lb.business_state='".$this->myDB->quote(trim($temp[1]))."'";
			}
		}

		if(isset($get['shirename']) && !empty($get['shirename'])) {
			$temp = explode("__",$get['shirename']);
			if(isset($temp[1])) {
				$condition .= " AND lb.shire_name='".$this->myDB->quote(trim($temp[1]))."'";
			}
		}

		if(isset($get['shiretown']) && !empty($get['shiretown'])) {
			$temp = explode("__",$get['shiretown']);
			if(isset($temp[1])) {
				$condition .= " AND lb.business_suburb='".$this->myDB->quote(trim($temp[1]))."'";
			}
		}

		if(isset($get['postcode']) && !empty($get['postcode'])) {
			$condition .= " AND lb.business_postcode=".$this->myDB->quote(trim($get['postcode']));
		}

		if(isset($get['postcode']) && !empty($get['postcode'])) {
			$condition .= " AND lb.business_postcode=".$this->myDB->quote(trim($get['postcode']));
			$shire_id = $this->isPostCodeExists($get['postcode']);
		}


		if(isset($get['shire_name']) && !empty($get['shire_name'])) {
			$condition .= " AND lb.shire_name='".$this->myDB->quote(trim($get['shire_name']))."'";
		}

		if(isset($get['shire_town']) && !empty($get['shire_town'])) {
			$condition .= " AND lb.business_suburb='".$this->myDB->quote(trim($get['shire_town']))."'";
		}
		if(!$shire_id && isset($get['shire_name'])) {
			$shire_id = $this->isRegionExists($get['shire_name']);
		}

		/*	if(isset($get['keyword']) && !empty($get['keyword'])) {

		$condition .= " AND business_keyword.business_key_name='".$get['keyword']."'";
		$addTable .= ' LEFT JOIN business_keyword ON business_keyword.business_id=lb.business_id ';
		}*/
		if(!$shire_id && isset($get['shire_name'])) {
			$shire_id = $this->isRegionExists($get['shire_name']);
		}

		if($shire_id) {
			$condition .=" AND br.shirename_id=$shire_id";
		}
		$shire_cond = " $main_cond AND bc.business_id = lb.business_id ";
		if(isset($get['shire_name']) && !empty($get['shire_name'])) {
			$shire_cond .= " AND lb.shire_name='".$this->myDB->quote(trim($get['shire_name']))."' ";
		}
		$condition = "( $condition ) OR ( $shire_cond )";

		$refineQuery="SELECT
						DISTINCT
						lb.business_phonestd, 
						lb.business_id, 
						lb.business_phone, 
						lb.business_url, 
						lb.bold_listing, 
						lb.business_street1,
						lb.street1_status,
						lb.street2_status, 
						lb.map_status, 
						lb.business_street2, 
						lb.business_logo,
						lb.business_mobile ,
						lb.business_email,
						lb.business_url,
						lb.business_fax,
						lb.business_description,
						bc.business_id, 
						lb.business_postcode, 
						lb.business_suburb, 
						lb.business_state, 
						lb.business_name,
						lb.shire_name,
						IF( ISNULL(br.businessrank_rank), 9999, br.businessrank_rank) AS rank
					FROM (
						business_classification AS bc
						LEFT JOIN local_businesses AS lb ON ( bc.business_id = lb.business_id )
						)
						LEFT JOIN business_ranks AS br ON ( lb.business_id = br.business_id
						AND br.localclassification_id=".$this->myDB->quote($search).")
						$addTable
					WHERE 
						$condition";

		$refineResult = $this->myDB->query($refineQuery);
		return $refineResult;
	}
	
	function categorySearchResultAlpha($fr=0, $perPage=DEFAULT_PAGING_SIZE, $get)
	{
		$result = $brands = $services = $hours = $payments = array();
		$search 		= (!empty($get['search']))?$get['search']:NULL;
		$main_cond	= $main_refine_cond = " bc.localclassification_id=".$this->myDB->quote($search)." AND lb.expired=0 ";
		$condition = " AND br.localclassification_id=bc.localclassification_id ";
		$category 		= (!empty($get['category']))?$get['category']:NULL;
		$val 			= (!empty($get['val']))?$get['val']:NULL;
		$SortCondition 	= (!empty($get['sortby']))?$get['sortby']:NULL;
		$Suburb 		= (!empty($get['Suburb']))?$get['Suburb']:NULL;
		$shire_id = $sh_id = 0;
		if($val == '')
		{
			$val 			= (!empty($get['Suburb']))?$get['Suburb']:NULL;
		}else{
			$val 			= (!empty($get['val']))?$get['val']:NULL;
		}

		$addTable = "";

		//Refine Search Start
		if(isset($get['service']) && !empty($get['service'])) {

			$main_cond .= " AND bs.service_id='".$get['service']."' AND bs.business_id=lb.business_id ";
			$addTable .= ', business_service AS bs ';
		}

		if(isset($get['brand']) && !empty($get['brand'])) {

			$main_cond .= " AND bb.brand_id='".$get['brand']."' AND bb.business_id=lb.business_id";
			$addTable .= ' , business_brand AS bb ';
		}

		if(isset($get['hours']) && !empty($get['hours'])) {

			$main_cond .= " AND bh.hour_id='".$get['hours']."' AND bh.business_id=lb.business_id";
			$addTable .= ' , business_hours AS bh ';
		}

		if(isset($get['payment']) && !empty($get['payment'])) {

			$main_cond .= " AND bp.payment_id='".$get['payment']."' AND bp.business_id=lb.business_id";
			$addTable .= ' , business_payment AS bp ';
		}
		//Refine Search End

		if(isset($get['state']) && !empty($get['state'])) {
			$temp = explode("__",$get['state']);
			if(isset($temp[1])) {
				$main_cond .= " AND lb.business_state='".$this->myDB->quote(trim($temp[1]))."'";
			}
		}

		$location_cond = "";
		if(isset($get['shirename']) && !empty($get['shirename'])) {
			$temp = explode("__",$get['shirename']);
			if(isset($temp[1])) {
				$location_cond .= " AND lb.shire_name='".$this->myDB->quote(trim($temp[1]))."'";
			}
		}

		if(isset($get['shiretown']) && !empty($get['shiretown'])) {
			$temp = explode("__",$get['shiretown']);
			if(isset($temp[1])) {
				$location_cond .= " AND lb.business_suburb='".$this->myDB->quote(trim($temp[1]))."'";
			}
		}

		if(isset($get['postcode']) && !empty($get['postcode'])) {
			$location_cond .= " AND lb.business_postcode=".$this->myDB->quote(trim($get['postcode']));
			$shire_id = $this->isPostCodeExists($get['postcode']);
		}

		if(isset($get['shire_town']) && !empty($get['shire_town'])) {
			$location_cond .= " AND lb.business_suburb='".$this->myDB->quote(trim($get['shire_town']))."'";
			$shire_id = $this->isSuburbExists($get['shire_town']);
		}

		if(!$shire_id && isset($get['shire_name'])) {
			$shire_id = $this->isRegionExists($get['shire_name']);
		}
		$rank_condition = '';
		if($shire_id) {
			$condition .= " AND br.shirename_id=$shire_id";
			$rank_condition = " AND br.shirename_id=$shire_id";
			$sh_id = $shire_id;
		}
		$shire_cond = " $main_cond AND bc.business_id = lb.business_id ";
		$refine_shire_cond = " $main_refine_cond $location_cond AND bc.business_id = lb.business_id ";
		$suburb_cond = "";
		if(isset($get['shire_name']) && !empty($get['shire_name'])) {
			$shire_cond .= " AND lb.shire_name='".$this->myDB->quote(trim($get['shire_name']))."' ";
			$refine_shire_cond .= " AND lb.shire_name='".$this->myDB->quote(trim($get['shire_name']))."' ";
			$suburb_cond = " AND lb.shire_name='".$this->myDB->quote(trim($get['shire_name']))."' ";
		}

		$refine_condition = "( $main_refine_cond $condition ) OR ( $refine_shire_cond )";

		$exclude_result_condition = "( $main_cond $condition $suburb_cond ) OR ( $shire_cond $location_cond )";
		$condition = "( $main_cond $condition ) OR ( $shire_cond $location_cond )";
		
		//exception handle for All-Sydney results
		$OrderBy ="ORDER BY lb.business_name";
		$rank_col = " br.businessrank_rank ";
		$time_stamp_col = "br.businessrank_timestamp,";
		
		if(!$shire_id || $shire_id==59) {
			//$rank_col = " 9999 ";
			//$OrderBy ="ORDER BY (CASE WHEN lb.business_name = 'Strike First Pest Management Systems' THEN 1  WHEN lb.business_name = 'MENASH & TECHNOSAT' THEN 1 WHEN lb.business_name = 'BIG BOB REMOVALS' THEN 2 WHEN lb.business_name = 'JUMBUCK POOL & HOME FENCING' THEN 3 WHEN lb.business_name = 'STREAMLINE ELECTRICAL AND SECURITY PTY LTD' THEN 4 WHEN lb.business_name = 'PHOENIX BATHROOM RENOVATIONS' THEN 5 WHEN lb.business_name = 'A SOUTH EAST KITCHEN MAKEOVER' THEN 6 ELSE 7 END), rank ASC, lb.business_name";
            $OrderBy ="ORDER BY lb.business_name";			
			$time_stamp_col = "";
		}
		
		
		//getting count of result with the business location
		$results_within_location = 0;
		if($suburb_cond) {
			$sql = "SELECT
						DISTINCT lb.business_id,
						$time_stamp_col 
						IF(ISNULL(br.businessrank_rank), 999999, $rank_col) AS rank
					FROM (
						business_classification AS bc
						)
						$addTable
						LEFT JOIN local_businesses AS lb ON ( bc.business_id = lb.business_id )
							LEFT JOIN business_ranks AS br ON ( lb.business_id = br.business_id
								AND br.localclassification_id=".$this->myDB->quote($search).")
					WHERE 
						$exclude_result_condition";

			$count_result = $this->myDB->query($sql);
			$results_within_location = count($count_result);
		}
		
		$sql = "SELECT
					DISTINCT lb.business_id,
					$time_stamp_col 
					IF(ISNULL(br.businessrank_rank), 999999, $rank_col) AS rank
				FROM (
					business_classification AS bc
					)
					$addTable
					LEFT JOIN local_businesses AS lb ON ( bc.business_id = lb.business_id )
						LEFT JOIN business_ranks AS br ON ( lb.business_id = br.business_id
							AND br.localclassification_id=".$this->myDB->quote($search).")
				WHERE 
					$condition";
		//prexit($sql);
		$count_result = $this->myDB->query($sql);
		//Limit results to 100 in order to stop SCRAPING
		$count = (count($count_result) > 100) ? 100 : count($count_result);
		$diff = $count - $results_within_location;
		
		$Limit = $perPage;
		
		//for special paging
		/*$ranked_count = 0;
		if($count_result) {
			foreach ($count_result as $res) {
				$ranked_count += ($res['rank']=='9999')?1:0;
			}
		}
		if($ranked_count>=5) {
			$Limit=5;
			$special_page_count = ceil($ranked_count/10);//prexit($special_page_count);
		}*/
		//for special paging

		if($count) {
			if(isset($_GET['exclude'])){
			  if($_GET['exclude']==1){
				  $condition = $exclude_result_condition;
				  $count = $results_within_location;
			  }	  
			}

                    $sql = "SELECT lb.business_id, lb.url_alias, lb.business_phonestd, lb.business_phone, 
                                   lb.business_url, lb.bold_listing, lb.business_street1, 
								   lb.street1_status, lb.street2_status, lb.map_status, 
								   lb.business_street2, lb.business_logo, lb.business_mobile , 
								   lb.business_email, lb.business_url, lb.business_fax, 
								   lb.business_description, bc.business_id, lb.business_postcode, 
								   lb.business_suburb, lb.business_state, lb.business_name, 
								   lb.shire_name, bc.localclassification_id,
								   lb.business_initials,
								   cast('99' as signed) AS rank 								   
	                          FROM business_classification bc, local_businesses lb
                             WHERE lb.business_id = bc.business_id
                               AND bc.localclassification_id = " .$this->myDB->quote($search) . " 
							   AND lb.business_initials !='free'
                             UNION
                            SELECT lb.business_id, lb.url_alias, lb.business_phonestd, lb.business_phone, 
                                lb.business_url, lb.bold_listing, lb.business_street1, 
								lb.street1_status, lb.street2_status, lb.map_status, 
								lb.business_street2, lb.business_logo, lb.business_mobile , 
								lb.business_email, lb.business_url, lb.business_fax, 
								lb.business_description, bc.business_id, lb.business_postcode, 
								lb.business_suburb, lb.business_state, lb.business_name, 
								lb.shire_name, bc.localclassification_id,
								lb.business_initials,
								cast('999999' as signed) AS rank 								
	                          FROM business_classification bc, local_businesses lb
                             WHERE lb.business_id = bc.business_id
                               AND bc.localclassification_id = " .$this->myDB->quote($search) . "
                               AND lb.business_initials ='free'
                             ORDER BY rank, business_name
							 LIMIT $fr,$Limit";
					//print("SQL<br />");
					//print($sql);
				    //prexit($sql);
			$business_ids_sql = "SELECT
								DISTINCT
								lb.business_id
							FROM (
								business_classification AS bc
								)
								LEFT JOIN local_businesses AS lb ON ( bc.business_id = lb.business_id )
								LEFT JOIN business_ranks AS br ON ( lb.business_id = br.business_id
								AND br.localclassification_id=".$this->myDB->quote($search).")
							WHERE 
								$refine_condition";
			$service_sql 		= "SELECT DISTINCT `service_id`, `business_service_name` FROM `business_service` WHERE business_id IN ($business_ids_sql)";
			$services 			= $this->myDB->query($service_sql);

			$brand_sql 			= "SELECT DISTINCT `brand_id`, `business_brand_name` FROM `business_brand` WHERE business_id IN ($business_ids_sql)";
			$brands 			= $this->myDB->query($brand_sql);

			$payment_sql 		= "SELECT DISTINCT `payment_id`, `payment_name` FROM `business_payment` WHERE business_id IN ($business_ids_sql)";
			$payments 			= $this->myDB->query($payment_sql);

			$hours_sql 			= "SELECT DISTINCT `hour_id`, `hour_name` FROM `business_hours` WHERE business_id IN ($business_ids_sql)";
			$hours 				= $this->myDB->query($hours_sql);
             
			$results  = $this->myDB->query($sql);
			
			$result = $results;
			//AB Commented 02/06/2010
			//$results1 = $this->myDB->query($sql1);			
			//$result   = array_merge($results, $results1);		
           
			foreach ($result as $k=>$category) {
				if($category['rank']<=9999) {
					$sql = "SELECT `business_street1`, `business_street2`, `business_suburb`, `business_state`, `business_postcode`, `street1_status`, `street2_status` FROM multiple_addresses WHERE business_id={$category['business_id']} AND shire_name=$sh_id";
					$rs = $this->myDB->query($sql);
					if($rs) {
						foreach ($rs[0] as $col=>$val) {
							$result[$k][$col] = $val;
						}
					}
				}
				$fetch_classificationName	= "SELECT localclassification_name FROM local_classification  WHERE localclassification_id={$category['localclassification_id']}";
				$result_classification 		= $this->myDB->query($fetch_classificationName);

				$fetch_add_word				= "SELECT * FROM `local_pages` WHERE `business_id` ={$category['business_id']}";
				$result_add_word 			= $this->myDB->query($fetch_add_word);

				$result[$k]['add_word1'] 	= @$result_add_word[0]['adword_line1'];
				$result[$k]['add_word2'] 	= @$result_add_word[0]['adword_line2'];

				$result[$k]['classification_name'] = $result_classification[0]['localclassification_name'];
				
				if(REWRITE_URL){
				  $result[$k]['link'] = $this->request->createURL("{$category['url_alias']}/{$category['business_id']}/listing");				
				  $result[$k]['url'] = $this->request->createURL("{$category['url_alias']}/{$category['business_id']}/listing");
                } else {				  
				  $result[$k]['link'] = $this->request->createURL("Listing", "boldListing", "ID={$category['business_id']}");
				  $result[$k]['url'] = $this->request->createURL("Listing", "googleMapView", "Street={$category['business_street1']}&Suburb={$category['business_suburb']}&State={$category['business_state']}&Postcode={$category['business_postcode']}&businessId={$category['business_id']}&name={$category['business_name']}&rank={$category['rank']}&classification={$result_classification[0]['localclassification_name']}");								
                }  				
								
			}
			if((!$shire_id || $shire_id==59) && !$fr) {//case all-sydney results
				$temp=array();
				foreach ($result as $k=>$listing) {
					if($listing['rank']==9999) {
						$sql = "SELECT businessrank_rank FROM business_ranks WHERE business_id={$listing['business_id']} AND localclassification_id={$listing['localclassification_id']}";
						$rs = $this->myDB->query($sql);
						if($rs) {
							if($rs[0]['businessrank_rank']!="9999") {
								$result[$k]['rank']=$rs[0]['businessrank_rank'];
								$temp[$rs[0]['businessrank_rank']] = $result[$k];
								unset($result[$k]);
							}
						}
					}
				}
/*				
				if($temp) {
					ksort($temp);
					$temp = array_values($temp);
					$result = array_merge($temp, $result);
				}
*/				
			}
			//prexit($result);
			//adding classification view data
			foreach ($result as $business) {
				if($business['rank']<=9999) {
					$this->addBusinessClassificationViews($search, $business['business_id']);
				}
			}
			//			adding values for reporting
			$this->addRegionClassificationViews($shire_id, $search);
		}
		else
		{
			$failed_searches=0;
			$sql="SELECT * FROM site_stats";
			$res=$this->myDB->query($sql);
			if($res[0]['failed_searches']=='')
			{
				$sql="INSERT INTO site_stats('failed_searches') VALUES('0') WHERE id=1";
				$this->myDB->query($sql);
			}
			else
			{
				$failed_searches=$res[0]['failed_searches']+1;
				$SQL="UPDATE site_stats SET failed_searches='{$failed_searches}' WHERE id=1";
				$this->myDB->query($SQL);
				if(@$StateSearch[1]!=''&& @$shirename[1]=='' && @$shiretown[1]=='')
				{
					$date=date("Y-m-d,H:m:s");
					$sql = "INSERT INTO `failed_searches` (`searchid`, `search_date`, `search_type`, `search_term`, `businessname`, `suburb`, `street`, `regionid`) VALUES (NULL, '{$date}', 'Keyword', '{$category}', NULL, NULL, NULL, NULL)";
					$this->myDB->query($sql);
				}
				elseif(@$StateSearch[1] != '' && @$shirename[1] != '' && @$shiretown[1] == '')
				{
					$date=date("Y-m-d,H:m:s");
					$sql = "INSERT INTO `failed_searches` (`searchid`, `search_date`, `search_type`, `search_term`, `businessname`, `suburb`, `street`, `regionid`) VALUES (NULL, '{$date}', 'Keyword', '{$category}', NULL, NULL, NULL, NULL)";
					$this->myDB->query($sql);
				}
				elseif(@$StateSearch[1] != '' && @$shirename[1] != '' && @$shiretown[1] != '')
				{
					$date=date("Y-m-d,H:m:s");
					$sql = "INSERT INTO `failed_searches` (`searchid`, `search_date`, `search_type`, `search_term`, `businessname`, `suburb`, `street`, `regionid`) VALUES (NULL, '{$date}', 'Keyword', '{$category}', NULL, '{$shiretown[1]}', NULL, NULL)";
					$this->myDB->query($sql);
				}
			}
		}
		$res['hours'] 			= $hours;
		$res['payments'] 		= $payments;
		$res['services']		= $services;
		$res['brands'] 			= $brands;
		$res['blogs'] 			= $result;
		$res['is_exclude']		= $results_within_location;
		$res['exclude_count']	= $diff;
		$res['paging'] 			= Paging::numberPaging($count, $fr, $perPage);
		return $res;
	} //CategoryResultAlpha End	

	function categorySearchResult($fr=0, $perPage=DEFAULT_PAGING_SIZE, $get)
	{	
		$result = $brands = $services = $hours = $payments = array();
		$search 		= (!empty($get['search']))?$get['search']:NULL;
		$main_cond	= $main_refine_cond = " bc.localclassification_id=".$this->myDB->quote($search)." AND lb.expired=0 ";
		$condition = " AND br.localclassification_id=bc.localclassification_id ";
		$category 		= (!empty($get['category']))?$get['category']:NULL;
		$val 			= (!empty($get['val']))?$get['val']:NULL;
		$SortCondition 	= (!empty($get['sortby']))?$get['sortby']:NULL;
		$Suburb 		= (!empty($get['Suburb']))?$get['Suburb']:NULL;
		$shire_id = $sh_id = 0;
		if($val == '')
		{
			$val 			= (!empty($get['Suburb']))?$get['Suburb']:NULL;
		}else{
			$val 			= (!empty($get['val']))?$get['val']:NULL;
		}

		$addTable = "";

		//Refine Search Start
		if(isset($get['service']) && !empty($get['service'])) {

			$main_cond .= " AND bs.service_id='".$get['service']."' AND bs.business_id=lb.business_id ";
			$addTable .= ', business_service AS bs ';
		}

		if(isset($get['brand']) && !empty($get['brand'])) {

			$main_cond .= " AND bb.brand_id='".$get['brand']."' AND bb.business_id=lb.business_id";
			$addTable .= ' , business_brand AS bb ';
		}

		if(isset($get['hours']) && !empty($get['hours'])) {

			$main_cond .= " AND bh.hour_id='".$get['hours']."' AND bh.business_id=lb.business_id";
			$addTable .= ' , business_hours AS bh ';
		}

		if(isset($get['payment']) && !empty($get['payment'])) {

			$main_cond .= " AND bp.payment_id='".$get['payment']."' AND bp.business_id=lb.business_id";
			$addTable .= ' , business_payment AS bp ';
		}
		//Refine Search End

		if(isset($get['state']) && !empty($get['state'])) {
		  /*
			$temp = explode("__",$get['state']);
			if(isset($temp[1])) {
				$main_cond .= " AND lb.business_state='".$this->myDB->quote(trim($temp[1]))."'";
			}
		  */	
		  $main_cond .= " AND lb.business_state='".$this->myDB->quote($get['state'])."'";
		}

		$location_cond = "";
		if(isset($get['shirename']) && !empty($get['shirename'])) {
			$temp = explode("__",$get['shirename']);
			if(isset($temp[1])) {
				$location_cond .= " AND lb.shire_name='".$this->myDB->quote(trim($temp[1]))."'";
			}
		}

		if(isset($get['shiretown']) && !empty($get['shiretown'])) {
			$temp = explode("__",$get['shiretown']);
			if(isset($temp[1])) {
				$location_cond .= " AND lb.business_suburb='".$this->myDB->quote(trim($temp[1]))."'";
			}
		}

		if(isset($get['postcode']) && !empty($get['postcode'])) {
			$location_cond .= " AND lb.business_postcode=".$this->myDB->quote(trim($get['postcode']));
			$shire_id = $this->isPostCodeExists($get['postcode']);
		}

		if(isset($get['shire_town']) && !empty($get['shire_town'])) {
			$location_cond .= " AND lb.business_suburb='".$this->myDB->quote(trim($get['shire_town']))."'";
			$shire_id = $this->isSuburbExists($get['shire_town']);
		}

		if(!$shire_id && isset($get['shire_name'])) {
			$shire_id = $this->isRegionExists($get['shire_name']);
		}
		$rank_condition = '';
		if($shire_id) {
			$condition .= " AND br.shirename_id=$shire_id";
			$rank_condition = " AND br.shirename_id=$shire_id";
			$sh_id = $shire_id;
		}
		$shire_cond = " $main_cond AND bc.business_id = lb.business_id ";
		$refine_shire_cond = " $main_refine_cond $location_cond AND bc.business_id = lb.business_id ";
		$suburb_cond = "";
		if(isset($get['shire_name']) && !empty($get['shire_name'])) {
			$shire_cond .= " AND lb.shire_name='".$this->myDB->quote(trim($get['shire_name']))."' ";
			$refine_shire_cond .= " AND lb.shire_name='".$this->myDB->quote(trim($get['shire_name']))."' ";
			$suburb_cond = " AND lb.shire_name='".$this->myDB->quote(trim($get['shire_name']))."' ";
		}

		$refine_condition = "( $main_refine_cond $condition ) OR ( $refine_shire_cond )";

		$exclude_result_condition = "( $main_cond $condition $suburb_cond ) OR ( $shire_cond $location_cond )";
		$condition = "( $main_cond $condition ) OR ( $shire_cond $location_cond )";
		
		//exception handle for All-Sydney results
		$OrderBy ="ORDER BY rank ASC, br.businessrank_timestamp ASC, lb.business_name";
		$rank_col = " br.businessrank_rank ";
		$time_stamp_col = "br.businessrank_timestamp,";
		
		if(!$shire_id || $shire_id==59) {
			//$rank_col = " 9999 ";
			//$OrderBy ="ORDER BY (CASE WHEN lb.business_name = 'Strike First Pest Management Systems' THEN 1  WHEN lb.business_name = 'MENASH & TECHNOSAT' THEN 1 WHEN lb.business_name = 'BIG BOB REMOVALS' THEN 2 WHEN lb.business_name = 'JUMBUCK POOL & HOME FENCING' THEN 3 WHEN lb.business_name = 'STREAMLINE ELECTRICAL AND SECURITY PTY LTD' THEN 4 WHEN lb.business_name = 'PHOENIX BATHROOM RENOVATIONS' THEN 5 WHEN lb.business_name = 'A SOUTH EAST KITCHEN MAKEOVER' THEN 6 ELSE 7 END), rank ASC, lb.business_name";
            $OrderBy ="ORDER BY rank ASC, lb.business_name";			
			$time_stamp_col = "";
			$sh_id = 59;
		}
		
		
		//getting count of result with the business location
		$results_within_location = 0;
		if($suburb_cond) {
			$sql = "SELECT
						DISTINCT lb.business_id,
						$time_stamp_col 
						IF(ISNULL(br.businessrank_rank), 999999, $rank_col) AS rank
					FROM (
						business_classification AS bc
						)
						$addTable
						LEFT JOIN local_businesses AS lb ON ( bc.business_id = lb.business_id )
							LEFT JOIN business_ranks AS br ON ( lb.business_id = br.business_id
								AND br.localclassification_id=".$this->myDB->quote($search).")
					WHERE 
						$exclude_result_condition";
			$count_result = $this->myDB->query($sql);
			$results_within_location = count($count_result);
		}
/*		
		$sql = "SELECT
					DISTINCT lb.business_id,
					$time_stamp_col 
					IF(ISNULL(br.businessrank_rank), 999999, $rank_col) AS rank
				FROM (
					business_classification AS bc
					)
					$addTable
					LEFT JOIN local_businesses AS lb ON ( bc.business_id = lb.business_id )
						LEFT JOIN business_ranks AS br ON ( lb.business_id = br.business_id
							AND br.localclassification_id=".$this->myDB->quote($search).")
				WHERE 
					$condition";
*/														  
				  
	     $sql = "SELECT DISTINCT lb.business_id, $time_stamp_col $rank_col AS rank
					 FROM business_classification AS bc							
					 LEFT JOIN local_businesses AS lb ON ( bc.business_id = lb.business_id )
					 LEFT JOIN business_ranks AS br ON ( lb.business_id = br.business_id $rank_condition
					  AND br.localclassification_id=".$this->myDB->quote($search).")
					WHERE $condition ";				  
 					
		//prexit($sql);
		$count_result = $this->myDB->query($sql);
		$count = count($count_result);
		$diff = $count - $results_within_location;
		
		$Limit = $perPage;
		
		//for special paging
		/*$ranked_count = 0;
		if($count_result) {
			foreach ($count_result as $res) {
				$ranked_count += ($res['rank']=='9999')?1:0;
			}
		}
		if($ranked_count>=5) {
			$Limit=5;
			$special_page_count = ceil($ranked_count/10);//prexit($special_page_count);
		}*/
		//for special paging

		if($count) {
			if(isset($_GET['exclude'])){
			  if($_GET['exclude']==1){
				  $condition = $exclude_result_condition;
				  $count = $results_within_location;
			  }	  
			}
			$sql="SELECT
						DISTINCT
						lb.business_phonestd, 						
						lb.business_id, 
						lb.url_alias,
						lb.business_phone, 
						lb.business_url, 
						lb.bold_listing, 
						lb.business_street1,
						lb.street1_status,
						lb.street2_status, 
						lb.map_status, 
						lb.business_street2, 
						lb.business_logo,
						lb.business_mobile ,
						lb.business_email,
						lb.business_url,
						lb.business_fax,
						lb.business_description,
						bc.business_id, 
						lb.business_postcode, 
						lb.business_suburb, 
						lb.business_state, 
						lb.business_name,
						lb.shire_name,
						bc.localclassification_id,
						$time_stamp_col
						IF(ISNULL(br.businessrank_rank), 999999, cast($rank_col as signed)) AS rank
					FROM (
							business_classification AS bc $addTable
						)
						LEFT JOIN local_businesses AS lb ON ( bc.business_id = lb.business_id )
						LEFT JOIN business_ranks AS br ON ( lb.business_id = br.business_id $rank_condition
						AND br.localclassification_id=".$this->myDB->quote($search). " " . " and br.shirename_id=$sh_id)
					WHERE 
						$condition
					$OrderBy 
					LIMIT $fr,$Limit ";
					
//						prexit($sql);
			$business_ids_sql = "SELECT
								DISTINCT
								lb.business_id
							FROM (
								business_classification AS bc
								)
								LEFT JOIN local_businesses AS lb ON ( bc.business_id = lb.business_id )
								LEFT JOIN business_ranks AS br ON ( lb.business_id = br.business_id
								AND br.localclassification_id=".$this->myDB->quote($search).")
							WHERE 
								$refine_condition";
			$service_sql 		= "SELECT DISTINCT `service_id`, `business_service_name` FROM `business_service` WHERE business_id IN ($business_ids_sql)";
			$services 			= $this->myDB->query($service_sql);

			$brand_sql 			= "SELECT DISTINCT `brand_id`, `business_brand_name` FROM `business_brand` WHERE business_id IN ($business_ids_sql)";
			$brands 			= $this->myDB->query($brand_sql);

			$payment_sql 		= "SELECT DISTINCT `payment_id`, `payment_name` FROM `business_payment` WHERE business_id IN ($business_ids_sql)";
			$payments 			= $this->myDB->query($payment_sql);

			$hours_sql 			= "SELECT DISTINCT `hour_id`, `hour_name` FROM `business_hours` WHERE business_id IN ($business_ids_sql)";
			$hours 				= $this->myDB->query($hours_sql);
            //dev_log::write("ListingFacade::categorySearchResult sql = ".$sql);
			$result = $this->myDB->query($sql);

			foreach ($result as $k=>$category) {
				if($category['rank']<=9999) {
					$sql = "SELECT `business_street1`, `business_street2`, `business_suburb`, `business_state`, `business_postcode`, `street1_status`, `street2_status` FROM multiple_addresses WHERE business_id={$category['business_id']} AND shire_name=$sh_id";
					$rs = $this->myDB->query($sql);
					if($rs) {
						foreach ($rs[0] as $col=>$val) {
							$result[$k][$col] = $val;
						}
					}
				}
				$fetch_classificationName	= "SELECT localclassification_name FROM local_classification  WHERE localclassification_id={$category['localclassification_id']}";
				$result_classification 		= $this->myDB->query($fetch_classificationName);

				$fetch_add_word				= "SELECT * FROM `local_pages` WHERE `business_id` ={$category['business_id']}";
				$result_add_word 			= $this->myDB->query($fetch_add_word);

				$result[$k]['add_word1'] 	= @$result_add_word[0]['adword_line1'];
				$result[$k]['add_word2'] 	= @$result_add_word[0]['adword_line2'];

				$result[$k]['classification_name'] = $result_classification[0]['localclassification_name'];
                
				if(REWRITE_URL){
				  $result[$k]['link'] = $this->request->createURL("{$category['url_alias']}/{$category['business_id']}/listing");				
				  $result[$k]['url'] = $this->request->createURL("{$category['url_alias']}/{$category['business_id']}/listing");
                } else {				  
				  $result[$k]['link'] = $this->request->createURL("Listing", "boldListing", "ID={$category['business_id']}");
				  $result[$k]['url'] = $this->request->createURL("Listing", "googleMapView", "Street={$category['business_street1']}&Suburb={$category['business_suburb']}&State={$category['business_state']}&Postcode={$category['business_postcode']}&businessId={$category['business_id']}&name={$category['business_name']}&rank={$category['rank']}&classification={$result_classification[0]['localclassification_name']}");								
                }  
			}
			if((!$shire_id || $shire_id==59) && !$fr) {//case all-sydney results
				$temp=array();
				foreach ($result as $k=>$listing) {
					if($listing['rank']==9999) {
						$sql = "SELECT businessrank_rank FROM business_ranks WHERE business_id={$listing['business_id']} AND shirename_id=59 AND localclassification_id={$listing['localclassification_id']}";
						$rs = $this->myDB->query($sql);
						if($rs) {
							if($rs[0]['businessrank_rank']!="9999") {
								$result[$k]['rank']=$rs[0]['businessrank_rank'];
								$temp[$rs[0]['businessrank_rank']] = $result[$k];
								unset($result[$k]);
							}
						}
					}
				}
				if($temp) {
					ksort($temp);
					$temp = array_values($temp);
					$result = array_merge($temp, $result);
				}
			}
			//prexit($result);
			//adding classification view data
			foreach ($result as $business) {
				if($business['rank']<=9999) {
					$this->addBusinessClassificationViews($search, $business['business_id']);
				}
			}
			//			adding values for reporting
			$this->addRegionClassificationViews($shire_id, $search);
		}
		else
		{
			$failed_searches=0;
			$sql="SELECT * FROM site_stats";
			$res=$this->myDB->query($sql);
			if($res[0]['failed_searches']=='')
			{
				$sql="INSERT INTO site_stats('failed_searches') VALUES('0') WHERE id=1";
				$this->myDB->query($sql);
			}
			else
			{
				$failed_searches=$res[0]['failed_searches']+1;
				$SQL="UPDATE site_stats SET failed_searches='{$failed_searches}' WHERE id=1";
				$this->myDB->query($SQL);
				if(@$StateSearch[1]!=''&& @$shirename[1]=='' && @$shiretown[1]=='')
				{
					$date=date("Y-m-d,H:m:s");
					$sql = "INSERT INTO `failed_searches` (`searchid`, `search_date`, `search_type`, `search_term`, `businessname`, `suburb`, `street`, `regionid`) VALUES (NULL, '{$date}', 'Keyword', '{$category}', NULL, NULL, NULL, NULL)";
					$this->myDB->query($sql);
				}
				elseif(@$StateSearch[1] != '' && @$shirename[1] != '' && @$shiretown[1] == '')
				{
					$date=date("Y-m-d,H:m:s");
					$sql = "INSERT INTO `failed_searches` (`searchid`, `search_date`, `search_type`, `search_term`, `businessname`, `suburb`, `street`, `regionid`) VALUES (NULL, '{$date}', 'Keyword', '{$category}', NULL, NULL, NULL, NULL)";
					$this->myDB->query($sql);
				}
				elseif(@$StateSearch[1] != '' && @$shirename[1] != '' && @$shiretown[1] != '')
				{
					$date=date("Y-m-d,H:m:s");
					$sql = "INSERT INTO `failed_searches` (`searchid`, `search_date`, `search_type`, `search_term`, `businessname`, `suburb`, `street`, `regionid`) VALUES (NULL, '{$date}', 'Keyword', '{$category}', NULL, '{$shiretown[1]}', NULL, NULL)";
					$this->myDB->query($sql);
				}
			}
		}
		$res['hours'] 			= $hours;
		$res['payments'] 		= $payments;
		$res['services']		= $services;
		$res['brands'] 			= $brands;
		$res['blogs'] 			= $result;
		$res['is_exclude']		= $results_within_location;
		$res['exclude_count']	= $diff;
		$res['paging'] 			= Paging::numberPaging($count, $fr, $perPage);
		return $res;
	}
	
	private function addBusinessClassificationViews($classification_id, $business_id) {
		
		$sql = "UPDATE
					business_classification_stats
				SET
					views=views+1
				WHERE
					business_id=$business_id
					AND
					classification_id=$classification_id
		";
		$aff_rows = $this->myDB->exec($sql);
		if($aff_rows<1) {
			$sql = "INSERT INTO
						business_classification_stats
					(business_id, classification_id, views)
					VALUES
					($business_id, $classification_id, 1)
			";
			$this->myDB->exec($sql);
		}
	}


	//====================================================================//
	//  Count of Refine Dispaly on the basis of right panel selection     //
	//====================================================================//

	public function countkeyCategorySearch($get) {

		$ret = 0;
		$search1 		= (!empty($get['Search1']))?$get['Search1']:NULL;
		$search2 		= (!empty($get['Search2']))?$get['Search2']:NULL;
		$categoryId 	= (!empty($get['clasId']))?$get['clasId']:NULL;

		$StateSearch 	= (!empty($get['state']))?$get['state']:NULL;
		$StateSearch	= explode("__",$StateSearch);

		$shirename 		= (!empty($get['shirename']))?$get['shirename']:NULL;
		$shirename		= explode("__",$shirename);

		$shiretown 		= (!empty($get['shiretown']))?$get['shiretown']:NULL;
		$shiretown		= explode("__",$shiretown);


		if(@$StateSearch['1'] == '' && @$shirename['1'] == '' && @$shiretown['1'] == '')
		{

			$condition="(localclassification_id  ='{$categoryId}') AND (local_businesses.business_name LIKE '%".$search1."%') AND (local_businesses.business_postcode LIKE '%".$search2."%' OR local_businesses.business_suburb LIKE '%".$search2."%' OR local_businesses.business_state LIKE '%".$search2."%')";
		}else if(@$StateSearch[1] != '' && @$shirename[1] == '' && @$shiretown[1] == ''){

			$condition="(localclassification_id  ='{$categoryId}') AND (local_businesses.business_name LIKE '%".$search1."%') AND (local_businesses.business_postcode LIKE '%".$search2."%' OR local_businesses.business_suburb LIKE '%".$search2."%') AND business_state = '{$StateSearch[1]}'";
		}else if(@$StateSearch[1] != '' && @$shirename[1] != '' && @$shiretown[1] == ''){

			$condition="(localclassification_id  ='{$categoryId}') AND (local_businesses.business_name LIKE '%".$search1."%') AND (local_businesses.business_postcode LIKE '%".$search2."%' OR local_businesses.business_suburb LIKE '%".$search2."%') AND business_state = '{$StateSearch[1]}' AND shire_name = '{$shirename[1]}'";
		}else{

			$condition="(localclassification_id  ='{$categoryId}') AND (local_businesses.business_name LIKE '%".$search1."%') AND (local_businesses.business_postcode LIKE '%".$search2."%' OR local_businesses.business_suburb LIKE '%".$search2."%')AND business_state = '{$StateSearch[1]}' AND shire_name = '{$shirename[1]}' AND shire_town = '{$shiretown[1]}'";
		}


		$sql="SELECT COUNT(DISTINCT local_businesses .business_id) as cnt
			FROM business_classification,local_businesses 
			WHERE $condition AND local_businesses.expired=0 AND local_businesses.business_id=business_classification.business_id";

		$result = $this->myDB->query($sql);
		$ret = $result[0]['cnt'];
		return $ret;
	}

	//====================================================================//
	//       Refine Dispaly on the basis of right panel selection         //
	//====================================================================//

	function keyCategorySearch($fr=0, $perPage=DEFAULT_PAGING_SIZE,$get)
	{

		$search1 		= (!empty($get['Search1']))?$get['Search1']:NULL;
		$search2 		= (!empty($get['Search2']))?$get['Search2']:NULL;
		$categoryId 	= (!empty($get['clasId']))?$get['clasId']:NULL;
		$SortCondition 	= (!empty($get['sortby']))?$get['sortby']:NULL;


		$StateSearch 	= (!empty($get['state']))?$get['state']:NULL;
		$StateSearch	= explode("__",$StateSearch);

		$shirename 		= (!empty($get['shirename']))?$get['shirename']:NULL;
		$shirename		= explode("__",$shirename);

		$shiretown 		= (!empty($get['shiretown']))?$get['shiretown']:NULL;
		$shiretown		= explode("__",$shiretown);



		if($SortCondition == 'Details')
		{
			$OrderBy		="ORDER BY local_businesses.business_state ASC";
		}else if($SortCondition == 'Name'){
			$OrderBy		="ORDER BY local_businesses.business_name ASC";
		}else{
			$OrderBy		="ORDER BY business_ranks.businessrank_rank DESC";
		}

		if(@$StateSearch['1'] == '' && @$shirename['1'] == '' && @$shiretown['1'] == '')
		{

			$condition="(business_classification.localclassification_id  ='{$categoryId}') AND (local_businesses.business_name LIKE '%".$search1."%') AND (local_businesses.business_postcode LIKE '%".$search2."%' OR local_businesses.business_suburb LIKE '%".$search2."%' OR local_businesses.business_state LIKE '%".$search2."%')";
		}else if(@$StateSearch[1] != '' && @$shirename[1] == '' && @$shiretown[1] == ''){

			$condition="(business_classification.localclassification_id  ='{$categoryId}') AND (local_businesses.business_name LIKE '%".$search1."%') AND (local_businesses.business_postcode LIKE '%".$search2."%' OR local_businesses.business_suburb LIKE '%".$search2."%') AND business_state = '{$StateSearch[1]}'";
		}else if(@$StateSearch[1] != '' && @$shirename[1] != '' && @$shiretown[1] == ''){

			$condition="(business_classification.localclassification_id  ='{$categoryId}') AND (local_businesses.business_name LIKE '%".$search1."%') AND (local_businesses.business_postcode LIKE '%".$search2."%' OR local_businesses.business_suburb LIKE '%".$search2."%') AND business_state = '{$StateSearch[1]}' AND shire_name = '{$shirename[1]}'";
		}else{

			$condition="(business_classification.localclassification_id  ='{$categoryId}') AND (local_businesses.business_name LIKE '%".$search1."%') AND (local_businesses.business_postcode LIKE '%".$search2."%' OR local_businesses.business_suburb LIKE '%".$search2."%')AND business_state = '{$StateSearch[1]}' AND shire_name = '{$shirename[1]}' AND shire_town = '{$shiretown[1]}'";
		}


		/*$sql="SELECT local_businesses.business_phonestd,local_businesses.business_id,local_businesses.business_phone,
		local_businesses.business_url,local_businesses.bold_listing,local_businesses.business_street1,local_businesses.business_street2,business_classification.business_id,local_businesses.business_postcode, local_businesses.business_suburb, local_businesses.business_state,local_businesses.business_name FROM business_classification,local_businesses WHERE $condition AND local_businesses.business_id=business_classification.business_id $OrderBy LIMIT $fr,$perPage";*/

		$condition .= "	AND local_businesses.expired=0 AND
				local_businesses.business_id = business_classification.business_id";

		$sql="SELECT
				local_businesses.business_phonestd, 
				local_businesses.business_id, 
				local_businesses.business_phone, 
				local_businesses.business_url, 
				local_businesses.bold_listing, 
				local_businesses.business_street1, 
				local_businesses.business_street2, 
				business_classification.business_id, 
				local_businesses.business_postcode, 
				local_businesses.business_suburb, 
				local_businesses.business_state, 
				local_businesses.business_name,
				business_ranks.businessrank_rank
			FROM 
				(business_classification, 
				local_businesses)
				LEFT JOIN
					business_ranks on (business_ranks.business_id = local_businesses.business_id 
					AND business_ranks.localclassification_id = business_classification.localclassification_id)
						
			WHERE $condition				
				
			$OrderBy 
			LIMIT $fr,$perPage ";


		$result = $this->myDB->query($sql);

		$res['blogs'] = $result;
		$res['paging'] = Paging::numberPaging($this->countkeyCategorySearch($get), $fr, $perPage);
		return $res;
	}

	function boldListingResult($get)
	{
		$count_business_views=0;
		$sql2="SELECT * FROM site_stats";
		$res=$this->myDB->query($sql2);

		if($res[0]['count_business_views']=='')
		{
			$sql="INSERT INTO site_stats(count_business_views) VALUES('0') WHERE id=1";//prexit($sql);
			$this->myDB->query($sql);
		}
		else
		{
			$count_business_views=$res[0]['count_business_views']+1;
			$sql="UPDATE site_stats SET `count_business_views` = '$count_business_views' WHERE id=1";//prexit($sql);
			$this->myDB->query($sql);

			$search		=$get['ID'];
			$condition="business_id  ='{$search}'";
			$sql="SELECT local_businesses.business_phonestd,business_faxstd,business_fax,business_email,
					business_mobile,business_contact,client_id,local_businesses.business_phone,
					local_businesses.business_url,local_businesses.business_description,local_businesses.business_email,
					local_businesses.bold_listing,local_businesses.business_street1,local_businesses.business_street2,
					local_businesses.business_postcode, local_businesses.business_suburb,local_businesses.street1_status,
					local_businesses.street2_status,local_businesses.map_status,local_businesses.shiretown_id, 
					local_businesses.business_state,
					local_businesses.business_name,local_businesses.business_logo, local_businesses.business_image
					FROM local_businesses 
					WHERE local_businesses.expired=0 AND $condition";
			$res[0] = $this->myDB->query($sql);

			if(!empty($res)){
				$sql="SELECT * FROM multiple_addresses WHERE $condition";
				$res[1] = $this->myDB->query($sql);

				$sql="SELECT business_key_name,business_id,key_id FROM business_keyword WHERE $condition";
				$res[2] = $this->myDB->query($sql);

				$sql="SELECT business_brand_name,business_id,brand_id FROM business_brand WHERE $condition";
				$res[3] = $this->myDB->query($sql);

				$sql_classification="SELECT local_classification .localclassification_name FROM local_classification,business_classification WHERE business_classification.business_id=$search AND business_classification.localclassification_id=local_classification.localclassification_id";
				$res[5] = $this->myDB->query($sql_classification);

				/*$sql="select * from business_days,business_hours where business_days.business_id=business_hours.business_id and business_days.business_id ='{$search}' and business_hours.business_id ='{$search}'";*/
				$sql="select hour_name from business_hours where business_id ='{$search}'";
				$res[4]=$this->myDB->query($sql);
				
				
				$sql="SELECT adword_line1,adword_line2 FROM local_pages WHERE $condition";
				$res[6] = $this->myDB->query($sql);
				
				$sql="select payment_name from business_payment where business_id ='{$search}'";
				$res[7]=$this->myDB->query($sql);
				
				$sql="select business_service_name from business_service where business_id ='{$search}'";
				$res[8]=$this->myDB->query($sql);
				
				$sql="select business_description from local_businesses where business_id ='{$search}'";
				$res[9]=$this->myDB->query($sql);

			}else {
				$res[1] = '';
				$res[2] = '';
				$res[3] = '';
				$res[4] = '';
				$res[5] = '';
				$res[6] = '';
				$res[7] = '';
				$res[8] = '';
				$res[9] = '';
			}


			return $res;
		}
	}

	function locationDisplay()
	{

		$sql="SELECT localstate_id,localstate_name FROM local_state";
		$locationResult = $this->myDB->query($sql);

		return $locationResult;
	}

	function regionDisplay($state)
	{
		$sql="SELECT shirename_shirename,shirename_id FROM shire_names WHERE shirename_state ='{$state[0]}'";
		$shireNameResult = $this->myDB->query($sql);
		return $shireNameResult;
	}


	function shireTownDisplay($shirename)
	{

		$sql="SELECT shiretown_townname,shiretown_id FROM shire_towns WHERE shirename_id ='{$shirename[0]}'";
		$shireTownResult = $this->myDB->query($sql);
		return $shireTownResult;
	}

	//====================================================================//
	//            Refine Display of the left panel Area                   //
	//====================================================================//

	function refineDisplay($refineDisplay)
	{

		$SearchVal1 	= (!empty($refineDisplay['Search1']))?$refineDisplay['Search1']:NULL;
		$SearchVal2 	= (!empty($refineDisplay['Search2']))?$refineDisplay['Search2']:NULL;
		$SearchOption 	= (!empty($refineDisplay['SearchOption']))?$refineDisplay['SearchOption']:NULL;
		if($SearchOption == '1')
		{
			if($SearchVal1 != '' && $SearchVal2 == '')
			{
				$condition="business_name LIKE '%".$SearchVal1."%'";
			}else if($SearchVal1 == '' && $SearchVal2 != ''){
				$condition="business_postcode LIKE '%".$SearchVal2."%' OR  business_suburb LIKE '%".$SearchVal2."%' OR  business_state LIKE '%".$SearchVal2."%'";
			}else{
				$condition="(business_name LIKE '%".$SearchVal1."%') AND (business_postcode LIKE '%".$SearchVal2."%' OR business_suburb LIKE '%".$SearchVal2."%' OR business_state LIKE '%".$SearchVal2."%')";
			}

			$sql="SELECT COUNT(bc.localclassification_id)AS CNT, lc.localclassification_name,lc.localclassification_id
					FROM business_classification as bc, local_classification as lc 
					WHERE bc.localclassification_id=lc.localclassification_id AND (lc.localclassification_id 
					IN (SELECT DISTINCT (lc1.`localclassification_id`) 
					FROM `business_classification` AS bc1, local_classification  AS lc1, local_businesses AS lb1 
					WHERE lb1.expired=0 AND lb1.business_id=bc1.business_id AND bc1.localclassification_id=lc1.localclassification_id 
					AND ($condition))) GROUP BY (bc.localclassification_id) LIMIT 0,5";
			$refineDisplay = $this->myDB->query($sql);

			if(count($refineDisplay>0)) {
				foreach ($refineDisplay as $k=>$refineCategory) {

					$refineDisplay[$k]['link'] = $this->request->createURL("Listing", "keyCategorySearch", "Search1={$this->request->getAttribute('Search1')}&Search2={$this->request->getAttribute('Search2')}&clasId={$refineCategory['localclassification_id']}&SearchOption={$this->request->getAttribute('SearchOption')}");
				}
			}

			return $refineDisplay;
		}
	}

	public function fetchRank()
	{
		$SQL="select MAX(Rank) AS Rank from  local_businesses WHERE expired=0 limit 0, 1";
		$res=$this->myDB->query($SQL);
		return $res;

	}


	//--------------------------------
	public function fetch_hours($get)
	{
		$Business_id		=array();
		foreach($this->refineKeywordSearchArray($get) as $business_id)
		{
			$Business_id[]= $business_id['business_id'];
		}

		$fArray_hour = array();
		foreach($Business_id as $val)
		{
			$fetchKey				= "SELECT hour_id,hour_name FROM business_hours WHERE business_id ='{$val}'";

			$r					= $this->myDB->query($fetchKey);
			$i=0;
			foreach($r as $t){
				$fArray_hour[$i]['hour_name'] = $t['hour_name'];
				$fArray_hour[$i]['hour_id'] = $t['hour_id'];
				$i++;
			}
		}
		return $fArray_hour;
	}
	//-------------------------------------------
	/*public function fetch_hours()
	{
	$SQL="SELECT * FROM business_hours_name";
	$res=$this->myDB->query($SQL);
	return $res;
	}*/


	public function fetch_payment($get)
	{
		$Business_id		=array();
		foreach($this->refineKeywordSearchArray($get) as $business_id)
		{
			$Business_id[]= $business_id['business_id'];
		}

		$fArray_hour = array();
		foreach($Business_id as $val)
		{
			$fetchKey				= "SELECT payment_id,payment_name FROM business_payment WHERE business_id ='{$val}'";

			$r					    = $this->myDB->query($fetchKey);
			$i=0;
			foreach($r as $t){
				$fArray_hour[$i]['payment_name'] = $t['payment_name'];
				$fArray_hour[$i]['payment_id'] = $t['payment_id'];
				$i++;
			}
		}
		return $fArray_hour;
	}

	/*	public function fetch_payment()
	{
	$SQL="SELECT * FROM business_payment_name";
	$res=$this->myDB->query($SQL);
	return $res;
	}*/


	//--------------------------------
	public function fetch_service($get)
	{
		$Business_id		=array();
		foreach($this->refineKeywordSearchArray($get) as $business_id)
		{
			$Business_id[]= $business_id['business_id'];
		}
		//	pre($Business_id);
		$fArray = array();
		foreach($Business_id as $val)
		{
			$fetchKey				= "SELECT service_id,business_service_name FROM business_service WHERE business_id ='{$val}' GROUP BY business_service_name";

			$r					= $this->myDB->query($fetchKey);
			$i=0;
			foreach($r as $t){

				$fArray[$i]['business_service_name'] = $t['business_service_name'];
				$fArray[$i]['service_id'] = $t['service_id'];
				$i++;
			}
		}
		return $fArray;
	}
	//--------------------------------
	/*	public function fetch_service()
	{
	$SQL="SELECT * FROM business_service_name";
	$res=$this->myDB->query($SQL);
	return $res;
	}*/


	public function addlist1($post,$logo)
	{

		$initials 		= (!empty($post['initials']))?$post['initials']:NULL;
		$name 			= (!empty($post['name']))?$post['name']:NULL;
		$street1 		= (!empty($post['street1']))?$post['street1']:NULL;
		$street2 		= (!empty($post['street2']))?$post['street2']:NULL;
		$phonestd 		= (!empty($post['phonestd']))?$post['phonestd']:NULL;
		$phone 			= (!empty($post['phone']))?$post['phone']:NULL;
		$faxstd 		= (!empty($post['faxstd']))?$post['faxstd']:NULL;
		$fax 			= (!empty($post['fax']))?$post['fax']:NULL;
		$email 			= (!empty($post['email']))?$post['email']:NULL;
		$url 			= (!empty($post['url']))?$post['url']:NULL;
		$origin 		= (!empty($post['origin']))?$post['origin']:NULL;
		$mobile 		= (!empty($post['mobile']))?$post['mobile']:NULL;
		$contact 		= (!empty($post['contact']))?$post['contact']:NULL;
		$postcode 		= (!empty($post['postcode']))?$post['postcode']:NULL;
		$description 	= (!empty($post['description']))?$post['description']:NULL;
		$classification = (!empty($post['classification']))?$post['classification']:NULL;
		$state 			= (!empty($post['state']))?$post['state']:NULL;
		$listing 		= (!empty($post['listing']))?$post['listing']:NULL;
		$rank 			= (!empty($post['rank']))?$post['rank']:NULL;
		$archived 		= (!empty($post['archived']))?$post['archived']:NULL;
		$OlistID 		= (!empty($post['OlistID']))?$post['OlistID']:NULL;
		$Add1			= (!empty($_POST['Add1']))?$_POST['Add1']:0;
		$Add2			= (!empty($_POST['Add2']))?$_POST['Add2']:0;
		$Add3			= (!empty($_POST['Add3']))?$_POST['Add3']:0;

		$logoname		=$logo['logo']['name'];
		$imagename		=$logo['image']['name'];		
		
		$brand			=explode('-',$_POST['brand']);
		$suburb			=explode(',',$_POST['suburb']);
		$shire			=explode(';',$_POST['region']);

		$listingValidation =$this->__userlistingValidation($post,$logo,"add");

		if(!$listingValidation['result'])
		{
			return $listingValidation;
		}

		$queryGetShire	="SELECT shiretown_id
		 					FROM shire_towns 
							WHERE shiretown_postcode='".$postcode."' 
								AND shiretown_townname='".$suburb[1]."'";
		$shireResult	=$this->myDB->query($queryGetShire);


		$addBusiness	="INSERT INTO
		                   local_businesses(`business_initials` , `business_name` , `business_street1` , `business_street2` , `business_phonestd` , `business_phone` , `business_faxstd` , `business_fax` , `business_email` , `business_url` , `business_origin` , `business_mobile` , `business_contact` ,`client_id`, `business_postcode` , `shiretown_id` , `business_suburb`,`business_logo`,`business_image`,`business_description`,`classification`,`business_state`,`bold_listing`,`archived`,`Rank`,`shire_name`,`shire_town`,`street1_status` ,`street2_status` ,`map_status`)
                     VALUES (
'{$initials}', '{$name}', '{$street1}', '{$street2}', '{$phonestd}', '{$phone}', '{$faxstd}', '{$fax}', '{$email}', '{$url}', '{$origin}', '{$mobile}', '{$contact}',".getSession("client_id").", '{$postcode}', '{$shireResult[0]['shiretown_id']}', '{$suburb[1]}','{$logoname }','{$imagename }','{$description}','{$classification}', '{$state}','{$listing}','{$archived}','{$rank}','{$shire[1]}','{$suburb[1]}','{$Add1}','{$Add2}','{$Add3}')";//prexit($addBusiness);

		$resultAddBusiness	=$this->myDB->query($addBusiness);

		$insertedBusinessId	=$this->myDB->getInsertID($resultAddBusiness);

		if($OlistID != '')
		{
			$OlistID_sql		=" INSERT INTO `dawson_olistkey_businessid`
									(`olistkey` ,`business_id`) VALUES ('{$OlistID}', '{$insertedBusinessId}')";

			$resultOlistID		=$this->myDB->query($OlistID_sql);
		}

		$brandAddQuery		="INSERT INTO `business_brand`
								(`brand_id`,`business_id`,`business_brand_name`) 
							  VALUES 
								('{$brand[0]}','{$insertedBusinessId}','{$brand[1]}')"; 
		$this->myDB->query($brandAddQuery);


		$addBusiness=array("result"=>true, "message"=>'Business Added Successfully',"InsertID"=>$insertedBusinessId);

		return $addBusiness;
	}

	public function addClassificationDetail($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;

		foreach($post['addclassification'] as $value)
		{

			$add_classification = "INSERT INTO `business_classification` (`businessclassification_id`, `business_id`, `localclassification_id`) VALUES ('', '{$BusinessID}', '{$value}')";

			$result  =$this->myDB->query($add_classification);

		}
		$addClass=array("result"=>true, "message"=>'Classification Added Successfully',"ID"=>$BusinessID);
		return $addClass;
	}


	public function classificationList($get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;

		$list_classification	="SELECT business_classification.localclassification_id, local_classification.localclassification_name FROM business_classification,local_classification WHERE business_id='".$BusinessID."' AND business_classification.localclassification_id=local_classification.localclassification_id";
		$result					=$this->myDB->query($list_classification);
		return $result;
	}

	public function deleteClassification($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;

		foreach($post['deleteClass'] as $value)
		{

			$del_classification = "DELETE FROM `business_classification` WHERE `business_id` ='".$BusinessID."' AND `localclassification_id` = '".$value."'";

			$result  =$this->myDB->query($del_classification);

		}
		$delClass=array("result"=>true, "message"=>'Classification deleted successfully',"ID"=>$BusinessID);
		return $delClass;
	}


	public function addRank($post,$get)
	{

		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$list_classification	="SELECT business_classification.localclassification_id, local_classification.localclassification_name FROM business_classification,local_classification WHERE business_id='".$BusinessID."' AND business_classification.localclassification_id=local_classification.localclassification_id";
		$result_class					=$this->myDB->query($list_classification);

		$list_region="SELECT * FROM shire_names";
		$result_region=$this->myDB->query($list_region);


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

					$tempArray[]		=array('classification'=>$valClass['localclassification_id'],'rank'=>$rank,'region'=>$valRegion['shirename_id']);

				}
			}

		}
		//var_dump($tempArray);
		foreach($tempArray as $value)
		{
			$rankDetails		="SELECT * FROM `business_ranks` WHERE `businessrank_rank`='{$value['rank']}' AND  	`localclassification_id` ='{$value['classification']}' AND `shirename_id` = '{$value['region']}' AND business_id != {$BusinessID}";
			$rankDetails_result	=$this->myDB->query($rankDetails);
			//var_dump(count($rankDetails_result));

			if(count($rankDetails_result) > 0)
			{

				$retArray = array("result"=>false, "message"=>'This Rank is not available under this classification and region.');
				return $retArray;
				break;

			}
		}

		$deleteQuery	="DELETE FROM business_ranks WHERE `business_id` ='{$BusinessID}'";
		$this->myDB->query($deleteQuery);
		
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
										'' , '{$BusinessID}', '{$value['classification']}', '{$value['rank']}', '', '', '{$value['region']}', '', '' , '' , ".getSession("client_id").", ''
										)";
			$result_rank		=$this->myDB->query($rankQuery);

		}



		$addRank=array("result"=>true, "message"=>'rank Added Successfully',"ID"=>$BusinessID);
		//	var_dump($addRank);
		return $addRank;
	}

	public function addRank123($post,$get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$email 			= (!empty($post['email']))?$post['email']:NULL;
		$web 			= (!empty($post['web']))?$post['web']:NULL;
		$list_classification	="SELECT business_classification.localclassification_id, local_classification.localclassification_name FROM business_classification,local_classification WHERE business_id='".$BusinessID."' AND business_classification.localclassification_id=local_classification.localclassification_id";
		$result_class					=$this->myDB->query($list_classification);

		$list_region="SELECT * FROM shire_names";
		$result_region=$this->myDB->query($list_region);

		foreach($result_region as $valRegion)
		{
			foreach($result_class as $valClass)
			{

				$key = $valRegion['shirename_id']."_".$valClass['localclassification_id'];




				if(isset($post[$key]) && !empty($post[$key]))
				{
					$rank = $post[$key];

					$deleteQuery	="DELETE FROM business_ranks WHERE `business_id` ='{$BusinessID}' AND `localclassification_id`='{$valClass['localclassification_id']}' AND `shirename_id`='{$valRegion['shirename_id']}'";
					$this->myDB->query($deleteQuery);

					$rankQuery      ="INSERT INTO `business_ranks` (
										`businessrank_id` ,
										`business_id` ,
										`localclassification_id` ,
										`businessrank_rank` ,
										`shirename_id` ,
										`businessrank_cost` ,
										`businessrank_timestamp` ,
										`businessrank_expire` ,
										`user_id` ,
										`businessrank_tempfield`
										)
										VALUES (
										'' , '{$BusinessID}', '{$valClass['localclassification_id']}', '{$rank}', '{$valRegion['shirename_id']}', '', '' , '' , ".getSession("client_id").", ''
										)";
					$result_rank		=$this->myDB->query($rankQuery);
				}
			}

		}

		$addRank=array("result"=>true, "message"=>'Rank added successfully',"ID"=>$BusinessID);
		return $addRank;
	}

	public function rankDetails($get)
	{
		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$rank_query		="SELECT * FROM business_ranks WHERE business_id={$BusinessID}";
		$rank_list		=$this->myDB->query($rank_query);
		return $rank_list;
	}


	private function __userlistingValidation(&$data,&$logo,$val)
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

		if(empty($data['description']))
		{
			$errors[] = "description is blank!!";
		}

		if($val == 'add')
		{
			if(empty($logo['logo']['name']))
			{
				$errors[] = "Please Select any Logo!!";
			}
		}

		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}














	public function addlist($post,$logo)
	{


		$initials 		= (!empty($post['initials']))?$post['initials']:NULL;
		$name 			= (!empty($post['name']))?$post['name']:NULL;
		$street1 		= (!empty($post['street1']))?$post['street1']:NULL;
		$street2 		= (!empty($post['street2']))?$post['street2']:NULL;
		$phonestd 		= (!empty($post['phonestd']))?$post['phonestd']:NULL;
		$phone 			= (!empty($post['phone']))?$post['phone']:NULL;
		$faxstd 		= (!empty($post['faxstd']))?$post['faxstd']:NULL;
		$fax 			= (!empty($post['fax']))?$post['fax']:NULL;
		$email 			= (!empty($post['email']))?$post['email']:NULL;
		$url 			= (!empty($post['url']))?$post['url']:NULL;
		$origin 		= (!empty($post['origin']))?$post['origin']:NULL;
		$mobile 		= (!empty($post['mobile']))?$post['mobile']:NULL;
		$contact 		= (!empty($post['contact']))?$post['contact']:NULL;
		$postcode 		= (!empty($post['postcode']))?$post['postcode']:NULL;
		$description 	= (!empty($post['description']))?$post['description']:NULL;
		$classification = (!empty($post['classification']))?$post['classification']:NULL;
		$state 			= (!empty($post['state']))?$post['state']:NULL;
		$listing 		= (!empty($post['listing']))?$post['listing']:NULL;
		$rank 			= (!empty($post['rank']))?$post['rank']:NULL;

		$sql="SELECT localclassification_id FROM  local_classification  WHERE localclassification_name='".$post['classification']."'";
		$clasid=$this->myDB->query($sql);

		$logoname=$logo['logo']['name'];
		$shire=explode(';',$_POST['region']);

		$res12 =$this->__userRegisterValidation($post);

		if(!$res12['result'])
		{
			return $res12;
		}

		if($logoname=='')
		{
			$retArray = array("result"=>false, "message"=>'Please select your logo');
			return $retArray;

		}

		/* $SQL2="SELECT * FROM local_businesses WHERE business_email='".$post['email']."'";
		$result=$this->myDB->query($SQL2);*/

		if($post['listing'] =='1')
		{
			$CHECK_RANK			="SELECT * FROM local_businesses
								WHERE expired=0 
								AND classification='{$post['classification']}' 
								AND shire_name='{$shire['1']}' AND Rank='{$post['rank']}'";

			$CHECK_RANK_RESULT	=$this->myDB->query($CHECK_RANK);
		}

		/*if(count($result)>0)
		{
		$retArray = array("result"=>false, "message"=>'Email Already Exists!! please try some other name');
		return $retArray;
		}*/
		if(count(@$CHECK_RANK_RESULT) > '0')
		{
			$retArray = array("result"=>false, "message"=>'This rank is not available under this classification and region.');
			return $retArray;
		}
		else
		{
			$sub=explode(',',$_POST['suburb']);

			$SQL2="SELECT
			             shiretown_id 
			       FROM 
				         shire_towns 
				   WHERE
				         shiretown_postcode='".$post['postcode']."' 
						 AND
						    shiretown_townname='".$sub[1]."'";
			$rec=$this->myDB->query($SQL2);

			$shire=explode(';',$_POST['region']);


			$SQL="INSERT INTO
		                   local_businesses( `business_initials` , `business_name` , `business_street1` , `business_street2` , `business_phonestd` , `business_phone` , `business_faxstd` , `business_fax` , `business_email` , `business_url` , `business_origin` , `business_mobile` , `business_contact` ,`client_id`, `business_postcode` , `shiretown_id` , `business_suburb`,`business_logo`,`business_description`,`classification`,`business_state`,`bold_listing`,`Rank`,`shire_name`,`shire_town`)
						   
						   VALUES (
'{$initials}', '{$name}', '{$street1}', '{$street2}', '{$phonestd}', '{$phone}', '{$faxstd}', '{$fax}', '{$email}', '{$url}', '{$origin}', '{$mobile}', '{$contact}',".getSession("client_id").", '{$postcode}', '{$rec[0]['shiretown_id']}', '{$sub[1]}','{$logoname }','{$description}','{$classification}', '{$state}','{$listing}','{$rank}','{$shire[1]}','{$sub[1]}')";



			$res=$this->myDB->query($SQL);
			$busiId=$this->myDB->getInsertID($res);

			$sql = "INSERT INTO `business_classification` (`businessclassification_id`, `business_id`, `localclassification_id`) VALUES ('', '{$busiId}', '{$clasid[0]['localclassification_id']}')";

			$this->myDB->query($sql);

			$INSERT_RANK	="INSERT INTO `rank_allocation` (
										`rank_id` ,
										`classification_name` ,
										`region_name` ,
										`client_id` ,
										`rank`
										)
										VALUES (
										NULL , '{$post['classification']}', '{$shire['1']}', ".getSession("client_id").", '{$post['rank']}'
										)";
			$this->myDB->query($INSERT_RANK);

			$rec=array("result"=>true, "message"=>'Added successfully',"InsertID"=>$busiId);
			return $rec;
		}
	}


	public function updateAdd($post)
	{
		$ID=$_GET['ID'];//prexit($ID);
		$SQL="UPDATE local_businesses SET Rank={$post['rank']} WHERE business_id={$ID}";
		$this->myDB->query($SQL);
		$rec=array("result"=>true, "message"=>'Added successfully');
		return $rec;
	}

	public function fetchRegion()
	{
		$SQL="SELECT
		            *
			  FROM
			        shire_names";
		$rec=$this->myDB->query($SQL);
		return $rec;
	}

	public function getSuburb($get)
	{
		$SQL="SELECT
		*
		FROM
		shire_towns
		WHERE shirename_id='{$get['ID']}'";
		$rec=$this->myDB->query($SQL);
		return $rec;
	}



	public function selectStates()
	{
		$sql="SELECT * FROM local_state";
		$res=$this->myDB->query($sql);
		return $res;
	}

	public function fetchRankRate()
	{
		$SQL="SELECT
		            *
			  FROM
			         rank_rate";
		$rec=$this->myDB->query($SQL);
		return $rec;
	}

	private function __userRegisterValidation(&$data)
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
			$errors[] = "description is blank!!";
		}
		if(empty($data['phone'])||!preg_match("/^[0-9]+$/",$data['phone'])) {
			$data['phone']=NULL;
			$errors[] = "phone is blank!!or not valid";
		}
		if(empty($data['phonestd'])||!preg_match("/^[0-9]+$/",$data['phonestd'])) {
			$data['phone']=NULL;
			$errors[] = "phonestd is blank!!or not valid";
		}
		if(empty($data['faxstd'])||!preg_match("/^[0-9]+$/",$data['faxstd'])) {
			$errors[] = "faxstd is blank!!or not valid";
		}
		if(empty($data['fax'])||!preg_match("/^[0-9]+$/",$data['fax'])) {
			$errors[] = "fax is blank!!or not valid";
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


		if(empty($data['contact'])||!preg_match("/^[0-9]+$/",$data['contact'])) {
			$errors[] = "contact is blank!!or not valid";
		}

		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}

	public function fetchTownDetails()
	{
		$sql="select * from shire_towns";
		$rec=$this->myDB->query($sql);
		return $rec;
	}

	public function viewfetchDetails($fr=0, $perPage=DEFAULT_PAGING_SIZE)
	{
		$this->myDB->addWhere("client_id='".getSession("client_id")."'");
		$this->myDB->setOrder("business_id DESC");
		$res=$this->myDB->getAll($fr, $perPage);
		$SQL="SELECT count(business_id) AS cnt
			FROM local_businesses 
			WHERE expired=0
			AND client_id='".getSession("client_id")."' ";
		$count_all = $this->myDB->query($SQL);
		$retArray['listings'] = $res;
		$retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $perPage);
		return $retArray;
	}

	public function fetchClassificationDetails()
	{
		$sql="SELECT * FROM local_classification";
		$rec=$this->myDB->query($sql);//prexit($rec);
		return $rec;
	}

	public function fetchDetails($post,$fr=0, $perPage=DEFAULT_PAGING_SIZE)
	{
		$this->myDB->addWhere("client_id='".getSession("client_id")."'");
		$res=$this->myDB->getAll();//prexit($res);
		return $res;
	}



	public function editListingFetchDetails()
	{
		$rec=$this->fetchTownDetails();

		$condition = $_GET['ID'];

		//	$sql="SELECT * FROM local_businesses AS LB,shire_towns AS ST WHERE ST.shiretown_id=".$rec[0]['shiretown_id']." AND LB.business_id=$condition ";//prexit($sql);

		//	$this->myDB->

		//	$res=$this->myDB->query($sql);//prexit($res);

		$res = $this->myDB->get($condition);
		return $res;
	}

	/*public function editListingFetchDetails()
	{
	$rec=$this->fetchTownDetails();
	$region=$this->fetchRegion();
	$condition = $_GET['ID'];
	$SQL="SELECT
	*
	FROM
	local_businesses AS LB,
	shire_towns AS ST
	WHERE LB.business_id=$condition
	AND
	ST.shiretown_id=".$rec[0]['shiretown_id']."
	";
	$res=$this->myDB->query($SQL);
	return $res;

	}*/


	public function editListing($post,$file)
	{
		$archived 	= (!empty($post['archived']))?$post['archived']:NULL;
		$image	=$file['logo']['name'];
		$shire	=explode(',',$_POST['region']);
		$sub	=explode(',',$_POST['suburb']);
		$Add1		= (!empty($_POST['Add1']))?$_POST['Add1']:0;
		$Add2		= (!empty($_POST['Add2']))?$_POST['Add2']:0;
		$Add3		= (!empty($_POST['Add3']))?$_POST['Add3']:0;
		$brand		= (!empty($_POST['brand']))?$_POST['brand']:0;
		$brand		= explode('-',$brand);
		// $listing 		= (!empty($post['listing']))?$post['listing']:0;

		$result =$this->__userlistValidation($post,$file,"edit");
		if(!$result['result'])
		{
			return $result;
		}


		$sql2="select shiretown_id from shire_towns where shiretown_postcode='".$sub[0]."' AND                  shiretown_townname='".$sub[1]."'";
		$rec=$this->myDB->query($sql2);

		$ID				=$_GET['ID'];
		$condition     	=$ID;
		$desc			=$post['description'];

		if(@$image=='')
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
			'shire_name'=>$shire[1],
			'business_description'=>$post['description'],
			'shire_town'=>$sub[1],
			'bold_listing'=>'0',
			//'bold_listing'=>$post['listing'],
			'archived'=>$post['archived'],
			'street1_status'=>$Add1,
			'street2_status'=>$Add2,
			'map_status'=>$Add3,
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
			'shire_name'=>$shire[1],
			'shire_town'=>$sub[1],
			'business_logo'=>$image ,
			'business_description'=>$post['description'],
			'bold_listing'=>'0',
			//'bold_listing'=>$post['listing'],
			'archived'=>$post['archived'],
			'street1_status'=>$Add1,
			'street2_status'=>$Add2,
			'map_status'=>$Add3,
			'business_state'=>$post['state']);
		}

		$this->myDB->setWhere("business_id=$condition") ;
		$val=$this->myDB->update($sql);

		$updateBrand			="UPDATE business_brand
											SET
												brand_id='{$brand[0]}',
												business_brand_name='{$brand[1]}'
											WHERE business_id=$condition"; 
		$this->myDB->query($updateBrand);

		$Array = array("result"=>true, "message"=>'Updated successfully');
		return $Array;

	}

	private function __userlistValidation(&$data)
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
		$this->myDB->remove($condition);
		$Array = array("result"=>true, "message"=>'Deleted successfully');
		return $Array;
	}


	public function googleMapViewResult($get)
	{
		$rank 					= (!empty($get['rank']))?$get['rank']:NULL;
		$businessid 			= (!empty($get['businessId']))?$get['businessId']:NULL;


		$map 					= new GoogleMap('map');
		$map->setHeight('405px');
		$map->setWidth('700px');


		$sql					= "SELECT *
									FROM local_businesses 
									WHERE local_businesses.expired=0 
									AND business_id={$businessid}";

		$result 				= $this->myDB->query($sql);
		$name 					= $result['0']['business_name'];
		
		$values					= $this->request->createURL("Listing","boldListing","ID={$businessid}");

		if($result['0']['business_street1'] != '')
		{
			$mapAddress			= "{$result['0']['business_street1']} {$result['0']['business_suburb']} {$result['0']['business_state']} {$result['0']['business_postcode']}";

		}else{

			$mapAddress			= "{$result['0']['business_suburb']} {$result['0']['business_state']} {$result['0']['business_postcode']}";

		}

		/*if($rank =='1' || $rank =='2' || $rank =='3' || $rank =='4' || $rank =='5')
		{
		$map->addMarkerByAddress($mapAddress ,$name,"<b><u><a href={$values} target=_new><font color='#FF0000'>$name</font></a></u></b>");
		}
		elseif($rank == '6' ||$rank == '7' ||$rank == '8' ||$rank == '9' ||$rank == '10' ||$rank == '11')
		{
		$map->addMarkerByAddress($mapAddress ,$name,"<b><u><a href={$values} target=_new>$name</a></u></b>");
		}
		else{
		$map->addMarkerByAddress($mapAddress ,$name,"<b>$name</b>");
		}*/

		$map->addMarkerByAddress($mapAddress ,$name,"<font size='2px'><b>$name</b></font>");
		return $map;
	}

	public function googleMapBusinessResult($get)
	{
		$businessid 			= (!empty($get['ID']))?$get['ID']:NULL;
		$map 					= new GoogleMap('map');
		$map->setHeight('400px');
		$map->setWidth('430px');
		//$map->disableMapControls();
		$map->setControlSize 	= 'small';

		$sql					= "SELECT *
									FROM local_businesses 
									WHERE local_businesses.expired=0 
									AND business_id={$businessid}";

		$result 				= $this->myDB->query($sql);

		$_SESSION['BID']=$businessid; 
		
		if($result['0']['business_street1'] != '')
		{
			$mapAddress			= "{$result['0']['business_street1']} {$result['0']['business_suburb']} {$result['0']['business_state']} {$result['0']['business_postcode']}";
		}else{
			$mapAddress			= "{$result['0']['business_suburb']} {$result['0']['business_state']} {$result['0']['business_postcode']}";
		}
		$map->addMarkerByAddress($mapAddress ,$result['0']['business_name'],"<b>{$result[0]['business_name']}</b>");

		return $map;
	}


	public function getBusinessDetails($get)
	{
		$businessid 	= (!empty($get['businessId']))?$get['businessId']:NULL;
		$sql="SELECT *
					FROM local_businesses 
					WHERE local_businesses.expired=0 
					AND business_id={$businessid}";
		$result = $this->myDB->query($sql);
		return $result;
	}

	public function mapSearchResultCount($get) {

		$ret = 0;
		$Search1 		= (!empty($get['Search1']))?$get['Search1']:NULL;
		$Search2 		= (!empty($get['Search2']))?$get['Search2']:NULL;

		$Search1 = $this->myDb->quote($Search1);
		$Search2 = $this->myDb->quote($Search2);

		$condition=" expired=0 AND (business_name LIKE '%".$Search1."%') AND (business_postcode LIKE '%".$Search2."%' OR business_suburb LIKE '%".$Search2."%' OR business_state LIKE '%".$Search2."%')";

		$this->myDB->setWhere($condition);
		$this->myDB->setSelect("count(local_businesses.business_id) as cnt");
		$result = $this->myDB->getAll();

		$ret = $result[0]['cnt'];
		return $ret;
	}


	public function mapSearchResult($fr=0, $perPage=DEFAULT_PAGING_SIZE,$get)
	{
		$retArray = array();


		$Search1 		= (!empty($get['Search1']))?$get['Search1']:NULL;
		$Search2 		= (!empty($get['Search2']))?$get['Search2']:NULL;

		$map = new GoogleMap('map');
		$map->setHeight('400px');
		$map->setWidth('600px');

		/*$condition="(business_name LIKE '%".$Search1."%') AND (business_postcode LIKE '%".$Search2."%' OR business_suburb LIKE '%".$Search2."%' OR business_state LIKE '%".$Search2."%')";

		$sql="SELECT business_name,business_id, business_postcode, business_suburb, business_state,business_phonestd,business_phone,business_url,bold_listing,business_street1,business_street2,Rank FROM local_businesses WHERE $condition LIMIT $fr,$perPage";*/
		//		$result = $this->myDB->query($sql);
		$res = $this->SearchResult($fr, $perPage, $get);
		$result = $res['blogs'];
		//pre($result1);
		//prexit($result);

		if(count($result) > 0)
		{
			$temp ='';
			$values ='';
			foreach($result as $val) {
				$values=$this->request->createURL("Listing","boldListing","ID={$val['business_id']}");
				$temp = "{$val['business_street1']} {$val['business_suburb']} {$val['business_state']} {$val['business_postcode']}";
				$name	="{$val['business_name']}";
				if($val['businessrank_rank'] >=1 && $val['businessrank_rank'] <=5) {
					//					echo $val['business_id'].pre($temp);
					$map->addMarkerByAddress($temp ,"<b>".$name."</b>","<b><u><a href={$values} target=_new><font color='#FF0000'>$name</font></a></u></b>");
				}
				else {
					$map->addMarkerByAddress($temp ,$name,"<b>$name</b>");
				}
			}
		}
		else
		{
			$failed_searches=0;
			$sql="select * from site_stats";
			$res=$this->myDB->query($sql);
			if($res[0]['failed_searches']=='')
			{
				$sql="INSERT INTO site_stats('failed_searches') VALUES('0') WHERE id=1";
				$this->myDB->query($sql);
			}
			else
			{
				$failed_searches=$res[0]['failed_searches']+1;
				$SQL="UPDATE site_stats SET failed_searches='{$failed_searches}' WHERE id=1";
				$this->myDB->query($SQL);
				if($Search1!='' && $Search2=='')
				{
					$date=date("Y-m-d,H:m:s");
					$sql = "INSERT INTO `failed_searches` (`searchid`, `search_date`, `search_type`, `search_term`, `businessname`, `suburb`, `street`, `regionid`) VALUES (NULL, '{$date}', 'Business Name ', '{$Search1}', NULL, NULL, NULL, NULL)";
					$this->myDB->query($sql);
				}
			}
		}

		$retArray['map'] = $map;
		$retArray['paging'] = Paging::numberPaging($this->mapSearchResultCount($get), $fr, $perPage);
		return $retArray;
	}

	public function browseCategoryResultCount($post) {

		$ret = 0;
		$searchValue 		= (!empty($post['search']))?$post['search']:NULL;
		$condition="local_classification.localclassification_name LIKE '".$searchValue."%'";

		$sql="SELECT COUNT(DISTINCT lc .localclassification_id) as cnt FROM business_classification as bc, local_classification as lc WHERE bc.localclassification_id=lc.localclassification_id AND (lc.localclassification_id IN (SELECT `localclassification_id` FROM `local_classification` WHERE $condition))";
		$result = $this->myDB->query($sql);
		$ret = $result[0]['cnt'];
		return $ret;
	}


	public function browseCategoryResult($post)
	{

		$searchValue 		= (!empty($post['search']))?$post['search']:NULL;


		$condition="local_classification.localclassification_name LIKE '".$searchValue."%'";

		$sql="SELECT
                        COUNT(bc.localclassification_id)AS count_localclassification_name, 
                        lc.localclassification_name,lc.localclassification_id 
                      FROM 
                        business_classification as bc, 
                        local_classification as lc 
                      WHERE 
                        bc.localclassification_id=lc.localclassification_id 
                        AND 
                        (lc.localclassification_id 
                            IN 
                                (SELECT 
                                    `localclassification_id` 
                                 FROM `local_classification` 
                                 WHERE 
                                    $condition)
                         )
                      GROUP BY
                        (lc.localclassification_name)
                      ";


		$bcResult = $this->myDB->query($sql);

		if(count($bcResult>0)) {
			foreach ($bcResult as $k=>$category) {
				$bcResult[$k]['link'] = $this->request->createURL("Listing", "categorySearch", "search={$category['localclassification_id']}&category=".urlencode($category['localclassification_name'])."&val={$this->request->getAttribute('Search2')}");
			}
		}




		/*$res['blogs'] = $bcResult;
		$res['paging'] = Paging::numberPaging($this->browseCategoryResultCount($post), $fr, $perPage);
		return $res;*/
		return $bcResult;
	}

	public function searchConut()
	{
		$SearchCounter='';
		$ip				= $_SERVER['REMOTE_ADDR'];
		$SEARCH_QUERY	= "SELECT search_IP,count FROM search_stats WHERE search_IP='{$ip}'";
		$seachResult = $this->myDB->query($SEARCH_QUERY);

		$Count			=count($seachResult);

		$SearchCounter	= (isset($seachResult[0]['count'])) ? $seachResult[0]['count'] + 1 : $SearchCounter + 1;

		if($Count==0)
		{
			$SEARCH_INSERT	= "INSERT INTO search_stats (
								`search_id` ,
								`search_IP` ,
								`count`
								)
								VALUES (
								'' , '$ip', '1'
								)";
			$this->myDB->query($SEARCH_INSERT);
		}else{
			$SEARCH_UPDATE	= "UPDATE search_stats SET `count` = '$SearchCounter' WHERE `search_IP` ='$ip'";
			$this->myDB->query($SEARCH_UPDATE);
		}

	}

	public function popularPageCount($page_id)
	{
		$PAGE_DETAIL_QUERY	="SELECT * FROM page_details WHERE page_id='$page_id'";
		$PAGE_DETAIL_RESULT	=$this->myDB->query($PAGE_DETAIL_QUERY);

		$homePageCount		=$PAGE_DETAIL_RESULT['0']['count']+1;

		$update_query	="UPDATE page_details SET `count` = '$homePageCount' WHERE page_id='$page_id'";
		$this->myDB->query($update_query);

		$date=date('Y-m-d');
		$select_page_stats="SELECT page_id,views FROM page_stats WHERE page_id='$page_id'";
		$views=$this->myDB->query($select_page_stats);
		if(count($views)==0)
		{
			$page_views=@$views[0]['views']+1;
			$insert_page_stats= "INSERT
							  INTO `page_stats` (`id`,`page_id`,`datereport`,`views`)
							  VALUES (NULL,'{$page_id}','{$date}','{$page_views}')"; 
			// prexit($insert_page_stats);
			$this->myDB->query($insert_page_stats);
		}
		else
		{
			$page_views=$views[0]['views']+1;
			$update_page_stats= "UPDATE page_stats SET views ='$page_views' WHERE page_id='$page_id' AND datereport ='$date'";
			//prexit($update_page_stats);
			$this->myDB->query($update_page_stats);
		}

	}

	public function addRegionClassificationViews($region_id, $classification_id) {
		
		$region_id = ($region_id)?$region_id:59;//taking region All Sydney in case of NULL region_id
		$agent_user = $_SERVER['HTTP_USER_AGENT'];
		$date=date('Y-m-d');

		$cut_word=null;$cut_word2=null;
		$cut_word  = strstr($agent_user, 'google');
		$cut_word2 = strstr($agent_user, 'bing');

		/*sanjeewa 14/09/2011/ & 15/09/2011 - store google & bing views seperate field */
		$google=0; 

		if ($cut_word != null || $cut_word2 != null) {
		    $google=1;
		} 
		
		$sql = "UPDATE
				region_classification_stats
			SET
				views=views+1,google_views=google_views+$google
			WHERE
				region_id=$region_id 
				AND
				classification_id=$classification_id
				AND
				view_date='$date'
			";
			
		$aff_recs = $this->myDB->exec($sql);
		if($aff_recs<1) {
			$sql = "INSERT INTO
						region_classification_stats
						(region_id, classification_id, views, user_agent, view_date, google_views)
					VALUES
						($region_id, $classification_id, 1, '$agent_user', '$date', $google)";
			
			$this->myDB->exec($sql);
		}

		/*sanjeewa - 1609 temporary*/
		$sql = "INSERT INTO user_agents (iduser_agents) VALUES ('$agent_user')";
		$this->myDB->exec($sql);
	}

	public function categorySearchCount($get)
	{
		$ip						= $_SERVER['REMOTE_ADDR'];
		$classification_id		= $get['search'];
		$classification_name	= $get['category'];
		$SearchCounter			='';
		$IPCount				='';
		$unique_visits			='';
		$TotalVisits			='';
		$seachResult			='';
		$date					='';

		$SEARCH_IP	= "SELECT * FROM classification_stats_ip WHERE IP='$ip' AND classification_id='$classification_id'";
		$seachResultIP = $this->myDB->query($SEARCH_IP);

		$IPCount		=count($seachResultIP);
		if($IPCount==0)
		{

			$IP_INSERT			="INSERT INTO classification_stats_ip (
								`stat_id` ,
								`classification_id` ,
								`IP`
								)
								VALUES (
								NULL , '$classification_id', '$ip'
								)";
			$this->myDB->query($IP_INSERT);

			$SEARCH_QUERY	= "SELECT total_vists, unique_visits FROM classification_stats WHERE classification_id='$classification_id'";
			@$seachResult = $this->myDB->query($SEARCH_QUERY);

			$Count			=count($seachResult);

			@$TotalVisits	=$seachResult['0']['total_vists']+1;
			@$unique_visits	=$seachResult['0']['unique_visits']+1;
			if($Count==0)
			{
				$SEARCH_INSERT	= "INSERT INTO classification_stats (
										`stat_id` ,
										`classification_id` ,
										`classification_name`,
										`total_vists`,
										`unique_visits`
										)
										VALUES (
										'' , '$classification_id','$classification_name','1', '1'
										)";
				$this->myDB->query($SEARCH_INSERT);

				$date=date('Y-m-d');
				$insert_stat_datewise ="INSERT INTO classification_stats_datewise (
										`id` ,
										`classification_id` ,
										`classification_name`,
										`total_visits`,
										`unique_visits`,
										`datereport`
										)
										VALUES (
										'' , '$classification_id','$classification_name','1', '1','$date'
										)";
				$this->myDB->query($insert_stat_datewise);
			}else{
				$SEARCH_UPDATE	= "UPDATE classification_stats SET `total_vists` = '$TotalVisits', `unique_visits` = '$unique_visits' WHERE `classification_id`='$classification_id'";
				$this->myDB->query($SEARCH_UPDATE);


				$select_stats_datewise="SELECT * FROM classification_stats_datewise WHERE datereport='$date'";
				$records=$this->myDB->query($select_stats_datewise);
				if(count($records)==0)
				{
					$insert_stat_datewise ="INSERT INTO classification_stats_datewise (
											`id` ,
											`classification_id` ,
											`classification_name`,
											`total_visits`,
											`unique_visits`,
											`datereport`
											)
											VALUES (
											NULL , '$classification_id','$classification_name','1', '1','$date'
											)";
					$this->myDB->query($insert_stat_datewise);
				}
				else
				{
					$SEARCH_QUERY1	= "SELECT total_visits, unique_visits FROM classification_stats_datewise WHERE classification_id='$classification_id'";
					$seachResult1 = $this->myDB->query($SEARCH_QUERY1);
					$TotalVisits1	=$seachResult1['0']['total_visits']+1;
					$unique_visits1	=$seachResult1['0']['unique_visits']+1;
					$update_stat_datewise="UPDATE classification_stats_datewise SET `total_visits` = '$TotalVisits1', `unique_visits` = '$unique_visits1' WHERE `classification_id`='$classification_id'";
					$this->myDB->query($update_stat_datewise);
				}
			}
		}else{
			$SEARCH_QUERY	= "SELECT total_vists, unique_visits FROM classification_stats WHERE classification_id='$classification_id'";
			$seachResult = $this->myDB->query($SEARCH_QUERY);
			$TotalVisits	=$seachResult['0']['total_vists']+1;
			$unique_visits	=$seachResult['0']['unique_visits']+1;

			$SEARCH_UPDATE	= "UPDATE classification_stats SET `total_vists` = '$TotalVisits' WHERE `classification_id`='$classification_id'";
			$this->myDB->query($SEARCH_UPDATE);

			$date=date('Y-m-d');
			$select_stats_datewise="SELECT * FROM classification_stats_datewise WHERE datereport='$date' AND classification_id='$classification_id'";
			$records=$this->myDB->query($select_stats_datewise);
			if(count($records)==0)
			{
				$insert_stat_datewise ="INSERT INTO classification_stats_datewise (
										`id` ,
										`classification_id` ,
										`classification_name`,
										`total_visits`,
										`unique_visits`,
										`datereport`
										)
										VALUES (
										NULL , '$classification_id','$classification_name','1', '1','$date'
										)";//prexit($insert_stat_datewise);
				$this->myDB->query($insert_stat_datewise);
			}
			else
			{
				$SEARCH_QUERY1	= "SELECT total_visits, unique_visits FROM classification_stats_datewise WHERE classification_id='$classification_id' and datereport='$date'";
				$seachResult1 = $this->myDB->query($SEARCH_QUERY1);
				$TotalVisits1	=@$seachResult1['0']['total_visits']+1;
				$unique_visits1	=@$seachResult1['0']['unique_visits']+1;
				$update_stat_datewise	= "UPDATE classification_stats_datewise SET `total_visits` = '$TotalVisits1' WHERE `classification_id`='$classification_id' and datereport='$date'";
				$this->myDB->query($update_stat_datewise);
			}
		}
	}
	
	public function getMarket() {
	
	  $marketID = null;
	  
	  if(isset($_GET['shire_town'])){
	    $marketID = $this->getMarketFromSuburb($_GET['shire_town']);
	  } else if(isset($_GET['shire_name'])){
	    $marketID = $this->getMarketFromRegion($_GET['shire_name']);
	  } else if(isset($_GET['search2'])){
	    $marketID = $this->getMarketFromLocation($_GET['search2']);
	  }
	  
      $marketID = (isset($marketID[0]['market_id'])) ? $marketID[0]['market_id'] : 1;
	  
	  return $marketID;
	  
	}
	
    public function getMarketFromSuburb($shire_town){
	
	  $suburb = mysql_escape_string(strtoupper(urldecode($shire_town)));
	
	  $sql = "select ms.market_id
               from shire_towns st, markets_to_shires ms
              where st.shiretown_townname = '".$suburb."'
                and st.shirename_id = ms.shirename_id";				
				
	  $marketID = $this->myDB->query($sql);

      return $marketID;					
	}
	
	public function getMarketFromRegion($shire_name){
	  $region = mysql_escape_string(strtoupper(urldecode($shire_name)));
	  
	  $sql = "select *
                from shire_names sn, markets_to_shires ms
               where sn.shirename_shirename = '".$region."'
                 and sn.shirename_id = ms.shirename_id";

	  $marketID = $this->myDB->query($sql);

      return $marketID;									       				 
	}
	
	public function getMarketFromLocation($search2){
      $region = mysql_escape_string(strtoupper(urldecode($search2)));
	  
	  $sql = "select *
                from shire_names sn, markets_to_shires ms
               where sn.shirename_shirename = '".$region."'
                 and sn.shirename_id = ms.shirename_id";
				
	  $marketID = $this->myDB->query($sql);  	  	  	 	  
	  
	  return $marketID;
	}
	
	
	/**
		* @desc This function will be used for getting the banner and place where it had to be pasted. 
		* @return mixed Return true if banner fetching was successfull or false if failure.
		*/			
	public function getBanner($pageID)
	{

		$classificationID 		= (!empty($_GET['shire_town']))?$_GET['shire_town']:NULL;
		$condition				= "banner_page={$pageID} AND status='1' AND localclassification_id='{$classificationID}'";
		$QUERY					= "SELECT * FROM banner WHERE $condition";
		$result					= $this->myDB->query($QUERY);

		return $result;
	}
	
	/**
		* @desc This function will be used for to insert a record whenever a particular banner is viewed
		* @return void.
		*/				
	private function setBannerImpression($businessID, $position, $classificationID, $marketID){
				
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
		* @desc This function will be used for getting the banner and place where it had to be pasted. 
		* @return mixed Return true if banner fetching was successfull or false if failure.
		*/			
	public function getBannerA($pageID)
	{
		$classificationID 		= (!empty($_GET['search'])) ? $_GET['search'] : NULL;	
						
		$marketID  = $this->getMarket();		
							
	    if(isset($marketID)){
		  $condition				= "banner_page={$pageID} AND status='1' AND localclassification_id='{$classificationID}' AND position='A' AND market_id = {$marketID} AND DATE(Now()) between DATE(add_date) AND DATE(expiry_date)";		  
		} else { 
	      $condition				= "banner_page={$pageID} AND status='1' AND localclassification_id='{$classificationID}' AND position='A'";		  
		}

		$QUERY					= "SELECT * FROM banner WHERE $condition";					
				
		$result					= $this->myDB->query($QUERY);
		
		if(isset($result[0])){		  
		  $businessID = $result[0]['business_id'];
		  $this->setBannerImpression($businessID, 'A', $classificationID, $marketID);
		}
				
		return $result;
	}

	public function getBannerB($pageID)
	{
		$classificationID 		= (!empty($_GET['search'])) ? $_GET['search'] : NULL;	
	
		$marketID  = $this->getMarket();		
					
	    if(isset($marketID)){
		  $condition				= "banner_page={$pageID} AND status='1' AND localclassification_id='{$classificationID}' AND position='B' AND market_id = {$marketID} AND DATE(Now()) between DATE(add_date) AND DATE(expiry_date)";		  
		} else { 
	      $condition				= "banner_page={$pageID} AND status='1' AND localclassification_id='{$classificationID}' AND position='B'";		  
		}
		
		//$condition				= "banner_page={$pageID} AND status='1' AND localclassification_id='{$classificationID}' AND position='B'";
		$QUERY					= "SELECT * FROM banner WHERE $condition";
		$result					= $this->myDB->query($QUERY);
		
		if(isset($result[0])){		  
		  $businessID = $result[0]['business_id'];
		  $this->setBannerImpression($businessID, 'B', $classificationID, $marketID);
		}		

		return $result;
	}

	public function getBannerC($pageID)
	{
		$classificationID 		= (!empty($_GET['search'])) ? $_GET['search'] : NULL;	
	
		$marketID  = $this->getMarket();		
					
	    if(isset($marketID)){
		  $condition				= "banner_page={$pageID} AND status='1' AND localclassification_id='{$classificationID}' AND position='C' AND market_id = {$marketID} AND DATE(Now()) between DATE(add_date) AND DATE(expiry_date)";		  
		} else { 
	      $condition				= "banner_page={$pageID} AND status='1' AND localclassification_id='{$classificationID}' AND position='C'";		  
		}

		//$condition				= "banner_page={$pageID} AND status='1' AND localclassification_id='{$classificationID}' AND position='C'";
		$QUERY					= "SELECT * FROM banner WHERE $condition";
		$result					= $this->myDB->query($QUERY);
		
		if(isset($result[0])){		  
		  $businessID = $result[0]['business_id'];
		  $this->setBannerImpression($businessID, 'C', $classificationID, $marketID);
		}		

		return $result;
	}
	
	public function getBannerD($pageID)
	{

		$classificationID 		= (!empty($_GET['search']))?$_GET['search']:NULL;
		$condition				= "banner_page={$pageID} AND status='1' AND localclassification_id='{$classificationID}' AND position='D'";
		$QUERY					= "SELECT * FROM banner WHERE $condition";
		$result					= $this->myDB->query($QUERY);

		return $result;
	}
	public function getBannerE($pageID)
	{

		$classificationID 		= (!empty($_GET['search']))?$_GET['search']:NULL;
		$condition				= "banner_page={$pageID} AND status='1' AND localclassification_id='{$classificationID}' AND position='E'";
		$QUERY					= "SELECT * FROM banner WHERE $condition";
		$result					= $this->myDB->query($QUERY);

		return $result;
	}
	/**
     *  loadAjax
     *
     *  Load Business names for ajax suggest
     * 
     * @param   array   get        	keyword
     * @return  object  			Json object
     * 
     */
	public function loadAjax($get) {

		header("Content-Types: application/json");
		$keyword = GeneralUtils::handle_input($get['kw']);
		$keyword = $this->myDB->quote($keyword);

		$sql = "SELECT distinct business_name
				FROM `local_businesses` lb
				WHERE lb.business_name like '$keyword%'
				   OR lb.business_name REGEXP '[[:<:]]$keyword'
				LIMIT 0, {$get['limit']}";

		$bus1_res = $this->myDB->query($sql);
		
		$cResults = array_merge($bus1_res);		
		
		echo "{\"results\": [";
		$arr = array();
		for ($i=0;$i<count($cResults);$i++)
		{
			$arr[] = "{\"id\": \"".$cResults[$i]['business_name']."\", \"value\": \"".$cResults[$i]['business_name']."\", \"info\": \"\"}";
		}
		echo implode(", ", $arr);
		echo "]}";

		//        return $retArray;

	}/* END loadAjax */



	public function tempSearchKeyword($get)
	{
		$Search1 				= (!empty($get['Search1']))?$get['Search1']:NULL;
		$Search2 				= (!empty($get['Search2']))?$get['Search2']:NULL;
		$finalLocation			='';
		$final_result			='';
		$finalClassification	='';

		//Search for the classification

		$classification_search	="SELECT localclassification_name,localclassification_id FROM local_classification WHERE localclassification_name LIKE '%".$Search1."%'";

		$classification_search_result		=$this->myDB->query($classification_search);
		$classification_search_count		=count($classification_search_result);

		if($classification_search_count =='0')
		{

			$classification_search_keyword	="SELECT localclassification_id,keyword FROM keywords WHERE keyword LIKE '%".$Search1."%'";

			$classification_search_result_keyword		=$this->myDB->query($classification_search_keyword);
			$classification_search_count_keyword		=count($classification_search_result_keyword);

			if($classification_search_count_keyword =='0')
			{

				$retArray = array("result"=>false, "message"=>'No Record for this search');
				return $retArray;

			}
			else if($classification_search_count_keyword =='1')
			{
				$finalClassification	=$classification_search_result_keyword['0']['keyword'];

			}
			else
			{
				$final_query	="SELECT st.shiretown_townname, st.`shiretown_id` , sn.shirename_shirename, sn.`shirename_id`
										FROM shire_towns AS st 
											LEFT JOIN shire_names AS sn ON ( st.shirename_id = sn.shirename_id )
										WHERE st.shiretown_townname LIKE '%".$Search2."%' OR st.shiretown_postcode LIKE '%".$Search2."%'";
				$final_result	=$this->myDB->query($final_query);

			}
		}
		else if($classification_search_count =='1')
		{
			$finalClassification	=$classification_search_result['0']['localclassification_name'];
		}
		else
		{

			$final_query	="SELECT st.shiretown_townname, st.`shiretown_id` , sn.shirename_shirename, sn.`shirename_id`
									FROM shire_towns AS st 
									LEFT JOIN shire_names AS sn ON ( st.shirename_id = sn.shirename_id )
									WHERE st.shiretown_townname LIKE '%".$Search2."%' OR st.shiretown_postcode LIKE '%".$Search2."%' ";
			$final_result	=$this->myDB->query($final_query);

		}

		if($Search2 == '')
		{
			$condition="local_classification.localclassification_name LIKE '%".$Search1."%'";

			$sql="SELECT count(local_classification.localclassification_name) AS count_localclassification_name,local_classification.localclassification_id,local_classification.localclassification_name
				FROM local_classification,local_businesses,business_classification 
				WHERE ($condition) AND local_businesses.expired=0 AND (local_businesses.business_id=business_classification.business_id) AND (local_classification.localclassification_id=business_classification.localclassification_id) GROUP BY local_classification .localclassification_name";
			$final_result = $this->myDB->query($sql);
			if(count($final_result)>0) {
				foreach ($final_result as $k=>$classification) {
					$final_result[$k]['link'] = $this->request->createURL("Listing", "categorySearch", "search={$classification['localclassification_id']}&category={$classification['localclassification_name']}&val={$this->request->getAttribute('Search2')}");
				}
			}
			return $final_result;
		}

		//Search for the location

		$location_search		="SELECT shirename_id,shirename_shirename FROM shire_names WHERE shirename_shirename LIKE '%".$Search2."%'";

		$location_search_result	=$this->myDB->query($location_search);

		$location_search_count	=count($location_search_result);

		if($location_search_count == '0')
		{
			$location_search_suburb		="SELECT shiretown_id,shiretown_townname,shiretown_postcode FROM shire_towns WHERE shiretown_townname LIKE '%".$Search2."%' OR shiretown_postcode LIKE '%".$Search2."%'";

			$location_search_result_suburb	=$this->myDB->query($location_search_suburb);
			$location_search_count_suburb	=count($location_search_result_suburb);

			if($location_search_count_suburb =='0')
			{

				$retArray = array("result"=>false, "message"=>'No Record for this search');
				return $retArray;
			}
			else if($location_search_count_suburb =='1')
			{
				$finalLocation	=$location_search_result_suburb['0']['shiretown_townname'];

			}
		}
		else if($location_search_count == '1')
		{
			$finalLocation	=$location_search_result['0']['shirename_shirename'];

		}
		else
		{
			$final_query	="SELECT st.shiretown_townname, st.`shiretown_id` , sn.shirename_shirename, sn.`shirename_id`
										FROM shire_towns AS st 
											LEFT JOIN shire_names AS sn ON ( st.shirename_id = sn.shirename_id )
										WHERE st.shiretown_townname LIKE '%".$Search2."%' OR st.shiretown_postcode LIKE '%".$Search2."%'";
			$final_result	=$this->myDB->query($final_query);

		}

		if($finalLocation !='' && $finalClassification !='')
		{

			$condition="(local_classification.localclassification_name LIKE '%".$finalClassification."%') AND(local_businesses.business_postcode LIKE '%".$finalLocation."%' OR local_businesses.shire_name LIKE '%".$finalLocation."%' OR local_businesses.business_suburb LIKE '%".$finalLocation."%' OR local_businesses.business_state LIKE '%".$finalLocation."%')";

			$sql="SELECT
						count(local_classification.localclassification_name) AS count_localclassification_name,
						local_classification.localclassification_id,
						local_classification.localclassification_name 
					FROM 
						local_classification,
						local_businesses,
						business_classification 
					WHERE ($condition)
						AND local_businesses.expired=0 
						AND (local_businesses.business_id=business_classification.business_id) 
						AND (local_classification.localclassification_id=business_classification.localclassification_id) 
					GROUP BY local_classification .localclassification_name";
			$final_result = $this->myDB->query($sql);
			if(count($final_result)>0) {
				foreach ($final_result as $k=>$classification) {
					$final_result[$k]['link'] = $this->request->createURL("Listing", "categorySearch", "search={$classification['localclassification_id']}&category={$classification['localclassification_name']}&val={$this->request->getAttribute('Search2')}");
				}
			}
		}
		return $final_result;
	}/* END tempSearchKeyword */

	public function getClassificationWithCount($classification_ids, $fr=0, $paging_size = DEFAULT_PAGING_SIZE)
	{
		$recs = array();
		$ids = implode(",", $classification_ids);
		$count_select_sql = " COUNT( `bc`.`localclassification_id`) ";
		$col_select_sql = "`bc`.`localclassification_id`,
							`lc`.`localclassification_name`,
							COUNT( DISTINCT bc.business_id ) AS cnt";
		$from_sql = "FROM
						(
						business_classification AS bc
						LEFT JOIN 
						local_classification AS `lc` 
							ON ( `lc`.`localclassification_id` = `bc`.`localclassification_id` )
						)
							LEFT JOIN business_ranks AS br
							ON ( br.business_id = bc.business_id AND br.localclassification_id = lc.localclassification_id AND br.localclassification_id IN ( $ids ) )
					WHERE
						`bc`.`localclassification_id`
						IN ( $ids )
					GROUP BY `bc`.`localclassification_id` ORDER BY `lc`.`localclassification_name` ASC";

		$sql_count = "SELECT ".$count_select_sql." ".$from_sql;
		$count_res = $this->myDB->query($sql_count);
		$count = count($count_res);
		if($count) {

			$sql = "SELECT $col_select_sql $from_sql LIMIT $fr, $paging_size";
			//			prexit($sql);
			$recs = $this->myDB->query($sql);
			foreach ($recs as $k=>$v) {
				$localclassification_name		=urlencode($v['localclassification_name']);
				$recs[$k]['link'] = $this->request->createURL("Listing", "categorySearch", "search={$v['localclassification_id']}&category={$localclassification_name}");
			}
		}
		$classifications['paging'] = Paging::numberPaging($count, $fr, $paging_size);
		$classifications['total_recs'] = $count;
		$classifications['classifications'] = $recs;
		return $classifications;
	}/* END getClassificationWithCount */

	public function isRegionExists($kw) {

		$sql = "SELECT
					 shirename_id
				FROM 
					shire_names
				WHERE
					shirename_shirename ='".$this->myDb->quote($kw)."'
				";

		$shire_res = $this->myDB->query($sql);
		if( count($shire_res) == 1 ) {
			return $shire_res[0]['shirename_id'];
		}
		return 0;
	}/* END isRegionExists */

	public function isRegionLikeExists($kw) {

		$sql = "SELECT
					 shirename_id,
					 shirename_shirename
				FROM 
					shire_names
				WHERE
					shirename_shirename LIKE '%".$this->myDb->quote($kw)."%'
				";

		$shire_res = $this->myDB->query($sql);
		if( count($shire_res) == 1 ) {
			return $shire_res[0];
		}
		return 0;
	}/* END isRegionLikeExists */

	public function isSuburbExists($kw, $state = '') {

        if($state == '') {	
          $sql = "SELECT st.shirename_id 
                    FROM shire_towns st, shire_names sn, local_state ls
                   WHERE st.shiretown_townname='" .$this->myDb->quote($kw)."'".
                     " AND st.shirename_id = sn.shirename_id
	                   AND sn.shirename_state = ls.localstate_id";
		} else {			   
          $sql = "SELECT st.shirename_id 
                    FROM shire_towns st, shire_names sn, local_state ls
                   WHERE st.shiretown_townname='" .$this->myDb->quote($kw)."'".
                     " AND st.shirename_id = sn.shirename_id
	                   AND sn.shirename_state = ls.localstate_id
	                   AND ls.localstate_name = '". $this->myDb->quote($state) ."'";
        }					 
		$res = $this->myDB->query($sql);
		if($res) {
			return $res[0]['shirename_id'];
		}
		return 0;
	}/* END isSuburbExists */
	
	public function isStateExistsByPostcode($postCode){
	  $sql = "SELECT ls.localstate_name
	            FROM shire_towns st, shire_names sn, local_state ls
               WHERE st.shirename_id = sn.shirename_id
	             AND sn.shirename_state = ls.localstate_id
		         AND st.shiretown_postcode = '". $this->myDb->quote($postCode) ."'";
				 
	  $res = $this->myDB->query($sql);
	  if($res) {
	    return $res[0]['localstate_name'];
	  }
	  return 0;				 
	
	}/* END isStateExistsBySuburb */	
	
	public function isStateExistsBySuburb($suburb){
	  $sql = "SELECT ls.localstate_name
	            FROM shire_towns st, shire_names sn, local_state ls
               WHERE st.shirename_id = sn.shirename_id
	             AND sn.shirename_state = ls.localstate_id
		         AND st.shiretown_townname = '". $this->myDb->quote($suburb) ."'";
				 
	  $res = $this->myDB->query($sql);
	  if($res) {
	    return $res[0]['localstate_name'];
	  }
	  return 0;				 
	
	}/* END isStateExistsBySuburb */
	
	public function isStateExistsByRegion($region){
	  $sql = "SELECT ls.localstate_name
                FROM shire_names sn, local_state ls
               WHERE sn.shirename_shirename = '". $this->myDb->quote($region) ."'
	             AND sn.shirename_state = ls.localstate_id";				 
	  $res = $this->myDB->query($sql);
	  if($res) {
	    return $res[0]['localstate_name'];
	  }
	  return 0;				 
	
	}/* END isStateExistsBySuburb */	

	public function isPostCodeExists($kw) {

		$sql = "SELECT
					shirename_id
				FROM 
					shire_towns
				WHERE
					shiretown_postcode='".$this->myDb->quote($kw)."' LIMIT 0, 1";

		$res = $this->myDB->query($sql);
		if($res) {
			return $res[0]['shirename_id'];
		}
		return 0;
	}/* END isPostCodeExists */
	
	/***
	*
	*  Get the URL Alias for a given region
	*
	***/	
	private function getRegionAlias($shire_name) {	
	  $sql = "SELECT url_alias
	            FROM shire_names
			   WHERE shirename_shirename = '" . $this->myDB->quote($shire_name) ."'";
			   
	  $urlAlias = $this->myDB->query($sql);
	  
	  return (isset($urlAlias[0]['url_alias'])) ? $urlAlias[0]['url_alias'] : '';	
	}
	/***
	*
	*  Get the Region Name for a given URL Alias
	*
	***/		
	public function getShireNameFromAlias($url_alias){
	
	  $sql = "SELECT shirename_shirename
	            FROM shire_names
			   WHERE url_alias = '" . $this->myDB->quote($url_alias) ."'";
			   
	  $shireName = $this->myDB->query($sql);	 
	  
	  return $shireName[0]['shirename_shirename'];	
	}	
	
	
	public function relatedClassLinks($class_id) {
		
		$query = "SELECT * from class_relationships WHERE class_id='$class_id'";
		//dev_log::write("relatedClassLinks query = ".$query);
		$res = $this->myDB->query($query);
		$list = '';
	    if($res) {
	    	$list = $res[0]['related'];
	    	//dev_log::write("relatedClassLinks list = ".$list);
			$output = explode(',', $list);
		}
		
		//return array();
		return $output;
	}

	public function getClassificationCountByLocation($location, $classification_ids, $fr=0, $paging_size = DEFAULT_PAGING_SIZE)
	{
		$locationParams = explode(' - ', $location);		
		$location = $locationParams[0];	
		$location_hack = FALSE;
	
		$state    = (isset($locationParams[1])) ? $locationParams[1] : '';
		
		if($state == ''){
		  $state = $this->isStateExistsByPostcode($location);
		  		 
		  if($state == '0'){
		    $state = ($this->isStateExistsBySuburb($location)) ? $this->isStateExistsBySuburb($location) : $this->isStateExistsByRegion($location);
		  }	
		}		
			
		$classifications = array();
		if(count($classification_ids)>0) {

			$location_cond = '';
			$param = '';
			$recs = $temp_for_sorting = $temp_recs = array();
			$ambiguous = $shire = false;
			$ambg_region_name = $ambg_suburb_name = "";
			$amb_c = (isset($_GET['c']) && $_GET['c'] == "r")?"r":"s";

			$shire_id = 0;
			//looking for exact region
			if($location) {
				$shire_id = $this->isRegionExists($location);
				if($shire_id) {
					if($shire_id!=59 && $shire_id!=314 && $shire_id!=315 && $shire_id!=316 && $shire_id!=317 && $shire_id!=318 && $shire_id!=319) { //  && $shire_id!=314 VICTORIA HACK ADDED 20120206
						$location_cond = " AND lb.shire_name='".$this->myDb->quote($location)."'";
						$regionURLAlias = $this->getRegionAlias($location);
						$param = "&shire_name=".urlencode($regionURLAlias);
						$shire = true;
					} else {
						$location_hack = TRUE;
					}
				}
				elseif( $shire_id = $this->isPostCodeExists($location)) {//looking for exact postcode

					$location_cond = " AND lb.business_postcode='".$this->myDb->quote($location)."'";
					$param = "&postcode=$location";
				}
				elseif( $shire_id = $this->isSuburbExists($location, $state)) {

					$location_cond = " AND lb.business_suburb='".$this->myDb->quote($location)."'";
					$param = "&shire_town=".urlencode($location);

					//checking ambiguity in Region & Suburb name
					if( $region = $this->isRegionLikeExists($location)) {
						$location_cond = " AND lb.business_suburb='".$this->myDb->quote($location)."'";
						$param = "&shire_town=".urlencode($location);
						$ambiguous = true;
						$ambg_region_name = $region['shirename_shirename'];
						$ambg_suburb_name = $location;
					}

					/*if($amb_c == "s") {
					$location_cond = " AND lb.business_suburb='".$this->myDb->quote($location)."'";
					$param = "&shire_town=".urlencode($location);
					}*/
				}
			}
			if(!$shire_id) {//if not matches exact Region/Postcode/Suburb
				return "";
			}

			$ids = implode(",", $classification_ids);

			$i=0;
			$classificationFacade = new ClassificationFacade($this->myDb);
			foreach ($classification_ids as $classification_id) {

				$main_cond	= " bc.localclassification_id=".$this->myDB->quote($classification_id)." AND lb.expired=0 ";
				$condition = " AND br.localclassification_id=bc.localclassification_id ";

				if($shire_id) {
					$condition .=" AND br.shirename_id=$shire_id";
				}

				$shire_cond = " $main_cond AND bc.business_id = lb.business_id ";
				if($shire) {
					$shire_cond .= " AND lb.shire_name='".$this->myDB->quote(trim($location))."' ";
				}

				$condition = "( $main_cond $condition ) OR ( $shire_cond $location_cond )";

				//exception handle for All-Sydney results
				$rank_col = " br.businessrank_rank ";
				$rank_condition =" AND br.shirename_id=$shire_id";
				$time_stamp_col = "br.businessrank_timestamp,";
				if(!$shire_id || $shire_id==59) {
					$rank_col = " 6 ";
					$rank_condition ="";
					$time_stamp_col = "";
				}

				$shire_sql = "SELECT DISTINCT
								lb.business_id, 
								$time_stamp_col
								$rank_col
							FROM
								business_classification AS bc
								
								LEFT JOIN local_businesses AS lb ON ( bc.business_id = lb.business_id )
									LEFT JOIN business_ranks AS br ON ( lb.business_id = br.business_id $rank_condition
										AND br.localclassification_id=".$this->myDB->quote($classification_id).")
							WHERE 
								$condition ";
				//dev_log::write("getClassificationCountByLocation: shire_id = $shire_id | shire_sql = $shire_sql");
								
				$count = $this->myDB->exec($shire_sql);
				if($count) {

					$classification_name = $classificationFacade->getClassificationNameById($classification_id);
					$temp_recs[$i]['cnt'] = $count;
					//$temp_recs[$i]['link'] = $this->request->createURL("Listing", "categorySearch", "category=".urlencode($classification_name).$param."&search=".$classification_id);
					
					if ($location_hack) {
					    // TEST Hack 20120427 - Hereward
					   //$regionURLAlias = $this->getRegionAlias($location);
					   //$param = "&shire_name=".urlencode($regionURLAlias);
					}

					$temp_recs[$i]['link'] = $this->request->createURL("Listing", "categorySearch", "category=".urlencode($classification_name)."&state=".$state.$param."&search=".$classification_id);					
					$temp_recs[$i]['localclassification_name'] = $classification_name;

					$temp_for_sorting[$classification_name] = $i;

					$i++;
				}
			}
			if($temp_for_sorting) {
				ksort($temp_for_sorting);
				foreach ($temp_for_sorting as $k=>$v) {
					$recs[] = $temp_recs[$v];
				}
			}

			if(isset($_GET['ambg_suburb'])) {
				$ambiguous = true;
				$ambg_suburb_name = $_GET['ambg_suburb'];
			}
			$classifications['total_recs'] = $i;
			$classifications['classifications'] = $recs;
			$classifications['ambiguous'] = $ambiguous;
            
			if(isset($ambg_region_name))
			  $regionAlias = $this->getRegionAlias($ambg_region_name);			
			$classifications['ambg_region_alias'] = (isset($regionAlias)) ? $regionAlias : '';
			$classifications['ambg_region_name']  = $ambg_region_name;
			$classifications['ambg_suburb_name']  = $ambg_suburb_name;
		}

		return $classifications;
	}/* END getClassificationCountByLocation */
	
	
	public function getClassificationCountByAlpha($location, $classification_ids, $fr=0, $paging_size = DEFAULT_PAGING_SIZE)
	{
		$classifications = array();		
		
		if(count($classification_ids)>0) {
		    
			$location_cond = '';
			$param = '';
			$recs = $temp_for_sorting = $temp_recs = array();
			$ambiguous = $shire = false;
			$ambg_region_name = $ambg_suburb_name = "";
			$amb_c = (isset($_GET['c']) && $_GET['c'] == "r")?"r":"s";

			$shire_id = 0;

			$ids = implode(",", $classification_ids);

			$i=0;
			$classificationFacade = new ClassificationFacade($this->myDb);
			foreach ($classification_ids as $classification_id) {

				$main_cond	= " bc.localclassification_id=".$this->myDB->quote($classification_id)." AND lb.expired=0 ";
				$condition = " AND br.localclassification_id=bc.localclassification_id ";

				if($shire_id) {
					$condition .=" AND br.shirename_id=$shire_id";
				}

				$shire_cond = " $main_cond AND bc.business_id = lb.business_id ";
				/*
				if($shire) {
					$shire_cond .= " AND lb.shire_name='".$this->myDB->quote(trim($location))."' ";
				}
				*/

				$condition = "( $main_cond $condition ) OR ( $shire_cond $location_cond )";

				//exception handle for All-Sydney results
				$rank_col = " br.businessrank_rank ";
				$rank_condition =" AND br.shirename_id=$shire_id";
				$time_stamp_col = "br.businessrank_timestamp,";
				if(!$shire_id || $shire_id==59) {
					$rank_col = " 6 ";
					$rank_condition ="";
					$time_stamp_col = "";
				}

				$shire_sql = "SELECT DISTINCT
								lb.business_id, 
								$time_stamp_col
								$rank_col
							FROM
								business_classification AS bc
								
								LEFT JOIN local_businesses AS lb ON ( bc.business_id = lb.business_id )
									LEFT JOIN business_ranks AS br ON ( lb.business_id = br.business_id $rank_condition
										AND br.localclassification_id=".$this->myDB->quote($classification_id).")
							WHERE 
								$condition";								

				$count = $this->myDB->exec($shire_sql);
				if($count) {

					$classification_name = $classificationFacade->getClassificationNameById($classification_id);
					$temp_recs[$i]['cnt'] = $count;
					$temp_recs[$i]['link'] = $this->request->createURL("Listing", "categorySearchAlpha", "search={$classification_id}&category=".urlencode($classification_name).$param);
					$temp_recs[$i]['localclassification_name'] = $classification_name;

					$temp_for_sorting[$classification_name] = $i;

					$i++;
				}
			}
			
			if($temp_for_sorting) {
				ksort($temp_for_sorting);
				foreach ($temp_for_sorting as $k=>$v) {
					$recs[] = $temp_recs[$v];
				}
			}
			
			if(isset($_GET['ambg_suburb'])) {
				$ambiguous = true;
				$ambg_suburb_name = $_GET['ambg_suburb'];
			}
			$classifications['total_recs'] = $i;
			$classifications['classifications'] = $recs;
			$classifications['ambiguous'] = $ambiguous;
			$classifications['ambg_region_name'] = $ambg_region_name;
			$classifications['ambg_suburb_name'] = $ambg_suburb_name;
		}
		return $classifications;
	}/* END getClassificationCountByAlpha */	

	private function addCount(&$recs, $classification) {
		foreach ($recs as $k=>$v) {
			if($v['localclassification_id'] == $classification['localclassification_id']) {
				$cnt = $v['cnt'];
				unset($recs[$k]);
				return $cnt;
			}
		}
		return 0;
	}
	
	public function relatedClassifications($classification)
	{
		$classifications = array();
		//First search in classification table
		$sql = "SELECT
					localclassification_id
				FROM 
					local_classification 
				WHERE 
					localclassification_name REGEXP '[[:<:]]".$this->myDB->quote($classification)."'";

		$res = $this->myDB->query($sql);
		if($res) {
			foreach ($res as $classification) {
				$classifications[] = $classification['localclassification_id'];
			}
		}
		//Now search for synonyms
		$sql = "SELECT
					localclassification_id
				FROM
					keywords
				WHERE
					keyword REGEXP '[[:<:]]".$this->myDB->quote($classification)."'";
		$res = $this->myDB->query($sql);
		if($res) {
			foreach ($res as $synonym) {
				$classifications[] = $synonym['localclassification_id'];
			}
		}

		//look in verticals(groups)
		$sql = "SELECT
					gc.classification_id
				FROM
					groups AS gp
					LEFT JOIN
						group_classification AS gc
						ON (gp.group_id=gc.group_id)
				WHERE
					gp.group_title REGEXP '[[:<:]]".$this->myDB->quote($classification)."'";
		$res = $this->myDB->query($sql);
		if($res) {
			foreach ($res as $group) {
				$classifications[] = $group['classification_id'];

			}
		}

		return array_unique($classifications);
	}/* END resolveClassification */

	public function resolveClassification($keyword)
	{
		$classifications = array();
		//First search in classification table
		$sql = "SELECT
					localclassification_id
				FROM 
					local_classification 
				WHERE 
					localclassification_name REGEXP '[[:<:]]".$this->myDB->quote($keyword)."'";

		$res = $this->myDB->query($sql);
		if($res) {
			foreach ($res as $classification) {
				$classifications[] = $classification['localclassification_id'];
			}
		}
		//Now search for synonyms
		$sql = "SELECT
					localclassification_id
				FROM
					keywords
				WHERE
					keyword REGEXP '[[:<:]]".$this->myDB->quote($keyword)."'";
		$res = $this->myDB->query($sql);
		if($res) {
			foreach ($res as $synonym) {
				$classifications[] = $synonym['localclassification_id'];
			}
		}

		//look in verticals(groups)
		$sql = "SELECT
					gc.classification_id
				FROM
					groups AS gp
					LEFT JOIN
						group_classification AS gc
						ON (gp.group_id=gc.group_id)
				WHERE
					gp.group_title REGEXP '[[:<:]]".$this->myDB->quote($keyword)."'";
		$res = $this->myDB->query($sql);
		if($res) {
			foreach ($res as $group) {
				$classifications[] = $group['classification_id'];

			}
		}

		return array_unique($classifications);
	}/* END resolveClassification */


	public function suburbAndRegionList($keyword, $location) {

		$regions = array();

		$sql = "SELECT
					DISTINCT
					st.shiretown_townname,
					st.`shiretown_postcode`,
					st.`shiretown_id`,
					sn.shirename_shirename,
					sn.`shirename_id`,
					ls.`localstate_name`					                    				
				FROM 
					shire_towns AS st
					LEFT JOIN 
						shire_names AS sn
						ON ( st.shirename_id = sn.shirename_id )
					LEFT JOIN local_state AS ls
					    ON (ls.localstate_id = sn.shirename_state)
				WHERE
					st.shiretown_townname LIKE '%".$this->myDb->quote($location)."%'
					or
					sn.shirename_shirename LIKE '%".$this->myDb->quote($location)."%'					
				ORDER BY
					sn.shirename_shirename, st.shiretown_townname
					";

		$result = $this->myDB->query($sql);

		if($result) {
			foreach ($result as $suburb) {

				$suburb['suburb_link'] = $this->request->createURL("Listing", "searchKeyword", "Search1=".urlencode($keyword)."&ID={$suburb['shiretown_id']}&Search2=".urlencode(trim($suburb['shiretown_townname']))."&exact=1");

				$regions[$suburb['shirename_id']]['suburbs'][] = $suburb;
				$regions[$suburb['shirename_id']]['region_name'] = $suburb['shirename_shirename'];
				$regions[$suburb['shirename_id']]['region_link'] = $this->request->createURL("Listing", "searchKeyword", "Search1=".urlencode($keyword)."&Search2=".urlencode($suburb['shirename_shirename'])."&exact=1");
			}
		}

		return $regions;
	}


	public function streetSearchList($keyword, $location) {

		$regions = array();

		$sql = "SELECT
					DISTINCT
					st.shiretown_townname,
					st.`shiretown_postcode`,
					st.`shiretown_id`,
					sn.shirename_shirename,
					sn.`shirename_id`
				FROM 
					shire_towns AS st
					LEFT JOIN 
						shire_names AS sn
						ON ( st.shirename_id = sn.shirename_id )
				WHERE
					st.shiretown_townname LIKE '%".$this->myDb->quote($location)."%'
				ORDER BY
					sn.shirename_shirename, st.shiretown_townname
					";

		$result = $this->myDB->query($sql);

		if($result) {
			foreach ($result as $suburb) {


				$suburb['suburb_link'] = $this->request->createURL("Listing", "searchStreetBusiness", "Search1=".urlencode($keyword)."&ID={$suburb['shiretown_id']}&Search2=".urlencode(trim($suburb['shiretown_townname']))."&exact=1");

				$regions[$suburb['shirename_id']]['suburbs'][] = $suburb;
				$regions[$suburb['shirename_id']]['region_name'] = $suburb['shirename_shirename'];
				$regions[$suburb['shirename_id']]['region_link'] = $this->request->createURL("Listing", "searchStreetBusiness", "Search1=$keyword&Search2=".urlencode(trim($suburb['shirename_shirename'])));
			}
		}

		return $regions;
	}

	public function streetBusinessSearch($get,$fr=0, $perPage=DEFAULT_PAGING_SIZE)
	{
		$street 				= (!empty($get['Search1']))?$get['Search1']:NULL;
		$suburb 				= urldecode((!empty($get['Search2']))?$get['Search2']:NULL);
		$suburb_id 				= (!empty($get['ID']))?$get['ID']:NULL;
		$res 				= array();
		$result	=array();
		$OrderBy ="ORDER BY lb.business_name, br.businessrank_timestamp ASC, rank ASC";
		//fetching count
		$sql = "SELECT
					COUNT(lb.business_id) AS cnt
				FROM
					local_businesses AS lb
				WHERE
					(lb.business_street1 LIKE '%".$street."%' OR lb.business_street2 LIKE '%".$street."%')
											AND (lb.business_suburb='{$suburb}' OR lb.shire_name='{$suburb}')";

		$result = $this->myDB->query($sql);
		$count=$result['0']['cnt'];

		$sql="SELECT
						DISTINCT 
						lb.business_phonestd, 
						lb.url_alias, 						
						lb.business_id, 
						lb.business_phone, 
						lb.business_url, 
						lb.bold_listing, 
						lb.business_street1,
						lb.street1_status,
						lb.street2_status, 
						lb.map_status, 
						lb.business_street2, 
						lb.business_logo,
						lb.business_mobile ,
						lb.business_email,
						lb.business_url,
						lb.business_fax,
						lb.business_description,
						bc.business_id, 
						lb.business_postcode, 
						lb.business_suburb, 
						lb.business_state, 
						lb.business_name,
						lb.shire_name,
						bc.localclassification_id,
						IF(ISNULL(br.businessrank_rank), 999999, br.businessrank_rank) AS rank
					FROM 
									local_businesses AS lb
									LEFT JOIN business_classification AS bc
										ON (
											lb.business_id = bc.business_id
										)
						LEFT JOIN business_ranks AS br ON ( lb.business_id = br.business_id
						)
					WHERE 
						(lb.business_street1 LIKE '%".$street."%' OR lb.business_street2 LIKE '%".$street."%')
											AND (lb.business_suburb='{$suburb}' OR lb.shire_name='{$suburb}') 
					GROUP BY lb.business_id 
					$OrderBy
					LIMIT $fr,$perPage "; 

		$result = $this->myDB->query($sql);

		if(count($result)>0) {
			$classificationFacade = new ClassificationFacade($this->myDB);
			foreach ($result as $k=>$category) {
				$classification_name = $classificationFacade->getClassificationNameById($category['localclassification_id']);

				$fetch_add_word				= "SELECT * FROM `local_pages` WHERE `business_id` ='{$category['business_id']}'";
				$result_add_word 			= $this->myDB->query($fetch_add_word);

				$result[$k]['add_word1'] 	= @$result_add_word[0]['adword_line1'];
				$result[$k]['add_word2'] 	= @$result_add_word[0]['adword_line2'];
				$result[$k]['classification_name'] = $classification_name;
				
				if(REWRITE_URL){
				  $result[$k]['link'] = $this->request->createURL("{$category['url_alias']}/{$category['business_id']}/listing");				
				  $result[$k]['url'] = $this->request->createURL("{$category['url_alias']}/{$category['business_id']}/listing");
                } else {				  
				  $result[$k]['link'] = $this->request->createURL("Listing", "boldListing", "ID={$category['business_id']}");
				  $result[$k]['url'] = $this->request->createURL("Listing", "googleMapView", "Street={$category['business_street1']}&Suburb={$category['business_suburb']}&State={$category['business_state']}&Postcode={$category['business_postcode']}&businessId={$category['business_id']}&name={$category['business_name']}&rank={$category['rank']}&classification={$classification_name}");
                }  								
			}
		}

		$res['listings'] 	= $result;
		$res['paging'] 		= Paging::numberPaging($count, $fr, DEFAULT_PAGING_SIZE);
		return $res;
	}

	public function contactUsDetails($get,$post)
	{


		$name 				= (!empty($post['name']))?$post['name']:NULL;
		$companyname 		= (!empty($post['companyname']))?$post['companyname']:NULL;
		$emailFrom 			= (!empty($post['email']))?$post['email']:NULL;
		$phone 				= (!empty($post['phone']))?$post['phone']:NULL;
		$comment 			= (!empty($post['comment']))?$post['comment']:NULL;
		$business_id 		= (!empty($get['ID']))?$get['ID']:NULL;
		$MessageHTML 		= '';
		$date				= date("Y-m-d,H:m:s");
		$date_mail			= date("j F, Y, g:i a");
		
		if (isset($_SESSION['BID'])) {
			$business_id = $_SESSION['BID'];
		} else {
			$business_id = 7566121;
		}

		$fetch_contactus_details		="SELECT business_name,business_email, account_id FROM local_businesses WHERE business_id='$business_id'";

		$detail_query 					= $this->myDB->query($fetch_contactus_details);
		$business_name					= $detail_query['0']['business_name'];
		$account_id						= $detail_query['0']['account_id'];

		if($detail_query['0']['account_id'] && $detail_query['0']['account_id']!=NULL && $detail_query['0']['account_id']!="NULL")
		{
			$account_id						= $detail_query['0']['account_id'];

		}else{
			$account_id						= "&nbsp;";
		}
		//prexit($account_id);
		$business_email					= $detail_query['0']['business_email'];
		$to							= ADMIN_EMAIL_ADDR;
		
		if(getSession("affiliate_id") == '')
		{
			$userID		=	getSession("client_id");
		}elseif(getSession("client_id") == '')
		{
			$userID		=	getSession("affiliate_id");
		}else{
			$userID		=	"";
		}


		/*		$retArray = array("result"=>false, "message"=>'');
		$res1 =$this->__contactUsValidation($post);
		if(!$res1['result'])
		{
		return $res1;
		}*/

		$insertContactDetails	="INSERT INTO contactUs_details (
											contact_id,
											name,
											company_name,
											email_from,
											email_to,
											phone,
											comment,
											user_id,
											time
										) VALUES (
											'',
											'{$name}',
											'{$companyname}',
											'{$emailFrom}',
											'{$business_email}',
											'{$phone}',
											'{$comment}',
											'{$userID}',
											'$date'
											)";

		$contactDetailsArray		=$this->myDB->query($insertContactDetails);

if($emailFrom != '') 
{
		$MessageHTML	.="
<table width='100%' border='0' cellspacing='0' cellpadding='0' style='color:#5F5E5E;height:10px;'>
        </table></td>
      </tr>
      <tr>
        <td style='color:#5F5E5E;font-size:13px;height:20px;'><br />
          The following message was sent to you from the Pink Pages website by someone wanting more information <br />
          regarding your products or services. </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td width='17%' valign='top'>&nbsp;</td>
            <td width='83%'>&nbsp;</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;' nowrap='nowrap'>Business Name:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$business_name</td>
          </tr>
         
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;' nowrap='nowrap'>Submission Time:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>&nbsp;$date_mail</td>
          </tr>

        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td width='17%' valign='top'>&nbsp;</td>
            <td width='83%'>&nbsp;</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Name:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$name</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Company Name:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$companyname</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Email:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$emailFrom</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Phone:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$phone</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Enquiry:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$comment</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td style='color:#5F5E5E;font-size:13px;height:20px;'>If you have any queries regarding this email, or would like to contact us regarding your advertising on the Pink Pages website, please call (02) 9635 1400 or email enquiries@pinkpages.com.au.</td>
      </tr>
      
    </table></td>
  </tr>
</table>
"; 
}

else{
			$MessageHTML	.="
<table width='100%' border='0' cellspacing='0' cellpadding='0' style='color:#5F5E5E;height:10px;'>
        </table></td>
      </tr>
      <tr>
        <td style='color:#5F5E5E;font-size:13px;height:20px;'><br />
          The following message was sent to you from the Pink Pages website by someone wanting more information <br />
          regarding your products or services. </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td style='color:#5F5E5E;font-size:13px;height:20px;'>Please do not reply to this email. Instead, contact the enquirer directly on the details supplied below. </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td width='17%' valign='top'>&nbsp;</td>
            <td width='83%'>&nbsp;</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;' nowrap='nowrap'>Business Name:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$business_name</td>
          </tr>
         
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;' nowrap='nowrap'>Submission Time:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>&nbsp;$date_mail</td>
          </tr>

        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td width='17%' valign='top'>&nbsp;</td>
            <td width='83%'>&nbsp;</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Name:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$name</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Company Name:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$companyname</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Email:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$emailFrom</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Phone:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$phone</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Enquiry:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$comment</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td style='color:#5F5E5E;font-size:13px;height:20px;'>If you have any queries regarding this email, or would like to contact us regarding your advertising on the Pink Pages website, please call (02) 9635 1400 or email enquiries@pinkpages.com.au.</td>
      </tr>
      
    </table></td>
  </tr>
</table>
"; 
	
}

		$mailer = new Mailer();
		$mailer->AddAddress($business_email);
		$mailer->Subject 	= "Enquiry from Pink Pages online";
		if($emailFrom != '')
		{
		$mailer->AddReplyTo($emailFrom);
		}else{
		$mailer->AddReplyTo('info@sydneypinkpages.com.au');
		}
			if($emailFrom != '')
		{
		$mailer->FromName=$name;
		}else{
		$mailer->FromName="Pink Pages";
		}
		$mailer->Body 		= $MessageHTML;
		$mailer->IsHTML(true);
		if(!$mailer->Send())
		{
			echo $mailer->ErrorInfo;
		}
		$mailer->ClearAddresses();
		$retArray = array("result"=>true, "message"=>'Thank You,Your details have been sent to the business owner successfully.');
		return $retArray;


		return $Array;
	}


	private function __contactUsValidation(&$data)
	{

		$retArray = array("result"=>false, "message"=>'');
		$errors = array();

		if(empty($data['phone'])) {
			$errors[] = "phone is blank!!";
		}

		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}

	public function addDetails($get)
	{
		$Business_ID						=$get['ID'];
		$date								= date("Y-m-d,H:m:s");
		$referer							=(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');


		$fetch_shiretown_id					="SELECT shire_name FROM local_businesses WHERE expired=0 AND business_id={$Business_ID}";
		$shiretown_idArray					=$this->myDB->query($fetch_shiretown_id);

		//$shire_name							= $shiretown_idArray['0']['shire_name'];
		$shire_name							= (!empty($shiretown_idArray['0']['shire_name']))?$shiretown_idArray['0']['shire_name']:NULL;

		$fetch_shirename_id					="SELECT shirename_id FROM shire_names WHERE shirename_shirename='{$shire_name}'";
		$shirename_idArray					=$this->myDB->query($fetch_shirename_id);

		$shirename_id							= (!empty($shirename_idArray['0']['shirename_id']))?$shirename_idArray['0']['shirename_id']:NULL;

		//$shirename_id						= $shirename_idArray['0']['shirename_id'];

		$fetch_business_classification		="SELECT * FROM business_classification WHERE business_id={$Business_ID}";
		$business_classificationArray		=$this->myDB->query($fetch_business_classification);

		foreach($business_classificationArray as $value)
		{

			$insert_business_pageviews			="INSERT INTO business_pageviews (
																				`business_id`,
																				`shirename_id`,
																				`localclassification_id`,
																				`session_id`,
																				`ts_date`,
																				`referer`) 
																		VALUES (
																				{$Business_ID},
																				{$shirename_id},
																				{$value['localclassification_id']},
																				'0',
																				'$date',
																				'$referer')";
			$business_pageviews					= $this->myDB->query($insert_business_pageviews);
		}


		$fetchBusinessCount					= "SELECT count FROM business_preview_count WHERE business_id={$Business_ID}";
		$result								= $this->myDB->query($fetchBusinessCount);
		if(isset($result['0']['count'])){
			$count								= $result['0']['count'];
		}else {
			$count = 0;
		}

		$finalCount							=$count+1;

		if(count($result) > 0)
		{
			$deleteCount					="DELETE FROM business_preview_count WHERE business_id={$Business_ID}";
			$deleteResult						= $this->myDB->query($deleteCount);
		}

		$insertDetail						="INSERT INTO business_preview_count (
																				`business_id`,
																				`count`) 
																			VALUE (
																				 {$Business_ID},
																				 $finalCount)";
		$this->myDB->query($insertDetail);


	}
	/*public function demoAddList($post,$logo)
	{

	$initials 		= (!empty($post['initials']))?$post['initials']:NULL;
	$name 			= (!empty($post['name']))?$post['name']:NULL;
	$street1 		= (!empty($post['street1']))?$post['street1']:NULL;
	$street2 		= (!empty($post['street2']))?$post['street2']:NULL;
	$phonestd 		= (!empty($post['phonestd']))?$post['phonestd']:NULL;
	$phone 			= (!empty($post['phone']))?$post['phone']:NULL;
	$faxstd 		= (!empty($post['faxstd']))?$post['faxstd']:NULL;
	$fax 			= (!empty($post['fax']))?$post['fax']:NULL;
	$email 			= (!empty($post['email']))?$post['email']:NULL;
	$url 			= (!empty($post['url']))?$post['url']:NULL;
	$origin 		= (!empty($post['origin']))?$post['origin']:NULL;
	$mobile 		= (!empty($post['mobile']))?$post['mobile']:NULL;
	$contact 		= (!empty($post['contact']))?$post['contact']:NULL;
	$postcode 		= (!empty($post['postcode']))?$post['postcode']:NULL;
	$description 	= (!empty($post['description']))?$post['description']:NULL;
	$classification = (!empty($post['classification']))?$post['classification']:NULL;
	$state 			= (!empty($post['state']))?$post['state']:NULL;
	$listing 		= (!empty($post['listing']))?$post['listing']:NULL;
	$rank 			= (!empty($post['rank']))?$post['rank']:NULL;
	$archived 		= (!empty($post['archived']))?$post['archived']:NULL;
	$OlistID 		= (!empty($post['OlistID']))?$post['OlistID']:NULL;
	$logoname		=$logo['logo']['name'];
	$suburb			=explode(',',$_POST['suburb']);
	$shire			=explode(';',$_POST['region']);

	$listingValidation =$this->__demolistingValidation($post,$logo,"add");

	if(!$listingValidation['result'])
	{
	return $listingValidation;
	}


	$queryGetShire	="SELECT shiretown_id
	FROM shire_towns
	WHERE shiretown_postcode='".$postcode."'
	AND shiretown_townname='".$suburb[1]."'";
	$shireResult	=$this->myDB->query($queryGetShire);


	$addBusiness	="INSERT INTO
	demo_local_businesses (`business_initials` , `business_name` , `business_street1` , `business_street2` , `business_phonestd` , `business_phone` , `business_faxstd` , `business_fax` , `business_email` , `business_url` , `business_origin` , `business_mobile` , `business_contact` , `business_postcode` , `shiretown_id` , `business_suburb`,`business_logo`,`business_description`,`classification`,`business_state`,`bold_listing`,`archived`,`Rank`,`shire_name`,`shire_town`)
	VALUES (
	'{$initials}', '{$name}', '{$street1}', '{$street2}', '{$phonestd}', '{$phone}', '{$faxstd}', '{$fax}', '{$email}', '{$url}', '{$origin}', '{$mobile}', '{$contact}', '{$postcode}', '{$shireResult[0]['shiretown_id']}', '{$suburb[1]}','{$logoname }','{$description}','{$classification}', '{$state}','{$listing}','{$archived}','{$rank}','{$shire[1]}','{$suburb[1]}')";//prexit($addBusiness);

	$resultAddBusiness	=$this->myDB->query($addBusiness);

	$insertedBusinessId	=$this->myDB->getInsertID($resultAddBusiness);

	if($OlistID != '')
	{
	$OlistID_sql		=" INSERT INTO `demo_dawson_olistkey_businessid`
	(`olistkey` ,`business_id`) VALUES ('{$OlistID}', '{$insertedBusinessId}')";

	$resultOlistID		=$this->myDB->query($OlistID_sql);
	}


	$addBusiness=array("result"=>true, "message"=>'Business Added Successfully',"InsertID"=>$insertedBusinessId);

	return $addBusiness;
	}*/


	public function demoAddList($post,$logo)
	{

		$name 			= (!empty($post['name']))?$post['name']:NULL;
		$address        = (!empty($post['address']))?$post['address']:NULL;
		$phone 			= (!empty($post['phone']))?$post['phone']:NULL;
		$postcode 		= (!empty($post['postcode']))?$post['postcode']:NULL;
		$description 	= (!empty($post['description']))?$post['description']:NULL;
		$state 			= (!empty($post['state']))?$post['state']:NULL;
		$listing 		= (!empty($post['listing']))?$post['listing']:NULL;
		$logoname		=$logo['logo']['name'];
		$suburb			= (!empty($post['suburb']))?$post['suburb']:NULL;


		$listingValidation =$this->__demolistingValidation($post,$logo,"add");

		if(!$listingValidation['result'])
		{
			return $listingValidation;
		}

		$addBusiness	="INSERT INTO
		                   demo_local_businesses1 (`business_name` , `business_address` ,`business_phone` ,`business_postcode` ,  `business_suburb`,`business_logo`,`business_description`,`business_state`)
                     VALUES (
 '{$name}', '{$address}', '{$phone}', '{$postcode}','{$suburb}','{$logoname }','{$description}', '{$state}')";                 

		$resultAddBusiness	=$this->myDB->query($addBusiness);
		$insertedBusinessId	=$this->myDB->getInsertID($resultAddBusiness);

		$addBusiness=array("result"=>true, "message"=>'Business Added Successfully',"InsertID"=>$insertedBusinessId);

		return $addBusiness;
	}

	private function __demolistingValidation(&$data,&$logo,$val)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();

		if(empty($data['name']))
		{
			$errors[] = "name is blank!!";
		}

		if(empty($data['address']))
		{
			$errors[] = "address is blank!!";
		}

		if(empty($data['phone']))
		{
			$errors[] = "Please enter your number!!";
		}
		/*if(empty($data['suburb']))
		{
		$errors[] = "Please enter your Suburb!!";
		}

		if(empty($data['postcode']))
		{
		$errors[] = "postcode is blank!!";
		}*/


		if(empty($data['description']))
		{
			$errors[] = "description is blank!!";
		}

		if($val == 'add')
		{
			if(empty($logo['logo']['name']))
			{
				$errors[] = "Please Select any Logo!!";
			}
		}

		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}

	/*public  function  demoListing(){

	$sql="SELECT
	COUNT( DISTINCT lb.business_id) AS cnt
	FROM demo_local_businesses AS lb ";


	$count_result = $this->myDB->query($sql);
	$count = $count_result[0]['cnt'];
	if($count) {

	$sql="SELECT
	DISTINCT
	lb.business_phonestd,
	lb.business_id,
	lb.business_phone,
	lb.business_url,
	lb.bold_listing,
	lb.business_street1,
	lb.business_street2,
	lb.business_postcode,
	lb.business_suburb,
	lb.business_state,
	lb.business_name,
	lb.shire_name,
	lb.street1_status,
	lb.business_email,
	lb.street2_status

	FROM  demo_local_businesses AS lb order by business_id desc limit 0,1 ";

	//prexit($sql);
	$result = $this->myDB->query($sql);

	foreach ($result as $k=>$category) {
	$result[$k]['link'] = $this->request->createURL("Listing", "demoBoldListing", "ID={$category['business_id']}");
	$result[$k]['url'] = $this->request->createURL("Listing", "googleMapView", "Street={$category['business_street1']}&Suburb={$category['business_suburb']}&State={$category['business_state']}&Postcode={$category['business_postcode']}&businessId={$category['business_id']}&name={$category['business_name']}");

	$result[$k]['contactUs'] = $this->request->createURL("Listing", "contactUs", "ID={$category['business_email']}&act=demoBoldListing&businessID={$category['business_id']}");
	}
	$res['blogs'] = $result;return $res;
	}

	//$res['paging'] = Paging::numberPaging($count, $fr, $perPage);

	}*/

	public  function  demoListing(){


		$sql="SELECT
					COUNT( DISTINCT lb.business_id) AS cnt
				FROM demo_local_businesses1 AS lb ";


		$count_result = $this->myDB->query($sql);
		$count = $count_result[0]['cnt'];
		if($count) {

			$sql="SELECT
						DISTINCT
						lb.business_id, 
						lb.business_phone, 
						lb.business_address, 
						lb.business_postcode,
						lb.business_logo,
						lb.business_description, 
						lb.business_suburb, 
						lb.business_state, 
						lb.business_name
											
						
					FROM  demo_local_businesses1 AS lb order by business_id desc limit 0,1 ";


			$result = $this->myDB->query($sql);

			foreach ($result as $k=>$category)
			{
				$result[$k]['link'] = $this->request->createURL("Listing", "demoBoldListing", "ID={$category['business_id']}");
			}
			$res['blogs'] = $result;
			return $res;
		}

		//$res['paging'] = Paging::numberPaging($count, $fr, $perPage);

	}
	/*function demoBoldListingResult($get)
	{
	//$count_business_views=0;


	$search		=$get['ID'];
	$condition="business_id  ='{$search}'";
	$sql="SELECT demo_local_businesses.business_phonestd,
	business_faxstd,business_fax,
	business_email,
	business_mobile,
	business_contact,
	client_id,
	demo_local_businesses.business_phone,
	demo_local_businesses.business_url,
	demo_local_businesses.business_description,
	demo_local_businesses.business_email,
	demo_local_businesses.bold_listing,
	demo_local_businesses.business_street1,
	demo_local_businesses.business_street2,
	demo_local_businesses.business_postcode,
	demo_local_businesses.business_suburb,
	demo_local_businesses.street1_status,
	demo_local_businesses.street2_status,
	demo_local_businesses.shiretown_id,
	demo_local_businesses.business_state,
	demo_local_businesses.business_name,
	demo_local_businesses.business_logo
	FROM demo_local_businesses WHERE $condition";
	$res = $this->myDB->query($sql);
	return $res;

	}*/

	function demoBoldListingResult($get)
	{
		$search		=$get['ID'];
		$condition="business_id  ='{$search}'";
		$sql="SELECT
		demo_local_businesses1.business_phone,
		demo_local_businesses1.business_description,
		demo_local_businesses1.business_address,
		demo_local_businesses1.business_postcode,
		demo_local_businesses1.business_suburb,
		demo_local_businesses1.business_state,
		demo_local_businesses1.business_name,
		demo_local_businesses1.business_logo 
		FROM demo_local_businesses1 WHERE $condition";
		$res = $this->myDB->query($sql);prexit($res);
		return $res;
	}

	public function moreAddressesAdd($post)
	{
		$id			= $_GET['ID'];
		$shire		= explode(';',$_POST['region']);//prexit($shire);
		$sub		= explode(',',$post['suburb']);
		$Add1		= (!empty($_POST['Add1']))?$_POST['Add1']:0;
		$Add2		= (!empty($_POST['Add2']))?$_POST['Add2']:0;

		$res		= $this->__addressFieldsValidation($post);
		if(!$res['result'])
		{
			return $res;
		}

		$sql		= "INSERT INTO `multiple_addresses` (`id`,`business_id`,`business_street1`,`business_street2`,`business_suburb`,`business_state`,`business_postcode`,`shire_name`,`shire_town`,`street1_status`,`street2_status`,`user_id`) VALUES('','{$id}','{$post['street1']}','{$post['street2']}','{$sub[1]}','{$post['state']}','{$post['postcode']}','{$shire[1]}','{$sub[1]}','{$Add1}',{$Add2},'".getSession("client_id")."')";
		$this->myDB->query($sql);
		$result 	= array("result"=>true, "message"=>'Added Successfully');
		return $result;


	}


	public function __addressFieldsValidation($get)
	{

		$retArray = array("result"=>false, "message"=>'');
		$errors = array();

		if(empty($get['street1'])) {
			$errors[] = "Street1 field is blank";
		}

		if(empty($get['region'])) {
			$errors[] = "Please select region";
		}

		if(empty($get['suburb'])) {
			$errors[] = "Please select suburb";
		}

		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;


	}

	public function manageAddress($fr=0, $perPage=DEFAULT_PAGING_SIZE)
	{

		$id						= $_GET['ID'];
		$sql					= "SELECT * FROM multiple_addresses WHERE business_id={$id} ";
		$res					= $this->myDB->query($sql);

		$sql2					= "SELECT count(business_id) as cnt FROM multiple_addresses WHERE business_id={$id}";
		$count_all				= $this->myDB->query($sql2);

		$retArray['listings'] 	= $res;
		$retArray['paging'] 	= Paging::numberPaging($count_all[0]['cnt'], $fr, $perPage);
		return $retArray;
	}


	public function editAddressesAdd($post)
	{
		$id						= $_GET['ID1'];
		$shire					= explode(',',$_POST['region']);
		$sub					= explode(',',$post['suburb']);
		$Add1					= (!empty($_POST['Add1']))?$_POST['Add1']:0;
		$Add2					= (!empty($_POST['Add2']))?$_POST['Add2']:0;
		$sql					= "UPDATE multiple_addresses
									  SET
										  business_street1='{$post['street1']}',
										  business_street2='{$post['street2']}',
										  business_suburb='{$sub[1]}',
										  business_state='{$post['state']}',
										  business_postcode='{$post['postcode']}',
										  shire_name='{$shire[1]}',
										  shire_town='{$sub[1]}',
										  street1_status='{$Add1}',
										  street2_status='{$Add2}' 
									  WHERE 
										  id={$id}";
		$this->myDB->query($sql);
		$result 				= array("result"=>true, "message"=>'Updated Successfully');
		return $result;
	}

	public function editaddressFetchDetails()
	{
		$id						= $_GET['ID1'];
		$sql					= "SELECT * FROM multiple_addresses WHERE id='{$id}'";
		$res=$this->myDB->query($sql);
		return $res;
	}

	public function deleteaddress()
	{
		$id						= $_GET['ID1'];
		$sql					= "DELETE FROM multiple_addresses where id='{$id}'";
		$this->myDB->query($sql);
		$result 				= array("result"=>true, "message"=>'Deleted Successfully');
		return $result;
	}

	public function fetchKeyword($get)
	{
		$Business_id			= array();

		foreach($this->refineKeywordSearchArray($get) as $business_id)
		{
			$Business_id[]		= $business_id['business_id'];
		}

		$fArray 				= array();
		foreach($Business_id as $val)
		{
			$fetchKey			= "SELECT business_key_name FROM business_keyword WHERE business_id ='{$val}' GROUP BY business_key_name";

			$r					= $this->myDB->query($fetchKey);
			foreach($r as $t){
				//if(!in_array($t['business_key_name'], $fArray)
				$fArray[] 		= $t['business_key_name'];
			}
		}
		$fArray 		= array_unique($fArray);

		return $fArray;
	}

	public function fetchBusinessKeyword($get)
	{
		$BusinessID 			= (!empty($get['ID']))?$get['ID']:NULL;
		$Query					= "SELECT * FROM business_keyword WHERE business_id={$BusinessID}";
		$result  				= $this->myDB->query($Query);
		return $result;
	}

	public function add_new_keyword($post,$get)
	{
		$BusinessID 			= (!empty($get['ID']))?$get['ID']:NULL;

		foreach($post['addclassification'] as $value)
		{

			$add_classification = "INSERT INTO `business_keyword` (`key_id`, `business_id`, `business_key_name`) VALUES ('', '{$BusinessID}', '{$value}')";

			$result  			= $this->myDB->query($add_classification);
		}
		$addClass				= array("result"=>true, "message"=>'Keyword Added Successfully',"ID"=>$BusinessID);
		return $addClass;
	}

	public function deleteKeyword($post,$get)
	{

		$BusinessID 	= (!empty($get['ID']))?$get['ID']:NULL;
		$deleteClass 	= (!empty($post['deleteClass']))?$post['deleteClass']:NULL;

		if($deleteClass == '')
		{
			$delClass=array("result"=>false, "message"=>'Please select any keyword to delete',"ID"=>$BusinessID);
			return $delClass;
		}

		foreach($deleteClass as $value)
		{

			$del_classification = "DELETE FROM `business_keyword` WHERE `business_id` ='".$BusinessID."' AND `key_id` = '".$value."'";

			$result  =$this->myDB->query($del_classification);

		}
		$delClass=array("result"=>true, "message"=>'Classification Added Successfully',"ID"=>$BusinessID);
		return $delClass;
	}

	//------------------------------

	public function fetchBrands($get)
	{
		$Business_id		=array();
		foreach($this->refineKeywordSearchArray($get) as $business_id)
		{
			$Business_id[]= $business_id['business_id'];
		}

		$fArray_hour = array();
		foreach($Business_id as $val)
		{
			$fetchKey				= "SELECT brand_id,business_brand_name FROM  business_brand WHERE business_id ='{$val}'";

			$r					= $this->myDB->query($fetchKey);
			$i=0;
			foreach($r as $t){
				$fArray_hour[$i]['business_brand_name'] = $t['business_brand_name'];
				$fArray_hour[$i]['brand_id'] = $t['brand_id'];
				$i++;
			}
		}

		return $fArray_hour;
	}
	//------------------------------

	/*public function fetchBrands()
	{
	$fetchBrand				="SELECT * FROM business_brand_name";
	$result				=$this->myDB->query($fetchBrand);
	return $result;
	}*/

	public function fetchBusinessBrand()
	{
		$BusinessID					=$_GET['ID'];
		$fetchBusinessBrand			="SELECT * FROM `business_brand` WHERE `business_id`='{$BusinessID}'";
		$result						=$this->myDB->query($fetchBusinessBrand);
		return $result;
	}
	
   public function BusinessRankedCount() // Hereward 20120515
	{
		$BusinessID				= $_GET['ID'];
		$fetchBusinessRank		= "SELECT * FROM `business_ranks` WHERE `business_id`='{$BusinessID}'";
		$result					= $this->myDB->query($fetchBusinessRank);
		$count = count($result);
		return $count;
	}

	public function businessStats($get)
	{
		$currentdate				= date("Y-m-d");
		$business_id				= $get['ID'];
		$result='';
		$fetchBusinessDetails		= "SELECT views
											FROM business_stats 
											WHERE business_id='{$business_id}' 
												AND view_date='{$currentdate}'";
		$result						= $this->myDB->query($fetchBusinessDetails);

		$count						= count($result);
		if($count == '0')
		{
			$insertQuery				= "INSERT INTO business_stats (
																	`business_id`,
																	`view_date`,
																	`views`) VALUES (
																	'{$business_id}',
																	'{$currentdate}',
																	'1')";
			$resultInser				= $this->myDB->query($insertQuery);
		}else{
			$total_view					= $result['0']['views']+1;
			$updateQuery				= "UPDATE business_stats
											SET views='{$total_view}' 
											WHERE business_id='{$business_id}' AND view_date='{$currentdate}'";
			$resultInser				= $this->myDB->query($updateQuery);

		}
	}

	public function addLocalityDetails($get)
	{
		$shiranameId 		= (!empty($get['ID']))?$get['ID']:NULL;
		$shiretown_townname = (!empty($get['Search2']))?$get['Search2']:NULL;
		$date				= date('Y-m-d');

		$fetchLocality		= "SELECT count FROM locality_count WHERE shiretown_id='{$shiranameId}' AND date_report='{$date}'";
		$result				= $this->myDB->query($fetchLocality);

		if(count($result)==0)
		{
			$Count				=@$result[0]['count']+1;
			$insert_locality_stats = "INSERT
							  INTO `locality_count` (`shiretown_id`,`shiretown_townname`,`count`,`date_report`)
							  VALUES ('{$shiranameId}','{$shiretown_townname}','{$Count}','{$date}')"; 

			$this->myDB->query($insert_locality_stats);
		}
		else
		{
			$Count				= @$result[0]['count']+1;
			$update_locality_stats 	= "UPDATE locality_count SET count ='$Count' WHERE shiretown_id='$shiranameId' AND date_report='{$date}'";
			$this->myDB->query($update_locality_stats);
		}
	}

}
?>