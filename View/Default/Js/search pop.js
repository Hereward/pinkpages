var classification = {
	script:"main.php?do=Classification&action=loadAjax&json=true&limit=6&",
	varname:"kw",
	json:true,
	shownoresults:false,
	maxresults:6,
	callback: function (obj) { document.getElementById('testid').value = obj.id; }
};

var business = {
	script:"main.php?do=Listing&action=loadAjax&json=true&limit=10&",	
	varname:"kw",
	json:true,
	shownoresults:false,
	maxresults:6,
	callback: function (obj) { document.getElementById('testid').value = obj.id; }
};

var region_location = {
	script:"main.php?do=Search&action=loadAjax&json=true&type=0&limit=10&",
	varname:"kw",
	json:true,
	shownoresults:false,
	maxresults:6,
	callback: function (obj) { document.getElementById('testid').value = obj.id; }
};

var as_json = new bsn.AutoSuggest('Search1', classification);

var region_json = new bsn.AutoSuggest('Search2', region_location);



function setOption(val) {
	if(val == 'c') {
		as_json = new bsn.AutoSuggest('Search1', classification);
	}
	else {
		as_json = new bsn.AutoSuggest('Search1', business);
	}
}

  
function check()
{
	if(document.getElementById('Search1').value == '')
	{
		alert("-Please enter a keyword or business name in the" + "`" + "Search For" + '`' + "box");
		return false;	
	}else{
		return true;
	}
}

function check_inner()
{
	if(document.getElementById('Search1').value == '')
	{
		alert("-Please enter a keyword or business name");
		return false;	
	}else{
		return true;
	}
}


function checkBusiness()
{
	if(document.getElementById('Search1').value == '')
	{
		alert('-Please enter a Business Name');
		return false;	
	}else{
		return true;
	}
}



function classChange(val)
{
	if(val =='0')
	{	
	document.getElementById('do').value='Listing';
	document.getElementById('action').value='searchKeyword';
	}else{
	document.getElementById('do').value='Listing';
	document.getElementById('action').value='search';
	}
}