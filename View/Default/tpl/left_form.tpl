  <div class="leftsidebar">
    <div class="banners">				 
			{if $bannerArrayA[0].banner_name neq '' && $bannerArrayA[0].banner_type eq '1'}	
			<div class="sitebanner"><center>
				<a id="{$bannerArrayA[0].banner_id}" href="{$bannerArrayA[0].banner_link}">
				<img src="{$BANNER_PATH}{$bannerArrayA[0].banner_name}" alt="{$bannerArrayA[0].alt_text}" width="{$bannerArrayA[0].banner_width}" />
				</a>
				</center>
			</div>
			
			{elseif $bannerArrayA[0].html_code neq ''}
			{$bannerArrayA[0].html_code}
			{/if}				 		  		  
		  
			{if $bannerArrayB[0].banner_name neq '' && $bannerArrayB[0].banner_type eq '1'}	
			<div class="sitebanner"><center>
				<a id="{$bannerArrayB[0].banner_id}" href="{$bannerArrayB[0].banner_link}">
				<img src="{$BANNER_PATH}{$bannerArrayB[0].banner_name}" alt="{$bannerArrayB[0].alt_text}" width="{$bannerArrayB[0].banner_width}" />
				</a>
				</center>
			</div>
			
			{elseif $bannerArrayB[0].html_code neq ''}
			{$bannerArrayB[0].html_code}
			{/if}				 		  
			
			{if $bannerArrayC[0].banner_name neq '' && $bannerArrayC[0].banner_type eq '1'}	
			<div class="sitebanner"><center>
				<a id="{$bannerArrayC[0].banner_id}" href="{$bannerArrayC[0].banner_link}">
				<img src="{$BANNER_PATH}{$bannerArrayC[0].banner_name}" alt="{$bannerArrayC[0].alt_text}" width="{$bannerArrayC[0].banner_width}" />
				</a>
				</center>
			</div>
			
			{elseif $bannerArrayC[0].html_code neq ''}
			{$bannerArrayC[0].html_code}
			{/if}				 		  			
  </div>  
</div>  
{literal}
   <script type="text/javascript" language="javascript">
     $('div.sitebanner a').click(function(e){
	   e.preventDefault();
	   var id = $(this).attr('id');
       window.location.href = "/click_thru.php?id="+id;  
	 });
   </script>
{/literal}   
