<?php
/**
 * Template Name: MAIN DASH VIEW
 */
?>
<?php
if(is_dir(get_template_directory().'/dashview/components/templates')) {
  $dir = new DirectoryIterator(get_template_directory().'/dashview/components/templates');

  foreach ($dir as $fileinfo) {
      if (!$fileinfo->isDot()) {
          $name = $fileinfo->getFilename();
          $path_parts = pathinfo($name);
          ?>
          <script type="text/x-template" id="<?php echo $path_parts['filename'];?>">
          <?php
          include get_template_directory().'/dashview/components/templates/'.$path_parts['basename'];
          ?>
          </script>
          <?php
      }
  }
}


$keys = explode("\n",get_option( 'api_keys', '' ));
$keyArray = array();
foreach($keys as $k) {
  $ex = explode(',',$k);
  $keyArray[trim($ex[0]) ] = trim($ex[1]);
}
//echo json_encode($keyArray);

 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="UTF-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
<title><?php echo get_the_title();?></title>

<script>
var App = {
  apiKeys : <?php echo json_encode($keyArray);?>,
  initialTodos : <?php echo json_encode(get_all_todos());?>,
  wpAjaxURL : "<?php echo admin_url( 'admin-ajax.php' );?>"
};



</script>


</head>
<body>



</body>
</html>
