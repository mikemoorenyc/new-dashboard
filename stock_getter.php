<?php
require_once("../../../wp-load.php");
$api = get_option('stock_api_key','');
$stocks = explode(',', get_option('stock_symbols',''));
if(empty($api) || empty($stocks)) {
 echo '[]';
 die();
}


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
 $close = floatval($daily["Time Series (Daily)"][1]['4. close'] );
 $current = $intra["Time Series (1min)"][0];
 $cVal = 9999;
 foreach($current as $k => $c) {
  if($k === "5. volume"){continue;}
  if( floatval($c) < $cVal) {
   $cVal = floatval($c); 
  }
 }
 $s_array[] = array(
  'title' => strtoupper($sym),
  'last' => round($cVal, 2),
  'change' => round($cVal - $close, 2)
 
 );
 
  
}
curl_close($ch);
echo json_encode($s_array);
die();
?>
