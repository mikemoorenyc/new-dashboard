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
