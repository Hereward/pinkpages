<div class="bbbg"><div class="white-sperater">
</div>

{include file="left_form.tpl"}
<!--New Code Starts here-->
<div class="content">
<table class="topnotice" width="99%"> {if $normalcount neq '0'}<tr><td>
  <center>
      <h1>{if $CountResult eq ''} {$normalcount}{else}{$CountResult}{/if} Results found for <span>'{$searchValue1|stripslashes}'</span></h1></center></td></tr>
 {else}<tr><td>
  <center>
      <h1>No results found</h1></center></td></tr><tr><td>
<b>Sorry, your search for <span><strong>'{$smarty.get.Search1}'</strong></span> returned no results<br />Please try again using a different Business Name, you can also <br /> try searching for <a href="{$business_name_search}http://www.sydneypinkpagesonline.com.au/main.php?do=Listing&action=searchKeyword&Search1={$smarty.get.Search1}"><span><strong>'{$smarty.get.Search1}'</strong></span></a> in a Keyword Search.</b>
    </td></tr>
{/if}


  	</table>
  	<br />
  	

  		

<table class="datatable">
                  
                  <tfoot class="quotetfoot">
                      <tr>
                          <td colspan="3" class="shadowrule"></td>
                      </tr>
                  </tfoot>
              {section name=i loop=$values}    
                  <tbody>
                  
                   <tr colspan="3">
				    
                      <td  valign="top"  >
                          <table  border="0" class="linebotom2"  cellpadding="0" cellspacing="0">
                          
                          <tr>
                          <td width="8px"></td>
                          <td>
                          <table width="595px">
                          <tr>
                          <td class="task" width="98%" colspan="2">
                                  <tr>
                                  <td class="smallrextlowtitle" colspan="2">
                                  {if $values[i].is_ranked eq 0}
        								<b><a href="{$values[i].link}" >{$values[i].business_name}</a>{* {$values[i].business_name|upper} *}</b>
        								{else}
        								
        								<b><a href="{$values[i].link}" >{$values[i].business_name}</a> </b> 
        								{/if}
        							    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        					{if $values[i].classification_name neq ''}		   

  	<span style="color:dimgray;">[{$values[i].classification_name}]</span>
 
        					{/if}		    
		        							  

												

        						</td>
                                  </tr>
                                  <tr>
                                   		{if $values[i].is_ranked > 0}
                                  		<td class="smallrextlow" width="450px">
                                  		{else}
                                        
                                  		<td class="smallrextlow" width="548px">
                                      
                                  		{/if}
                                  		
                                  		{strip}
        									{if $values[i].street1_status eq '0' && $values[i].business_street1 neq ''}{$values[i].business_street1}{/if}
        									{if $values[i].street2_status eq '0' && $values[i].business_street2 neq ''} {$values[i].business_street2}{/if}
        									{if $values[i].business_suburb neq ''} {$values[i].business_suburb}{/if}
        									{if $values[i].business_state neq ''} {$values[i].business_state}{/if}
        									{if $values[i].business_postcode neq ''} {$values[i].business_postcode}{/if}{/strip} 
        
                                   
        									
        									
                                    {if  ($values[i].business_phone != '') && ($values[i].business_phone|SUBSTR:0:2 neq '04' && $values[i].business_phone|SUBSTR:0:2 neq '13' && $values[i].business_phone|SUBSTR:0:2 neq '18') && ($values[i].business_state eq 'NSW')}   | PH: (02)&nbsp;{/if} {$values[i].business_phone} </a> </td>
                                    
                                   
                                       <td align="right" class="smallrextlowMap"> 
                                        {if $values[i].business_email neq ''}						  
						 <a href="{$values[i].link}" >Email</a>
						  {/if}		
                          {if ($values[i].business_email neq '') && ($values[i].business_url neq '')}
                          
                          |
                          {/if}
                          
								 {if $values[i].business_url neq ''}	
								 {if $values[i].business_url neq 'http://'}
						<a href="{$values[i].link}" >Website</a>
						  {/if}	
						  {/if}	
                                       
                                       {if $values[i].is_ranked > 0}
                                       {if ($values[i].business_url neq '') && ($values[i].business_url neq 'http://')}	
						 |
						  {/if}	

<a href="{$values[i].link}" >Map</a> 
                                       {else}
                                       
                                       <a  href="{$values[i].url}" >Map</a>
						
						  
						   
                                       
                                    
                                    
                                    {/if}
                                    </td>
                                  </tr>
             </table>
             </td></tr>
                      </table></td>
                    </tr>
                    
                  
                  </tbody>
				  {/section}
                </table><br /><br /><br />
				<div align="center">{include file="pagination.tpl"}</div>
			{if $bannerArray3[0].banner_name neq ''}
			<div class="sitebanner">
			<a href="http://{$bannerArray3[0].banner_link}"><img border="0" src="{$BANNER_PATH}{$bannerArray3[0].banner_name}" alt="{$bannerArray3[0].alt_text}" width="{$bannerArray3[0].banner_width}" />
			</a>
			</div>
			{elseif $bannerArray3[0].html_code neq ''}
			<div class="sitebanner">{$bannerArray[0].html_code}</div> 
			
			{/if}
</div>

<!--Search box starts-->
{include file="business_side_search_form.tpl"}
<!--Search box ends-->

<div class="bottomseperator">
</div>
</div>