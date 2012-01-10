<div class="white"><div class="map-sperater">
</div>
  	
					<ul class="map-detail-left">
					<li>
			<h1>{$business_details.business_name}</h1><br /><br /><br /><br />
</li>
                  					
						
						 <li>	
                            
                                <p>[{$smarty.get.classification|stripslashes}]</p>
                                
                              
							</li>
							
							
							
							<li>

									
																
							{if $business_details.street1_status eq '0'}
							{$business_details.business_street1}
							{/if}
							{if $business_details.street2_status eq '0'}
							{$business_details.business_street2}
							{/if}</li>
                            <li>
{$business_details.business_suburb}</li>
<li> {$business_details.business_state}, {$business_details.business_postcode}
								
							</li>
                            <li>{assign var=ph value=$business_details.business_phone|SUBSTR:0:2}
							Ph:{if ($ph == 13 OR $ph == 18 OR $ph == 04) AND $business_details.business_state eq 'NSW' }&nbsp;{else} (02)&nbsp;{/if}
							 {$business_details.business_phone}
							</li>
                            		
						
					</ul>
					<ul class="map-detail-right">
						

							<li style="border:solid; border-color:#103c91;">
							{$map_header_js}
							{$map_js}
							{$map_view_js}
							{$onload_js}
						    </li>
							
					
                        
					</ul>
  
  
  <div class="mapbottom">
   <table align="center" width="95%">
   <tr><td height="6px" colspan="2"></td></tr>
        <tr>
            <td class="googlemapword" width="50%" align="left">
                <b> <a href="javascript: history.back()">Back to Search</a></b>
					</td>
					 <td class="googlemapword" width="50%" align="right">
					 <b> <a href="javascript:window.print()">Print this page</a></b>
					</td>
					 </tr>
					 </table>
</div>
  
  </div>
		    
			
		