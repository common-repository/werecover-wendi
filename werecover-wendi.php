<?php
/**
 * Plugin Name: WeRecover Wendi
 * Plugin URI: http://werecover.com
 * Description: WeRecover Wendi automated messaging UI integration with wordpress sites.
 * Version: 1.0.4
 * License:     GPL2

 * WeRecover Wendi is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.

 * WeRecover Wendi is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

add_action('wp_footer', 'wr_inquiry_widget_html');
function wr_inquiry_widget_html() {
  $auth_token = get_option('wr_inquiry_widget_auth_token');
  if ($auth_token) {
    wp_enqueue_script(
      'werecover_wendi_js',
      'https://wendi.werecover.com/js/app.js'
    );
    wp_enqueue_style(
      'werecover_wendi_css',
      'https://wendi.werecover.com/css/app.css'
    );
    ?>
    <inquiry-widget auth-token="<?php echo $auth_token ?>"></inquiry-widget>
    <?php
  }
}

function wr_inquiry_widget_settings_init() {
  register_setting(
    'general',
    'wr_inquiry_widget_auth_token',
    array('type' => 'string')
  );

  add_settings_section(
    'wr_inquiry_widget_config',
    'WeRecover Provider Configuration',
    'wr_inquiry_widget_config_cb',
    'general'
  );

  add_settings_field(
    'wr_inquiry_widget_auth_token_field',
    'Auth Token',
    'wr_inquiry_widget_auth_token_field_cb',
    'general',
    'wr_inquiry_widget_config'
  );
}

add_action('admin_init', 'wr_inquiry_widget_settings_init');

function wr_inquiry_widget_config_cb() {
  echo '<p>WeRecover Provider Configuration</p>';
}

function wr_inquiry_widget_auth_token_field_cb() {
  $setting = get_option('wr_inquiry_widget_auth_token');
  ?>
  <input type="text" name="wr_inquiry_widget_auth_token" value="<?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?>">
  <?php
}
?>
