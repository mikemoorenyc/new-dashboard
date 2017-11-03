<?php
require_once("../../../wp-load.php");
$api = get_option('stock_api_key','');
$stocks = explode(',', get_option('stock_symbols',''));
if(empty($api) || empty($stocks)) {
 echo '[]';
 die();
}
date_default_timezone_set('America/Los_Angeles');


$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$s_array = [];

foreach($stocks as $s) {
 $sym = trim($s);
 curl_setopt($ch, CURLOPT_URL, 'https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol='.$sym.'&interval=1min&apikey='.$api);
 $intra = curl_exec($ch);
 if($intra === false) {
    continue;
 }
 $intra = json_decode($intra,true);

 curl_setopt($ch, CURLOPT_URL, 'https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol='.$sym.'&apikey='.$api);
 $daily = curl_exec($ch);
 if($daily === false) {
    continue;
 }
 $daily = json_decode($daily,true);

$last_update = $daily['Meta Data']["3. Last Refreshed"];
$yesterday = new DateTime($last_update);
$yesterday->modify('-1 day');

$close = floatval($daily["Time Series (Daily)"][$yesterday->format('Y-m-d')]["4. close"]);
	
 $current = floatval($intra["Time Series (1min)"][$intra["Meta Data"]["3. Last Refreshed"]]["4. close"]);
 $s_array[] = array(
  'title' => strtoupper($sym),
  'last' => round($current,2),
  'change' => round($current - $close,2)
 
 );
 
  
}
curl_close($ch);
echo json_encode($s_array);
die();
?>
