<?php
function ajax_shift_items_init() {
  add_action( 'wp_ajax_shifttodos', 'shift_todos' );
}
add_action('init', 'ajax_shift_items_init');
function shift_todos() {
  $items = $_POST['listItems'];
  $error = '{"status": "error"}';
  if(empty($items)) {
    echo $error;
    die();
  }
  $looper = 0;
  $updated = true;
  foreach($items as $i) {
    wp_update_post( array(
          'ID'=>$i['id'],
          'menu_order' =>$looper
        ) );
    $looper++;
  }


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
