<?php
function ajax_update_item_init() {
  add_action( 'wp_ajax_updatetodo', 'update_todo' );
}
add_action('init', 'ajax_update_item_init');
function update_todo() {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $error = '{"status": "error"}';
  if(empty($id) || empty($title)) {
    echo $error;
    die();
  }

  $updated = wp_update_post( array(
        'ID'=>$id,
        'post_title' =>$title
      ) );
  if($updated) {
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
