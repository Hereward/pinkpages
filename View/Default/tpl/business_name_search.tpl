<!--Body Start-->
<div class="middle-content">
	<div class="searchbox-index">
    <div class="searchbox-front-left">
    </div>
    <div class="searchbox-front-middle">
    <br />
       <P> </P>
		<div class="searchbox-index-left-bus">
     
				<form id="test" action="main.php" method="get" onsubmit="return checkBusiness();">
		<input type="hidden" id="testid" value="" disabled="disabled" />

		<input type="hidden" id="do" name="do" value="Listing" />
		<input type="hidden" id="action" name="action" value="search" />
			
			 <table class="searchbox-index-left" >
           <tr>
           
           <td width="420px" class="title">	<input type="hidden" name="SearchOption" id="SearchOption" checked="checked" type="radio" value="1" onchange="classChange(this.value);" />Business Name Search
           </td>
     
 			 <td class="title">&nbsp;
           </td>
           </tr>
           
             <tr>
           <td >
           <p class="inputbox-b"><input type="text" name="Search1" id="Search1" value="Enter business name" /></p>
           </td>
        
           <td align="left"><input src="{$IMAGES_PATH}btn-search.gif" type="image" name="Submit" id="Submit" value="Search" />
           </td>
         
        
           </tr>
         
           
           </table>
			
		 <!--  <table class="searchbox-index-left" >
           
		   <tr>
           <td colspan="3" class="title">
           </td></tr>
           
             <tr>
           	<td width="320px" ><p class="inputbox-b">
             <input type="text" name="Search1" id="Search1" value="" />
           	</p>
           	</td>
           	
           <td width="20px"></td>
         
           <td>
           <input class="btn" src="{$IMAGES_PATH}btn-search.gif" type="image" name="Submit" id="Submit" value="Search" />
           </td>
           </tr>
       
           
           </table> -->
           </form>
		
	  </div>
     <span><a href="/main.php?do=Content&action=contactUs">Advertise with us</a></span>

   </div>
      <div class="searchbox-front-right">
      </div>
          

	
  </div>

</div>
{include file="news.tpl"}

<script language="javascript" src="{$JS_PATH}search.js"></script>

<script>
window.onload = setOption("b");
</script>

<script src="http://192.168.60.107:8080/View/Default/Js/default_values.js" type="text/javascript" language="javascript"></script>