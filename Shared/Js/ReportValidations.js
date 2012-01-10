function validateStep1() 
{
	
	if(document.Step1.ReportName.value=="")
	{
		alert("Please Fill the Report Name");
		document.Step1.ReportName.focus();
		return false;
	}
	if(document.Step1.ReportDescription.value=="")
	{
		alert("Please Fill the Report Description");
		document.Step1.ReportDescription.focus();
		return false;
	}
	if(document.Step1.TableName.value==0)
	{
		alert("Please Select The Source Table/View");
		document.Step1.TableName.focus();
		return false;
	}
	
	return true;
}

function validateStep2() 
{
	
	len = document.Step2.SelectedColumn.length
	//alert(len);
	i = 0;
	chosen = "";
	
	for (i = 0; i < len; i++) {
		if (document.Step2.SelectedColumn[i].selected) {
			chosen = chosen + document.Step2.SelectedColumn[i].value + "\n";
		}
	}

	//alert(chosen);
	if(chosen=='')
	{
		alert('Please add the columns to the right side');
		return false
	}
	
	
	return true;
	
}


function validateStep3() 
{
	
	
	//alert(len);
	x = 0;
	Count = 0;
	var illegalChars = /[^A-Za-z]/;
	
	for (x = 0; x < document.Step3.elements.length; x++) {
		
		if( document.Step3.elements[x].type=='checkbox'){
			
			Count = Count + 1;
		}
	}
	//alert(Count);
	
	/*for (c = 0; c < Count; c++) {
		var tempDisplayColumnTitle="DisplayTitle"+c;
			//alert(document.getElementById(tempDisplayColumnTitle).value);
			if (illegalChars.test(document.getElementById(tempDisplayColumnTitle).value)) {
			error = "The fields name should not contain spaces";
			alert(error);
			document.getElementById(tempDisplayColumnTitle).focus();
			return false;
    		}	
	}*/
	
	
	for (c = 0; c < Count; c++) {
		var tempDisplayColumnName="DisplayColumnNamecheck"+c;
		var tempDisplayColumnFunc="DisplayColumnFunc"+c;
		var tempDisplayColumnTitle="DisplayColumnTitle"+c;
		var tempColGroupBy="ColGroupBy"+c;	
		
		if(document.getElementById(tempDisplayColumnName).checked==true){
				if(document.getElementById(tempDisplayColumnTitle).value==''){
					var tempvalue=document.getElementById(tempDisplayColumnTitle).value;
					error="field Lable can not be Left blank"+tempvalue;
					alert(error);
					document.getElementById(tempDisplayColumnTitle).focus();	
					return false
				}else{
						if(document.getElementById(tempDisplayColumnFunc).value!=''){
								if(document.getElementById(tempColGroupBy).value==''){	
								var tempvalue1=document.getElementById(tempDisplayColumnTitle).value;
								error="Please Select A Group By function for "+tempvalue1;
								alert(error);
								document.getElementById(tempColGroupBy).focus();	
								return false
							}
							
						}
				}
		
		}
	
	}
	
	return true;
	
}


function validateStep4() 
{
	
	
	//alert(len);
	x = 0;
	Count = 0;
	var illegalChars = /[^A-Za-z]/;
	var letterNumbersUnderscores = 	/\W/; // allow letters, numbers, and underscores*/
	
	for (x = 0; x < document.Step4.elements.length; x++) {
		
		if( document.Step4.elements[x].type=='checkbox'){
			
			Count = Count + 1;
		}
	}
	//alert(Count);
	
	for (c = 0; c < Count; c++) {
		var tempFormFieldNameid="FormFieldNameid"+c;
		var tempFormColumnLabel="FormColumnLabel"+c;
		var tempFormColumnscheck="FormColumnscheck"+c;
		var tempFormFieldTypeid="FormFieldTypeid"+c;
		var tempAll_tables_FieldSource="All_tables_FieldSource"+c;
		var tempColLabelFieldSource="ColLabelFieldSource"+c;
		var tempColValueFieldSource="ColValueFieldSource"+c;
		
		if(document.getElementById(tempFormColumnscheck).checked==true){
			if(document.getElementById(tempFormFieldNameid).value==''){					
					error="field Name can not be Left blank";
					alert(error);
					document.getElementById(tempFormFieldNameid).focus();	
					return false
			}
			if(document.getElementById(tempFormColumnLabel).value==''){					
					error="field Lable can not be Left blank";
					alert(error);
					document.getElementById(tempFormColumnLabel).focus();	
					return false
			}
			//if (illegalChars.test(document.getElementById(tempFormFieldNameid).value)) {
			if (letterNumbersUnderscores.test(document.getElementById(tempFormFieldNameid).value)) {				
				error = "The fields name should not contain spaces";
				alert(error);
				document.getElementById(tempFormFieldNameid).focus();
				return false;
    		}
			for (j = 0; j < Count; j++) {
				var tempFormFieldNameid_temp="FormFieldNameid"+j;				
				if(c!=j){
					if(document.getElementById(tempFormFieldNameid).value==document.getElementById(tempFormFieldNameid_temp).value){
						error = "The fields name should not be same";
						alert(error);
						document.getElementById(tempFormFieldNameid).focus();
						return false;
					}
				}
			}
			if(document.getElementById(tempFormFieldTypeid).value=='externalsource'){	
					if(document.getElementById(tempAll_tables_FieldSource).value==''){				
						error="Please Select A Group By function";
						alert(error);
						document.getElementById(tempAll_tables_FieldSource).focus();	
						return false
					} else{
						if(document.getElementById(tempColLabelFieldSource).value==''){				
							error="Please Select A Label";
							alert(error);
							document.getElementById(tempColLabelFieldSource).focus();	
							return false
						}
						if(document.getElementById(tempColValueFieldSource).value==''){				
							error="Please Select A Value";
							alert(error);
							document.getElementById(tempColValueFieldSource).focus();	
							return false
						}					
					
					}
				
			}
			
		}
			
	}	
	
	

}



function checkAll()
{
	for (y = 0; y < document.Step3.elements.length; y++) {		
		if( document.Step3.elements[y].type=='checkbox'){
			document.Step3.elements[y].checked= true ;			
		}
	}
}

function uncheckAll()
{
	for (z = 0; z < document.Step3.elements.length; z++) {		
			if( document.Step3.elements[z].type=='checkbox'){
				document.Step3.elements[z].checked= false ;			
			}
	}
}


function checkAll2()
{
	for (y = 0; y < document.Step4.elements.length; y++) {		
		if( document.Step4.elements[y].type=='checkbox'){
			document.Step4.elements[y].checked= true ;			
		}
	}
}

function uncheckAll2()
{
	for (z = 0; z < document.Step4.elements.length; z++) {		
			if( document.Step4.elements[z].type=='checkbox'){
				document.Step4.elements[z].checked= false ;			
			}
	}
}