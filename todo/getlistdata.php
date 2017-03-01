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



 ?>
