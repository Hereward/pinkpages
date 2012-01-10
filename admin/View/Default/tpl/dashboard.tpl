<div class="content">
<h1 title="Admin Dashboard"><span><img src="{$IMAGES_PATH}arrow1.gif" alt="" />Admin Dashboard</span></h1>
 <div class="items" >

 {foreach from=$user_permission item=key}
 {if $key.1 eq '1'}
    <a href="{$search}">
      <p>
		<img src="{$IMAGES_PATH}ad1.gif" />
		<span>Business Manager</span>
	  </p>
	</a>
	{/if}
	
	{if $key.1 eq '2'}
	<a href="{$clientManager}">
	  <p>
		<img src="{$IMAGES_PATH}ad2.gif" />
		<span>Client Manager</span>
	  </p>
	</a>
	{/if}
	{if $key.1 eq '3'}
	<a href="{$TeamManager_url}">
	  <p>
		<img src="{$IMAGES_PATH}ad3.gif" />
		<span>Team Manager</span>
	  </p>
 	</a>
	{/if}
	
	
	<!--<a href="{$viewlisting}">
      <p>
		<img src="{$IMAGES_PATH}ad4.gif" />
		<span>Multiple Listing Manager</span>
	  </p>
	</a> -->
	{if $key.1 eq '4'}
	<a href="{$csvfile}">
	  <p>
		<img src="{$IMAGES_PATH}ad5.gif" />
		<span>Listing Manager</span>
	  </p>
	</a>
	{/if}
	
	{if $key.1 eq '5'}
	<a href="{$searchClassification}">
	  <p>
		<img src="{$IMAGES_PATH}ad6.gif" />
		<span>Classification Manager</span>
	  </p>
 	</a>
	{/if}
	{if $key.1 eq '6'}
	<!--<a href="{$viewVertical}">-->
	<a href="{$viewGroup}">
	  <p>
		<img src="{$IMAGES_PATH}ad7.gif" />
		<span>Vertical Manager</span>
	  </p>
	</a>
	{/if}
	{if $key.1 eq '7'}
	<a href="{$view}">
	  <p>
		<img src="{$IMAGES_PATH}ad8.gif" />
		<span>Synonyms Manager</span>
      </p>
 	</a>
	{/if}
	{if $key.1 eq '8'}
	<a href="{$viewLocation}">
     <p>
	    <img src="{$IMAGES_PATH}ad9.gif" />
		<span>Location Manager</span>
	 </p>
	</a>
		{/if}
		{if $key.1 eq '9'}
	<a href="{$bannerManager}">
	 <p>
		<img src="{$IMAGES_PATH}ad10.gif" />
		<span>Banner Manager</span>
	 </p>
	</a>
	{/if}
	{if $key.1 eq '10'}
	<a href="{$viewPage}">
	 <p>
	    <img src="{$IMAGES_PATH}ad11.gif" />
		<span>Content Manager</span>
	 </p>
	</a>
	{/if}
	{if $key.1 eq '11'}
	<a href="{$sitePerformanceReport}">
	 <p>
	    <img src="{$IMAGES_PATH}ad12.gif" />
		<span>Site Statistics</span>
     </p>
	</a>
	{/if}
		{if $key.1 eq '12'}
	<a href="{$rankReport}">
	 <p>
		<img src="{$IMAGES_PATH}ad13.gif" />
		<span>Rank Manager</span>
	 </p>
	</a>
	{/if}
	{/foreach}
	</div>
</div>

