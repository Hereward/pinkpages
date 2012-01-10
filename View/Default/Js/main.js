var app_path = "";
function reportError(request)
{
	alert('Sorry. There was an error.');
}

//------------------ Open Index page ---------------------------------
function ChangeRetailer(DivId)
{
	if($(DivId).innerHTML != '') {
		Effect.toggle(DivId,'slide');
		return false;
	}
	else {
		$(DivId).innerHTML = '<p>Loading...</p>';
	}
	var url = app_path + 'main.php?do=OrderItem&action=ChangeRetailer';
	var myAjax = new Ajax.Updater(
	{success:DivId},
	url,
	{
		method: 'get',
		parameters: '',
		onComplete:Effect.toggle(DivId,'slide'),
		onFailure: reportError
	});
}

function ChangeTemplate(mystring)
{
    //alert(mystring); 
    var mySplitResult = mystring.split("_");
    var EmailTemplateId=mySplitResult[0];
    var OrderItemId=mySplitResult[1];
    //alert(EmailTemplateId);
    //alert(OrderItemId);
    //return false;
    var url = app_path + 'main.php?do=OrderItem&action=ChangeEmailsTemplet&EmailTemplateId='+EmailTemplateId+'&OrderItemId='+OrderItemId;
    //var url='view/EmailsMidAjax.php?';
    var myAjax = new Ajax.Updater(
    {success:'TemplateId'},
    url,
    {
        method: 'get',
        parameters: '',
        onFailure: reportError
    });
}


function SaveClassification(ID, keyword)
{
	var url = app_path + 'main.php?do=Classification&action=editKeyword&ID='+ID+'&keyword='+keyword;
	var myAjax = new Ajax.Request(
	url,
	{
		method: 'get',
		parameters: '',
//        onComplete: test
		onFailure: reportError
	});
}

function SaveKeys(ID, keyword)
{  
	var url = app_path + 'main.php?do=Key&action=editKeys&ID='+ID+'&keyword='+keyword;

	var myAjax = new Ajax.Request(
	url,
	{
		method: 'get',
		parameters: '',
	onFailure: reportError
	});
}

function SaveConfigValue(ID, keyword)
{  

	var url = app_path + 'main.php?do=Admin&action=editConfigValue&ID='+ID+'&keyword='+keyword;

	var myAjax = new Ajax.Request(
	url,
	{
		method: 'get',
		parameters: '',
	onFailure: reportError
	});
}


function saveRate(ID, rate)
{  
	var url = app_path + 'main.php?do=Admin&action=editRate&ID='+ID+'&rate='+rate;


	var myAjax = new Ajax.Request(
	url,
	{
		method: 'get',
		parameters: '',
	onFailure: reportError
	});
}

var newwindow;
function poptastic(url)
{
	
newwindow=window.open(url,'sydneypinkpages','height=auto,width=900,left=60,top=60,resizable=yes,scrollbars=yes,toolbar=no,status=yes');

if (window.focus) {newwindow.focus()}

}

