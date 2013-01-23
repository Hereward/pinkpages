<?php 

$test = TRUE;

if ($test) {
	$db_name = "ppo_dev";
	$db_host = "localhost";
	$db_user = "root";
	$db_pass = "pullit911";
} else {
	$db_name = "ppo_prd";
	$db_host = "localhost";
	$db_user = "root";
	$db_pass = "H1virJ2a";
}



$url_stem = 'http://www.pinkpages.com.au';
header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8" ?>';

$url_tpl = '<url> 
    <loc>%s</loc> 
    <lastmod>%s</lastmod>
    <changefreq>%s</changefreq>
    <priority>%s</priority>
</url>';

$top_list_str = "
$url_stem/MEDICAL+PRACTITIONERS/NSW/2331,
$url_stem/TURF/NSW/2161,
$url_stem/BUILDING+CONTRACTORS+-+GENERAL/NSW/912,
$url_stem/DENTISTS/NSW/1417,
$url_stem/HAIRDRESSERS/NSW/1898,
$url_stem/RESTAURANTS/NSW/2830,
$url_stem/ACCOUNTANTS/NSW/608,
$url_stem/DOG+%26+CAT+GROOMING/NSW/1471,
$url_stem/BEAUTY+SALONS/NSW/802,
$url_stem/ELECTRICIANS/NSW/1523,
$url_stem/DRIVING+SCHOOLS/NSW/1497,
$url_stem/MECHANICS+-+MOBILE/NSW/2383,
$url_stem/SOLICITORS/NSW/3045,
$url_stem/PAINTERS/NSW/2525,
$url_stem/SCHOOLS+-+PUBLIC/NSW/2906,
$url_stem/PLUMBERS/NSW/2677,
$url_stem/CAR+%26+TRUCK+DETAILING/NSW/2231,
$url_stem/CLEANING+CONTRACTORS/NSW/1160
";

$top_list = implode(',', $top_list_str);
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        
  <url> 
    <loc><?php echo $url_stem ?></loc> 
    <lastmod>2013-01-23</lastmod>
    <changefreq>weekly</changefreq>
    <priority>1.00</priority>
  </url>
  
  <url> 
    <loc><?php echo htmlspecialchars("$url_stem/main.php?do=Content&action=contactUs"); ?></loc> 
    <lastmod>2013-01-23</lastmod>
    <changefreq>weekly</changefreq>
    <priority>1.00</priority>
  </url>
  
 <?php
   foreach (range('a', 'z') as $char) {
   	  $loc = htmlspecialchars("$url_stem/Listing/browseCategory/search/$char");
      $output = sprintf($url_tpl,$loc,'2013-01-23','weekly','1.00');
      echo "$output\n";
   } 
   
   foreach ($top_list as $url_raw) {
   	  $loc = htmlspecialchars(trim($url_raw));
      $output = sprintf($url_tpl,$loc,'2013-01-23','weekly','1.00');
      echo "$output\n";
   } 
   
   

   $db_link = mysql_connect($db_host, $db_user, $db_pass);
   mysql_select_db($db_name);
   
   $query = 'SELECT * FROM `local_businesses` ORDER BY `local_businesses`.`date_modified` DESC, `local_businesses`.`business_id` DESC LIMIT 0 , 300';
   $query_result = mysql_query($query);
   while ($line = mysql_fetch_array($query_result, MYSQL_ASSOC)) {
    
        $last_mod = ($line['date_modified']=='0000-00-00 00:00:00')?'2013-01-23':$line['date_modified'];
        
        $time = strtotime($last_mod);
        $formatted_time = date("Y-m-d",$time);
        $loc = htmlspecialchars("$url_stem/{$line['url_alias']}/{$line['business_id']}/listing");
        $output = sprintf($url_tpl,$loc,$formatted_time,'daily','1.00');
        echo "$output\n";
   }
   
   mysql_free_result($query_result);
   mysql_close($db_link);
 ?>
  
 
  
  
</urlset>





<?php 
/*
header("Content-type: text/xml");

<?xml version="1.0" encoding="UTF-8" ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        
  <url> 
    <loc>http://www.example.com/foo.html</loc> 
    <image:image>
       <image:loc>http://example.com/image.jpg</image:loc> 
    </image:image>
    <video:video>     
      <video:content_loc>http://www.example.com/video123.flv</video:content_loc>
      <video:player_loc allow_embed="yes"
      autoplay="ap=1">http://www.example.com/videoplayer.swf?video=123</video:player_loc>
      <video:thumbnail_loc>http://www.example.com/thumbs/123.jpg</video:thumbnail_loc>
      <video:title>Grilling steaks for summer</video:title>  
      <video:description>Get perfectly done steaks every time</video:description>
    </video:video>
  </url>
</urlset>
*/
 
?>

