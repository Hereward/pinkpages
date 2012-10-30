<?php
class ContentFacade extends MainFacade {

	public function __construct(MyDB $MyDB){           //Start of The __contructor.purpose is to assign database parmeters to                                                           //a variable acting as an object and using that object to declare
		$this->MyDB = $MyDB;                             //the table name,sequence name and primary column.
		$this->MyDB->table="cms";
		$this->MyDB->sequenceName="cms";
		$this->MyDB->primaryCol="id";
	}
	public function viewPage($paramlink){
		$SQL="SELECT * FROM `cms` WHERE `peramlink`='$paramlink'";//prexit($SQL);
		$result=$this->MyDB->query($SQL);//prexit($result);
		$result[0]['page_content'] = stripslashes($result[0]['page_content']);
		return  $result;

	}
	public function pageAdd($post)
	{

		$SQL="INSERT INTO `cms` (

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
		$result[0]['page_content'] = stripslashes($result[0]['page_content']);
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
		$result[0]['page_content'] = stripslashes($result[0]['page_content']);
		return  $result;
	}

	public function contactUs()
	{
		$id					= 50;
		$SQL				= "SELECT * FROM cms where id=$id";
		$result				= $this->MyDB->query($SQL);
		if(count($result) > 0)
		{
		$result[0]['page_content'] = stripslashes($result[0]['page_content']);
		}
		return  $result;
	}

	public function aboutUs()
	{
		$id=60;
		$SQL="SELECT * FROM cms where id=$id";
		$result=$this->MyDB->query($SQL);
		$result[0]['page_content'] = stripslashes($result[0]['page_content']);
		return  $result;
	}

	public function getRegion()
	{
		$SQL="SELECT * FROM shire_names";
		$result=$this->MyDB->query($SQL);
		return  $result;
	}

	public function fetchSuburb($get)
	{

		$RegionID		=$get['Code'];
		$SQL="SELECT * FROM shire_towns WHERE shirename_id='{$RegionID}'";
		$result=$this->MyDB->query($SQL);
		return  $result;
	}

	public function careers()
	{
		$id=61;
		$SQL="SELECT * FROM cms where id=$id";//prexit($SQL);
		$result=$this->MyDB->query($SQL);//prexit($result);
		return  $result;
	}

	public function popularPageCount($page_id)
	{
		return ''; // Hereward 20121030 - remove redundant code
		$PAGE_DETAIL_QUERY	="SELECT * FROM page_details WHERE page_id='$page_id'";
		$PAGE_DETAIL_RESULT	=$this->MyDB->query($PAGE_DETAIL_QUERY);

		$homePageCount		=$PAGE_DETAIL_RESULT['0']['count']+1;

		$update_query	="UPDATE page_details SET `count` = '$homePageCount' WHERE page_id='$page_id'";
		$this->MyDB->query($update_query);
		
		$date=date('Y-m-d');
		$select_page_stats="SELECT page_id,views FROM page_stats WHERE page_id='$page_id'";
		$views=$this->MyDB->query($select_page_stats);
		if(count($views)==0)
		{
		 $page_views=@$views[0]['views']+1;
		 $insert_page_stats= "INSERT
							  INTO `page_stats` (`id`,`page_id`,`datereport`,`views`)
							  VALUES (NULL,'{$page_id}','{$date}','{$page_views}')"; 
		// prexit($insert_page_stats);					  
		 $this->MyDB->query($insert_page_stats);
		}
		else
		{
		$page_views=$views[0]['views']+1;
		$update_page_stats= "UPDATE page_stats SET views ='$page_views' WHERE page_id='$page_id' AND datereport ='$date'";
		//prexit($update_page_stats);
		$this->MyDB->query($update_page_stats);
		}
	}

	public function sendMail($post)
	{
		$Name			= $post['name'];
		$CompanyName	= $post['companyname'];
		$Email			= $post['email'];
		$Phone			= $post['phone'];
		$Comment		= $post['comment'];
		$MessageHTML = '';
		
/*		$retArray = array("result"=>false, "message"=>'');
		$res1 =$this->__contactUsValidation($post);
		if(!$res1['result'])
		{
		return $res1;
		}*/
		
		$fetch_admin_email		= "SELECT `localuser_email` FROM `local_user`  WHERE `localuser_username`='admin'";
		$admin_email_value		= $this->MyDB->query($fetch_admin_email);
		$admin_email_id	       = $admin_email_value['0']['localuser_email'];
 
		        	
 if($Email != '')
		{
		$MessageHTML .=     "<table width='800' border='0' cellpadding='0' cellspacing='0' style='font:normal 13px/16px Verdana, Arial, Helvetica, sans-serif;
color:#5F5E5E;font-size:13px;height:20px;'>
  <tr>
    <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
      <tr>
        <td style='border-bottom-width: 4px;	border-bottom-style: solid;	border-bottom-color: #333333;	height:30px;	font:normal 20px Verdana, Arial, Helvetica, sans-serif;	'>Pink Pages Website Email Contact Information</td>
      </tr>
      <tr>
      </tr>
     
      <tr>
        <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td width='17%' valign='top'>&nbsp;</td>
            <td width='83%'>&nbsp;</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Name:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$Name</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Company Name:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$CompanyName</td>
          </tr>
	
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Email:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$Email</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Phone:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$Phone</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Comment:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$Comment</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
";
		}else{
		$MessageHTML .=     "<table width='800' border='0' cellpadding='0' cellspacing='0' style='font:normal 13px/16px Verdana, Arial, Helvetica, sans-serif;
color:#5F5E5E;font-size:13px;height:20px;'>
  <tr>
    <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
      <tr>
        <td style='border-bottom-width: 4px;	border-bottom-style: solid;	border-bottom-color: #333333;	height:30px;	font:normal 20px Verdana, Arial, Helvetica, sans-serif;	'>Pink Pages Website Email Contact Information</td>
      </tr>
	   <tr>
        <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>The client has not supplied an email address, please do not reply to this email address.</td>
      </tr>
      <tr>
      </tr>
     
      <tr>
        <td><table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td width='17%' valign='top'>&nbsp;</td>
            <td width='83%'>&nbsp;</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Name:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$Name</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Company Name:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$CompanyName</td>
          </tr>
	
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Email:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$Email</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Phone:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$Phone</td>
          </tr>
          <tr>
            <td valign='top' style='font-size:13px;font-weight:bold;color:#000;'>Comment:</td>
            <td style='color:#5F5E5E;font-size:13px;height:20px;'>$Comment</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
";
		}
 		$mailer = new Mailer();
		if ($admin_email_id != '') 
		{
			$mailer->AddAddress($admin_email_id);
		} else {
			$mailer->AddAddress("gtcattley@gmail.com");
		}
		$mailer->Subject 	= "Client Contact Details";
		//$mailer->From=$Email;
		if($Name != '')
		{
		$mailer->FromName=$Name;
		}else{
		$mailer->FromName="Pink Pages";
		}
		if($Email != '')
		{
		$mailer->AddReplyTo($Email);
		}else{
		$mailer->AddReplyTo('info@sydneypinkpages.com.au');
		}
		
		$mailer->Body 		= $MessageHTML;
		$mailer->IsHTML(true);
		if(!$mailer->Send())
		{
			echo $mailer->ErrorInfo;
		}
		$mailer->ClearAddresses();
		$retArray = array("result"=>true, "message"=>'Thank You
Your comments or suggestion have been passed onto the appropriate department.');
		return $retArray;
	}
	
	private function __contactUsValidation(&$data)
	{
		$retArray = array("result"=>false, "message"=>'');
		$errors = array();

		if(empty($data['phone'])) {
			$errors[] = "Phone Number is blank!!";
		}

		if(count($errors) == 0) {
			$retArray['result'] = true;
		}
		$retArray['message'] = $errors;
		return $retArray;
	}	



}
?>