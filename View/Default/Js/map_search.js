function check()
{
	if(document.getElementById('Search1').value == '')
	{
		alert('Enter any Keyword or Business');
		return false;	
	}else{
		return true;	
	}
}

var options = {
	script:"main.php?do=Listing&action=loadAjax&json=true&limit=6&",
	varname:"kw",
	json:true,
	shownoresults:false,
	maxresults:6,
	callback: function (obj) { document.getElementById('testid').value = obj.id; }
};
var as_json = new bsn.AutoSuggest('Search1', options);