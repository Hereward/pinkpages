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
		@$res1 =$this->__userRegisterValidation($post);
		if(!@$res1['result'])
		{
			return $res1;
		}
		else
		{
			if(@$post['meta_description']==''&&@$post['meta_tag']==''&&@$post['title_tag']=='')
			{
				$SQL="INSERT
	        INTO `cms` (
									`page_title` ,
									`page_content`,
									 peramlink  
			                        )
		    VALUES (
		 '{$post['page-title']}', '{$post['pagecontent']}','{$post['peramlink']}'
		)";
			}

			if(@$post['meta_description']==''&&@$post['meta_tag']!=''&&@$post['title_tag']!='')
			{
				$SQL="INSERT
	       INTO `cms` (
								`meta_tag` ,
								`title_tag` ,
								`page_title` ,
								`page_content`,
								 peramlink  
								
		                          )
		  VALUES (
		 '{$post['metatag']}', '{$post['title-tag']}', '{$post['page-title']}', '{$post['pagecontent']}','{$post['peramlink']}'
		)";
			}

			if(@$post['meta_description']!=''&&@$post['meta_tag']==''&&@$post['title_tag']!='')
			{
				$SQL="INSERT
	       INTO `cms` (
								`meta_description` ,
								`title_tag` ,
								`page_title` ,
								`page_content`,
								 peramlink  
								
	                              )
	       VALUES (
	'{$post['metadescription']}', '{$post['title-tag']}', '{$post['page-title']}', '{$post['pagecontent']}','{$post['peramlink']}'
	)";

			}

			if(@$post['meta_description']!=''&&@$post['meta_tag']!=''&&@$post['title_tag']=='')
			{
				$SQL="INSERT
	        INTO `cms` (
									`meta_description` ,
									`meta_tag` ,
									`page_title` ,
									`page_content`,
									 peramlink  
		                            )
		   VALUES (
		 '{$post['metadescription']}', '{$post['metatag']}', '{$post['title-tag']}', '{$post['pagecontent']}','{$post['peramlink']}'
		)";

			}
			else
			{
				$SQL="INSERT
	       INTO `cms` (
									`meta_description` ,
									`meta_tag` ,
									`title_tag` ,
									`page_title` ,
									`page_content`,
									 peramlink 

                                   )
          VALUES (
         '{$post['metadescription']}', '{$post['metatag']}', '{$post['title-tag']}', '{$post['page-title']}', '{$post['pagecontent']}','{$post['peramlink']}'
)";
			}
			$this->MyDB->query($SQL);
			$retArray = array("result"=>true, "message"=>'Successfully saved');
			return $retArray;
		}
	}


	private function __userRegisterValidation(&$data)
	{

		$retArray = array("result"=>false, "message"=>'');
		$errors = array();
		if(empty($data['page-title']))
		{
			$errors[] = "Page Title is blank!!";
		}
		if(empty($data['pagecontent']))
		{
			$errors[] = "Page Content is blank!!";
		}
		if(empty($data['peramlink']))
		{
			$errors[] = "Page Url is blank!!";
		}else{
			if(isset($data['ID'])&& $data['ID']!='')
			{
				$con=" and id <> {$data['ID']}";
			}
			else{
				$con='';
			}
			$sql="select peramlink from cms where peramlink='".addslashes($data['peramlink'])."' $con";
			$result2=$this->MyDB->query($sql);
			if(count($result2)>0){
				$errors[] = "Page Url is already exist!!";

			}
		}
		if(count($errors) == 0)
		{
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		
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
		@$res1 =$this->__userRegisterValidation($post);
		
		if(!@$res1['result'])
		{
			return $res1;
		}
		else
		{
			
			$id=$_GET['ID'];
			if(@$post['meta_description']==''&&@$post['meta_tag']==''&&@$post['title_tag']=='')
			{
				$sql=array('page_title'=>$post['page-title'],
				'page_content'=>$post['pagecontent'],
				'peramlink'=>$post['peramlink']
				);

			}
			if(@$post['meta_description']==''&&@$post['meta_tag']!=''&&@$post['title_tag']!='')
			{
				$sql=array('meta_tag'=>$post['metatag'],
				'title_tag'=>$post['title-tag'],
				'page_title'=>$post['page-title'],
				'page_content'=>$post['pagecontent'],
				'peramlink'=>$post['peramlink']
				);

			}
			if(@$post['meta_description']!=''&&@$post['meta_tag']==''&&@$post['title_tag']!='')
			{
				$sql=array('meta_description'=>$post['metadescription'],
				'title_tag'=>$post['title-tag'],
				'page_title'=>$post['page-title'],
				'page_content'=>$post['pagecontent'],
				'peramlink'=>$post['peramlink']
				);
			}
			if(@$post['meta_description']!=''&&@$post['meta_tag']!=''&&@$post['title_tag']=='')
			{
				$sql=array('meta_description'=>$post['metadescription'],
				'meta_tag'=>$post['metatag'],
				'title_tag'=>$post['title-tag'],
				'page_content'=>$post['pagecontent'],
				'peramlink'=>$post['peramlink']
				);
			}
			else
			{
				$sql=array('meta_description'=>$post['metadescription'],
				'meta_tag'=>$post['metatag'],
				'title_tag'=>$post['title-tag'],
				'page_title'=>$post['page-title'],
				'page_content'=>$post['pagecontent'],
				'peramlink'=>$post['peramlink']
				);

				$this->MyDB->setWhere("id=$id"); //prexit($sql);
				$this->MyDB->update($sql);
				$Array = array("result"=>true, "message"=>'Updated Successfully');
			}		return $Array;
		}
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
		$id=50;
		$SQL="SELECT * FROM cms where id=$id";//prexit($SQL);
		$result=$this->MyDB->query($SQL);//prexit($result);
		return  $result;
	}



}
?>