<div class="bbbg"><div class="white-sperater">
</div>
{include file="left_form.tpl"}

<div class="content">
  <table class="topnotice" width="99%"><tr><td>

    <center>
      <h1 style="margin:0px; padding:0px; line-height:auto;">Please choose a Region for <span>'{$classi_name|lower|capitalize}'</span> from the list below</h1></center>
      </td></tr>
  	</table>
  	
  	

        	<br />
        <div style="margin:0px 0px 20px 30px;">
        {section name=state_index loop=$states}
            {assign var=state value=$states[state_index]}
            {* <h2 style="margin-top:0px; color:black;">{$state}</h2> *}
            
            <div style="margin:0px 0px 20px 0px;">
            {assign var=region_init value=1}
            
            <h2 style="margin-top:0px; color:black;">{$state}</h2>
            
            {section name=region loop=$shire_names}
                 
                {assign var=myIndex value="r_"|cat:$shire_names[region].shirename_id}
                {assign var=r_count value=$region_count.$myIndex.count}
                {assign var=unit_state value=$region_count.$myIndex.state}
                
                {* <div>[{$myIndex}] [{$state}] [{$unit_state}] [{$r_count}]</div> *}
              
                {if $r_count && $unit_state == $state}
                     
              
                      <div style="margin:0px 0px 0px 0px;">
                      <a class="region_filter"  
			          href="{$SITE_PATH}main.php?do=Listing&action=categorySearch&search={$classi}&category={$classi_enc}&state={$state}&shire_name={$region_count.$myIndex.alias}"> 
                      {$classi_name|lower|capitalize} In {$shire_names[region].shirename_shirename|lower|capitalize}&nbsp; <span style="color:gray; font-weight: bold;">
			          ({$region_count.$myIndex.count})</span></a>
                     </div>
                {/if}
               
               
            {/section}
            {assign var=region_init value=1}
            </div>
            
            
            {*
            {assign var=myIndex value="r_"|cat:$shire_names[i].shirename_id}
			{assign var=r_count value=$region_count.$myIndex.count}
			{if $r_count}
			<tr>

			<td onmouseover="this.style.backgroundColor='#FCEDF6';" onmouseout="this.style.backgroundColor='#FFFFFF';" style="background-color:#FFFFFF; border-bottom:1px solid gray;"> &nbsp;&nbsp;&nbsp;&nbsp;  
			
			<a style="font-size: 16px; font-weight: normal" 
			href="{$SITE_PATH}main.php?do=Listing&action=categorySearch&search={$classi}&category={$classi_enc}&state={$region_count.$myIndex.state}&shire_name={$region_count.$myIndex.alias}"> 
			
			{$shire_names[i].shirename_shirename|lower|capitalize}&nbsp; <span style="color:gray; font-weight: bold;">
			 ({$region_count.$myIndex.count})</span>
			<span style="float:right;">View Listings</span></a>
			
	
			</td>
			</tr>
            {/if}
            *}
		{/section}
        </div>
        	
        
        
        {*	
	<table style="margin-top:0px; padding-top:0px; border-top:2px solid gray;" class="datatable-classnew" >
		{section name=i loop=$shire_names}
            {assign var=myIndex value="r_"|cat:$shire_names[i].shirename_id}
			{assign var=r_count value=$region_count.$myIndex.count}
			{if $r_count}
			<tr>

			<td onmouseover="this.style.backgroundColor='#FCEDF6';" onmouseout="this.style.backgroundColor='#FFFFFF';" style="background-color:#FFFFFF; border-bottom:1px solid gray;"> &nbsp;&nbsp;&nbsp;&nbsp;  
			
			<a style="font-size: 16px; font-weight: normal" 
			href="{$SITE_PATH}main.php?do=Listing&action=categorySearch&search={$classi}&category={$classi_enc}&state={$region_count.$myIndex.state}&shire_name={$region_count.$myIndex.alias}"> 
			
			{$shire_names[i].shirename_shirename|lower|capitalize}&nbsp; <span style="color:gray; font-weight: bold;">
			 ({$region_count.$myIndex.count})</span>
			<span style="float:right;">View Listings</span></a>
			
			</td>
			</tr>
            {/if}
		{/section}
	</table>
			*}
			
			
			</br></br>

	
				 
		{if $bannerArray[0].banner_name neq ''}
		<div class="sitebanner"><a href="http://{$bannerArray[0].banner_link}"><img border="0" src="{$BANNER_PATH}{$bannerArray[0].banner_name}" alt="{$bannerArray[0].alt_text}" width="{$bannerArray[0].banner_width}" /></a> </div>
		
		{elseif $bannerArray[0].html_code neq ''}
		<div class="sitebanner">{$bannerArray[0].html_code}</div>


	    {/if}
	
	
      
</div>


<!--Search box starts-->
{include file="keyword_search_form.tpl"}
<!--Search box ends-->
<div class="bottomseperator">
</div></div>

<script language="javascript1.5" src="{$JS_PATH}search.js" type="text/javascript" >
</script>
