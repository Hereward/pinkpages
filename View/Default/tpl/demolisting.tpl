<!--Search box starts-->
{include file="search_form.tpl"}
<!--Search box ends-->


<div class="content">
  <h4 class="search-subhead"></h4>
<table class="datatable">
                  
                  <tfoot class="quotetfoot">
                      <tr>
                          <td colspan="3" class="shadowrule"></td>
                      </tr>
                  </tfoot>
				 
                  <tbody>
                  <tr>
				   <td colspan="3">
				   <table width="100%" class="linebotom" >
              
                    <tr >
                      <td width="50%" class="task" ><table width="95%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td class="mainheading">
						  			{if $values[0].bold_listing eq 1}
										<a href="{$values[0].link}" target="_new">{$values[0].business_name}</a>		
										{else}{$values[0].business_name}
									{/if}		
						  </td>
                        </tr>
                        <tr>
                          
						  <td class="darkgrey">
						  		{if $values[0].business_address neq '0'}{$values[0].business_address}{/if}
								<!--{if $values[i].street2_status eq '0'}{$values[i].business_street2}{/if} -->						  </td>
                        </tr>
                        <tr>
                          <td class="darkgrey"> {if $values[0].business_suburb neq ''}{$values[0].business_suburb},{else} {/if}
								{if $values[0].business_state neq ''}{$values[0].business_state},{else} {/if}
						  {if $values[0].business_postcode neq '0'}{$values[0].business_postcode}{else}{/if}</td>
                        </tr>
                        <tr>
						
                          <td class="number-phone-td">
						  Ph: {if $values[0].business_phonestd eq ''} {else} ({$values[0].business_phonestd}) {/if} 
						  {if $values[0].business_phone eq ''}{else}{$values[0].business_phone}{/if}
						  </td>
                        </tr>
                        <tr>
						
                          <td class="viewmap-blue"><a href="#" target="_new">View Map</a> | 
						  
								<a href="#">Email</a>
								
						   </td>
						 
						   <td>
						     {if $values[0].business_email neq ''}	
								<a href="{$contactUs}={$values[0].business_email}&search={$smarty.get.search}&category={$smarty.get.category}&Suburb={$smarty.get.Suburb}&fr={$smarty.get.fr}">Email</a>
								{/if}
						   </td>
						 
                        </tr>
                        
                      </table></td>
					  <td width="20%" valign="middle">
					     <table width="90%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><img src="{$IMAGES_PATH}DemoListing/{$values[0].business_logo}" alt="" width="110" height="84" />
						    </td>
                          </tr>
                        </table>
					  </td>
					  <td width="30%">
					   <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td class="mainheading-blue">{$values[0].business_description|truncate:120:"...":true}</td>
                        </tr>
                        
                       </table>
					  </td>
                    </tr>

                   </table>
				  </td>
				 </tr>
				 </tbody>
</table>				   
			  <div align="center">{include file="pagination.tpl"}</div>
			   		 
              
              
</div>













<!--****************************************************************************************************************** -->
 <!-- <div class="content">
  
              
  <h4 class="search-subhead">
  
  </h4>
        	
                
                <table class="datatable-classnew">
                  
                  <tfoot class="quotetfoot">
                      <tr>
                          <td colspan="3" class="shadowrule"></td>
                      </tr>
                  </tfoot>
                  
                  <tbody>
	  	
        {section name=i loop=$values}
			{if $values[i].rank neq 0 &&  $values[i].rank lte $DEFAULT_RANK_LIMIT}
                    <tr>
                      <td class="paid-task">
					  	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                    			<td>
									{if $values[i].bold_listing eq 1}
										<a href="{$values[i].link}" target="_new">{$values[i].business_name}</a>		
										{else}{$values[i].business_name}
									{/if}
								</td>
                        	</tr>
                        <tr>
							<td>
							<span>  
							        {if $values[i].business_address neq ''}{$values[i].business_address}, {/if} 
									{if $values[i].business_suburb neq ''}{$values[i].business_suburb}, {/if}
									{if $values[i].business_state neq ''}{$values[i].business_state}, {/if}
									{if $values[i].business_postcode neq ''}{$values[i].business_postcode}{/if}
							</span>
							</td>
						</tr>
                        	<tr>
								  <td>{if $values[i].business_phonestd eq ''} {else} ({$values[i].business_phonestd}) {/if} {if $values[i].business_phone eq ''}{else}{$values[i].business_phone},{/if}
								  {if $values[i].business_url eq '' OR $values[i].business_url eq 'http://'}{else}<a href="http://{$values[i].business_url}"> {$values[i].business_url}</a>{/if}
								  <br /> 
								   {if $values[i].business_email neq ''}	
								   <!--<a href="{$values[i].contactUs}">contact us</a>-->
								   
								<!--   {/if}
								  </td>
	                        </tr>
	                      </table>
						 </td>
					  
                      	 <td class="paid-task">
						
						</td>
					  </tr>
		{else}
		<tr class="odd">
                      <td width="55%" valign="top" class="task" ><table width="90%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
								{if $values[i].bold_listing eq 1}
								<a href="{$values[i].link}" target="_new">
								<strong>{$values[i].business_name}</strong>
								</a>
								{else}
								<strong>{$values[i].business_name}</strong>
								{/if}
                          </tr>
                          
                      </table></td>
                      <td width="45%" colspan="2" valign="middle"><table width="90%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td class="number-phone">{$values[i].business_phone}</td>
                        </tr>
                        <tr>
							<td class="smallrextlow">
									{if $values[i].business_address neq ''}{$values[i].business_address}{/if} 
									{if $values[i].business_suburb neq ''},{$values[i].business_suburb}{/if}
									{if $values[i].business_state neq ''},{$values[i].business_state}{/if}
									{if $values[i].business_postcode neq ''},{$values[i].business_postcode}{/if}
							</td>
                        </tr>
                        <tr>
                          <td class="smallrext">&nbsp;</td>
                        </tr>
                      </table></td>
                       </tr>	 -->		  
					   
<!--					   
*************************************************************************************************************		 -->			   
					   
			<!--<tr>
				<td class="task" >
					<table width="90%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                    		<td>{if $values[i].bold_listing eq 1}<a href="{$values[i].link}" class="pink" target="_new"><strong>{$values[i].business_name}</strong></a>{else}<strong>{$values[i].business_name}</strong>{/if}</td>
                        </tr>
                        <tr>
							<td>
							{if $values[i].street1_status eq '1'}{$values[i].business_street1}, {/if}
							{if $values[i].street2_status eq '1'}{$values[i].business_street2}, {/if}
							<span>
									{if $values[i].business_suburb neq ''}{$values[i].business_suburb}, {/if}
									{if $values[i].business_state neq ''}{$values[i].business_state}, {/if}
									{if $values[i].business_postcode neq ''}{$values[i].business_postcode}{/if}
							</span>
							</td>
						</tr>
                        <tr>
                          <td>{if $values[i].business_phonestd eq ''}{else}({$values[i].business_phonestd}){/if} {$values[i].business_phone} 
						  {if $values[i].business_url eq '' OR $values[i].business_url eq 'http://'}{else},<a href="http://{$values[i].business_url}"> {$values[i].business_url}
						  </a>				
						  {/if}
						  <br />
						  {if $values[i].business_email neq ''}						  
						  <a href="{$values[i].contactUs}">contact us</a>
						  {/if}
						  </td>
						  
                        </tr>
                      </table></td> <td><!--<table width="90%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center"><img src="{$IMAGES_PATH}map.gif" alt="" width="42" height="32" /></td>
                        </tr>
                        <tr>
                          <td align="center"><a href="{$values[i].url}" target="_new">Map Sydney Results</a></td>
                        </tr>
                        
                      </table></td>	   </tr>
		{/if}			  
	
         {/section}
				</tbody>
                </table>
        <div align="center">{include file="pagination.tpl"}</div>
		 <div class="sitebanner"><a href="http://{$bannerArray1[0].banner_link}"><img border="0" src="{$BANNER_PATH}{$bannerArray1[0].banner_name}" alt="{$bannerArray1[0].alt_text}" width="{$bannerArray1[0].banner_width}" /></a> </div>       
</div>-->

