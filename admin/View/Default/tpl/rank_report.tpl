<div class="content">
<h3 align="left">Rank Report</h3>
<form id="test" action="{$action}"  name="rankReport" method="post" target="_new" onsubmit="return check_classification();" >
<ul class="textfieldlist">

<li>
   <label> Select Classification: <font color="#FF0000">*</font></label>
    
	 <select name="classification" id="type1">
	                <option value="0">--Select One--</option>
					 {foreach from=$classifications item=key}			
			              <option id="postcode1" value="{$key.localclassification_id}" {if $classification eq $key.localclassification_name} selected="selected" {/if}>{$key.localclassification_name}
						  </option>
					  {/foreach} 
					</select>
</li>
<li>

     <label> Select a State: <font color="#FF0000">*</font></label>

	 <select name="state" id="type2">
					 {foreach from=$states item=key}			
			              <option id="state" value="{$key.localstate_id}" {if $state eq $key.localstate_name} selected="selected" {/if}>{$key.localstate_name}
						  </option>
					  {/foreach} 
					</select>

</li>
</ul>
<br />
<ul class="controlbar">
<div align="center">
<input type="submit" name="submit" value="View Report" class="controlgrey" />
</div>
</ul>
</form>
</div>
<script language="javascript1.5" src="{$SITE_PATH}Js/GeneralFunction.js" type="text/javascript" >
</script>