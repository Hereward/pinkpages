//------------------------------------------------------
//                Email validation
//------------------------------------------------------
function isEmail(aStr)
  {
       var reEmail=/^[0-9a-zA-Z_\.-]+\@[0-9a-zA-Z_\.-]+\.[0-9a-zA-Z_\.-]+$/;
       if(!reEmail.test(aStr))
       {
               return false;
       }
               return true;
  }
  

	function check_req_val1()
	{
		if(document.getElementById('phone').value == '' && document.getElementById('email').value == ''){
			alert("Enter either a phone number or an email address!!");
			document.getElementById('email').focus();
			return false;	
			}else if (document.getElementById('email').value != '' && !isEmail(document.getElementById('email').value))
			{
			alert("Enter valid email address!!");
			document.getElementById('email').focus();
			return false;		
			}else{
			return true;
		}
	}
	
function check_req_val()
{
	if(document.getElementById('email').value == '' && document.getElementById('phone').value == '')
    {
            alert("You need to fill in an email address or a phone number so we can contact you!!");
            document.getElementById('email').focus();
            return false;
     }   
            else if(document.getElementById('email').value != '' && !isEmail(document.getElementById('email').value))
                {
                
                alert("Email is invalid!!");
				document.getElementById('email').focus();
		        return false;
	           	
		        }   
		            else
		            {
    		        //alert("Your contact form has been submitted, thank you");
		                return true;
		} 
}
	


function checkStreet()
{
	if(document.getElementById('Search1').value == '' && document.getElementById('Search2').value == '')
	{
		alert("-Please enter a street name \n-Please enter a suburb");
		return false;	
	}else if(document.getElementById('Search1').value == '')
	{
		alert('-Please enter a street name');
		return false;	
	}
	else if(document.getElementById('Search2').value == '')
	{
		alert('-Please enter a suburb');
		return false;	
	}else{
		return true;
	}
}