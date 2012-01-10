<?php
class SearchFacade extends MainFacade {

	/**
     *  __construct
     *
     *  Instantiate MyDb object
     */
	public function __construct(MyDB $MyDB) {

		$this->myDB = $MyDB;
		$this->myDB->table = 'shire_names';
		$this->myDB->sequenceName = 'shire_names';
		$this->myDB->primaryCol = "shirename_id";
	}/* END __construct */

	/**
     *  loadAjax
     *
     *  Load Locations for ajax suggest
     * 
     * @param   array   get        	keyword
     * @return  object  			Json object
     * 
     */
	public function loadAjax($get) {
//prexit($get);
		$retVal='';
		$reg_res=array();
		header("Content-Types: application/json");
		$keyword = GeneralUtils::handle_input($get['kw']);
		$keyword = $this->myDB->quote($keyword);

		if($get['type']==0)
		{
			$sql = "SELECT CONCAT(sn.`shirename_shirename`, ' - ', ls.localstate_name)  AS `result_string`
					FROM `shire_names` sn, `local_state` ls
					WHERE sn.shirename_shirename REGEXP '[[:<:]]".$this->myDB->quote($keyword)."'
					  AND sn.shirename_state = ls.localstate_id
				 ORDER BY `result_string`";

			$reg_res = $this->myDB->query($sql);
		}

		$sql = "SELECT DISTINCT CONCAT(st.`shiretown_townname`, ' - ', ls.localstate_name) AS `result_string`
				FROM `shire_towns` st, `shire_names` sn, `local_state` ls
				WHERE `shiretown_townname` REGEXP '[[:<:]]$keyword'
				  AND st.shirename_id = sn.shirename_id 
				  AND sn.shirename_state = ls.localstate_id
				  ORDER BY `result_string`
				  LIMIT 0, {$get['limit']}";

		$sub_res = $this->myDB->query($sql);

		$sql = "SELECT CONCAT(st.`shiretown_townname`, ' - ', ls.localstate_name) AS `result_string`
				FROM `shire_towns` st, `shire_names` sn, `local_state` ls
				WHERE `shiretown_postcode` = '$keyword'
                  AND st.shirename_id = sn.shirename_id 
				  AND sn.shirename_state = ls.localstate_id				 
				LIMIT 0, {$get['limit']}";
		$post_res= $this->myDB->query($sql);

		$cResults = array_merge($reg_res, $sub_res);
		$cResults = array_merge($cResults, $post_res);
		array_splice($cResults, 10);
		echo "{\"results\": [";
		$arr = array();

		for ($i=0;$i<count($cResults);$i++)
		{
			//$arr[] = "{\"id\": \"".$cResults[$i]['result_string']."\", \"value\": \"".ucwords(strtolower($cResults[$i]['result_string']))."\", \"info\": \"\"}";
          $arr[] = "{\"id\": \"".$cResults[$i]['result_string']."\", \"value\": \"".ucwords(strtolower(substr($cResults[$i]['result_string'], 0, strpos($cResults[$i]['result_string'], '-')))).substr($cResults[$i]['result_string'], strpos($cResults[$i]['result_string'], '-'))."\", \"info\": \"\"}";			
		}
		echo implode(", ", $arr);
		echo "]}";

		//        return $retArray;

	}/* END loadAjax */

}/* END ClassificationFacade */
?>