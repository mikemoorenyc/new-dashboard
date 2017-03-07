<?php
/**
 * Template Name: TODO LIST
 */
?>


<?php
$userInfo =json_encode(false);
$listItems = json_encode(array());
$lastModified = json_encode(false);

if ( is_user_logged_in() ) {
   $current_user = wp_get_current_user();

  $userInfo = json_encode(returnUser($current_user->ID));
  $listData = getListData(get_the_ID());
  $listItems = json_encode($listData['listItems'],true);
  $lastModified = json_encode($listData['lastModified'],true);
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
  lastModified: <?php echo $lastModified;?>,
  pageid: <?php echo get_the_ID();?>,
  ajaxURL : "<?php echo admin_url( 'admin-ajax.php' );?>",
  currentlyEditing: false,
  saving: false
}


</script>

</head>

<body>
<a target="_blank" href="<?php echo wp_logout_url( ); ?> " style="display:none;">Logout</a>
<div id="entry"></div>
<script src="<?php echo get_bloginfo('template_url');?>/plugin-debounce.js"></script>
<script src="<?php echo get_bloginfo('template_url');?>/plugin-hammer.js"></script>
<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://unpkg.com/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/sortable/1.4.2/Sortable.min.js"></script>
<script src="https://cdn.rawgit.com/David-Desmaisons/Vue.Draggable/master/dist/vuedraggable.min.js"></script>

<script src="<?php echo get_bloginfo('template_url');?>/todo/main.js?v=<?php echo time();?>"></script>

<script type="text/x-template" id="login-template">
<div>

  <form id="login-form" action="<?php echo admin_url( 'admin-ajax.php' );?>" method="post" >
    <input type="text" v-model="email" required placeholder="Email Address" />
    <input v-model="password" type="password" placeholder="Password" />
    <button @click.prevent="submit">Submit</button>
    <a target="_blank" href="<?php echo wp_lostpassword_url(); ?>">Forgot your password?</a>
    <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
  </form>
  <transition>
  <div id="form-modal" v-if="modal!== false" :class="modal.status">
    <div class="loading" v-if="modal.status=='loading'">
      loading..
    </div>

    <div class="error-msg" v-if="modal.status == 'error'" >
      <div class="text">Couldn't log you in</div>
      <button @click.prevent="reset">Try Again</button>

    </div>
    <div class="success-msg" v-if="modal.status == 'success'">
      <div class="msg" v-html="modal.text"></div>
    </div>
  </div>
  </transition>
</div>
</script>

<script type="text/x-template" id="app-header-template">
    <?php include 'template-app-header.php';?>
</script>
<script type="x-template" id="main-list-template">
  <?php include 'template-thelist.php';?>
</script>
<script type="x-template" id="template-list-item">
  <?php include 'template-list-item.php';?>
</script>

<div id="data-return"></div>
</body>


</html>
