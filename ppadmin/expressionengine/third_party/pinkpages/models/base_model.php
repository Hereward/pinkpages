<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// Base Model
//extends CI_Model

class Base_model extends CI_Model {

    protected $EE;
    public $base_url;

    public function __construct()
    {
        $this->EE =& get_instance();
        $this->ppo_db = $this->EE->load->database('ppo', TRUE);
        $this->base_url = $this->EE->config->config['base_url'];
        //set a global object
        //$this->EE->pinkpages = $this;
    }

    public function urlify($input) {
        $str = preg_replace("/[^A-Za-z0-9\- ]/", '', $input);
        $str = preg_replace('!\s+!', ' ', $input);
        $str = preg_replace('!\'!', '', $input);
        $str_unencoded = strtolower($str);
        $str = urlencode($str_unencoded);

        $root_url = "http://{$_SERVER['SERVER_NAME']}";
        //print_r($this->EE->config->config);
        //die();
        //$root = $_SERVER['DOCUMENT_ROOT'];
        return $str;

    }

    public function sanitize($input) {
        $value = preg_replace("/[^A-Za-z0-9&'\\- ]/", '', $input);
        $value = preg_replace('!\s+!', ' ', $value);
        $value = trim($value);
        //$value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        //$value = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        //die("[$value]");

        //$value = urlencode($value);
        // die("[$value]");
        return $value;
    }

    public function handle_input($input) {

        if(empty($input)) return "";
        //$value = ereg_replace("\[\]$","",$input);
        //$value = preg_replace("\[\]$","",$input);
        $value = preg_replace("/&#124;/", "|", $input);
        $value = stripslashes( html_entity_decode( $value ) );
        return trim($value);
    }

    function get_variable_from_session($key) {
        if (array_key_exists($key,$_SESSION)) {
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    function session_keys_exist($keys=array()) {
        foreach ($keys as $key) {
            if (array_key_exists($key,$_SESSION)) {
                return TRUE;
            } else {
                die("SESSION KEY MISSING: $key");
                return FALSE;
            }
        }
    }


}
// End Class
/* End of file base_model.php */
/* Location: ./system/expressionengine/third_party/pinkpages/models/base_model */
