<div class="content">
<!--<script src="http://localhost/pinkpages.com.au/show_banner.php?affiliate_id=14&banner_id=2"></script> -->
<h3 align="left">Affiliate Banner Listings</h3>
    
<table class="datatable" width="100" border="0" cellpadding="0" cellspacing="0" align="center">

      
        <td class="h4reversed"><b>Title</b></td>
		 <td class="h4reversed"><b>Image</b></td>
        <td class="h4reversed" align="right"><b>Get Code</b></td>
		
      
 
	{assign var="j" value=0}
	{foreach from=$bannerArray item=key}

     <tr class="{if $j % 2==0}{else}odd{/if}">

      
        <td>{$key.banner_title}</td>
		<td><img src="{$BANNER_PATH}{$key.banner_name}" height="20" width="50" /></td>
        <td align="right"><a href="#" onclick="getCode('OpenNew','{$key.banner_id}');"><font color="#CC3399"><b id="jclick">Get Code</b></font></a></td>
		   
    </tr>
	 {assign var="j" value=$j+1}
    {/foreach}

</table>


<div id="getCode" style="display:none; position:absolute; left:40px; top:90px; z-index:2000; background-color:#FFCCFF">
				
				<form name="Upload" action="" method="post" enctype="multipart/form-data">
				<table bgcolor="#FFFFFF" border="1" width="500" height="400">
				<tr><td align="center"><font color="#CC66CC"><strong>Copy and Paste your code of the Image from here.</strong></font></td><td align="center"><a href="#" onclick="getCode('CloseNew', '{$key.banner_id}');">Close</a></td></tr>
				
				<tr>
				<td colspan="2"><textarea rows="20" cols="90" id="test" readonly="readonly"><script src="{$PATH}show_banner.php?affiliate_id={$smarty.session.$USERNAMESPACE.affiliate_id}&banner_id={$key.banner_id}"></script></textarea></td>
				</tr>
				
				</table>	
				</form>
						
</div>


<div align="center">{include file="pagination.tpl"}</div>
</div>
{literal}
<script language="javascript">
// Delete Confirmation
function del(val)
{
	var answer = confirm  ("Are you sure,you want to delete?");
	if (answer)
	 window.location.href=val;
	
	 
	else
		{;}
}

function getCode(Val,ID){

		if(Val=="OpenNew"){
			document.getElementById("getCode").style.display="block";		
//			document.getElementById("test").value =	"\<script\ language='javascript'>sfdjsdlfj\</script\>";
			document.getElementById("test").value =	'\<script\ src="{/literal}{$PATH}{literal}show_banner.php?affiliate_id={/literal}{$smarty.session.$USERNAMESPACE.affiliate_id}{literal}&banner_id='+ID+'"></script\>';
		}
		if(Val=="CloseNew"){
			document.getElementById("getCode").style.display="none";
		}
}
</script>
{/literal}
