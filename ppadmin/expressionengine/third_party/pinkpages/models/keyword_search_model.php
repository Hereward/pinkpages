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
		$this->orig = $this->my_var;
		parent::__construct();
	}


    public function c_match($keyword) {
        //$first_word_pattern =  "^[[:<:]]{$this->ppo_db->escape_str($keyword)}.*$";

        $w = $this->ppo_db->escape_str($keyword);
        $first_word_pattern =  "^({$w}|{$w}[[.space.]]+.*)$";

        $query = "SELECT
					localclassification_id, localclassification_name
				FROM
					local_classification
				WHERE
					localclassification_name REGEXP '".$first_word_pattern."'";

        $results = $this->ppo_db->query($query);

        if ($results->num_rows()) {
            return $results;
        } else {
            return FALSE;
        }
    }
	
    public function r_match($keyword) {
		$query = "
		SELECT 
		   id,local_classification.localclassification_id,keyword,localclassification_name 
		FROM 
		   keyword_resolve,local_classification 
		WHERE 
		   keyword_resolve.keyword = ".$this->ppo_db->escape($keyword)." 
		AND 
		   local_classification.localclassification_id = keyword_resolve.localclassification_id";
		
		$results = $this->ppo_db->query($query);
		
		if ($results->num_rows()) {
			return $results;
		} else {
			return FALSE;
		}
	}
	
	
    public function k_match($keyword) {
		//$first_word_pattern =  "^[[:<:]]{$this->ppo_db->escape_str($keyword)}.*$";
		$w = $this->ppo_db->escape_str($keyword);
		$first_word_pattern =  "^({$w}|{$w}[[.space.]]+.*)$";
		//^(car|car[[.space.]]+.*)$
		$query = "SELECT
					id, keywords.localclassification_id, keywords.keyword, local_classification.localclassification_name
				FROM
					keywords,local_classification
				WHERE
					keywords.keyword REGEXP '".$first_word_pattern."' 
				AND 
				    keywords.localclassification_id = local_classification.localclassification_id" ;
		
		$results = $this->ppo_db->query($query);
		
		if ($results->num_rows()) {
			return $results;
		} else {
			return FALSE;
		}
	}



    public function resolve_classification($keyword='')
    {
        $keyword = $this->handle_input($keyword);

        $word_array = explode(' ',$keyword);
        $short_key = $word_array[0];

        $w_list = array('full'=>$keyword);

        if (count($word_array)>1) {
            $w_list['short'] = $short_key;
        }


        $output = array();

        foreach ($w_list as $label=>$key) {
            $classifications = array();
            $functions = array('c_match', 'r_match', 'k_match');

            foreach ($functions as $f) {
                $classifications[$f] = FALSE;
                $results = $this->$f($key);

                if ($results) {
                    $classifications[$f][] = array('ID','CLASS','KEYWORD','C_NAME');
                    $classifications[$f] = array_merge($classifications[$f], $results->result_array());
                }
            }
/*
            if ($label == 'short') {
                var_dump($classifications);
                die();
            }
*/
            $output[$label] = $classifications;
        }

        //var_dump($output);
        //die();

        return $output;

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
