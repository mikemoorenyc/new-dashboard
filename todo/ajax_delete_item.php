<?php
function ajax_delete_item_init() {
  add_action( 'wp_ajax_deletetodo', 'delete_todo' );
}
add_action('init', 'ajax_delete_item_init');
function delete_todo() {
  $id = $_POST['id'];
  $error = '{"status": "error"}';
  if(empty($id)) {
    echo $error;
    die();
  }

  $delete = wp_trash_post( $id, false );
  if($delete) {
    $response = array(
      'status'=> 'success',
      'listItems' => get_all_todos()
    );
    echo json_encode($response);
    die();
  } else {
    echo $error;
    die();
  }
}
 ?>
