{literal}
<script src="http://www.google.com/adsense/search/ads.js" type="text/javascript"></script> 
<script type="text/javascript" charset="utf-8"> 
function init_gcs(keyword) {
var pageOptions = { 
  'pubId': 'pub-3947502494298555',
  'query': keyword,
  'hl': 'en'
};

var adblock1 = { 
		  'container': 'adcontainer1',
		  'number': '4',
		  'lines': '3',
		  'fontSizeTitle': '14px',
		  'colorDomainLink': '000000'
};

var adblock2 = { 
		  'container': 'adcontainer2',
		  'number': '4',
		  'lines': '3',
		  'fontSizeTitle': '14px',
		  'colorDomainLink': '000000'
};




new google.ads.search.Ads(pageOptions, adblock1, adblock2);
}


</script>
{/literal}
<script type="text/javascript" charset="utf-8"> 
init_gcs('{$keyword}');
</script>



