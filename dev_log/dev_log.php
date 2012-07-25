<?php
class dev_log {

	//public static $log_path = '/home/sydneypink/public_html/dev_log/log.txt';
	public static $log_path;
	
    //public static $start_time = '';
	/*
	 function __construct($path='') {
		$this->log_path = "$path/log.txt";
		}
		*/
    static function init($path='') {
    	if (!$path) {
    		$path = "{$_SERVER['DOCUMENT_ROOT']}/dev_log/log.txt";
    	}
    	self::$log_path = $path;
    }
    
	public static function write($msg='',$verbose=false) {
		
		$ts = date("y/m/d : H:i:s", time());

		ob_start();
		debug_print_backtrace();
		$trace = ob_get_contents();
		ob_end_clean();

		$referer = 'VOID';
		if (array_key_exists('HTTP_REFERER', $_SERVER)) {
			$referer = $_SERVER['HTTP_REFERER'];
		}

		$agent = $_SERVER['HTTP_USER_AGENT'];
		$remote_addr = $_SERVER['REMOTE_ADDR'];

		$xtra = '';
		if ($verbose) {
			$xtra = " | agent = [$agent] remote_addr = [$remote_addr] referer = [$referer] trace = $trace";
		}
       
		if (strstr($remote_addr, '60.240.39') || strstr($remote_addr, '192.168.60.108') ) {
			error_log("$ts | $msg $xtra\n", 3, self::$log_path);
		}
		
		 //die($remote_addr);
	}

	public static function cur_url($msg='') {
		$ts = date("y/m/d : H:i:s", time());
		$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https')=== FALSE ? 'http' : 'https';
		$host     = $_SERVER['HTTP_HOST'];
		$script   = $_SERVER['SCRIPT_NAME'];
		$params   = $_SERVER['QUERY_STRING'];
		$currentUrl = $protocol . '://' . $host . $script . '?' . $params;
		$remote_addr = $_SERVER['REMOTE_ADDR'];
		if (strstr($remote_addr, '60.240.39') || strstr($remote_addr, '192.168.60.108') )  {
			error_log("$ts | $currentUrl | $msg\n", 3, self::$log_path);
		}
		return $currentUrl;
	}
	
	
     public static function get_cur_url() {
		$ts = date("y/m/d : H:i:s", time());
		$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https')=== FALSE ? 'http' : 'https';
		$host     = $_SERVER['HTTP_HOST'];
		$script   = $_SERVER['SCRIPT_NAME'];
		$params   = $_SERVER['QUERY_STRING'];
		$currentUrl = $protocol . '://' . $host . $script . '?' . $params;
		$remote_addr = $_SERVER['REMOTE_ADDR'];
		return $currentUrl;
	}
	
	public function timer($func) {
		static $start_time;
		$ts = date("y/m/d : H:i:s", time());
		if ($func == 'set') {
			$start_time = time();
			error_log("$ts | start timer\n", 3, self::$log_path);
		} elseif ($func == 'get') {
			$curr = time();
			$diff =  $curr-$start_time;
			error_log("$ts | timer = $diff secs\n", 3, self::$log_path);
		}
		
	}



	function backtrace($trace) {
		//var_dump(debug_print_backtrace());
			
		ob_start();
		debug_print_backtrace();
		$trace = ob_get_contents();
		ob_end_clean();

		//var_dump(debug_backtrace());

	}
	
	function dump_obj($obj) {
		ob_start();
		var_dump($obj);
		$obj_str = ob_get_contents();
		ob_end_clean();
		return $obj_str;
	}

}

dev_log::init();