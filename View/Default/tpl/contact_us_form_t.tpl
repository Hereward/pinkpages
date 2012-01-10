<!--Body Start-->
<div class="middle-content">
	<div class="searchbox-index"> 
    <div class="searchbox-front-left" width="15px">
    </div>
    <div class="searchbox-front-middle"> 
    <br />

		<div class="searchbox-index-left-con"> 
        
            <P >If you wish to enquire about advertising in the Sydney Pink Pages <br />Please contact a Sales Consultant on:(02) 9635 1400 during office hours<br />
			Our simply complete our contact form

			 </P>
             <img src="{$IMAGES_PATH}local.gif" align="right" vspace="30" alt="sydney pink pages local man image" />
				<form name="contactUs" action="{$action}={$smarty.get.ID}" method="post" onsubmit="return check_req_val();">
		
		<table>
  
                <tr><td>
					<label class="contact-title-label">Name</label></td><td>
				<p class="smallinputbox">	<input type="text" name="name" size="30" value="{$name}" /></p></td></tr>
                    <tr><td>
					<label class="contact-title-label">Email Address</label></td><td>
					<p class="smallinputbox"><input type="text" name="email" id="email" size="30" /></p></td></tr>
				<tr><td>
					<label class="contact-title-label">Phone Number</label></td><td>
					<p class="smallinputbox"><input type="text" name="phone" id="phone" size="30" value="{$phone}"/></p></td></tr>
				<tr><td>
					<label class="contact-title-label">Comments</label></td><td>
					<p class="context"><textarea name="comment" rows="2" cols="30">{$comment}</textarea>
				</td></tr>
				<tr><td></td><td align="right">
					<input  src="{$IMAGES_PATH}contact-sub.gif" type="image" name="contactus"  value="Submit" />
				</td></tr>
			</table>
		
	
		</form>
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