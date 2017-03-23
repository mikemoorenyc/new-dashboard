<?php
add_filter('admin_init', 'google_api_path');

function google_api_path() {
  register_setting('general', 'google_api_path', 'esc_attr');
   add_settings_field('google_api_path', '<label for="google_api_path">'.__('Google API Path' , 'google_api_path' ).'</label>' , "google_api_path_editor", 'general');

}
function google_api_path_editor()
{
    $value = get_option( 'google_api_path', '' );

    echo '<input class="regular-text" type="text" id="google_api_path" name="google_api_path" value="'.$value.'" />';
}


 ?>
