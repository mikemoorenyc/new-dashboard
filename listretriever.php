<?php
require_once("../../../wp-load.php");

echo json_encode(
  array(
    'status'=>'success',
    'listItems'=>get_all_todos()
  )

);

 ?>
