<?php
/**
 * Template Name: TODO LIST
 */
?>

<?php

if($_GET['id'] === 'rest') {
  echo json_encode(
    array(
      'listItems' => get_all_todos()
    )
  );
  die();
}

 ?>


<?php

$userInfo =json_encode(false);
$listItems = json_encode(array());


if ( is_user_logged_in() ) {
   $current_user = wp_get_current_user();

  $userInfo = json_encode(returnUser($current_user->ID));

  $listItems = json_encode(get_all_todos());

}




 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="UTF-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
 <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
<link rel="stylesheet" href="<?php echo get_bloginfo('template_url');?>/css/todolist.css?v=<?php echo time();?>">
<title><?php echo get_the_title();?></title>
<script>
var App = {
  userInfo: <?php echo $userInfo;?>,
  listItems: <?php echo $listItems;?>,
  lastModified: null,
  pageid: <?php echo get_the_ID();?>,
  ajaxURL : "<?php echo admin_url( 'admin-ajax.php' );?>",
  currentlyEditing: false,
  saving: false
}


</script>

<?php
$icons = array(180,120,167,152);
$launch = array(
  array(1080,1920),
  array(750,1334),
  array(640,1136),
  array(2048,2732),
  array(1536,2048)
);
$icon_id = get_option( 'ios_icon', '' );
$launch_id =  get_option( 'launch_screen', '' );
$looper = 0;
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
      <?php

      $looper++;
    }

  }
}
if(!empty($launch_id)) {
  $looper = 0;
  foreach($launch as $l) {
    $img = wp_get_attachment_image_src( $launch_id, 'launch_'.$l[0] );
    if(!empty($img)) {
      if($looper === 0) {
        ?>
        <link rel="apple-touch-startup-image" href="<?php echo $img[0];?>">
        <?php
      }
      ?>
      <link rel="apple-touch-startup-image" sizes="<?php echo $l[0];?>x<?php echo $l[1];?>" href="<?php echo $img[0];?>">
      <?php
      $looper++;
    }
  }
}


 ?>

<meta name="apple-mobile-web-app-title" content="M&D Todos">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

</head>

<body>

<div id="entry"></div>
<a target="_blank" href="<?php echo wp_logout_url( ); ?> " style="position:fixed; left:10px; bottom:10px;">Logout</a>

<script src="<?php echo get_bloginfo('template_url');?>/plugin-debounce.js"></script>
<script src="<?php echo get_bloginfo('template_url');?>/plugin-hammer.js"></script>
<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/sortable/1.4.2/Sortable.min.js"></script>
<script src="https://cdn.rawgit.com/David-Desmaisons/Vue.Draggable/master/dist/vuedraggable.min.js"></script>

<script src="<?php echo get_bloginfo('template_url');?>/todo/main.js?v=<?php echo time();?>"></script>

<script type="text/x-template" id="login-template">


  <form @submit.prevent="submit" id="login-form" action="<?php echo admin_url( 'admin-ajax.php' );?>" method="post" >
    <h2>Please log in first</h2>
    <label>Email address</label>
    <input class="text-field" type="email" v-model="email" required  />
    <label>Password</label>
    <input v-model="password" class="text-field" type="password" required  />
    <button class="submit-button">Log In</button>
    <div class="forgot">
      <a target="_blank" href="<?php echo wp_lostpassword_url(); ?>">Forgot your password?</a>
    </div>
    <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>

    <div v-if="modal !== false" id="form-modal">
      <div class="loading centerer" v-if="modal.status === 'loading'">

        Logging you in
        <div class="loader-bar"></div>
      </div>
      <div class="result centerer" v-if="modal.status == 'error' || modal.status == 'success'">
        <div v-if="modal.status == 'error'" class="icon error">
          <?php include get_template_directory().'/icon_error_outline.php';?>
        </div>
        <div v-if="modal.status == 'success'" class="icon">
          <?php
          $svg = file_get_contents(get_template_directory().'/icon_check.php');
          echo str_replace('<svg fill="#000000"','<svg :fill="modal.color"',$svg);

           ?>
        </div>
        <div v-if="modal.status=='error'">We couldn't log you in.<br/><a href="#" @click.prevent="reset">Try again.</a></div>
        <div v-if="modal.status=='success'" v-html="modal.text"></div>
      </div>


    </div>

  </form>


</script>

<script type="text/x-template" id="app-header-template">
    <?php include 'template-app-header.php';?>
</script>
<script type="text/x-template" id="main-list-template">
  <?php include 'template-thelist.php';?>
</script>
<script type="text/x-template" id="template-list-item">
  <?php include 'template-list-item.php';?>
</script>

<!--<div id="data-return" style="position:fixed; background:red; width:100%; left:0;bottom:0;"></div>-->
</body>


</html>
