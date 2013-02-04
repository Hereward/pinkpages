<!--Body Start-->
<div class="middle-content">
	<div class="searchbox-index">
    <div class="searchbox-front-left">
    </div>
    <div class="searchbox-front-middle">
    <br />
       <P> </P>
		<div class="searchbox-index-left-bus">
     {* return checkBusiness(); *}
				<form id="test" action="main.php" method="get" onsubmit="">
		<input type="hidden" id="testid" value="" disabled="disabled" />

		<input type="hidden" id="do" name="do" value="Listing" />
		<input type="hidden" id="action" name="action" value="search" />
			
			 <table class="searchbox-index-left" >
           <tr>
           
           <td width="420px" class="title">	<input type="hidden" name="SearchOption" id="SearchOption" checked="checked" type="radio" value="1" onchange="classChange(this.value);" />
           Business Name Search
           </td>
     
 			 <td class="title">&nbsp;
           </td>
           </tr>
           
           <tr>
              <td colspan="2">&nbsp;
              </td>
           </tr>
           
           
             <tr>
           <td >
           <p class="inputbox-b">
           <input type="text" name="Search1" id="Search1" value="" />
           <label for="Search1" generated="true" class="error" style="background-color:#E9138F; font-weight:bold; color:black; padding:3px; border:1px solid #E9138F; top:-70px; position:relative; display: none;"></label>
           </p>
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



{literal}
<script type="text/javascript">
// hello
$(function () {
		$("#Search1").watermark("Enter business name");
		$("#Search1Focus").click(
			function () {
				$("#Search1")[0].focus();
			}
		);
});


$().ready(function() {
   // $('#test').validate( {invalidHandler: $.watermark.showAll} );


    $("#test").validate({
		rules: {
    	    Search1: "required"
		},
		messages: {
			Search1: "Please enter a business name"
		},
		invalidHandler: $.watermark.showAll
	});
});

</script>
{/literal}