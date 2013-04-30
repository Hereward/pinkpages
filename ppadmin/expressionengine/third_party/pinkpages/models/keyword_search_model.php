<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// Pink Pages Model
//extends CI_Model

class keyword_search_model extends Base_model {

	public $my_var = 'My Var is EMPTY';
	public $orig = '[EMPTY GiGi]';
	/*
	 protected $EE;
	 */
	public function __construct()
	{
		//$this->EE =& get_instance();

		//die('whizzzzz');
		
		$this->orig = $this->my_var;
		
		parent::__construct();
		//set a global object
		//$this->EE->pinkpages = $this;
	}

	
	
	public function resolve_classification($keyword='')
	{
		$ppo_db = $this->EE->load->database('ppo', TRUE);
		
		$keyword = $this->handle_input($keyword);

		$classifications = array();
		

		$query_01 = "SELECT
					localclassification_id, localclassification_name
				FROM 
					local_classification 
				WHERE 
					localclassification_name REGEXP '[[:<:]]".$ppo_db->escape_str($keyword)."'";
		
		
		$results_01 = $ppo_db->query($query_01);
        //$my_array = $results_01->result_array();
        //var_dump($my_array);
		if ($results_01->num_rows()) {
			//$classifications =  array_merge($classifications, $results_01->result_array());
			$classifications['c_match'][] = array('ID','CLASSIFICATION');
			$classifications['c_match'] = array_merge($classifications['c_match'], $results_01->result_array());
		}

		$query_02 = "SELECT
					id, keywords.localclassification_id, keywords.keyword, local_classification.localclassification_name
				FROM
					keywords,local_classification
				WHERE
					keywords.keyword REGEXP '[[:<:]]".$ppo_db->escape_str($keyword)."' AND keywords.localclassification_id = local_classification.localclassification_id" ;
		
		//die($query_02);
		
		$results_02 = $ppo_db->query($query_02);
		$num_rows = $results_02->num_rows();
		$my_array = $results_02->result_array();
		//var_dump($my_array);
		//die();

		if ($results_02->num_rows()) {
			//$classifications = array_merge($classifications, $results_02->result_array());
			$classifications['k_match'][] = array('K-ID','C-ID', 'K-VALUE', 'C-VALUE',);
			$classifications['k_match'] = array_merge($classifications['k_match'], $results_02->result_array());
		}
		
		$query_03 = "SELECT id,local_classification.localclassification_id,keyword,localclassification_name from keyword_resolve,local_classification WHERE keyword_resolve.keyword = 
		".$ppo_db->escape($keyword)." AND local_classification.localclassification_id = keyword_resolve.localclassification_id";
		
		//die($query_03);
        $results_03 = $ppo_db->query($query_03);
        $num_rows = $results_03->num_rows();
        //die("$num_rows $query_03");
        if ($num_rows) {
        	$my_array = $results_03->result_array();
        	//var_dump($my_array);
        	//die();
        	$classifications['r_match'][] = array('K-ID','C-ID', 'K-VALUE', 'C-VALUE');
        	$classifications['r_match'] = array_merge($classifications['r_match'], $results_03->result_array());
        }
        
		//var_dump($classifications);
		//die();
		
		// $classifications = array_unique($classifications);
		
		return $classifications;

	}
	
	public function model_test_2() {
		return $this->my_var;
	}

	public function model_test() {
		$this->my_var = 'My Var has been transmofrigied X';
		$ppo_db = $this->EE->load->database('ppo', TRUE);

		$query = "SELECT * FROM `local_businesses` WHERE business_id = 10599250";
		$results = $ppo_db->query($query);

		$bname = $results->row('business_name');

		$res2 = $ppo_db->get('shire_names');
		$shirename = '[no data]';

		//$select_query = $ppo_db->get_compiled_select();

		$row = $res2->row_array(2);
		$shirename = $row['shirename_shirename'];

		/*
		 $row = $res2->row();
		 $shirename = $row->shirename_shirename;
		 */

		/*
		 foreach ($res2->result() as $row)
		 {
			$shirename = $row->shirename_shirename;
			break;
			}
			*/

		//$this->db->get_compiled_select();
		//$this->db->_reset_select();

		$select_query = $ppo_db->last_query();

		$output = "MODEL TEST: business_name = [$bname] [business_id = 10599250] shirename = [$shirename] select_query = [$select_query]";
		return $output;
	}


	/*
	 public function model_test() {
		$ppo_db = $this->EE->load->database('ppo', TRUE);

		$query = "SELECT * FROM `local_businesses` WHERE business_id = 10599250";
		$results = $ppo_db->query($query);

		$bname = $results->row('business_name');

		$res2 = $ppo_db->get('shire_names');
		$shirename = '[no data]';

		//$select_query = $ppo_db->get_compiled_select();

		$row = $res2->row_array(2);
		$shirename = $row['shirename_shirename'];


		//$row = $res2->row();
		//$shirename = $row->shirename_shirename;



		// foreach ($res2->result() as $row)
		// {
		//	$shirename = $row->shirename_shirename;
		//	break;
		// }


		//$this->db->get_compiled_select();
		//$this->db->_reset_select();

		$select_query = $ppo_db->last_query();

		$output = "MODEL TEST: business_name = [$bname] [business_id = 10599250] shirename = [$shirename] select_query = [$select_query]";
		return $output;
		}
		*/

}
// End Class
/* End of file pinkpages_model.php */
/* Location: ./system/expressionengine/third_party/pinkpages/models/pinkpages_model */
