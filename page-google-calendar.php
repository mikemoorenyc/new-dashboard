<?php
/**
 * Template Name: Google calendar
 */
header('Content-Type: application/json');
session_start();

$google_api_path = get_option( 'google_api_path', '' );
$current_url = get_permalink();
$user_id = wp_get_current_user()->ID;
if(!empty($_GET['id'])) {
  $user_id = $_GET['id'];
}

$original_token = get_the_author_meta( '_original_token', $user_id );
$access_token = get_the_author_meta( '_access_token', $user_id );


if(!empty($_GET['id'])) {
  $user_id = $_GET['id'];
}
if(empty($google_api_path)) {
  echo '<a href="'.admin_url( 'options-general.php').'">Set the path on the server</a>';
  die();
}
require_once $google_api_path.'/Google/autoload.php';
$client = new Google_Client();
$client->setAuthConfigFile($google_api_path.'/client_secret.json');
$client->setRedirectUri($current_url);
$client->setAccessType('offline');
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);
if(empty($original_token) && ! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
}
if(empty($original_token) &&  isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $first_token =  $client->getAccessToken();
  var_dump($first_token);
  update_usermeta( $user_id, '_original_token', $first_token );
  update_usermeta( $user_id, '_access_token', $first_token );
  wp_redirect( $current_url );
  die();
}

$client->setAccessToken($access_token);
if($client->isAccessTokenExpired() ) {
	//echo'bad';
	$refresh_token = json_decode($original_token)->refresh_token;
	//var_dump($refresh_token);
	$client->refreshToken($refresh_token);
	$newtoken=$client->getAccessToken();
	update_usermeta( $user_id, '_access_token', $newtoken);
	$client->setAccessToken($newtoken);

}


/*
if($client->isAccessTokenExpired() ) {
	//echo'bad';
	$refresh_token = json_decode($og_access)->refresh_token;
	//var_dump($refresh_token);
	$client->refreshToken($refresh_token);
	$newtoken=$client->getAccessToken();
	file_put_contents($access_file, $newtoken);
	$client->setAccessToken($newtoken);

}
*/
date_default_timezone_set('America/New_York');
$year = date('Y');
$month = date('m');
$today = date('d');
$ystring = $year.'-'.$month.'-'.$today;

$datetime = new DateTime($ystring);
$datetime->modify('+1 day');
$tomorrowFull = $datetime->format('Y-m-d');
$timeMin = $year.'-'.$month.'-'.$today.'T00:00:00-05:00';
$timeMax = $tomorrowFull.'T23:59:00-05:00';

$calendar_service = new Google_Service_Calendar($client);

$list = $calendar_service->events->listEvents('primary',
array(
	'singleEvents' => true,
	'timeMin' => $timeMin,
	'timeMax' => $timeMax
));

$items= $list->items;
$dateArray = array();


foreach($items as $item) {
	//var_dump($item);
	if($item->start->dateTime == NULL) {
		$date = $item->start->date.'T00:01:00-05:00';
	} else {
		$date = $item->start->dateTime;
	}
	array_push($dateArray,
		array(
		'title' => $item->summary,
		'date' => $date
		)
	);
}


echo json_encode(array(
  'items' =>$dateArray
));

die();


//ACCESS TOKEN
//

/*
if($_GET['type'] == 'personal') {
	$access_file = 'personal-access.txt';
	$og_file = 'personal-og.txt';
} else {
	$access_file = 'access.txt';
	$og_file = 'rea-og.txt';
}

$access_token = file_get_contents($access_file);
$og_access = file_get_contents($og_file);

$client = new Google_Client();
$client->setAuthConfigFile('client_secret.json');
$client->setAccessType('offline');
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

$client->setAccessToken($access_token);



if($client->isAccessTokenExpired() ) {
	//echo'bad';
	$refresh_token = json_decode($og_access)->refresh_token;
	//var_dump($refresh_token);
	$client->refreshToken($refresh_token);
	$newtoken=$client->getAccessToken();
	file_put_contents($access_file, $newtoken);
	$client->setAccessToken($newtoken);

}
date_default_timezone_set('America/New_York');
$year = date('Y');
$month = date('m');
$today = date('d');
$ystring = $year.'-'.$month.'-'.$today;

$datetime = new DateTime($ystring);
$datetime->modify('+1 day');
$tomorrowFull = $datetime->format('Y-m-d');
$timeMin = $year.'-'.$month.'-'.$today.'T00:00:00-05:00';
$timeMax = $tomorrowFull.'T23:59:00-05:00';

$calendar_service = new Google_Service_Calendar($client);

$list = $calendar_service->events->listEvents('primary',
array(
	'singleEvents' => true,
	'timeMin' => $timeMin,
	'timeMax' => $timeMax
));

$items= $list->items;
$dateArray = array();


foreach($items as $item) {
	//var_dump($item);
	if($item->start->dateTime == NULL) {
		$date = $item->start->date.'T00:01:00-05:00';
	} else {
		$date = $item->start->dateTime;
	}
	array_push($dateArray,
		array(
		'title' => $item->summary,
		'date' => $date
		)
	);
}


echo json_encode($dateArray);


/*
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
var_dump($_SESSION['access_token']);
  $client->setAccessToken($_SESSION['access_token']);
  $calendar_service = new Google_Service_Calendar($client);
  $list = $calendar_service->events->listEvents('primary');
  var_dump($list);

} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/dashboard/googleapi/oauth2callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  //echo'help';
}

$client = new Google_Client();
$client->setAuthConfigFile('client_secret.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/dashboard/googleapi/oauth2callback.php');
$client->setAccessType('offline');
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  var_dump($_SESSION['access_token']);
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/dashboard/googleapi/quickstart.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
*/

?>
