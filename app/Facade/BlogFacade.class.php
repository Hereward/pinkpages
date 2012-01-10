<?php

/**
 *  BlogFacade Class
 *
 *  
 *  @author     Vinod Kumar
 *  @package    Project Name
 *
 */

class BlogFacade extends MainFacade {

    /**
     *  __construct
     *
     *  Instantiate BlogService Object
     */
    public function __construct(MyDB $MyDB, Request $request) {

        parent::__construct($MyDB, $request);
       
        $this->MyDB->table="blog";
        $this->MyDB->sequenceName="blog";
        $this->MyDB->primaryCol="blogId";

    }/* END __construct */

    /**
     *  countAll
     *
     *  count all blogs
     * 
     * @return  int   ret    count all blogs
     * 
     */
    public function countAll() {
        $ret = 0;
        $this->MyDB->setSelect("count(blogId) as cnt");
        $result = $this->MyDB->getAll();
        $ret = $result[0]['cnt'];
        return $ret;
    }/* END countAll */

    /**
     *  fetchAll
     *
     *  select all Blog
     * 
     * @return  array   retArray    all blogs
     * 
     */
    public function fetchAll($fr=0, $noOfRecords=DEFAULT_PAGING_SIZE) {
        $retArray = array();
        $this->MyDB->reset();
        $blogs = $this->MyDB->getAll($fr, $noOfRecords);
        if($blogs) {
            foreach ($blogs as $key=>$blog) {
                $blogs[$key]['blog_del_url'] = $this->request->createURL("Blog","del", "id={$blog["blogid"]}");
            }
        }
        $retArray['blogs'] = $blogs;
        $retArray['paging'] = Paging::numberPaging($this->countAll(), $fr, $noOfRecords);
        return $retArray;
    }/* END fetchAll */

    /**
     *  insert
     *
     *  Add new blog
     * 
     * @param   array   post        blog related data
     * @return  array   retArray    bool result & message
     * 
     */
    public function insert($post) {

        $data = array("UserId"=>getSession('userid'),"title"=>$post['Title'], "description"=>$post['Description']);
        $retArray = $this->MyDB->save($data);
        return $retArray;

    }/* END insert */


    /**
     *  detailBlog
     *
     *  Whole detail of a particular Blog
     * 
     * @param   array   variable    Blog id
     * @return  array   retArray    blog detail
     * 
     */
    public function detailBlog($blogId) {

        $retArray = array("result"=>false, "message"=>'');

        return $retArray;
    } /* END detailBlog */


    /**
     *  delete
     *
     *  Delete the Blog
     * 
     * @param   int     variable    blog id
     * @return  array   retArray    bool result & message 
     */
    public function delete($blogId) {

        $retArray = array("result"=>false, "message"=>'Blog deleted!!');
        $this->blogService->blogId = $blogId;
        if($this->blogService->delete()) {
            $retArray['result'] = true;
        }
        else {
            $retArray['message'] = "Couldn't delete!!";
        }
        return $retArray;
    } /* END delete */


    /**
     *  addComment
     *
     *  Add comment to the blog
     * 
     * @param   array   post        blog id and comment data
     * @return  array   retArray    bool result & message
     * 
     */
    public function addComment($post) {

    }/* END addComment */


    /**
     *  delComment
     *
     *  Delete the comment of a blog
     * 
     * @param   int     variable    comment id
     * @return  array   retArray    bool result & message 
     */
    public function delComment($commentId) {


    } /* END delComment */

}/*END BlogFacade*/
?>