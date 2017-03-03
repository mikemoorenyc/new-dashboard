<?php
include 'author-color.php';
include 'getlistdata.php';
include 'updateValues.php';

function ajax_login_init() {
  add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}


function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false,
                                'message'=>__('Wrong username or password.')));
    } else {
      $current_user = wp_get_current_user();
      $userInfo = returnUser($user_signon->ID);
        echo json_encode(array('loggedin'=>true,
                                'userInfo'=> $userInfo,
                                'listData' => getListData($_POST['pageid'])
                          ));
    }

    die();
}

 ?>
