<?php
function returnUser($id) {
  $user = get_user_by( 'ID', $id );
  $color =  get_the_author_meta( '_color', $id );
  if(empty($color)) {
    $color = false;
  }
  return array(
    "id" => intval($id),
    "firstname" => $user->user_firstname,
    "color" => $color
  );
}

 ?>
