<!--Body Start-->
<div class="middle-content">
	<div class="searchbox-index"> 
    <div class="searchbox-front-left" width="15px">
    </div>
    <div class="searchbox-front-middle"> 
    <br />

		<div class="searchbox-index-left-con"> 
        Business Listing Contact Page <br /><br />
            If you wish to enquire about our products or services, please complete the contact form.<br />
			To enable us to reply please include your email address or contact number.  
<br /><br />

			<form name="contactUs" action="{$action}" method="post" onsubmit="return check_req_val();">
		
		<table width="460px" align="left">
  
                <tr><td>
					<label class="contact-title-label">Your Name</label></td><td>
				<p class="smallinputbox">	<input type="text" name="name" size="30" value="{$name}" /></p></td><td ></td></tr>
                    <tr><td>
					<label class="contact-title-label">Email Address</label></td><td>
					<p class="smallinputbox"><input type="text" name="email" id="email" size="30" /></p></td><td ><font color="#ffffff"><b>or</b></font></td></tr>
				
				<tr><td>
					<label class="contact-title-label">Contact Number</label></td><td>
					<p class="smallinputbox"><input type="text" name="phone" id="phone" size="30" value="{$phone}"/></p> </td><td ></td></tr>
				<tr><td  valign="top">
					<label class="contact-title-label">Message</label></td><td>
					<p class="context"><textarea name="comment" rows="2" cols="30">{$comment}</textarea>
				 </td><td ></td></tr>
				<tr><td ></td><td align="right">
					<input  src="{$IMAGES_PATH}contact-sub.gif" hspace="4px" type="image" name="contactus" value="Submit" />
				</td><td ></td></tr>
			</table>
		
	
		</form>
	</div>
  
   </div>
      <div class="searchbox-front-right" width="15px">
      </div>
          

	
  </div>

</div>

	
	

	

<script language="javascript1.5" src="{$JS_PATH}contact_validation.js" type="text/javascript" >
</script>