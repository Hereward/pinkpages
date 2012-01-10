<?

require_once 'System/Utils/Stats.class.php';

$stats = new Stats();

//Validate the banner_id and increment its click count
$id  = (int)$_GET['id'];
$url = $stats->setBannerClick($id);

if($url === FALSE){
  header("Location: http://www.pinkpages.com.au/");
} else {
  header("Location: " . $url);
}

?>