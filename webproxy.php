<?php
require_once("../../../wp-load.php");
if(($_GET['id']) == 'stocks') {
  $stocks = '';
  $keys = explode("\n",get_option( 'api_keys', '' ));
  $keyArray = array();
  foreach($keys as $k) {
    $ex = explode(',',$k);
    if(trim($ex[0]) == 'stocks') {
      $stocks =trim($ex[1]) ;
    }
    $keyArray[trim($ex[0]) ] = trim($ex[1]);
  }
  //var_dump($stocks);
  //$test = file_get_contents($stocks)


  echo file_get_contents(htmlspecialchars_decode($stocks));

  die();
}
echo file_get_contents(($_GET['id']));

 ?>
