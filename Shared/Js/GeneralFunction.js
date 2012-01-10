//	Chech and uncheck all checkboxes

function CheckAll(chk)
	{

	for (var i=0;i < document.searchForm.elements.length;i++)
		{
			var e = document.searchForm.elements[i];
			if (e.type == "checkbox")
			{
				e.checked = chk.checked;
			}
		}
	}
//	Choose The Invoice Tamplate Set the color of Selected Tamplate

function countcheckboxes(){
	
	var $c=0;
	for (var i=0;i < document.searchForm.elements.length;i++)
		{			
			var e = document.searchForm.elements[i];
			
			if (e.type == "checkbox")
			{				
				if (e.checked == true)
				{					
					$c=$c+1;
				}
			}
		}
		if($c<=0){
			alert('Please first check the customer you want to send the reminder ');
			return false;
		}else{
			return true;
		}
	}
	
	function valdate(searchForm2)
	{
	//alert('i am here');	
		if(document.getElementById("srchday3").checked==true ){
			if(document.searchForm2.ExpiryDatePhysical1.value=='' || document.searchForm2.ExpiryDatePhysical2.value==''){ 
				alert('Please fill up the date range');
				return false;
			}
		}
		
	}

	function valdateOrderRefill()
	{
	
		if(document.getElementById("srchday3").checked==true){
			
			if(document.getElementById('date1').value=='' || document.getElementById('date2').value==''){ 
				
				alert('Please fill up the date range');
				return false;

			}else{
				return true;
			}
		}
		
	}

function SelectInvoiceTamplate(Id){
	
	var PreviousId	=	document.getElementById("InvoiceTemplateId").value
	document.getElementById("InvoiceTemplateId").value=Id;
	
	document.getElementById("Invoice"+Id).setAttribute("bgcolor", "#CCCCCC");
	if(PreviousId != Id){
		document.getElementById("Invoice"+PreviousId).setAttribute("bgcolor", "#FFFFFF");
	}
	
	
}

function InsertInvoiceTamplateId(Id){	//alert(Id);return false;
	document.getElementById("InvoiceTemplateId").value=Id;
}

//	Change the Shipping Method Page


function RedirectPage(UserId){
	
		var SelectVal	=	document.getElementById("Carrier").value;
	
	if(SelectVal==""){
		window.location.href=""+app_path+"main.php?do=Warehouse&action=AddAirbill&UserId="+UserId;
	}else if(SelectVal=="FDE"){
		window.location.href=""+app_path+"main.php?do=Warehouse&action=AddFedExExpress&UserId="+UserId;
	}else if(SelectVal=="FDG"){
		window.location.href=""+app_path+"main.php?do=Warehouse&action=AddFedExGround&UserId="+UserId;
	}else if(SelectVal=="ARB"){
		window.location.href=""+app_path+"main.php?do=Warehouse&action=AddAireborneDHL&UserId="+UserId;
	}else if(SelectVal=="UPS"){
		window.location.href=""+app_path+"main.php?do=Warehouse&action=AddUPS&UserId="+UserId;
	}else if(SelectVal=="UEX"){
		window.location.href=""+app_path+"main.php?do=Warehouse&action=AddUSPSExpress&UserId="+UserId;
	}else if(SelectVal=="UGE"){
		window.location.href=""+app_path+"main.php?do=Warehouse&action=AddUSPSGlobalExpress&UserId="+UserId;
	}
}





//		Copy Paste and Clear the price

function CopyPrice(ButtonName){
	document.getElementById("CopyButton").value	=	ButtonName;
}

function PastePrice(TextName){

	var NumText	=	document.getElementById("TextQty").value;
	var CopyButtonName	=	document.getElementById("CopyButton").value;
	
	for (var x = 1; x <= NumText; x++)
   {

  	 document.getElementById(TextName + x).value	=	document.getElementById(CopyButtonName + x).value;
   }
}

function ClearPrice(TextName){

	var NumText	=	document.getElementById("TextQty").value;
	
	for (var x = 1; x <= NumText; x++)
   {

  	 document.getElementById(TextName + x).value	=	"";
   }
}


function ChangeAction(ActionName){

	document.getElementById("RetailerItemForm").setAttribute("method", "POST");
	document.searchForm1.action= app_path + "main.php?do=Retailer&action="+ActionName;
	
}

function ChangeActionReprint(){

	document.searchForm.action= app_path + "main.php?do=Warehouse&action=ReprintOrder";
	
}

  function check_classification()
{
	if(document.getElementById('type1').value == '0'){
		alert("Please select any classification!!");
		document.getElementById('type1').focus();
		return false;	
		}else{
		return true;
	}
}