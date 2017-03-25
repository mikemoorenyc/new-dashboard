<?php
/**
 * Template Name: MAIN DASH VIEW
 */
?>
<?php


$allUsers = array();

foreach(get_users() as $u) {
  array_push($allUsers, returnUser($u->ID));
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
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
<title><?php echo get_the_title();?></title>
<meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="manifest" href="<?php echo  get_bloginfo('template_url');?>/manifest.php">
<?php
$icons = array(180,120,167,152);
$icon_id = get_option( 'ios_icon', '' );
if(!empty($icon_id)) {
  foreach($icons as $i) {
    $img = wp_get_attachment_image_src( $icon_id, 'icon_'.$i );
    if(!empty($img)) {
      if($looper === 0) {
        ?>
        <link rel="apple-touch-icon" href="<?php echo $img[0];?>">
        <?php
      }
      ?>
      <link rel="apple-touch-icon" sizes="<?php echo $i;?>x<?php echo $i;?>" href="<?php echo $img[0];?>">
      <link rel="icon" type="image/png" sizes="<?php echo $i;?>x<?php echo $i;?>" href="<?php echo $img[0];?>" />
      <?php

      $looper++;
    }

  }
}
 ?>
<script>
var App = {
  apiKeys : <?php echo json_encode($keyArray);?>,
  initialTodos : <?php echo json_encode(get_all_todos());?>,
  wpAjaxURL : "<?php echo admin_url( 'admin-ajax.php' );?>",
  templateURL: "<?php echo  get_bloginfo('template_url');?>",
  allUsers: <?php echo json_encode($allUsers);?>,
  homeURL: "<?php echo esc_url( home_url( ) );?>"
};



</script>

<link rel="stylesheet" type="text/css" href="<?php echo  get_bloginfo('template_url');?>/css/main.css?v=<?php echo time();?>">
</head>
<body>
<div id="main-view" class="clearfix">
  <div class="col">
    <div id="subway"></div>
    <div id="news"></div>
    <div id="clock"></div>
  </div>
  <div class="col">
    <div id="weather"></div>
    <div id="stocks"></div>
  </div>
  <div class="col">
    <div id="calendar"></div>
    <div id="todolist"></div>
  </div>








<?php

if(is_dir(get_template_directory().'/dashview/components/templates')) {
  $dir = new DirectoryIterator(get_template_directory().'/dashview/components/templates');

  foreach ($dir as $fileinfo) {
      if (!$fileinfo->isDot()) {
          $name = $fileinfo->getFilename();
          $path_parts = pathinfo($name);
          ?>
          <script type="text/x-template" id="template-<?php echo $path_parts['filename'];?>">
          <?php
          include get_template_directory().'/dashview/components/templates/'.$path_parts['basename'];
          ?>
          </script>
          <?php
      }
  }
}


 ?>
<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<script src="<?php echo  get_bloginfo('template_url');?>/js/main.js?v=<?php echo time();?>"></script>
<script src="<?php echo  get_bloginfo('template_url');?>/component-maker.php?v=<?php echo time();?>"></script>
<script>
$(document).ready(function(){
  AppInit();
});

</script>
</div>
</body>
</html>
