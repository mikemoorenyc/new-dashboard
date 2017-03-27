<?php
require_once("../../../wp-load.php");
if(empty($_GET['id'])) {
  die();
}
$api_id = $_GET['id']);
$keys = explode("\n",get_option( 'api_keys', '' ));
$keyArray = array();
foreach($keys as $k) {
  $ex = explode(',',$k);
  $keyArray[trim($ex[0]) ] = trim($ex[1]);
}
echo file_get_contents(htmlspecialchars_decode($keyArray[$api_id]));
die();


 ?>
