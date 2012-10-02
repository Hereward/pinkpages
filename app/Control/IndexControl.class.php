<?php
/**
 *  IndexControl Class
 *
 *  
 *
 *  @author     GA
 *  @version    $Revision: 1.0$
 *  @package    PinkPages.com.au
 *
 */
class IndexControl extends MainControl {
    
    /**
     *  __construct
     *
     *  Set up request object & MainPage object
     *
     *  @param  object  request Request object
     */
    public function __construct($request) {

        parent::__construct($request);
        $this->page = new MainPage();
		
		$this->CommonFacade 		= new CommonFacade($GLOBALS['conn']);
			$alphabets = array('a'=>'A',
		'b'=>'B',
		'c'=>'C',
		'd'=>'D',
		'e'=>'E',
		'f'=>'F',
		'g'=>'G',
		'h'=>'H',
		'i'=>'I',
		'j'=>'J',
		'k'=>'K',
		'l'=>'L',
		'm'=>'M',
		'n'=>'N',
		'o'=>'O',
		'p'=>'P',
		'q'=>'Q',
		'r'=>'R',
		's'=>'S',
		't'=>'T',
		'u'=>'U',
		'v'=>'V',
		'w'=>'W',
		'x'=>'X',
		'y'=>'Y',
		'z'=>'Z');
		$alpha_links = array();
		$i=0;
		foreach ($alphabets as $k=>$v) {
			$alpha_links[$i]["link"] = $this->request->createURL("Listing", "browseCategory", "search=$k");
			$alpha_links[$i]["text"] = $v;
			$i++;
		}
		$this->page->assign("alpha_links",$alpha_links);

    }/* END __construct */
    
    /**
     *  userHome
     *
     *  Open user home page
     */
    public function userHome() {

        $this->page->getPage('userhome.tpl');
    }/* END userHome */
    
    /**
     *  home
     *
     *  Open user home page
     */
    public function home() {

		$alphabets = array('a'=>'A',
		'b'=>'B',
		'c'=>'C',
		'd'=>'D',
		'e'=>'E',
		'f'=>'F',
		'g'=>'G',
		'h'=>'H',
		'i'=>'I',
		'j'=>'J',
		'k'=>'K',
		'l'=>'L',
		'm'=>'M',
		'n'=>'N',
		'o'=>'O',
		'p'=>'P',
		'q'=>'Q',
		'r'=>'R',
		's'=>'S',
		't'=>'T',
		'u'=>'U',
		'v'=>'V',
		'w'=>'W',
		'x'=>'X',
		'y'=>'Y',
		'z'=>'Z');
		$alpha_links = array();
		$i=0;
		foreach ($alphabets as $k=>$v) {
			$alpha_links[$i]["link"] = $this->request->createURL("Listing", "browseCategory", "search=$k");
			$alpha_links[$i]["text"] = $v;
			$i++;
		}
		$this->page->assign("alpha_links",$alpha_links);	
		
		//Add Meta Tags
		$this->page->addMetaDescription("Pink Pages is a local search and business directory that provides truly local results for services and products");
		$this->page->addMetaKeywords("pink pages, truly local, business directory, products, services");		
			
        $this->page->assign("do", "Listing");
        $this->page->assign("action", "search");
		$this->page->assign("home",$this->request->createURL("Affiliate", "showhomePageAffiliate"));
        $this->page->assign("SearchAction",$this->request->createURL("Listing", "search"));
		dev_log::write("home() F1");
		$this->page->assign("browse_by_category",$this->request->createURL("Listing", "browseCategory"));
		$this->page->assign("searchStreetAction",$this->request->createURL("Listing", "searchStreet"));
		$this->page->assign("searchStreetForm",$this->request->createURL("Listing", "searchStreetForm"));
		$this->page->assign("faq",$this->request->createURL("Content", "faq"));
		$this->page->assign("contactUs",$this->request->createURL("Content","contactUs"));
		
        $this->page->addJsFile("bsn.AutoSuggest_2.1.3.js");
        $this->page->addJsFile("default_values.js");		
        $this->page->addCssStyle("autosuggest_inquisitor.css");
		$bannerArray=$this->CommonFacade->getBanner("0");
		dev_log::write("home() F2");
		$this->page->assign("viewdemo",$this->request->createURL("Listing", "demoAddListing"));
		dev_log::write("home() F2.1");
		$this->page->assign("bannerArray",$bannerArray);
		dev_log::write("home() F2.2");
		$resip=$this->CommonFacade->addIp();
		dev_log::write("home() F2.5");
		$this->CommonFacade->popularPageCount("1");
		dev_log::write("home() F3");
        $this->page->getPage('home.tpl');
    }/* END home */
    
    /**
     *  pageNotFound
     *
     *  Triggered when undefined function of this class is called
     */    
    public function pageNotFound() {

        $this->page->getPage('page_not_found.tpl');
    }/* END pageNotFound */
    
}/*END IndexControl*/
?>