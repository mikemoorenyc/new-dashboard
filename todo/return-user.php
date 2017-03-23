<?php
function returnUser($id) {
  $user = get_user_by( 'ID', $id );
  $color =  get_the_author_meta( '_color', $id );
  $cal = get_the_author_meta( '_original_token', $id );
  $calendarReady = true;
  if(empty($cal)) {
    $calendarReady = false;
  }
  if(empty($color)) {
    $color = false;
  }
  return array(
    "id" => intval($id),
    "firstname" => $user->user_firstname,
    "color" => $color,
    "calendarReady" => $calendarReady
  );
}

 ?>
