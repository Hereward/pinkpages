<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class keyword_search_controller extends Base_Controller {

	protected $EE;

	public function __construct($args='') {
		//die('boo');
		parent::__construct($args);
	}

	public function index() {
		$this->EE->load->library('table');
		$parameter = $this->EE->TMPL->fetch_param('type');
		$this->EE->load->model('keyword_search_model');
		//var_dump($_GET);
		//die();
		$keyword = $_POST['Search1'];
		$location = $_POST['Search2'];
		
		$classies = $this->EE->keyword_search_model->resolve_classification($keyword);
		//var_dump($classies['r_match']);
		//die();
		
		$tmpl = array ( 'table_open'  => '<table border="1" cellpadding="5" cellspacing="1" class="mytable">' );
		$this->EE->table->set_template($tmpl); 
		
		$c_table = ($classies['c_match'])?$this->EE->table->generate($classies['c_match']):'<span style = "color:red">Zero Matches</span>';
		$k_table = ($classies['k_match'])?$this->EE->table->generate($classies['k_match']):'<span style = "color:red">Zero Matches</span>';
		$r_table = ($classies['r_match'])?$this->EE->table->generate($classies['r_match']):'<span style = "color:red">Zero Matches</span>';
		
		//die($r_table);
		
		//die($c_table);
		
		$vars = array('c_table'=>$c_table, 'k_table'=>$k_table, 'r_table'=>$r_table, 'keyword'=>$keyword, 'area'=>$location);
		return $this->EE->load->view('resolve_classification', $vars, TRUE);
		//return "RESOLVING CLASSIFICATION... Keyword = [{$_GET['Search1']}] Area = [{$_GET['Search2']}]";
		
		/*
		$output = "A. This is a test function of the PP 2 module - YAY IT WORKS!";
		$lib_test = $this->EE->pinkpages_lib->library_test();
		$mod_test = $this->EE->pinkpages_model->model_test();
		$my_var = $this->EE->pinkpages_model->my_var;
		$orig = $this->EE->pinkpages_model->orig;

		return "$output<br/>$lib_test<br/>$mod_test<br/>my_var = $my_var<br/>orig = $orig<br/><br/>";
		
		*/

	}

}
