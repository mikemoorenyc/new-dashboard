<?php
function update_value_init() {
  add_action( 'wp_ajax_updatevalues', 'update_values' );
}
if (is_user_logged_in()) {
    add_action('init', 'update_value_init');
}

function update_values() {
  $oldVal = get_post_meta($_POST['pageid'], 'listItems', true);
  $newVal = json_encode($_POST['listItems'], true);


  if($newVal === $oldVal) {
    echo json_encode(
      array(
        'updated '=> false
      )
    );
    die();
  } else {
    update_post_meta($_POST['pageid'], 'listItems', $newVal);
    echo '{"updated": true, "listItems": '.$newVal.'}';
  }

  die();
}




 ?>
