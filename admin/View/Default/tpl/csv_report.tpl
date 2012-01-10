<div class="content">
<h3 align="left">Free Listing Upload Report</h3>
<form name="list" action="{$action}" method="post">
<table class="datatable" width="50%" border="0" cellpadding="0" cellspacing="0" align="center" >
   <tr>
      <!--<td class="h4reversed" colspan="">Select Business</td> -->
      <td class="h4reversed" colspan="">Business ID</td>
	  <td class="h4reversed" colspan="">Business Name</td>
	  <td class="h4reversed" colspan="">Business Street1</td>
	  <td class="h4reversed" colspan="">Business Street2</td>
	  <td class="h4reversed" colspan="">Business Suburb</td>
	  <td class="h4reversed" colspan="">Business Postcode</td>
	  <td class="h4reversed" colspan="">Business State</td>
   </tr>
   {assign var="j" value=1}
 {section name=listing loop=$values start=1 step=1}
 <input type="hidden" name="total" value="{$j}" />
 <!-- <tr><td colspan=""><input type="checkbox" name="insert_{$j}" id="insert" value="1" />
		  
  </td> -->
    <td colspan="">{$values[listing].0}<input type="hidden" name="BisinessInitial{$j}" value="{$values[listing].0}" /></td>
	<td colspan="">{$values[listing].1}<input type="hidden" name="BisinessName{$j}" value="{$values[listing].1}" /></td>
	<td colspan="">{$values[listing].2}<input type="hidden" name="BisinessStreet1{$j}" value="{$values[listing].2}" /></td>
	<td colspan="">{$values[listing].3}<input type="hidden" name="BisinessStreet2{$j}" value="{$values[listing].3}" /></td>
	<td colspan="">{$values[listing].4}<input type="hidden" name="BisinessSuburb{$j}" value="{$values[listing].4}" /></td>
	<td colspan="">{$values[listing].5}<input type="hidden" name="BisinessPostcode{$j}" value="{$values[listing].5}" /></td>
	<td colspan="">{$values[listing].6}<input type="hidden" name="BisinessState{$j}" value="NSW" /></td>
	
	<input type="hidden" name="Bisinessphonestd{$j}" value="{$values[listing].6}"/>	
	<input type="hidden" name="Bisinessphone{$j}" value="{$values[listing].7}" />
	<input type="hidden" name="BisinessClass1{$j}" value="{$values[listing].8}" />
	<input type="hidden" name="BisinessClass2{$j}" value="{$values[listing].9}" />
	<input type="hidden" name="BisinessClass3{$j}" value="{$values[listing].10}" />
	<input type="hidden" name="BisinessClass4{$j}" value="{$values[listing].11}" />
	<input type="hidden" name="BisinessClass5{$j}" value="{$values[listing].12}" />
	<input type="hidden" name="Bisinessorigin{$j}" value="{$values[listing].13}" />
	<input type="hidden" name="shiretown_id{$j}" value="{$values[listing].14}" />
	<input type="hidden" name="shire_name{$j}" value="{$values[listing].15}" />
	<input type="hidden" name="shire_town{$j}" value="{$values[listing].16}" />
	<input type="hidden" name="Bisinessmobile{$j}" value="{$values[listing].17}" />
	<input type="hidden" name="Bisinesscontact{$j}" value="{$values[listing].18}" />
	<input type="hidden" name="bold_listing{$j}" value="{$values[listing].19}" />
	<input type="hidden" name="archived{$j}" value="{$values[listing].20}" />
	<input type="hidden" name="account_id{$j}" value="{$values[listing].21}" />
	<input type="hidden" name="client_id{$j}" value="{$values[listing].22}" />
	<input type="hidden" name="Bisinesslogo{$j}" value="{$values[listing].23}" />
	<input type="hidden" name="business_description{$j}" value="{$values[listing].24}" />
	<input type="hidden" name="classification{$j}" value="{$values[listing].25}" />
	<input type="hidden" name="Rank{$j}" value="{$values[listing].26}" />
	
	
</tr>
   {assign var="j" value=$j+1}
  {/section}
</table>
<ul class="controlbar">
<div align="center">
<input type="submit" name="submit" value="Import" class="controlgrey" />
</div>
</ul>
</div>




















