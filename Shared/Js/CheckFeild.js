function CheckShipping(){

	if(!document.FormAddress.SameAddress.checked){
		
		document.getElementById("AddressLine1").disabled=false;
		document.getElementById("AddressLine2").disabled=false;
		document.getElementById("City").disabled=false;
		document.getElementById("State").disabled=false;
		document.getElementById("Zip").disabled=false;
		document.getElementById("Country").disabled=false;
		document.getElementById("Phone").disabled=false;
		
		document.getElementById("AddressLine1").setAttribute("class", "required");
		document.getElementById("City").setAttribute("class", "required");
		document.getElementById("State").setAttribute("class", "required");
		document.getElementById("Zip").setAttribute("class", "required validate-alphanum");
		document.getElementById("Country").setAttribute("class", "validate-selection");
		document.getElementById("Phone").setAttribute("class", "required");
		
	}else{
		
		document.getElementById("AddressLine1").disabled="disabled";
		document.getElementById("AddressLine2").disabled="disabled";
		document.getElementById("City").disabled="disabled";
		document.getElementById("State").disabled="disabled";
		document.getElementById("Zip").disabled="disabled";
		document.getElementById("Country").disabled="disabled";
		document.getElementById("Phone").disabled="disabled";
		
		document.getElementById("AddressLine1").setAttribute("class", "");
		document.getElementById("City").setAttribute("class", "");
		document.getElementById("State").setAttribute("class", "");
		document.getElementById("Zip").setAttribute("class", "");
		document.getElementById("Country").setAttribute("class", "");
		document.getElementById("Phone").setAttribute("class", "");
		
	}
	
}


//	For QAUser add regions

function CheckRegionIdFunction(CheckName, InputName){

var check	=	CheckName;
var Field	=	InputName;

if(!document.getElementById(check).checked){
		
		document.getElementById(Field).disabled=false;
		
	}else{
		
		document.getElementById(Field).disabled="disabled";
		
	}
	
}