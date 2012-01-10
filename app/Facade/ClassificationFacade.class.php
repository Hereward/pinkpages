<?php
class ClassificationFacade extends MainFacade {

	private $used_group_ids = array();
	private $nodes = array();
	/**
     *  __construct
     *
     *  Instantiate MyDb object
     */
	public function __construct(MyDB $MyDB) {

		$this->myDB = $MyDB;
		$this->myDB->table = TBL_LOCAL_CLASSIFICATION;
		$this->myDB->sequenceName = TBL_LOCAL_CLASSIFICATION;
		$this->myDB->primaryCol = "localclassification_id";
	}/* END __construct */

	/**
     *  loadAjax
     *
     *  Load Classifications for ajax suggest
     * 
     * @param   array   get            keyword
     * @return  object              Json object
     * 
     */
	public function insertNode(&$nodes, $new_node, $gp_id) {

		foreach ($nodes as $k=>$node) {
			if($node['group_id'] == $gp_id) {
				$nodes['child'] = array_push($nodes[$k]['child'], $new_node);
				return ;
			}
			else {
				$this->insertNode($nodes[$k]['child'], $new_node, $gp_id);
			}
		}
	}

	/**
     *  loadAjax
     *
     *  Load Classifications for ajax suggest
     * 
     * @param   array   get            keyword
     * @return  object              Json object
     * 
     */
	public function getTree1($gp_id, &$new_node) {

		$sql = "SELECT group_id, group_title, level, parent_id FROM groups WHERE group_id=$gp_id";
		$rs = $this->myDB->query($sql);
		$new_node = array(
		"group_label"=>str_repeat("....",$rs[0]['level']).$rs[0]['group_title'],
		"group_title"=>$rs[0]['group_title'],
		"group_id"=>$rs[0]['group_id'],
		"level"=>$rs[0]['level'],
		"classifications"=>array(),
		"child"=>array($new_node)
		);
		if(in_array($gp_id, $this->used_group_ids)) {
			return ;
		}
		$this->used_group_ids[] = $gp_id;
		if($rs[0]['parent_id']) {
			$this->getTree1($rs[0]['parent_id'],$new_node);
		}
		return $new_node;
	}

	public function pushInTree(&$root_node, $clf) {

		foreach ($root_node as &$node) {
			if($node) {
				if($node['group_id'] == $clf['group_id']) {
					//insert
					//				prexit($node);
					$node['classifications'][] = $clf;
					return ;
				}
				else {
					if(isset($node['child']) && $node['child']) {

						$this->pushInTree($node['child'], $clf);
					}
					else {
						return ;
					}
				}
			}
		}
	}

	public function loadAjax($get) {

		$keyword = GeneralUtils::handle_input($get['kw']);
		$keyword = $this->myDB->quote($keyword);
		$suggest_arr = array();
		$all_groups = array();
		$classifications = array();
		$sql = "SELECT
					group_id, level, group_title
				FROM 
					groups
				WHERE 
					`group_title` REGEXP '[[:<:]]$keyword'
				ORDER BY
					level DESC
					";
		$rs = $this->myDB->query($sql);
		foreach ($rs as $gp) {
			$all_groups[$gp['level']][] = $gp;
		}
		//		prexit($all_groups);
		/*

		for($i=0;$i<count($rs);$i++) {
		if($rs[$i]['group_id']!=0) {
		$arr=array();
		$tree = $this->getTree1($rs[$i]['group_id'], $arr);
		if($tree) {
		$this->nodes[] = $tree;
		}
		}
		}*/
		//		header("Content-Type: application/json");
		$sql = "SELECT
					cv.*,
					gc.group_id,
					gp.group_title,
					gp.level
				FROM 
					(
					classifications_v AS cv 
					LEFT JOIN group_classification AS gc
					ON (cv.id = gc.classification_id)
					)
					LEFT JOIN groups as gp
						ON (gc.group_id=gp.group_id)
				WHERE 
					cv.`localclassification_name` REGEXP '[[:<:]]$keyword'
				ORDER BY gp.level DESC";
		//prexit($sql);
		$c_res = $this->myDB->query($sql);
		foreach ($c_res as $gp) {
			if($gp['level'])
			$all_groups[$gp['level']][] = $gp;
		}

		//pushing classifications in group tree

		foreach($all_groups as $level) {
			foreach($level as $group) {
				$arr=array();
				$tree = $this->getTree1($group['group_id'], $arr);
				if($tree) {
					$this->nodes[] = $tree;
				}
			}
		}

		foreach ($c_res as $clf) {
			if($clf['group_id']) {
				$this->pushInTree($this->nodes, $clf);
			}
			else {
				$classifications[] = $clf;
			}
		}
//		pre($classifications);
//		prexit($this->nodes);
		foreach ($classifications as $clf) {
			$suggest_arr[] = "{\"id\": \"".$clf['localclassification_name']."\", \"value\": \"".$clf['localclassification_name']."\", \"info\": \"\"}";
		}
		foreach ($this->nodes as $grp) {
			$this->createTree($grp, $suggest_arr);
		}
//		prexit($suggest_arr);
		
		echo "{\"results\": [";
		
		echo implode(", ", array_unique($suggest_arr));
		echo "]}";

	}/* END loadAjax */

	public function createTree($node, &$suggest_arr) {
		
		$suggest_arr[] = "{\"id\": \"".$node['group_title']."\", \"value\": \"".$node['group_label']."\", \"info\": \"\"}";
		foreach ($node['classifications'] as $clf) {
			$suggest_arr[] = "{\"id\": \"".$clf['localclassification_name']."\", \"value\": \"".str_repeat("....",$clf['level']+1).$clf['localclassification_name']."\", \"info\": \"\"}";
		}
		if($node['child']) {
			foreach ($node['child'] as $node) {
				if($node)
					$this->createTree($node, $suggest_arr);
			}
		}
	}
	public function getGroups($cl_id) {

		$sqlGroup="SELECT group_id FROM
						group_classification 
					WHERE 
						classification_id={$cl_id}";
		$rs = $this->myDB->query($sqlGroup);
		$arr=array();
		for($i=0;$i<count($rs);$i++) {
			if($rs[$i]['group_id']!=0) {
				$this->getTree($rs[$i]['group_id'], $arr);
			}
		}
		return array_reverse($arr);
	}

	public function getTree($gp_id, &$arr) {

		$sql = "SELECT * FROM groups WHERE group_id=$gp_id";
		$rs = $this->myDB->query($sql);
		$arr[] = "{\"id\": \"".$rs[0]['group_title']."\", \"value\": \"".str_repeat("....",$rs[0]['level']).$rs[0]['group_title']."\", \"info\": \"\"}";
		;
		if($rs[0]['parent_id']) {
			$this->getTree($rs[0]['parent_id'],$arr);
		}
	}
	
	public function getClassificationNameById($classification_id) {

		if($classification_id) {
			$sql = "SELECT localclassification_name FROM local_classification  WHERE localclassification_id=$classification_id";
			$rs = $this->myDB->query($sql);
		
			if($rs[0]['localclassification_name']) {
				return $rs[0]['localclassification_name'];
			}
		}
		return "";
	}
	
	public function getClassificationDescription($classification_id){
	
	  $sql = "SELECT localclassification_description
	            FROM content_classification_description
			   WHERE localclassification_id = " . GeneralUtils::handle_input($classification_id);
			   			   
      $results = $this->myDB->query($sql);			   
	  
	  if($results)
	    $description = $results[0]['localclassification_description'];
      else
        $description = false;	  
	  
	  return $description;
	
	}
	
	public function getClassificationSnippet($classification_id, $page){
	
	  $sql = "SELECT content_snippet
	            FROM content_classification_snippet
			   WHERE localclassification_id = " . GeneralUtils::handle_input($classification_id) .
			   " AND page_number = " . GeneralUtils::handle_input($page);
								
      $results = $this->myDB->query($sql);				
	  
      return $results;
	  
	}

}/* END ClassificationFacade */

?>