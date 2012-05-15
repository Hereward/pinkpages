{literal}
<script src="http://www.google.com/adsense/search/ads.js" type="text/javascript"></script> 
<script type="text/javascript" charset="utf-8"> 
function init_gcs(keyword, ads_per_block) {

if (!ads_per_block) {
	ads_per_block = 4;
}


var pageOptions = { 
  'pubId': 'pub-3947502494298555',
  'query': keyword,
  'hl': 'en'
};

var adblock1 = { 
		  'container': 'adcontainer1',
		  'number': ads_per_block,
		  'lines': '3',
		  'fontSizeTitle': '14px',
		  'colorDomainLink': '000000'
};

var adblock2 = { 
		  'container': 'adcontainer2',
		  'number': ads_per_block,
		  'lines': '3',
		  'fontSizeTitle': '14px',
		  'colorDomainLink': '000000'
};




new google.ads.search.Ads(pageOptions, adblock1, adblock2);
}


</script>
{/literal}
<script type="text/javascript" charset="utf-8"> 
var ads_per_block = '{$ads_per_block}';
//alert("A ads_per_block = "+ads_per_block);
init_gcs('{$keyword}',ads_per_block);
</script>



