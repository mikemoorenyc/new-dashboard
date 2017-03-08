<?php

$icons = array(180,120,167,152);
foreach($icons as $i) {
  add_image_size( 'icon_'.$i, $i, $i, true );
}

$launch = array(
  array(1080,1920),
  array(750,1334),
  array(640,1136),
  array(2048,2732),
  array(1536,2048)
);
foreach($launch as $l) {
  add_image_size( 'launch_'.$l[0], $l[0], $l[1], true );
}
add_filter('admin_init', 'ios_images');

function ios_images() {
  register_setting('general', 'ios_icon', 'esc_attr');
   add_settings_field('ios_icon', '<label for="ios_icon">'.__('iOS Icon ID' , 'ios_icon' ).'</label>' , "ios_icon_editor", 'general');
   register_setting('general', 'launch_screen', 'esc_attr');
    add_settings_field('launch_screen', '<label for="launch_screen">'.__('Launch Screen ID' , 'launch_screen' ).'</label>' , "launch_screen_editor", 'general');
}
function ios_icon_editor()
{
    $value = get_option( 'ios_icon', '' );
    echo '<input type="text" id="ios_icon" name="ios_icon" value="' . $value . '" class="regular-text"/ >';
}
function launch_screen_editor()
{
    $value = get_option( 'launch_screen', '' );
    echo '<input type="text" id="launch_screen" name="launch_screen" value="' . $value . '" class="regular-text"/ >';
}

 ?>
