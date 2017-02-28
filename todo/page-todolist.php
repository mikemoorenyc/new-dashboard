<?php
/**
 * Template Name: TODO LIST
 */
?>


<?php
$userInfo = json_encode(false);

if ( is_user_logged_in() ) {
   $current_user = wp_get_current_user();

  $userInfo = json_encode(returnUser($current_user->ID));
}

$listItems = json_encode(array());

$editStatus = json_encode(array());



 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 <meta charset="UTF-8" />
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

<title><?php echo get_the_title();?></title>
<script>
var App = {
  userInfo: <?php echo $userInfo;?>,
  listItems: <?php echo $listItems;?>,
  lastEdited: false
}

</script>
</head>

<body>
<a target="_blank" href="<?php echo wp_logout_url( ); ?> ">Logout</a>
<div id="entry"></div>

<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/sortable/1.4.2/Sortable.min.js"></script>
<script src="https://cdn.rawgit.com/David-Desmaisons/Vue.Draggable/master/dist/vuedraggable.min.js"></script>
<script src="<?php echo get_bloginfo('template_url');?>/todo/main.js"></script>

<script type="text/x-template" id="login-template">
<div>
  <form id="login-form" action="<?php echo admin_url( 'admin-ajax.php' );?>" method="post" >
    <input type="text" v-model="email" required placeholder="Email Address" />
    <input v-model="password" type="password" placeholder="Password" />
    <button @click.prevent="submit">Submit</button>
    <a target="_blank" href="<?php echo wp_lostpassword_url(); ?>">Forgot your password?</a>
    <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
  </form>
  <div id="form-modal" v-if="modal!== false" :class="modal.status">
    {{modal.text}}
  </div>
</div>
</script>




</body>


</html>
