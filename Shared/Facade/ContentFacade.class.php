<?php
class ContentFacade extends MainFacade {

	public function __construct(MyDB $MyDB){           //Start of The __contructor.purpose is to assign database parmeters to                                                           //a variable acting as an object and using that object to declare
		$this->MyDB = $MyDB;                             //the table name,sequence name and primary column.
		$this->MyDB->table="cms";
		$this->MyDB->sequenceName="cms";
		$this->MyDB->primaryCol="id";
	}

	public function pageAdd($post)
	{
		$SQL="INSERT INTO `pinkpages`.`cms` (

`meta_description` ,
`meta_tag` ,
`title_tag` ,
`page_title` ,
`page_content` 

)
VALUES (
 '{$post['metadescription']}', '{$post['metatag']}', '{$post['title-tag']}', '{$post['page-title']}', '{$post['pagecontent']}'
)";

		//prexit($SQL);
		$this->MyDB->query($SQL);
		$retArray = array("result"=>true, "message"=>'Successfully saved');
		return $retArray;

	}

	public function fetchDetails()
	{
		$this->MyDB->reset();
		$SQL="SELECT * FROM cms";
		$result=$this->MyDB->query($SQL);
		return  $result;
	}

	public function editfetchDetails()
	{
		$id=$_GET['ID'];
		$SQL="SELECT * FROM cms where id=$id";//prexit($SQL);
		$result=$this->MyDB->query($SQL);//prexit($result);
		return  $result;
	}

	public function editAdd($post)
	{
		$id=$_GET['ID'];
		$sql=array('meta_description'=>$post['metadescription'],
		'meta_tag'=>$post['metatag'],
		'title_tag'=>$post['title-tag'],
		'page_title'=>$post['page-title'],
		'page_content'=>$post['pagecontent']
		);

		$this->MyDB->setWhere("id=$id"); //prexit($sql);
		$this->MyDB->update($sql);
		$Array = array("result"=>true, "message"=>'Updated Successfully');
		return $Array;
	}

	public function delList()
	{
		$ID			=$_GET['ID'];
		$condition  =$ID;//prexit($condition);
		$this->MyDB->remove($condition);
		$Array = array("result"=>true, "message"=>'Deleted Succesfully');
		return $Array;
	}

	public function fetchPrivacyDetails()
	{
		$id=59;
		$SQL="SELECT * FROM cms where id=$id";//prexit($SQL);
		$result=$this->MyDB->query($SQL);//prexit($result);
		return  $result;
	}

	/*public function fetchfooterDetails()
	{
	$SQL="SELECT * FROM cms";
	$result=$this->MyDB->query($SQL);
	return  $result;
	}*/

	public function termsAndConditionsDetails()
	{
		$id=54;
		$SQL="SELECT * FROM cms where id=$id";//prexit($SQL);
		$result=$this->MyDB->query($SQL);//prexit($result);
		return  $result;
	}

	public function contactUs()
	{
		$id=54;
		$SQL="SELECT * FROM cms where id=$id";//prexit($SQL);
		$result=$this->MyDB->query($SQL);//prexit($result);
		return  $result;
	}
}
?>