<?php
require_once("../../../wp-load.php");


if($_GET['ts']) {
	$args = array(
    'post_type' 		=> 'todo',
    'orderby' 			=> 'modified',
    'order' 			=> 'DESC',
    'posts_per_page' => -1
  );
$files_in_cat_query = new WP_Query($args);

if ( $files_in_cat_query->have_posts() ) {
	$first = $files_in_cat_query->get_posts()[0];
	$date = new DateTime($first->post_modified_gmt,new DateTimeZone('UTC'));
	$date->setTimezone(new DateTimeZone('EST'));
	
	if($date->getTimestamp() < intval($_GET['ts'])) {
		header('HTTP/1.0 304 Not Modified');
		die();

	}	
		
}
	
	
	
}



echo json_encode(
  array(
    'status'=>'success',
    'listItems'=>get_all_todos()
  )

);

 ?>
