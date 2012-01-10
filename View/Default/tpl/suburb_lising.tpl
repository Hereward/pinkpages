<div class="content">
	<h2 class="black">List of Suburbs for "{$Region}"</h2>

	<table class="datatable">
	<td class="h4reversed"><strong>Suburb<strong></td>
	<td  class="h4reversed"><strong>Post Code<strong></td>			  
	{assign var="j" value=0}
	{section name=i loop=$suburbResult}
	
	<tr class="{if $j % 2==0}{else}odd{/if}">
	
	<td>{$suburbResult[i].shiretown_townname}</td><td>{$suburbResult[i].shiretown_postcode}</td>
	</tr>
	{assign var="j" value=$j+1}
	{/section}
	</table>
</div>