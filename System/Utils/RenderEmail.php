<?php
ini_set("display_errors", 0);
class RenderEmail {
	
	var $ReplaceVars = array(
							"OrdersID"=>'',
							"CustomersContactFName"=>'',
							"OrderDomainStr"=>'',
							"ServerDomainStr"=>'',
							"EmailFrom"=>'',
							"OrderTotal"=>'',
							"RetailersDomainStr"=>'',
							"RetailerPhone"=>'',
							"RetailerEmail"=>'',
							"CustomersID"=>'',
							"CustomersContactLName"=>'',
							"AddressBillingStreet"=>'',
							"AddressBillingStreet2"=>'',
							"AddressBillingCity"=>'',
							"AddressBillingRegion"=>'',
							"AddressBillingPostalCode"=>'',
							"AddressBillingCountry"=>'',
							"AddressBillingPhone"=>'',
							"AddressShippingStreet"=>'',
							"AddressShippingStreet2"=>'',
							"AddressShippingCity"=>'',
							"AddressShippingRegion"=>'',
							"AddressShippingPostalCode"=>'',
							"AddressShippingCountry"=>'',
							"AddressShippingPhone"=>'',
							"PaymentCardNumber"=>'',
							"PaymentCardType"=>'',
							"CustomerDOB"=>'',
							"OrderDetailsItemQty"=>'',
							"OrderDetailsItemDirections"=>'',
							"TPName"=>'',
							"TPAddress"=>'',
							"TPPhone"=>'',
							"TPFax"=>'',
							"TPReorders"=>'',
							"TPLicense"=>'',
							"OrderDetailsItemName"=>'',
							"EmailFrom"=>'',
							"OrderTotal"=>'',
							"OrderReferrer"=>'',
							"OrderTotal"=>'',
							"Fname"=>'',
							"Lname"=>'',
							"DomainStr"=>'',
							"SYSID"=>'',
							"Timestamp"=>'',
							"ItemNum"=>'',
							"ItemName"=>'',
							"Email"=>''
							);
	var $TemplateText='';
	
	function setTemplate($Text) {
	//echo "sssss".$Text; exit;
		$this->TemplateText = $Text;
	}
	
	function setVar($key, $val) {
		$this->ReplaceVars[$key] = $val;
	}
	
	public static function RenderTemplate($Template, $AssocValues) {
		foreach ($AssocValues as $key=>$val) {
			$Template = str_replace("[[$key]]", $val, $Template);
		}
		return $Template;
	}
}

//$tempObj->TemplateText = "CustID:[[OrdersID]], CustName:[[CustomersContactFName]],OrdDomain:[[OrderDomainStr]]";
//$arr = array("OrdersID"=>100,"CustomersContactFName"=>"Sufyan", "OrderDomainStr"=>"TestDomain");
//echo RenderEmail::RenderTemplate("CustID:[[OrdersID]], CustName:[[CustomersContactFName]],OrdDomain:[[OrderDomainStr]]", $arr);

?>