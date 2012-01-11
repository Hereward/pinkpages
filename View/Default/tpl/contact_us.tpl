<!--Body Start-->
<div class="middle-content">
	<div class="searchbox-index"> 
    <div class="searchbox-front-left" width="15px">
    </div>
    <div class="searchbox-front-middle"> 
    <br />

		<div class="searchbox-index-left-con"> 
        
            If you wish to enquire about advertising in Pink Pages Online or update your listing,<br />contact us on: (02) 8898 1900 during office hours,
			or simply complete our contact form<br /><br /><br />

				<form name="contactUs" action="{$action}" method="post" onsubmit="return check_req_val();">
		
		<table width="460px" align="left">
  
                <tr><td >
					<label class="contact-title-label">Your Name</label></td><td>
				<p class="smallinputbox">	<input type="text" name="name" size="55" /></p></td><td ></td></tr>
                    <tr><td >
					<label class="contact-title-label">Company Name</label></td><td>
				<p class="smallinputbox">	<input type="text" name="companyname" size="55"  /></p>
			 </td><td ></td></tr>
                    <tr><td >
					<label class="contact-title-label">Email Address</label> </td><td>
					<p class="smallinputbox"><input type="text" name="email" id="email" size="55"/></p></td><td ><font color="#ffffff"><b>or</b></font></td></tr>
					
				<tr><td>
					<label class="contact-title-label">Contact Number</label></td><td>
					<p class="smallinputbox"><input type="text" name="phone" id="phone" size="55"  /></p></td><td ></td></tr>
				<tr><td  valign="top">
					<label class="contact-title-label">Message</label></td><td >
					<p class="context"><textarea name="comment" rows="3" size="55" ></textarea>
				</td><td ></td></tr>
				<tr><td ></td><td align="right">
					<input  src="{$IMAGES_PATH}contact-sub.gif" hspace="4px" type="image" name="contactus" value="Submit" />
				</td><td ></td></tr>
			</table>
		
	
		</form>
		
		<div class="contact_address">
		<table class="contact_page_details">
		<tr><td>Dawson Media Pty Ltd Est 1968</td></tr>
		<tr><td>Level 5<br>
106 Church St<br>
Parramatta 2150<br>
NSW Australia<br>
<br>
PO Box 199<br>
Parramatta 2124<br>
<br>
Ph: 02 9635 1400<br>
Fax: 02 9761 0462 </td></tr></table>

		
		</div>
		
	</div>
  
   </div>
      <div class="searchbox-front-right" width="15px">
      </div>
          

	
  </div>

</div>
<!--Body End--><!-- {include file="news.tpl"}  -->

<!--<div class="alpha_links" align="center">

	Business Types:	&nbsp;
	{foreach from=$alpha_links item=alpha key=key}
		{if $searchLetter eq $alpha.text}
			<span>{$alpha.text}</span>
		{else}
			<a href="{$alpha.link}">{$alpha.text}</a>
		{/if}
		{if $key < 25} |{/if} 
	{/foreach}
    </div>
    -->	
	
	
	
<!--{if $bannerArray[0].banner_name neq ''}	
	<div class="sitebanner"><a href="http://{$bannerArray[0].banner_link}"><img src="{$BANNER_PATH}{$bannerArray[0].banner_name}" alt="{$bannerArray[0].alt_text}" width="{$bannerArray[0].banner_width}" /></a> </div>
	{elseif $bannerArray[0].html_code neq ''}
	<div class="sitebanner">{$bannerArray[0].html_code}</div>

	{/if}-->
	


<script language="javascript1.5" src="{$JS_PATH}contact_validation.js" type="text/javascript" >
</script>