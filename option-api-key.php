<?php
add_filter('admin_init', 'api_keys_option');

function api_keys_option() {
  register_setting('general', 'api_keys', 'esc_attr');
  register_setting('general', 'stock_symbols', 'esc_attr');
  register_setting('general', 'stock_api_key', 'esc_attr');
   add_settings_field('api_keys', '<label for="api_keys">'.__('API Keys' , 'api_keys' ).'</label>' , "api_keys_editor", 'general');
  add_settings_field('stock_symbols', '<label for="stock_symbols">'.__('Stock Symbols' , 'stock_symbols' ).'</label>' , "stock_symbols_input", 'general');
  add_settings_field('stock_api_key', '<label for="stock_api_key">'.__('Stock API Key' , 'stock_api_key' ).'</label>' , "stock_api_key_input", 'general');

}
function api_keys_editor()
{
    $value = get_option( 'api_keys', '' );
    echo '<textarea id="api_keys" name="api_keys" rows="10" class="large-text code">'. $value.'</textarea>';
}
function stock_symbols_input() {
 $value = get_option('stock_symbols','');
 echo '<input type="text" id="stock_symbols" name="stock_symbols" value="'.$value'" />';
}
function stock_api_key_input() {
 $value = get_option('stock_api_key','');
 echo '<input type="text" id="stock_api_key" name="stock_api_key" value="'.$value'" />
}


 ?>
