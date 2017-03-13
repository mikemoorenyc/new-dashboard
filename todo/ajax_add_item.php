<?php
function ajax_add_item_init() {
  add_action( 'wp_ajax_addtodo', 'insert_todo' );
}
add_action('init', 'ajax_add_item_init');

function insert_todo() {
  $title = $_POST['title'];
  $error = '{"status": "error"}';
  if(empty($title)) {
    echo $error;
    die();
  }
  $args = array(
    'post_type' 		=> 'todo',
    'orderby' 			=> 'menu_order',
    'order' 			=> 'ASC',
    'posts_per_page' => -1
  );
  $files_in_cat_query = new WP_Query($args);
  if ( $files_in_cat_query->have_posts() ) {
    $todoArray = array();
    $todos = $files_in_cat_query->get_posts();
    $looper=1;
    foreach($todos as $t) {
      wp_update_post( array(
        'ID'=>$t->ID,
        'menu_order' =>$looper
      ) );
      $looper++;
    }
  }
  $insert = wp_insert_post( array(
    'post_title' => $title,
    'post_type' => 'todo',
    'menu_order'=> 0,
    'post_status'=> 'publish'
  ) );

  if($insert) {



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
