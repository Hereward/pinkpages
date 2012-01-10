	<div class="content0left">
	<div class="content">
	<h4 class="h4reversed" align="left"><b>Search Classification Banner</b></h4>
	
	<ul class="textfieldlist" >
	<form name="searchclassification" action="{$action}" method="get" onsubmit="return validate();">
	<input type="hidden" name="do" value="BannerManager" />
	<input type="hidden" name="action" value="searchClassificationBannerDetail" /> 
	
	        

			<li>
				<label>Classification Name:</label>
				<select name="classification" id="classification">
					<option value="0">--Select One--</option>
					{foreach from=$result item=key}
					<option value="{$key.localclassification_id}">{$key.localclassification_name}</option>
					{/foreach}					
				</select>
			</li>
			<li>
				<label>Business Name:</label>
				<input type="text" name="title" id="title" value="" class="textfieldshort"/>
			</li>			
			<br />
			<ul class="">
			<div align="center"><input type="submit" name="submit" value="Search" class="controlgrey" /></div>
	</ul>
	</form>
	</ul>
	</div>
	</div>
{literal}
<script language="javascript">
function validate()
{

	if(document.searchclassification.classification.value == "0" && document.searchclassification.title.value == "")
	{
	alert('Select any Classification or enter Title for search');
	document.searchclassification.title.focus();
	return false;
	}
	return true;
}  
</script>
{/literal}