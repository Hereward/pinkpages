<div class="content0left">
<div class="content">
<h4 class="h4reversed" align="center"><b>Add Business Listing</b></h4>
<form id="test" action="{$action}"  name="loginForm" method="POST" enctype="multipart/form-data" >
<br />
<ul class="textfieldlist">

<li>

   <label>OlistID</label>    
   <input  id="field1" type="text" name="OlistID" value="{$OlistID}"  class="textfieldshort" />

</li>

<li>

   <label>Account Number</label>    
   <input  id="field1" type="text" name="AccNo" value="{$AccNo}"  class="textfieldshort" />

</li>

<li>
   <label>Business Initials  <font color="#FF0000">*</font></label>
    
   	 <input  id="field1" type="text" name="initials" value="{$initials}"  class="textfieldshort" />
	<!-- <textarea id="elm1" name="elm1" rows="15" cols="80" style="width: 80%">dfdsffds</textarea> -->
</li>	

<li>
   <label>Business Name   <font color="#FF0000">*</font></label>
    
   	 <input  id="field2" type="text" name="name" value="{$name}" class="textfieldshort"/>
</li>

<li>
   <label>Business Street1   <font color="#FF0000">*</font></label>
    
   	 <input  id="field3" type="text" name="street1" value="{$street1}" class="textfieldshort"/>
	 <input type="checkbox" name="Add1" value="1" {if $values12.street1_status eq '1'} checked="checked" {/if}  />
		<span><font color="#FF0000" size="-6">(Tick to suppress address 1 on the site)</font></span>
</li>

<li>
   <label>Business Street2  <font color="#FF0000">*</font></label>
    
   	 <input  id="field4" type="text" name="street2" value="{$street2}" class="textfieldshort"/>
	 <input type="checkbox" name="Add2" value="1" {if $values12.street2_status eq '1'} checked="checked" {/if} />
		<span><font color="#FF0000" size="-6">(Tick to suppress address 2 on the site)</font></span>
</li>

<li>
  <label>Business Region  <font color="#FF0000">*</font></label>
    
	 <select name="region" id="type1" onchange=setSuburb(this.value,'{$SITE_PATH}') >
	               <option selected="selected"><h4>--Select One--</h4></option>
					{foreach from=$regionValue item=key}			
			              <option id="region" value="{$key.shirename_id};{$key.shirename_shirename}">                                                     {$key.shirename_shirename}
						  </option>
					  {/foreach}
					</select>
					<div><font color="#FF0000" size="-6">(Please Select your Region to get Suburbs)</font></div>
					</li>
	 					
<li>

<li>
  <label>Business Suburb  <font color="#FF0000">*</font></label>
    <div id="tesJs1"></div>
	 <select name="suburb" id="suburbs" onchange=setPostCode(this.value) ></select>
     <div><font color="#FF0000" size="-6">(Please Select your Suburb to get Postcode)</font></div>
					</li>
	 					
<li>
   <label>Business Postcode  <font color="#FF0000">*</font></label>
    
   	 <input  id="field5" type="text" name="postcode" value="{$postcode}" class="textfieldshort" readonly=""/>
</li>

<li>
   <label>Business State</label>
    {foreach from=$values2 item=key}
	<select name="state">
						  <option value="{$key.localstate_name}" selected="selected">{$key.localstate_name}</option>
	</select>	
   	 
	 {/foreach}
</li>

<li>
   <label>Map</label>
    	<input type="checkbox" name="Add3" value="1" {if $values12.map_status eq '1'} checked="checked" {/if} />
		<span><font color="#FF0000" size="-6">(Tick to supress map)</font></span>
</li>

<li>
   <label>Business Phone STD</label>
    
   	 <input  id="field6" type="text" name="phonestd" value="{$phonestd}" class="textfieldshort"/>
</li>

<li>
   <label>Business Phone</label>
    
   	 <input  id="field7" type="text" name="phone" value="{$phone}" class="textfieldshort"/>
</li>

<li>
   <label>Business Fax STD</label>
    
   	 <input  id="field8" type="text" name="faxstd" value="{$faxstd}" class="textfieldshort"/>
</li>

<li>
   <label>Business Fax</label>
    
   	 <input  id="field9" type="text" name="fax" value="{$fax}" class="textfieldshort"/>
</li>
<li>
   <label>Business Email</label>
    
   	 <input  id="field10" type="text" name="email" value="{$email}" class="textfieldshort"/>
</li>

<li>
   <label>Business URL</label>
    
   	 <input  id="field11" type="text" name="url" value="{$url}" class="textfieldshort"/>
</li>

<!--<li>
   <label>Business Brand</label>
   
    <select name="brand" >
	              
					{foreach from=$brandResult item=key}			
			              <option value="{$key.brand_id}-{$key.brand_name}">{$key.brand_name}</option>
					  {/foreach}
					</select>
					<div><font color="#FF0000" size="-6">(Please Select your Brand)</font></div>
</li>-->

<li>
   <label>Business Description  <font color="#FF0000">*</font></label>
   	<li> <textarea  id="field11" type="text" name="description" value="{$description}" class="textfieldshort" rows="5"/>{$description}</textarea>
	<div><font color="#FF0000" size="-6">(Please Enter a Brief Description for knowhow of your business)</font></div>
	</li>
	
</li> 


<li>
    <label>Business Logo  <font color="#FF0000">*</font></label>
    
   	 <input  id="field12" type="file" name="logo" value="" class="textfieldshort" size='62'  /> 
	 <div><font color="#FF0000" size="-6">(Please Select Logo)</font></div> 
</li>


<li>
   <label>Business Origin</label>
    
   	 <input  id="field12" type="text" name="origin" value="{$origin}" class="textfieldshort"/>
</li>

<li>
   <label>Business Mobile</label>
   
   	 <input  id="field13" type="text" name="mobile" value="{$mobile}" class="textfieldshort"/>
</li>

<!--<li>
   <label>Bold Listing</label>
    <li>
   	 <select name="listing">
						  <option value="1" onclick="openDiv('OpenNew','1');">YES</option>
						  <option value="0" selected="selected" onclick="openDiv('CloseNew','0');">NO</option> 
	</select>					  
	</li>
	 <div><font color="#FF0000" size="-6">(Please Selet 'YES' For paid and 'NO' for free listing)</font></div> -->

<li>
   <label>Live/Archived</label>

   	 <select name="archived">
						  <option value="1" selected="selected">Live</option>
						  <option value="0">Archived</option> 
	</select>					  
</li>
	 
<!--<div id="openNewDiv" style="display:none;">
		<li>
			<label>Please Select Rank:</label>
    	<li>
			<select name="rank" onchange="openPopup('OpenPopup',this.value);">
								<option value="1000">--Select One--</option>
								  <option value="1">1</option>
								  <option value="2">2</option>
								  <option value="3">3</option>
								  <option value="4">4</option>
								  <option value="5">5</option>
								  <option value="6">6</option>
								  <option value="7">7</option>
								  <option value="8">8</option>
								  <option value="9">9</option>
								  <option value="10">10</option>
								  <option value="11">11+</option>
			</select>					  
	</li>
	
	</div>
<div id="openNewPopup" style="display:none;position:fixed; left:50px; top:50px;background-color:#FFCCFF; width:60%;" >
<table class="datatable">

      
		<td class="h4reversed"><b id="value">Rank</b></td>
		<td class="h4reversed"><b>Rate</b></td>
		<td class="h4reversed" width="10"><b onclick="openPopup('ClosePopup',this.value);">X</b></td>
    {assign var="j" value=0}
    {foreach from=$rankList item=key}
    <tr class="{if $j % 2==0}{else}odd{/if}">  
	<td id="td{$j+1}">{$key.rank}</td>
	<td>${$key.rate}</td>
	<td width="10"></td>
    </tr>
	 {assign var="j" value=$j+1}
    {/foreach}
</table>

</div> -->

</ul>


<ul class="controlbar">
		<div align="center">
		<input type="submit" name="submit" value="Save" class="controlgrey" onclick="setName(this.value)" />
		<input type="button" name="submit" value="Cancel" class="controlgrey" onclick="javascript:history.back();" /></a>
		</div>
</ul>

 
</form>
</div>
</div>



 {literal}
<script type="text/javascript">
function setPostCode(val)
{
	temp=val.split(',');
	document.loginForm.postcode.value = S=temp[0];

}

function setSuburb(val,PATH)
{
	temp=val.split(';');
	var url = PATH+'main.php?do=Listing&action=getSuburb&ID='+val;

	var myAjax = new Ajax.Updater(
	{success:'suburbs'},
	url,
	{
		method: 'get',
		parameters: ''
		//      ,onComplete: GetVal(PrimerID)

	});

}
function preview() 
{
document.loginForm.pic.src = document.loginForm.logo.value;
}

function openDiv(Val,ID){

		if(Val=="OpenNew"){
			document.getElementById("openNewDiv").style.display="block";		
		}
		if(Val=="CloseNew"){
			document.getElementById("openNewDiv").style.display="none";
		}
}

function openPopup(Action,Val){

		if(Action=="OpenPopup"){
			document.getElementById("openNewPopup").style.display="block";
			document.getElementById("td"+Val).setAttribute("style","font-weight:bold");		
		}
		if(Action=="ClosePopup"){
			document.getElementById("openNewPopup").style.display="none";
		}
}

</script>
{/literal}



