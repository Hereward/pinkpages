<?php
class MainPage extends Smarty {

	var $pageTitle = SITE_NAME;
	var $metaKeywords = '';
	var $metaDescription = '';
	var $canonical = '';
	var $metaTags = array();
	var $header = '';
	var $leftPanel = '';
	var $midPart = '';
	var $footer = '';
	var $do='';

	var $cssStyleFiles = array("pagination.css", "default1.css"); //Default Css
	//    var $jsFiles = array(); //Default JS
	var $jsFiles = array("contact_validation.js","jquery.js","tooltip.js"); //Default JS

	//Control=>Array of actions - to not to display menu on page, add corresponding action & control here
	var $actions = array(
	"IndexControl"=>array("home"),
	
	"ContentControl"=>array("termsAndConditions","contactUs", "privacyStatement","aboutUs", "careers","fetchSuburb"),
	
	"AffiliateControl"=>array("loggedOut"),
	
	"ListingControl"=>array(
	"mapSearch",
	"mapSearchResult",
	"search",
	"categorySearch",
	"boldListing",
	"googleMapView",
	"browseCategory",
	"keyCategorySearch"),
	
	"BusinessControl"=>array(
	"login",
	"doLogin",
	"registrationAdd",
	"busaddition")
	);

	public function __construct() {

		global $request;
		$this->debugging = false;

		$this->template_dir = VIEW_PATH."Default/tpl/";
		$this->compile_dir = VIEW_PATH."Default/tpl_c/";
		$this->assign("SITE_PATH", SITE_PATH);
		if(isset($_SESSION['userid']) && ($_SESSION['userid'])) {
			
			$this->assign("SITE_PATH", SITE_PATH);
			$this->assign("logout_url", $request->createURL("User", "doLogout"));
			$this->assign("home_url", $request->createURL("", ""));
			$this->assign("edit_profile_url", $request->createURL("User","edit"));
			$this->assign("change_pass_url", $request->createURL("User", "password"));
		}
		//setting page titles
		$do = (isset($_GET['do']))?$_GET['do']:"Index";
		$action = (isset($_GET['action']))?$_GET['action']:"home";
		//include(APP_ROOT_ABS_PATH."page_titles.php");
		if(isset($titles[$do][$action])) {
			
			$this->addPageTitle($titles[$do][$action]);
		}
		//setting page titles		
	}

	function addJsFile($file) {
	  $this->jsFiles[] = $file;
	}
	
	function addMetaDescription($desc){
      $this->metaDescription = $desc;
	}
	
	function addMetaKeywords($keywords){
      $this->metaKeywords = $keywords;
	}	
	
	function addMetaTags($name, $content){
	  $this->metaTags[$name] = $content;
	}		

	function loadJsFiles() {
		foreach ($this->jsFiles as $jsFile) {
			$jsFiles[] = "<script src=\"".JS_PATH."$jsFile\" type=\"text/javascript\" language=\"javascript\"></script>";
		}
		return $jsFiles;
	}

	function addCssStyle($file) {
		$this->cssStyleFiles[] = $file;
	}
	
	function addCanonical($url){
        $this->canonical = "<link rel=\"canonical\" href=\"$url\" />";
    }	
	
	function addPageTitle($title) {
		dev_log::write("addPageTitle");
		$this->pageTitle = $title;
	}

	function loadCssStyle() {
		foreach ($this->cssStyleFiles as $cssFile) {
	        $cssFiles[] = "<link href=\"".CSS_PATH."$cssFile\" rel=\"stylesheet\" type=\"text/css\" />";
		}
        return $cssFiles;  		
	}

	function getPage($midPage) {
        
		global $request, $do, $action;
		$this->assign("USERNAMESPACE", USERNAMESPACE);
		$this->assign("IMAGES_PATH", IMAGES_PATH);
		$this->assign("BANNER_PATH", BANNER_PATH);
		$this->assign("ADMIN_EMAIL_ADDR", ADMIN_EMAIL_ADDR);
		$this->assign("DEFAULT_RANK_LIMIT", DEFAULT_RANK_LIMIT);
		$this->assign("CLIENT_IMAGES_PATH", CLIENT_IMAGES_PATH);
		$this->assign("JS_PATH", JS_PATH);
		$this->assign("page_title", $this->pageTitle);
		$this->assign("css_files", $this->loadCssStyle());
		$this->assign("js_files", $this->loadJsFiles());
		$this->assign("meta_description", $this->metaDescription);
		$this->assign("meta_keywords", $this->metaKeywords);
		$this->assign("meta_tags", $this->metaTags);
		$this->assign("canonical", $this->canonical);
		$this->assign("powered_by","Dawson Media");
		$this->assign("business_login",$request->createURL("Business", "login"));
		$this->assign("add_listing",$request->createURL("Listing", "addListing"));
		$this->assign("user_home",$request->createURL("Business", "showhomePageBusiness"));

		if($do == "ListingControl" && $action == "boldListing") {
			/*$this->display("no-header.tpl");*/
			dev_log::write("getPage: A");
		}elseif($do == "ListingControl" && $action == "demoBoldListing") {
			$this->display("no-header.tpl");
			dev_log::write("getPage: B");
		}
		
		elseif(($do == DEFAULT_CONTROL."Control" && $action == DEFAULT_ACTION) || ($do == 'ListingControl' && $action == 'mapSearch') || ($do == 'ListingControl' && $action == 'searchStreetForm')|| ($do == 'ListingControl' && $action == 'businessNameSearch'))
		{
			$this->display("header.tpl");
			dev_log::write("getPage: C");
		}
		else {
			$this->display("header_inner.tpl");
			dev_log::write("getPage: D");
		}

		//{
		if($request->getAttribute("message")) {
			$this->assign("alert_msg", $this->__renderMsg($request->getAttribute("message")));
			$this->display("alert.tpl");
		}
		if($request->getAttribute("message-succ")) {
			$this->assign("alert_msg_succ", $this->__renderMsg($request->getAttribute("message-succ")));
			$this->display("alert.tpl");
		}
		//}
		if(getSession("client_id") && $this->__doShowRightMenu($do, $action) ){

			$this->assign("logout_url",$request->createURL("Business", "doLogout"));
			$this->assign("listing",$request->createURL("Listing", "addListing"));
			$this->assign("viewlisting",$request->createURL("Listing", "viewList"));
			$this->assign("edit",$request->createURL("Business", "edit"));
			$this->assign("client_id",getSession("client_id"));
			$this->assign("affiliate_id",getSession("affiliate_id"));
			$this->display("business_profile_left.tpl");
		}
		else if(getSession("affiliate_id") && $this->__doShowRightMenu($do, $action)){
			$this->assign("client_id",getSession("client_id"));
			$this->assign("affiliate_id",getSession("affiliate_id"));
			$this->assign("logout_url",$request->createURL("Affiliate", "doLogout"));
			$this->display("business_profile_left.tpl");


		}
		
		$this->display($midPage);
		$this->assign("browse_by_category",$request->createURL("Listing", "browseCategory"));
		if(!($do == "ListingControl" && ($action == "boldListing" || $action == "demoBoldListing")) ) {
			$this->display("footer.tpl");
		}
		
	}

	private function __renderMsg($msg) {

		return (is_array($msg))?implode("</li><li>", $msg):$msg;
	}

	private function __doShowRightMenu($do, $action) {

		if(isset($this->actions[$do]) && is_array($this->actions[$do])) {
			if(in_array($action, $this->actions[$do])) {
				return false;
			}
		}
		return true;
	}
}
?>
