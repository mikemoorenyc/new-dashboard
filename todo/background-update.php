<?php
function background_update_init() {
  add_action( 'wp_ajax_backgroundupdate', 'background_update' );
}
add_action('init', 'background_update_init');
function background_update() {
  $oldVal = get_post_meta($_POST['pageid'], 'listItems', true);

  echo '{"listItems": '.$oldVal.'}';
  die();
}


 ?>
