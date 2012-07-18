<?php
class ListingFacade extends MainFacade {

	/**
     *  __construct
     *
     *  Instantiate MyDB object
     */
	public function __construct(MyDB $MyDB){           //Start of The __contructor.purpose is to assign database parmeters to                                                           //a variable acting as an object and using that object to declare

		$this->MyDB = $MyDB;                             //the table name,sequence name and primary column.
		$this->MyDB->table=TBL_LOCAL_BUSINESS;
		$this->MyDB->sequenceName=TBL_LOCAL_BUSINESS;
		$this->MyDB->primaryCol="business_id";
	}

	/*public function __construct(MyDB $myDB, Request $request) {

	parent::__construct($myDB, $request);
	$this->myDB = $myDB;
	$this->myDB->table=TBL_LOCAL_BUSINESS;
	$this->myDB->sequenceName=TBL_LOCAL_BUSINESS;
	$this->myDB->primaryCol="business_id";
	}*/
	/* END __construct */



	public function expiredCronJob(){

		$mktime = mktime(date("h", time()),date("i", time()),date("s", time()),date("m", time()),date("d", time())-40,date("Y", time()));
		//		$mktime = mktime(date("h", time()),date("i", time()),date("s", time()),date("m", time()),date("d", time()),date("Y", time())-1);
		/*echo $Query			="SELECT business_id, business_addDate
		FROM local_businesses
		WHERE business_addDate > '".date("Y-m-d h:i:s",$mktime)
		."' ORDER BY business_id  LIMIT 0,20";*/

		//exit();

		$Query			="UPDATE local_businesses
							SET expired=1
						WHERE business_addDate < '".date("Y-m-d h:i:s",$mktime)."'";

		$result  =$this->MyDB->query($Query);

		$affectedRow = mysql_affected_rows();

		return $affectedRow;
	}

	public function expiredBusiness($get, $fr=0, $noOfRecords=DEFAULT_PAGING_SIZE)
	{

		if(isset($get['searchType']) && $get['searchType']=="willExpired"){

			if(isset($get['days']) && is_numeric($get['days']) && $get['days']>0){

				$days = $get['days'];
			}else {

				$days = 15;
			}
			$mktime = mktime(date("h", time()),date("i", time()),date("s", time()),date("m", time()),date("d", time())+$days,date("Y", time()));
			$nowTime = mktime(date("h", time()),date("i", time()),date("s", time()),date("m", time()),date("d", time())-15,date("Y", time()));
			$condition = " expired=0 AND business_addDate BETWEEN '".date("Y-m-d h:i:s",$nowTime)."' AND '".date("Y-m-d h:i:s",$mktime)."'";
			//			$condition = " business_addDate BETWEEN NOW() AND '".date("Y-m-d h:i:s",$mktime)."'";

		}else {
			$condition = "expired=1";
		}
		$SQL			="SELECT
											local_businesses.business_id,
											local_businesses.business_name, 
											local_businesses.business_suburb, 
											local_businesses.business_phonestd, 
											local_businesses.business_phone ,
											local_businesses.Rank
										  FROM
											   local_businesses 
										  WHERE
												$condition
										  ORDER BY 
											  local_businesses.business_name ASC		
										  LIMIT $fr, $noOfRecords";

		$listings = $this->MyDB->query($SQL);

		$this->MyDB->reset();

		$SQL			="SELECT
											count(local_businesses.business_id) AS cnt
										  FROM
											local_businesses 
									  	WHERE
											$condition";

		$count_all = $this->MyDB->query($SQL);

		$retArray['listings'] = $listings;
		$retArray['paging'] = Paging::numberPaging($count_all[0]['cnt'], $fr, $noOfRecords);
		return $retArray;
	}//END OF SEARCH BUSINESS FUNCTION

	function getReport($san_data) {
		//prexit($san_data);
		$launch_date = strtotime($san_data['to_date']);
		$business_id = $san_data['business_id'];
		//getting business title from business_id
		$sql = "SELECT business_name FROM ".$this->MyDB->sequenceName." WHERE business_id=".$this->MyDB->quote($business_id);
		die($sql);
		dev_log::write("Report SQL = [$sql]");
		$rs = $this->MyDB->query($sql);
		$business_name = $rs[0]['business_name'];

		$page_size = $san_data['page_size'];
		$from = $san_data['fr'];
		//		prexit($launch_date);
		//verified Users
		$columns[] = array(
		'date_col'=>		'view_date',
		'res_col_name'=>	'views',
		'table'=>			'business_stats',
		'data_arr_name'=>	'business_stats_report',
		'count_col'=>		'views',
		'cond'=>			" AND business_id=$business_id "
		);

		/////////////////////////////

		$date_format = 'd-M-Y';

		$duration_arr = array();

		/*if($san_data['period'] == 'Hourly') {

		$time_arr = GeneralUtils::timeDiff($launch_date, time(), 'h');
		$all_recs_count = $time_arr['hours']+1;

		$trim_date = 13;
		$date_format = 'd-M-Y h A';

		$u_limit = date('Y-m-d H', mktime (date('H')-$from,0,0,date("m"), date("d"), date("Y")));
		$l_limit = date('Y-m-d H', mktime (date('H')-($from+$page_size-1),0,0,date("m"), date("d"), date("Y")));
		for($i=$from;$i<($from+$page_size);$i++) {
		$duration_arr[] = date("$date_format", mktime (date('H')-$i,0,0,date("m"), date("d"), date("Y")));
		}
		}
		else */
		if($san_data['period'] == 'Monthly') {

			$time_arr = GeneralUtils::timeDiff($launch_date, time(), 'mt');
			$all_recs_count = $time_arr['months']+1;

			$date_format = 'M-Y';
			$trim_date = 7;
			$u_limit = date('Y-m-d h', mktime (date('H'),0,0,date("m")-$from, date("d"), date("Y")));
			$l_limit = date('Y-m-d h', mktime (date('H'),0,0,date("m")-($from+$page_size-1), date("d"), date("Y")));
			for($i=$from;$i<($from+$page_size);$i++) {
				$duration_arr[] = date("$date_format", mktime (date('H'),0,0,date("m")-$i, date("d"), date("Y")));
			}
		}
		else if($san_data['period'] == 'Yearly') {

			$time_arr = GeneralUtils::timeDiff($launch_date, time(), 'Y');
			$all_recs_count = $time_arr['years']+1;

			$trim_date = 4;
			$date_format = 'Y';
			$u_limit = date('Y-m-d h', mktime (date('H'),0,0,date("m"), date("d"), date("Y")-$from));
			$l_limit = date('Y-m-d h', mktime (date('H'),0,0,date("m"), date("d"), date("Y")-($from+$page_size-1)));
			for($i=$from;$i<($from+$page_size);$i++) {
				$duration_arr[] = date("$date_format", mktime (date('H'),0,0,date("m"), date("d"), date("Y")-$i));
			}
		}
		else { //default Daily & Weekly Settings

			$time_arr = GeneralUtils::timeDiff($launch_date, time(), 'D');

			$all_recs_count = $time_arr['days']+1;

			if($san_data['period'] == 'Weekly') $page_size *= 7;

			$u_limit = date('Y-m-d', mktime (date('H'),0,0,date("m"), date("d")-$from, date("Y")));
			$l_limit = date('Y-m-d', mktime (date('H'),0,0,date("m"), date("d")-($from+$page_size-1), date("Y")));
			$date_format = 'd-M-Y';
			for($i=$from;$i<($from+$page_size);$i++) {
				$duration_arr[] = date("$date_format", mktime (0,0,0,date("m"), date("d")-$i, date("Y")));
			}
			$trim_date = 10;
		}


		foreach ($columns as $col) {

			if($san_data['period'] == "Daily") {
				$duration = " {$col['date_col']} ";
			}
			else {
				$duration = "LEFT( {$col['date_col']} , $trim_date )";
			}

			$sql = "SELECT $col[date_col] as period, sum($col[count_col]) as $col[res_col_name] FROM $col[table] WHERE $duration<='$u_limit' AND $duration>='$l_limit' $col[cond] GROUP BY $duration ORDER BY $col[date_col] DESC";
			$reg_rs = $this->MyDB->query($sql);
			$arr_name = "$col[data_arr_name]";

			$$arr_name = array();
			$temp = array();
			if($reg_rs) {
				foreach ($reg_rs as $row) {
					$temp[date("$date_format",strtotime($row['period']))] = $row[$col['res_col_name']];
				}
			}
			$$arr_name = $temp;
		}

		$all_data_arr = array();
		foreach ($duration_arr as $date) {

			foreach ($columns as $col) {
				$temp = array();
				$arr_name = "$col[data_arr_name]";
				$temp = $$arr_name;

				if(isset($temp[$date])) {
					$all_data_arr[$date][$col['res_col_name']] = $temp[$date];
				}
				else {
					$all_data_arr[$date][$col['res_col_name']] = 0;
				}

				if($san_data['period'] == "Daily") {
					$all_data_arr[$date]['day'] = date("D", strtotime($date));
				}
			}
		}

		if($san_data['period'] == 'Weekly') {

			$all_data_arr = array_chunk($all_data_arr, 7, true);
			$temp_arr = array();
			foreach ($all_data_arr as $temp) {

				$reg_count = 0;
				$i=0;
				$week_date_from = '';
				$week_date_to = '';

				foreach ($temp as $key=>$val) {

					if($i==0) $week_date_from = $key;
					if($i==6) $week_date_to = $key;

					$reg_count += $val[$columns[0]['res_col_name']];
					$i++;
				}

				$week_date = "$week_date_from to $week_date_to";

				$temp_arr[$week_date][$columns[0]['res_col_name']] = $reg_count;
			}
			$all_data_arr = $temp_arr;
		}
		//		prexit($all_data_arr);
		$retArray['business_name'] = $business_name;
		$retArray['all_data_arr'] = $all_data_arr;
		$retArray['paging'] = Paging::numberPaging($all_recs_count, $from, $page_size);

		return $retArray;
	}


	public function activateBus($id){

		$Query = "UPDATE local_businesses SET
					expired=0,
					business_addDate=NOW()
					WHERE business_id={$id}
					";
		$res = $this->MyDB->query($Query);
		$res = array(
		'result'=>1,
		'message'=>"Business has been activated successfuly",
		);
		return $res;
	}




	public function reportMail($san_data){

		$sql = "SELECT business_email FROM local_businesses WHERE business_id={$san_data['business_id']}";
		$mailAr = $this->MyDB->query($sql);

		$res = $this->getReport($san_data);

		$Body = '';
		$Body .= '
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="datatable">
					
							<tr><td height="4"></td></tr>
							<tr>
								<td width="100%" align="center">
									<div align="center"></div>
								</td>
							</tr>
							<tr><td height="4"></td></tr>
							<tr>
								<td width="100%" align="center">
									<table id="inbox_table" width="90%" style="" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td class="h4reversed">Date</th>';

		if($san_data['period'] == 'Daily'){
			$Body .= '<td class="h4reversed">Day</th>';
		}
		$Body .= '<td class="h4reversed">View Count</th>
										</tr>';
		foreach($res['all_data_arr'] as $key=>$val){
			$Body .= '<tr>
											<td align="left" nowrap>'.$key.'</td>';

			if($san_data['period'] == 'Daily'){
				$Body .= '<td align="left">'.$val['day'].'</td>';
			}
			$Body .= '<td align="left">'.$val['views'].'</td>
										</tr>';
		}
		$Body .='</table>
								</td>
							</tr>
							<tr><td height="4"></td></tr>
						</table>';

		//			echo $Body;//exit;

		$mailer = new Mailer();

		$mailer->AddAddress($mailAr[0]['business_email']);
		//			$mailer->AddAddress('jitendra.saklani@vsworx.com');


		$mailer->IsHTML(true);





		$mailer->Body = $Body;
		$mailer->Subject = "Business Listings Report";
		if(!$mailer->Send()){

			$retArray 			= array("result"=>false, "message"=>'Mail has not been sent');
			return $retArray;
			// echo $mailer->ErrorInfo;
		}
		$mailer->ClearAddresses();
		$retArray 			= array("result"=>true, "message"=>'Mail has been sent successfully');
		return $retArray;
	}
	
	/**
     *  updateLocalBusinessIndex
     *
     *  Updates Listing name in indexed table for fast searching (used in auto suggest)
     * 
     * @param   int   business_id
     * 
     */
	public function updateLocalBusinessIndex($business_id) {

		//delete from local_business_index_table
		$sql = "DELETE FROM ".TBL_LOCAL_BUSINESS_INDEX." WHERE business_id = ".$this->MyDB->quote($business_id);
		$this->MyDB->query($sql);
		
		//now insert new row
		$sql = "INSERT INTO ".TBL_LOCAL_BUSINESS_INDEX." SELECT business_id, business_name FROM ".TBL_LOCAL_BUSINESS." WHERE business_id = ".$this->MyDB->quote($business_id);
		$this->MyDB->query($sql);

	}/* END updateLocalBusinessIndex */
	
	/**
     *  Markets Upload
     *
     *  Updates records in the Markets database table
     * 
     * @param   file   $file
     * 
     */
	public function marketsUpload($file) {
	
	if($file){
	  $tmp       = $_FILES['csvfile']['tmp_name'];
      $uploadDir = $this->sys_get_temp_dir();
      $file      = $_FILES['csvfile']['name'];
      setSession("file",$uploadDir.$file);			
	  
      if(move_uploaded_file($tmp, $uploadDir . $file) or die("Cannot copy uploaded file")){
        echo "File successfully uploaded to " . $uploadDir . $file;
        echo "<br />Now attempt to extract file to " .$uploadDir . $file ." <br />";           
        //$values = $this->gz_read($file, $uploadDir);
	    $content = $this->parseCSVFile($file, $uploadDir);	  		
		$res = $this->insertMarkets($content);
		//$report[] = count($values);
      } else echo "File was <strong>NOT</strong> successfully uploaded to " . $uploadDir . $_FILES['data']['name'];  							  
	  

	  
	  echo $content;
	  
	  return $content;
	}  
	
	
	}/* END marketsUpload */	
	
	public function insertMarkets($post){
	
	  $this->deleteMarketEntries();
      foreach($post as $i => $row){
	  if($row[0] && $row[1]){
 	  $sql="INSERT INTO `markets` (
		`market_id` ,
		`market_name`
		)
		VALUES (
		'{$row[0]}', '{$row[1]}' );";						 
		print($sql);					
		$res1	=   mysql_query($sql);								  
	  }        
	}

  }	
	
	private function deleteMarketEntries(){
      $sql = "delete from markets;";
	  $result  = $this->MyDB->query($sql);	  					  
	}	
	
	/**
     *  Markets Upload
     *
     *  Updates records in the MarketsToShires database table
     * 
     * @param   file   $file
     * 
     */
	public function marketsToShiresUpload($file) {
	
	if($file){
	  $tmp       = $_FILES['csvfile']['tmp_name'];
      $uploadDir = $this->sys_get_temp_dir();
      $file      = $_FILES['csvfile']['name'];
      setSession("file",$uploadDir.$file);			
	  
      if(move_uploaded_file($tmp, $uploadDir . $file) or die("Cannot copy uploaded file")){
        echo "File successfully uploaded to " . $uploadDir . $file;
        echo "<br />Now attempt to extract file to " .$uploadDir . $file ." <br />";           
        //$values = $this->gz_read($file, $uploadDir);
	    $content = $this->parseCSVFile($file, $uploadDir);	  		
		$res = $this->insertMarketsToShires($content);
		//$report[] = count($values);
      } else echo "File was <strong>NOT</strong> successfully uploaded to " . $uploadDir . $_FILES['data']['name'];  							  
	  	 
	  echo $content;
	  
	  return $content;
	}  
	
	
	}/* END marketsToShiresUpload */	
	
	public function insertMarketsToShires($post){
	
	  $this->deleteMarketsToShiresEntries();
      foreach($post as $i => $row){
	    if($row[0] && $row[1]){
 	    $sql="INSERT INTO `markets_to_shires` (
		`market_id` ,
		`shirename_id`
		)
		VALUES (
		'{$row[0]}', '{$row[1]}' );";						 
		print($sql);					
		$res1	=   mysql_query($sql);								  
	    }      
	  }

    }		
	
	private function deleteMarketsToShiresEntries(){
      $sql = "delete from markets_to_shires;";
	  $result  = $this->MyDB->query($sql);	  					  
	}		
	
private function parseCSVFile($file, $path){
  $fp = fopen("$path$file", "rb") or die("Cannot open file");
  set_time_limit(0);
  // iterate through file
  // retrieve and print each field
  
  $content = array();
  
  while (!feof($fp)) {
    //$line = fgetcsv($fp, 0, ',', '"');	
	array_push($content, fgetcsv($fp, 0, ',', '"'));
  }
  // close file
  fclose($fp) or die("Cannot close file");
  return $content;
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
}
?>