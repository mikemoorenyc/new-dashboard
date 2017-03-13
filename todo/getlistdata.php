<?php
function getListData($post_id) {
  $listItems = get_post_meta($post_id, 'listItems', true);
  if(empty($listItems)) {
    $listItems = array();
  } else {
    $listItems = json_decode($listItems, true);
  }
  $lastModified = get_post_meta($post_id, 'lastModified', true);
  if(empty($lastModified)) {
    $lastModified = false;
  } else {
    $lastModified = json_decode($listItems, true);
  }

  return array(
    "listItems" => $listItems,
    "lastModified" => $lastModified
  );

}


function get_all_todos() {
  $args = array(
    'post_type' 		=> 'todo',
    'orderby' 			=> 'menu_order',
    'order' 			=> 'ASC',
    'posts_per_page' => -1
  );
  $files_in_cat_query = new WP_Query($args);
  if ( $files_in_cat_query->have_posts() ) {
    $todoArray = array();
    $todos = $files_in_cat_query->get_posts();
    foreach($todos as $t) {
      $checkedBy = false;
       if($t->post_content === 'checked') {
        $checkedBy = returnUser(get_post_meta($t->ID, 'checkedBy', true)); 
       }
      
      $item = array(
        'id' => $t->ID,
        'title' => $t->post_title,
        'addedBy' => returnUser($t->post_author),
        'checkedBy' => $checkedBy
      );
      array_push($todoArray,$item);
    }
    return $todoArray;
  } else {
    return array();
  }


}


 ?>
