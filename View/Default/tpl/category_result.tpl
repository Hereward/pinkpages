
 <div class="bbbg"><div class="white-sperater">
</div>
{include file="left_form.tpl"}

<div class="content">  
 

  <table class="topnotice" width="99%" align="center">
    <tr>
	  <td>
      <center>
        <h1>{if $CountResult eq ''}<span>{$normalcount}</span>{else}<span>{$CountResult}</span>{/if} {if $normalcount eq '1'}Result {else}Results{/if} found in <span>'{$category|stripslashes}'</span> in <span>'{$location|stripslashes}'</span></h1>
      </center>
      </td>
	</tr>
  </table>

		{section name=i loop=$values} 
		{if $values[i].rank neq '999999'}
		{capture name=google assign=add}
		Google
		{/capture}
		{/if}
		{/section}
		 	
		{*
		{if $smarty.capture.google eq ''}
	
		<table align="center"  width="590px" class="googleadds" >
		<tr><td align="center">
		
		{literal}
		<script type="text/javascript"><!--
		google_ad_client = "pub-3947502494298555";
		/* 468x60, created 3/17/09 */
		google_ad_slot = "5386581257";
		google_ad_width = 468;
		google_ad_height = 70;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		{/literal}
		
		</td></tr>
		</table>
		
		
		
		{/if}
  	    *}

      <table class="datatable">
                  
              {section name=i loop=$values}    
                  <tbody>
                  
				   {if $values[i].rank eq '999999'}
		
				    <tr colspan="3">
				    
                      <td  valign="top"  >
                          <table border="0" class="linebotom2"  cellpadding="0" cellspacing="0">
                          
                          	<tr>
                          		<td width="8px"></td>
                          		<td>
								     {if !$row}
								      {include ad_container_id="adcontainer1" gab=1 file="google_ad.tpl"}
								      
                                       <hr />
									   {assign var="row" value="1"}
									 {/if}
                         			 <table>
                          				<tr>
                          					<td class="task" width="100%" colspan="2">
                                 		 <tr>
                                 			 <td class="smallrextlowtitle" colspan="2">
        								<b><a class="smallrextlowtitle" href="{$values[i].url}" >{$values[i].business_name|upper}<span class="grey"> - {$category|stripslashes}</span></a></b>{$values[i].archived}
        									</td>
                                 		 </tr>
                                 		 <tr>
                                  			<td class="smallrextlow" width="554px" >{strip}
        									{if $values[i].street1_status eq '0' && $values[i].business_street1 neq ''}{$values[i].business_street1}{/if}
        									{if $values[i].street2_status eq '0' && $values[i].business_street2 neq ''} {$values[i].business_street2}{/if}
        									{if $values[i].business_suburb neq ''} {$values[i].business_suburb}{/if}
        									{if $values[i].business_state neq ''} {$values[i].business_state}{/if}
        									{if $values[i].business_postcode neq ''} {$values[i].business_postcode}{/if}{/strip} 
        
                                   
                                     | PH: {if  ($values[i].business_phone != '') && ($values[i].business_phone|SUBSTR:0:2 neq '14' && $values[i].business_phone|SUBSTR:0:2 neq '13' && $values[i].business_phone|SUBSTR:0:2 neq '18') && ($values[i].business_state eq 'NSW')} (02)&nbsp;{/if}
						  {if $values[i].business_phone eq ''}{else}{$values[i].business_phone}&nbsp;{/if}
						  {if $values[i].business_mobile eq ''}{else} <b>Mob:</b>&nbsp;{$values[i].business_mobile} {/if}</a> </td>
                                      {if $values[i].map_status eq '0'}
                                   
                                      	 <td class="smallrextlowMap" align="right" > <a  href="{$values[i].url}" >Map</a>
                                    
                                   		 </td>
                                    {/if}
                                 	 </tr>
             					</table>
             			</td>
                        </tr>
                      </table>
                      </td>
                    </tr>
                    
                    
                   {elseif $values[i].rank neq '999999'}
					
					 <tr>
					 <td colspan="3" class="category-result" style="cursor: pointer;" onmouseover="this.style.backgroundColor='#f831a6';" onmouseout="this.style.backgroundColor='#ffffff';" onClick="location.href='{$values[i].link}'";>
				       <table class="mainheadingbg" width="100%">
                         <tr>
                           {if ($values[i].rank <= 5)}						 
                             <td  class="mainheadingtop5">
                             <a href="{$values[i].link}" >{$values[i].business_name}</a>
        					 <span style="color:#f831a6;">[{$values[i].rank}]</span>
                           </td>  							 							 
						   {else}
                             <td  class="mainheading">
                             <a href="{$values[i].link}" >{$values[i].business_name}</a>
        					 <span style="color:#ea6ab5;">[{$values[i].rank}]</span>
                           </td>  							 
						   {/if}	 
						   
                           {if $values[i].business_email neq ''}	
						     <td class="mainheadingmap" width="53px"  >
						       <a href="{$values[i].link}" >Email</a></td>
						   {/if}                                                                                  
                                
                           {if $values[i].business_url neq ''}	
						     <td class="mainheadingmap"  width="66px" >
                               <a href="{$values[i].link}" >Website</a></td>
						  {/if}	                                                                                                         
                          {if $values[i].map_status eq '0'}
                            <td class="mainheadingmap" width="38px">
                              <a href="{$values[i].link}" >Map</a> 
                            </td>
                          {/if}                       						 																                                                                                                            
                         </tr>
                       </table>	 
					   
              {if ($values[i].rank <= 5)}
                <table  class="linebottomtop5">
			  {else}
                <table class="linebotom">
          				<tr>
              {/if}						
          			 
                      <td width="100%" class="task" >
                  
                      <table width="95%"  valign="top" border="0" cellpadding="0" cellspacing="0">
                      {if ($values[i].add_word1 eq '') && ($values[i].add_word2 eq '')} 
                      {else}
                  
                    <tr valign="top">
						  <td height="35px" valign="top" class="darkgrey">
                          <b>{$values[i].add_word1} {$values[i].add_word2}</b>
                          </td>
                      </tr>
                     {/if}
                      
                        <tr valign="top">
                          
						  <td  class="number-phone-td">
						  		{if $values[i].street1_status eq '0'}{$values[i].business_street1} {/if}
								{if $values[i].street2_status eq '0'}{$values[i].business_street2}{/if}						  </td>
                        </tr>
                        <tr valign="top">
                          <td class="number-phone-td"> {if $values[i].business_suburb neq ''}{$values[i].business_suburb}, {/if}
								{if $values[i].business_state neq ''}{$values[i].business_state}{/if}
						  {if $values[i].business_postcode neq ''}{$values[i].business_postcode}{/if}</td>
                        </tr>
                        <tr valign="top">
						
                          <td class="number-phone-td">
						    <!--{if $values[i].business_phonestd eq ''} {else}<b>Ph:</b> ({$values[i].business_phonestd}) {/if} -->{if $values[i].business_phone ne ''}<b>Ph:</b>{/if}
						    {if  ($values[i].business_phone != '') && ($values[i].business_phone|SUBSTR:0:2 neq '04' && $values[i].business_phone|SUBSTR:0:2 neq '13' && $values[i].business_phone|SUBSTR:0:2 neq '18') && ($values[i].business_state eq 'NSW')} (02)&nbsp;{/if}
						    {if $values[i].business_phone eq ''}{else}{$values[i].business_phone}{/if}
						    {if $values[i].business_mobile eq ''}{else}<b>Mob:</b>&nbsp;{$values[i].business_mobile} {/if}
						  </td>
                        </tr>
						<tr>
						  <td class="classification-listing">							
    						<span class="classification-listing">{$category|stripslashes} in {$location|stripslashes}</span>
						  </td>
                        </tr>
                      
                         {if ($values[i].add_word1 eq '') && ($values[i].add_word2 eq '')} 
                
                  
                    <tr valign="top">
						  <td height="35px">
                          </td>
                      </tr>
                     {/if}
 
                        
                      </table></td>
					
                      <td width="100px" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td> {if $values[i].business_logo neq ''}<img src="{$CLIENT_IMAGES_PATH}{$values[i].business_logo}" alt="business logo image" width="90px" height="60px" />{/if}</td>
                        </tr>
                        
                      </table></td>
					  
                    </tr>
              </table>
              
              </td></tr>
              
             
              
            
			  {/if}					
				   
		
                    
                  </tbody>
				  {/section}
                </table>
                <br/>
              {include ad_container_id="adcontainer2" gab=2 file="google_ad.tpl"}
				
            <div align="center">{include file="pagination.tpl"}</div>
          
             {if ($related_class_count > 0)}
             <h2 style="font-size:14px; font-weight:bold; padding:0; color:black; margin: 10px 0 0 25px;">Related Classifications</h2>
             <div style="margin:10px 0px 5px 25px; font-size:11px;">
               {section name=i loop=$relatedClassLinks}
			      <a href="{$relatedClassLinks[i].link}{if $smarty.get.Suburb}&Suburb={$smarty.get.Suburb}{/if}"> {$relatedClassLinks[i].localclassification_name|lower|capitalize}</a>{if !$smarty.section.i.last} &nbsp;|&nbsp; {/if}
		       {/section}
		       {* <span> {$relatedClassLinks[i].cnt} business results </span> *}
             </div>
            {/if}
            
            


			<P>&nbsp;</P>	
{*
            <div class="banners">				 
			{if $bannerArrayA[0].banner_name neq '' && $bannerArrayA[0].banner_type eq '1'}	
			<div class="sitebanner"><center>
				<a id="banner-{$bannerArrayA[0].banner_id}" href="{$bannerArrayA[0].banner_link}">
				<img src="{$BANNER_PATH}{$bannerArrayA[0].banner_name}" alt="{$bannerArrayA[0].alt_text}" width="{$bannerArrayA[0].banner_width}" />
				</a>
				</center>
			</div>
			
			{elseif $bannerArrayA[0].html_code neq ''}
			{$bannerArrayA[0].html_code}
			{/if}				 		  		  
		  
			{if $bannerArrayB[0].banner_name neq '' && $bannerArrayB[0].banner_type eq '1'}	
			<div class="sitebanner"><center>
				<a id="banner-{$bannerArrayB[0].banner_id}" href="{$bannerArrayB[0].banner_link}">
				<img src="{$BANNER_PATH}{$bannerArrayB[0].banner_name}" alt="{$bannerArrayB[0].alt_text}" width="{$bannerArrayB[0].banner_width}" />
				</a>
				</center>
			</div>
			
			{elseif $bannerArrayB[0].html_code neq ''}
			{$bannerArrayB[0].html_code}
			{/if}				 		  
			
			{if $bannerArrayC[0].banner_name neq '' && $bannerArrayC[0].banner_type eq '1'}	
			<div class="sitebanner"><center>
				<a id="banner-{$bannerArrayC[0].banner_id}" href="{$bannerArrayC[0].banner_link}">
				<img src="{$BANNER_PATH}{$bannerArrayC[0].banner_name}" alt="{$bannerArrayC[0].alt_text}" width="{$bannerArrayC[0].banner_width}" />
				</a>
				</center>
			</div>
			
			{elseif $bannerArrayC[0].html_code neq ''}
			{$bannerArrayC[0].html_code}
			{/if}				 		  			
			</div>
	
*}
<div class="sitebanner" align="center" width="468" height="60">
{literal}
    <script type="text/javascript"><!--
google_ad_client = "pub-3947502494298555";
/* 468x60, created 3/30/09 */
google_ad_slot = "7650630311";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
{/literal}
</div>

{if $description}
<div class="description">
  <p>{$description}</p>
</div>
{/if}	

            
</div>
 

<!--Search box starts-->
{include file="keyword_search_form.tpl"}
<!--Search box ends-->
<div class="bottomseperator">
</div>
</div>

 {include file="google_custom_search.tpl"}
