<div class="content0left">
<div class="content">
<h4 class="h4reversed" align="center"><b>Add Synonyms</b></h4>
<form id="test" action="{$action}"  name="loginForm" method="post" enctype="multipart/form-data" >
<br />
<ul class="textfieldlist">

<li>
   <label>Classification:  <font color="#FF0000">*</font></label>
    
	 <select name="name" id="type1">
	                <option value='0'>--Select One--</option>
					 {foreach from=$values1 item=key}			
			              <option id="postcode1" value="{$key.localclassification_name}" {if $classification eq $key.localclassification_name} selected="selected" {/if}>{$key.localclassification_name}
						  </option>
					  {/foreach} 
					</select>
</li>

<li>
   <label>Synonym:  <font color="#FF0000">*</font></label>
    
   	 <input  id="field1" type="text" name="keyword" value="{$keyword}"  class="textfieldshort" />
</li>	
</ul>

<ul class="controlbar"> 
<div align="center">
<input type="submit" name="submit" value="Save" class="controlgrey" />
<!--<a href="{$cancel}" style="text-decoration:none"><input type="submit" name="submit" value="Cancel" class="controlgrey" /></a> -->
<!--<a href="{$view}" style="text-decoration:none"><font color="#CC3399">View Keywords</font></a> -->
</div>
</ul> 
 
</form>
</div>
</div>
