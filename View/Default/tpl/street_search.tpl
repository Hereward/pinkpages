<div class="bbbg"><div class="white-sperater">
</div>
{include file="left_form.tpl"}

<!--New Code Starts here-->
<!--New Code-->

<div class="content">      
 {if $countlow eq '0'}
  
  <table class="topnotice" width="99%"><tr><td>
  <center>
      <h1>No results found</h1></center></td></tr><tr><td>
  	<b>Sorry, your search on <span>'{$smarty.get.Search1}'</span> in <span>'{$smarty.get.Search2}'</span> returned no results<br />
		You could try searching in another street or suburb</b>
  	</tr></td></table>
		<br />
	{else}
	  
  <table class="topnotice" width="99%"><tr><td>
  <center>
      <h1>{if $count eq ''}{$countlow}{else}{$count}{/if} Results found for <span>'{$smarty.get.Search1}'</span> in <span>'{$smarty.get.Search2}'</span></h1></center></td></tr></table>
  	<br />

	{/if}

      <table class="datatable">
                  
                  <tfoot class="quotetfoot">
                      <tr>
                          <td colspan="3" class="shadowrule"></td>
                      </tr>
                  </tfoot>
              {section name=i loop=$businessArray}    
                  <tbody>
				
				  <tr colspan="3">
				    
                      <td  valign="top"  ><a href="{$businessArray[i].link}">
                          <table  border="0" class="linebotom2"  cellpadding="0" cellspacing="0">
                          
                          <tr>
                          <td width="8px"></td>
                          <td>
                          <table width="595px">
                          <tr>
                          <td class="task" width="98%" colspan="3">
                                  <tr>
                                  <td class="smallrextlowtitle">
                                  {if $businessArray[i].rank eq '999999'}
        								<b>{$businessArray[i].business_name|lower|capitalize}</b>
        								{else}
        								
        								<b><a href="{$businessArray[i].link}" >{$businessArray[i].business_name|lower|capitalize}</a> </b>
        								{/if}
                                        {if $businessArray[i].classification_name neq ''}
                                          &nbsp;
                                        	<span style="color:gray;">[{$businessArray[i].classification_name|lower|capitalize}]</span>
                                            {/if}	
        						</td>
                                  </tr>
                                  <tr>
                                  		  {if $businessArray[i].rank neq '999999'}
                                  		<td class="smallrextlow" width="450px">
                                  		{else}
                                  		<td class="smallrextlow" width="548px">
                                  		{/if}{strip}
        									{if $businessArray[i].street1_status eq '0' && $businessArray[i].business_street1 neq ''}{$businessArray[i].business_street1|lower|capitalize}{/if}
        									{if $businessArray[i].street2_status eq '0' && $businessArray[i].business_street2 neq ''} {$businessArray[i].business_street2|lower|capitalize}{/if}
        									{if $businessArray[i].business_suburb neq ''} {$businessArray[i].business_suburb|lower|capitalize}{/if}
        									{if $businessArray[i].business_state neq ''} {$businessArray[i].business_state}{/if}
        									{if $businessArray[i].business_postcode neq ''} {$businessArray[i].business_postcode}{/if}{/strip} 
        
                                   
        									
        									
                                    {if  ($businessArray[i].business_phone != '') && ($businessArray[i].business_phone|SUBSTR:0:2 neq '04' && $businessArray[i].business_phone|SUBSTR:0:2 neq '13' && $businessArray[i].business_phone|SUBSTR:0:2 neq '18') && ($businessArray[i].business_state eq 'NSW')}   | PH: (02)&nbsp;{/if} {$businessArray[i].business_phone} </a> </td>
                                    
                                 {*
                                       <td class="smallrextlowMap" align="right"> 
                                   
						
                                       {if $businessArray[i].business_email neq ''}						  
						  <a href="{$businessArray[i].link}" >Email</a>
						  {/if}		
						  
                           {if ($businessArray[i].business_email neq '') && ($businessArray[i].business_url neq '')}
                          
                          |
                          {/if}
						    
								 {if $businessArray[i].business_url neq ''}	
						 <a href="{$businessArray[i].link}" >Website</a>
						  {/if}	
                                       
                                    
                                        {if $businessArray[i].rank eq '999999'}
                                       <a  href="{$businessArray[i].url}" >Map</a>
                                       
                                       {else}
                                       
                                      | <a href="{$businessArray[i].link}" >Map</a> 
                                       
                                       {/if}
                                    </td>
                                    *}
                                  </tr>
             </table>
             </td></tr>
                      </table></a></td>
                    </tr>
					
	
			  
                  </tbody>
				  {/section}
                </table>
                <br /><br /><br />
				 <div align="center">{include file="pagination.tpl"}</div>
			   		 {if $bannerArray1[0].banner_name neq ''}	
	<div class="sitebanner"><a href="http://{$bannerArray1[0].banner_link}"><img src="{$BANNER_PATH}{$bannerArray1[0].banner_name}" alt="{$bannerArray1[0].alt_text}" width="{$bannerArray1[0].banner_width}" /></a> </div>
	{elseif $bannerArray1[0].html_code neq ''}
	<div class="sitebanner">{$bannerArray1[0].html_code}</div>
	
	{/if}
            
</div>
<!--Search box starts-->
{include file="side_street_search_form.tpl"}
<!--Search box ends-->
<div class="bottomseperator">
</div>

</div>
