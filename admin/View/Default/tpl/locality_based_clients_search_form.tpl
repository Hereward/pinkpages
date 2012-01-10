<div class="content0left">
<div class="content" align="center">
<h4 class="h4reversed" align="center"><b>Search clients based on locality</b></h4>
<form id="test" action="{$action}"  name="loginForm" method="get"  >
<br />
<ul class="textfieldlist" >
<input type="hidden" name="do" value="Admin" />
<input type="hidden" name="action" value="search_locality_based_clients" /> 
<li><label>Please select the suburb to display clients</label></li>
<li >
<select name="suburb" id="type1" >
	               <option selected="selected" ><h4>--Select One--</h4></option>
					{foreach from=$values item=key}			
			              <option  value="{$key.shiretown_townname}">                                                     {$key.shiretown_townname}
						  </option>
					  {/foreach}
					</select>
</li>					
</ul>
<ul class="">
		<div style="margin-right:25px;">
		<input type="submit" name="submit" value="Search" class="controlgrey" />
		<!--<a href="{$cancel}"><input type="submit" name="submit" value="Cancel" class="controlgrey" /></a> -->
		</div>
</ul>
</form>
</div>
</div>
					