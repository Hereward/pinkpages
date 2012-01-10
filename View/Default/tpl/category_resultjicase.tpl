
{include file="left_form.tpl"}
<div class="content">  
 

  <table class="topnotice" width="90%" align="center"><tr><td>
  	<b>{if $CountResult eq ''}{$normalcount}{else}{$CountResult}{/if} {if $normalcount eq '1'}result {else}results{/if} under the Classification '<span><strong>{$category|stripslashes}</strong></span>'</b>
  	</tr></td></table>

		{section name=i loop=$values} 
		{if $values[i].rank neq '999999'}
		{capture name=google assign=add}
		Google
		{/capture}
		{/if}
		{/section}
		 	
		<center>
		<table cellpadding="6">
		<tr><td>
		{if $smarty.capture.google eq ''}
		{literal}
		<script type="text/javascript"><!--
		google_ad_client = "pub-3947502494298555";
		/* 468x60, created 3/17/09 */
		google_ad_slot = "5386581257";
		google_ad_width = 468;
		google_ad_height = 60;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		{/literal}
		{/if}
		</td></tr>
		</table>
		</center>

  	  

      <table class="datatable">
                  
              {section name=i loop=$values}    
                  <tbody>

				   {if $values[i].rank eq '999999'}
		
				    <tr colspan="3">
				    
                      <td  valign="top"  >
                          <table width="100%" border="0" class="linebotom2"  cellpadding="0" cellspacing="0">
                          
                          <tr>
                          <td width="8px"></td>
                          <td>
                          <table>
                          <tr>
                          <td class="task" width="98%" colspan="3">
                                  <tr>
                                  <td class="smallrextlowtitle">
        								<b>{$values[i].business_name|upper}</b>
        						</td>
                                  </tr>
                                  <tr>
                                  		<td class="smallrextlow">{strip}
        									{if $values[i].street1_status eq '0' && $values[i].business_street1 neq ''}{$values[i].business_street1}{/if}
        									{if $values[i].street2_status eq '0' && $values[i].business_street2 neq ''} {$values[i].business_street2}{/if}
        									{if $values[i].business_suburb neq ''} {$values[i].business_suburb}{/if}
        									{if $values[i].business_state neq ''} {$values[i].business_state}{/if}
        									{if $values[i].business_postcode neq ''} {$values[i].business_postcode}{/if}{/strip} 
        
                                   
                                    {if  ($values[i].business_phone != '') && ($values[i].business_phone|SUBSTR:0:2 neq '04' && $values[i].business_phone|SUBSTR:0:2 neq '13' && $values[i].business_phone|SUBSTR:0:2 neq '18') && ($values[i].business_state eq 'NSW')}   | PH: (02)&nbsp;{/if} {$values[i].business_phone} </a> </td>
                                      {if $values[i].map_status eq '0'}
                                   
                                       <td class="smallrextlowMap"> <a  href="{$values[i].url}" >Map</a>
                                    
                                    </td>
                                    {/if}
                                  </tr>
             </table>
             </td></tr>
                      </table></td>
                    </tr>
                    {elseif $values[i].rank neq '999999'}
					
                      	   

					 <tr>
					 <td colspan="3">
					 
					 
              <table width="100%" class="linebotom" >
                    <tr valign="top"><td class="task" width="98%" colspan="3" valign="top"> 
                      <table class="mainheadingbg" width="100%">
                        <tr valign="top">
                          <td  class="mainheading"><a href="javascript:poptastic('{$values[i].link}');" >{$values[i].business_name}</a> 
                          
                          {if $values[i].rank neq '9999' } 
        						 <span style="color:#CDB79E;">[{$values[i].rank}]</span>
                        
                                    {/if}
                           
                                     {if $values[i].rank eq '9999' } 
						         <span style="color:#CDB79E;">11+</span>
                         
                                    {/if}
                                    
                                    
                                    </td> 
                                    {if $values[i].map_status eq '0'}
                          <td class="mainheadingmap" align="right"><a href="javascript:poptastic('{$values[i].link}');" >Profile</a> 
						  {if $values[i].business_email neq ''}						  
						| <a href="{$contactUs}={$values[i].business_id}&search={$smarty.get.search}&category={$smarty.get.category}&Suburb={$smarty.get.Suburb}&fr={$smarty.get.fr}">Email</a>
						  {/if}		
						  
								 {if $values[i].business_url neq ''}
						| <a href="{$values[i].business_url}" target="new">Website</a>
						  {/if}	
						   </td>
						  {else}
						   <td class="mainheadingmap" align="right">
						    {if $values[i].business_email neq ''}						  
						| <a href="{$contactUs}={$values[i].business_id}&search={$smarty.get.search}&category={$smarty.get.category}&Suburb={$smarty.get.Suburb}&fr={$smarty.get.fr}">Email</a>
						  {/if}		
								 {if $values[i].business_url neq ''}	
						| <a href="{$values[i].business_url}" target="new">Website</a>
						  {/if}	
						   </td> 
						 {/if} 
                                    
                                    
                                    </td>
                        </tr>
                        </table>
                        </td>
                    </tr>
          			<tr>
          			 
                      <td width="600px" class="task" >
                  
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
						  <!--{if $values[i].business_phonestd eq ''} {else}<b>Ph:</b> ({$values[i].business_phonestd}) {/if} --><b>Ph:</b>
						  {if  ($values[i].business_phone != '') && ($values[i].business_phone|SUBSTR:0:2 neq '04' && $values[i].business_phone|SUBSTR:0:2 neq '13' && $values[i].business_phone|SUBSTR:0:2 neq '18') && ($values[i].business_state eq 'NSW')} (02)&nbsp;{/if}
						  {if $values[i].business_phone eq ''}{else}{$values[i].business_phone}&nbsp;{/if}
						  {if $values[i].business_mobile eq ''}{else} <b>Mob:</b>{$values[i].business_mobile} {/if}</td>
                        </tr>
                      
                         {if ($values[i].add_word1 eq '') && ($values[i].add_word2 eq '')} 
                
                  
                    <tr valign="top">
						  <td height="35px">
                          </td>
                      </tr>
                     {/if}
 
                        
                      </table></td>
					 
                      <td width="120px" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>{if $values[i].business_logo neq ''}<img src="{$CLIENT_IMAGES_PATH}{$values[i].business_logo}" alt="business logo image" width="90px" height="60px" />{/if}</td>
                        </tr>
                        
                      </table></td>
					  
                    </tr>
              </table>
              
              </td></tr>
              
             
              
            
			  {/if}					
				   
				   
                    
                  </tbody>
				  {/section}
                </table>
     
                
  <div align="center">{include file="pagination.tpl"}</div>
		


{include file="keyword_search_form.tpl"}
</div>