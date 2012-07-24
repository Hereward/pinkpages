<?php
class AdminPage extends Smarty {

	var $pageTitle = '';
	var $metaKeywords = '';
	var $metaDescription = '';
	var $header = '';
	var $leftPanel = '';
	var $midPart = '';
	var $footer = '';


	var $cssStyleFiles = array("admin_stylesheet.css", "pagination.css"); //Default Css
	var $jsFiles = array("prototype.1.6.js","jquery.js", "main.js", "tooltip.js"); //Default JS
  	//var $jsFiles = array(); //Default JS

	public function __construct() {

		global $request;
		$this->debugging = false;

		$this->template_dir = ADMIN_VIEW_PATH."Default/tpl/";
		$this->compile_dir = ADMIN_VIEW_PATH."Default/tpl_c/";
        $this->assign("SITE_PATH", SITE_PATH); 
		$this->assign("JS_PATH", JS_PATH);
		$this->assign("ADMIN_JS_PATH", ADMIN_JS_PATH);
		
		if(getSession('userid')) {
			
			$this->assign("namespace", USERNAMESPACE);
			$this->assign("SITE_PATH", SITE_PATH); 
		    $this->assign("JS_PATH", JS_PATH);
			$this->assign("CLIENT_IMAGES_PATH", CLIENT_IMAGES_PATH);
			$this->assign("logout_url", $request->createURL("User", "doLogout"));
			$this->assign("home_url", $request->createURL("Admin", "showhomePageAdmin"));
			$this->assign("edit_profile_url", $request->createURL("User","edit"));
			$this->assign("change_pass_url", $request->createURL("User", "password"));
			$this->assign("blog_url", $request->createURL("Blog", "loadall"));
		}
	}

	function addJsFile($file) {
		$this->jsFiles[] = $file;
	}
	
	function removeJsFile($file) {
		foreach($this->jsFiles as $k=>$v) {
			if($file == $v) unset($this->jsFiles[$k]);
		}
	}

	function loadJsFiles() {
		foreach ($this->jsFiles as $jsFile) {
			echo "<script src=\"".JS_PATH."$jsFile\" type=\"text/javascript\" language=\"javascript\"></script>";
		}
	}

	function addCssStyle($file) {
		$this->cssStyleFiles[] = $file;
	}

	function loadCssStyle() {
		foreach ($this->cssStyleFiles as $cssFile) {
			echo "<link href=\"".ADMIN_CSS_PATH."$cssFile\" rel=\"stylesheet\" type=\"text/css\" />";
		}
	}

	function getPage($midPage) {

		global $request;
		
		$output = '';

		$this->assign("LOGO_PATH", LOGO_PATH);
		$this->assign("IMAGES_PATH", ADMIN_IMAGES_PATH);
		$this->assign("BANNER_UPLOAD_PATH", BANNER_UPLOAD_PATH);
		$this->assign("BANNER_PATH", BANNER_PATH);
		
		$this->assign("ADMIN_SITE_PATH", ADMIN_SITE_PATH);
		$this->assign("page_title", $this->pageTitle);
		$this->assign("css_files", $this->loadCssStyle());
		$this->assign("js_files", $this->loadJsFiles());
		$this->assign("meta_description", $this->metaDescription);
		$this->assign("meta_keywords", $this->metaKeywords);


		//$this->display("header.tpl");
		$output .= $this->fetch("header.tpl");
		if($request->getAttribute("message")) {
			$this->assign("alert_msg", $this->renderMsg($request->getAttribute("message")));
			//$this->display("alert.tpl");
			$output .= $this->fetch("alert.tpl");
		}
		if($request->getAttribute("message-succ")) {
			$this->assign("alert_msg_succ", $this->renderMsg($request->getAttribute("message-succ")));
			//$this->display("alert.tpl");
			$output .= $this->fetch("alert.tpl");
		}
		if(getSession("userid")&& getSession("localuser_access")=='admin'&& getSession("localuser_status")!="0")
		{
		    $this->assign("isAdmin", AccessDetails::isAdmin(getSession('username')));		
			$this->assign("logout_url",$request->createURL("Admin", "doLogout"));
			$this->assign("MultipleListngMgr_url",$request->createURL("AdminListing", "addListing"));
			$this->assign("viewlisting",$request->createURL("AdminListing", "viewList"));
			$this->assign("edit",$request->createURL("Business", "edit"));
			$this->assign("home_url",$request->createURL("Admin", "showhomePageAdmin"));
			if(isset($_GET['action'])){
				$currentAction				= $_GET['action'];
			}else {
				$currentAction				= '';
			}
			$menuArray = array('view_operation_hour_history',
						'view_operation_day_history',
						'view_key_history',
						'view_history',
						'view_classification_history',
						'view_rank_history',
						'showRankReport',
						'showClientDetails');
			if(!in_array($currentAction,$menuArray))
			{
			//$this->display("menu.tpl");
			$output .= $this->fetch("menu.tpl");
			}
		}
		else
		{
			if(getSession("userid")&& getSession("localuser_access")=='Employee'&& getSession("localuser_status")!="0")
			{
				//$this->assign("logout_url",$request->createURL("Admin", "doLogout"));
				//$this->assign("listing",$request->createURL("Employee", "addListing"));
				//$this->assign("viewlisting",$request->createURL("Employee", "viewList"));
				//$this->assign("edit",$request->createURL("Business", "edit"));
				//$this->assign("home_url",$request->createURL("Admin", "showhomePageEmployee"));
				//$this->assign("search",$request->createURL("SalesAccountManager","searchBusiness"));
				//$this->assign("addbusinessform",$request->createURL("Employee", "addListing"));
				//$this->display("menu.tpl");
				$output .= $this->fetch("menu.tpl");
			}
			
		}

		if(getSession("userid")&& getSession("localuser_access")=='SAcManager'&& getSession("localuser_status")!="0")
		{
			//$this->assign("logout_url",$request->createURL("Admin", "doLogout"));
			//$this->assign("listing",$request->createURL("SalesAccountManager", "addListing"));
			//$this->assign("viewlisting",$request->createURL("SalesAccountManager", "viewList"));
			//$this->assign("edit",$request->createURL("SalesAccountManager", "edit"));
			//$this->assign("addemployee",$request->createURL("SalesAccountManager","registrationAdd"));
			//$this->assign("home_url",$request->createURL("Admin", "showhomePageSalesManager"));
			//$this->assign("search",$request->createURL("SalesAccountManager","searchBusiness"));
			//$this->assign("addbusinessform",$request->createURL("SalesAccountManager", "addListing"));
			//$this->assign("searchemployee",$request->createURL("SalesAccountManager","searchEmployee"));
			//$this->display("menu.tpl");
			$output .= $this->fetch("menu.tpl");
		}
	

		//        $this->display("leftpanel.tpl");

		//$this->display($midPage);
        //$mp_content = $this->fetch($midPage);
        $output .= $this->fetch($midPage);
        //echo $mp_content;
		//$this->display("footer.tpl");
		$output .= $this->fetch("footer.tpl");
		echo $output;
	}

	private function renderMsg($msg) {

		return (is_array($msg))?implode("<br />", $msg):$msg;
	}

	public function assignCMS($arr){
		$this->assign("cmsArray", $arr);
	}


}

?>