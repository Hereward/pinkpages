<?php
/**
 *  BlogControl Class
 *
 *  
 *
 *  @author     Vinod Kumar
 *  @version    $Revision: 1.0$
 *  @package    Project Name
 *
 */
class BlogControl extends MainControl {

	private $blogFacade;
	
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
		$this->blogFacade = new BlogFacade($GLOBALS['conn'], $request);
		
	}/* END __construct */
    
    /**
     *  loadAll
     *
     *  Load user's scraps
     */
	public function loadAll() {
	    
        $countRow = $this->blogFacade->countAll();
        
        $this->request->setAttribute("noOfRecords", $countRow);
	    
        $result = $this->blogFacade->fetchAll($this->request->getAttribute("fr"), $this->request->getAttribute("pg_size"));
        $this->page->assign("blogArray", $result['blogs']);
        $this->page->assign("paging", $result['paging']);
        $this->page->assign("blog_add_url", $this->request->createURL("Blog","add"));
        
        $this->page->getPage('blogs.tpl');
	}/* END loadAll */
	
	/**
     *  add
     *
     *  Display the form for add blog
     * 
     */    
    public function add() {

        $this->page->assign('action', $this->request->createURL("Blog","insert"));
        $this->page->getPage('add_blog.tpl');
    }/* END add */
    
    /**
     *  insert
     *
     *  Inser new blog
     * 
     */    
    public function insert() {
        
        $retArray = $this->blogFacade->insert($_POST);
        
        if($retArray['result']){
        
            $this->request->redirect("Blog", "loadAll");// Success
        }
        else{
        
            $this->request->setAttribute("message", $res['message']);
            $this->add();
        }
    }/* END insert */
    
    
    /**
     *  detailBlog
     *
     *  detail of the Blog
     * 
     */	
	public function detailBlog() {
		
	}/* END detailBlog */
	
	/**
     *  del
     *
     *  delete blog
     * 
     */    
    public function del() {
        
        $retArray = $this->blogFacade->delete($_GET['id']);
        $this->request->setAttribute("message", $retArray['message']);
        $this->loadAll();
    }/* END del */
    
    /**
     *  addComment
     *
     *  Add comment to a particular Blog
     * 
     */    
    public function addComment() {
        
        $retArray = $this->blogFacade->addComment();
    }/* END addComment */
    
    /**
     *  delComment
     *
     *  delete comment of a particular blog
     * 
     */    
    public function delComment() {
        
    }/* END delComment */
	
}/*END BlogControl*/
?>