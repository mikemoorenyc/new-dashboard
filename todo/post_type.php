<?php
function todo_post_init() {
//PROPERTY
$args = array(
  'label' => 'Todos',
  'public' => false,
  'labels' => array(
    'add_new_item' => 'Add New Todo',
    'name' => 'Todos',
    'edit_item' => 'Edit Todo',
    'search_items' => 'Search Todos',
    'not_found' => 'No Todos found.',
    'all_items' => 'All Todos'
  ),
  'show_ui' => true,
  'capability_type' => 'page',
  'hierarchical' =>true,
  'has_archive' => false,
  'rewrite' => array('slug' => 'todo'),
  'query_var' => true,
  'menu_icon' =>'dashicons-yes',
  'supports' => array(
      'title',
      'editor',
      'revisions',
      'page-attributes'
    )
  );
register_post_type( 'todo', $args );

}
add_action( 'init', 'todo_post_init' );
 ?>
