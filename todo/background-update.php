<?php
function background_update_init() {
  add_action( 'wp_ajax_backgroundupdate', 'background_update' );
}
add_action('init', 'background_update_init');
function background_update() {


  echo json_encode(array(
    'listItems'=>get_all_todos()
  ));
  die();
}


 ?>
