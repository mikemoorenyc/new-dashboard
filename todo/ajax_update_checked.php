<?php

function ajax_update_item_checked_init() {
  add_action( 'wp_ajax_updatechecked', 'updateChecked' );
}
add_action('init', 'ajax_update_item_checked_init');




function updateChecked() {
  $checked = $_POST['checked'];
  $id = $_POST['id'];
  $error = '{"status": "error"}';
  if(empty($checked) || empty($id)) {
    echo $error;
    die();
  }
  if($checked === 'uncheck') {
    wp_update_post( array(
          'ID'=>$id,
          'post_content' =>''
        ) );
    update_post_meta($id, 'checkedBy', '');
  }
  if(is_numeric($checked)) {
    wp_update_post( array(
          'ID'=>$id,
          'post_content' =>'checked'
        ) );
    update_post_meta($id, 'checkedBy', $checked);
  }


  $response = array(
    'status'=> 'success',
    'listItems' => get_all_todos()
  );
  echo json_encode($response);



  die();
}
 ?>
